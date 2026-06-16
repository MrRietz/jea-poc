<?php
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/layout.php';

render_header(
    'betalningar.php',
    'Avgift',
    'Avgift',
    'Saldo, poster och inbetalningar samlade på en sida',
    'Här ser du vad som är betalt, vad som återstår och vilka poster som ligger bakom saldot.'
);
?>
<section class="panel two-column">
    <div class="panel-card">
        <p class="eyebrow">Nuvarande saldo</p>
        <div class="payment-summary">
            <strong><?php echo (int) $member['balance']; ?> kr</strong>
            <span>Att betala just nu</span>
        </div>
        <div class="payment-form">
            <label>
                Registrera inbetalning
                <input type="text" value="250">
            </label>
            <button class="button button-primary" type="button">Nolla efter betalning</button>
        </div>
        <p class="muted-copy">När en betalning kommit in kan Jea registrera den och uppdatera saldot direkt.</p>
    </div>

    <div class="panel-card">
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Post</th>
                    <th>Belopp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo h($payment['date']); ?></td>
                        <td><?php echo h($payment['label']); ?></td>
                        <td><?php echo (int) $payment['amount']; ?> kr</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php render_footer($exercises); ?>
