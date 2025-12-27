<?php
/**
 * Plugin Name: Woo Social Market
 * Plugin URI:  https://example.com
 * Description: Gestione ordini collettivi GAS con WooCommerce.
 * Version:     0.1.0
 * Author:      socialforger
 * Text Domain: woosocialmarket
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WOOSM_VERSION', '0.1.0' );
define( 'WOOSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WOOSM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-loader.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-activator.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-deactivator.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-i18n.php';
require_once WOOSM_PLUGIN_DIR . 'includes/helpers.php';

register_activation_hook( __FILE__, array( 'Woosm_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Woosm_Deactivator', 'deactivate' ) );

function woosocialmarket_run() {

    $plugin_i18n = new Woosm_i18n();
    $plugin_i18n->load_textdomain();

    $plugin = new Woosm_Loader();
    $plugin->run();
}
add_action( 'plugins_loaded', 'woosocialmarket_run' );
