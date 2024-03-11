<?php

function fetch_async_api_data($endpoints, $symbol, $token)
{
    $mh = curl_multi_init();
    $curl_handles = [];

    foreach ($endpoints as $endpoint) {
        $api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/' . $endpoint;
        $ch = curl_init($api_url);

        $headers = array(
            'x-csrf-token: ' . $token->csrf,
            'Authorization: Bearer ' . $token->jwToken
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_multi_add_handle($mh, $ch);
        $curl_handles[$endpoint] = $ch;
    }

    $responses = array();
    do {
        while (($execrun = curl_multi_exec($mh, $running)) == CURLM_CALL_MULTI_PERFORM);
        if ($execrun != CURLM_OK)
            break;
        // a request was just completed -- find out which one
        while ($done = curl_multi_info_read($mh)) {
            $info = curl_getinfo($done['handle']);
            if ($info['http_code'] == 200) {
                $response = curl_multi_getcontent($done['handle']);
                $endpoint = array_search($done['handle'], $curl_handles);
                if($endpoint === "overview") {
                    $response = json_decode($response);
                    if ($response && isset($response->data)) {
                        $responses[$endpoint] = $response->data;
                    }    
                } else {
                    $response = json_decode($response, true);
                    if ($response && isset($response['data'])) {
                        $responses[$endpoint] = $response['data'];
                    }
                }
            }
            curl_multi_remove_handle($mh, $done['handle']);
            curl_close($done['handle']);
        }
        // Block for data in / output; error handling is done by curl_multi_exec
        if ($running)
            curl_multi_select($mh, 5);
    } while ($running);

    curl_multi_close($mh);

    return $responses;
}

function fetch_all_api_data($symbol, $token)
{
    $endpoints = ['overview', 'returns', 'income-statement', 'balance-sheet', 'cash-flow', 'key-ratios', 'news', 'analysts-predictions'];
    return fetch_async_api_data($endpoints, $symbol, $token);
}


function fetch_price_chart_api_data($symbol, $token) {
    error_log("Price Chart API Call");
    $price_chart_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/ohlcv?timeframe=1Y&interval=daily';
    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($price_chart_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Price Chart API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Price Chart API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Price Chart API response error: Invalid data format");
    return false;
}
