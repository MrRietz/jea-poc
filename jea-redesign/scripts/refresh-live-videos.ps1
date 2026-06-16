$ErrorActionPreference = "Stop"

$root = Split-Path -Parent $PSScriptRoot
$cacheDir = Join-Path $root "cache"
$cachePath = Join-Path $cacheDir "videos-live.json"

if (-not (Test-Path $cacheDir)) {
    New-Item -ItemType Directory -Path $cacheDir | Out-Null
}

function Clean-Text {
    param([string]$Text)

    if ([string]::IsNullOrWhiteSpace($Text)) {
        return ""
    }

    $decoded = [System.Net.WebUtility]::HtmlDecode($Text)
    $decoded = [regex]::Replace($decoded, "<[^>]+>", " ")
    $decoded = [regex]::Replace($decoded, "\s+", " ")
    return $decoded.Trim()
}

function Format-VideoDate {
    param([string]$RawDate)

    if ($RawDate.Length -lt 6) {
        return $RawDate
    }

    $yy = $RawDate.Substring(0, 2)
    $mm = $RawDate.Substring(2, 2)
    $dd = $RawDate.Substring(4, 2)
    return "20$yy-$mm-$dd"
}

function Guess-Status {
    param([string]$Feedback)

    if ([string]::IsNullOrWhiteSpace($Feedback)) {
        return "Tillgänglig"
    }

    if ($Feedback.Length -gt 180) {
        return "Behöver uppföljning"
    }

    return "Feedback klar"
}

function Guess-Meta {
    param([string]$Title)

    $parts = $Title -split "\si\s", 2
    $left = if ($parts.Count -gt 0) { $parts[0].Trim() } else { $Title.Trim() }
    $exercise = if ($parts.Count -gt 1) { $parts[1].Trim() } else { "Träning" }
    $tokens = $left -split "\s+"

    $member = if ($tokens.Count -gt 0 -and $tokens[0]) { $tokens[0] } else { "Medlem" }
    $dog = if ($tokens.Count -gt 1 -and $tokens[1]) { $tokens[1] } else { "Hund" }

    [PSCustomObject]@{
        member = $member
        dog = (Get-Culture).TextInfo.ToTitleCase($dog.ToLower())
        exercise = if ($exercise) { $exercise } else { "Träning" }
    }
}

$listResponse = Invoke-WebRequest -UseBasicParsing -Uri "https://www.jea.se/videos/vidlst.php" -Method Post -Body @{
    actvid = "0"
    Xsgn   = "Eliza"
}

$rowPattern = '<div style="display:flex;color:black;" id="vidid(?<id>\d+)">(?<content>[\s\S]*?)</div>\s*'
$rowMatches = [regex]::Matches($listResponse.Content, $rowPattern)

$videos = New-Object System.Collections.Generic.List[object]
$detailFetchLimit = 15

for ($i = 0; $i -lt $rowMatches.Count; $i++) {
    $row = $rowMatches[$i]
    $id = [int]$row.Groups["id"].Value
    $content = $row.Groups["content"].Value

    $rawDate = ([regex]::Match($content, '<button class="fs-xs wss"[^>]*>\s*(?<date>[^<]+?)\s*</button>', 'Singleline')).Groups["date"].Value.Trim()
    $momentCode = ([regex]::Match($content, "vidmom$id`"[^>]*>\s*(?<mom>[^<]+?)\s*</button>", 'Singleline')).Groups["mom"].Value.Trim()
    $title = Clean-Text (([regex]::Match($content, '<button class="fs-s wss besk"[^>]*>\s*(?<title>[^<]*?)\s*</button>', 'Singleline')).Groups["title"].Value)

    $detailTitle = $title
    $feedback = ""
    $videoUrl = ""
    $detailMomentCode = $momentCode

    if ($i -lt $detailFetchLimit) {
        try {
            $detailResponse = Invoke-WebRequest -UseBasicParsing -Uri "https://www.jea.se/videos/vidshw.php?vidid=$id&Xsgn=Eliza"
            $detailHtml = $detailResponse.Content

            $detailTitle = Clean-Text (([regex]::Match($detailHtml, 'id="nytit"[^>]*value="(?<title>[^"]*)"', 'Singleline')).Groups["title"].Value)
            $detailMomentCode = ([regex]::Match($detailHtml, 'id="mokod"[^>]*value="(?<mom>[^"]*)"', 'Singleline')).Groups["mom"].Value.Trim()
            $feedbackHtml = ([regex]::Match($detailHtml, '<div id="frediv"[^>]*>(?<feedback>[\s\S]*?)</div>', 'Singleline')).Groups["feedback"].Value
            $feedback = Clean-Text $feedbackHtml
            $videoFile = ([regex]::Match($detailHtml, "<source[^>]*src='../videos/uploads/(?<file>[^']+)'", 'Singleline')).Groups["file"].Value
            if ($videoFile) {
                $videoUrl = "https://www.jea.se/videos/uploads/$([uri]::EscapeDataString($videoFile))"
            }
        } catch {
        }
    }

    if (-not $detailTitle) {
        $detailTitle = if ($title) { $title } else { "Video #$id" }
    }

    $meta = Guess-Meta $detailTitle

    $summaryText = if ($feedback) {
        $feedback.Substring(0, [Math]::Min($feedback.Length, 180))
    } else {
        "Video importerad från live-listan."
    }

    $videos.Add([PSCustomObject]@{
        id = $id
        title = $detailTitle
        dog = $meta.dog
        member = $meta.member
        exercise = $meta.exercise
        moment_code = if ($detailMomentCode) { $detailMomentCode } else { "0" }
        status = Guess-Status $feedback
        date = Format-VideoDate $rawDate
        coach_note = if ($feedback) { $feedback } else { "Öppna videon för att läsa eller uppdatera mer information." }
        consent_site = $true
        consent_book = $false
        live_endpoint = "videos/vidshw.php?vidid=$id&Xsgn=Eliza"
        save_endpoint = "videos/vidshw2.php"
        video_url = $videoUrl
        summary = @($summaryText)
    })
}

$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
[System.IO.File]::WriteAllText($cachePath, ($videos | ConvertTo-Json -Depth 6), $utf8NoBom)

$pythonFixer = Join-Path $PSScriptRoot "fix-json-mojibake.py"
if (Test-Path $pythonFixer) {
    python $pythonFixer | Out-Null
}

Write-Output "Saved $($videos.Count) videos to $cachePath"
