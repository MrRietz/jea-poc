<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'samtycke.php',
    'Samtycke',
    'GDPR och godkännande',
    'Samtycke för videos behöver vara tydligt, valbart och spårbart',
    'Det här förslaget gör det tydligt vad som gäller för inskickade videos på hemsidan och lägger till ett separat godkännande för eventuell användning i bokmaterial eller QR-kodslänkar.'
);
?>
<section class="panel consent-panel">
    <div class="consent-copy">
        <p>
            När du skickar in video till Team Jea bekräftar du att du har rätt att dela materialet och att Team Jea får lagra,
            bearbeta och visa videon på hemsidan som en del av träningen och återkopplingen. Inskickat material kan vara synligt
            för andra medlemmar enligt hur tjänsten är upplagd.
        </p>
        <p>
            Om Team Jea vill använda material i bok, kursmaterial eller QR-kodslänkat innehåll ska det finnas ett separat godkännande
            som medlemmen kan tacka ja eller nej till utan att det påverkar den vanliga träningsytan.
        </p>
        <label><input type="checkbox" checked> Jag godkänner lagring och visning på hemsidan.</label>
        <label><input type="checkbox"> Jag godkänner även användning i bokmaterial och QR-kodslänkat material.</label>
        <label><input type="checkbox"> Jag avstår användning utanför hemsidans träningsyta.</label>
    </div>
</section>
<?php render_footer($exercises); ?>
