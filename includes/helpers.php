<?php
/**
 * Helper functions
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function woosm_log( $message ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        if ( is_array( $message ) || is_object( $message ) ) {
            $message = print_r( $message, true );
        }
        error_log( '[WooSocialMarket] ' . $message );
    }
}

function woosm_get_login_page_url() {
    // In futuro può diventare configurabile via impostazioni.
    return site_url( '/woosm-login/' );
}

function woosm_get_registration_page_url() {
    return site_url( '/woosm-registrazione/' );
}

function woosm_get_reserved_home_url() {
    return site_url( '/area-riservata/' );
}
