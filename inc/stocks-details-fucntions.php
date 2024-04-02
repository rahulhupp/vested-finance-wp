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
        '^us-stocks/([^/]+)/([^/]+)/?$',
        'index.php?custom_stock_request=1&symbol=$matches[1]&company=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        '^us-stocks/etf/([^/]+)/([^/]+)/?$',
        'index.php?custom_stock_request=1&symbol=$matches[1]&company=$matches[2]&is_etf=1',
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
    }
}
add_action('template_redirect', 'custom_template_redirect');

// Hook into the template_redirect action
add_action('template_redirect', 'custom_redirect');

$requested_url = $_SERVER['REQUEST_URI'];
$home_url = parse_url(home_url(), PHP_URL_PATH);
$path = substr($requested_url, strlen($home_url));
$getfirstpath = explode("/", $path);

$requestUri = $_SERVER['REQUEST_URI'];
    // Check if the URL contains uppercase characters
    if (preg_match('/[A-Z]/', $requestUri)) {
    // Redirect to the lowercase URL
    $lowercaseUri = strtolower($requestUri);
    header('Location: ' . $lowercaseUri, true, 301);
    exit();
 }

if ($getfirstpath[1] == 'us-stocks') {
    $redirect_mappings = get_data_from_stocks_list();

    if ($getfirstpath[2] == 'etf') {
        $start_pos_symbol = strpos($requested_url, '/us-stocks/etf/') + strlen('/us-stocks/etf/');
    } else {
        $start_pos_symbol = strpos($requested_url, '/us-stocks/') + strlen('/us-stocks/');
    }
    $stocks_symbol = substr($requested_url, $start_pos_symbol);
    $end_pos_symbol = strpos($stocks_symbol, '/');
    if ($end_pos_symbol !== false) {
        $stocks_symbol = substr($stocks_symbol, 0, $end_pos_symbol);
    }
    $stocks_symbol = strtolower(trim($stocks_symbol));
    if ($redirect_mappings[$stocks_symbol]['name']?? false) {
        $redirect_slug = $redirect_mappings[$stocks_symbol]['name'] . '-share-price';
        if ($getfirstpath[2] == 'etf') {
            if ($getfirstpath[4] !== $redirect_slug || preg_match('/[A-Z]/', $getfirstpath[3])) {
                custom_redirect();
            }
        } else {
            if ($getfirstpath[3] !== $redirect_slug  || preg_match('/[A-Z]/', $getfirstpath[2]) ) {
                custom_redirect();
            }
        }
    } else {
        error_log('Symbol not found');
        $not_found_url = home_url("/stock-not-found");
        wp_redirect($not_found_url, 301);
        exit();
    }
} else {
    error_log('Not us-stocks');
}

function custom_redirect() {
    $requested_url = $_SERVER['REQUEST_URI'];
    $home_url = parse_url(home_url(), PHP_URL_PATH);
    $path = substr($requested_url, strlen($home_url));
    $getfirstpath = explode("/", $path);

    if ($getfirstpath[1] == 'us-stocks') {
        $redirect_mappings = get_data_from_stocks_list();
        if ($getfirstpath[2] == 'etf') {
            $start_pos_symbol = strpos($requested_url, '/us-stocks/etf/') + strlen('/us-stocks/etf/');
        } else {
            $start_pos_symbol = strpos($requested_url, '/us-stocks/') + strlen('/us-stocks/');
        }

        $stocks_symbol = substr($requested_url, $start_pos_symbol);
        $end_pos_symbol = strpos($stocks_symbol, '/');
        if ($end_pos_symbol !== false) {
            $stocks_symbol_draft = substr($stocks_symbol, 0, $end_pos_symbol);
            $stocks_symbol = strtolower($stocks_symbol_draft);
        }
        $stocks_symbol = strtolower(trim($stocks_symbol));
        
        if (array_key_exists($stocks_symbol, $redirect_mappings) || preg_match('/[A-Z]/', $getfirstpath[3])) {
            $new_slug = $redirect_mappings[$stocks_symbol]['name'];
            if ($redirect_mappings[$stocks_symbol]['type'] == 'etf') {
                $new_url = home_url("/us-stocks/etf/{$stocks_symbol}/{$new_slug}-share-price/");
            } else {
                $new_url = home_url("/us-stocks/{$stocks_symbol}/{$new_slug}-share-price/");
            }

            wp_redirect($new_url, 301);
            exit();
        } else {
            $not_found_url = home_url("/stock-not-found");
            wp_redirect($not_found_url, 301);
            exit();
        }
    }
}

