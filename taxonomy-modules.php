<?php
get_header();
?>
<div id="content" role="main" class="vested-acadamy-page">
    <?php if (have_posts()) :
        $term = get_queried_object();
        if ($term) {
            $term_slug = $term->slug;
            $module_image = get_field('module_image', $term);
            $module_desc = $term->description;

            $query_args = array(
                'post_type' => 'module',  // Replace with your actual post type
                'tax_query' => array(
                    array(
                        'taxonomy' => 'modules',  // Replace with your actual taxonomy
                        'field' => 'slug',
                        'terms' => $term_slug,
                    ),
                ),
                'posts_per_page' => -1,  // To count all posts
            );
            $post_query = new WP_Query($query_args);
            $found_posts = $post_query->found_posts;
        }
    ?>
        <section class="acadamy_banner_section">
            <div class="container">
                <div class="acadamy_banner_content">
                    <div class="acadamy_banner_heading">
                        <h1><?php echo single_term_title(); ?></h1>
                        <p class="sub_heading"><?php echo $module_desc;  ?></p>
                    </div>
                    <div class="acadamy_banner_image_col">
                        <div class="acadamy_banner_img">
                            <img src="<?php echo $module_image ?>" alt="<?php echo single_term_title(); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr class="acadamy_divider">
        <section class="modules_section">
            <div class="container">
                <h2>Chapters</h2>
                <div class="modules_list">
                    <?php while (have_posts()) : the_post();
                        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        $reading_time = calculate_reading_time(get_the_content());
                        $excerpt = get_the_excerpt();
                        $post_categories = get_the_terms(get_the_ID(), 'modules');
                        if ($post_categories && !is_wp_error($post_categories)) {
                            // Loop through the categories and display their names
                            $category_names = array();
                            foreach ($post_categories as $category) {
                                $category_names[] = $category->name;
                            }
                            $category_list = implode(', ', $category_names);
                            $hasGlossary = strpos($category_list, 'Glossary') !== false;
                            $item_class = $hasGlossary ? 'modules-glossary' : 'non-modules-glossary';
                        }
                    ?>
                        <div class="modules_item" data-cat="<?php echo $item_class; ?>">
                            <div class="module_meta_wrap">
                                <div class="module_meta">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo $excerpt; ?></p>
                                </div>
                                <div class="module_img">
                                    <?php if (get_field('listing_image')) : ?>
                                        <img src="<?php the_field('listing_image'); ?>" alt="<?php the_title(); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>

                            </div>

                            <div class="module_btn">
                                <div class="module_sharing_wrap">
                                    <a href="<?php the_permalink(); ?>" data-post-id="<?php echo get_the_ID(); ?>" data-category="<?php echo $term_slug; ?>" class="read-button">Start Learning</a>
                                    <div class="module_share"><i class="fa fa-share-alt"></i></div>
                                    <div class="module_share_wrap">
                                        <a href="javascript:void(0);" class="share_twitter" target="_blank" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="share_facebook" target="_blank" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="share_whatsapp" target="_blank" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
                                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="read_time"><?php echo 'Read time: ' . $reading_time . ' minutes' ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
            <?php endif; ?>
            </div>
        </section>
        <script>
            const termSlug = "<?php echo $term_slug; ?>";
            const foundPosts = <?php echo $found_posts; ?>;

            // Set item in localStorage
            localStorage.setItem(`visited-module-${termSlug}`, foundPosts);

            document.addEventListener('DOMContentLoaded', function() {
                const readButtons = document.querySelectorAll('.read-button');

                // Load the IDs from localStorage
                const storedResumeIds = localStorage.getItem(`visited-module-${termSlug}-resume`);
                const storedOverIds = localStorage.getItem(`visited-module-${termSlug}-over`);
                const resumeIdArray = storedResumeIds ? JSON.parse(storedResumeIds) : [];
                const overIdArray = storedOverIds ? JSON.parse(storedOverIds) : [];

                // Update button text based on localStorage
                readButtons.forEach(function(button) {
                    const postId = button.getAttribute('data-post-id');
                    if (overIdArray.includes(parseInt(postId))) {
                        button.textContent = 'Start Over';
                    } else if (resumeIdArray.includes(parseInt(postId))) {
                        button.textContent = 'Resume';
                    } else {
                        button.textContent = 'Start Learning';
                    }
                });

                const moduleShareWrap = document.querySelectorAll('.module_share_wrap');
                const moduleShare = document.querySelectorAll('.module_share');

                moduleShareWrap.forEach(function(element) {
                    element.style.display = 'none';
                });

                moduleShare.forEach(function(element) {
                    element.addEventListener('click', function() {
                        element.classList.toggle('active');

                        if (element.classList.contains('active')) {
                            element.innerHTML = '<i class="fa fa-times"></i>';
                        } else {
                            element.innerHTML = '<i class="fa fa-share-alt"></i>';
                        }

                        moduleShareWrap.forEach(function(wrap) {
                            if (wrap !== element.nextElementSibling) {
                                wrap.style.display = 'none';
                            }
                        });

                        element.nextElementSibling.style.display = 'block';

                        moduleShare.forEach(function(share) {
                            if (share !== element) {
                                share.classList.remove('active');
                                share.innerHTML = '<i class="fa fa-share-alt"></i>';
                            }
                        });
                    });
                });
            });

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
</div>

<?php
get_footer();
?>