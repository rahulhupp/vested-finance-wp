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
   $args = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'paged' => 1,
);
$query = new WP_Query($args);
    ?>
    <?php if ($query->have_posts()) : ?>
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
            <?php while ($query->have_posts()) : $query->the_post(); ?>
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
        <button id="loadMore" data-page="1">Load More</button>
    </div>				
    </div>
    </section>
    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
jQuery(function($){

$('#loadMore').on('click', function(){
    var button = $(this);
    var page = button.data('page');

    $.ajax({
        url : '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Use admin_url to get ajax URL
        type : 'POST',
        data : {
            action : 'loadmore', // Action defined in functions.php
            page : page,
        },
        beforeSend : function(){
            button.text('Loading...'); // Change button text while loading
        },
        success : function(data){
            if( data ) {
                $('.post-item').append(data); // Append the new posts
                button.data('page', page + 1); // Increment the page number
                button.text('Load More'); // Reset button text
            } else {
                button.text('No more posts'); // No more posts to load
                button.attr('disabled', true);
            }
        }
    });
});

});
</script>

<?php get_footer(); ?>
