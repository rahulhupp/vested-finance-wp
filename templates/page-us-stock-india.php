<?php
/*
Template name: Page - US Stock India
*/
get_header();
?>
<div id="content" role="main">
    <section class="us-stock-banner">
        <div class="container">
            <div class="us-stock-banner-content">
                <h1><?php the_field('banner_title'); ?></h1>
                <?php the_field('banner_description'); ?>
                <p><?php the_field('banner_learn_more_heading'); ?></p>
                <div class="us-stock-banner-buttons">
                    <p><?php the_field('nri_text'); ?></p>
                    <a href="<?php echo esc_url(get_field('banner_button')['banner_button_url']); ?>" class="btn">
                        <?php echo esc_html(get_field('banner_button')['banner_button_label']); ?>
                    </a>
                </div>
            </div>
            <div class="us-stock-banner-image">
                <?php
                $image = get_field('banner_image');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="us-stock-popup-overlay">
        <div class="us-stock-popup">
            <div class="close-btn">
                <i class="fa fa-times"></i>
            </div>
            <p><?php the_field('banner_learn_more_text'); ?></p>
        </div>
    </div>

    <section class="us-stock-stocks-section">
        <div class="container">
            <h2>Most Popular US Stocks by Indian Investors</h2>
            <p>Access 10,000+ US Stocks and ETFs with a trusted global platform</p>
            <div class="us-stock-stocks-search">
                <div class="stock-search-field">
                    <input type="text" id="stockSearchInput" placeholder="Search any US Stocks or ETF..." autocomplete="off">
                    <img class="search-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/search-icon.webp" alt="Search">
                    <div class="clear-icon" id="clearSearchIcon" style="display: none;">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="stock-results-container">
                    <ul id="stockResultsList" class="stock-results-list">
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/aapl/apple-inc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/AAPL.png" alt="Apple Inc" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Apple Inc</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/googl/alphabet-inc-class-a-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/GOOGL.png" alt="Alphabet Inc Class A" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Alphabet Inc Class A</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/msft/microsoft-corporation-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/MSFT.png" alt="Microsoft Corporation" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Microsoft Corporation</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/tsla/tesla-inc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/TSLA.png" alt="Tesla Inc" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Tesla Inc</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/meta/meta-platforms-inc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/META.png" alt="Meta Platforms Inc." onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Meta Platforms Inc.</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/nflx/netflix-inc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/NFLX.png" alt="Netflix Inc" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Netflix Inc</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/amzn/amazon-com-inc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/AMZN.png" alt="Amazon.com Inc" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Amazon.com Inc</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/nvda/nvidia-corporation-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/NVDA.png" alt="NVIDIA Corporation" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">NVIDIA Corporation</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/spot/spotify-technology-sa-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/SPOT.png" alt="Spotify Technology SA" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Spotify Technology SA</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="stock-item">
                            <a href="https://vestedfinance.com/us-stocks/ivz/invesco-plc-share-price/" rel="nofollow">
                                <div class="stock-item-content">
                                    <div class="stock-image">
                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/IVZ.png" alt="Invesco Plc" onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                                    </div>
                                    <div class="stock-info">
                                        <div class="stock-name">Invesco Plc</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="us-stock-stocks-buttons">
                    <a href="https://app.vestedfinance.com/signup" class="btn">Invest in US Stocks</a>
                </div>
            </div>
            <p class="disclaimer">Disclosure: This list is representative of stocks available but is not intended to recommend any investment.</p>
        </div>                
    </section>

    <section class="us-stock-collection-section">
        <div class="container">
            <h2>Explore US Stock Collections</h2>
            <p>Discover curated collections of US Stocks designed to match your goals and simplify your investing decisions</p>
            <?php
                $taxonomy = 'stocks_collections_categories';
                $terms = get_terms($taxonomy);
            ?>
            <div class="us-stock-collections-list">
                <?php
                foreach ($terms as $term) :
                    $category_name = $term->name;
                    
                    // Exclude "Popular on Vested" category
                    if ($category_name === 'Popular on Vested') {
                        continue;
                    }
                    
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
                    $category_image = get_field('collection_image', $term);

                    $term_query = new WP_Query($term_args);
                    $post_count = $term_query->post_count;
                    $first_post_url = '';
                ?>
                    <div class="us-stock-collection-item">
                        <div class="us-stock-collection-content">
                            <div class="us-stock-collection-image">
                                <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_name); ?>">
                            </div>
                            <h3 class="us-stock-collection-title"><?php echo esc_html($category_name); ?></h3>
                        </div>
                        <?php if ($post_count > 0) : ?>
                            <ul class="us-stock-collection-categories">
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
                                    <li class="us-stock-collection-category">
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                                            <?php echo esc_html($collection_name); ?>
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
            <div class="us-stock-collections-buttons">
                <a href="<?php echo home_url(); ?>/us-stock-collections/" class="btn">Explore All Collections</a>
            </div>
        </div>
    </section>

    <section class="us-stock-why-invest-section">
        <div class="container">
            <h2><?php the_field('why_invest_title'); ?></h2>
            <p><?php the_field('why_invest_sub_title'); ?></p>
            <div class="us-stock-why-invest-list">
                <?php if (have_rows('why_invest_list')) : ?>
                    <?php 
                    $item_index = 0;
                    while (have_rows('why_invest_list')) : the_row(); ?>
                        <div class="us-stock-why-invest-item">
                            <h3><?php the_sub_field('why_invest_item_title'); ?></h3>
                            <p><?php the_sub_field('why_invest_item_content'); ?></p>
                            <div class="us-stock-why-invest-item-image">
                                <?php
                                $image = get_sub_field('why_invest_item_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                                <?php if ($item_index === 2) : ?>
                                <div class="extra-content">
                                    <div class="extra-content-items">
                                        <span>India Markets</span>
                                        <span>Global Markets</span>
                                    </div>
                                    <a href="#">Why US Markets deliver higher returns?</a>
                                    <span>Past performance is no guarantee of future results.</span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php 
                    $item_index++;
                    endwhile; ?>
                <?php endif; ?>
            </div>
            <p class="us-stock-why-invest-disclosure"><?php the_field('why_invest_disclosure'); ?></p>
        </div>
    </section>

    <section class="us-stock-why-choose-section">
        <div class="container">
            <h2><?php the_field('why_choose_title'); ?></h2>
            <p><?php the_field('why_choose_sub_title'); ?></p>
            <div class="us-stock-why-choose-list" id="us-stock-why-choose-slider">
                <?php if (have_rows('why_choose_slider_list')) : ?>
                    <?php while (have_rows('why_choose_slider_list')) : the_row(); ?>
                        <div class="us-stock-why-choose-item">
                            <div class="us-stock-why-choose-item-image">
                                <?php
                                $image = get_sub_field('why_choose_slider_item_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                            </div>
                            <h3><?php the_sub_field('why_choose_slider_item_title'); ?></h3>
                            <p><?php the_sub_field('why_choose_slider_item_description'); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="us-stock-why-choose-slider-nav">
                <button class="us-stock-why-choose-slider-button-prev">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="-0.85" y="0.85" width="46.3" height="46.3" rx="23.15" transform="matrix(-1 0 0 1 46.3 0)" stroke="#8E9DAD" stroke-width="1.7"/>
                        <path d="M28 15L18.7774 24.2226L28 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                    </svg>
                </button>
                <button class="us-stock-why-choose-slider-button-next">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.85" y="0.85" width="46.3" height="46.3" rx="23.15" stroke="#8E9DAD" stroke-width="1.7"/>
                        <path d="M19 15L28.2226 24.2226L19 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                    </svg>
                </button>
            </div>
        </div>
        <p class="us-stock-why-choose-disclosure"><?php the_field('why_choose_disclosure'); ?></p>
    </section>

    <section class="us-stock-return-calculator-section">
        <div class="container">
            <h2>US Stock Return Calculator</h2>
            <p>View how your investment would have performed over a selected historical period</p>
            <?php get_template_part('template-parts/stocks-calculator-us-stock-india'); ?>
            <p class="us-stock-return-calculator-disclaimer">This calculator utilizes dividend and split adjusted close price of third business day of start and end months to calculate returns. The total return, annualized return, and the hypothetical portfolio value of the investment amount are computed based on the first and last prices within the selected range.</p>
        </div>
    </section>

    <section class="us-stocks-steps-section">
        <div class="container">
            <h2><?php the_field('steps_title'); ?></h2>
            <div class="us-stocks-steps-list">
                <?php if (have_rows('steps_list')) : ?>
                    <?php while (have_rows('steps_list')) : the_row(); ?>
                        <div class="us-stocks-step-item">
                            <div class="us-stocks-step-item-content">
                                <h3><?php the_sub_field('step_item_title'); ?></h3>
                                <p><?php the_sub_field('step_item_description'); ?></p>
                            </div>
                            <div class="us-stocks-step-item-image">
                                <?php
                                $image = get_sub_field('step_item_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="us-stocks-steps-buttons">
                <a href="<?php echo esc_url(get_field('steps_button')['steps_button_link']); ?>" class="btn">
                    <?php echo esc_html(get_field('steps_button')['steps_button_text']); ?>
                </a>
            </div>
        </div>
    </section>

    <?php if (have_rows('investors_reviews', 'option')) : ?>
        <section class="us-stock-investors-section">
            <div class="container">
                <h2>Why Investors Choose Vested</h2>
                <p>Read about experiences of those who have taken their portfolio global</p>
                <div class="us-stock-investors-list" id="us-stock-investors-slider">
                    <?php while (have_rows('investors_reviews', 'option')) : the_row(); ?>
                        <div class="us-stock-investors-item">
                            <div class="us-stock-investors-item-info">
                                <div class="us-stock-investors-item-image">
                                    <img src="<?php the_sub_field('investor_image') ?>" alt="<?php the_sub_field('investor_name') ?>">
                                </div>
                                <div class="us-stock-investors-item-content">
                                    <h4><?php the_sub_field('investor_name') ?></h4>
                                    <p><?php the_sub_field('investor_designation') ?></p>
                                </div>
                            </div>
                            <div class="us-stock-investors-item-review">
                                <?php the_sub_field('investor_review') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="us-stock-investors-slider-nav">
                    <button class="us-stock-investors-slider-button-prev">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.85" y="0.85" width="46.3" height="46.3" rx="23.15" transform="matrix(-1 0 0 1 46.3 0)" stroke="#8E9DAD" stroke-width="1.7"/>
                            <path d="M28 15L18.7774 24.2226L28 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                        </svg>
                    </button>
                    <button class="us-stock-investors-slider-button-next">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.85" y="0.85" width="46.3" height="46.3" rx="23.15" stroke="#8E9DAD" stroke-width="1.7"/>
                            <path d="M19 15L28.2226 24.2226L19 33.4452" stroke="#8E9DAD" stroke-width="1.7"/>
                        </svg>
                    </button>
                </div>
                <p class="us-stock-investors-disclaimer">These customers were not paid for their testimonials and may not be representative of the experience of other customers. These testimonials are no guarantee of future performance or success.</p>
            </div>
        </section>
    <?php endif; ?>

    <section class="us-stock-blogs-section">
        <div class="container">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'master_categories',
                        'field'    => 'slug',
                        'terms'    => array('us-stocks'),
                    ),
                ),
            );

            $custom_query = new WP_Query($args);
            $has_blogs = $custom_query->have_posts();
            ?>
            <?php if ($has_blogs) : ?>
                <h2>Invest with Confidence: Read our Blogs</h2>
                <div class="us-stock-blogs-list">
                    <?php
                    while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                        <a href="<?php echo get_permalink() ?>" class="us-stock-blog-item">
                            <?php the_post_thumbnail(); ?>
                            <h4><?php the_title(); ?></h4>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="us-stock-partners-section">
        <div class="container">
            <h2><?php the_field('partners_title'); ?></h2>
            <p><?php the_field('partners_sub_title'); ?></p>
            <?php if (have_rows('partners_list')) : ?>
                <div class="us-stock-partners-list">
                    <?php while (have_rows('partners_list')) : the_row(); ?>
                        <div class="us-stock-partner-item">
                            <?php
                            $image = get_sub_field('partner_logo');
                            if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <div class="us-stock-partners-buttons">
                <a href="<?php echo esc_url(get_field('partners_button')['partners_button_link']); ?>" class="btn">
                    <?php echo esc_html(get_field('partners_button')['partners_button_text']); ?>
                </a>
            </div>
        </div>
    </section>
    
    <section class="us-stock-learn-more-section">
        <div class="container">
            <h2><?php the_field('learn_more_title'); ?></h2>
            <div class="us-stock-learn-more-content collapsed" id="learnMoreContent">
                <?php the_field('learn_more_description'); ?>            
            </div>
            <div class="us-stock-learn-more-buttons">
                <a class="btn read-more-btn" id="readMoreBtn">Read More</a>
            </div>
        </div>
    </section>

    <?php if (have_rows('faq_list')) : ?>
        <section class="us-stock-faqs-section">
            <div class="container">
                <h2><?php the_field('faqs_heading'); ?></h2>
                <div class="us-stock-faqs-list">
                    <?php while (have_rows('faq_list')) : the_row(); ?>
                        <div class="us-stock-faq-item">
                            <div class="us-stock-faq-question">
                                <span><?php the_sub_field('faq_question') ?></span>
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4131 0.000480166L12.1636 0.000480503L12.1636 12.1643L-0.000245424 12.1643V15.4138L12.1636 15.4138L12.1636 27.5776L15.4131 27.5776L15.4131 15.4138H27.5769V12.1643H15.4131L15.4131 0.000480166Z" fill="#021930"/>
                                </svg>
                            </div>
                            <div class="us-stock-faq-answer">
                                <?php the_sub_field('faq_answer') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php if (have_rows('faq_list')) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $rowCount = 0; ?>
        <?php while (have_rows('faq_list')) : the_row(); ?>
            {
                "@type": "Question",
                "name": <?php echo json_encode(get_sub_field('faq_question')); ?>,
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": <?php echo json_encode(get_sub_field('faq_answer')); ?>
                }
            }<?php echo (++$rowCount === count(get_field('faq_list'))) ? '' : ','; ?>
        <?php endwhile; ?>
    ]
}
</script>
<?php endif; ?>

