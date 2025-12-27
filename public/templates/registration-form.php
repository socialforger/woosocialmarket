<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$email = isset( $woosm_email ) ? $woosm_email : '';
?>
<div class="woosm-registration-form">
    <h2><?php esc_html_e( 'Completa la registrazione', 'woosocialmarket' ); ?></h2>
    <form method="post">
        <?php wp_nonce_field( 'woosm_registration', 'woosm_registration_nonce' ); ?>

        <p>
            <label><?php esc_html_e( 'Email', 'woosocialmarket' ); ?></label><br>
            <input type="email" name="woosm_email" value="<?php echo esc_attr( $email ); ?>" readonly>
        </p>

        <p>
            <label><?php esc_html_e( 'Nome', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_first_name" required>
        </p>

        <p>
            <label><?php esc_html_e( 'Cognome', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_last_name" required>
        </p>

        <p>
            <label><?php esc_html_e( 'Data di nascita', 'woosocialmarket' ); ?></label><br>
            <input type="date" name="woosm_birth_date">
        </p>

        <p>
            <label><?php esc_html_e( 'Luogo di nascita', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_birth_place">
        </p>

        <p>
            <label><?php esc_html_e( 'Indirizzo e numero civico', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_address" required>
        </p>

        <p>
            <label><?php esc_html_e( 'CAP', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_zip">
        </p>

        <p>
            <label><?php esc_html_e( 'Città', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_city" required>
        </p>

        <p>
            <label><?php esc_html_e( 'Nazione', 'woosocialmarket' ); ?></label><br>
            <input type="text" name="woosm_country" value="Italia">
        </p>

        <p class="woosm-info">
            <?php esc_html_e( 'Per poter usare la piattaforma sarai iscritto all\'associazione che la gestisce al momento del primo pagamento (aggiunta del prodotto di iscrizione al carrello).', 'woosocialmarket' ); ?>
        </p>

        <p>
            <button type="submit"><?php esc_html_e( 'Completa registrazione', 'woosocialmarket' ); ?></button>
        </p>
    </form>
</div>
