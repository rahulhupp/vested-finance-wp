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
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $paged
    );
    $custom_query = new WP_Query($args);
    ?>
    <?php if ($custom_query->have_posts()) : ?>
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
        <div class="post-item">
            <?php while ($custom_query->have_posts()) :  $custom_query->the_post(); ?>
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
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
    
    <div class="load-more-btn">
        <a href="#" id="loadMore" data-paged="2">Load More</a>
    </div>				
    </div>
    </section>
    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
   jQuery(document).ready(function($) {
        var displayedPostIds = []; 

        function gatherDisplayedPostIds() {
            $('#postContainer .post-card').each(function() {
                var postId = $(this).attr('id'); 
                if (postId) { 
                    postId = postId.replace('post-', ''); 
                    if (!displayedPostIds.includes(postId)) {
                        displayedPostIds.push(postId); 
                    }
                }
            });
        }

        gatherDisplayedPostIds();

        $('#loadMore').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var paged = button.data('paged');
            var maxPages = <?php echo $custom_query->max_num_pages; ?>;
            
            if (paged > maxPages) {
                return;
            }

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    paged: paged
                },
                beforeSend: function() {
                    button.text('Loading...'); 
                },
                success: function(response) {
                    if (response) {
                        var $response = $(response);
                        var newPostsAdded = false;

                        $response.each(function() {
                            var postId = $(this).attr('id'); 
                            if (postId) {
                                postId = postId.replace('post-', '');
                                if (!displayedPostIds.includes(postId)) {
                                    $('.post-item').append(this);
                                    displayedPostIds.push(postId);
                                    newPostsAdded = true;
                                }
                            }
                        });

                        if (newPostsAdded) {
                            button.data('paged', paged + 1);
                        } else {
                            button.text('No more posts to load.');
                            button.prop('disabled', true);
                        }
                        button.text('Load More');
                    } else {
                        button.text('No more posts to load.'); 
                        button.prop('disabled', true);
                    }
                },
                error: function() {
                    button.text('Error loading more posts.');
                }
            });
        });
    });
</script>

<?php get_footer(); ?>
