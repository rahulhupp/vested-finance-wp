<?php
/*
Template name: Page - Articles
*/
get_header(); ?>

<div class="custom_breadcrumb">
    <div class="container">
        <ul>
            <li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
            <li class="active"><a href="#">Articles</a></li>						
        </ul>
    </div>
</div>

<div id="content" role="main" class="sub-category-page">
    <section>
        <div class="container">
            <?php 
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 8, // -1 to display all posts
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
                        <?php // get_search_form(); ?>
                        <?php echo do_shortcode('[ivory-search id="4325" title="Sub Category AJAX Search"]'); ?>
                    </div>
                </header>
                <div class="post-item">
                    <?php while ($custom_query->have_posts()) :  $custom_query->the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" class="post-card display">
                            <div class="featured-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); // You can specify the image size here ?>
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
                <?php
            else :
                // Display a message for no posts
                ?>
                <?php
            endif;
            ?>	
            <div class="load-more-btn">
                <a href="#" id="loadMore">Load More</a>
            </div>				
        </div>
    </section>
    <section class="newsletter-section">
		<?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>
<script>
	jQuery(document).ready(function ($) {
        var page = 1;
    $('#loadMore').on('click', function(e) {
        e.preventDefault();
        page++;
        var data = {
            'action': 'load_more_posts',
            'page': page,
            'security': '<?php echo wp_create_nonce("load_more_posts"); ?>'
        };
        $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
            $('.post-item').append(response);
        });
    });
	});  
</script>

<?php get_footer(); ?>
