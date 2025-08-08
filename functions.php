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
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0');


// Include your custom functions file from the "inc" folder
require_once get_stylesheet_directory() . '/inc/allow-svg.php';
require_once get_stylesheet_directory() . '/inc/enqueue-style-script.php';
require_once get_stylesheet_directory() . '/inc/acf-options.php';
require_once get_stylesheet_directory() . '/inc/store-token.php';
require_once get_stylesheet_directory() . '/inc/stocks-details-fucntions.php';
require_once get_stylesheet_directory() . '/template-parts/stocks-details/fetch-stocks-api-data.php';
require_once get_stylesheet_directory() . '/template-parts/fetch-inr-bonds-api-data.php';
require_once get_stylesheet_directory() . '/inc/bond-details-functions.php';
require_once get_stylesheet_directory() . '/inc/stocks-collection-table.php';
require_once get_stylesheet_directory() . '/inc/stock-search-function.php';
require_once get_stylesheet_directory() . '/inc/ipo-details-functions.php';
require_once get_stylesheet_directory() . '/inc/ipo-api-handler.php';

function add_custom_js_to_pages()
{
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

function monthsToYearsAndMonths($months)
{
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
function custom_page_meta_box()
{
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


function footer_meta_box($post)
{

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
function save_custom_page_meta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['footer_options'])) {
        update_post_meta($post_id, '_custom_page_meta_key', sanitize_text_field($_POST['footer_options']));
    }
}
add_action('save_post', 'save_custom_page_meta');


if (function_exists('acf_add_options_page')) {

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

    acf_add_options_page(array(
        'page_title'    => 'Stocks Meta Settings',
        'menu_title'    => 'Stocks Meta Settings',
        'menu_slug'     => 'stocks-meta-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url' => 'dashicons-admin-site',
    ));

    acf_add_options_page(array(
        'page_title'    => 'Partners Options',
        'menu_title'    => 'Partners Options',
        'menu_slug'     => 'partners-options',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url' => 'dashicons-list-view',
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
add_filter('astra_comment_form_default_fields_markup', 'wplogout_remove_comment_website_field', 20);

function wplogout_remove_comment_website_field($fields)
{
    unset($fields['url']);

    return $fields;
}


function comment_form_change_cookies_consent($fields)
{
    $commenter = wp_get_current_commenter();
    $consent   = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
    $fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
        '<label for="wp-comment-cookies-consent">Save my name and email in this browser for the next time I comment.</label></p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'comment_form_change_cookies_consent');

function custom_comments_template($comment_template)
{
    return get_stylesheet_directory() . '/custom-comment.php';
}

add_filter('comments_template', 'custom_comments_template');


function check_page_language()
{
    $post_id = get_the_ID();
    $languages = get_the_terms($post_id, 'languages');
    if ($languages && !is_wp_error($languages)) {
        foreach ($languages as $language) {
            if ($language->slug === 'in') {
                echo '<script>console.log("3 Page has \'in\' language.");</script>';
    ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var logoLink = document.querySelector(".custom-logo-link");
                        var pricingLink = document.querySelector(".mega-menu-item-1140 a");
                        var usStocksLink = document.querySelector(".us_stocks_link");

                        if (logoLink) {
                            logoLink.href = "<?php echo home_url(); ?>/in";
                            console.log('logoLink');
                        }
                        if (pricingLink) {
                            pricingLink.href = "<?php echo home_url(); ?>/in/pricing";
                            console.log('pricingLink');
                        }
                        if (usStocksLink) {
                            usStocksLink.href = "<?php echo home_url(); ?>/in/us-stocks";
                            console.log('usStocksLink');
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
function custom_add_mtags_field()
{
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
function custom_get_mtags_field($object, $field_name, $request)
{
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


add_filter('wpseo_sitemap_entry', 'exclude_specific_pages_from_sitemap', 10, 3);

function exclude_specific_pages_from_sitemap($url, $type, $object)
{
    $excluded_page_ids = array(7224, 7536, 7538, 7615); // Add your page IDs here
    if (in_array($object->ID, $excluded_page_ids)) {
        return '';
    }
    return $url;
}



function custom_comment_reply_notification_to_fyno($comment_id, $comment_approved, $commentdata)
{
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
        $response = wp_remote_post('https://api.fyno.io/v1/FYAP0CAC5F304IN/event', array(
            'method'    => 'POST',
            'body'      => json_encode($data),
            'headers'   => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer LZkJG+K.FC8hskVHBHiCoRzUVmfAo36kiNL3v4Sn' // Replace with your actual Fyno API key
            ),
        ));

        // Check for errors in the response
        if (is_wp_error($response)) {
            // error_log('Fyno API request failed: ' . $response->get_error_message());
        } else {
            // error_log('Fyno API request successful: ' . wp_remote_retrieve_body($response));
        }
    }
}

add_action('comment_post', 'custom_comment_reply_notification_to_fyno', 10, 3);

/* function to add nofollow for external links */


function add_nofollow_to_all_links($buffer)
{
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

function buffer_start()
{
    ob_start('add_nofollow_to_all_links');
}
function buffer_end()
{
    ob_end_flush();
}

add_action('wp_head', 'buffer_start');

add_action('wp_footer', 'buffer_end');



function change_comment_order($query)
{
    if (is_admin()) {
        return;
    }

    $query->query_vars['orderby'] = 'comment_date_gmt';
    $query->query_vars['order'] = 'DESC';
}
add_action('pre_get_comments', 'change_comment_order');

add_filter('acf/load_field/name=select_posts', 'acf_load_all_posts');
add_filter('acf/load_field/name=blog_to_display', 'acf_load_all_posts');

function acf_load_all_posts($field)
{
    // Get all posts
    $posts = get_posts(array(
        'post_type'      => 'post',       // Replace with your custom post type if needed
        'numberposts'    => -1,           // Retrieve all posts
        'post_status'    => 'publish',    // Only show published posts
    ));

    // Initialize choices array
    $field['choices'] = [];

    // Loop through each post and add it to the choices array
    if ($posts) {
        foreach ($posts as $post) {
            $field['choices'][$post->ID] = $post->post_title;
        }
    }

    // Return the field
    return $field;
}

add_filter('excerpt_more', function ($more) {
    if (is_singular('post') || is_page_template('single-collections.php')) {
        return '';
    }
    return $more;
});


function preload_image($image_url)
{
    // Ensure the URL is not empty and it's a valid URL
    if (!empty($image_url) && filter_var($image_url, FILTER_VALIDATE_URL)) {
        echo '<link rel="preload" href="' . esc_url($image_url) . '" as="image" />';
    }
}

function enforce_lowercase_symbol($query)
{
    if (!is_admin() && isset($query->query_vars['symbol'])) {
        $query->query_vars['symbol'] = strtolower($query->query_vars['symbol']);
    }
}
add_action('parse_query', 'enforce_lowercase_symbol');

function news_wpseo_sitemap_index($sitemap_index)
{
    $last_modified = date('c');
    $news_sitemap_url = '<sitemap><loc>' . home_url('/news-sitemap.xml') . '</loc><lastmod>' . $last_modified . '</lastmod></sitemap>';
    $sitemap_index .= $news_sitemap_url;

    return $sitemap_index;
}
add_filter('wpseo_sitemap_index', 'news_wpseo_sitemap_index', 10, 1);

add_action('wp_ajax_load_more_posts', 'load_more_posts_callback');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_callback');

function load_more_posts_callback() {
    $exclude_ids = isset($_GET['exclude']) ? array_map('intval', explode(',', $_GET['exclude'])) : [];

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'post_status' => 'publish',
        'post__not_in' => $exclude_ids,
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" class="post-card display" data-id="<?php the_ID(); ?>">
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
    endif;

    wp_die();
}


add_filter('wpseo_robots_array', 'custom_robots_rules', 10, 2);

function custom_robots_rules($robots_array, $indexable) {
    // Post IDs you want to allow (index, follow)
    $allowed_ids = [12504, 12702]; // Replace with your real IDs

    // Apply to all singular pages or posts
    if (is_singular('partners') || is_page_template('templates/page-new-partner.php')) {
        global $post;

        // If post is one of the allowed ones → index, follow
        if (in_array($post->ID, $allowed_ids)) {
            $robots_array['index']  = 'index';
            $robots_array['follow'] = 'follow';
        } else {
            // Everything else → noindex, nofollow
            $robots_array['index']  = 'noindex';
            $robots_array['follow'] = 'nofollow';
        }
    }

    // Additionally force noindex, nofollow for specific page templates (e.g. static pages)
    if (is_page_template('page-us-stock-india-copy.php') || is_page_template('templates/page-hsl-tpp-calculator.php')) {
        $robots_array['index']  = 'noindex';
        $robots_array['follow'] = 'nofollow';
    }

    return $robots_array;
}


function autoplay_videos_on_single_post() {
    if (is_single()) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videos = document.querySelectorAll('video');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;

                    if (entry.isIntersecting) {
                        video.muted = true;
                        video.loop = true;
                        video.controls = false;

                        // Only try to play if not already playing
                        if (video.paused) {
                            video.play().catch(err => {
                                console.warn('Autoplay blocked:', err);
                            });
                        }
                    } else {
                        video.pause();
                    }
                });
            }, {
                threshold: 0.5 // Play only when 50% is visible
            });

            videos.forEach(video => observer.observe(video));
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'autoplay_videos_on_single_post');

add_filter( 'big_image_size_threshold', '__return_false' );