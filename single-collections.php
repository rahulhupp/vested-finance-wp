<?php
get_header();
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
while (have_posts()) :
    the_post();
    $featured_image_url = get_the_post_thumbnail_url();
    $ticker_selected = get_field('ticker_list_type');
    $sortByField = get_field('sort_by');
    $sortOrderField = get_field('sort_order');
    $sortBy = isset($sortByField['value']) ? $sortByField['value'] : '';
    $sortOrder = isset($sortOrderField['value']) ? $sortOrderField['value'] : '';
    preload_image($featured_image_url);
    if ($ticker_selected === 'manual') {
    } elseif ($ticker_selected === 'algorithm') {
        $algorithmSelected = get_field('algorithm_select');

        if ($algorithmSelected === 'megaCap' || $algorithmSelected === 'largeCap' || $algorithmSelected === 'midCap' || $algorithmSelected === 'smallCap' || $algorithmSelected === 'microCap') {
            $sortBy = 'market_cap';
            $sortOrder = 'dsc';
        }
    }
?>

    <div class="collection_page_banner smaller">
        <div class="container">
            <div class="collection_breadcrumb">
                <p><a href="#">US Stocks</a><span class="divider"> > </span><a href="<?php echo home_url('/us-stocks/collections/'); ?>">All Collections</a><span class="divider"> > </span><span class="current_page"><?php the_title(); ?></span></p>
            </div>
            <div class="banner_content_wrap">
                <div class="banner_content_col">
                    <h1 class="mt_0"><?php the_title(); ?></h1>
                    <p class="banner_desc"><?php the_field('collection_description', false, false); ?></p>
                    <?php if (get_field('banner_button_url')): ?>
                        <a href="<?php the_field('banner_button_url'); ?>" class="btn_dark"><?php the_field('banner_button_text'); ?></a>
                    <?php else: ?>
                        <a href="#" class="btn_dark">Invest in <?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="banner_img_col">
                    <img src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="explore_market_leaders" id="list_table" data-sort-by="<?php echo esc_attr($sortBy); ?>" data-sort-order="<?php echo esc_attr($sortOrder); ?>" data-post-num="<?php the_field('no_of_stocks_to_display'); ?>">
        <div class="container">
            <div class="market_leaders_row">
                <div class="market_leaders_col">
                    <?php
                    $post_id = get_the_ID();
                    $terms = get_the_terms($post_id, 'stocks_collections_categories');
                    $currentPageName = $terms[0]->name;
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
                            echo '<h2>Explore ' . $currentPageName . '</h2><ul>';
                            while ($related_posts->have_posts()) : $related_posts->the_post();
                                $current_class = (get_the_ID() === $post_id) ? ' class="current"' : '';
                                echo '<li' . $current_class . '><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></li>';
                            endwhile;
                            echo '</ul>';
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
                                <div class="tabs">
                                    <button class="tab-button" data-target="#tab1">Stocks</button>
                                    <button class="tab-button" data-target="#tab2">ETFs</button>
                                </div>
                            </div>
                            <div class="market_table_search">
                                <input type="text" id="stock-search" data-type="" />
                                <div class="table_mobile_sort">
                                    <div class="sort_icon">
                                        <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 6.30615C0.5 3.26859 2.96243 0.806152 6 0.806152H26C29.0376 0.806152 31.5 3.26859 31.5 6.30615V26.3062C31.5 29.3437 29.0376 31.8062 26 31.8062H6C2.96243 31.8062 0.5 29.3437 0.5 26.3062V6.30615Z" fill="white" />
                                            <path d="M0.5 6.30615C0.5 3.26859 2.96243 0.806152 6 0.806152H26C29.0376 0.806152 31.5 3.26859 31.5 6.30615V26.3062C31.5 29.3437 29.0376 31.8062 26 31.8062H6C2.96243 31.8062 0.5 29.3437 0.5 26.3062V6.30615Z" stroke="#CCD4DC" />
                                            <path d="M15.3333 19.6396L12.6667 22.3063L10 19.6396" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.666 22.3062V14.3062" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M21.9993 12.9728L19.3327 10.3062L16.666 12.9728" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M19.334 18.3062V10.3062" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="table_sort_overlay"></div>
                                    <div class="table_sort_options">
                                        <h4 class="sort_title">Sort</h4>

                                        <ul>
                                            <li data-sort="price" data-order="asc">Price</li>
                                            <li data-sort="market_cap" data-order="asc">Market Cap</li>
                                            <li data-sort="pe_ratio" data-order="asc">P/E Ratio</li>
                                            <li data-sort="one_year_returns" data-order="asc">1Y Returns</li>
                                            <li data-sort="cagr_5_year" data-order="asc">5Y CAGR</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p id="stocks_count"></p>
                        <div class="skeleton-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th data-sort="market_cap">Market Cap
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
                                        <th data-sort="one_year_returns">1Y Returns
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                        <th data-sort="cagr_5_year">5Y CAGR
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><div class="flex"><div class="skeleton skeleton-cell" style="width: 32px; height: 32px;"></div><div class="skeleton skeleton-cell" style="width: 75px; height: 38px;"></div></div></td>
                                        <td><div class="skeleton skeleton-cell" style="width: 80px; margin-bottom: 2px;"></div><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
                                        <td><div class="skeleton skeleton-cell" style="width: 100px;"></div></td>
                                        <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
                                        <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
                                        <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="stocks_table_wrap stocks_table">
                            <table id="stocks-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th data-sort="market_cap">Market Cap
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
                                        <th data-sort="one_year_returns">1Y Returns
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                        <th data-sort="cagr_5_year">5Y CAGR
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="stocks_table_wrap">
                            <table id="etf-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>AUM</th>
                                        <th>Expense Ratio</th>
                                        <th data-sort="one_year_returns">1Y Returns
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                        <th data-sort="cagr_5_year">5Y CAGR
                                            <span class="sort_data">
                                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.94188 4.57036L4.21022 0.0960542C4.1034 -0.0320181 3.89773 -0.0320181 3.78978 0.0960542L0.0581151 4.57036C-0.0805157 4.7372 0.0444792 4.9816 0.268334 4.9816H7.73167C7.95552 4.9816 8.08052 4.7372 7.94188 4.57036Z" fill="black" fill-opacity="0.25" />
                                                    <path d="M7.73167 7.0184H0.268334C0.0444792 7.0184 -0.0805157 7.2628 0.0581151 7.42964L3.78978 11.9039C3.89659 12.032 4.10227 12.032 4.21022 11.9039L7.94188 7.42964C8.08052 7.2628 7.95552 7.0184 7.73167 7.0184Z" fill="black" fill-opacity="0.25" />
                                                </svg>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Controls -->
                        <div id="pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endwhile;
