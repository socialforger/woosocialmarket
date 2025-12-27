<?php
/**
 * Magic link login
 * author: socialforger
 */

if (!defined('ABSPATH')) exit;

class Woosm_Magic_Login {

    const META_MAGIC_TOKEN   = '_woosm_magic_token';
    const META_MAGIC_EXPIRES = '_woosm_magic_expires';

    public function maybe_handle_login_request() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (empty($_POST['woosm_magic_login_nonce']) ||
            !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['woosm_magic_login_nonce'])), 'woosm_magic_login')) {
            return;
        }

        if (empty($_POST['woosm_email'])) return;

        $email = sanitize_email(wp_unslash($_POST['woosm_email']));
        if (!is_email($email)) return;

        $user = get_user_by('email', $email);

        if ($user) {
            $this->send_magic_link($user->ID, 'login');
        } else {
            $this->send_magic_link(0, 'register', $email);
        }

        wp_safe_redirect(add_query_arg('woosm_msg', 'check_email', woosm_get_login_page_url()));
        exit;
    }

    protected function send_magic_link($user_id, $purpose, $email_override = '') {

        $token   = wp_generate_password(32, false);
        $expires = time() + HOUR_IN_SECONDS;

        $email = $email_override ?: ($user_id ? get_userdata($user_id)->user_email : '');
        if (!$email) return;

        if ($user_id) {
            update_user_meta($user_id, self::META_MAGIC_TOKEN, $token);
            update_user_meta($user_id, self::META_MAGIC_EXPIRES, $expires);
        }

        $args = [
            'token'   => $token,
            'purpose' => $purpose,
            'email'   => rawurlencode($email),
        ];

        $url = ('login' === $purpose)
            ? add_query_arg($args, woosm_get_login_page_url())
            : add_query_arg($args, woosm_get_registration_page_url());

        $subject = ('login' === $purpose)
            ? __('Il tuo link di accesso', 'woosocialmarket')
            : __('Completa la registrazione', 'woosocialmarket');

        $message  = __('Clicca sul seguente link per procedere:', 'woosocialmarket') . "\n\n";
        $message .= esc_url($url) . "\n\n";
        $message .= __('Se non hai richiesto questo accesso, ignora questa email.', 'woosocialmarket');

        wp_mail($email, $subject, $message);
    }

    public function process_magic_link() {

        if (!isset($_GET['token'], $_GET['purpose'])) return;

        $token   = sanitize_text_field(wp_unslash($_GET['token']));
        $purpose = sanitize_text_field(wp_unslash($_GET['purpose']));
        $email   = isset($_GET['email']) ? sanitize_email(wp_unslash($_GET['email'])) : '';

        if ('login' === $purpose) {

            $user = get_user_by('email', $email);
            if (!$user) {
                wp_die(esc_html__('Utente non trovato.', 'woosocialmarket'));
            }

            $stored_token   = get_user_meta($user->ID, self::META_MAGIC_TOKEN, true);
            $stored_expires = (int) get_user_meta($user->ID, self::META_MAGIC_EXPIRES, true);

            if ($stored_token !== $token || time() > $stored_expires) {
                wp_die(esc_html__('Link non valido o scaduto.', 'woosocialmarket'));
            }

            delete_user_meta($user->ID, self::META_MAGIC_TOKEN);
            delete_user_meta($user->ID, self::META_MAGIC_EXPIRES);

            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            wp_safe_redirect(woosm_get_reserved_home_url());
            exit;

        } elseif ('register' === $purpose) {

            if (!$email) {
                wp_die(esc_html__('Email non valida.', 'woosocialmarket'));
            }

            // Nessun gruppo assegnato qui, solo passaggio al form di registrazione.
            return;
        }
    }
}
