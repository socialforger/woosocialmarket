<?php
if (!defined('ABSPATH')) exit;

$email = isset($woosm_email) ? $woosm_email : '';
?>
<div class="ct-container woosm-auth-container">
    <div class="ct-card woosm-auth-card">
        <h2 class="ct-title"><?php esc_html_e('Completa la registrazione', 'woosocialmarket'); ?></h2>

        <form method="post" class="woosm-form">
            <?php wp_nonce_field('woosm_registration', 'woosm_registration_nonce'); ?>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Email', 'woosocialmarket'); ?></label>
                <input type="email" name="woosm_email" class="ct-input" value="<?php echo esc_attr($email); ?>" readonly>
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Nome', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_first_name" class="ct-input" required>
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Cognome', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_last_name" class="ct-input" required>
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Data di nascita', 'woosocialmarket'); ?></label>
                <input type="date" name="woosm_birth_date" class="ct-input">
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Luogo di nascita', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_birth_place" class="ct-input">
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Indirizzo e numero civico', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_address" class="ct-input" required>
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('CAP', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_zip" class="ct-input">
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Città', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_city" class="ct-input" required>
            </div>

            <div class="woosm-field">
                <label class="ct-label"><?php esc_html_e('Nazione', 'woosocialmarket'); ?></label>
                <input type="text" name="woosm_country" class="ct-input" value="Italia">
            </div>

            <p class="woosm-info ct-text-muted">
                <?php esc_html_e(
                    'Per poter usare la piattaforma sarai iscritto all\'associazione che la gestisce al momento del primo pagamento (aggiunta del prodotto di iscrizione al carrello).',
                    'woosocialmarket'
                ); ?>
            </p>

            <button type="submit" class="ct-button ct-button-primary">
                <?php esc_html_e('Completa registrazione', 'woosocialmarket'); ?>
            </button>
        </form>
    </div>
</div>
