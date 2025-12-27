<?php
/**
 * Registrazione utente con geocoding OSM
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woosm_Registration {

    public function maybe_handle_registration_submit() {

        if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
            return;
        }

        if ( empty( $_POST['woosm_registration_nonce'] ) ||
             ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woosm_registration_nonce'] ) ), 'woosm_registration' ) ) {
            return;
        }

        $email = isset( $_POST['woosm_email'] ) ? sanitize_email( wp_unslash( $_POST['woosm_email'] ) ) : '';

        if ( ! $email || ! is_email( $email ) ) {
            return;
        }

        // Se esiste già → login diretto (nessun gruppo assegnato qui)
        if ( email_exists( $email ) ) {
            $user = get_user_by( 'email', $email );
            wp_set_current_user( $user->ID );
            wp_set_auth_cookie( $user->ID );
            wp_safe_redirect( woosm_get_reserved_home_url() );
            exit;
        }

        // Dati anagrafici
        $nome         = sanitize_text_field( $_POST['woosm_first_name'] ?? '' );
        $cognome      = sanitize_text_field( $_POST['woosm_last_name'] ?? '' );
        $birth_date   = sanitize_text_field( $_POST['woosm_birth_date'] ?? '' );
        $birth_place  = sanitize_text_field( $_POST['woosm_birth_place'] ?? '' );
        $address      = sanitize_text_field( $_POST['woosm_address'] ?? '' );
        $zip          = sanitize_text_field( $_POST['woosm_zip'] ?? '' );
        $city         = sanitize_text_field( $_POST['woosm_city'] ?? '' );
        $country      = sanitize_text_field( $_POST['woosm_country'] ?? '' );

        // Creazione utente
        $password = wp_generate_password( 20, true );
        $username = sanitize_user( current( explode( '@', $email ) ) );

        if ( username_exists( $username ) ) {
            $username .= '_' . wp_generate_password( 4, false );
        }

        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            woosm_log( 'Errore creazione utente: ' . $user_id->get_error_message() );
            return;
        }

        // Aggiornamento profilo
        wp_update_user( array(
            'ID'           => $user_id,
            'first_name'   => $nome,
            'last_name'    => $cognome,
            'display_name' => trim( $nome . ' ' . $cognome ),
        ) );

        update_user_meta( $user_id, 'woosm_birth_date', $birth_date );
        update_user_meta( $user_id, 'woosm_birth_place', $birth_place );
        update_user_meta( $user_id, 'woosm_address', $address );
        update_user_meta( $user_id, 'woosm_zip', $zip );
        update_user_meta( $user_id, 'woosm_city', $city );
        update_user_meta( $user_id, 'woosm_country', $country );

        /**
         * Geocoding OSM (solo suggerimento futuro, nessuna assegnazione gruppo)
         */
        $full_address = trim( $address . ', ' . $zip . ' ' . $city . ', ' . $country );

        $geocoder = new Woosm_Geocoding();
        $coords   = $geocoder->geocode( $full_address );

        if ( $coords ) {
            update_user_meta( $user_id, 'woosm_lat', $coords['lat'] );
            update_user_meta( $user_id, 'woosm_lng', $coords['lng'] );
        } else {
            woosm_log( 'Geocoding fallito per: ' . $full_address );
        }

        // Nessun gruppo assegnato qui: sarà assegnato solo dopo il pagamento dell'ordine.

        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id );
        wp_safe_redirect( woosm_get_reserved_home_url() );
        exit;
    }
}