function get_data_from_stocks_list() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'stocks_list';
    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    $redirect_mappings = array();
    foreach ($results as $row) {
        $symbol = strtolower(trim($row['symbol']));
        $name = strtolower($row['name']);
        $name = str_replace([' ', ','], '-', $name);
        $name = preg_replace('/[^a-zA-Z0-9\-]/', '', $name);
        $name = preg_replace('/-+/', '-', $name);
        $name = trim($name, '-');
        $type = strtolower($row['type']);
        $redirect_mappings[$symbol] = ['name'=>$name,'type'=>$type];
    }
    return $redirect_mappings;
}


// ============================================================================================

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
// add_filter('wpseo_canonical', 'custom_wpseo_opengraph_url', 10, 1);


function custom_wpseo_opengraph_image($image) {
    $stock_image_value = get_query_var('custom_stock_image_value');
    if ($stock_image_value) {
        $image = $stock_image_value;
    }
    return $image;
}
// add_filter('wpseo_opengraph_image', 'custom_wpseo_opengraph_image', 10, 1);
add_filter('wpseo_twitter_image', 'custom_wpseo_opengraph_image', 10, 1);

function prefix_filter_canonical_example( $canonical ) {
    $stock_url_value = get_query_var('custom_stock_url_value');
    if ($stock_url_value) {
        $canonical = $stock_url_value;
    }
  
    return $canonical;
}
  
add_filter( 'wpseo_canonical', 'prefix_filter_canonical_example' );

add_action('wpseo_head', 'add_extra_og', 10);

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
    $custom_urls = array(
        '<sitemap><loc>' . home_url('/us-stocks-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>',
        '<sitemap><loc>' . home_url('/us-stocks-etf-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>'
    );
    
    // Append each custom URL to the sitemap index
    foreach ($custom_urls as $url) {
        $sitemap_index .= $url;
    }
    
    return $sitemap_index;
}
add_filter('wpseo_sitemap_index', 'custom_wpseo_sitemap_index', 10, 1);



function remove_unwanted_styles() {
    $stock_title_value = get_query_var('custom_stock_title_value');
    if ( $stock_title_value ) {
        wp_enqueue_style('stocks-details-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-stocks-details.css', false, '', '');
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
        wp_dequeue_style('contact-form-7');
        wp_deregister_style('contact-form-7');
        wp_dequeue_style('astra-contact-form-7');
        wp_deregister_style('astra-contact-form-7');
        wp_dequeue_style('ivory-search-styles');
        wp_deregister_style('ivory-search-styles');
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
        wp_dequeue_style('fontawesome');
        wp_deregister_style('fontawesome');
        wp_dequeue_style('wp-block-library');
        wp_deregister_style('wp-block-library');
        wp_dequeue_style('megamenu');
        wp_deregister_style('megamenu');
        wp_dequeue_style('header-style');
        wp_deregister_style('header-style');
        wp_dequeue_style('footer-style');
        wp_deregister_style('footer-style');
        // wp_dequeue_style('astra-theme-css');
        // wp_deregister_style('astra-theme-css');

        wp_dequeue_script('slick-carousel');
        wp_deregister_script('slick-carousel');
        wp_dequeue_script('custom-slick-slider');
        wp_deregister_script('custom-slick-slider');
        wp_dequeue_script('script-js');
        wp_deregister_script('script-js');
        wp_dequeue_script('moengage-ajax-script');
        wp_deregister_script('moengage-ajax-script');
        wp_dequeue_script('swv');
        wp_deregister_script('swv');
        wp_dequeue_script('contact-form-7');
        wp_deregister_script('contact-form-7');
        wp_dequeue_script('hoverIntent');
        wp_deregister_script('hoverIntent');
        wp_dequeue_script('ivory-search-scripts');
        wp_deregister_script('ivory-search-scripts');
        wp_dequeue_script('header-js');
        wp_deregister_script('header-js');
        wp_dequeue_script('footer-js');
        wp_deregister_script('footer-js');
        wp_dequeue_script('astra-theme-js');
        wp_deregister_script('astra-theme-js');
    } else {
        error_log('Dequeue function Else');
    }
}
add_action('wp_enqueue_scripts', 'remove_unwanted_styles', 99999999999);

?>
