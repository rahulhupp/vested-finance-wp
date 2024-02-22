<?php
/*
Template name: Page - US Stock Global
*/
get_header(); ?>
<div id="content" role="main" class="calc-page">

    <section class="stock-info">
        <div class="container">
            <div class="stock-row">
                <div class="stock-content">
                    <?php the_field('stock_content_global'); ?>
                    <div class="bottom">
                        <div class="buttons">
                            <a class="btn_dark" href="<?php the_field('start_investing_link_global'); ?>"><?php the_field('start_investing_label_global'); ?></a>
                            <!-- <a class="btn_light" href="#"><i class="fa fa-play" aria-hidden="true"></i><?php the_field('watch_video_label'); ?></a> -->
                        </div>
                    </div>
                </div>
                <div class="stock-image">
                    
                    <?php
$image = get_field('stock_image_global');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>"/>
                          <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="banner_popup_overlay">
            <div class="banner_popup">
                <div class="close_btn"><i class="fa fa-times"></i></div>
                <p>This page contains information on investing in US Stocks and ETFs via Vested. Securities mentioned on this page are offered through VF Securities, Inc. (member FINRA/SIPC). Alternative investment options outside of US Stocks and ETFs, that are offered on other sections of the website are not FINRA regulated and not protected by the SIPC. Stocks displayed are a representative sample of the watchlist feature and is not intended as a recommendation.</p>
            </div>
        </div>
    </section>

    <section class="why_invest">
        <div class="container">
            <div class="why_invest_block">
                <h2 class="section_title align_left light"><span><?php the_field('why_inveset_heading_global'); ?></span></h2>

                <div class="why_invest_wrap">
                    <div class="why_invest_content">

                        <h3><?php the_field('why_inveset_text_global'); ?></h3>

                    </div>
                    <div class="why_invest_img">
                       
                        <?php
