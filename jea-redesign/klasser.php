<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'klasser.php',
    'Klasser',
    'Klasser',
    'Bokningar, deltagare och nästa träningstillfällen',
    'Se kommande pass, vilka som är bokade och vad du behöver göra inför nästa träning.'
);
?>
<section class="class-grid">
    <?php foreach ($events as $event): ?>
        <article class="panel-card class-card">
            <div class="class-card-top">
                <div>
                    <p class="eyebrow"><?php echo h($event['status']); ?></p>
                    <h2><?php echo h($event['date']); ?> kl <?php echo h($event['time']); ?></h2>
                </div>
                <span class="status-tag"><?php echo h($event['place']); ?></span>
            </div>
            <p class="muted-copy"><?php echo h($event['note']); ?></p>
            <div class="attendee-row">
                <?php foreach ($event['attendees'] as $attendee): ?>
                    <span class="attendee-chip"><?php echo h($attendee); ?></span>
                <?php endforeach; ?>
            </div>
            <div class="spotlight-actions">
                <button class="button button-primary" type="button"><?php echo h($event['request_state']); ?></button>
                <button class="button button-secondary" type="button">Visa detaljer</button>
            </div>
        </article>
    <?php endforeach; ?>
</section>
<?php render_footer($exercises); ?>
