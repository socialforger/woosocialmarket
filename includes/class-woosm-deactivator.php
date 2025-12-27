<?php
/**
 * Disattivazione plugin
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woosm_Deactivator {

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
