<?php
/*
Template name: Page - Vested Acadamy
*/
get_header(); ?>
<div id="content" role="main" class="vested-acadamy-page">

    <section class="acadamy_banner_section">
        <div class="container">
            <div class="acadamy_banner_content">
                <div class="acadamy_banner_heading">
                    <h1><?php the_field('acadamy_heading'); ?></h1>
                    <p class="sub_heading"><?php the_field('acadamy_sub_heading'); ?></p>
                </div>
                <div class="acadamy_banner_image_col">
                    <div class="acadamy_banner_img">
                        <img src="<?php the_field('banner_image'); ?>" alt="Learn With Vested">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr class="acadamy_divider">
    <section class="modules_section">
        <div class="container">
            <h2><?php the_field('module_heading'); ?></h2>
            <?php
            $taxonomy = 'modules';
            $exclude_term_slug = 'glossary';
            $terms = get_terms($taxonomy);
            ?>
            <div class="modules_list">
                <?php
                foreach ($terms as $term) :

                    if ($term->slug === $exclude_term_slug) {
                        continue;
                    }
                    $term_args = array(
                        'post_type' => 'module',
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'posts_per_page' => -1,
                    );

                    $module_link = get_term_link($term);
                    $module_name = $term->name;
                    $module_slug = $term->slug;
                    $module_desc = $term->description;
                    if (strlen($module_desc) > 110) {
                        $module_desc = substr($module_desc, 0, 110) . '...';
                    }
                    if (strlen($module_name) > 24) {
                        $module_name = substr($module_name, 0, 24) . '...';
                    }
                    $module_image = get_field('module_image', $term);
                    $term_link = get_term_link($term);
                    $term_id = $term->term_id;
                    $total_reading_time = calculate_total_reading_time_for_term($term_id);
                    $args = array(
                        'post_type' => 'module',
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'posts_per_page' => -1,
                        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                    );
                    $term_query = new WP_Query($term_args);
                    $post_count = $term_query->post_count;
                ?>
                    <div class="modules_item">
                        <div class="module_meta_wrap">
                            <div class="module_meta">
                                <h3><a href="<?php echo $term_link; ?>"><?php echo $module_name; ?></a></h3>
                                <p><?php echo $module_desc; ?></p>

                            </div>
                            <div class="module_img">
                                <img src="<?php echo $module_image; ?>" alt="">
                            </div>
                        </div>

                        <div class="module_btn">
                            <div class="module_sharing_wrap">
                                <a href="<?php echo $term_link; ?>" class="category-btn" data-cat-slug="<?php echo $module_slug; ?>">Start Learning</a>
                                <div class="module_share" data-module-name="<?php echo $module_name; ?>">
                                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" fill="#002852"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="module_share_mobile">
                                <button class="sharing-icon">
                                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" fill="#002852"></path>
                                            </g>
                                        </svg>
                                </button>
                                </div>
                                <div class="module_share_wrap">
                                    <div class="module_share_inner">
                                       <ul>
                                            <li>
                                                <a class="copyLink">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link.png" alt="link" />
                                                    <input class="copyPostLink" type="hidden" value="<?php echo $term_link; ?>" />
                                                    <span>Copy link</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="share_whatsapp" href="javascript:void(0);" data-title="<?php echo $module_name; ?>" data-url="<?php echo $term_link; ?>" target="_blank">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/whatsapp.png" alt="whatsapp" />
                                                    <span>Share on Whatsapp</span>
                                                </a>
                                            </li>
                                       </ul> 
                                    </div>
                                    <!-- <div class="module_share_inner">
                                        <a class="share_twitter" href="javascript:void(0);"  data-title="<?php echo $module_name; ?>" data-url="<?php echo $term_link; ?>"><svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20">
                                                <style>
                                                    .s0 {
                                                        fill: #002852;
                                                        stroke: #002852;
                                                        stroke-width: 0
                                                    }
                                                </style>
                                                <g id="SVGRepo_bgCarrier"></g>
                                                <g id="SVGRepo_tracerCarrier"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="7935ec95c421cee6d86eb22ecd12f847">
                                                        <path id="Layer" class="s0" d="m17.9 5.9q0 0.3 0 0.6c0 5.4-4.1 11.6-11.6 11.6-2.3 0-4.5-0.7-6.3-1.8q0.5 0 1 0c1.9 0 3.7-0.6 5.1-1.7-1.8-0.1-3.3-1.2-3.8-2.9q0.3 0.1 0.7 0.1 0.6 0 1.1-0.1c-1.9-0.4-3.3-2.1-3.3-4.1q0 0 0 0 0.9 0.5 1.9 0.5c-1.1-0.7-1.8-2-1.8-3.4 0-0.8 0.2-1.5 0.5-2.1 2 2.5 5 4.1 8.4 4.3q-0.1-0.4-0.1-0.9c0-2.3 1.9-4.1 4.1-4.1 1.2 0 2.3 0.5 3 1.3q1.4-0.3 2.6-1c-0.3 0.9-0.9 1.7-1.8 2.3q1.3-0.2 2.4-0.7-0.9 1.3-2.1 2.1z" />
                                                    </g>
                                                </g>
                                            </svg></a>
                                        <a class="share_facebook" href="javascript:void(0)"  data-title="<?php echo $module_name; ?>" data-url="<?php echo $term_link; ?>"><svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20">
                                                <style>
                                                    .s0 {
                                                        fill: #002852
                                                    }
                                                </style>
                                                <g id="SVGRepo_bgCarrier"></g>
                                                <g id="SVGRepo_tracerCarrier"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="Page-1">
                                                        <g id="Dribbble-Light-Preview">
                                                            <g id="icons">
                                                                <path id="facebook-[#176]" fill-rule="evenodd" class="s0" d="m11.8 20v-9h2.8l0.4-4h-3.2v-1.9c0-1.1 0-2.1 1.5-2.1h1.4v-2.9c0 0-1.2-0.1-2.5-0.1-2.6 0-4.3 1.7-4.3 4.7v2.3h-2.9v4h2.9v9z" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></a>
                                        <a class="share_whatsapp" href="javascript:void(0);"  data-title="<?php echo $module_name; ?>" data-url="<?php echo $term_link; ?>"><svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20">
                                                <style>
                                                    .s0 {
                                                        fill: #002852
                                                    }
                                                </style>
                                                <g id="SVGRepo_bgCarrier"></g>
                                                <g id="SVGRepo_tracerCarrier"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path id="Layer" fill-rule="evenodd" class="s0" d="m18.8 10c-0.1 4.8-4 8.8-8.8 8.8-1.6-0.1-3.1-0.5-4.3-1.2l-3.8 1.1c-0.3 0.1-0.6 0-0.9-0.2-0.2-0.3-0.2-0.6-0.1-0.9l1.4-3.4c-0.7-1.2-1-2.7-1-4.2 0-4.8 3.9-8.8 8.7-8.8 4.8 0 8.8 4 8.8 8.8zm-14.8 3.7c0.1 0.3 0.1 0.5 0 0.8l-0.9 2.1 2.4-0.7c0.3-0.1 0.5 0 0.7 0.1 1.1 0.7 2.4 1.1 3.8 1.1 3.9 0 7.1-3.2 7.1-7.1 0-3.9-3.2-7.1-7.1-7.1-3.9 0-7.1 3.2-7.1 7.1 0 1.4 0.4 2.6 1.1 3.7zm8.8-1.9l1.4 0.8c0.2 0.2 0.4 0.4 0.4 0.7 0 0.2-0.1 0.5-0.3 0.7l-0.5 0.4c-0.5 0.4-1.1 0.6-1.9 0.4-0.9-0.2-2.4-0.8-3.9-2.3-1.4-1.4-2.1-2.9-2.4-3.9-0.3-0.9 0-1.8 0.7-2.3l0.2-0.3c0.2-0.1 0.5-0.2 0.7-0.2 0.3 0.1 0.5 0.3 0.6 0.5l0.9 1.6c0.2 0.4 0.1 0.8-0.2 1.1l-0.7 0.6c0.3 0.5 0.8 1.1 1.4 1.7 0.5 0.6 1.1 1 1.6 1.3l1.1-0.8c0.3-0.2 0.6-0.2 0.9 0z" />
                                                </g>
                                            </svg>
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                            <span><?php echo $post_count; ?> Chapters</span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const readButtons = document.querySelectorAll('.category-btn');
            const sharebtn = document.querySelectorAll('.module_share');
            const shareModule = document.querySelectorAll('.module_share_wrap');
            readButtons.forEach(function(button) {
                const postSlug = button.getAttribute('data-cat-slug');
                const storedOverIdsArray = localStorage.getItem(`visited-module-${postSlug}-over`);
                const storedResumeIdsArray = localStorage.getItem(`visited-module-${postSlug}-resume`);
                const storedPostCount = localStorage.getItem(`visited-module-${postSlug}`);
                const storedOverIds = storedOverIdsArray ? JSON.parse(storedOverIdsArray) : [];
                const storedResumeIds = storedResumeIdsArray ? JSON.parse(storedResumeIdsArray) : [];

                if (storedOverIds.length > 0) {
                    if (storedOverIds.length != storedPostCount) {
                        button.textContent = 'Resume';
                    } else if (storedOverIds.length == storedPostCount) {
                        button.textContent = 'Start Over';
                    }
                } else if (storedResumeIds.length > 0) {
                    button.textContent = 'Resume';
                } else {
                    button.textContent = 'Start Learning';
                }
            });
            jQuery('.module_share_wrap').fadeOut();
            jQuery('.module_share').click(function() {
                jQuery(this).toggleClass('active');
                if (jQuery(this).hasClass('active')) {
                    jQuery(this).html('<svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#002852"></path> </g></svg>');
                } else {
                    jQuery(this).html('<svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" fill="#002852"></path> </g></svg>');
                }

                jQuery('.module_share_wrap').not(jQuery(this).siblings('.module_share_wrap')).fadeOut();

                jQuery(this).siblings('.module_share_wrap').fadeToggle();

                jQuery('.module_share').not(this).removeClass('active').html('<svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" fill="#002852"></path> </g></svg>');
            });



        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const twitterButtons = document.querySelectorAll('.share_twitter');
            const facebookButtons = document.querySelectorAll('.share_facebook');
            const whatsappButtons = document.querySelectorAll('.share_whatsapp');

            twitterButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const title = button.getAttribute('data-title');
                    const url = button.getAttribute('data-url');
                    window.open('http://twitter.com/share?text=' + encodeURIComponent(title) + '&url=' + encodeURIComponent(url) + '&utm-medium=social&utm-source=Twitter&utm-campaign=Academy', "", "width=600,height=400");
                });
            });

            facebookButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const title = button.getAttribute('data-title');
                    const url = button.getAttribute('data-url');
                    window.open('https://www.facebook.com/sharer.php?text=' + encodeURIComponent(title) + '&u=' + encodeURIComponent(url) + '&utm-medium=social&utm-source=Facebook&utm-campaign=Academy', "", "width=600,height=400");
                });
            });

            whatsappButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const title = button.getAttribute('data-title');
                    const url = button.getAttribute('data-url');
                    window.open('https://wa.me/?text=' + encodeURIComponent(title + " , " + url) + '&utm-medium=social&utm-source=WhatsApp&utm-campaign=Academy', "_blank");
                });
            });
        });
    </script>
    <script>
        jQuery(".copyLink").click(function () {
            var currentElement = jQuery(this); // Store reference to the current element
            var inputField = currentElement.find('.copyPostLink');
            var inputValue = inputField.val();
            var tempInput = jQuery('<input>');
            tempInput.val(inputValue);
            jQuery('body').append(tempInput);
            tempInput.select();
            document.execCommand('copy');
            tempInput.remove();
            currentElement.find('span').text("Copied");
            // Use the stored reference to the current element
            setTimeout(function() {
                currentElement.find('span').text("Copy link");
            }, 1000);
        });


        const BlogData = {
            title: '<?php the_title(); ?>',
            url: '<?php the_permalink(); ?>',
        }

        const btn = document.querySelector('.sharing-icon');

        // Share must be triggered by "user activation"
        btn.addEventListener('click', async () => {
            try {
                if (navigator.canShare &&
                    typeof navigator.canShare === 'function' &&
                    navigator.canShare(BlogData)) {
                    let result = await navigator.share(BlogData);
                    document.getElementById("status").innerText = result || '';
                } else {
                    document.getElementById("status").innerText = "Sharing selected data not supported.";
                }
            } catch (err) {
                document.getElementById("status").innerText = "Share not complete";
            }
        });
    </script>
</div>
<?php get_footer(); ?>