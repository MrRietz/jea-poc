<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'forts.php',
    'Forts',
    'Forts',
    'Nästa nivå för störning, precision och tävlingsmoment',
    'Här ligger fortsättningsmomenten som bygger vidare på grunderna. Expandera en övning för att läsa hela momentbeskrivningen.'
);
?>
<section class="panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">FORTS</p>
            <h2>Störning, kedjor och tävlingsnära moment</h2>
        </div>
        <label class="filter-field">
            <span>Sök i forts</span>
            <input class="filter-input exercise-search-input" type="search" placeholder="Sök moment, kategori eller beskrivning" data-exercise-search="forts">
        </label>
    </div>
    <p class="filter-summary" data-exercise-summary="forts">Visar alla fortsättningsmoment.</p>
    <p class="empty-state" data-exercise-empty="forts" hidden>Inget forts-moment matchar sökningen just nu.</p>
    <div class="stack-list" data-exercise-results="forts">
        <?php foreach ($fortsGroups as $group): ?>
            <article class="matrix-card" data-exercise-group="forts">
                <div class="matrix-header">
                    <div>
                        <p class="level-pill"><?php echo h($group['title']); ?></p>
                        <h3><?php echo h($group['description']); ?></h3>
                    </div>
                    <a class="inline-link" href="./videos.php">Visa videos för nivån</a>
                </div>
                <div class="matrix-list">
                    <?php foreach ($group['items'] as $item): ?>
                        <?php
                        $exerciseSearch = implode(' ', [
                            (string) $group['title'],
                            (string) ($group['description'] ?? ''),
                            (string) ($item['name'] ?? ''),
                            (string) ($item['description'] ?? ''),
                            strip_tags((string) ($item['detail_html'] ?? '')),
                        ]);
                        ?>
                        <div class="matrix-row" data-exercise-row="forts" data-search="<?php echo h($exerciseSearch); ?>">
                            <strong><?php echo h($item['name']); ?></strong>
                            <p><?php echo h($item['description']); ?></p>
                            <span class="status-pill status-<?php echo strtolower(h($item['status'])); ?>"><?php echo h($item['status']); ?></span>
                            <small><?php echo $item['video_linked'] ? 'Har video' : 'Ingen video än'; ?></small>
                            <details class="exercise-expander">
                                <summary>Visa övningsinfo</summary>
                                <div class="exercise-detail-body">
                                    <?php if (!empty($item['detail_html'])): ?>
                                        <?php echo $item['detail_html']; ?>
                                    <?php else: ?>
                                        <p><?php echo h($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php render_footer($exercises); ?>
