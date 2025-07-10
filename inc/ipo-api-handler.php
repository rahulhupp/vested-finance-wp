<?php
/**
 * IPO API Handler
 * Handles API calls for IPO details page
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// API Configuration
define('IPO_API_INVESTOR_ID', 'a0147241-64d9-41e9-875c-b67dd7cf07ab'); // Static investor ID
/**
 * Generic function to fetch data from IPO APIs
 * 
 * @param string $ipo_id The IPO ID
 * @param string $endpoint The API endpoint (documents, news, research, investors)
 * @return array|false Array of data or false on error
 */
function get_ipo_api_data($ipo_id, $endpoint) {
    // error_log("get_ipo_api_data: " . $ipo_id . " " . $endpoint);
    // Validate IPO ID
    if (empty($ipo_id)) {
        // error_log("IPO {$endpoint} API Error: Empty IPO ID provided");
        return false;
    }
    
    // Skip cache - always fetch fresh data
    $cache_key = "ipo_{$endpoint}_" . sanitize_key($ipo_id);
    // error_log("Skipping cache - fetching fresh data for {$endpoint} and IPO {$ipo_id}");
    
    // API endpoints mapping
    $endpoints = array(
        'documents' => 'document',
        'news' => 'pre-ipo-company-news',
        'research' => 'pre-ipo-company-research',
        'investors' => 'pre-ipo-company-spv/investor/' . IPO_API_INVESTOR_ID,
        'investment' => 'pre-ipo-company-investment/investor/' . IPO_API_INVESTOR_ID,
        'funding_rounds' => 'pre-ipo-company-funding-round'
    );
    
    if (!isset($endpoints[$endpoint])) {
        // error_log("IPO API Error: Invalid endpoint '{$endpoint}'");
        return false;
    }
    
    // API endpoint and headers
    $api_url = "https://sandbox-api.monark-markets.com/primary/v1/{$endpoints[$endpoint]}?preIPOCompanyId=" . urlencode($ipo_id) . "&monarkStage=PRIMARY_FUNDRAISE&exemptionsClaimed=Reg_S";
    // error_log("api_url: " . $api_url);
    $headers = array(
        'Authorization' => 'partner_w4jzGWqdQ7Mgb2r2yq5ndIQOjdq/VVuvk3ZEmEMoJgE=',
        'accept' => 'application/json',
    );
    
    // Make API request
    $response = wp_remote_get($api_url, array(
        'headers' => $headers,
        'timeout' => 30,
    ));
    
    // Check for errors
    if (is_wp_error($response)) {
        // error_log("IPO {$endpoint} API Error: " . $response->get_error_message());
        return false;
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        // error_log("IPO {$endpoint} API Error: HTTP {$response_code} for IPO ID: {$ipo_id}");
        return false;
    }
    
    // Parse response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        // error_log("IPO {$endpoint} API Error: Invalid JSON response for IPO ID: {$ipo_id}");
        return false;
    }
    
    // Log the actual API response data
    // error_log("=== IPO API RESPONSE DATA ===");
    // error_log("Endpoint: {$endpoint}");
    // error_log("IPO ID: {$ipo_id}");
    // error_log("Response Code: {$response_code}");
    // error_log("Raw Response Body: " . $body);
    // error_log("Parsed Data: " . print_r($data, true));
    // error_log("=== END IPO API RESPONSE DATA ===");
    
    // Cache the data for 1 hour
    set_transient($cache_key, $data, HOUR_IN_SECONDS);
    
    return $data;
}

/**
 * Get SPV details using the SPV ID from investors API
 * 
 * @param string $spv_id The SPV ID from investors API
 * @return array|false Array of SPV details or false on error
 */
