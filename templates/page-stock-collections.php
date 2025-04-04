<?php
/*
Template Name: US Stock Collection Page
*/
get_header();
?>

<div class="collection_page_banner page_template_banner">
    <div class="container">
        <div class="banner_content_wrap">
            <div class="banner_content_col">
                <p class="small_heading"><?php the_field('banner_sub_heading'); ?></p>
                <h1><?php the_field('banner_heading'); ?></h1>
                <p class="banner_desc"><?php the_field('banner_description', false, false); ?></p>
            </div>
            <div class="banner_img_col">
                <img src="<?php the_field('banner_image'); ?>" alt="<?php the_field('banner_heading'); ?>">
            </div>
        </div>
    </div>
</div>

<div class="stocks_list_collections">
    <div class="container">
        <h2 class="section_title">Explore US Stocks Collections</h2>
        <?php
        $taxonomy = 'stocks_collections_categories';
        $terms = get_terms($taxonomy);
        ?>
        <div class="main_collections_list">
            <?php
            foreach ($terms as $term) :
                $term_args = array(
                    'post_type' => 'collections',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'term_id',
                            'terms' => $term->term_id,
                        ),
                    ),
                    'posts_per_page' => -1,
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                );
                $category_name = $term->name;
                $category_desc = $term->description;
                $category_image = get_field('collection_image', $term);

                $term_query = new WP_Query($term_args);
                $post_count = $term_query->post_count;
                $first_post_url = '';
            ?>
                <div class="single_collection">
                    <div class="single_collection_img">
                        <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_name); ?>">
                    </div>
                    <h3 class="single_collection_title"><?php echo esc_html($category_name); ?></h3>
                    <p class="single_collection_desc"><?php echo esc_html($category_desc); ?></p>

                    <?php if ($post_count > 0) : ?>
                        <ul class="collections_categories">
                            <?php
                            $is_first = true;
                            while ($term_query->have_posts()) :
                                $term_query->the_post();
                                $collection_name = get_the_title();
                                $collection_slug = get_post_field('post_name', get_the_ID());
                                $post_permalink = get_permalink();
                                if ($is_first) {
                                    $first_post_url = $post_permalink;
                                    $is_first = false; // Mark as no longer the first post
                                }
                            ?>
                                <li class="single_collection_category">
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($collection_name); ?> <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.625 8.75L4.375 5L0.625 1.25" stroke="#B2BECB" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($first_post_url); ?>" class="first_cat_url"></a>
                    <?php wp_reset_postdata(); // Reset post data after each query 
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php
get_footer();
