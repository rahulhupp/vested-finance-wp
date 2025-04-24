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
            <div class="post-item" id="postContainer">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 8,
                );
                $initial_query = new WP_Query($args);
                if ($initial_query->have_posts()) :
                    while ($initial_query->have_posts()) : $initial_query->the_post(); ?>
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
                endif;
                ?>
            </div>

            <div class="load-more-btn">
                <a href="#" id="loadMore" data-paged="1">Load More</a>
            </div>
        </div>
    </section>
    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
    jQuery(document).ready(function($) {
        let currentPage = 1;
        let isLoading = false;
        let postsPerPage = 8;
        console.log('posts initialized');
        
        $('#loadMore').on('click', function(e) {
            e.preventDefault();
            if (isLoading) return;
            isLoading = true;

            currentPage++;

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: currentPage,
                    posts_per_page: postsPerPage,
                },
                beforeSend: function() {
                    $('#loadMore').text('Loading...');
                },
                success: function(response) {
                    if (response.success && response.data) {
                        $('.post-item').append(response.data);
                        $('#loadMore').text('Load More');
                    } else {
                        $('#loadMore').text('No more posts');
                        $('#loadMore').prop('disabled', true);
                    }
                    isLoading = false;
                },
                error: function() {
                    $('#loadMore').text('Error loading');
                    isLoading = false;
                }
            });
        });
    });
</script>

<?php get_footer(); ?>