function get_ipo_spv_details($spv_id) {
    // Validate SPV ID
    if (empty($spv_id)) {
        // error_log("IPO SPV API Error: Empty SPV ID provided");
        return false;
    }
    
    // Skip cache - always fetch fresh data
    $cache_key = "ipo_spv_details_" . sanitize_key($spv_id);
    // error_log("Skipping SPV cache - fetching fresh data for SPV {$spv_id}");
    
    // API endpoint and headers
    $api_url = "https://sandbox-api.monark-markets.com/primary/v1/pre-ipo-company-spv/{$spv_id}/investor/" . IPO_API_INVESTOR_ID . "?includeDocuments=true&monarkStage=PRIMARY_FUNDRAISE&exemptionsClaimed=Reg_S";
    $headers = array(
        'Authorization' => 'partner_w4jzGWqdQ7Mgb2r2yq5ndIQOjdq/VVuvk3ZEmEMoJgE=',
        'accept' => 'application/json',
    );
    
    // Make API request
    $response = wp_remote_get($api_url, array(
        'headers' => $headers,
        'timeout' => 30,
    ));
    
    // Check for errors
    if (is_wp_error($response)) {
        // error_log("IPO SPV API Error: " . $response->get_error_message());
        return false;
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        // error_log("IPO SPV API Error: HTTP {$response_code} for SPV ID: {$spv_id}");
        return false;
    }
    
    // Parse response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        // error_log("IPO SPV API Error: Invalid JSON response for SPV ID: {$spv_id}");
        return false;
    }
    
    // Log the actual SPV API response data
    // error_log("=== IPO SPV API RESPONSE DATA ===");
    // error_log("SPV ID: {$spv_id}");
    // error_log("Response Code: {$response_code}");
    // error_log("Raw Response Body: " . $body);
    // error_log("Parsed Data: " . print_r($data, true));
    // error_log("=== END IPO SPV API RESPONSE DATA ===");
    
    // Cache the data for 1 hour
    set_transient($cache_key, $data, HOUR_IN_SECONDS);
    
    return $data;
}

/**
 * Get deal memo URL from SPV details
 * 
 * @param string $ipo_id The IPO ID
 * @return string|false Deal memo URL or false if not found
 */
function get_ipo_deal_memo_url($ipo_id) {
    // First get investors data to get SPV ID
    $investors_data = get_ipo_investors($ipo_id);
    
    if (!$investors_data || empty($investors_data['items'])) {
        return false;
    }
    
    // Get the first investor's SPV ID
    $first_investor = $investors_data['items'][0];
    if (empty($first_investor['id'])) {
        return false;
    }
    
    $spv_id = $first_investor['id'];
    
    // Get SPV details
    $spv_details = get_ipo_spv_details($spv_id);
    
    if (!$spv_details || empty($spv_details['documents'])) {
        return false;
    }
    
    // Find the DealMemo_Monark document
    foreach ($spv_details['documents'] as $document) {
        if (isset($document['type']) && $document['type'] === 'DealMemo_Monark') {
            return $document['url'];
        }
    }
    
    return false;
}

/**
 * Fetch documents for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of documents or false on error
 */
function get_ipo_documents($ipo_id) {
    return get_ipo_api_data($ipo_id, 'documents');
}

/**
 * Fetch news for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of news or false on error
 */
function get_ipo_news($ipo_id) {
    return get_ipo_api_data($ipo_id, 'news');
}

/**
 * Fetch research reports for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of research reports or false on error
 */
function get_ipo_research($ipo_id) {
    return get_ipo_api_data($ipo_id, 'research');
}

/**
 * Fetch investors data for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of investors data or false on error
 */
function get_ipo_investors($ipo_id) {
    return get_ipo_api_data($ipo_id, 'investors');
}

/**
 * Fetch investment data for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of investment data or false on error
 */
function get_ipo_investment($ipo_id) {
    return get_ipo_api_data($ipo_id, 'investment');
}

/**
 * Fetch funding rounds data for a specific IPO
 * 
 * @param string $ipo_id The IPO ID
 * @return array|false Array of funding rounds data or false on error
 */
function get_ipo_funding_rounds($ipo_id) {
    return get_ipo_api_data($ipo_id, 'funding_rounds');
}

/**
 * Test API connection (for debugging)
 * 
 * @param string $ipo_id The IPO ID to test
 * @param string $endpoint The endpoint to test (documents, news, research, investors, investment)
 * @return array Test results
 */
function test_ipo_api_connection($ipo_id = '6253a09c-a9f2-42b6-8d50-e44b504d9cb4', $endpoint = 'documents') {
    $result = array(
        'success' => false,
        'message' => '',
        'data' => null
    );
    
    try {
        $data = get_ipo_api_data($ipo_id, $endpoint);
        
        if ($data === false) {
            $result['message'] = "Failed to fetch {$endpoint} from API";
        } else {
            $result['success'] = true;
            $result['message'] = "API connection successful for {$endpoint}";
            $result['data'] = $data;
        }
    } catch (Exception $e) {
        $result['message'] = 'Exception: ' . $e->getMessage();
    }
    
    return $result;
} 