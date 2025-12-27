<?php
/**
 * Shortcodes (login, registrazione, area riservata)
 * author: socialforger
 */

if (!defined('ABSPATH')) exit;

class Woosm_Shortcodes {

    public function __construct() {
        add_shortcode('woosm_login', [$this, 'render_login']);
        add_shortcode('woosm_register', [$this, 'render_register']);
        add_shortcode('woosm_reserved_home', [$this, 'render_reserved_home']);
    }

    public function render_login($atts = [], $content = '') {
        if (is_user_logged_in()) {
            wp_safe_redirect(woosm_get_reserved_home_url());
            exit;
        }

        ob_start();
        include WOOSM_PLUGIN_DIR . 'public/templates/login-form.php';
        return ob_get_clean();
    }

    public function render_register($atts = [], $content = '') {
        if (is_user_logged_in()) {
            wp_safe_redirect(woosm_get_reserved_home_url());
            exit;
        }

        if (empty($_GET['email'])) {
            return '<div class="ct-container"><p>' .
                   esc_html__('Email non valida o mancante.', 'woosocialmarket') .
                   '</p></div>';
        }

        $email       = sanitize_email(wp_unslash($_GET['email']));
        $woosm_email = $email;

        ob_start();
        include WOOSM_PLUGIN_DIR . 'public/templates/registration-form.php';
        return ob_get_clean();
    }

    public function render_reserved_home($atts = [], $content = '') {
        if (!is_user_logged_in()) {
            wp_safe_redirect(woosm_get_login_page_url());
            exit;
        }

        ob_start();
        include WOOSM_PLUGIN_DIR . 'public/templates/reserved-home.php';
        return ob_get_clean();
    }
}
