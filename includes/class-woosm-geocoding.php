<?php
/**
 * Geocoding OSM (Nominatim)
 * author: socialforger
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woosm_Geocoding {

    const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search';

    /**
     * Geocodifica un indirizzo e restituisce lat/lng
     *
     * @param string $address
     * @return array|null
     */
    public function geocode( $address ) {

        if ( empty( $address ) ) {
            return null;
        }

        $params = array(
            'q'      => $address,
            'format' => 'json',
            'limit'  => 1,
        );

        $url = add_query_arg( $params, self::NOMINATIM_URL );

        $response = wp_remote_get( $url, array(
            'timeout' => 10,
            'headers' => array(
                'User-Agent' => 'WooSocialMarket/1.0 (socialforger)',
            ),
        ) );

        if ( is_wp_error( $response ) ) {
            woosm_log( 'Errore geocoding: ' . $response->get_error_message() );
            return null;
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( empty( $data ) || ! is_array( $data ) ) {
            woosm_log( 'Geocoding: nessun risultato per ' . $address );
            return null;
        }

        $result = $data[0];

        if ( empty( $result['lat'] ) || empty( $result['lon'] ) ) {
            woosm_log( 'Geocoding: risultato incompleto per ' . $address );
            return null;
        }

        return array(
            'lat' => floatval( $result['lat'] ),
            'lng' => floatval( $result['lon'] ),
        );
    }
}
