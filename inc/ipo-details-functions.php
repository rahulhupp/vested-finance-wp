<?php
function ipo_custom_query_vars($vars)
{
    $vars[] = 'custom_ipo_request';
    $vars[] = 'ipo_slug';
    return $vars;
}
add_filter('query_vars', 'ipo_custom_query_vars');


function ipo_custom_rewrite_rules()
{
    add_rewrite_rule(
        '^in/pre-ipo/([^/]+)/?$',
        'index.php?custom_ipo_request=1&ipo_slug=$matches[1]',
        'top'
    );
}
add_action('init', 'ipo_custom_rewrite_rules');

// Force flush rewrite rules now
function force_flush_ipo_rewrite_rules() {
    ipo_custom_rewrite_rules();
    flush_rewrite_rules();
}
add_action('init', 'force_flush_ipo_rewrite_rules', 1);


function ipo_custom_template_redirect()
{
    $custom_ipo_request = get_query_var('custom_ipo_request');
    $ipo_slug = get_query_var('ipo_slug');
    
    if ($custom_ipo_request && $ipo_slug) {
        // Get IPO ID by slug
        $ipo_id = get_ipo_id_by_slug($ipo_slug);
        
        if ($ipo_id) {
            // Get IPO data
            global $wpdb;
            $table_name = $wpdb->prefix . 'ipo_list';
            $ipo_exists = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_name WHERE ipo_id = %s",
                $ipo_id
            ));
            
            if ($ipo_exists) {
                // Set IPO ID for template and API calls
                set_query_var('ipo_id', $ipo_id);
                set_query_var('custom_ipo_title_value', $ipo_exists->name);
                include get_stylesheet_directory() . '/templates/page-ipo-details.php';
                exit();
            }
        }
        
        // IPO not found, redirect to 404 or custom page
        $not_found_url = home_url("/ipo-not-found");
        wp_redirect($not_found_url, 301);
        exit();
    }
}
add_action('template_redirect', 'ipo_custom_template_redirect');

// Function to get IPO data from database with new URL structure
function get_ipo_data_from_list()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ipo_list';
    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    $ipo_mappings = array();
    foreach ($results as $row) {
        $id = $row['ipo_id'];
        $slug = generate_ipo_slug($row['name']);
        $ipo_mappings[$id] = [
            'name' => $slug, 
            'original_name' => $row['name'],
            'url' => home_url('/in/pre-ipo/' . $slug . '/')
        ];
    }
    return $ipo_mappings;
}

/**
 * Generate URL-friendly slug from company name
 */
function generate_ipo_slug($name) {
    // Convert to lowercase
    $slug = strtolower($name);
    
    // Replace spaces and special characters with hyphens
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    
    // Remove leading/trailing hyphens
    $slug = trim($slug, '-');
    
    // Limit length
    if (strlen($slug) > 100) {
        $slug = substr($slug, 0, 100);
        $slug = rtrim($slug, '-');
    }
    
    return $slug;
}

/**
 * Get IPO ID by slug
 */
function get_ipo_id_by_slug($slug) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ipo_list';
    
    // Get all IPOs and find by slug
    $results = $wpdb->get_results("SELECT ipo_id, name FROM $table_name");
    
    foreach ($results as $ipo) {
        $ipo_slug = generate_ipo_slug($ipo->name);
        if ($ipo_slug === $slug) {
            return $ipo->ipo_id;
        }
    }
    
    return false;
}



function remove_unwanted_for_ipo_styles()
{
    $custom_ipo_request = get_query_var('custom_ipo_request');
    if ($custom_ipo_request) {
        wp_enqueue_style('ipo-details-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-ipo-details.css', false, '', '');
        wp_enqueue_script('ipo-details-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-ipo-details.js', array(), null, true);
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
add_action('wp_enqueue_scripts', 'remove_unwanted_for_ipo_styles', 99999999999);

function format_human_readable_number($number) {
    if ($number >= 1_000_000_000_000) {
        return number_format($number / 1_000_000_000_000, ($number % 1_000_000_000_000 ? 1 : 0)) . 'T';
    } elseif ($number >= 1_000_000_000) {
        return number_format($number / 1_000_000_000, ($number % 1_000_000_000 ? 1 : 0)) . 'B';
    } elseif ($number >= 1_000_000) {
        return number_format($number / 1_000_000, ($number % 1_000_000 ? 1 : 0)) . 'M';
    } elseif ($number >= 1_000) {
        return number_format($number / 1_000, ($number % 1_000 ? 1 : 0)) . 'K';
    } else {
        return (string)$number;
    }
}

function get_typoform_link_by_ipo_id($ipo_id) {
    if (have_rows('ipo_typoform_links', 'option')) {
        while (have_rows('ipo_typoform_links', 'option')) {
            the_row();
            $stored_ipo_id = get_sub_field('ipo_id');
            if ($stored_ipo_id === $ipo_id) {
                return get_sub_field('typoform_link');
            }
        }
    }
    return false;
}