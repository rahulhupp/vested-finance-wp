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
require_once get_stylesheet_directory() . '/inc/store-token.php';
require_once get_stylesheet_directory() . '/inc/stocks-details-fucntions.php';
require_once get_stylesheet_directory() . '/template-parts/stocks-details/fetch-stocks-api-data.php';
require_once get_stylesheet_directory() . '/template-parts/fetch-inr-bonds-api-data.php';
require_once get_stylesheet_directory() . '/inc/bond-details-functions.php';


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

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Chapter CTA',
        'menu_title' => 'Chapter CTA',
        'menu_slug'  => 'chapter-cta',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));
}


function calculate_reading_time($content)
{

    $words_per_minute = 250;

    $word_count = str_word_count(strip_tags($content));

    $reading_time = ceil($word_count / $words_per_minute);

    return $reading_time;
}


function calculate_total_reading_time_for_term($term_id)
{
    $args = array(
        'post_type' => 'module',
        'tax_query' => array(
            array(
                'taxonomy' => 'modules',
                'field' => 'term_id',
                'terms' => $term_id,
            ),
        ),
    );

    $posts = get_posts($args);
    $total_reading_time = 0;

    foreach ($posts as $post) {
        $content = $post->post_content;
        $reading_time = calculate_reading_time($content);
        $total_reading_time += $reading_time;
    }

    return $total_reading_time;
}
add_filter( 'astra_comment_form_default_fields_markup', 'wplogout_remove_comment_website_field', 20 );

function wplogout_remove_comment_website_field( $fields ) {
    unset( $fields['url'] );
    
    return $fields;
}


function comment_form_change_cookies_consent( $fields ) {
    $commenter = wp_get_current_commenter();
    $consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
    $fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
                     '<label for="wp-comment-cookies-consent">Save my name and email in this browser for the next time I comment.</label></p>';
    return $fields;
}
add_filter( 'comment_form_default_fields', 'comment_form_change_cookies_consent' );

function custom_comments_template($comment_template) {
    return get_stylesheet_directory() . '/custom-comment.php';
}

add_filter('comments_template', 'custom_comments_template');



function check_page_language() {
    $post_id = get_the_ID();
    $languages = get_the_terms($post_id, 'languages');
    if ($languages && !is_wp_error($languages)) {
        foreach ($languages as $language) {
            if ($language->slug === 'in') {
                ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var logoLink = document.querySelector(".custom-logo-link");
                            var pricingLink = document.querySelector(".mega-menu-item-1140 a");
                            var usStocksLink = document.querySelector(".us_stocks_link");

                            if (logoLink) { 
                                logoLink.href = "<?php echo home_url(); ?>/in"; 
                            }
                            if (pricingLink) { 
                                pricingLink.href = "<?php echo home_url(); ?>/in/pricing"; 
                            }
                            if (usStocksLink) { 
                                usStocksLink.href = "<?php echo home_url(); ?>/in/us-stocks"; 
                            }
                        });

                    </script>
                <?php
                break; // Exit the loop if "in" language is found
            }
        }
    }
}
add_action('wp_footer', 'check_page_language');


