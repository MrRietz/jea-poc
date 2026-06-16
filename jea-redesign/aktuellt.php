<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'aktuellt.php',
    'Aktuellt',
    'Aktuellt',
    'Meddelanden, nyheter och snabb kontakt',
    'Här samlas Jeas inlägg, viktiga instruktioner och meddelanden mellan medlem och tränare.'
);
?>
<section class="panel two-column">
    <article class="panel-card">
        <p class="eyebrow">Nytt meddelande</p>
        <form class="login-form">
            <label>
                Till
                <select>
                    <option>Jea</option>
                    <option>Alla medlemmar</option>
                    <option>Min träningsgrupp</option>
                </select>
            </label>
            <label>
                Skriv meddelande
                <textarea rows="5" placeholder="Skriv ditt meddelande här"></textarea>
            </label>
            <div class="spotlight-actions">
                <button class="button button-primary" type="button">Skicka meddelande</button>
                <button class="button button-secondary" type="button">Spara utkast</button>
            </div>
        </form>
    </article>
    <article class="panel-card">
        <p class="eyebrow">Det här kan du göra</p>
        <ul class="check-list">
            <li>Jea kan skriva nyheter och instruktioner till alla medlemmar.</li>
            <li>Medlemmar kan ställa frågor eller skicka korta uppdateringar.</li>
            <li>Viktiga meddelanden ska gå att hitta igen senare.</li>
        </ul>
    </article>
</section>

<section class="news-stack">
    <?php foreach ($announcements as $post): ?>
        <article class="panel post-card">
            <div class="post-meta">
                <span class="status-tag"><?php echo h($post['author']); ?></span>
                <span><?php echo h($post['time']); ?></span>
                <span>Till: <?php echo h($post['audience']); ?></span>
            </div>
            <h2><?php echo h($post['title']); ?></h2>
            <p><?php echo h($post['body']); ?></p>
        </article>
    <?php endforeach; ?>
</section>
<?php render_footer($exercises); ?>
