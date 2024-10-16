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
                    'posts_per_page' => 12,
                    'paged' => 1
                );
                $custom_query = new WP_Query($args);

                if ($custom_query->have_posts()) :
                    while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                        <div class="post-card display" id="post-<?php the_ID(); ?>" data-id="<?php the_ID(); ?>">
                <div class="featured-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('full'); ?>
                    </a>
                </div>
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                <div class="meta-info">
                    <span class="post-author"><?php the_author(); ?></span>
                    <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
            </div>
                <?php endwhile;
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
  jQuery(function($) {
    var loadedPosts = [];

    // On page load, add the IDs of already loaded posts to the array
    $('.post-card').each(function() {
        loadedPosts.push($(this).data('id')); // Assuming post-card has a data-id attribute with post ID
    });

    $('#loadMore').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var page = button.data('page'); // Get the current page

        // Collect IDs of currently loaded posts again (in case new posts were added via AJAX)
        $('.post-card').each(function() {
            loadedPosts.push($(this).data('id')); // Push post IDs into loadedPosts array
        });

        // Send AJAX request via the REST API
        $.ajax({
            url: '<?php echo get_rest_url(null, '/custom/v1/load-more-posts'); ?>',
            type: 'GET',
            data: {
                page: page + 1,        // Increment page number
                exclude: loadedPosts   // Pass already loaded post IDs to the server
            },
            beforeSend: function() {
                button.text('Loading...');
            },
            success: function(response) {
                if (response.success && response.data) {
                    $('.post-item').append(response.data); // Append the new posts
                    button.data('page', page + 1); // Increment the page counter
                    button.text('Load More');

                    // Add newly loaded post IDs to the loadedPosts array
                    $(response.data).find('.post-card').each(function() {
                        loadedPosts.push($(this).data('id'));
                    });
                } else {
                    button.text('No more posts');
                    button.attr('disabled', true); // Disable button if no more posts
                }
            },
            error: function() {
                button.text('Error loading posts. Try again');
                button.prop('disabled', false);
            }
        });
    });
});

</script>

<?php get_footer(); ?>