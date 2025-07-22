<?php
function custom_bond_query_vars($vars)
{
    $vars[] = 'custom_bond_request';
    $vars[] = 'bondCategory';
    $vars[] = 'issuerName';
    $vars[] = 'securityId';
    return $vars;
}
add_filter('query_vars', 'custom_bond_query_vars');

function custom_bond_rewrite_rules()
{
    add_rewrite_rule(
        '^in/inr-bonds/(government-bonds|corporate-bonds)/([^/]+)/([^/]+)/?$',
        'index.php?custom_bond_request=1&bondCategory=$matches[1]&issuerName=$matches[2]&securityId=$matches[3]',
        'top'
    );
}
add_action('init', 'custom_bond_rewrite_rules');

function custom_bond_template_redirect()
{
    $custom_bond_request = get_query_var('custom_bond_request');
    $bondCategory = get_query_var('bondCategory');
    $issuerName = get_query_var('issuerName');
    $securityId = get_query_var('securityId');
    if ($custom_bond_request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bonds_list';

        $internalBondCategory = ($bondCategory == 'government-bonds') ? 'GOVT' : 'CORPORATE';

        $bonds = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        $bond_found = false;

        foreach ($bonds as $bond) {
            $issuer_name_slug = sanitize_title($bond['issuerName']);
            $security_code = strtolower($bond['securityId']);
            if ($issuer_name_slug == $issuerName && $security_code == $securityId && $bond['bondCategory'] == $internalBondCategory) {
                $bond_found = true;
                // error_log("Custom bond request: $custom_bond_request, Bond category: $bondCategory, Issuer name: $issuerName, Security ID: $securityId");
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
       // error_log("Custom bond request not set.");
    }
}
add_action('template_redirect', 'custom_bond_template_redirect');


function add_wanted_styles()
{
    $bond_name_slug = get_query_var('securityId');
    if ($bond_name_slug) {
        wp_enqueue_style('bonds-details-page-style', get_stylesheet_directory_uri() . '/assets/css/templates/css-bonds-details.css', false, '', '');
    }
}
add_action('wp_enqueue_scripts', 'add_wanted_styles', 99999999999);

function formatIndianCurrency($num)
{
    $intPart = (int)$num;

    $lastThree = substr($intPart, -3);
    $remainingDigits = substr($intPart, 0, -3);

    if ($remainingDigits != '') {
        $lastThree = ',' . $lastThree;
    }

    $formattedIntPart = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . $lastThree;

    return '₹' . $formattedIntPart;
}
function custom_bonds_wpseo_title($title) {
    $custom_bond_title_value = get_query_var('custom_bond_title_value');
    $isincode = get_query_var('custom_bond_security_id');
    $coupon = get_query_var('custom_bond_coupon_rate');
    if ( $custom_bond_title_value ) {
        $title = $custom_bond_title_value . " Coupon " . $coupon . "% INE - " . $isincode;
    }
    return $title;
}
add_filter('wpseo_title', 'custom_bonds_wpseo_title', 10, 1);
add_filter('wpseo_opengraph_title', 'custom_bonds_wpseo_title', 10, 1);
add_filter('wpseo_twitter_title', 'custom_bonds_wpseo_title', 10, 1);
add_filter('wpseo_twitter_image_alt', 'custom_bonds_wpseo_title', 10, 1);


function custom_bonds_wpseo_metadesc($description) {
    $bond_description_value = get_query_var('custom_bond_description');
    if ($bond_description_value) {
        $description = $bond_description_value;
    }
    return $description;
}
add_filter('wpseo_metadesc', 'custom_bonds_wpseo_metadesc', 10, 1);
add_filter('wpseo_twitter_description', 'custom_bonds_wpseo_metadesc', 10, 1);