<?php

function jea_fix_mojibake_text(string $value): string
{
    $value = str_replace("\xC2\xA0", ' ', $value);

    $replacements = [
        'ÃƒÂ¥' => 'å',
        'ÃƒÂ¤' => 'ä',
        'ÃƒÂ¶' => 'ö',
        'Ãƒâ€¦' => 'Å',
        'Ãƒâ€ž' => 'Ä',
        'Ãƒâ€“' => 'Ö',
        'ÃƒÂ©' => 'é',
        'ÃƒÂ¼' => 'ü',
        'ÃƒÂ±' => 'ñ',
        'Ã¢â‚¬Â¢' => '•',
        'Ã¢â‚¬â€œ' => '–',
        'Ã¢â‚¬â€' => '—',
        'Ã¢â‚¬Å“' => '“',
        'Ã¢â‚¬' => '”',
        'Ã¢â‚¬â„¢' => '’',
        'Ã¢â‚¬Â¦' => '…',
        'Ã‚ ' => ' ',
        'Ã‚' => '',
    ];

    $fixed = strtr($value, $replacements);

    for ($i = 0; $i < 3; $i++) {
        if (!preg_match('/[ÃÂâ]/u', $fixed)) {
            break;
        }

        $candidate = @iconv('Windows-1252', 'UTF-8//IGNORE', $fixed);
        if (!is_string($candidate) || $candidate === '' || $candidate === $fixed) {
            break;
        }

        $fixed = $candidate;
    }

    return trim(strtr($fixed, $replacements));
}

function jea_normalize_array(array $value): array
{
    foreach ($value as $key => $item) {
        if (is_string($item)) {
            $value[$key] = jea_fix_mojibake_text($item);
        } elseif (is_array($item)) {
            $value[$key] = jea_normalize_array($item);
        }
    }

    return $value;
}

function jea_live_video_cache_path(): string
{
    $dir = dirname(__DIR__) . '/cache';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }

    return $dir . '/videos-live.json';
}

function jea_http_post(string $url, array $data): ?string
{
    return null;
}

function jea_http_get(string $url): ?string
{
    return null;
}

function jea_clean_text(string $value): string
{
    $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = strip_tags($value);
    $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

    return jea_fix_mojibake_text(trim($value));
}

function jea_decode_cached_json(string $path): array
{
    $raw = (string) file_get_contents($path);
    $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw) ?? $raw;
    $decoded = json_decode($raw, true);

    return is_array($decoded) ? jea_normalize_array($decoded) : [];
}

function jea_extract_video_rows(string $html): array
{
    $rows = [];

    if (!preg_match_all('/<div style="display:flex;color:black;" id="vidid(\d+)">(.*?)<\/div>\s*\s*/si', $html, $matches, PREG_SET_ORDER)) {
        return $rows;
    }

    foreach ($matches as $match) {
        $id = (int) $match[1];
        $rowHtml = $match[2];

        preg_match('/<button class="fs-xs wss"[^>]*>\s*([^<]+?)\s*<\/button>/si', $rowHtml, $dateMatch);
        preg_match('/vidmom' . $id . '"[^>]*>\s*([^<]+?)\s*<\/button>/si', $rowHtml, $momentMatch);
        preg_match('/<button class="fs-s wss besk"[^>]*>\s*([^<]*?)\s*<\/button>/si', $rowHtml, $titleMatch);

        $rows[] = [
            'id' => $id,
            'raw_date' => isset($dateMatch[1]) ? trim($dateMatch[1]) : '',
            'moment_code' => isset($momentMatch[1]) ? trim($momentMatch[1]) : '',
            'title' => isset($titleMatch[1]) ? jea_clean_text($titleMatch[1]) : '',
        ];
    }

    return $rows;
}

function jea_extract_video_detail(int $id): array
{
    $detailUrl = 'https://www.jea.se/videos/vidshw.php?vidid=' . $id . '&Xsgn=Eliza';
    $html = jea_http_get($detailUrl);

    if ($html === null) {
        return [];
    }

    preg_match('/id="mokod"[^>]*value="([^"]*)"/si', $html, $mokodMatch);
    preg_match('/id="nytit"[^>]*value="([^"]*)"/si', $html, $titleMatch);
    preg_match('/<div id="frediv"[^>]*>(.*?)<\/div>/si', $html, $feedbackMatch);
    preg_match('/<source[^>]*src=\'\.\.\/videos\/uploads\/([^\']+)\'/si', $html, $srcMatch);

    $title = isset($titleMatch[1]) ? jea_clean_text($titleMatch[1]) : '';
    $feedbackHtml = $feedbackMatch[1] ?? '';
    $feedback = jea_clean_text($feedbackHtml);
    $momentCode = isset($mokodMatch[1]) ? trim($mokodMatch[1]) : '';
    $videoFile = $srcMatch[1] ?? '';
    $videoUrl = $videoFile !== '' ? 'https://www.jea.se/videos/uploads/' . rawurlencode($videoFile) : '';

    return [
        'title' => $title,
        'coach_note' => $feedback,
        'moment_code' => $momentCode,
        'video_url' => $videoUrl,
        'live_endpoint' => 'videos/vidshw.php?vidid=' . $id . '&Xsgn=Eliza',
    ];
}

function jea_format_video_date(string $rawDate): string
{
    $rawDate = trim($rawDate);
    if ($rawDate === '' || strlen($rawDate) < 10) {
        return $rawDate;
    }

    $yy = substr($rawDate, 0, 2);
    $mm = substr($rawDate, 2, 2);
    $dd = substr($rawDate, 4, 2);

    return '20' . $yy . '-' . $mm . '-' . $dd;
}

function jea_guess_status(string $feedback): string
{
    $feedback = jea_fix_mojibake_text($feedback);

    if ($feedback === '') {
        return 'Ny';
    }

    $len = function_exists('iconv_strlen') ? iconv_strlen($feedback, 'UTF-8') : strlen($feedback);
    if ($len > 180) {
        return 'Behöver uppföljning';
    }

    return 'Feedback klar';
}

function jea_guess_dog_and_member(string $title): array
{
    $clean = jea_fix_mojibake_text(trim($title));
    $parts = preg_split('/\s+i\s+/u', $clean, 2);
    $left = $parts[0] ?? $clean;
    $exercise = $parts[1] ?? '';

    $tokens = preg_split('/\s+/u', trim($left)) ?: [];
    $member = $tokens[0] ?? 'Medlem';
    $dog = $tokens[1] ?? 'Hund';

    return [
        'member' => $member,
        'dog' => ucfirst($dog),
        'exercise' => $exercise !== '' ? ucfirst(trim($exercise)) : 'Träning',
    ];
}

function jea_fetch_live_videos(): array
{
    $cachePath = jea_live_video_cache_path();
    if (is_file($cachePath)) {
        $cached = jea_decode_cached_json($cachePath);
        if ($cached !== []) {
            return $cached;
        }
    }

    return [];
}
