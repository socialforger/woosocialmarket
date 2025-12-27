<?php
/**
 * Attivazione plugin
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woosm_Activator {

    public static function activate() {
        // In futuro: registrazione CPT, ruoli, tabelle custom
        flush_rewrite_rules();
    }
}
