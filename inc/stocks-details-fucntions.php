<?php
function custom_query_vars($vars)
{
    $vars[] = 'custom_stock_request';
    $vars[] = 'symbol';
    $vars[] = 'company';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');


function custom_rewrite_rules()
{
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
    $current_url_path = rtrim($_SERVER['REQUEST_URI'], '/'); // Remove trailing slash for consistency
    // error_log('Current URL Path: ' . $current_url_path);
}
add_action('init', 'custom_rewrite_rules');


function custom_template_redirect()
{
    $requested_url = $_SERVER['REQUEST_URI'];
    $custom_stock_request = get_query_var('custom_stock_request');
    $symbol = get_query_var('symbol');
    $company = get_query_var('company');
    // error_log('requested url: ' . $requested_url);

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
    if ($redirect_mappings[$stocks_symbol]['name'] ?? false) {
        $redirect_slug = $redirect_mappings[$stocks_symbol]['name'] . '-share-price';
        if ($getfirstpath[2] == 'etf') {
            if ($getfirstpath[4] !== $redirect_slug || preg_match('/[A-Z]/', $getfirstpath[3])) {
                custom_redirect();
            }
        } else {
            if ($getfirstpath[3] !== $redirect_slug  || preg_match('/[A-Z]/', $getfirstpath[2])) {
                custom_redirect();
            }
        }
    } else {
        $prefixes = [
            '/us-stocks/collections/',
            '/in/us-stocks/collections/',
        ];
        $is_valid_prefix = false;
        foreach ($prefixes as $prefix) {
            if (strpos($requested_url, $prefix) === 0) {
                $is_valid_prefix = true;
                return;
            }
        }
        if ($is_valid_prefix) {
      // error_log('ETF IF');
        } else {
      // error_log('Symbol not found');
            $not_found_url = home_url("/stock-not-found");
            wp_redirect($not_found_url, 301);
            exit();
        }
    }
} else {
    // error_log('Not us-stocks');
}

function custom_redirect()
{
    $requested_url = $_SERVER['REQUEST_URI'];
    $prefixes = [
        '/us-stocks/collections/',
        '/in/us-stocks/collections/',
    ];
    foreach ($prefixes as $prefix) {
        if (strpos($requested_url, $prefix) === 0) {
            return;
        }
    }
    $home_url = parse_url(home_url(), PHP_URL_PATH);
    $path = substr($requested_url, strlen($home_url));
    $getfirstpath = explode("/", $path);

    if ($getfirstpath[1] == 'us-stocks') {
        $prefixes = [
            '/us-stocks/collections/',
            '/in/us-stocks/collections/',
        ];
        $is_valid_prefix = false;
        foreach ($prefixes as $prefix) {
            if (strpos($requested_url, $prefix) === 0) {
                $is_valid_prefix = true;
                return;
            }
        }
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

        if (array_key_exists($stocks_symbol, $redirect_mappings) || preg_match('/[A-Z]/', $getfirstpath[2])) {
            $new_slug = $redirect_mappings[$stocks_symbol]['name'];
            if ($redirect_mappings[$stocks_symbol]['type'] == 'etf') {
                $new_url = home_url("/us-stocks/etf/{$stocks_symbol}/{$new_slug}-share-price/");
            } else {
                $new_url = home_url("/us-stocks/{$stocks_symbol}/{$new_slug}-share-price/");
            }

            wp_redirect($new_url, 301);
            exit();
        } else {
            $current_url_path = $_SERVER['REQUEST_URI'];
      // error_log('ETF Not Current URL Path: ' . $current_url_path);
            if ($is_valid_prefix) {
          // error_log('ETF IF');
            } else {
          // error_log('Symbol not found');
                $not_found_url = home_url("/stock-not-found");
                wp_redirect($not_found_url, 301);
                exit();
            }
        }
    }
}

function get_data_from_stocks_list()
{
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
        $redirect_mappings[$symbol] = ['name' => $name, 'type' => $type];
    }
    return $redirect_mappings;
}


// ============================================================================================

