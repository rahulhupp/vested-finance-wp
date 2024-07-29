<?php
    function custom_bond_query_vars($vars) {
        $vars[] = 'custom_bond_request';
        $vars[] = 'bond_company';
        $vars[] = 'isin';
        return $vars;
    }
    add_filter('query_vars', 'custom_bond_query_vars');

    function custom_bond_rewrite_rules() {
        add_rewrite_rule(
            '^bond/([^/]+)/([^/]+)/?$',
            'index.php?custom_bond_request=1&bond_company=$matches[1]&isin=$matches[2]',
            'top'
        );
    }
    add_action('init', 'custom_bond_rewrite_rules');

    function custom_bond_template_redirect() {
        $custom_bond_request = get_query_var('custom_bond_request');
        $bond_company = get_query_var('bond_company');
        $isin_code = get_query_var('isin');

        if ($custom_bond_request) {
            
            
            // $api_url = 'https://yield-api-prod.vestedfinance.com/bonds';
            // $response = wp_remote_get($api_url);
            // $body = wp_remote_retrieve_body($response);
            // $data = json_decode($body, true);
            // $bond_found = false;
            // if (isset($data['status']) && $data['status'] === 'SUCCESS' && isset($data['bonds']) && is_array($data['bonds'])) {
            //     foreach ($data['bonds'] as $bond) {
            //         $issuer_name_slug = sanitize_title($bond['displayName']);
            //         $securityCode = strtolower($bond['securityId']);
            //         if ($issuer_name_slug  == $bond_company && $securityCode == $isin_code) {
            //             $bond_found = true;
            //             break;
            //         }
            //     }
            // }
            global $wpdb;
            $table_name = $wpdb->prefix . 'bonds_list';

            // Query to get bonds data from the database
            $bonds = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

            $bond_found = false;

            foreach ($bonds as $bond) {
                $issuer_name_slug = sanitize_title($bond['displayName']);
                $securityCode = strtolower($bond['securityId']);
                if ($issuer_name_slug == $bond_company && $securityCode == $isin_code) {
                    $bond_found = true;
                    error_log("2 Custom bond request: $custom_bond_request, Bond company: $bond_company, ISIN code: $isin_code");
                    break;
                }
            }

            if ($bond_found) {
                include get_stylesheet_directory() . '/templates/page-bonds-details.php';
            } else {
                wp_redirect(home_url('/bond-not-found'));
            }
            exit();
        } else {
            error_log("Custom bond request not set.");
        }
    }
    add_action('template_redirect', 'custom_bond_template_redirect');


    function add_wanted_styles() {
        $bond_name_slug = get_query_var('bond_company');
        if($bond_name_slug) {
            wp_enqueue_style('bonds-details-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-bonds-details.css', false, '', '');
        }
        
    }
    add_action('wp_enqueue_scripts', 'add_wanted_styles', 99999999999);

    function formatIndianCurrency($num) {
        // Convert the number to an integer to remove decimal points
        $intPart = (int)$num;
    
        // Format the integer part according to the Indian numbering system
        $lastThree = substr($intPart, -3);  // Last three digits
        $remainingDigits = substr($intPart, 0, -3);  // Remaining digits
    
        if ($remainingDigits != '') {
            $lastThree = ',' . $lastThree;
        }
    
        // Add commas after every 2 digits from the end of the remaining digits
        $formattedIntPart = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . $lastThree;
    
        return '₹' . $formattedIntPart;  // Prepend the Rupee symbol
    }
    
?>