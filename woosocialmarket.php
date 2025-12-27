<?php
/**
 * Plugin Name: Woo Social Market
 * Description: Gestione ordini collettivi GAS con WooCommerce (magic link + registrazione + geocoding).
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

// Core
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-activator.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-deactivator.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-i18n.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-loader.php';
require_once WOOSM_PLUGIN_DIR . 'includes/helpers.php';

// Moduli frontend base
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-public.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-shortcodes.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-magic-login.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-registration.php';
require_once WOOSM_PLUGIN_DIR . 'includes/class-woosm-geocoding.php';

register_activation_hook( __FILE__, array( 'Woosm_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Woosm_Deactivator', 'deactivate' ) );

function woosocialmarket_run() {

    $i18n         = new Woosm_i18n();
    $public       = new Woosm_Public();
    $shortcodes   = new Woosm_Shortcodes();
    $magic_login  = new Woosm_Magic_Login();
    $registration = new Woosm_Registration();

    $loader = new Woosm_Loader();

    // i18n
    $loader->add_action( 'plugins_loaded', $i18n, 'load_textdomain' );

    // frontend assets
    $loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_assets' );

    // magic link
    $loader->add_action( 'init', $magic_login, 'maybe_handle_login_request' );
    $loader->add_action( 'template_redirect', $magic_login, 'process_magic_link' );

    // registrazione
    $loader->add_action( 'init', $registration, 'maybe_handle_registration_submit' );

    $loader->run();
}
woosocialmarket_run();
