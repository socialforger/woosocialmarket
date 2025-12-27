<?php
/**
 * Frontend public
 * author: socialforger
 */

if (!defined('ABSPATH')) exit;

class Woosm_Public {

    public function enqueue_assets() {
        wp_enqueue_style(
            'woosm-public',
            WOOSM_PLUGIN_URL . 'assets/css/public.css',
            [],
            WOOSM_VERSION
        );

        wp_enqueue_script(
            'woosm-public',
            WOOSM_PLUGIN_URL . 'assets/js/public.js',
            ['jquery'],
            WOOSM_VERSION,
            true
        );
    }
}
