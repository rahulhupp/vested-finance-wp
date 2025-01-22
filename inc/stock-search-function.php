<?php
add_action('rest_api_init', function () {
    register_rest_route('api', '/stocks', [
        'methods' => 'GET',
        'callback' => 'fetch_stocks',
    ]);
});

function fetch_stocks(WP_REST_Request $request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'stocks_list';
    $query = sanitize_text_field($request->get_param('query'));
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE symbol LIKE %s OR name LIKE %s",
        "$query%",
        "$query%"
    ), ARRAY_A);
    return rest_ensure_response($results);
}
