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
