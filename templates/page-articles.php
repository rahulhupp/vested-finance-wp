<?php
/*
Template name: Page - Articles
*/
get_header(); ?>

<div class="custom_breadcrumb">
    <div class="container">
        <ul>
            <li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
            <li class="active"><a href="#">All Articles</a></li>						
        </ul>
    </div>
</div>

<div id="content" role="main" class="sub-category-page">
    <section>
        <div class="container">
            <header class="page-header">
                <div class="heading">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (category_description()) : ?>
                        <div class="category-description"><?php echo category_description(); ?></div>
                    <?php endif; ?>
                </div>
                <div class="search">
                    <?php echo do_shortcode('[ivory-search id="4323" title="AJAX Search Form"]'); ?>
                </div>
            </header>

            <!-- Post container to load initial posts -->
            <div class="post-item">
                <?php
                // Initial post loading (first page)
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 8,
                    'paged' => 1
                );
                $custom_query = new WP_Query($args);

                if ($custom_query->have_posts()) :
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        get_template_part('template-parts/post-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No posts found.</p>';
                endif;
                ?>
            </div>

            <!-- Load more button -->
            <div class="load-more-btn">
                <a href="#" id="loadMore" data-page="1">Load More</a>
            </div>
        </div>
    </section>

    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
    jQuery(document).ready(function ($) {
        $('#loadMore').on('click', function (e) {
            e.preventDefault();

            var page = $(this).data('page');
            var button = $(this);
            button.text('Loading...').prop('disabled', true);

            // Fetch posts via REST API
            $.get('<?php echo get_rest_url(null, '/custom/v1/load-more-posts'); ?>', { page: page + 1 }, function (response) {
                if (response.success && response.data) {
                    $('.post-item').append(response.data);
                    button.data('page', page + 1).text('Load More').prop('disabled', false);

                    // If no more posts, disable the button
                    if (response.data === '') {
                        button.text('No more posts').prop('disabled', true);
                    }
                } else {
                    button.text('No more posts').prop('disabled', true);
                }
            }).fail(function () {
                button.text('Error, try again').prop('disabled', false);
            });
        });
    });
</script>

<?php get_footer(); ?>
