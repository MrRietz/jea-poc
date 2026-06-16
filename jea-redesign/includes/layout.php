<?php

function jea_fix_output_text(string $value): string
{
    return strtr($value, [
        'ÃƒÆ’Â¥' => 'å',
        'ÃƒÆ’Â¤' => 'ä',
        'ÃƒÆ’Â¶' => 'ö',
        'ÃƒÆ’â€¦' => 'Å',
        'ÃƒÆ’â€ž' => 'Ä',
        'ÃƒÆ’â€“' => 'Ö',
        'Ãƒâ€šÃ‚Â¥' => 'å',
        'Ãƒâ€šÃ‚Â¤' => 'ä',
        'Ãƒâ€šÃ‚Â¶' => 'ö',
        'Ãƒâ€šÃ¢â‚¬Â¦' => 'Å',
        'Ãƒâ€šÃ¢â‚¬Å¾' => 'Ä',
        'Ãƒâ€šÃ¢â‚¬â€œ' => 'Ö',
        'Ã¥' => 'å',
        'Ã¤' => 'ä',
        'Ã¶' => 'ö',
        'Ã…' => 'Å',
        'Ã„' => 'Ä',
        'Ã–' => 'Ö',
        'â€¢' => '•',
        'â€“' => '–',
        'â€”' => '—',
        'â€œ' => '“',
        'â€' => '”',
        'â€™' => '’',
        'â€¦' => '…',
        'Â ' => ' ',
        'Â' => '',
    ]);
}

function h(string $value): string
{
    $value = function_exists('jea_fix_mojibake_text') ? jea_fix_mojibake_text($value) : $value;
    return htmlspecialchars(jea_fix_output_text($value), ENT_QUOTES, 'UTF-8');
}

function render_header(string $activePage, string $pageTitle, string $eyebrow, string $heading, string $lead): void
{
    if (ob_get_level() === 0) {
        ob_start(static function (string $buffer): string {
            return jea_fix_output_text($buffer);
        });
    }

    $navItems = [
        'index.php' => 'Start',
        'aktuellt.php' => 'Aktuellt',
        'videos.php' => 'Videos',
        'ovningar.php' => 'Grunder',
        'forts.php' => 'Forts',
        'teori.php' => 'Teori',
        'klasser.php' => 'Klasser',
        'betalningar.php' => 'Avgift',
        'login.php' => 'Login',
    ];
    ?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($pageTitle); ?> | Team Jea</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Manrope:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-ui-dist/jquery-ui.min.css">
    <link rel="stylesheet" href="./styles.css?v=4">
</head>
<body data-page="<?php echo h($activePage); ?>">
    <header class="site-header">
        <div class="header-top">
            <div class="brand-wrap">
                <a class="brand brand-standalone" href="./index.php">
                    <img class="brand-logo" src="./assets/team-jea-logo-transparent.png?v=3" alt="Team Jea">
                </a>
                <p class="brand-subtitle">Hundträning med videos, feedback, bokningar, avgifter och träningsöversikt i samma enkla PHP-flöde.</p>
            </div>
            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span></span>
                <span></span>
                <span></span>
                <span class="sr-only">Öppna meny</span>
            </button>
        </div>

        <div id="site-nav" class="top-nav-panel">
            <nav class="top-nav">
                <?php foreach ($navItems as $file => $label): ?>
                    <a class="nav-link<?php echo $file === $activePage ? ' is-active' : ''; ?>" href="./<?php echo h($file); ?>"><?php echo h($label); ?></a>
                <?php endforeach; ?>
            </nav>
            <div class="top-nav-actions">
                <button id="open-upload" class="button button-primary" type="button">Skicka video</button>
            </div>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <p class="eyebrow"><?php echo h($eyebrow); ?></p>
            <h1><?php echo h($heading); ?></h1>
            <p class="lead"><?php echo h($lead); ?></p>
        </section>
    <?php
}

function render_footer(array $exercises): void
{
    ?>
        <div id="upload-dialog" title="Skicka video" class="upload-dialog" style="display:none;">
            <form class="upload-form">
                <label>
                    Hund
                    <select>
                        <option>Wilma</option>
                        <option>Lexie</option>
                        <option>Peach</option>
                    </select>
                </label>
                <label>
                    Moment
                    <select>
                        <?php foreach ($exercises as $exercise): ?>
                            <option><?php echo h($exercise['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>
                    Kort beskrivning
                    <textarea rows="4" placeholder="Vad vill du ha feedback på?"></textarea>
                </label>
                <div class="consent-inline-box">
                    <p><strong>Samtycke vid uppladdning</strong></p>
                    <p>Det här samtycket sparas på videon, så Jea direkt ser om materialet bara får visas på hemsidan eller också får användas i bok och QR-material.</p>
                    <label class="inline-check"><input type="checkbox" checked> Jag godkänner lagring och visning på hemsidan</label>
                    <label class="inline-check"><input type="checkbox"> Jag godkänner även användning i bokmaterial och QR-länkar</label>
                </div>
                <button class="button button-primary" type="button">Ladda upp video</button>
            </form>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-dist/jquery-ui.min.js"></script>
    <script src="./app.js?v=3"></script>
</body>
</html>
    <?php
}
