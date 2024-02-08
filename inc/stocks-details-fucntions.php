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


?>