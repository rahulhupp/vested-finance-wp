<?php

/**
 * STAGING ONLY: Exclude IPO pages from PPWP password protection
 * 
 * This functionality is only needed for staging environment where PPWP is active.
 * When going live, this code can be safely removed as PPWP won't be active.
 */
function exclude_ipo_pages_from_password_protection() {
    // Check if we're on an IPO page
    $custom_ipo_request = get_query_var('custom_ipo_request');
    $ipo_slug = get_query_var('ipo_slug');
    
    // Check if we're on the IPO landing page
    $current_page_template = get_page_template_slug();
    $is_ipo_landing_page = ($current_page_template === 'templates/page-ipo-landing.php');
    
    // Check if current URL contains IPO-related paths
    $current_url = $_SERVER['REQUEST_URI'] ?? '';
    $is_ipo_url = (
        ($custom_ipo_request && $ipo_slug) || 
        $is_ipo_landing_page ||
        strpos($current_url, '/in/pre-ipo/') !== false ||
        strpos($current_url, '/ipo-') !== false
    );
    
    if ($is_ipo_url) {
        // Bypass sitewide authentication check for IPO pages
        add_filter('ppwp_bypass_sitewide_authentication_check', '__return_true', 10, 2);
        
        // Prevent password form from rendering on IPO pages
        add_filter('ppwp_should_render_password_form', '__return_false');
        
        // Bypass post password requirement for IPO pages
        add_filter('post_password_required', '__return_false', 999);
        
        // Also bypass any individual page protection for IPO pages
        add_filter('ppw_is_valid_permission', '__return_true', 999, 2);
    }
}

/**
 * STAGING ONLY: Use PPWP's own hook to prevent form rendering for IPO pages
 */
function prevent_ppwp_form_for_ipo_pages($should_render) {
    $current_url = $_SERVER['REQUEST_URI'] ?? '';
    
    if (strpos($current_url, '/in/pre-ipo/') !== false || 
        strpos($current_url, '/ipo-') !== false) {
        return false; // Don't render the password form
    }
    
    return $should_render;
}

/**
 * STAGING ONLY: Early IPO detection and bypass
 * This runs before template_redirect to catch IPO pages early
 */
function early_ipo_bypass() {
    $current_url = $_SERVER['REQUEST_URI'] ?? '';
    
    if (strpos($current_url, '/in/pre-ipo/') !== false || 
        strpos($current_url, '/ipo-') !== false) {
        
        // Apply all bypasses immediately with high priority
        add_filter('ppwp_bypass_sitewide_authentication_check', '__return_true', 1, 2);
        add_filter('ppwp_should_render_password_form', '__return_false', 1);
        add_filter('post_password_required', '__return_false', 1);
        add_filter('ppw_is_valid_permission', '__return_true', 1, 2);
        add_filter('ppwp_apply_password_for_entire_site', '__return_false', 1);
        add_filter('ppw_before_render_form_entire_site', '__return_false', 1);
    }
}

// STAGING ONLY: Apply the IPO exclusion
add_action('init', 'early_ipo_bypass', 1);
add_action('template_redirect', 'exclude_ipo_pages_from_password_protection', 5);
add_filter('ppw_before_render_form_entire_site', 'prevent_ppwp_form_for_ipo_pages', 1);

?>