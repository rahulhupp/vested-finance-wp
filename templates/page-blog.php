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
                <?php if( have_rows('filter_list') ): ?>
                    <ul>
                        <li class="active"><a href="#">All</a></li>
                        <?php while( have_rows('filter_list') ): the_row(); 
                        ?>
                        <li>
                            <a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('label'); ?></a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="search">
                <?php get_search_form(); ?>
            </div>
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
                        $author_name = get_the_author($single_post->ID);
                        $publication_date = get_the_date('M j, Y', $single_post->ID);
                        $post_excerpt = get_the_excerpt($single_post);
                        echo $single_image;
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
                <?php if( have_rows('featured_articles') ): ?>
                    <ul>
                        <?php while( have_rows('featured_articles') ): the_row(); ?>
                            <?php $post_object = get_sub_field('item'); ?>
                            <?php if( $post_object ): ?>
                                <?php // override $post
                                $post = $post_object;
                                setup_postdata( $post );
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
            <?php while( have_rows('blog_list') ): the_row(); ?>
                <?php $post_object = get_sub_field('item'); ?>
                <?php if( $post_object ): ?>
                    <?php // override $post
                    $post = $post_object;
                    setup_postdata( $post );
                    ?>
                    <li>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <?php the_post_thumbnail('full'); // You can specify the image size here ?>
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
                <div class="line"></div>
            </div>            
            <a href="<?php the_field('view_all_link'); ?> "><?php the_field('view_all_text'); ?></a>                     
        </div>
        <div class="inner-row">
            <div class="blog-list">
                <ul>
                    <?php while( have_rows('us-stock-blog') ): the_row(); ?>
                        <?php $post_object = get_sub_field('item'); ?>
                        <?php if( $post_object ): ?>
                            <?php // override $post
                            $post = $post_object;
                            setup_postdata( $post );
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
                        <?php echo do_shortcode('[moengage_newsletter name="newsletter-subscriber" message="Thank You! You have been added to the waitlist." button_text="Subscribe"]'); ?>
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
                    <a href="<?php the_field('vested_shorts_view_all_button_link'); ?>"><?php the_field('vested_shorts_view_all_button'); ?></a>
                </div>
                <span><?php the_field('vested_shorts_sub_heading'); ?></span>
            </div>
        </div>
        <div class="post-list">
            <ul>
                <?php
                    $args = array(
                        'category_name' => 'p2p-lending/vested-shorts/', // Use the slug of the subcategory
                        'posts_per_page' => -5, // Set the number of posts you want to display, -1 to show all
                    );

                    $custom_query = new WP_Query($args);

                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                            // Display post content here
                            ?>
                            <li>
                                <div class="featured-image">
                                    <?php if (has_post_thumbnail()) : ?>                                       
                                        <?php the_post_thumbnail('full'); // You can specify the image size here ?>
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
                    else :
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
                <div class="title"><h2><?php the_field('sport_light_heading'); ?></h2></div>
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
                        $author_name = get_the_author($single_post->ID);
                        $publication_date = get_the_date('M j, Y', $single_post->ID);
                        $post_excerpt = get_the_excerpt($single_post);
                        echo $single_image;
                        echo '<div class="content">';
                        echo '<div class="inner">';
                        echo '<h3><a href="' . esc_url(get_permalink($single_post->ID)) . '">' . $single_title . '</a></h3>';
                        echo '<p>'. $post_excerpt .'</p>';
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
                <?php if( have_rows('sport_light_list_post') ): ?>
                    <ul>
                        <?php while( have_rows('sport_light_list_post') ): the_row(); ?>
                            <?php $post_object = get_sub_field('item'); ?>
                            <?php if( $post_object ): ?>
                                <?php // override $post
                                $post = $post_object;
                                setup_postdata( $post );
                                ?>
                                <li>
                                    <div class="featured-image">
                                    <?php if (has_post_thumbnail()) : ?>                                       
                                        <?php the_post_thumbnail('full'); // You can specify the image size here ?>
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

<section class="vested-edge-blog">
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
            <?php if( have_rows('vested_edge_post') ): ?>
                <ul>
                    <?php while( have_rows('vested_edge_post') ): the_row(); ?>
                        <?php $post_object = get_sub_field('item'); ?>
                        <?php if( $post_object ): ?>
                            <?php // override $post
                            $post = $post_object;
                            setup_postdata( $post );
                            ?>
                            <li>
                                <div class="featured-image">
                                <?php if (has_post_thumbnail()) : ?>                                       
                                    <?php the_post_thumbnail('full'); // You can specify the image size here ?>
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
    </div>
</section>

<section class="newsletter-section">
    <?php get_template_part('template-parts/newsletter'); ?>
</section>

</div>
<?php get_footer(); ?>