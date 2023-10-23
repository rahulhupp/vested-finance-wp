<?php
    function enqueue_custom_assets() {
        // Enqueue the Slick Carousel CSS files from the CDN
        wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.8.1', 'all');
        wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), '1.8.1', 'all');

        // Enqueue the Slick Carousel JS file from the CDN
        wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true);
    
        // Enqueue your custom JavaScript file
        wp_enqueue_script('custom-slick-slider', get_stylesheet_directory_uri() . '/assets/js/slick-slider.js', array('jquery'), '1.0.0', true);
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_assets');
?>