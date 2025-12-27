<?php
/**
 * Internazionalizzazione
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woosm_i18n {

    public function load_textdomain() {
        load_plugin_textdomain(
            'woosocialmarket',
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/../languages/'
        );
    }
}
