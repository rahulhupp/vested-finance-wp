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



/** 
 * Google reCAPTCHA: Add widget before the submit button 
 */ 
// function add_google_recaptcha($submit_field) { 
//     $submit_field['submit_field'] = '<div class="g-recaptcha" data-sitekey="6LeGMSAlAAAAAOCpi_3SLw_Z_eLxE4W5XhW3C6zF"></div>'.$submit_field['submit_field']; 
//     return $submit_field; 
// } 
 
// if (!is_user_logged_in()) { 
//     add_filter('comment_form_defaults', 'add_google_recaptcha'); 
// } 
 
/** 
 * Google reCAPTCHA: verify response and validate comment submission 
 */ 
function is_valid_captcha_response($captcha) { 
    $captcha_postdata = http_build_query( 
        array( 
            'secret' => '6LeGMSAlAAAAAIMVgLUlIpI8Xbrc8knciaSi0xpB', 
            'response' => $captcha, 
            'remoteip' => $_SERVER['REMOTE_ADDR'] 
        ) 
    ); 
    $captcha_opts = array( 
        'http' => array( 
            'method'  => 'POST', 
            'header'  => 'Content-type: application/x-www-form-urlencoded', 
            'content' => $captcha_postdata 
        ) 
    ); 
    $captcha_context  = stream_context_create($captcha_opts); 
    $captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $captcha_context), true); 
    if(!empty($captcha_response['success'])){ 
        return true; 
    }else{ 
        return false; 
    } 
} 
 
function verify_google_recaptcha() { 
    $recaptcha = $_POST['g-recaptcha-response']; 
    if(empty($recaptcha)){ 
        wp_die(__("<b>ERROR: </b><b>Please click the captcha checkbox.</b><p><a href='javascript:history.back()'>« Back</a></p>")); 
    }elseif(!is_valid_captcha_response($recaptcha)){ 
        wp_die(__("<b>Sorry, spam detected!</b>")); 
    } 
} 
 
if (!is_user_logged_in()) { 
    add_action('pre_comment_on_post', 'verify_google_recaptcha'); 
}

add_filter( 'wpseo_robots', 'yoast_seo_robots_modify_search' );

function yoast_seo_robots_modify_search( $robots ) {
  if ( is_search() ) {
    return "noindex, nofollow";
  } else {
    return $robots;
  }
}


add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    check_ajax_referer('load_more_posts', 'security');

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $_POST['page']
    );

    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) : $custom_query->the_post();
            ?>
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
            <?php
        endwhile;
        wp_reset_postdata();
    endif;

    die();
}

add_filter( 'wpseo_sitemap_entry', 'exclude_specific_pages_from_sitemap', 10, 3 );

function exclude_specific_pages_from_sitemap( $url, $type, $object ) {
    $excluded_page_ids = array( 7224, 7536, 7538, 7615 ); // Add your page IDs here
    if ( in_array( $object->ID, $excluded_page_ids ) ) {
        return '';
    }
    return $url;
}
