<?php
/**
 * Geocoding OSM (Nominatim)
 * author: socialforger
 */

if (!defined('ABSPATH')) exit;

class Woosm_Geocoding {

    const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search';

    public function geocode($address) {

        if (empty($address)) return null;

        $params = [
            'q'      => $address,
            'format' => 'json',
            'limit'  => 1,
        ];

        $url = add_query_arg($params, self::NOMINATIM_URL);

        $response = wp_remote_get($url, [
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'WooSocialMarket/1.0 (socialforger)',
            ],
        ]);

        if (is_wp_error($response)) {
            woosm_log('Errore geocoding: ' . $response->get_error_message());
            return null;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (empty($data) || !is_array($data)) {
            woosm_log('Geocoding: nessun risultato per ' . $address);
            return null;
        }

        $res = $data[0];
        if (empty($res['lat']) || empty($res['lon'])) {
            woosm_log('Geocoding: risultato incompleto per ' . $address);
            return null;
        }

        return [
            'lat' => (float)$res['lat'],
            'lng' => (float)$res['lon'],
        ];
    }
}
