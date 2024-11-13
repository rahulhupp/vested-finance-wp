<?php
/*
Template Name: US Stock Collection Page
*/
get_header();
?>

<div class="collection_page_banner">
    <div class="container">
        <div class="banner_content_wrap">
            <div class="banner_content_col">
                <p class="small_heading"><?php the_field('banner_sub_heading'); ?></p>
                <h1><?php the_field('banner_heading'); ?></h1>
                <p class="banner_desc"><?php the_field('banner_description', false, false); ?></p>
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
                    'post_type' => 'stocks_collections',
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
                            while ($term_query->have_posts()) :
                                $term_query->the_post();
                                $collection_name = get_the_title();
                                $collection_slug = get_post_field('post_name', get_the_ID());
                            ?>
                                <li class="single_collection_category">
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($collection_name); ?></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); // Reset post data after each query 
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php
get_footer();
