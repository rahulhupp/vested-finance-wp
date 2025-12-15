<?php
/**
 * Stock Schema Helper Functions
 * 
 * This file contains all helper functions for generating structured data schemas
 * for stock and ETF detail pages.
 * 
 * @package Vested Finance
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sanitize and escape JSON string for schema output
 * 
 * @param string $string The string to sanitize
 * @return string Sanitized string safe for JSON
 */
function vf_schema_sanitize_string($string) {
    if (empty($string)) {
        return '';
    }
    // Remove extra whitespace and newlines
    $string = preg_replace('/\s+/', ' ', trim($string));
    // Escape quotes and special characters for JSON
    return str_replace(['"', "\n", "\r", "\t"], ['\"', ' ', ' ', ' '], $string);
}

/**
 * Get the logo URL for the organization schema
 * 
 * @return string Logo URL
 */
function vf_get_logo_url() {
    // Try to get from theme options first
    $logo_url = get_theme_mod('custom_logo');
    if ($logo_url) {
        $logo_array = wp_get_attachment_image_src($logo_url, 'full');
        if ($logo_array) {
            return $logo_array[0];
        }
    }
    
    // Fallback to default logo
    return 'https://vested-wordpress-media-prod-in.s3.ap-south-1.amazonaws.com/wp-content/uploads/2025/11/14083935/logo-primary.svg';
}

/**
 * Extract investment fund types from stock tags
 * 
 * @param array $tags Stock tags from API
 * @return array Array of investment fund type strings
 */
function vf_get_investment_fund_types($tags) {
    $fund_types = [];
    
    if (empty($tags) || !is_array($tags)) {
        return ['Equity']; // Default fallback
    }
    
    foreach ($tags as $tag) {
        if (isset($tag->value) && !empty($tag->value)) {
            $fund_types[] = vf_schema_sanitize_string($tag->value);
        }
    }
    
    // Ensure we always have at least 'Equity'
    if (empty($fund_types)) {
        $fund_types[] = 'Equity';
    }
    
    return $fund_types;
}

/**
 * Format returns data for fund performance schema
 * 
 * @param mixed $returns_data Returns data from API (can be object or array)
 * @return array Array of formatted fund performance objects
 */
function vf_format_fund_performance($returns_data) {
    $performance = [];
    
    if (empty($returns_data)) {
        return $performance;
    }
    
    // Convert to array if it's an object
    if (is_object($returns_data)) {
        $returns_data = (array) $returns_data;
    }
    
    // Check if data has the nested structure: current->raw
    $raw_data = null;
    if (isset($returns_data['current']['raw'])) {
        $raw_data = $returns_data['current']['raw'];
    } elseif (isset($returns_data['current']) && is_array($returns_data['current'])) {
        $raw_data = $returns_data['current'];
    } else {
        $raw_data = $returns_data;
    }
    
    // Map of return periods to display names
    $period_map = [
        '1y' => '1-Year Return',
        '3y' => '3-Year Return',
        '5y' => '5-Year Return',
        '10y' => '10-Year Return',
    ];
    
    foreach ($period_map as $key => $display_name) {
        $value = null;
        
        // Check if key exists in the raw data
        if (isset($raw_data[$key]) && is_numeric($raw_data[$key])) {
            $value = $raw_data[$key];
        }
        
        // If we found a value, add it to performance array
        if ($value !== null) {
            $formatted_value = number_format((float)$value, 2, '.', '');
            $performance[] = [
                '@type' => 'InvestmentOrDeposit',
                'name' => $display_name,
                'amount' => [
                    '@type' => 'MonetaryAmount',
                    'value' => $formatted_value,
                    'currency' => 'PERCENT'
                ]
            ];
        }
    }
    
    return $performance;
}

/**
 * Parse market cap value to numeric format
 * 
 * @param string $market_cap_string Market cap string (e.g., "1.2T", "500B")
 * @return string Numeric value as string
 */
