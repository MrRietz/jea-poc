<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'teori.php',
    'Teori',
    'Teori',
    'Förstå träningen bättre mellan passen',
    'Här ligger teoripass och anteckningar som hjälper dig förstå varför övningarna ser ut som de gör.'
);
?>
<section class="panel two-column">
    <article class="panel-card">
        <p class="eyebrow">Teoripass</p>
        <div class="stack-list">
            <?php foreach ($theory as $item): ?>
                <article class="stack-item">
                    <strong><?php echo h($item['title']); ?></strong>
                    <p><?php echo h($item['summary']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="panel-card">
        <p class="eyebrow">Hundanteckning</p>
        <h2><?php echo h($member['displayName']); ?></h2>
        <p class="muted-copy">Samla sådant du vill komma ihåg till nästa pass.</p>
        <div class="note-box">
            <p><?php echo h($member['dogNote']); ?></p>
        </div>
        <button class="button button-primary" type="button">Spara träningsanteckning</button>
    </article>
</section>
<?php render_footer($exercises); ?>
