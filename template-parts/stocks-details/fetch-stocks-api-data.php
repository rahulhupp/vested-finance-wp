<?php
// Define a function to fetch data from the API
function fetch_overview_api_data($symbol, $token) {
    error_log("Overview API Call");
    $instruments_api_url = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/' . $symbol . '/overview';

    // Set headers
    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    // Make the API request using wp_remote_get with custom headers
    $response = wp_remote_get($instruments_api_url, array(
        'headers' => $headers,
    ));

    // Check if the request was successful
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("API request error: $error_message"); // Log error message
        return false; // Return false if there's an error
    }

    // Get response code
    $response_code = wp_remote_retrieve_response_code($response);

    // Check if response code is 200 (OK)
    if ($response_code !== 200) {
        error_log("API response error: HTTP $response_code"); // Log HTTP error code
        return false; // Return false if there's an error
    }

    // Get response body
    $body = wp_remote_retrieve_body($response);

    // Decode JSON response
    $data = json_decode($body);

    // Check if data is valid
    if ($data && isset($data->data)) {
        return $data->data; // Return data if successful
    }

    // Log error if data is invalid
    error_log("API response error: Invalid data format");
    return false; // Return false if there's an error
}

?>
