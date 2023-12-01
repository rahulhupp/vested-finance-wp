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




// Detect IP Address

global $mycountry;
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
    else
    $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function ip_details($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function custom_front_page_redirect() {    
    $myipd = get_client_ip(); 
    $url = 'http://www.geoplugin.net/json.gp?ip='.$myipd; 
    $details =  ip_details($url); 
    $v = json_decode($details);
    $mycountry = $v->geoplugin_countryName;    
    $chtml = '';

    if ($mycountry === 'India') {
        if (is_page_template('templates/page-us-stock-global.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>You're on our Global website. Visit the India website to explore our India-specific products.</p></div></div><div class='right'><a href='".home_url('in')."'><img src='".get_stylesheet_directory_uri()."/assets/images/india.png'>India</a></div>";
            // echo "Go back to India page";
        }
        if (is_page_template('templates/page-home-page.php')) {
            $chtml = "<div class='left india'><div class='content'><p>Discover the new face of Vested! Read our latest update to know more.</p></div></div><div class='right learn-more'><a href='".home_url()."/blog/vested-updates/welcome-to-a-better-and-improved-vested/' target='_blank'>Learn more</a></div>";
            // echo "Show learn more";
        }
        if (is_page_template('templates/page-pricing-global.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>You're on our Global website. Visit the India website to explore our pricing for Indian users.</p></div></div><div class='right'><a href='".home_url('in')."/pricing'><img src='".get_stylesheet_directory_uri()."/assets/images/india.png'>India</a></div>";
        }
        if (is_page_template('templates/page-pricing-india.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>Discover the new face of Vested! Read our latest update to know more.</p></div></div><div class='right learn-more'><a href='".home_url()."/blog/vested-updates/welcome-to-a-better-and-improved-vested/' target='_blank'>Learn more</a></div>";
        } 
    } else {
        if (is_page_template('templates/page-us-stock-global.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>Discover the new face of Vested! Read our latest update to know more.</p></div></div><div class='right learn-more'><a href='".home_url()."/blog/vested-updates/welcome-to-a-better-and-improved-vested/' target='_blank'>Learn more</a></div>";
            // echo "Show learn more";
        }
        if (is_page_template('templates/page-home-page.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>You're on our India website. Visit the Global website to explore our Global products.</p></div></div><div class='right'><a href='".home_url()."'><img src='".get_stylesheet_directory_uri()."/assets/images/global.png'>Global</a></div>";
            // echo "Go back to Global page";
        }
        if (is_page_template('templates/page-pricing-india.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>You're on our India website. Visit the Global website to explore our pricing for the global users.</p></div></div><div class='right'><a href='".home_url()."/pricing'><img src='".get_stylesheet_directory_uri()."/assets/images/global.png'>Global</a></div>";
        }
        if (is_page_template('templates/page-pricing-global.php')) {
            $chtml = "<div class='left'><div class='close'><img src=' ".get_stylesheet_directory_uri()."/assets/images/close-icon.png'></div><div class='content'><p>Discover the new face of Vested! Read our latest update to know more.</p></div></div><div class='right learn-more'><a href='".home_url('')."/blog/vested-updates/welcome-to-a-better-and-improved-vested/' target='_blank'>Learn more</a></div>";
        }
    }
    ?>
    <?php 
        if (is_page_template('templates/page-home-page.php') || is_page_template('templates/page-us-stock-global.php') || is_page_template('templates/page-pricing-global.php') || is_page_template('templates/page-pricing-india.php') ) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelector(".geolocation_banner").innerHTML = "<?php echo $chtml; ?>";
                    var globalBanner = document.querySelector(".geolocation_banner");
                    if (globalBanner) {
                        globalBanner.style.display = "flex"; 
                    }
                });
            </script>
            <?php
        }
    ?>
    <?php
}

// Hook this function to the 'template_redirect' action
add_action('template_redirect', 'custom_front_page_redirect');

// End Detect IP Address