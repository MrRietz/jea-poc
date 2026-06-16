<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

$videoYears = [];
foreach ($videos as $video) {
    $date = (string) ($video['date'] ?? '');
    if (preg_match('/^\d{4}/', $date) === 1) {
        $videoYears[] = substr($date, 0, 4);
    }
}

$videoYears = array_values(array_unique($videoYears));
rsort($videoYears, SORT_STRING);
$defaultVideoYear = $videoYears[0] ?? 'all';

render_header(
    'videos.php',
    'Videos',
    'Videobibliotek',
    'Alla medlemsvideos samlade med feedback och status',
    'Här hittar du dina videos, ser Jeas återkoppling och kan följa vad som är nytt, klart eller behöver uppföljning.'
);
?>
<section class="panel feature-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Senaste video</p>
            <h2><?php echo h($featuredVideo['title']); ?></h2>
        </div>
        <p class="status-tag"><?php echo h($featuredVideo['status']); ?></p>
    </div>
    <div class="featured-video-layout">
        <div class="video-stage">
            <video controls preload="metadata" playsinline>
                <source src="<?php echo h($featuredVideo['video_url']); ?>" type="video/mp4">
            </video>
        </div>
        <div class="video-detail-card">
            <p><strong>Hund:</strong> <?php echo h($featuredVideo['dog']); ?></p>
            <p><strong>Övning:</strong> <?php echo h($featuredVideo['exercise']); ?></p>
            <p><strong>Momentkod:</strong> <?php echo h($featuredVideo['moment_code']); ?></p>
            <p><strong>Feedback:</strong> <?php echo h($featuredVideo['coach_note']); ?></p>
            <div class="consent-badges">
                <span class="attendee-chip">Hemsida: <?php echo $featuredVideo['consent_site'] ? 'Ja' : 'Nej'; ?></span>
                <span class="attendee-chip">Bok/QR: <?php echo $featuredVideo['consent_book'] ? 'Ja' : 'Nej'; ?></span>
            </div>
            <ul class="check-list">
                <?php foreach ($featuredVideo['summary'] as $point): ?>
                    <li><?php echo h($point); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section class="panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Alla videos</p>
            <h2>Filtrera och hitta rätt direkt</h2>
        </div>
        <label class="filter-field">
            <span>Sök video</span>
            <input id="video-search" class="filter-input" type="search" placeholder="Hund, medlem, moment eller feedback" data-video-search>
        </label>
        <label class="filter-field filter-field-compact">
            <span>År</span>
            <select id="video-year" class="filter-select" data-video-year>
                <option value="all">Alla år</option>
                <?php foreach ($videoYears as $year): ?>
                    <option value="<?php echo h($year); ?>"<?php echo $year === $defaultVideoYear ? ' selected' : ''; ?>><?php echo h($year); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="filters" data-filter-group="video-status">
            <button class="chip chip-active" data-filter="all" type="button">Alla</button>
            <button class="chip" data-filter="Ny" type="button">Nya</button>
            <button class="chip" data-filter="Feedback klar" type="button">Feedback klar</button>
            <button class="chip" data-filter="Behöver uppföljning" type="button">Behöver uppföljning</button>
            <button class="chip" data-filter="Tillgänglig" type="button">Tillgängliga</button>
        </div>
    </div>
    <p class="filter-summary" data-video-summary></p>
    <p class="empty-state" data-video-empty hidden>Inga videos matchar filtret just nu. Prova ett annat år, en annan status eller bredare sökning.</p>
    <div class="video-grid">
        <?php foreach ($videos as $video): ?>
            <?php
            $videoDate = (string) ($video['date'] ?? '');
            $videoYear = preg_match('/^\d{4}/', $videoDate) === 1 ? substr($videoDate, 0, 4) : 'Okant';
            $videoSearch = implode(' ', [
                (string) ($video['title'] ?? ''),
                (string) ($video['dog'] ?? ''),
                (string) ($video['member'] ?? ''),
                (string) ($video['exercise'] ?? ''),
                (string) ($video['moment_code'] ?? ''),
                (string) ($video['date'] ?? ''),
                (string) ($video['status'] ?? ''),
                (string) ($video['coach_note'] ?? ''),
            ]);
            ?>
            <article
                class="video-card"
                data-video-card
                data-status="<?php echo h($video['status']); ?>"
                data-year="<?php echo h($videoYear); ?>"
                data-search="<?php echo h($videoSearch); ?>"
            >
                <div class="video-thumb">
                    <span><?php echo h($video['dog']); ?></span>
                </div>
                <div class="video-meta">
                    <p class="status-tag"><?php echo h($video['status']); ?></p>
                    <h3><?php echo h($video['title']); ?></h3>
                    <p><?php echo h($video['exercise']); ?></p>
                    <small><?php echo h($video['date']); ?> • <?php echo h($video['moment_code']); ?></small>
                    <div class="consent-badges">
                        <span class="attendee-chip">Hemsida: <?php echo $video['consent_site'] ? 'Ja' : 'Nej'; ?></span>
                        <span class="attendee-chip">Bok/QR: <?php echo $video['consent_book'] ? 'Ja' : 'Nej'; ?></span>
                    </div>
                    <div class="feedback-box">
                        <strong>Jeas feedback</strong>
                        <p><?php echo h($video['coach_note']); ?></p>
                    </div>
                    <?php if ($video['video_url'] !== ''): ?>
                        <a class="inline-link" href="<?php echo h($video['video_url']); ?>" target="_blank" rel="noreferrer">Öppna videofilen direkt</a>
                    <?php else: ?>
                        <span class="inline-link">Öppna detalj i Jeas videolista för full information</span>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="panel two-column">
    <article class="panel-card">
        <p class="eyebrow">Jeas kö</p>
        <h2>Videos som behöver åtgärd</h2>
        <div class="stack-list">
            <?php foreach ($videoAdminQueue as $item): ?>
                <article class="stack-item">
                    <strong><?php echo h($item['title']); ?></strong>
                    <span><?php echo h($item['member']); ?> / <?php echo h($item['dog']); ?></span>
                    <small>Video #<?php echo (int) $item['video_id']; ?></small>
                    <p>Samtycke hemsida: <?php echo h($item['consent_site']); ?> • Bok/QR: <?php echo h($item['consent_book']); ?></p>
                    <p><?php echo h($item['action']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="panel-card">
        <p class="eyebrow">Sök och filter</p>
        <h2>Det här behöver gå snabbt att hitta</h2>
        <ul class="check-list">
            <li>Sök på hund, medlem, övning, feedback och momentkod.</li>
            <li>Filtrera på status och år innan hela videobiblioteket blir för långt.</li>
            <li>Se direkt vad som är nytt och vad som väntar på Jea.</li>
        </ul>
    </article>
</section>
<?php render_footer($exercises); ?>
