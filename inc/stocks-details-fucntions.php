<?php

function custom_query_vars($vars) {
    $vars[] = 'custom_stock_request';
    $vars[] = 'symbol';
    $vars[] = 'company';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');


function custom_rewrite_rules() {
    add_rewrite_rule(
        '^us-stocks/([^/]+)/([^/]+)/?$',
        'index.php?custom_stock_request=1&symbol=$matches[1]&company=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');


function custom_template_redirect() {
    $custom_stock_request = get_query_var('custom_stock_request');
    $symbol = get_query_var('symbol');
    $company = get_query_var('company');

    if ($custom_stock_request) {
        include get_stylesheet_directory() . '/templates/page-stocks-details.php';
        exit();
    } else {
        echo "Debug: Custom stock request not detected.<br>";
    }
}
add_action('template_redirect', 'custom_template_redirect');


// Function to set custom title and meta description
function custom_modify_document_title_parts($title_parts) {
    $custom_stock_title_value = get_query_var('custom_stock_title_value');
    $custom_stock_description_value = get_query_var('custom_stock_description_value');

    if ($custom_stock_title_value) {
        $title_parts = array('title' => $custom_stock_title_value);

        // Add meta description only if it hasn't been added before
        if (!has_action('wp_head', 'custom_add_meta_description')) {
            add_action('wp_head', 'custom_add_meta_description');
        }
    } else {
        echo "Debug: Custom stock title value not found<br>";
    }

    return $title_parts;
}

// Function to add meta description
function custom_add_meta_description() {
    $custom_stock_description_value = get_query_var('custom_stock_description_value');
    ?>
    <meta name="description" content="<?php echo esc_attr($custom_stock_description_value); ?>">
    <?php
}

// Hook into document_title_parts filter
add_filter('document_title_parts', 'custom_modify_document_title_parts');











?>