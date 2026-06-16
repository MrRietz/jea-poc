<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'ovningar.php',
    'Grunder',
    'Grunder',
    'Grundövningar för fokus, vardag och samarbete',
    'Här hittar du momenten som bygger basen för fortsatt träning. Expandera en övning för att läsa hela beskrivningen.'
);
?>
<section class="panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">GRUNDER</p>
            <h2>Moment med status, videokoppling och hundfokus</h2>
        </div>
        <label class="filter-field">
            <span>Sök i grunder</span>
            <input class="filter-input exercise-search-input" type="search" placeholder="Sök övning, kategori eller beskrivning" data-exercise-search="grunder">
        </label>
    </div>
    <p class="filter-summary" data-exercise-summary="grunder">Visar alla grundövningar.</p>
    <p class="empty-state" data-exercise-empty="grunder" hidden>Ingen grundövning matchar sökningen just nu.</p>
    <div class="stack-list" data-exercise-results="grunder">
        <?php foreach ($grunderGroups as $group): ?>
            <article class="matrix-card" data-exercise-group="grunder">
                <div class="matrix-header">
                    <div>
                        <p class="level-pill"><?php echo h($group['title']); ?></p>
                        <h3><?php echo h($group['description']); ?></h3>
                    </div>
                    <a class="inline-link" href="./videos.php">Visa kopplade videos</a>
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
                        <div class="matrix-row" data-exercise-row="grunder" data-search="<?php echo h($exerciseSearch); ?>">
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

<section class="panel two-column">
    <?php foreach ($dogs as $dog): ?>
        <article class="panel-card">
            <p class="eyebrow"><?php echo h($dog['name']); ?></p>
            <h2><?php echo h($dog['focus']); ?></h2>
            <p class="muted-copy"><?php echo h($dog['progress']); ?></p>
            <p><?php echo h($dog['coach_note']); ?></p>
        </article>
    <?php endforeach; ?>
</section>
<?php render_footer($exercises); ?>
