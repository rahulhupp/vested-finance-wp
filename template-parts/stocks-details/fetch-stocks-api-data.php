<?php

function fetch_overview_api_data($symbol, $token) {
    error_log("Overview API Call");
    $instruments_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/overview';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($instruments_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Overview API request error: $error_message");
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);

    if ($response_code !== 200) {
        error_log("Overview API response error: HTTP $response_code");
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    if ($data && isset($data->data)) {
        return $data->data;
    }
    error_log("Overview API response error: Invalid data format");
    return false;
}


function fetch_returns_api_data($symbol, $token) {
    error_log("Returns API Call");
    $returns_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/returns';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($returns_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Returns API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Returns API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Returns API response error: Invalid data format");
    return false;
}


function fetch_income_statement_api_data($symbol, $token) {
    error_log("Income Statement API Call");
    $income_statement_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/income-statement';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($income_statement_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Income Statement API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Income Statement API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Income Statement API response error: Invalid data format");
    return false;
}


function fetch_balance_sheet_api_data($symbol, $token) {
    error_log("Balance Sheet API Call");
    $balance_sheet_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/balance-sheet';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($balance_sheet_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Balance Sheet API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Balance Sheet API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Balance Sheet API response error: Invalid data format");
    return false;
}


function fetch_cash_flow_api_data($symbol, $token) {
    error_log("Cash Flow API Call");
    $cash_flow_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/cash-flow';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($cash_flow_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Cash Flow API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Cash Flow API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Cash Flow API response error: Invalid data format");
    return false;
}


function fetch_ratios_api_data($symbol, $token) {
    error_log("Ratios API Call");
    $ratios_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/key-ratios';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($ratios_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Ratios API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("Ratios API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("Ratios API response error: Invalid data format");
    return false;
}


function fetch_news_api_data($symbol, $token) {
    error_log("News API Call");
    $news_api_url = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/' . $symbol . '/news';

    $headers = array(
        'x-csrf-token' => $token->csrf,
        'Authorization' => 'Bearer ' . $token->jwToken
    );

    $response = wp_remote_get($news_api_url, array(
        'headers' => $headers,
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("News API request error: $error_message");
        return false;
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log("News API response error: HTTP $response_code");
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if ($data && isset($data['data'])) {
        return $data['data'];
    }
    error_log("News API response error: Invalid data format");
    return false;
}

?>
