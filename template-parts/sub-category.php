<div class="custom_breadcrumb">
    <div class="container">
        <ul>
            <li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
            <?php
                $term = get_queried_object();
                $taxonomy = 'master_categories';

                if ($term->parent) {
                    $parent_term = get_term($term->parent, $taxonomy);
                    $parent_term_link = get_term_link($parent_term, $taxonomy);
                    echo '<li><a href="' . esc_url($parent_term_link) . '">' . $parent_term->name . '</a></li>';
                }

                if ($term) {
                    $term_link = get_term_link($term, $taxonomy);
                    echo '<li class="active"><a href="' . esc_url($term_link) . '">' . $term->name . '</a></li>';
                }
            ?>
        </ul>
    </div>
</div>
<div id="content" role="main" class="sub-category-page">
    <section>
        <div class="container">
            <?php 
                $term = get_queried_object(); // Get the current term in 'master_categories' taxonomy

                $args = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'master_categories',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ),
                    ),
                    'posts_per_page' => -1,
                );

                $custom_query = new WP_Query($args);
            ?>
            <?php if ($custom_query->have_posts()) : ?>
                <header class="page-header">
                    <div class="heading">
                        <h1 class="page-title"><?php single_cat_title(); ?></h1>
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
                        <div id="post-<?php the_ID(); ?>" class="post-card">
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
    <?php if (have_rows('select_categroy', 'term_' . $term->term_id)) { ?>
        <section class="main-category">
            <div class="container">
                <div class="head-part">
                    <h2>Learn More With Vested</h2>
                    <p>Two stock deep-dives every month, published every other Wednesday</p>
                </div>
                <ul>
                    <?php
                        // Check if the term has Repeater field data
                        while (have_rows('select_categroy', 'term_' . $term->term_id)) {
                            the_row();
                            $field1 = get_sub_field('item');
                            $category = get_term($field1, 'master_categories'); // Use the custom taxonomy 'master_categories'
                            ?>
                            <li>
                                <div class="box">
                                    <div class="image">
                                        <img src="<?php echo get_field('category_image', $category); ?>" />
                                    </div>
                                    <a href="<?php echo get_term_link($category); ?>"><?php echo $category->name ?> ></a>
                                    <div class="description"><?php echo $category->description ?></div>
                                </div>
                            </li>
                            <?php
                        }
                    ?>							
                </ul>
            </div>
        </section>
        <?php } ?>
    <section class="newsletter-section category">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
	jQuery(document).ready(function ($) {
		$(".main-category ul").slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			responsive: [
				{
				breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
				breakpoint: 768,
					settings: {
						slidesToShow: 2,
					}
				},
				{
				breakpoint: 576,
					settings: {
						slidesToShow: 1,
					}
				}
			]
		});
		$(function () {
			var getLength = jQuery('.post-card').length;
			if (getLength <= 8) {
				$(".load-more-btn").remove();
			}
			$(".post-card").slice(0, 8).addClass('display');
			$("#loadMore").on('click', function (e) {
				e.preventDefault();
				$(".post-card:hidden").slice(0, 8).addClass('display');
				if ($(".post-card:hidden").length == 0) {
				$(".load-more-btn").remove();
				} else {
					// $('html,body').animate({
					// 	scrollTop: $(this).offset().top
					// }, 1500);
				}
			});
		});
	});  
</script>