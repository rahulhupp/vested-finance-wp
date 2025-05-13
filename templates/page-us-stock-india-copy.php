<?php
/*
Template name: Page - US Stock India Copy
*/
get_header(); ?>
<div id="content" role="main" class="calc-page">
    <section class="stock-info">
        <div class="container">
            <div class="stock-row">
                <div class="stock-content">
                    <?php the_field('stock_content'); ?>
                    <div class="bottom">
                        <b><?php the_field('nri_text'); ?></b>
                        <div id="coupon-section" class="coupon">
                            <div class="coupon-header">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ticket.svg" alt="ticket-icon" />
                                <h3><?php the_field('coupon_title'); ?></h3>
                            </div>
                            <input type="text" id="coupon-code" placeholder="Enter code">
                            <p id="coupon-message"></p>
                        </div>
                        <div class="buttons">
                            <a class="btn_dark" id="applyCoupon"><?php the_field('start_investing_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="stock-image">
                    <?php
                    $image = get_field('stock_image');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt']); ?>" />
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

    <section class="explore-stock">
        <div class="container">
            <div class="head">
                <h2>Explore US Stocks</h2>
                <p>Discover the world of 10,000+ US Stocks and ETFs</p>
                <!-- <p class="desktop_hide">Issued by top rated companies with high <br>CRISIL ratings</p> -->
            </div>
            <div class="explore-image">
                <ul>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/apple.webp"
                                        alt="Apple" width="47" height="57">
                                </div>
                                <span>Apple</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/google.webp"
                                        alt="Google" width="58" height="71">
                                </div>
                                <span>Google</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/invesco.webp"
                                        alt="Invesco" width="54" height="44">
                                </div>
                                <span>Invesco</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/microsoft.webp"
                                        alt="Microsoft" width="58" height="57">
                                </div>
                                <span>Microsoft</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/tesla.webp"
                                        alt="Tesla" width="58" height="57">
                                </div>
                                <span>Tesla</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/meta.webp"
                                        alt="Meta" width="57" height="33">
                                </div>
                                <span>Meta</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/netflix.webp"
                                        alt="Netflix" width="71" height="47">
                                </div>
                                <span>Netflix</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/spdr.webp"
                                        alt="Spdr" width="78" height="44">
                                </div>
                                <span>SPDR</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/amazon.webp"
                                        alt="Amazon" width="58" height="57">
                                </div>
                                <span>Amazon</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="box">
                                <div class="explore-icon">
                                    <img src="http://wordpress-testing.vestedfinance.com/wp-content/themes/vested-finance-wp/assets/images/spotify.webp"
                                        alt="Spotify" width="46" height="47">
                                </div>
                                <span>Spotify</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content text-center">
                <p>Disclosure: This list is representative of stocks available but is not intended to recommend any
                    investment.</p>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/us-stock-vests-india'); ?>

    <section class="tab-section">
        <div class="container">
            <div class="tabs">
                <div class="head">
                    <h2><?php the_field('tab_heading'); ?></h2>
                    <?php if (have_rows('tab_item')) : $index = 1; ?>
                        <div class="nav_tabs_container">
                            <ul id="tabs-nav">
                                <?php while (have_rows('tab_item')) : the_row();
                                ?>
                                    <li>
                                        <a href="#tab<?php echo $index; ?>"><?php the_sub_field('title'); ?></a>
                                    </li>
                                    <?php $index++; ?>
                                <?php endwhile; ?>
                            </ul>

                            <ul id="mob-tabs">
                                <?php $mobIndex = 1;
                                while (have_rows('tab_item')) : the_row();
                                ?>
                                    <li><a href="#tab<?php echo $mobIndex; ?>"></a></li>
                                    <?php $mobIndex++; ?>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
                <div id="tabs-content" class="main-tabs">
                    <?php if (have_rows('tab_item')) : $index = 1; ?>
                        <?php while (have_rows('tab_item')) : the_row();
                        ?>
                            <div id="tab<?php echo $index; ?>" class="tab-content">
                                <div class="inner">
                                    <div class="content">
                                        <?php the_sub_field('content'); ?>
                                    </div>
                                    <div class="image">
                                        <?php if (get_sub_field('mobile_image')) { ?>
                                            <?php
                                            $image = get_sub_field('image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_hide" />
                                            <?php endif; ?>

                                            <?php
                                            $image = get_sub_field('mobile_image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                                            <?php endif; ?>
                                        <?php } else { ?>
                                            <?php
                                            $image = get_sub_field('image');
                                            if (!empty($image)): ?>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <?php endif; ?>
                                        <?php } ?>
                                        <?php if ($index === 3) : ?><p class="img_source">Source: Bloomberg and CNBC<?php endif; ?></p>
                                    </div>
                                    <?php if ($index === 1) : ?><p class="img_source mt-0">Source: Bloomberg and CNBC<?php endif; ?></p>
                                </div>
                            </div>
                            <?php $index++; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <p class="desc">Disclosure: Returns shown are based on historical performance. Past Performance does not guarantee future results.</p>
        </div>
    </section>

    <?php if (have_rows('stocks_slider')) : ?>
        <section class="stocks_slider_sec">
            <div class="container">
                <h2 class="section_title desktop_hide">
                    <span><?php the_field('stocks_slider_heading'); ?></span>
                </h2>
                <div class="stocks_slider_wrap">

                    <div class="stocks_slider_inner">
                        <h2 class="section_title align_left mobile_hide">
                            <span><?php the_field('stocks_slider_heading'); ?></span>
                        </h2>
                        <div class="stocks_slider_content">

                            <?php $currentIndexNo = 0;
                            while (have_rows('stocks_slider')) : the_row();

                            ?>
                                <div class="single_portfolio_slider_content" data-curent-slide="<?php echo $currentIndexNo; ?>">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('stocks_slider_slider_title') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('stocks_slider_slider_description') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php $currentIndexNo++;
                            endwhile; ?>
                        </div>
                    </div>
                    <div class="us_stocks_slider stock-single-item">
                        <?php while (have_rows('stocks_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                <?php
                                $image = get_sub_field('stocks_slider_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <?php the_field('slider_disclaimer'); ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="stock_chart_sec">
        <?php
        $chart = 'true';
        ?>
        <?php get_template_part('template-parts/stocks-calculator-india'); ?>
    </section>
    <?php if (have_rows('portfolio_slider')) : ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title">
                    <span><?php the_field('portfolio_heading'); ?></span>
                </h2>
                <div class="portfolio_slider_wrap">
                    <div class="portfolio_slider slider single-item">
                        <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">

                                <?php
                                $image = get_sub_field('slider_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (have_rows('portfolio_slider')) : ?>
                        <div class="portfolio_slider_content">
                            <?php while (have_rows('portfolio_slider')) : the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('slider_title') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('slider_description') ?>
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
            <h2>Invest with Confidence: Read our Blogs</h2>
            <div class="post-listing">
                <ul>
                    <?php
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'master_categories',
                                'field'    => 'slug',
                                'terms'    => array('us-stocks'),
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
            <div class="btn text-center">
                <a href="<?php echo home_url(); ?>/blog/us-stocks/" class="btn_dark" target="_blank">Read All Blogs</a>
            </div>
        </div>
    </section>

    <section class="partners">
        <div class="container">
            <h2 class="section_title"><?php the_field('partners_heading'); ?></h2>
            <p class="sub_heading"><?php the_field('partners_sub_heading'); ?></p>
            <?php if (have_rows('partners_list')) : ?>
                <div class="partners_wrap">
                    <?php while (have_rows('partners_list')) : the_row(); ?>
                        <div class="single_partner_block">
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
            <div class="btn text-center">
                <a href="https://vestedfinance.typeform.com/to/ZdG011Tv" class="btn_dark" target="_blank">Become A Partner</a>
            </div>
        </div>
    </section>
    <section class="eft_stock_info">
        <div class="container">
            <h2 class="section_title"><?php the_field('stock_eft_section_title'); ?></h2>
            <?php $eftContent = get_field('stock_eft_description');
            if ($eftContent) :
            ?>
                <?php echo $eftContent; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php if (have_rows('faq_list')) : ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('faqs_heading'); ?></span></h2>

                <div class="home_page_faq_wrap">
                    <?php while (have_rows('faq_list')) : the_row(); ?>
                        <div class="single_faq">
                            <div class="faq_que">
                                <h4>
                                    <?php the_sub_field('faq_question') ?>
                                </h4>
                            </div>
                            <div class="faq_content">
                                <?php the_sub_field('faq_answer') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="btn text-center">
                    <a href="https://support.vestedfinance.com/portal/en/kb/vested-us-stocks" class="btn_dark" target="_blank">Explore All FAQs</a>
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
                <?php while (have_rows('faq_list')) : the_row(); ?> {
                        "@type": "Question",
                        "name": "<?php the_sub_field('faq_question') ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "
                            <?php the_sub_field('faq_answer') ?> "
                        }
                    }
                    <?php echo (++$rowCount === count(get_field('faq_list'))) ? '' : ','; ?>
                <?php endwhile; ?>
            ]
        }
    </script>
<?php endif; ?>

<?php get_footer(); ?>