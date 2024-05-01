<?php
function fetch_inr_bonds_api_data() {
    error_log("INR Bonds API Call");
    $inr_bonds_api_url = 'https://yield-api-test.vestedfinance.com/bonds';
    $headers = array(
        'User-Agent' => 'Vested_M#8Dfz$B-8W6'
    );

    $response = wp_remote_get($inr_bonds_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("INR Bonds API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("INR Bonds API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    // print_r($body);
    $data = json_decode($body, true);
    if ($data && isset($data['bonds'])) {
        return $data['bonds'];
    }
    error_log("INR Bonds API response error: Invalid data format");
    return false;
}

?>