function vf_parse_market_cap($market_cap_string) {
    if (empty($market_cap_string)) {
        return '0';
    }
    
    // Remove currency symbols and spaces
    $value = trim(str_replace(['$', '₹', ' '], '', $market_cap_string));
    
    // Convert to numeric
    $multiplier = 1;
    if (stripos($value, 'T') !== false) {
        $multiplier = 1000000000000;
        $value = str_replace(['T', 't'], '', $value);
    } elseif (stripos($value, 'B') !== false) {
        $multiplier = 1000000000;
        $value = str_replace(['B', 'b'], '', $value);
    } elseif (stripos($value, 'M') !== false) {
        $multiplier = 1000000;
        $value = str_replace(['M', 'm'], '', $value);
    } elseif (stripos($value, 'K') !== false) {
        $multiplier = 1000;
        $value = str_replace(['K', 'k'], '', $value);
    }
    
    $numeric_value = floatval($value) * $multiplier;
    return number_format($numeric_value, 0, '.', '');
}

/**
 * Get current page URL for stock details
 * 
 * @return string Current page URL
 */
function vf_get_current_stock_url() {
    // Try to get from query var first (set in page-stocks-details.php)
    $url = get_query_var('custom_stock_url_value');
    
    if (!empty($url)) {
        return esc_url($url);
    }
    
    // Fallback to current URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $current_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    return esc_url($current_url);
}

/**
 * Get stock description for schema
 * 
 * @param object $overview_data Stock overview data
 * @return string Stock description
 */
function vf_get_stock_description($overview_data) {
    // Try custom meta description first
    $custom_description = get_query_var('custom_stock_description_value');
    if (!empty($custom_description)) {
        return vf_schema_sanitize_string($custom_description);
    }
    
    // Use API description
    if (!empty($overview_data->description)) {
        return vf_schema_sanitize_string($overview_data->description);
    }
    
    // Fallback description
    $name = isset($overview_data->name) ? $overview_data->name : 'this stock';
    $ticker = isset($overview_data->ticker) ? $overview_data->ticker : '';
    return vf_schema_sanitize_string("Invest in {$name} ({$ticker}) stock with real-time price, key metrics, and historical returns via Vested Finance.");
}

/**
 * Determine if current page is ETF
 * 
 * @param array $get_path URL path array
 * @return bool True if ETF, false otherwise
 */
function vf_is_etf_page($get_path) {
    return isset($get_path[2]) && $get_path[2] === 'etf';
}

/**
 * Get fund type label
 * 
 * @param object $overview_data Stock overview data
 * @param bool $is_etf Whether page is ETF
 * @return string Fund type label
 */
function vf_get_fund_type($overview_data, $is_etf) {
    if ($is_etf) {
        return 'ETF';
    }
    
    if (!empty($overview_data->type)) {
        return vf_schema_sanitize_string($overview_data->type);
    }
    
    return 'Common Stock';
}

/**
 * Get ticker symbol with exchange
 * 
 * @param object $overview_data Stock overview data
 * @return string Formatted ticker (e.g., "NASDAQ:TSLA")
 */
function vf_get_ticker_with_exchange($overview_data) {
    $exchange = !empty($overview_data->exchange) ? $overview_data->exchange : 'NASDAQ';
    $ticker = !empty($overview_data->ticker) ? $overview_data->ticker : '';
    
    return vf_schema_sanitize_string($exchange . ':' . $ticker);
}

/**
 * Build breadcrumb list items
 * 
 * @param object $overview_data Stock overview data
 * @param bool $is_etf Whether page is ETF
 * @return array Array of breadcrumb items
 */
function vf_build_breadcrumb_items($overview_data, $is_etf) {
    $home_url = home_url('/');
    $current_url = vf_get_current_stock_url();
    $stock_name = !empty($overview_data->name) ? vf_schema_sanitize_string($overview_data->name) : 'Stock';
    
    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => $home_url
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'US Stocks',
            'item' => home_url('/us-stocks/')
        ]
    ];
    
    if ($is_etf) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => 'ETFs',
            'item' => home_url('/us-stocks/etf/')
        ];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => $current_url,
            'item' => $current_url
        ];
    } else {
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $current_url,
            'item' => $current_url
        ];
    }
    
    return $items;
}

/**
 * Validate and format price value
 * 
 * @param mixed $price Price value
 * @return string Formatted price
 */
function vf_format_price($price) {
    if (empty($price) || !is_numeric($price)) {
        return '0.00';
    }
    return number_format((float)$price, 2, '.', '');
}