// Add custom field to WordPress REST API response for posts
function custom_add_mtags_field() {
    register_rest_field(
        'post', // Post type
        'mtags', // Field name in JSON response
        array(
            'get_callback' => 'custom_get_mtags_field',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

// Callback function to retrieve the mtags data
function custom_get_mtags_field($object, $field_name, $request) {
    // Get the post ID
    $post_id = $object['id'];

    // Get the tags for the post
    $post_tags = wp_get_post_tags($post_id);

    // Prepare the mtags data
    $mtags_data = array();

    foreach ($post_tags as $tag) {
        $mtags_data[] = array(
            'term_id' => $tag->term_id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'term_group' => $tag->term_group,
            'term_taxonomy_id' => $tag->term_taxonomy_id,
            'taxonomy' => $tag->taxonomy,
            'description' => $tag->description,
            'parent' => $tag->parent,
            'count' => $tag->count,
            'filter' => 'raw'
        );
    }

    return $mtags_data;
}

// Hook to add the custom field to the REST API response
add_action('rest_api_init', 'custom_add_mtags_field');



// /** 
//  * * Google reCAPTCHA: Add widget before the submit button 
//  */
// function add_google_recaptcha($submit_field) { 
//     function add_google_recaptcha($submit_field) {
//         // Check if no comments exist on the post
//         if (get_comments_number() === 0) {
//             $submit_field['submit_field'] = '<div class="g-recaptcha" data-sitekey="6LeGMSAlAAAAAOCpi_3SLw_Z_eLxE4W5XhW3C6zF"></div>' . $submit_field['submit_field'];
//         }
//         return $submit_field;
//     }
    
//     if (!is_user_logged_in()) {
//         add_filter('comment_form_defaults', 'add_google_recaptcha');
//     }
// }    
 
// /** 
//  * Google reCAPTCHA: verify response and validate comment submission 
//  */ 
// function is_valid_captcha_response($captcha) { 
//     $captcha_postdata = http_build_query( 
//         array( 
//             'secret' => '6LeGMSAlAAAAAIMVgLUlIpI8Xbrc8knciaSi0xpB', 
//             'response' => $captcha, 
//             'remoteip' => $_SERVER['REMOTE_ADDR'] 
//         ) 
//     ); 
//     $captcha_opts = array( 
//         'http' => array( 
//             'method'  => 'POST', 
//             'header'  => 'Content-type: application/x-www-form-urlencoded', 
//             'content' => $captcha_postdata 
//         ) 
//     ); 
//     $captcha_context  = stream_context_create($captcha_opts); 
//     $captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $captcha_context), true); 
//     if(!empty($captcha_response['success'])){ 
//         return true; 
//     }else{ 
//         return false; 
//     } 
// } 
 
// function verify_google_recaptcha() { 
//     $recaptcha = $_POST['g-recaptcha-response']; 
//     if(empty($recaptcha)){ 
//         wp_die(__("<b>ERROR: </b><b>Please click the captcha checkbox.</b><p><a href='javascript:history.back()'>« Back</a></p>")); 
//     }elseif(!is_valid_captcha_response($recaptcha)){ 
//         wp_die(__("<b>Sorry, spam detected!</b>")); 
//     } 
// } 
 
// if (!is_user_logged_in()) { 
//     add_action('pre_comment_on_post', 'verify_google_recaptcha'); 
// }

add_filter( 'wpseo_robots', 'yoast_seo_robots_modify_search' );

function yoast_seo_robots_modify_search( $robots ) {
  if ( is_search() ) {
    return "noindex, nofollow";
  } else {
    return $robots;
  }
}

// Load More Posts AJAX Handler
function load_more_posts_template() {
    check_ajax_referer('load_more_posts', 'security');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $paged
    );

    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" class="post-card display">
                <div class="featured-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('full'); ?>
                    </a>
                </div>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="meta-info">
                    <span class="post-author"><?php the_author(); ?></span>
                    <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo ''; // No more posts
    endif;

    wp_die();
}

function enqueue_load_more_script() {
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_posts')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');


add_action('wp_ajax_load_more_posts', 'load_more_posts_template');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_template');


add_filter( 'wpseo_sitemap_entry', 'exclude_specific_pages_from_sitemap', 10, 3 );

function exclude_specific_pages_from_sitemap( $url, $type, $object ) {
    $excluded_page_ids = array( 7224, 7536, 7538, 7615 ); // Add your page IDs here
    if ( in_array( $object->ID, $excluded_page_ids ) ) {
        return '';
    }
    return $url;
}

function custom_comment_reply_notification_to_fyno($comment_id, $comment_approved, $commentdata) {
    // Check if the comment is a reply
    $parent_id = $commentdata['comment_parent'];
    if ($parent_id) {
        // Get the parent comment
        $parent_comment = get_comment($parent_id);

        // Get the original comment author's name and email
        $user_name = $parent_comment->comment_author;
        $user_email = $parent_comment->comment_author_email;

        // Get the post details
        $post_id = $commentdata['comment_post_ID'];
        $post_title = get_the_title($post_id);
        $post_link = get_permalink($post_id);

        // Get the sender details (assuming the sender is the admin)
        $sender_name = 'Vested Finance';
        $sender_email = get_option('admin_email');

        // Get the reply comment text
        $comment_text = $commentdata['comment_content'];

        // Prepare the data to send to Fyno
        $data = array(
            'event' => 'Blog_Comment',
            'to' => array(
                'email' => $user_email
            ),
            'data' => array(
                'user_name' => $user_name,
                'post_title' => $post_title,
                'response_link' => $post_link,
                'message' => $comment_text,
                'sender' => array(
                    'name' => $sender_name,
                    'email' => $sender_email
                ),
                'reply_to' => array(
                    'email' => 'rahul@vestedfinance.co' // Replace with the appropriate email
                )
            )
        );

        // Send the data to Fyno
        $response = wp_remote_post('https://api.fyno.io/v1/FYAP0CAC5F304IN/test/event', array(
            'method'    => 'POST',
            'body'      => json_encode($data),
            'headers'   => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer LZkJG+K.FC8hskVHBHiCoRzUVmfAo36kiNL3v4Sn' // Replace with your actual Fyno API key
            ),
        ));

        // Check for errors in the response
        if (is_wp_error($response)) {
            error_log('Fyno API request failed: ' . $response->get_error_message());
        } else {
            error_log('Fyno API request successful: ' . wp_remote_retrieve_body($response));
        }
    }
}

add_action('comment_post', 'custom_comment_reply_notification_to_fyno', 10, 3);

function add_nofollow_to_all_links($buffer) {
    $excluded_domains = ['vestedfinance.com', '/in'];

    $buffer = preg_replace_callback(
        '/<a(.*?)href=["\'](.*?)["\'](.*?)>/i',
        function ($matches) use ($excluded_domains) {
            $url = $matches[2];

            if ($url === '#' || strpos($url, '#') === 0) {
                return $matches[0];
            }

            foreach ($excluded_domains as $domain) {
                if (strpos($url, $domain) !== false) {
                    return $matches[0];
                }
            }

            if (strpos($matches[1] . $matches[3], 'rel=') === false) {
                return "<a" . $matches[1] . "href='" . $matches[2] . "'" . $matches[3] . " rel='nofollow'>";
            } elseif (strpos($matches[1] . $matches[3], 'nofollow') === false) {
                return preg_replace('/rel=["\'](.*?)["\']/', "rel='$1 nofollow'", $matches[0]);
            }
            return $matches[0];
        },
        $buffer
    );

    return $buffer;
}

function buffer_start() { ob_start('add_nofollow_to_all_links'); }
function buffer_end() { ob_end_flush(); }

add_action('wp_head', 'buffer_start');

add_action('wp_footer', 'buffer_end');



function change_comment_order( $query ) {
    if ( is_admin() ) {
        return;
    }

    $query->query_vars['orderby'] = 'comment_date_gmt';
    $query->query_vars['order'] = 'DESC';
}
add_action( 'pre_get_comments', 'change_comment_order' );


/* stocks collection table */

// Ajax handler for stocks collection pagination
add_action('wp_ajax_fetch_stocks_data', 'fetch_stocks_data');
add_action('wp_ajax_nopriv_fetch_stocks_data', 'fetch_stocks_data');

function fetch_stocks_data()
{
    global $wpdb;

    $page_id = intval($_POST['page_id']);
    $stocks_list = get_field('stock_symbols', $page_id); // acf field
    $symbols = explode(',', $stocks_list); // Convert to array
    $table_name = $wpdb->prefix . 'stocks_list_details';
    $placeholders = implode(',', array_fill(0, count($symbols), '%s'));
    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE symbol IN ($placeholders)", $symbols);
    $results = $wpdb->get_results($query);

    $all_data = [];
    foreach ($results as $row) {
        $all_data[] = [
            'name' => $row->name,
            'symbol' => $row->symbol,
            'price' => $row->price,
            'price_change' => $row->price_change,
            'market_cap' => number_format($row->market_cap),
            'pe_ratio' => $row->pe_ratio,
        ];
    }

    wp_send_json_success(['all_data' => $all_data]);
}

function enqueue_custom_pagination_script()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
    var page_id = '<?php echo get_the_ID(); ?>';
    var currentPage = 1;
    var allData = [];
    var stocksPerPage = $('#list_table').data('post-num') || -1;

    // Get default sort_by and sort_order values from ACF
    var sortBy = $('#list_table').data('sort-by') || 'market_cap'; // 'market_cap' or 'price'
    var sortOrder = $('#list_table').data('sort-order') || 'asc';  // 'asc' or 'dsc'

    // Sorting state
    var sortingState = {
        marketCap: { order: 'asc' },
        peRatio: { order: 'asc' }
    };

    // Fetch data and render table
    loadStocksData();

    function loadStocksData() {
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                action: 'fetch_stocks_data',
                page_id: page_id
            },
            success: function(response) {
                if (response.success) {
                    allData = response.data.all_data;

                    // Apply default sorting based on ACF fields
                    applyDefaultSort();

                    // Render the table after sorting
                    renderTable(currentPage);
                    generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
                    updateStockCount(allData.length);
                } else {
                    $('#stocks-table tbody').html('<tr><td colspan="6">Error loading data</td></tr>');
                }
            }
        });
    }

    function updateStockCount(totalStocks) {
        if (totalStocks > 0) {
            $('#stocks_count').text(totalStocks + ' Stocks');
        } else {
            $('#stocks_count').text('No Stocks');
        }
    }

    // Default sorting logic based on ACF fields
    function applyDefaultSort() {
        allData.sort(function(a, b) {
            var valueA, valueB;

            // Sorting by 'market_cap' or 'price' based on the ACF value
            if (sortBy === 'market_cap') {
                valueA = parseFloat(a.market_cap.replace(/,/g, '')) || 0;
                valueB = parseFloat(b.market_cap.replace(/,/g, '')) || 0;
            } else if (sortBy === 'price') {
                valueA = parseFloat(a.price) || 0;
                valueB = parseFloat(b.price) || 0;
            }

            // Sort ascending or descending based on the ACF 'sort_order'
            if (sortOrder === 'asc') {
                return valueA - valueB;
            } else {
                return valueB - valueA;
            }
        });
    }

    // Render the table for the current page
    function renderTable(page) {
        $('#stocks-table tbody').empty();
        var start = (page - 1) * stocksPerPage;
        var end = start + stocksPerPage;

        var currentData = allData.slice(start, end);

        if (currentData.length === 0) {
            $('#stocks-table tbody').html('<tr><td colspan="6" style="text-align:center;">No results found</td></tr>');
            return;
        }

        // Populate table rows
        currentData.forEach(function(stock) {
            $('#stocks-table tbody').append('<tr><td>' +
                '<div class="stock_symbol_wrap"><div class="stock_symbol_img"><img src="https://d13dxy5z8now6z.cloudfront.net/symbol/' +
                stock.symbol + '.png" alt="' + stock.symbol + '-img" /></div>' +
                '<div class="stock_name"><p>' + stock.name + '</p>' +
                '<span>(' + stock.symbol + ')</span></div></div></td>' +
                '<td class="pricing_cols">$' + stock.price +
                '<strong class="stock_change ' + (stock.price_change < 0 ? 'minus_value' : '') + '">' +
                (stock.price_change < 0 ? '' : '+') + stock.price_change + '</strong></td>' +
                '<td>' + stock.market_cap.toLocaleString() + '</td>' +
                '<td>' + stock.pe_ratio + '</td>' +
                '<td>--</td><td>--</td></tr>');
        });
    }

    // Sorting functionality when clicking sort buttons (SVG icons)
    $('.sort_data').on('click', function() {
        var sortField = $(this).closest('th').data('sort');
        var currentOrder = $(this).data('order') || 'asc';

        // Reset other sorting fields
        if (sortField === 'market_cap') {
            sortingState.peRatio.order = 'asc';
        } else if (sortField === 'pe_ratio') {
            sortingState.marketCap.order = 'asc';
        }

        // Toggle sort order for the current field
        currentOrder = (currentOrder === 'asc') ? 'desc' : 'asc';
        $(this).data('order', currentOrder);

        // Sort based on selected column (market_cap or pe_ratio)
        allData.sort(function(a, b) {
            var aValue, bValue;

            if (sortField === 'market_cap') {
                aValue = parseFloat(a.market_cap.replace(/,/g, '')) || 0;
                bValue = parseFloat(b.market_cap.replace(/,/g, '')) || 0;
            } else if (sortField === 'pe_ratio') {
                aValue = parseFloat(a.pe_ratio) || 0;
                bValue = parseFloat(b.pe_ratio) || 0;
            }

            return (currentOrder === 'asc') ? (aValue - bValue) : (bValue - aValue);
        });

        // Re-render the table with the sorted data
        renderTable(currentPage);
    });

    // Pagination functionality
    function generatePagination(totalPages, currentPage) {
    var paginationHtml = '';

    // Previous arrow
    if (currentPage > 1) {
        paginationHtml += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.39846 1.9843V0.927467C7.39846 0.835866 7.29318 0.78528 7.22209 0.841334L1.05881 5.6552C1.00644 5.69592 0.964071 5.74807 0.934924 5.80766C0.905777 5.86725 0.890625 5.93271 0.890625 5.99905C0.890625 6.06539 0.905777 6.13085 0.934924 6.19044C0.964071 6.25003 1.00644 6.30217 1.05881 6.3429L7.22209 11.1568C7.29455 11.2128 7.39846 11.1622 7.39846 11.0706V10.0138C7.39846 9.9468 7.36701 9.88254 7.31506 9.84153L2.39318 5.99973L7.31506 2.15657C7.36701 2.11555 7.39846 2.0513 7.39846 1.9843Z" fill="black" fill-opacity="0.88"/></svg></a> ';
    } else {
        paginationHtml += '<span class="page-link disabled"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.39846 1.9843V0.927467C7.39846 0.835866 7.29318 0.78528 7.22209 0.841334L1.05881 5.6552C1.00644 5.69592 0.964071 5.74807 0.934924 5.80766C0.905777 5.86725 0.890625 5.93271 0.890625 5.99905C0.890625 6.06539 0.905777 6.13085 0.934924 6.19044C0.964071 6.25003 1.00644 6.30217 1.05881 6.3429L7.22209 11.1568C7.29455 11.2128 7.39846 11.1622 7.39846 11.0706V10.0138C7.39846 9.9468 7.36701 9.88254 7.31506 9.84153L2.39318 5.99973L7.31506 2.15657C7.36701 2.11555 7.39846 2.0513 7.39846 1.9843Z" fill="black" fill-opacity="0.25"/></svg></span> ';
    }

    // Page numbers
    for (var i = 1; i <= totalPages; i++) {
        paginationHtml += '<a href="#" class="page-link ' + (i === currentPage ? 'active' : '') + '" data-page="' + i + '">' + i + '</a> ';
    }

    // Next arrow
    if (currentPage < totalPages) {
        paginationHtml += '<a href="#" class="page-link" data-page="' + (currentPage + 1) + '"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.96854 5.65558L0.805274 0.841708C0.789169 0.829029 0.769815 0.82115 0.749434 0.818975C0.729052 0.8168 0.708471 0.820417 0.690053 0.829412C0.671635 0.838407 0.656128 0.852414 0.645312 0.869825C0.634496 0.887236 0.62881 0.907344 0.628907 0.927841V1.98468C0.628907 2.05167 0.660353 2.11593 0.712306 2.15694L5.63417 6.00011L0.712306 9.84327C0.658986 9.88429 0.628907 9.94855 0.628907 10.0155V11.0724C0.628907 11.164 0.734181 11.2146 0.805274 11.1585L6.96854 6.34464C7.02092 6.30378 7.0633 6.25151 7.09245 6.19181C7.12159 6.13211 7.13674 6.06654 7.13674 6.00011C7.13674 5.93367 7.12159 5.86811 7.09245 5.80841C7.0633 5.74871 7.02092 5.69644 6.96854 5.65558Z" fill="black" fill-opacity="0.88"/></svg></a>';
    } else {
        paginationHtml += '<span class="page-link disabled"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.96854 5.65558L0.805274 0.841708C0.789169 0.829029 0.769815 0.82115 0.749434 0.818975C0.729052 0.8168 0.708471 0.820417 0.690053 0.829412C0.671635 0.838407 0.656128 0.852414 0.645312 0.869825C0.634496 0.887236 0.62881 0.907344 0.628907 0.927841V1.98468C0.628907 2.05167 0.660353 2.11593 0.712306 2.15694L5.63417 6.00011L0.712306 9.84327C0.658986 9.88429 0.628907 9.94855 0.628907 10.0155V11.0724C0.628907 11.164 0.734181 11.2146 0.805274 11.1585L6.96854 6.34464C7.02092 6.30378 7.0633 6.25151 7.09245 6.19181C7.12159 6.13211 7.13674 6.06654 7.13674 6.00011C7.13674 5.93367 7.12159 5.86811 7.09245 5.80841C7.0633 5.74871 7.02092 5.69644 6.96854 5.65558Z" fill="black" fill-opacity="0.25"/></svg></span>';
    }

    $('#pagination').html(paginationHtml);
}

    // Handle pagination click event
    $('#pagination').on('click', 'a.page-link', function(e) {
    e.preventDefault();
    
    // Get the page from the clicked element
    var newPage = $(this).data('page');
    
    // Only update if it's a different page
    if (newPage !== currentPage) {
        currentPage = newPage;

        // Update the table and pagination
        renderTable(currentPage);
        generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
        
        // Smooth scroll to the top of the table section
        // $('html, body').animate({
        //     scrollTop: $('#list_table').offset().top
        // }, 200);
    }
});

    // Search functionality
    $('#stock-search').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();

        if (searchTerm === "") {
            renderTable(currentPage);
            generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
            return;
        }

        var filteredData = allData.filter(function(stock) {
            return stock.name.toLowerCase().includes(searchTerm) ||
                stock.symbol.toLowerCase().includes(searchTerm);
        });

        if (filteredData.length === 0) {
            $('#stocks-table tbody').html('<tr><td colspan="6" style="text-align:center;">No results found</td></tr>');
        } else {
            generatePagination(Math.ceil(filteredData.length / stocksPerPage), currentPage);
            renderFilteredTable(filteredData);
        }
    });

    // Render filtered data for search
    function renderFilteredTable(data) {
        $('#stocks-table tbody').empty();
        if (data.length === 0) {
            $('#stocks-table tbody').html('<tr><td colspan="6" style="text-align:center;">No results found</td></tr>');
            return;
        }

        data.forEach(function(stock) {
            $('#stocks-table tbody').append('<tr><td>' +
                '<div class="stock_symbol_wrap"><div class="stock_symbol_img"><img src="https://d13dxy5z8now6z.cloudfront.net/symbol/' +
                stock.symbol + '.png" alt="' + stock.symbol + '-img" /></div>' +
                '<div class="stock_name"><p>' + stock.name + '</p>' +
                '<span>(' + stock.symbol + ')</span></div></div></td>' +
                '<td class="pricing_cols">$' + stock.price +
                '<strong class="stock_change ' + (stock.price_change < 0 ? 'minus_value' : '') + '">' +
                (stock.price_change < 0 ? '' : '+') + stock.price_change + '</strong></td>' +
                '<td>' + stock.market_cap.toLocaleString() + '</td>' +
                '<td>' + stock.pe_ratio + '</td>' +
                '<td>--</td><td>--</td></tr>');
        });
    }
});

    </script>
<?php
}
add_action('wp_footer', 'enqueue_custom_pagination_script');


