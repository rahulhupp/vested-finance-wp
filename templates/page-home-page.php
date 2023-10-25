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
                    <div class="btn">
                        <a href="<?php the_field('banner_video_button_url'); ?>" class="btn_light"><i class="fa fa-play" aria-hidden="true"></i> <?php the_field('banner_video_button_text'); ?></a>
                        <span class="watch_time"><?php the_field('banner_video_watch_time'); ?> seconds watch</span>
                    </div>

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
                <img src="<?php the_field('multi_asset_image'); ?>" alt="Multi Asset" class="mobile_hide">
                <img src="<?php the_field('multi_asset_image_mobile'); ?>" alt="Multi Asset" class="desktop_hide">
            </div>
        </div>
    </section>
    <?php if (have_rows('easy_access_list')) : ?>
        <section class="easy_access">
            <div class="container">
                <div class="easy_access_wrap">

                    <div class="easy_access_content">
                        <h2 class="section_title align_left"><?php the_field('easy_access_heading'); ?></h2>
                        <img src="<?php the_field('easy_access_image'); ?>" alt="Easy Access" class="desktop_hide">
                        <div class="easy_access_list">
                            <?php while (have_rows('easy_access_list')) : the_row(); ?>
                                <div class="single_easy-access">
                                    <div class="easy_access_icon">
                                        <img src="<?php the_sub_field('easy_access_icon') ?>" alt="<?php the_sub_field('easy_access_title') ?>">
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
                        <img src="<?php the_field('easy_access_image'); ?>" alt="Easy Access">
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (have_rows('edge_list')) : ?>
        <section class="edge_section">
            <div class="container">
                <div class="edge_wrapper">
                    <div class="edge_content">
                        <h2 class="section_title align_left"><?php the_field('edge_heading'); ?></h2>
                        <img src="<?php the_field('edge_image'); ?>" alt="Vested Edge" class="desktop_hide">
                        <div class="edge_list">
                            <?php while (have_rows('edge_list')) : the_row(); ?>
                                <div class="single_edge">
                                    <div class="edge_icon">
                                        <img src="<?php the_sub_field('edge_icon') ?>" alt="<?php the_sub_field('edge_title') ?>">
                                    </div>
                                    <h4><?php the_sub_field('edge_title') ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="edge_btns">
                            <a href="<?php the_field('edge_button_one_url'); ?>" class="btn_light"><?php the_field('edge_button_text'); ?></a>
                            <a href="<?php the_field('edge_button_two_url'); ?>" class="link_dark"><?php the_field('edge_button_two_text'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="edge_img mobile_hide">
                        <img src="<?php the_field('edge_image'); ?>" alt="Vested Edge">
                    </div>
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
                        <img src="<?php the_field('inr_bond_image'); ?>" alt="Easy Access" class="desktop_hide">
                        <div class="easy_access_list">
                            <?php while (have_rows('inr_bond_list')) : the_row(); ?>
                                <div class="single_easy-access">
                                    <div class="easy_access_icon">
                                        <img src="<?php the_sub_field('inr_bond_icon') ?>" alt="<?php the_sub_field('inr_bond_title') ?>">
                                    </div>
                                    <h4><?php the_sub_field('inr_bond_title') ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="easy_access_btns">
                            <a href="<?php the_field('inr_bond_button_one_url'); ?>" class="btn_dark"><?php the_field('easy_access_button_one_text'); ?></a>
                            <a href="<?php the_field('inr_bond_button_two_url'); ?>" class="link_light"><?php the_field('inr_bond_button_two_text'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="easy_access_img mobile_hide">
                        <img src="<?php the_field('inr_bond_image'); ?>" alt="Easy Access">
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>
    <!--  -->
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
                                <img src="<?php the_sub_field('slider_image') ?>" alt="Portfolio" />
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
    <?php if (have_rows('investors_reviews')) : ?>
        <section class="investors_sec">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('investors_heading'); ?></span></h2>
                <p class="investor_subtitle"><?php the_field('investors_sub_heading'); ?></p>
                <div class="investors_slider_wrap">
                    <div class="investors_slider">
                        <?php while (have_rows('investors_reviews')) : the_row(); ?>
                            <div class="single_investor_slide">
                                <div class="investor_slide_inner">
                                    <div class="investor_details">
                                        <div class="investor_info">
                                            <div class="investor_img">
                                                <img src="<?php the_sub_field('investor_image') ?>" alt="<?php the_sub_field('investor_name') ?>">
                                            </div>
                                            <div class="investor_detail">
                                                <h4 class="invesetor_name">
                                                    <a href="<?php the_sub_field('review_platform_link') ?>" target="_blank">
                                                        <?php the_sub_field('investor_name') ?>
                                                    </a>
                                                </h4>
                                                <p class="investor_designation">
                                                    <?php the_sub_field('investor_designation') ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="platform_icon">
                                            <a href="<?php the_sub_field('review_platform_link') ?>" target="_blank">
                                                <img src="<?php the_sub_field('review_platform_icon') ?>" alt="Review Platform">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="investor_review">
                                        <?php the_sub_field('investor_review') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="investor_slider_nav">
                        <div class="investor_prev">
                            <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.1035 10.0566H1.74131M1.74131 10.0566L10.9639 0.833984M1.74131 10.0566L10.9639 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                        <div class="investor_next">
                            <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.283203 10.0566H25.6454M25.6454 10.0566L16.4228 0.833984M25.6454 10.0566L16.4228 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="investor_desclaimer">
                    <?php the_field('investors_disclaimer'); ?>
                </div>
            </div>

        </section>
    <?php endif; ?>
    <?php if (have_rows('learning_list')) : ?>
        <section class="invest_wisely_sec">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('invest_wisely_heading'); ?></span></h2>
                <div class="invest_wisely_wrap">
                    <?php while (have_rows('learning_list')) : the_row(); ?>
                        <div class="single_wisely_list">
                            <div class="single_wisely_img">
                                <img src="<?php the_sub_field('learning_image') ?>" alt="<?php the_sub_field('learning_title') ?>">
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
            </div>
        </section>
    <?php endif; ?>
</div>
<?php get_footer(); ?>