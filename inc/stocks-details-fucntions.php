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
        echo "Debug: Custom stock request not detected. 3<br>";
    }
}
add_action('template_redirect', 'custom_template_redirect');

// Customize the meta title
function custom_wpseo_title($title) {
    $custom_stock_title_value = get_query_var('custom_stock_title_value');
    if ( $custom_stock_title_value ) {
        $title = $custom_stock_title_value;
    }
    return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title', 10, 1);

// Customize the meta description
function custom_wpseo_metadesc($description) {
    $custom_stock_description_value = get_query_var('custom_stock_description_value');
    if ($custom_stock_description_value) {
        $description = $custom_stock_description_value;
    }
    return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc', 10, 1);

?>