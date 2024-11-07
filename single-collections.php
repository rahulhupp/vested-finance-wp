<?php
get_header();

while (have_posts()) :
    the_post();
    $featured_image_url = get_the_post_thumbnail_url();
    $ticker_selected = get_field('ticker_list_type');
    $sortBy = '';
    $sortOrder = '';
    if ($ticker_selected === 'manual') {
        $sortByField = get_field('sort_by');
        $sortOrderField = get_field('sort_order');

        $sortBy = isset($sortByField['value']) ? $sortByField['value'] : '';
        $sortOrder = isset($sortOrderField['value']) ? $sortOrderField['value'] : '';
    } elseif ($ticker_selected === 'algorithm') {
        $sortBy = 'price_change';
        $sortOrder = 'desc';
    }
?>  

    <div class="collection_page_banner smaller">
        <div class="container">
            <div class="collection_breadcrumb">
                <p><a href="#">US Stocks</a><span class="divider"> > </span><a href="<?php echo home_url('/in/us-stocks/collections/'); ?>">All Collections</a><span class="divider"> > </span><span class="current_page"><?php the_title(); ?></span></p>
            </div>
            <div class="banner_content_wrap">
                <div class="banner_content_col">
                    <h1 class="mt_0"><?php the_title(); ?></h1>
                    <p class="banner_desc"><?php the_field('collection_description', false, false); ?></p>
                    <a href="#" class="btn_dark">Invest in <?php the_title(); ?></a>
                </div>
                <div class="banner_img_col">
                    <img src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="explore_market_leaders" id="list_table" data-sort-by="<?php echo esc_attr($sortBy); ?>" data-sort-order="<?php echo esc_attr($sortOrder); ?>" data-post-num = "<?php the_field('no_of_stocks_to_display'); ?>">
        <div class="container">
            <div class="market_leaders_row">
                <div class="market_leaders_col">
                    <?php
                    $post_id = get_the_ID();
                    $terms = get_the_terms($post_id, 'stocks_collections_categories');
                    if ($terms && ! is_wp_error($terms)) :
                        $term_ids = wp_list_pluck($terms, 'term_id');
                        $args = array(
                            'post_type' => 'collections',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'stocks_collections_categories',
                                    'field'    => 'term_id',
                                    'terms'    => $term_ids,
                                ),
                            ),
                            'posts_per_page' => -1,
                        );
                        $related_posts = new WP_Query($args);
                        if ($related_posts->have_posts()) :
                            echo '<h2>Explore Market Leaders</h2><ul>';
                            while ($related_posts->have_posts()) : $related_posts->the_post();
                                $current_class = (get_the_ID() === $post_id) ? ' class="current"' : '';
                                echo '<li' . $current_class . '><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></li>';
                            endwhile;
                            echo '</ul>';
                        else :
                            echo '<p>No related posts found.</p>';
                        endif;
                        wp_reset_postdata();
                    endif;

                    ?>
                </div>
                <div class="market_table_col">
                <div class="market_table_col_wrap">
                    <div class="market_table_headings">
                        <div class="market_table_name">
                            <h3><?php the_title(); ?></h3>
                            <p id="stocks_count"></p>
                        </div>
                        <div class="market_table_search">
                            <input type="text" id="stock-search" placeholder="Search stocks..." />
                        </div>
                    </div>
                    <table id="stocks-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th data-sort="market_cap">Market Cap.
                                    <span class="sort_data">
                                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                            <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                        </svg>
                                    </span>
                                </th>
                                <th data-sort="pe_ratio">P/E Ratio
                                    <span class="sort_data">
                                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                            <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                        </svg>
                                    </span>
                                </th>
                                <th>1Y Returns</th>
                                <th>5Y CAGR</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <!-- Pagination Controls -->
                    <div id="pagination"></div>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
endwhile;
get_footer();
