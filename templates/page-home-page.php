<?php
/*
    Template name: Home Page Template
*/
get_header(); ?>
<div id="content" role="main" class="home-page">

    <section class="home_banner">
        <div class="container">
            <div class="banner_content">
                <h1><?php the_field('banner_heading'); ?></h1>
                <p><?php the_field('banner_sub_heading'); ?></p>
                <div class="banner_buttons">
                    <div class="btn">
                        <a href="<?php the_field('banner_button_1_url'); ?>" class="btn_dark"><?php the_field('banner_button_1_text'); ?></a>
                    </div>
                    <?php $button_text = get_field('banner_video_button_text'); ?>
                    <?php
                    if (!empty($button_text)) {

                    ?>
                        <div class="btn">
                            <a href="<?php the_field('banner_video_button_url'); ?>" class="btn_light"><i class="fa fa-play" aria-hidden="true"></i> <?php echo $button_text; ?></a>
                            <span class="watch_time"><?php the_field('banner_video_watch_time'); ?> seconds watch</span>
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </div>
        </div>
    </section>
    <?php if (have_rows('counter_list')) : ?>
        <section class="counter_section">
            <div class="container">

                <div class="counters_wrap">
                    <?php while (have_rows('counter_list')) : the_row(); ?>
                        <div class="single_counter">

                            <div class="counter_amt">
                                <h3><?php the_sub_field('counter_prefix') ?><span class="counter_digit" data-count="<?php the_sub_field('counter_amount') ?>"><?php the_sub_field('counter_amount') ?></span><?php the_sub_field('counter_postfix') ?></h3>
                            </div>
                            <div class="counter_title">
                                <?php the_sub_field('counter_title') ?>
                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            </div>
        </section>
    <?php endif; ?>
    <section class="multi_assets">
        <div class="container">
            <h2 class="section_title">
                <?php the_field('multi_asset_heading'); ?>
            </h2>
            <div class="multi_asset_img">
                <?php
                $image = get_field('multi_asset_image');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_hide" />
                <?php endif; ?>
                <?php
                $image = get_field('multi_asset_image_mobile');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if (have_rows('easy_access_list')) : ?>
        <section class="easy_access">
            <div class="container">
                <div class="easy_access_wrap">

                    <div class="easy_access_content">
                        <h2 class="section_title align_left"><?php the_field('easy_access_heading'); ?></h2>

                        <?php
                        $image = get_field('easy_access_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" class="desktop_hide" />
                        <?php endif; ?>

                        <div class="easy_access_list">
                            <?php while (have_rows('easy_access_list')) : the_row(); ?>
                                <div class="single_easy-access">
                                    <div class="easy_access_icon">

                                        <?php
                                        $image = get_sub_field('easy_access_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <h4><?php the_sub_field('easy_access_title') ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="easy_access_btns">
                            <a href="<?php the_field('easy_access_button_one_url'); ?>" class="btn_dark"><?php the_field('easy_access_button_one_text'); ?></a>
                            <a href="<?php the_field('easy_access_button_two_url'); ?>" class="link_light"><?php the_field('easy_access_button_two_text'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="easy_access_img mobile_hide">

                        <?php
                        $image = get_field('easy_access_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="disclosure">
                    <p>
                        <?php echo esc_html(get_field('easy_disclosure')); ?>
                    </p>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!--  -->
    <?php if (have_rows('inr_bond_list')) : ?>
        <section class="inr_bond easy_access">
            <div class="container">
                <div class="easy_access_wrap">

                    <div class="easy_access_content">
                        <h2 class="section_title align_left"><?php the_field('inr_bond_heading'); ?></h2>
                        <?php
                        $image = get_field('inr_bond_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_easy_access_img desktop_hide" />
                        <?php endif; ?>

                        <div class="easy_access_list">
                            <?php while (have_rows('inr_bond_list')) : the_row(); ?>
                                <div class="single_easy-access">
                                    <div class="easy_access_icon">

                                        <?php
                                        $image = get_sub_field('inr_bond_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <h4><?php the_sub_field('inr_bond_title') ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="easy_access_btns">
                            <a href="<?php the_field('inr_bond_button_one_url'); ?>" class="btn_dark" target="_blank"><?php the_field('inr_bond_button_text'); ?></a>
                            <a href="<?php the_field('inr_bond_button_two_url'); ?>" class="link_light"><?php the_field('inr_bond_button_two_text'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="easy_access_img mobile_hide">
                        <?php
                        $image = get_field('inr_bond_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" />
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>
    <!--  -->
    <?php if (have_rows('solar_bond_list')) : ?>
        <section class="solar inr_bond easy_access">
            <div class="container">
                <div class="easy_access_wrap">
                    <div class="easy_access_content">
                        <h2 class="section_title align_left"><?php the_field('solar_bond_heading'); ?></h2>

                        <?php
                        $image = get_field('solar_bond_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" class="mobile_easy_access_img desktop_hide" />
                        <?php endif; ?>
                        <div class="easy_access_list">
                            <?php while (have_rows('solar_bond_list')) : the_row(); ?>
                                <div class="single_easy-access">
                                    <div class="easy_access_icon">

                                        <?php
                                        $image = get_sub_field('solar_bond_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <h4><?php the_sub_field('solar_bond_title') ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="easy_access_btns">
                            <a href="<?php the_field('solar_bond_button_one_url'); ?>" class="btn_dark" target="_blank"><?php the_field('solar_bond_button_text'); ?></a>
                            <a href="<?php the_field('solar_bond_button_two_url'); ?>" class="link_light"><?php the_field('solar_bond_button_two_text'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="easy_access_img mobile_hide">
                        <?php
                        $image = get_field('solar_bond_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" />
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>
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

    <?php if (have_rows('learning_list')) : ?>
        <section class="invest_wisely_sec">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('invest_wisely_heading'); ?></span></h2>
                <div class="invest_wisely_wrap">
                    <?php while (have_rows('learning_list')) : the_row(); ?>
                        <div class="single_wisely_list">
                            <div class="single_wisely_img">
                                <?php
                                $image = get_sub_field('learning_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                            </div>
                            <div class="single_wisely_content">
                                <h3><?php the_sub_field('learning_title') ?></h3>
                                <p><?php the_sub_field('learning_description') ?></p>
                                <a href="<?php the_sub_field('learning_cta_url') ?>" class="btn_dark"><?php the_sub_field('learning_cta_text') ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (have_rows('faq_list')) : ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('faqs_heading'); ?></span></h2>

                <div class="home_page_faq_wrap">
                    <?php while (have_rows('faq_list')) : the_row(); ?>
                        <div class="single_faq">
                            <div class="faq_que">
                                <h3>
                                    <?php the_sub_field('faq_question') ?>
                                </h3>
                            </div>
                            <div class="faq_content">
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
                        globalBanner.innerHTML = "<div class='content'><p>Looking to invest Globally via Mutual Funds? Sign up for early access. <a href='<?php echo site_url() ?>/in/global-mutual-funds/' rel='nofollow' target='_blank' class='learn_more_btn tmp'>Know More</a></p></div>";
                        // globalBanner.innerHTML = "<div class='content'><p>Announcing our latest partnership with HDFC Securities powering their Global Investing 2.0 offering. <a href='https://bfsi.economictimes.indiatimes.com/news/financial-services/hdfc-securities-partners-with-vested-finance-to-offer-access-to-global-investing-for-indians-and-nris/112221333' rel='nofollow' target='_blank' class='learn_more_btn tmp'>Read Press Release</a></p></div>";
                        // globalBanner.classList.add('warning_banner');
                        // globalBanner.style.display = "none";
                        console.log('show geolocation_banner');
                    } else if (data.country === "US") {
                        globalBanner.innerHTML = "<div class='content'><p>You're on our India website. Visit the USA website. <a href='<?php echo site_url('/us/') ?>' class='learn_more_btn tmp'>Visit USA Website</a></p></div>";
                    } else {
                        globalBanner.innerHTML = "<div class='content'><p>You're on our India website. Visit the Global website to explore our Global products.</p></div><a href='<?php echo site_url() ?>'><img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/global.png'>Global</a>";
                    }
                }
            })
            .catch(error => {
                console.error('Error getting user location based on IP:', error);
            });
    }
</script>
<?php get_footer(); ?>