<?php
// BreadcrumbList Schema
$current_url = get_permalink();
$site_name = get_bloginfo('name');
$home_url = home_url();
$page_title = get_the_title();
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": <?php echo json_encode($site_name); ?>,
            "item": <?php echo json_encode($home_url); ?>
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": <?php echo json_encode($page_title); ?>,
            "item": <?php echo json_encode($current_url); ?>
        }
    ]
}
</script>

<?php
// Organization Schema
$site_name = get_bloginfo('name');
$site_url = home_url();
$site_description = get_bloginfo('description');
$custom_logo_id = get_theme_mod('custom_logo');
$logo_url = '';
if ($custom_logo_id) {
    $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
}
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": <?php echo json_encode($site_name); ?>,
    "url": <?php echo json_encode($site_url); ?><?php if ($site_description) : ?>,
    "description": <?php echo json_encode($site_description); ?><?php endif; ?><?php if ($logo_url) : ?>,
    "logo": <?php echo json_encode($logo_url); ?><?php endif; ?>
}
</script>

<?php
// WebPage Schema
$page_title = get_the_title();
$page_url = get_permalink();
$page_description = '';
if (get_field('banner_description')) {
    $page_description = wp_strip_all_tags(get_field('banner_description'));
    $page_description = wp_trim_words($page_description, 30, '...');
} elseif (get_bloginfo('description')) {
    $page_description = get_bloginfo('description');
}
$page_date_published = get_the_date('c');
$page_date_modified = get_the_modified_date('c');
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": <?php echo json_encode($page_title); ?>,
    "url": <?php echo json_encode($page_url); ?><?php if ($page_description) : ?>,
    "description": <?php echo json_encode($page_description); ?><?php endif; ?>,
    "datePublished": <?php echo json_encode($page_date_published); ?>,
    "dateModified": <?php echo json_encode($page_date_modified); ?>,
    "inLanguage": "en-US",
    "isPartOf": {
        "@type": "WebSite",
        "name": <?php echo json_encode(get_bloginfo('name')); ?>,
        "url": <?php echo json_encode(home_url()); ?>
    }
}
</script>