function custom_wpseo_title($title)
{
    $custom_stock_title_value = get_query_var('custom_stock_title_value');
    if ($custom_stock_title_value) {
        $title = $custom_stock_title_value;
    }
    return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_opengraph_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_twitter_title', 'custom_wpseo_title', 10, 1);
add_filter('wpseo_twitter_image_alt', 'custom_wpseo_title', 10, 1);

function custom_wpseo_metadesc($description)
{
    $stock_description_value = get_query_var('custom_stock_description_value');
    if ($stock_description_value) {
        $description = $stock_description_value;
    }
    return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc', 10, 1);
// add_filter('wpseo_opengraph_description', 'custom_wpseo_metadesc', 10, 1);
add_filter('wpseo_twitter_description', 'custom_wpseo_metadesc', 10, 1);

function custom_wpseo_opengraph_url($url)
{
    $stock_url_value = get_query_var('custom_stock_url_value');
    if ($stock_url_value) {
        $url = $stock_url_value;
    }
    return $url;
}
add_filter('wpseo_opengraph_url', 'custom_wpseo_opengraph_url', 10, 1);
// add_filter('wpseo_canonical', 'custom_wpseo_opengraph_url', 10, 1);


function custom_wpseo_opengraph_image($image)
{
    $stock_image_value = get_query_var('custom_stock_image_value');
    if ($stock_image_value) {
        $image = $stock_image_value;
    }
    return $image;
}
// add_filter('wpseo_opengraph_image', 'custom_wpseo_opengraph_image', 10, 1);
add_filter('wpseo_twitter_image', 'custom_wpseo_opengraph_image', 10, 1);

function prefix_filter_canonical_example($canonical)
{
    $stock_url_value = get_query_var('custom_stock_url_value');
    if ($stock_url_value) {
        $canonical = $stock_url_value;
    }

    return $canonical;
}

add_filter('wpseo_canonical', 'prefix_filter_canonical_example');

add_action('wpseo_head', 'add_extra_og', 10);

function add_extra_og()
{
    $stock_image_value = get_query_var('custom_stock_image_value');
    if ($stock_image_value) {
        $image = $stock_image_value;
        echo '<meta property="og:image" content="' . $image . '" />';
    }
    $stock_description_value = get_query_var('custom_stock_description_value');
    if ($stock_description_value) {
        $description = $stock_description_value;
        echo '<meta property="og:description" content="' . $description . '" />';
    }
}

function custom_wpseo_twitter_card_type($card_type)
{
    return 'summary';
}
add_filter('wpseo_twitter_card_type', 'custom_wpseo_twitter_card_type', 10, 1);

function custom_wpseo_twitter_site($site)
{
    return '@Vested_finance';
}
add_filter('wpseo_twitter_site', 'custom_wpseo_twitter_site', 10, 1);

function custom_wpseo_sitemap_index($sitemap_index)
{
    $last_modified = date('c');
    $custom_urls = array(
        '<sitemap><loc>' . home_url('/us-stocks-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>',
        '<sitemap><loc>' . home_url('/us-stocks-etf-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>',
        '<sitemap><loc>' . home_url('/calculators-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>'
    );

    // Append each custom URL to the sitemap index
    foreach ($custom_urls as $url) {
        $sitemap_index .= $url;
    }

    return $sitemap_index;
}
add_filter('wpseo_sitemap_index', 'custom_wpseo_sitemap_index', 10, 1);



function remove_unwanted_styles()
{
    $stock_title_value = get_query_var('custom_stock_title_value');
    if ($stock_title_value) {
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
  // error_log('Dequeue function Else');
    }
}
add_action('wp_enqueue_scripts', 'remove_unwanted_styles', 99999999999);



/**
 * Convert user-friendly position selection to decimal position
 * 
 * @param mixed $position_value The position value from ACF (can be string like "after_1" or number)
 * @return float The calculated decimal position
 */
function convert_faq_position($position_value) {
    // If it's already a number, use it directly
    if (is_numeric($position_value)) {
        return floatval($position_value);
    }
    
    // Normalize the position value (trim, lowercase, remove spaces/special chars)
    $normalized = strtolower(trim($position_value));
    $normalized = preg_replace('/[^a-z0-9_]/', '', $normalized);
    
    // Handle string-based position selections with multiple possible formats
    $position_map = array(
        // Direct matches
        'beginning' => -1,
        'after_0' => 0.5,   // After 1st FAQ
        'after_1' => 1.5,   // After 2nd FAQ
        'after_2' => 2.5,   // After 3rd FAQ
        'after_3' => 3.5,   // After 4th FAQ
        'after_4' => 4.5,   // After 5th FAQ
        'after_5' => 5.5,   // After 6th FAQ
        'after_6' => 6.5,   // After 7th FAQ
        'after_7' => 7.5,   // After 8th FAQ
        'after_8' => 8.5,   // After 9th FAQ
        'after_9' => 9.5,   // After 10th FAQ
        'end' => 999,       // At the end
        // Alternative formats that might come from ACF
        'after1st' => 0.5,
        'after2nd' => 1.5,
        'after3rd' => 2.5,
        'after4th' => 3.5,
        'after5th' => 4.5,
        'after6th' => 5.5,
        'after7th' => 6.5,
        'after8th' => 7.5,
        'after9th' => 8.5,
        'after10th' => 9.5,
    );
    
    // Try normalized value first
    if (isset($position_map[$normalized])) {
        return $position_map[$normalized];
    }
    
    // Try original value (case-insensitive)
    $original_lower = strtolower(trim($position_value));
    if (isset($position_map[$original_lower])) {
        return $position_map[$original_lower];
    }
    
    // Try to extract number from strings like "after 1st", "after_1", "After 1st FAQ", etc.
    // Match patterns like: "after 1st", "after_1", "after 1", "After 1st FAQ:", etc.
    // This handles both "after_1" (meaning after FAQ at position 1) and "after 1st" (meaning after 1st FAQ at position 0)
    if (preg_match('/after[_\s]*(\d+)(?:st|nd|rd|th)?/i', $position_value, $matches)) {
        $num = intval($matches[1]);
        // Check if it's in ordinal format (1st, 2nd, 3rd, etc.)
        if (preg_match('/after[_\s]*\d+(st|nd|rd|th)/i', $position_value)) {
            // "After 1st FAQ" means after position 0, so position = (1-1) + 0.5 = 0.5
            if ($num >= 1 && $num <= 10) {
                return floatval($num - 1) + 0.5;
            }
        } else {
            // "After _1" or "after 1" means after position 1, so position = 1 + 0.5 = 1.5
            if ($num >= 0 && $num <= 9) {
                return floatval($num) + 0.5;
            }
        }
    }
    
    // Default to end if unknown
    return 999;
}

/**
 * Get custom FAQs for a specific ticker from stocks_settings_list
 * 
 * @param string $ticker The stock ticker symbol
 * @return array Array of custom FAQs with position, question, and answer
 */
function get_custom_faqs_for_ticker($ticker) {
    $custom_faqs = array();
    
    if (empty($ticker)) {
        return $custom_faqs;
    }
    
    $stocks_settings_list = get_field('meta_settings', 'option');
    
    if ($stocks_settings_list && is_array($stocks_settings_list)) {
        foreach ($stocks_settings_list as $meta_row) {
            // Check if this row matches the ticker (case-insensitive)
            if (!empty($meta_row['ticker']) && strtolower(trim($meta_row['ticker'])) === strtolower(trim($ticker))) {
                // Check if custom FAQs exist for this ticker
                if (!empty($meta_row['custom_faqs']) && is_array($meta_row['custom_faqs'])) {
                    foreach ($meta_row['custom_faqs'] as $faq) {
                        // Skip if question or answer is empty
                        $question = isset($faq['question']) ? trim($faq['question']) : '';
                        $answer = isset($faq['answer']) ? trim($faq['answer']) : '';
                        
                        if (empty($question) || empty($answer)) {
                            continue; // Skip empty FAQs
                        }
                        
                        // Convert position to decimal value
                        $position_value = !empty($faq['position']) ? $faq['position'] : 'end';
                        $calculated_position = convert_faq_position($position_value);
                        
                        $custom_faqs[] = array(
                            'position' => $calculated_position,
                            'question' => $question,
                            'answer' => $answer,
                        );
                    }
                }
                break; // Found the matching ticker, no need to continue
            }
        }
    }
    
    // Sort by position (ensure proper float comparison)
    usort($custom_faqs, function($a, $b) {
        $pos_a = floatval($a['position']);
        $pos_b = floatval($b['position']);
        if ($pos_a == $pos_b) {
            return 0;
        }
        return ($pos_a < $pos_b) ? -1 : 1;
    });
    
    return $custom_faqs;
}

/**
 * Merge static and custom FAQs based on position
 * 
 * @param array $static_faqs Array of static FAQs with their positions
 * @param array $custom_faqs Array of custom FAQs from ACF
 * @return array Merged array of FAQs sorted by position
 */
function merge_faqs($static_faqs, $custom_faqs) {
    $all_faqs = array();
    
    // Validate inputs
    if (!is_array($static_faqs)) {
        $static_faqs = array();
    }
    if (!is_array($custom_faqs)) {
        $custom_faqs = array();
    }
    
    // Add static FAQs
    foreach ($static_faqs as $index => $faq) {
        if (!isset($faq['position']) || !isset($faq['question']) || !isset($faq['answer'])) {
            continue; // Skip invalid static FAQs
        }
        
        $all_faqs[] = array(
            'position' => floatval($faq['position']),
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'is_custom' => false,
        );
    }
    
    // Add custom FAQs
    foreach ($custom_faqs as $faq) {
        if (!isset($faq['position']) || !isset($faq['question']) || !isset($faq['answer'])) {
            continue; // Skip invalid custom FAQs
        }
        
        // Skip if question or answer is empty
        if (empty(trim($faq['question'])) || empty(trim($faq['answer']))) {
            continue;
        }
        
        $all_faqs[] = array(
            'position' => floatval($faq['position']),
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'is_custom' => true,
        );
    }
    
    // Sort by position (ensure proper float comparison)
    usort($all_faqs, function($a, $b) {
        $pos_a = floatval($a['position']);
        $pos_b = floatval($b['position']);
        if ($pos_a == $pos_b) {
            return 0;
        }
        return ($pos_a < $pos_b) ? -1 : 1;
    });
    
    return $all_faqs;
}