$image = get_field('why_inveset_image_global');
                          if (!empty($image)): ?>
                              <img src="<?php echo esc_url($image['url']); ?>"
                                  alt="<?php echo esc_attr($image['alt']); ?>"/>
                          <?php endif; ?>
                        <p class="img_source"><?php the_field('why_inveset_img_source_global'); ?></p>
                    </div>
                </div>
            </div>
            <p class="diclosure"><?php the_field('why_inveset_disclosure_global'); ?></p>
        </div>
    </section>

    <?php get_template_part('template-parts/us-stock-search'); ?>

    <?php get_template_part('template-parts/us-stock-vests'); ?>
    
    <?php if (have_rows('stocks_slider_global')) : ?>
        <section class="stocks_slider_sec">
            <div class="container">
                <h2 class="section_title desktop_hide">
                    <span><?php the_field('stocks_slider_heading_global'); ?></span>
                </h2>
                <div class="stocks_slider_wrap">
                    <div class="stocks_slider_inner">
                        <h2 class="section_title align_left mobile_hide">
                            <span><?php the_field('stocks_slider_heading_global'); ?></span>
                        </h2>
                        <div class="stocks_slider_content">

                            <?php while (have_rows('stocks_slider_global')) : the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('stocks_slider_slider_title_global') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('stocks_slider_slider_description_global') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="us_stocks_slider stock-single-item">
                        <?php while (have_rows('stocks_slider_global')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                 <?php
                                            $image = get_sub_field('stocks_slider_image_global');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <?php the_field('slider_disclaimer_global'); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php
        $chart = 'false';
    ?>
    <?php get_template_part('template-parts/stocks-calculator'); ?>
    
    <?php if (have_rows('portfolio_slider_global')) : ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title">
                    <span><?php the_field('portfolio_heading_global'); ?></span>
                </h2>
                <div class="portfolio_slider_wrap">
                    <div class="portfolio_slider slider single-item">
                        <?php while (have_rows('portfolio_slider_global')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                 <?php
                                            $image = get_sub_field('slider_image_global');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (have_rows('portfolio_slider_global')) : ?>
                        <div class="portfolio_slider_content">
                            <?php while (have_rows('portfolio_slider_global')) : the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('slider_title_global') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('slider_description_global') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/investors-slider'); ?>

    <section class="post-type-list">
        <div class="container">
            <h2>Invest wisely with clarity and conviction</h2>
            <div class="post-listing">
                <div class="head">
                    <div class="left-part">
                        <h3>Under the Spotlight</h3>
                        <a href="<?php echo home_url() ?>/blog/us-stocks/under-the-spotlight/">View All</a>

                    </div>
                    <div class="short-content">
                        <p>Deep-dive articles on the long-term prospects of U.S. companies, with our in-depth research.</p>
                    </div>
                </div>
                <ul>
                    <?php
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'master_categories', // Replace with your actual taxonomy name
                                'field'    => 'slug', // Change to 'term_id', 'name', or 'slug' as needed
                                'terms'    => 'under-the-spotlight', // Replace with the term you want to display
                            ),
                        ),
                    );

                    $custom_query = new WP_Query($args);
                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                            <li>
                                <a href="<?php echo get_permalink() ?>">
                                    <?php the_post_thumbnail(); ?>
                                    <h4><?php the_title(); ?></h4>
                                </a>
                            </li>
                    <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </ul>
            </div>
            <div class="post-listing">  
                <div class="head">
                    <div class="left-part">
                        <h3>Vested Shorts</h3>
                        <a href="<?php echo home_url() ?>/blog/us-stocks/vested-shorts/">View All</a>

                    </div>
                    <div class="short-content">
                        <p>Bite-sized insights on market updates and trends to stay ahead of the curve.</p>
                    </div>
                </div>
                <ul>
                    <?php
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'master_categories', // Replace with your actual taxonomy name
                                'field'    => 'slug', // Change to 'term_id', 'name', or 'slug' as needed
                                'terms'    => 'vested-shorts', // Replace with the term you want to display
                            ),
                        ),
                    );

                    $custom_query = new WP_Query($args);
                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                            <li>
                                <a href="<?php echo get_permalink(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                    <h4><?php the_title(); ?></h4>
                                </a>
                            </li>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </ul>
            </div>
            <div class="post-listing">
                <div class="head">
                    <div class="left-part">
                        <h3>Blogs</h3>
                        <a href="<?php echo home_url() ?>/blog/">View All</a>

                    </div>
                    <div class="short-content">
                        <p>Learn more with regular insights that dive into the US Stock Markets.</p>
                    </div>
                </div>
                <ul>
                    <?php
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'master_categories',
                                'field'    => 'slug',
                                'terms'    => array('under-the-spotlight', 'vested-shorts'),
                                'operator' => 'NOT IN',
                            ),
                        ),
                    );

                    $custom_query = new WP_Query($args);
                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                            <li>
                                <a href="<?php echo get_permalink() ?>">
                                    <?php the_post_thumbnail(); ?>
                                    <h4><?php the_title(); ?></h4>
                                </a>
                            </li>
                    <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </ul>
            </div>
        </div>
    </section>
    <?php if (have_rows('faq_list_global')) : ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('faqs_heading_global'); ?></span></h2>

                <div class="home_page_faq_wrap">
                    <?php while (have_rows('faq_list_global')) : the_row(); ?>
                        <div class="single_faq">
                            <div class="faq_que">
                                <h4>
                                    <?php the_sub_field('faq_question_global') ?>
                                </h4>
                            </div>
                            <div class="faq_content">
                                <?php the_sub_field('faq_answer_global') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php if (have_rows('faq_list_global')) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $rowCount = 0; ?>
        <?php while (have_rows('faq_list_global')) : the_row(); ?>
            {
                "@type": "Question",
                "name": "<?php the_sub_field('faq_question_global') ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "
                        <?php the_sub_field('faq_answer_global') ?>
                    "
                }
            }<?php echo (++$rowCount === count(get_field('faq_list_global'))) ? '' : ','; ?>
        <?php endwhile; ?>
    ]
}
</script>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getUserLocationByIP();
    });

    function getUserLocationByIP() {
        // Make a request to the ipinfo.io API to get user location based on IP
        fetch('https://get.geojs.io/v1/ip/country.json')
            .then(response => response.json())
            .then(data => {
            var globalBanner = document.querySelector(".geolocation_banner");
            if (globalBanner) {
                globalBanner.style.display = "flex"; 
                if (data.country === "IN") {
                    if (document.body.classList.contains('page-template-page-us-stock-global')) {
                        globalBanner.innerHTML = "<div class='content'><p>You're on our Global website. Visit the India website to explore our India-specific products.</p></div><a href='<?php home_url() ?>/in'><img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/india.png'>India</a>";
                    }
                } else {
                    if (document.body.classList.contains('page-template-page-us-stock-global')) {
                        globalBanner.innerHTML = "<div class='content'><p>Bitcoin ETFs available on Vested: Experience seamless, tax-efficient, and hassle-free Bitcoin investing!</p></div><a href='<?php home_url(); ?>/blog/us-stocks/investing-in-spot-bitcoin-etfs-from-india-everything-you-need-to-know/' target='_blank' class='learn_more_btn'>Learn more</a>";
                    }
                }
            }
            })
            .catch(error => {
                console.error('Error getting user location based on IP:', error);
            });
    }
</script>
<?php get_footer(); ?>