<?php
// ItemList Schema for Stocks
$default_stocks = ['AAPL', 'GOOGL', 'MSFT', 'TSLA', 'META', 'NFLX', 'AMZN', 'NVDA', 'SPOT', 'IVZ'];
$stock_items = [];
foreach ($default_stocks as $position => $symbol) {
    $formatted_symbol = strtolower($symbol);
    // Stock URLs follow pattern: /us-stocks/{symbol}/{name}-share-price/
    // Since we don't have stock names in PHP, we'll use a simplified URL structure
    $stock_url = 'https://vestedfinance.com/us-stocks/' . $formatted_symbol . '/';
    $stock_items[] = [
        '@type' => 'ListItem',
        'position' => $position + 1,
        'name' => $symbol,
        'item' => $stock_url
    ];
}
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Most Popular US Stocks by Indian Investors",
    "description": "Access 10,000+ US Stocks and ETFs with a trusted global platform",
    "itemListElement": <?php echo json_encode($stock_items, JSON_UNESCAPED_SLASHES); ?>
}
</script>

<?php
// ItemList Schema for Collections
$taxonomy = 'stocks_collections_categories';
$terms = get_terms(array(
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
));
$collection_items = [];
$position = 1;

foreach ($terms as $term) {
    $category_name = $term->name;
    
    // Exclude "Popular on Vested" category
    if ($category_name === 'Popular on Vested') {
        continue;
    }
    
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
    );
    
    $term_query = new WP_Query($term_args);
    
    if ($term_query->have_posts()) {
        while ($term_query->have_posts()) {
            $term_query->the_post();
            $collection_name = get_the_title();
            $collection_url = get_permalink();
            
            $collection_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $collection_name,
                'item' => $collection_url
            ];
        }
        wp_reset_postdata();
    }
}
?>
<?php if (!empty($collection_items)) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Explore US Stock Collections",
    "description": "Discover curated collections of US Stocks designed to match your goals and simplify your investing decisions",
    "itemListElement": <?php echo json_encode($collection_items, JSON_UNESCAPED_SLASHES); ?>
}
</script>
<?php endif; ?>

