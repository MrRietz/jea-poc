<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'index.php',
    'Start',
    'Team Jea',
    'Allt du behöver för träning, videos och uppföljning på ett ställe',
    'Startsidan samlar aktuellt, nästa klass, videos, hundstatus, betalningar och genvägar till grunder, fortsättning och teori.'
);
?>
<section class="dashboard-shell">
    <div class="home-grid">
        <article class="panel-card spotlight-card">
            <p class="eyebrow">Snabbt just nu</p>
            <h2>Hej <?php echo h($member['name']); ?></h2>
            <p class="spotlight-text">Du har <?php echo (int) $member['unreadFeedback']; ?> ny video med feedback, nästa träning är <?php echo h($member['nextClass']); ?> och nuvarande saldo är <?php echo (int) $member['balance']; ?> kr.</p>
            <div class="spotlight-actions">
                <a class="button button-primary" href="./videos.php">Öppna videos</a>
                <a class="button button-secondary" href="./klasser.php">Se bokningar</a>
            </div>
        </article>

        <article class="panel-card member-card">
            <p class="eyebrow">Min hund</p>
            <h2><?php echo h($member['dog']); ?></h2>
            <p class="muted-copy"><?php echo h($member['dogNote']); ?></p>
            <div class="stats-grid">
                <article>
                    <span class="stat-label">Oläst feedback</span>
                    <strong><?php echo (int) $member['unreadFeedback']; ?> video</strong>
                </article>
                <article>
                    <span class="stat-label">Nästa pass</span>
                    <strong>22 juni</strong>
                </article>
                <article>
                    <span class="stat-label">Saldo</span>
                    <strong><?php echo (int) $member['balance']; ?> kr</strong>
                </article>
                <article>
                    <span class="stat-label">Fokus nu</span>
                    <strong>Footwork</strong>
                </article>
            </div>
        </article>
    </div>

    <section class="panel feature-panel">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Utvald video</p>
                <h2>Senaste videon med feedback</h2>
            </div>
            <a class="button button-secondary" href="./videos.php">Se hela videobiblioteket</a>
        </div>
        <div class="featured-video-layout">
            <div class="video-stage">
                <video controls preload="metadata" playsinline>
                    <source src="<?php echo h($featuredVideo['video_url']); ?>" type="video/mp4">
                </video>
            </div>
            <div class="video-detail-card">
                <p class="status-tag"><?php echo h($featuredVideo['status']); ?></p>
                <h3><?php echo h($featuredVideo['title']); ?></h3>
                <p class="lead compact"><?php echo h($featuredVideo['coach_note']); ?></p>
                <ul class="check-list">
                    <?php foreach ($featuredVideo['summary'] as $point): ?>
                        <li><?php echo h($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <div class="home-grid home-grid-secondary">
        <section class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Aktuellt från Jea</p>
                    <h2>Senaste inlägg och meddelanden</h2>
                </div>
                <a class="button button-secondary" href="./aktuellt.php">Visa alla inlägg</a>
            </div>
            <div class="news-stack compact-stack">
                <?php foreach (array_slice($announcements, 0, 2) as $post): ?>
                    <article class="post-card post-card-inline">
                        <div class="post-meta">
                            <span class="status-tag"><?php echo h($post['author']); ?></span>
                            <span><?php echo h($post['time']); ?></span>
                        </div>
                        <h3><?php echo h($post['title']); ?></h3>
                        <p><?php echo h($post['body']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Träning</p>
                    <h2>Välj område att jobba vidare med</h2>
                </div>
            </div>
            <div class="track-grid">
                <a class="track-card" href="./ovningar.php">
                    <span class="level-pill">GRUNDER</span>
                    <strong>Basmoment och tydliga statusar</strong>
                    <small>Kontakt, vardagshyfs och verktyg</small>
                </a>
                <a class="track-card" href="./forts.php">
                    <span class="level-pill">FORTS</span>
                    <strong>Störning, kedjor och nästa nivå</strong>
                    <small>Footwork, lydnad och rally</small>
                </a>
                <a class="track-card" href="./teori.php">
                    <span class="level-pill">TEORI</span>
                    <strong>Förklaringar och hundanteckningar</strong>
                    <small>För dig som vill förstå varför</small>
                </a>
            </div>
        </section>
    </div>

    <div class="home-grid home-grid-secondary">
        <section class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Nästa pass</p>
                    <h2>Klasser och bokningar</h2>
                </div>
                <a class="button button-secondary" href="./klasser.php">Öppna kalender</a>
            </div>
            <div class="stack-list">
                <?php foreach ($events as $event): ?>
                    <article class="stack-item booking-item">
                        <strong><?php echo h($event['date']); ?> kl <?php echo h($event['time']); ?></strong>
                        <span><?php echo h($event['place']); ?></span>
                        <small><?php echo h($event['status']); ?></small>
                        <p><?php echo h($event['note']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Avgift</p>
                    <h2>Saldo och senaste poster</h2>
                </div>
                <a class="button button-secondary" href="./betalningar.php">Se hela avgiftslistan</a>
            </div>
            <div class="payment-summary payment-summary-card">
                <strong><?php echo (int) $member['balance']; ?> kr</strong>
                <span>Att betala just nu</span>
            </div>
            <div class="stack-list">
                <?php foreach (array_slice($payments, 0, 3) as $payment): ?>
                    <article class="stack-item row-item">
                        <strong><?php echo h($payment['label']); ?></strong>
                        <span><?php echo h($payment['date']); ?></span>
                        <small><?php echo (int) $payment['amount']; ?> kr</small>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</section>
<?php render_footer($exercises); ?>
