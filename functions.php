<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );


// Include your custom functions file from the "inc" folder
require_once get_stylesheet_directory() . '/inc/allow-svg.php';
require_once get_stylesheet_directory() . '/inc/enqueue-style-script.php';
require_once get_stylesheet_directory() . '/inc/acf-options.php';


function add_custom_js_to_pages() {
    if (is_page()) { // You can specify conditions if needed
        echo '<script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                var imgElement = document.querySelector(\'img[alt="Seraphinite Accelerator"]\');
                if (imgElement) {
                    var spanElement = imgElement.nextElementSibling;

                    if (imgElement && spanElement) {
                        imgElement.style.display = "none";
                        spanElement.style.display = "none";
                    }
                }
            });
        </script>';
    }
}

add_action('wp_footer', 'add_custom_js_to_pages');

function monthsToYearsAndMonths($months) {
    $years = floor($months / 12);
    $remainingMonths = $months % 12;

    if ($years > 0 && $remainingMonths > 0) {
        return $years . ' years ' . $remainingMonths . ' months';
    } elseif ($years > 0) {
        return $years . ' years';
    } elseif ($remainingMonths > 0) {
        return $remainingMonths . ' months';
    } else {
        return '0 months';
    }
}

// function for custom meta field for footer selection
function custom_page_meta_box() {
    add_meta_box(
        'footer-options',
        'Footer Options',
        'footer_meta_box',
        'page',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'custom_page_meta_box');


function footer_meta_box($post) {

    $custom_page_meta_value = get_post_meta($post->ID, '_custom_page_meta_key', true);
    ?>
    <p class="post-attributes-label-wrapper menu-order-label-wrapper">
        <label for="footer_options" class="post-attributes-label">Select Footer to display</label>
    </p>
    <select id="footer_options" name="footer_options">
        <option value="global-footer" <?php selected($custom_page_meta_value, 'global-footer'); ?>>Global Footer</option>
        <option value="india-market" <?php selected($custom_page_meta_value, 'india-market'); ?>>India Market</option>
        <option value="us-market" <?php selected($custom_page_meta_value, 'us-market'); ?>>US Market</option>
    </select>
    <?php
}


// save selected footer option
function save_custom_page_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['footer_options'])) {
        update_post_meta($post_id, '_custom_page_meta_key', sanitize_text_field($_POST['footer_options']));
    }
}
add_action('save_post', 'save_custom_page_meta');


if( function_exists('acf_add_options_page') ) {
        
    acf_add_options_page(array(
        'page_title'    => 'Global Footer Settings',
        'menu_title'    => 'Footer',
        'menu_slug'     => 'footer-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url' => 'dashicons-screenoptions',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'India Market Footer',
        'menu_title'    => 'India Market Footer',
        'parent_slug'   => 'footer-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'US Market Footer',
        'menu_title'    => 'US Market Footer',
        'parent_slug'   => 'footer-settings',
    ));
    
}