<?php
    function enqueue_custom_assets() {

        wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all');

        // Enqueue the Slick Carousel CSS files from the CDN
        wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.8.1', 'all');
        wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), '1.8.1', 'all');

        // Enqueue the Slick Carousel JS file from the CDN
        wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true);
    
        // Enqueue your custom JavaScript file
        wp_enqueue_script('custom-slick-slider', get_stylesheet_directory_uri() . '/assets/js/slick-slider.js', array('jquery'), '1.0.0', true);
    
        wp_enqueue_style('newsletter-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-newsletter.css', false, '', '');
        wp_enqueue_style('sub-category-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-sub-category.css', false, '', '');
        wp_enqueue_style('blog-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-blog.css', false, '', '');
        wp_enqueue_style('header-style', get_stylesheet_directory_uri() . '/assets/css/header.css', false, '', '');
        wp_enqueue_style('footer-style', get_stylesheet_directory_uri() . '/assets/css/footer.css', false, '', '');
        wp_enqueue_style('module-style', get_stylesheet_directory_uri() . '/assets/css/module.css', false, '', '');
        wp_enqueue_script('header-js', get_stylesheet_directory_uri() . '/assets/js/header.js');
        wp_enqueue_script('footer-js', get_stylesheet_directory_uri() . '/assets/js/footer.js');
        wp_enqueue_script('script-js', get_stylesheet_directory_uri() . '/assets/js/script.js');
        if ( is_page_template( 'templates/page-home-page.php') ) {
            wp_enqueue_style('home-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-home-page.css', false, '', '');
            wp_enqueue_script('home-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-home-page.js');
        }
        if (is_page_template('templates/page-p2p-edge.php')) {
            wp_enqueue_style('edge-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-edge.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('edge-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-edge.js');
        }

        if (is_page_template('templates/page-calculators.php')) {
            wp_enqueue_style('culators-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-calculators.css', false, '', '');
        
        }
        if (is_page_template('templates/page-edge.php')) {
            wp_enqueue_style('edge-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-edge.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('edge-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-edge.js');
        }
        if (is_page_template('templates/page-inr-bonds.php')) {
            wp_enqueue_style('inr-bonds-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-inr-bonds.css', false, '', '');
            wp_enqueue_script('inr-bonds-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-inr-bonds.js');
        }
        if (is_page_template('templates/page-calculator.php')) {
            wp_enqueue_style('calculator-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-calc.css', false, '', '');
            wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', false, '', '');
            wp_enqueue_script('calculator-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-calc.js');
            wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
        }
        if (is_page_template('templates/page-us-stock-india.php') || is_page_template('templates/page-us-stock-india-copy.php')) {
            wp_enqueue_style('us-stock-india-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-us-stock-india.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('us-stock-india-page-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-us-stock-india.js');
        }
        if (is_page_template('templates/page-us-stock-global.php')) {
            wp_enqueue_style('us-stock-global-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-us-stocks-global.css', false, '', '');
            wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', false, '', '');
            wp_enqueue_script('progressbar-js', 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.1/progressbar.min.js');
            wp_enqueue_script('us-stock-global-page-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-us-stocks-global.js');
            wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
        }
        if (is_page_template('templates/page-pricing-global.php') || is_page_template('templates/page-pricing-india.php')) {
            wp_enqueue_style('pricing-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-pricing.css', false, '', '');
            wp_enqueue_script('pricing-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-pricing.js');
        }
        if (is_page_template('templates/page-our-story.php')) {
            wp_enqueue_style('our-story-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-our-story.css', false, '', '');
            wp_enqueue_script('our-story-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-our-story.js');
        }
        if (is_page_template('templates/page-solar.php')) {
            wp_enqueue_style('solar-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-solar.css', false, '', '');
            wp_enqueue_script('solar-page-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-solar.js');
        }
        if (is_page_template('templates/page-calculator-sip-lumpsum.php')) {
            wp_enqueue_style('sip-lumpsum-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-sip-lumpsum-calculator.css', false, '', '');
        }
        if (is_page_template('templates/page-c2c-landing.php')) {
            wp_enqueue_style('c2c-landing-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-c2c-landing.css', false, '', '');
            wp_enqueue_script('c2c-landing-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-c2c-landing.js');
        }
        if(is_page_template('templates/page-partners.php')) {
            wp_enqueue_style('partners-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-partners.css', false, '', '');
        }
        if(is_page_template('templates/page-partner-program-faqs.php')) {
            wp_enqueue_style('partners-faqs-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-partner-program-faqs.css', false, '', '');
        }
        if (is_page_template('templates/page-stock-collections.php') || (is_singular('collections'))) {
            wp_enqueue_style('stock-collection-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-stocks-collections.css', false, '', '');
            wp_enqueue_script('stock-collection-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-stock-collection.js');
        }
        if (is_singular('partners')) {
            wp_enqueue_style('partners-single-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-partner-single.css', false, '', '');
            wp_enqueue_script('partners-single-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-partner-single.js');
        }
        if (is_page_template('templates/page-us.php')) {
            wp_enqueue_style('gi-joe-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-us.css', false, '', '');
            wp_enqueue_script('gi-joe-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-us.js');
        }
        if (is_page_template('templates/page-global-mutual-funds.php')) {
            wp_enqueue_style('global-funds-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-global-mutual-funds.css', false, '', '');
            wp_enqueue_script('global-funds-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-global-mutual-funds.js');
        }
        if (is_page_template('templates/page-new-partner.php')) {
            wp_enqueue_style('new-partner-css', get_stylesheet_directory_uri() . '/assets/css/templates/css-new-partner.css', false, '', '');
            wp_enqueue_script('new-partner-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-new-partner.js');
        }
        if (is_page_template('templates/page-partner-landing-v3.php')) {
            wp_enqueue_style('partner-landing-v3-css', get_stylesheet_directory_uri() . '/assets/css/templates/css-partner-landing-v3.css', false, '', '');
            wp_enqueue_script('partner-landing-v3-js', get_stylesheet_directory_uri() . '/assets/js/templates/js-partner-landing-v3.js');
        }
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_assets');
?>