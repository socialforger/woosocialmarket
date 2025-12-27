<?php
/**
 * Helpers
 * author: socialforger
 */

if (!defined('ABSPATH')) exit;

function woosm_log($message) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        error_log('[WooSocialMarket] ' . $message);
    }
}

/**
 * URL pagine chiave (da allineare agli slug reali)
 */
function woosm_get_login_page_url() {
    return site_url('/woosm-login/');
}

function woosm_get_registration_page_url() {
    return site_url('/woosm-registrazione/');
}

function woosm_get_reserved_home_url() {
    return site_url('/area-riservata/');
}

/**
 * Distanza in km (Haversine)
 */
function woosm_calculate_distance_km($lat1, $lng1, $lat2, $lng2) {
    $earth = 6371;
    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);
    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);

    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;

    $a = sin($dlat/2)**2 + cos($lat1)*cos($lat2)*sin($dlng/2)**2;
    return $earth * 2 * atan2(sqrt($a), sqrt(1-$a));
}

/**
 * Coordinate utente (se presenti)
 */
function woosm_get_user_coords($user_id) {
    $lat = get_user_meta($user_id, 'woosm_lat', true);
    $lng = get_user_meta($user_id, 'woosm_lng', true);

    if (!$lat || !$lng) return null;

    return [
        'lat' => (float)$lat,
        'lng' => (float)$lng,
    ];
}
