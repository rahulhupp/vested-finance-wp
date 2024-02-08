<?php

function custom_query_vars($vars) {
    $vars[] = 'custom_stock_request';
    $vars[] = 'symbol';
    $vars[] = 'company';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');


function custom_rewrite_rules() {
    add_rewrite_rule(
        // '^us-stocks/([^/]+)/([^/]+)/?$',
        '^us-stocks/([^/]+)/([^/]+)$',
        'index.php?custom_stock_request=1&symbol=$matches[1]&company=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');


function custom_template_redirect() {
    $custom_stock_request = get_query_var('custom_stock_request');
    $symbol = get_query_var('symbol');
    $company = get_query_var('company');

    if ($custom_stock_request) {
        include get_stylesheet_directory() . '/templates/page-stocks-details.php';
        exit();
    } else {
        error_log('Debug: Custom stock request not detected.');
    }
}
add_action('template_redirect', 'custom_template_redirect');

function custom_wpseo_title($title) {
    $custom_stock_title_value = get_query_var('custom_stock_title_value');
    if ( $custom_stock_title_value ) {
        $title = $custom_stock_title_value;
    }
    return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_opengraph_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_twitter_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_twitter_image_alt', 'custom_wpseo_title', 10, 1);

function custom_wpseo_metadesc($description) {
    $stock_description_value = get_query_var('custom_stock_description_value');
    if ($stock_description_value) {
        $description = $stock_description_value;
    }
    return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc', 10, 1);
// add_filter('wpseo_opengraph_description', 'custom_wpseo_metadesc', 10, 1);
add_filter('wpseo_twitter_description', 'custom_wpseo_metadesc', 10, 1);

function custom_wpseo_opengraph_url($url) {
    $stock_url_value = get_query_var('custom_stock_url_value');
    if ($stock_url_value) {
        $url = $stock_url_value;
    }
    return $url;
}
add_filter('wpseo_opengraph_url', 'custom_wpseo_opengraph_url', 10, 1);
add_filter('wpseo_canonical', 'custom_wpseo_opengraph_url', 10, 1);


function custom_wpseo_opengraph_image($image) {
    $stock_image_value = get_query_var('custom_stock_image_value');
    if ($stock_image_value) {
        $image = $stock_image_value;
    }
    return $image;
}
// add_filter('wpseo_opengraph_image', 'custom_wpseo_opengraph_image', 10, 1);
add_filter('wpseo_twitter_image', 'custom_wpseo_opengraph_image', 10, 1);

add_action('wpseo_head', 'add_extra_og', 5);

function add_extra_og() {
    $stock_image_value = get_query_var('custom_stock_image_value');
    if ($stock_image_value) {
        $image = $stock_image_value;
        echo '<meta property="og:image" content="'. $image .'" />';
    }
    $stock_description_value = get_query_var('custom_stock_description_value');
    if ($stock_description_value) {
        $description = $stock_description_value;
        echo '<meta property="og:description" content="'. $description .'" />';
    }
}

function custom_wpseo_twitter_card_type($card_type) {
    return 'summary'; 
}
add_filter('wpseo_twitter_card_type', 'custom_wpseo_twitter_card_type', 10, 1);

function custom_wpseo_twitter_site($site) {
    return '@Vested_finance';
}
add_filter('wpseo_twitter_site', 'custom_wpseo_twitter_site', 10, 1);

function custom_wpseo_sitemap_index($sitemap_index) {
    $last_modified = date('c');
    $custom_url = '<sitemap><loc>' . home_url('/us-stocks-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>';
    $sitemap_index .= $custom_url;
    return $sitemap_index;
}
add_filter('wpseo_sitemap_index', 'custom_wpseo_sitemap_index', 10, 1);


function remove_unwanted_styles() {
    $stock_title_value = get_query_var('custom_stock_title_value');
    if ( $stock_title_value ) {
        wp_dequeue_style('slick-carousel');
        wp_deregister_style('slick-carousel');
        wp_dequeue_style('slick-theme');
        wp_deregister_style('slick-theme');
        wp_dequeue_style('newsletter-style');
        wp_deregister_style('newsletter-style');
        wp_dequeue_style('sub-category-style');
        wp_deregister_style('sub-category-style');
        wp_dequeue_style('blog-page-style');
        wp_deregister_style('blog-page-style');
        wp_dequeue_style('module-style');
        wp_deregister_style('module-style');

        wp_dequeue_script('slick-carousel');
        wp_deregister_script('slick-carousel');
        wp_dequeue_script('custom-slick-slider');
        wp_deregister_script('custom-slick-slider');
        wp_dequeue_script('script-js');
        wp_deregister_script('script-js');
    }
}
add_action('wp_enqueue_scripts', 'remove_unwanted_styles', 9999);


// Hook into the template_redirect action
add_action('template_redirect', 'custom_redirect');

function custom_redirect() {
    // Get the requested URL
    $requested_url = $_SERVER['REQUEST_URI'];

    $home_url = parse_url(home_url(), PHP_URL_PATH);

    $path = substr($requested_url, strlen($home_url));
    
    $getfirstpath = explode("/",$path);
    error_log('3 First: ' . $getfirstpath[1]);

    // Check if the requested URL contains "us-stocks"
    if ($getfirstpath[1] == 'us-stocks') {
        
        $token_api_url = 'https://vested-api-prod.vestedfinance.com/get-partner-token';
        $token_headers = array(
            'partner-id: 7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
            'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9',
            'instrument-list-access: true',
        );
        $token = call_api_with_curl($token_api_url, $token_headers);
        $redirect_mappings = array();
        if (!empty($token)) {
            $data_api_url = 'https://vested-api-prod.vestedfinance.com/v1/partner/instruments-list';
            $data_headers = array(
                'partner-authentication-token: ' . $token,
                'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9',
            );
            $data_response = call_api_with_curl($data_api_url, $data_headers);
            $data = json_decode($data_response, true);

            if ($data && isset($data['access']) && $data['access'] === 'PASS' && isset($data['instruments']) && is_array($data['instruments'])) {
                foreach ($data['instruments'] as $instrument) {
                    if($instrument['type'] !== 'etf') {
                        $stocks_symbol = strtolower($instrument['symbol']);
                        $name = strtolower($instrument['name']); // Convert name to lowercase
                        $name = str_replace([' ', ','], '-', $name); // Replace spaces and commas with dashes
                        $name = preg_replace('/[^a-zA-Z0-9\-]/', '', $name); // Remove special characters and dots
                        $name = preg_replace('/-+/', '-', $name);
                        $redirect_mappings[$stocks_symbol] = $name;
                    }
                }
            }
        }

        // error_log(print_r($redirect_mappings, true));


        $start_pos_symbol = strpos($requested_url, '/us-stocks/') + strlen('/us-stocks/');
        $stocks_symbol = substr($requested_url, $start_pos_symbol);

        // Extract the symbol
        $end_pos_symbol = strpos($stocks_symbol, '/');
        if ($end_pos_symbol !== false) {
            $stocks_symbol = substr($stocks_symbol, 0, $end_pos_symbol);
        }

        error_log('Extracted symbol: ' . $stocks_symbol);

        // Trim the symbol to remove whitespace
        $stocks_symbol = trim($stocks_symbol);

        // Check if the symbol exists in the mappings array
        if (array_key_exists($stocks_symbol, $redirect_mappings)) {
            // Get the new slug
            $new_slug = $redirect_mappings[$stocks_symbol];

            // Construct the new URL
            $new_url = home_url("/us-stocks/{$stocks_symbol}/{$new_slug}-share-price/");

            // Log the new URL for debugging
            error_log('New URL: ' . $new_url);

            // Perform the redirection
            wp_redirect($new_url, 301);
            exit();
        } else {
            error_log('Defult New URL:');
        }
    }
}

?>