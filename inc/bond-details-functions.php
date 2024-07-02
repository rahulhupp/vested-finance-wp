<?php
    function custom_bond_query_vars($vars) {
        $vars[] = 'custom_bond_request';
        $vars[] = 'bond_company';
        return $vars;
    }
    add_filter('query_vars', 'custom_bond_query_vars');

    function custom_bond_rewrite_rules() {
        add_rewrite_rule(
            '^bond/([^/]+)/?$',
            'index.php?custom_bond_request=1&bond_company=$matches[1]',
            'top'
        );
    }
    add_action('init', 'custom_bond_rewrite_rules');

    function custom_bond_template_redirect() {
        $custom_bond_request = get_query_var('custom_bond_request');
        $bond_company = get_query_var('bond_company');

        if ($custom_bond_request) {
            error_log("Custom bond request: $custom_bond_request, Bond company: $bond_company");
            include get_stylesheet_directory() . '/templates/page-bonds-details.php';
            exit();
        } else {
            error_log("Custom bond request not set.");
        }
    }
    add_action('template_redirect', 'custom_bond_template_redirect');



    function add_wanted_styles() {
        wp_enqueue_style('bonds-details-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-bonds-details.css', false, '', '');
        
    }
    add_action('wp_enqueue_scripts', 'add_wanted_styles', 99999999999);
    
?>