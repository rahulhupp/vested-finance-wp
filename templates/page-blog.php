<?php
/*
Template name: Page - Blog
*/
get_header(); ?>

<div id="content" role="main" class="blog-page">

    <section class="blog-info">
        <div class="container">
            <div class="inner">
                <h1><?php the_field('blog_title'); ?></h1>
                <p><?php the_field('blog_content'); ?></p>
            </div>
        </div>
    </section>

    <section class="filter-tab">
        <div class="container">
            <div class="inner-row">
                <div class="category-tab">
                    <?php if (have_rows('filter_list')): ?>
                        <ul>
                            <li class="active"><a href="#">All</a></li>
                            <?php while (have_rows('filter_list')):
                                the_row();
                                ?>
                                <li>
                                    <a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('label'); ?></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="search">
                    <?php // get_search_form(); ?>
                    <?php echo do_shortcode('[ivory-search id="4323" title="AJAX Search Form"]'); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fresh-reads-post">
        <div class="container">
            <div class="head-part">
                <div class="heading">
                    <div class="title">
                        <h2><?php the_field('blog_heading'); ?></h2>
                        <a
                            href="<?php the_field('blog_view_all_articles_link'); ?>"><?php the_field('blog_view_all_articles_text'); ?></a>
                    </div>
                    <span><?php the_field('blog_contents'); ?></span>
                </div>
            </div>
            <div class="inner-row">

                <?php
                $latest_post = new WP_Query(
                    array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'order' => 'DESC',
                        'orderby' => 'date'
                    )
                );

                if ($latest_post->have_posts()):
                    while ($latest_post->have_posts()):
                        $latest_post->the_post();
                        ?>
                        <div class="fresh-reads-blog">
                            <div class="latest-post">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                                            alt="<?php the_title(); ?>">
                                    </a>
                                <?php endif; ?>
                                <h6>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h6>
                                <div class="post-content">
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                                <div class="meta-info">
                                    <span class="post-author"><?php the_author(); ?></span>
                                    <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>

    <section class="first-blog">
        <div class="container">
            <div class="inner-row">
                <div class="single-blog">
                    <?php
                    $single_post = get_field('single_post');

                    if ($single_post) {
                        $single_image = get_the_post_thumbnail($single_post->ID, 'full');
                        $single_title = esc_html($single_post->post_title);
                        $single_content = esc_html($single_post->post_title);
                        $post_content = apply_filters('the_content', $single_post->post_content);
                        $author_name = get_the_author_meta('display_name', $single_post->post_author); // Get author's display name
                        $publication_date = get_the_date('M j, Y', $single_post->ID);
                        $post_excerpt = get_the_excerpt($single_post);
                        echo '<a href="' . get_permalink($single_post->ID) . '">' . $single_image . '</a>';
                        echo '<div class="content">';
                        echo '<h3><a href="' . esc_url(get_permalink($single_post->ID)) . '">' . $single_title . '</a></h3>';
                        echo '<p>' . $post_excerpt . '</p>';
                        echo '<div class="meta-info">';
                        echo '<span>' . $author_name . '</span>';
                        echo '<span>' . $publication_date . '</span>';
                        echo '</div>';
                        echo '</div>';

                    }
                    ?>
                </div>
                <div class="featured-article">
                    <div class="title">
                        <h2><?php the_field('featured_title'); ?></h2>
                    </div>
                    <?php if (have_rows('featured_articles')): ?>
                        <ul>
                            <?php while (have_rows('featured_articles')):
                                the_row(); ?>
                                <?php $post_object = get_sub_field('item'); ?>
                                <?php if ($post_object): ?>
                                    <?php // override $post
                                                $post = $post_object;
                                                setup_postdata($post);
                                                ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="meta-info">
                                            <span class="post-author"><?php the_author(); ?></span>
                                            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </li>
                                    <?php wp_reset_postdata(); ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <ul class="blog-list">
                <?php while (have_rows('blog_list')):
                    the_row(); ?>
                    <?php $post_object = get_sub_field('item'); ?>
                    <?php if ($post_object): ?>
                        <?php // override $post
                                $post = $post_object;
                                setup_postdata($post);
                                ?>
                        <li>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="featured-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <?php the_excerpt(); ?>
                            <div class="meta-info">
                                <span class="post-author"><?php the_author(); ?></span>
                                <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                            </div>
                        </li>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>

    <section class="us-stock-list">
        <div class="container">
            <div class="head-part">
                <div class="left-part">
                    <div class="stock-label">
                        <?php the_field('us_stock_title'); ?>
                    </div>
                </div>
                <a href="<?php the_field('view_all_link'); ?> "><?php the_field('view_all_text'); ?></a>
            </div>
            <div class="inner-row">
                <div class="blog-list">
                    <ul>
                        <?php while (have_rows('us-stock-blog')):
                            the_row(); ?>
                            <?php $post_object = get_sub_field('item'); ?>
                            <?php if ($post_object): ?>
                                <?php // override $post
                                        $post = $post_object;
                                        setup_postdata($post);
                                        ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <?php the_excerpt(); ?>
                                    <div class="meta-info">
                                        <span class="post-author"><?php the_author(); ?></span>
                                        <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </li>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div class="mobile-view-all-btn">
                    <a href="<?php the_field('view_all_link'); ?> "><?php the_field('view_all_text'); ?></a>
                </div>
                <div class="subscriber-blog">
                    <div class="inner">
                        <h3><?php the_field('subscriber_heading'); ?></h3>
                        <div class="image">
                            <img src="<?php the_field('subscriber_image'); ?>" />
                        </div>
                        <div class="newsletter-form">
                            <?php echo do_shortcode('[moengage_newsletter id="1" name="newsletter-subscriber" message="Thank you! You have successfully subscribed to our blog." button_text="Subscribe"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vested-shots-blog">
        <div class="container">
            <div class="head-part">
                <div class="heading-icon">
                    <img src="<?php the_field('vested_shorts_icon'); ?>" />
                </div>
                <div class="heading">
                    <div class="title">
                        <h2><?php the_field('vested_shorts_heading'); ?></h2>
                        <a
                            href="<?php the_field('vested_shorts_view_all_button_link'); ?>"><?php the_field('vested_shorts_view_all_button'); ?></a>
                    </div>
                    <span><?php the_field('vested_shorts_sub_heading'); ?></span>
                </div>
            </div>
            <div class="post-list">
                <ul>
                    <?php

                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 5,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'master_categories', // Replace with your actual taxonomy name
                                'field' => 'slug', // Change to 'term_id', 'name', or 'slug' as needed
                                'terms' => 'vested-shorts', // Replace with the term you want to display
                            ),
                        ),
                    );

                    $custom_query = new WP_Query($args);

                    if ($custom_query->have_posts()):
                        while ($custom_query->have_posts()):
                            $custom_query->the_post();
                            // Display post content here
                            ?>
                            <li>
                                <div class="featured-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="content">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <?php the_excerpt(); ?>
                                    <div class="meta-info">
                                        <span class="post-author"><?php the_author(); ?></span>
                                        <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata(); // Restore the global post data
                    else:
                        echo 'No posts found';
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="spot-light">
        <div class="container">
            <div class="head-part">
                <div class="heading-icon">
                    <img src="<?php the_field('heading_icon'); ?>" />
                </div>
                <div class="heading">
                    <div class="title">
                        <h2><?php the_field('sport_light_heading'); ?></h2>
                    </div>
                    <span><?php the_field('sport_light_sub_heading'); ?></span>
                </div>
            </div>
            <div class="inner-row">
                <div class="single-blog">
                    <?php
                    $single_post = get_field('sport_light_single_post');

                    if ($single_post) {
                        $single_image = get_the_post_thumbnail($single_post->ID, 'full');
                        $single_title = esc_html($single_post->post_title);
                        $single_content = esc_html($single_post->post_title);
                        $post_content = apply_filters('the_content', $single_post->post_content);
                        $author_name = get_the_author_meta('display_name', $single_post->post_author); // Get author's display name
                        $publication_date = get_the_date('M j, Y', $single_post->ID);
                        $post_excerpt = get_the_excerpt($single_post);
                        echo '<a href="' . get_permalink($single_post->ID) . '">' . $single_image . '</a>';
                        echo '<div class="content">';
                        echo '<div class="inner">';
                        echo '<h3><a href="' . esc_url(get_permalink($single_post->ID)) . '">' . $single_title . '</a></h3>';
                        echo '<p>' . $post_excerpt . '</p>';
                        echo '<div class="meta-info">';
                        echo '<span>' . $author_name . '</span>';
                        echo '<span>' . $publication_date . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                    }
                    ?>
                </div>
                <div class="blog-list">
                    <?php if (have_rows('sport_light_list_post')): ?>
                        <ul>
                            <?php while (have_rows('sport_light_list_post')):
                                the_row(); ?>
                                <?php $post_object = get_sub_field('item'); ?>
                                <?php if ($post_object): ?>
                                    <?php // override $post
                                                $post = $post_object;
                                                setup_postdata($post);
                                                ?>
                                    <li>
                                        <div class="featured-image">
                                            <?php if (has_post_thumbnail()): ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="content">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <?php the_excerpt(); ?>
                                            <div class="meta-info">
                                                <span class="post-author"><?php the_author(); ?></span>
                                                <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php wp_reset_postdata(); ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div>
                </div>
    </section>

    <?php if (have_rows('vested_edge_post')): ?>
        <section class="vested-edge-blog" id="p2p-lending">
            <div class="container">
                <div class="head-part">
                    <div class="vested-label">
                        <div class="label">
                            <img src="<?php the_field('vested_edge_icon'); ?>" />
                            <h2><?php the_field('vested_edge_heading'); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="inner-row">
                    <ul>
                        <?php while (have_rows('vested_edge_post')):
                            the_row(); ?>
                            <?php $post_object = get_sub_field('item'); ?>
                            <?php if ($post_object): ?>
                                <?php // override $post
                                            $post = $post_object;
                                            setup_postdata($post);
                                            ?>
                                <li>
                                    <div class="featured-image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php the_excerpt(); ?>
                                        <div class="meta-info">
                                            <span class="post-author"><?php the_author(); ?></span>
                                            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </li>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (have_rows('bond_post')): ?>
        <section class="vested-edge-blog" id="bonds">
            <div class="container">
                <div class="head-part">
                    <div class="vested-label">
                        <div class="label">
                            <img src="<?php the_field('bond_icon'); ?>" />
                            <h2><?php the_field('bond_heading'); ?></h2>
                        </div>
                    </div>  
                </div>
                <div class="inner-row">
                    <ul>
                        <?php while (have_rows('bond_post')):
                            the_row(); ?>
                            <?php $post_object = get_sub_field('bond_item'); ?>
                            <?php if ($post_object): ?>
                                <?php // override $post
                                            $post = $post_object;
                                            setup_postdata($post);
                                            ?>
                                <li>
                                    <div class="featured-image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php the_excerpt(); ?>
                                        <div class="meta-info">
                                            <span class="post-author"><?php the_author(); ?></span>
                                            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </li>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>   
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <?php if (have_rows('solar_post')): ?>
        <section class="vested-edge-blog" id="solar">
            <div class="container">
                <div class="head-part">
                    <div class="vested-label">
                        <div class="label">
                            <img src="<?php the_field('solar_icon'); ?>" />
                            <h2><?php the_field('solar_heading'); ?></h2>
                        </div>
                    </div>  
                </div>
                <div class="inner-row">
                    <ul>
                        <?php while (have_rows('solar_post')):
                            the_row(); ?>
                            <?php $post_object = get_sub_field('solar_item'); ?>
                            <?php if ($post_object): ?>
                                <?php // override $post
                                            $post = $post_object;
                                            setup_postdata($post);
                                            ?>
                                <li>
                                    <div class="featured-image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php the_excerpt(); ?>
                                        <div class="meta-info">
                                            <span class="post-author"><?php the_author(); ?></span>
                                            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </li>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>   
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="latest_articles">
        <div class="container">
            <div class="head-part">
                <div class="title">
                    <h2><?php the_field('articles_heading'); ?></h2>
                </div>
                <span><?php the_field('articles_sub_heading'); ?></span>
            </div>
            <div class="articles-list">
                <ul>
                    <?php

                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                        ),
                    );

                    $custom_query = new WP_Query($args);

                    if ($custom_query->have_posts()):
                        while ($custom_query->have_posts()):
                            $custom_query->the_post();
                            // Display post content here
                            ?>
                            <li>
                                <div class="featured-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('full'); // You can specify the image size here ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="content articles-wrap">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                    <div class="meta-info">
                                        <span class="post-author"><?php the_author(); ?></span>
                                        <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata(); // Restore the global post data
                    else:
                        echo 'No posts found';
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>

</div>

<script>
    window.onload = function () {
        // Get the input element by its ID
        var myInput = document.querySelector('.search-field');

        // Set the placeholder attribute
        myInput.placeholder = 'Search all blogs';
    };
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.articles-list ul').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1000,
            arrows: true,
            responsive: [{
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
            ]
        });
    });
</script>
<?php get_footer(); ?>