?>
<?php if (have_rows('faq_list')): ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                <?php
                $faq_count = 0; // Initialize a counter to track the last FAQ item
                while (have_rows('faq_list')): the_row();
                    $faq_count++; // Increment the counter
                ?> {
                        "@type": "Question",
                        "name": "<?php the_sub_field('faq_question'); ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "<?php the_sub_field('faq_answer', false, false); ?>"
                        }
                    }
                    <?php if ($faq_count < count(get_field('faq_list'))) echo ','; // Add a comma except for the last item 
                    ?>
                <?php endwhile; ?>
            ]
        }
    </script>
<?php endif; ?>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "item": {
                "@id": "<?php echo home_url(); ?>",
                "name": "Home"
            }
        }, {
            "@type": "ListItem",
            "position": 2,
            "item": {
                "@id": "<?php echo home_url('/us-stocks/collections'); ?>",
                "name": "US Stocks Collections"
            }
        }, {
            "@type": "ListItem",
            "position": 3,
            "item": {
                "@id": "<?php echo $current_url; ?>",
                "name": "<?php the_title(); ?>"
            }
        }]
    }
</script>

<script>
    const tbody = document.querySelector('.skeleton-table tbody');
    for (let i = 0; i < 10; i++) {
        tbody.innerHTML += `
        <tr>
            <td><div class="flex"><div class="skeleton skeleton-cell" style="width: 32px; height: 32px;"></div><div class="skeleton skeleton-cell" style="width: 75px; height: 38px;"></div></div></td>
            <td><div class="skeleton skeleton-cell" style="width: 80px; margin-bottom: 2px;"></div><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
            <td><div class="skeleton skeleton-cell" style="width: 100px;"></div></td>
            <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
            <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
            <td><div class="skeleton skeleton-cell" style="width: 80px;"></div></td>
        </tr>
        `;
    }
</script>

<?php

get_footer();
