<?php
/*
Template name: Page - US Stock India
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
                        <div class="buttons">
                            <a class="btn_dark" href="<?php the_field('start_investing_link'); ?>"><?php the_field('start_investing_label'); ?></a>
                            <a class="btn_light" href="#"><i class="fa fa-play" aria-hidden="true"></i><?php the_field('watch_video_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="stock-image">
                    <img src="<?php the_field('stock_image'); ?>" />
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
                                        <img src="<?php the_sub_field('image'); ?>" class="<?php if ($index == 2) : ?>mobile_hide <?php endif; ?>" />
                                        <?php if ($index == 1) : ?><p class="img_source">Source: Bloomberg and CNBC<?php endif; ?></p>
                                            <img src="<?php the_sub_field('mobile_image'); ?>" class="<?php if ($index == 2) : ?>desktop_hide <?php endif; ?>" />
                                    </div>
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

    <?php get_template_part('template-parts/us-stock-search'); ?>

    <?php get_template_part('template-parts/us-stock-vests'); ?>

    
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

                            <?php $currentIndexNo = 0; while (have_rows('stocks_slider')) : the_row();
                            
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
                            <?php $currentIndexNo++; endwhile; ?>
                        </div>
                    </div>
                    <div class="us_stocks_slider stock-single-item">
                        <?php while (have_rows('stocks_slider')) : the_row(); ?>
                            <div class="single_portfolio_slider">
                                <img src="<?php the_sub_field('stocks_slider_image') ?>" alt="Portfolio" />
                            </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <?php the_field('slider_disclaimer'); ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="calculator">
        <div class="container">
            <h2 class="section_title align_left"><?php the_field('main_heading'); ?></h1>
                <p class="sub_heading"><?php the_field('main_sub_heading'); ?></p>


                <div class="main_calc_wrap">
                    <div class="calc_col">

                        <div class="calc_form_wrap">
                            <form action="" class="calc_form">

                                <div class="field_group">
                                    <label for="stockSelector">Select Stock</label>
                                    <select name="stockSelector" id="">
                                        <option value="">Appl, Inc - AAPL </option>
                                        <option value="">Alphabet </option>
                                        <option value="">Meta </option>
                                        <option value="">Amazon </option>
                                        <option value="">Netflix </option>
                                        <option value="">Google </option>
                                    </select>
                                </div>

                                <div class="field_group">
                                    <label for="invest_val">Enter Investment Amount</label>

                                    <div class="inner_field">
                                        <span class="currency">&#x20B9;</span>
                                        <input type="text" id="invest_val" value="1,000">

                                        <div class="currency_select">
                                            <div>
                                                <input type="radio" name="currency" id="inr_currency" checked>
                                                <label for="inr_currency">INR</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="currency" id="usd_currency">
                                                <label for="usd_currency">USD</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_note">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                <path d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18Z" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.5 13.5V10.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.5 7.5H10.5075" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg> Choosing INR will incorporate the FX rate changes as well</span>
                                    </div>
                                </div>


                                <div class="field_group">
                                    <div class="field_row">
                                        <div class="field_col">
                                            <label for="startMonth">Select Stock</label>
                                            <select name="startMonth" id="">
                                                <option value="">Jan, 2021</option>
                                                <option value="">Fab, 2021</option>
                                                <option value="">Mar, 2021</option>
                                            </select>
                                        </div>
                                        <div class="field_col">
                                            <label for="startMonth">Select Stock</label>
                                            <select name="startMonth" id="">
                                                <option value="">Aug, 2023</option>
                                                <option value="">Jul, 2023</option>
                                                <option value="">Jun, 2023</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit_btn">
                                    <input type="submit" value="calculate">
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="calc_result_col">
                        <div class="result_inner_col">
                            <h3>Return Breakdown</h3>
                            <div class="result_breakdown_wrap">
                                <div class="result_graph_col">
                                    <!-- <div class="result_circle_wrap">
                                        <div class="investment_amount_data"></div>
                                        <div class="returns_data"></div>
                                    </div> -->
                                    <div class="fd_result" id="fd_results">
                                    <div class="total_value">
                                        <p>Total Value</p>
                                        <h4>$<span id="total_calc_val">5,000</span></h4>
                                    </div>
                                </div>
                                </div>
                                <div class="result_breakdown_info">

                                    <div class="breakdown_list">
                                        <div class="invested_val list">
                                            <p>Invested Amount</p>
                                            <h4>$ 1,000</h4>
                                        </div>
                                        <div class="est_return list">
                                            <p>Est. Returns</p>
                                            <h4>$ 4,000</h4>
                                        </div>
                                        <div class="total_val list">
                                            <p>Total Value</p>
                                            <h4>$5,000</h4>
                                        </div>
                                        <div class="cagr_val list">
                                            <p>CAGR</p>
                                            <h4>37.97%</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="investment_cta">
                            <div class="cta_content_col">
                                <p><?php the_field('cta_text'); ?></p>
                            </div>
                            <div class="cta_btn">
                                <a href="<?php the_field('cta_button_url'); ?>"><?php the_field('cta_button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <p class="calc_desc">
                    <?php the_field('calc_disclaimer'); ?>
                </p>
        </div>
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
                                                    <?php the_sub_field('investor_name') ?>
                                                </h4>
                                                <p class="investor_designation">
                                                    <?php the_sub_field('investor_designation') ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="platform_icon">
                                            <img src="<?php the_sub_field('review_platform_icon') ?>" alt="Review Platform">
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

    <section class="post-type-list">
        <div class="container">
            <h2>Invest wisely with <br class="desktop_hide"> clarity and conviction</h2>
            <div class="post-listing">
                <div class="head">
                    <div class="left-part">
                        <h3>Under the Spotlight</h3>
                        <a href="#">View All</a>

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
                        <a href="#">View All</a>

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
                        <h3>Blogs</h3>
                        <a href="#">View All</a>

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

    <section class="partners">
        <div class="container">
            <h2 class="section_title"><?php the_field('partners_heading'); ?></h2>
            <p class="sub_heading"><?php the_field('partners_sub_heading'); ?></p>
            <?php if (have_rows('partners_list')) : ?>
                <div class="partners_wrap">
                    <?php while (have_rows('partners_list')) : the_row(); ?>
                        <div class="single_partner_block">
                            <img src="<?php the_sub_field('partner_logo') ?>" alt="<?php the_sub_field('partner_name') ?>">
                        </div>
                    <?php endwhile; ?>
                </div>
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
            </div>
        </section>
    <?php endif; ?>
</div>
<?php get_footer(); ?>