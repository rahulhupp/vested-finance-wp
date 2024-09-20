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
    'posts_per_page' => 12,
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
jQuery(function($) {

var loadedPosts = [];
$('.post-card').each(function() {
        loadedPosts.push($(this).data('id'));
    });

    
$('#loadMore').on('click', function() {
    var button = $(this);
    var page = button.data('page');

    
    $('.post-card').each(function() {
        loadedPosts.push($(this).data('id'));
    }); 
    $.ajax({
        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
        type: 'POST',
        data: {
            action: 'loadmore',
            page: page,
            exclude: loadedPosts,
        },
        beforeSend: function() {
            button.text('Loading...');
        },
        success: function(data) {
            if (data) {
                $('.post-item').append(data);
                button.data('page', page + 1);
                button.text('Load More');
            } else {
                button.text('No more posts');
                button.attr('disabled', true);
            }
        }
    });
});

});
</script>

<?php get_footer(); ?>
