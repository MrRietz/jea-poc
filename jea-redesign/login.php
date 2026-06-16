<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'login.php',
    'Login',
    'Login',
    'Logga in som medlem eller Jea',
    'Välj rätt inloggning för att komma till dina videos, bokningar, betalningar och träningsanteckningar.'
);
?>
<section class="panel two-column">
    <div class="panel-card">
        <p class="eyebrow">Medlemsinloggning</p>
        <form class="login-form">
            <label>
                E-post eller användarnamn
                <input type="text" value="hedvig@example.com">
            </label>
            <label>
                Lösenord
                <input type="password" value="hedvig123">
            </label>
            <div class="spotlight-actions">
                <button class="button button-primary" type="button">Logga in som medlem</button>
                <button class="button button-secondary" type="button">Logga in som Jea</button>
            </div>
        </form>
    </div>
    <div class="panel-card">
        <p class="eyebrow">Efter inloggning</p>
        <ul class="check-list">
            <li>Medlem ser egna hundar, videos, feedback, bokningar och saldo.</li>
            <li>Jea ser videokö, betalningar, inlägg och träningsinnehåll.</li>
            <li>Allt är samlat i samma meny men med olika rättigheter.</li>
        </ul>
    </div>
</section>
<?php render_footer($exercises); ?>
