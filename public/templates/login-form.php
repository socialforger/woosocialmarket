<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$msg = '';
if ( isset( $_GET['woosm_msg'] ) && 'check_email' === $_GET['woosm_msg'] ) {
    $msg = __( 'Se l\'indirizzo è valido, riceverai un link via email.', 'woosocialmarket' );
}
?>
<div class="woosm-login-form">
    <?php if ( $msg ) : ?>
        <p class="woosm-message"><?php echo esc_html( $msg ); ?></p>
    <?php endif; ?>
    <form method="post">
        <?php wp_nonce_field( 'woosm_magic_login', 'woosm_magic_login_nonce' ); ?>
        <label for="woosm_email"><?php esc_html_e( 'Email', 'woosocialmarket' ); ?></label>
        <input type="email" name="woosm_email" id="woosm_email" required>
        <button type="submit"><?php esc_html_e( 'Accedi / Registrati', 'woosocialmarket' ); ?></button>
    </form>
</div>