<script>
(function() {
    const defaultStocks = ['AAPL', 'GOOGL', 'MSFT', 'TSLA', 'META', 'NFLX', 'AMZN', 'NVDA', 'SPOT', 'IVZ'];
    let authToken = null;
    let searchTimeout = null;
    let allInstruments = [];
    // Preserve the baked-in static list so we can restore it when APIs fail or return nothing
    const staticListHTML = (() => {
        const el = document.getElementById('stockResultsList');
        return el ? el.innerHTML : '';
    })();

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeStockSearch();
    });

    async function initializeStockSearch() {
        await getAuthToken();
        await loadInstrumentsList();
        loadDefaultStocks();
        setupSearchInput();
    }

    async function getAuthToken() {
        try {
            const response = await fetch('https://vested-api-prod.vestedfinance.com/get-partner-token', {
                method: 'GET',
                headers: {
                    'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
                    'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
                    'lead-token-access': 'true'
                }
            });
            const tokenData = await response.json();
            if (tokenData && tokenData.csrf && tokenData.jwToken) {
                authToken = {
                    csrf: tokenData.csrf,
                    jwToken: tokenData.jwToken
                };
            }
        } catch (error) {
            console.error('Error getting auth token:', error);
        }
    }

    async function loadInstrumentsList() {
        try {
            const tokenResponse = await fetch('https://vested-api-prod.vestedfinance.com/get-partner-token', {
                method: 'GET',
                headers: {
                    'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
                    'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
                    'instrument-list-access': 'true'
                }
            });
            const partnerToken = await tokenResponse.text();
            
            const instrumentsResponse = await fetch('https://vested-api-prod.vestedfinance.com/v1/partner/instruments-list', {
                method: 'GET',
                headers: {
                    'partner-authentication-token': partnerToken,
                    'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9'
                }
            });
            const instrumentsData = await instrumentsResponse.json();
            if (instrumentsData && instrumentsData.instruments) {
                console.log('instrumentsData', instrumentsData);
                allInstruments = instrumentsData.instruments;
            }
        } catch (error) {
            console.error('Error loading instruments list:', error);
        }
    }

    function setupSearchInput() {
        const searchInput = document.getElementById('stockSearchInput');
        const clearIcon = document.getElementById('clearSearchIcon');

        searchInput.addEventListener('input', function() {
            const value = this.value.trim();
            
            if (value.length > 0) {
                clearIcon.style.display = 'flex';
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                searchTimeout = setTimeout(() => {
                    performSearch(value);
                }, 500);
            } else {
                clearIcon.style.display = 'none';
                loadDefaultStocks();
            }
        });

        clearIcon.addEventListener('click', function() {
            searchInput.value = '';
            clearIcon.style.display = 'none';
            loadDefaultStocks();
        });
    }

    function displaySkeletonLoading(count = 10) {
        const resultsList = document.getElementById('stockResultsList');
        resultsList.innerHTML = '';
        
        for (let i = 0; i < count; i++) {
            const li = document.createElement('li');
            li.className = 'stock-item skeleton-loading';
            li.innerHTML = `
                <div style="display: block; height: 100%; padding: 16px;">
                    <div class="stock-item-content">
                        <div class="stock-image">
                            <div class="skeleton-box skeleton-shimmer"></div>
                        </div>
                        <div class="stock-info">
                            <div class="stock-name">
                                <div class="skeleton-box skeleton-shimmer" style="width: 80%; height: 20px; margin: 0 auto;"></div>
                            </div>
                        </div>
                        <div class="stock-price-info">
                            <div class="stock-price">
                                <div class="skeleton-box skeleton-shimmer" style="width: 60%; height: 20px; margin: 8px auto 0;"></div>
                            </div>
                            <div class="stock-change">
                                <div class="skeleton-box skeleton-shimmer" style="width: 70%; height: 16px; margin: 4px auto 0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            resultsList.appendChild(li);
        }
    }

    async function performSearch(searchTerm) {
        if (!allInstruments.length) {
            return;
        }

        const resultsList = document.getElementById('stockResultsList');
        displaySkeletonLoading(3); // Show 3 skeleton cards for search results

        const searchLower = searchTerm.toLowerCase().trim();
        const searchUpper = searchTerm.toUpperCase().trim();
        const searchTrimmed = searchTerm.trim();
        
        // Split search term into words for better matching (used in both filter and sort)
        const searchWords = searchLower.split(/\s+/).filter(word => word.length > 0);
        const isMultiWordSearch = searchWords.length > 1;
        
        // Check if search term looks like a ticker (short, alphanumeric, typically 1-5 chars)
        // A ticker is typically: all uppercase, 1-5 chars, alphanumeric, no spaces
        // If it's all lowercase and longer than 3 chars, it's probably a word, not a ticker
        const isShortAlphanumeric = /^[A-Z0-9]{1,5}$/i.test(searchTrimmed);
        const isAllUppercase = searchTrimmed === searchUpper;
        const isAllLowercase = searchTrimmed === searchLower;
        const looksLikeTicker = isShortAlphanumeric && (isAllUppercase || (isAllLowercase && searchTrimmed.length <= 3));
        // Only treat as ticker if it's all uppercase
        const isTickerSearch = isShortAlphanumeric && isAllUppercase;
        
        let filtered = allInstruments.filter(instrument => {
            const instrumentSymbol = instrument.symbol.toLowerCase();
            const instrumentName = instrument.name.toLowerCase();
            
            // First, always check for exact symbol match (case-insensitive)
            // This handles "aapl" -> "AAPL" or "AAPL" -> "AAPL"
            if (instrumentSymbol === searchLower) {
                return true;
            }
            
            // For uppercase ticker searches, only return exact symbol matches
            if (isTickerSearch) {
                return false; // Already checked above
            }
            
            // If search looks like a ticker (even lowercase), be more strict
            // Only match if symbol appears in parentheses in the name
            if (looksLikeTicker) {
                const symbolInName = instrumentName.includes(`(${searchUpper})`) || 
                                     instrumentName.includes(`(${searchLower})`);
                return symbolInName;
            }
            
            // For name searches, check multiple conditions
            // Check if name starts with the full search term (exact phrase match)
            const nameStartsWith = instrumentName.startsWith(searchLower);
            
            // For multi-word searches, prioritize exact phrase matches
            if (isMultiWordSearch) {
                // First check if name starts with the exact search phrase
                if (nameStartsWith) {
                    return true;
                }
                // For multi-word, also check if the phrase appears as a whole (not just individual words)
                const escapedSearch = searchLower.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const phraseMatch = new RegExp(`\\b${escapedSearch}`, 'i').test(instrumentName);
                if (phraseMatch) {
                    return true;
                }
                // Don't match multi-word searches if words are scattered
                return false;
            }
            
            // For single-word searches, check if all search words appear in the name (with word boundaries)
            let allWordsMatch = true;
            if (searchWords.length > 0) {
                for (const word of searchWords) {
                    const escapedWord = word.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const wordRegex = new RegExp(`\\b${escapedWord}`, 'i');
                    if (!wordRegex.test(instrumentName)) {
                        allWordsMatch = false;
                        break;
                    }
                }
            }
            
            // Check if symbol appears in parentheses in the name (e.g., "Apple (AAPL)")
            const symbolInName = instrumentName.includes(`(${searchUpper})`) || 
                                 instrumentName.includes(`(${searchLower})`);
            
            // For single-word searches, return true if name starts with search, all words match, or symbol is in name
            return nameStartsWith || allWordsMatch || symbolInName;
        });
        
        // Sort results to prioritize better matches
        filtered.sort((a, b) => {
            const aSymbol = a.symbol.toLowerCase();
            const bSymbol = b.symbol.toLowerCase();
            const aName = a.name.toLowerCase();
            const bName = b.name.toLowerCase();
            
            // First priority: Exact symbol match
            const aSymbolMatch = aSymbol === searchLower;
            const bSymbolMatch = bSymbol === searchLower;
            if (aSymbolMatch && !bSymbolMatch) return -1;
            if (!aSymbolMatch && bSymbolMatch) return 1;
            
            // Second priority: Exact phrase match (name equals or starts with search term)
            const aStartsWith = aName.startsWith(searchLower);
            const bStartsWith = bName.startsWith(searchLower);
            if (aStartsWith && !bStartsWith) return -1;
            if (!aStartsWith && bStartsWith) return 1;
            
            // For multi-word searches, prioritize exact phrase matches
            if (isMultiWordSearch) {
                const escapedSearch = searchLower.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const phraseRegex = new RegExp(`\\b${escapedSearch}`, 'i');
                const aPhraseMatch = phraseRegex.test(aName);
                const bPhraseMatch = phraseRegex.test(bName);
                if (aPhraseMatch && !bPhraseMatch) return -1;
                if (!aPhraseMatch && bPhraseMatch) return 1;
            }
            
            // Third priority: Symbol in name (in parentheses)
            const aSymbolInName = aName.includes(`(${searchUpper})`) || aName.includes(`(${searchLower})`);
            const bSymbolInName = bName.includes(`(${searchUpper})`) || bName.includes(`(${searchLower})`);
            if (aSymbolInName && !bSymbolInName) return -1;
            if (!aSymbolInName && bSymbolInName) return 1;
            
            // Fourth priority: Position of match (earlier is better)
            const aIndex = aName.indexOf(searchLower);
            const bIndex = bName.indexOf(searchLower);
            if (aIndex !== -1 && bIndex !== -1 && aIndex !== bIndex) return aIndex - bIndex;
            
            // Finally, alphabetical
            return aName.localeCompare(bName);
        });
        
        filtered = filtered.slice(0, 20); // Limit to 20 results

        console.log('filtered', filtered);
        if (filtered.length > 0) {
            // Fetch price data for filtered stocks
            const stockPromises = filtered.map(instrument => fetchStockData(instrument.symbol));
            console.log('stockPromises', stockPromises);
            const stockData = await Promise.all(stockPromises);
            console.log('stockData', stockData);
            const validStocks = stockData.filter(stock => stock !== null);
            console.log('validStocks', validStocks);
            
            if (validStocks.length > 0) {
                displayStocks(validStocks);
            } else {
                displayNoResults();
            }
        } else {
            displayNoResults();
        }
    }

    // Try to load default stocks via API; if anything fails, keep/restore the static list
    async function loadDefaultStocks() {
        const resultsList = document.getElementById('stockResultsList');
        if (!resultsList) return;

        try {
            if (!authToken) {
                await getAuthToken();
            }

            // Show skeletons while fetching
            displaySkeletonLoading(10);

            const stockPromises = defaultStocks.map(symbol => fetchStockData(symbol));
            const stockData = await Promise.all(stockPromises);
            const validStocks = stockData.filter(stock => stock !== null);

            if (validStocks.length > 0) {
                displayStocks(validStocks);
            } else {
                // Fallback to static list if no valid API data
                if (staticListHTML) {
                    resultsList.innerHTML = staticListHTML;
                } else {
                    resultsList.innerHTML = '<li class="no-results">Unable to load stocks at this time.</li>';
                }
            }
        } catch (err) {
            console.warn('Default stock load failed, using static list', err);
            if (staticListHTML) {
                resultsList.innerHTML = staticListHTML;
            } else {
                resultsList.innerHTML = '<li class="no-results">Unable to load stocks at this time.</li>';
            }
        }
    }

    function normalizeStockType(type) {
        if (!type) return 'stock';
        
        const typeLower = type.toLowerCase();
        
        // Check for ETF types
        if (typeLower.includes('etf') || typeLower.includes('exchange traded fund')) {
            return 'etf';
        }
        
        // Check for stock types (Common Stock, Preferred Stock, etc.)
        if (typeLower.includes('stock') || typeLower === 'stock') {
            return 'stock';
        }
        
        // Default to stock if unknown
        return 'stock';
    }

    async function fetchStockData(symbol) {
        if (!authToken) {
            return null;
        }

        try {
            const response = await fetch(`https://vested-woodpecker-prod.vestedfinance.com/instrument/${symbol}/overview`, {
                method: 'GET',
                headers: {
                    'x-csrf-token': authToken.csrf,
                    'Authorization': 'Bearer ' + authToken.jwToken
                }
            });

            if (!response.ok) {
                return null;
            }

            const data = await response.json();
            if (data && data.data) {
                return {
                    symbol: data.data.ticker || symbol,
                    name: data.data.name,
                    price: data.data.price,
                    change: data.data.change,
                    changePercent: data.data.changePercent,
                    type: normalizeStockType(data.data.type)
                };
            }
        } catch (error) {
            console.error(`Error fetching data for ${symbol}:`, error);
        }
        return null;
    }

    function displayStocks(stocks) {
        const resultsList = document.getElementById('stockResultsList');
        resultsList.innerHTML = '';

        console.log('stocks', stocks);

        stocks.forEach(stock => {
            const li = document.createElement('li');
            li.className = 'stock-item';

            const changeClass = stock.change < 0 ? 'negative' : '';
            const changeSign = stock.change >= 0 ? '+' : '';
            const changePercentSign = stock.changePercent >= 0 ? '+' : '';

            const formattedName = stock.name.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            const formattedSymbol = stock.symbol.toLowerCase().replace(/\s+/g, '-');
            // console.log('stock', stock);
            // console.log('stock.symbol', stock.symbol);
            // console.log('stock.type', stock.type);
            // console.log('==============================================');
            const stockUrl = stock.type === 'stock' 
                ? `https://vestedfinance.com/us-stocks/${formattedSymbol}/${formattedName}-share-price/`
                : `https://vestedfinance.com/us-stocks/etf/${formattedSymbol}/${formattedName}-share-price/`;

            li.innerHTML = `
                <a href="${stockUrl}">
                    <div class="stock-item-content">
                        <div class="stock-image">
                            <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/${stock.symbol}.png" 
                                 alt="${stock.name}" 
                                 onerror="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-stock.png'">
                        </div>
                        <div class="stock-info">
                            <div class="stock-name">${stock.name}</div>
                        </div>
                        <div class="stock-price-info">
                            <div class="stock-price">$${parseFloat(stock.price).toFixed(2)}</div>
                            <div class="stock-change ${changeClass}">
                                <span class="change-amount">${changeSign}$${Math.abs(parseFloat(stock.change)).toFixed(2)}</span>
                                <span class="change-percent">
                                    (
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.89722 0L7.79433 7.5H0.000102484L3.89722 0Z" fill="#05A86B"/>
                                    </svg>
                                    ${changePercentSign}${parseFloat(stock.changePercent).toFixed(2)}%
                                    )
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            `;
            resultsList.appendChild(li);
        });
    }

    function displayNoResults() {
        const resultsList = document.getElementById('stockResultsList');
        // Fall back to the static list if we have it, otherwise show a simple message
        if (staticListHTML) {
            resultsList.innerHTML = staticListHTML;
        } else {
            resultsList.innerHTML = '<li class="no-results">No stocks found. Please try a different search term.</li>';
        }
    }
})();
</script>

<?php get_footer(); ?>