<?php
    function enqueue_custom_assets() {
        // Enqueue the Slick Carousel CSS files from the CDN
        wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.8.1', 'all');
        wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), '1.8.1', 'all');

        // Enqueue the Slick Carousel JS file from the CDN
        wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true);
    
        // Enqueue your custom JavaScript file
        wp_enqueue_script('custom-slick-slider', get_stylesheet_directory_uri() . '/assets/js/slick-slider.js', array('jquery'), '1.0.0', true);
    
        
        wp_enqueue_style('header-style', get_stylesheet_directory_uri() . '/assets/css/header.css', false, '', '');
        wp_enqueue_script('header-js', get_stylesheet_directory_uri() . '/assets/js/header.js');
        wp_enqueue_style('pricing-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-pricing.css', false, '', '');
        wp_enqueue_script('pricing-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-pricing.js');

        if ( is_page_template( 'page-home-page.php') ) {
            wp_enqueue_style('home-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-home-page.css', false, '', '');
            wp_enqueue_script('home-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-home-page.js');
        }
        if (is_page_template('page-edge.php')) {
            wp_enqueue_style('edge-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-edge.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('edge-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-edge.js');
        }
        if (is_page_template('page-inr-bonds.php')) {
            wp_enqueue_style('inr-bonds-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-inr-bonds.css', false, '', '');
            wp_enqueue_script('inr-bonds-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-inr-bonds.js');
        }
        if (is_page_template('page-calculator.php')) {
            wp_enqueue_style('calculator-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-calc.css', false, '', '');
            wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', false, '', '');
            wp_enqueue_script('calculator-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-calc.js');
            wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
        }
        if (is_page_template('page-us-stock-india.php')) {
            wp_enqueue_style('us-stock-india-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-us-stock-india.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('us-stock-india-page-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-us-stock-india.js');
        }
        if (is_page_template('page-us-stock-global.php')) {
            wp_enqueue_style('us-stock-global-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-us-stocks-global.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('us-stock-global-page-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-us-stocks-global.js');
        }
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_assets');
?>