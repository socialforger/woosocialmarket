<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_user = wp_get_current_user();
?>
<div class="woosm-reserved-home">
    <h2><?php printf( esc_html__( 'Ciao %s', 'woosocialmarket' ), esc_html( $current_user->display_name ) ); ?></h2>
    <p><?php esc_html_e( 'Questa è l\'area riservata. In futuro vedrai qui il gruppo più vicino, la mappa e l\'elenco dei gruppi disponibili.', 'woosocialmarket' ); ?></p>
</div>
