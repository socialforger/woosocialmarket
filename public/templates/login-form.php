<?php
if (!defined('ABSPATH')) exit;

$msg = '';
if (isset($_GET['woosm_msg']) && 'check_email' === $_GET['woosm_msg']) {
    $msg = __('Se l\'indirizzo è valido, riceverai un link via email.', 'woosocialmarket');
}
?>
<div class="ct-container woosm-auth-container">
    <div class="ct-card woosm-auth-card">
        <h2 class="ct-title"><?php esc_html_e('Accedi o registrati', 'woosocialmarket'); ?></h2>

        <?php if ($msg) : ?>
            <p class="ct-message-info"><?php echo esc_html($msg); ?></p>
        <?php endif; ?>

        <form method="post" class="woosm-form">
            <?php wp_nonce_field('woosm_magic_login', 'woosm_magic_login_nonce'); ?>

            <div class="woosm-field">
                <label for="woosm_email" class="ct-label">
                    <?php esc_html_e('Email', 'woosocialmarket'); ?>
                </label>
                <input type="email" name="woosm_email" id="woosm_email" class="ct-input" required>
            </div>

            <button type="submit" class="ct-button ct-button-primary">
                <?php esc_html_e('Invia link di accesso', 'woosocialmarket'); ?>
            </button>
        </form>
    </div>
</div>
