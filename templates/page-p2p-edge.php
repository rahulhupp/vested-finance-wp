<?php
/*
    Template name: pl Edge Page Template
*/

get_header(); ?>
<div class="pzp-new">
<div class="header_section" id="main-header">
    <div class="container">
        <div class="p2p_new_header">

            <div class="left-side">
                <a href="#home" class="scroll-link"><?php the_field('header_text'); ?></a>
            </div>

            <div class="burger-menu" onclick="toggleMenu()">
                <div class="bar"></div>
            </div>

            <div class="overlay" id="overlay" onclick="closeMenu()"></div>

            <div class="right_side_menu" id="menu">
                <?php if (have_rows('header_menu_links')): ?>
                    <ul class="header_list">
                        <?php $counter = 1; ?>
                        <?php while (have_rows('header_menu_links')):
                            the_row(); ?>
                            <?php
                            $edgeMenuItem = get_sub_field('header');
                            $edgeMenuItem = str_replace('?', '₹', $edgeMenuItem);
                            $liId = 'menu-item-' . $counter;
                            ?>
                            <li id="<?php echo esc_attr($liId); ?>">
                                <a href="#section-<?php echo esc_attr($counter); ?>" class="scroll-link">
                                    <?php echo $edgeMenuItem; ?>
                                </a>
                            </li>
                            <?php $counter++; ?>
                        <?php endwhile; ?>
                    </ul>
                    <div class="button_header">
                        <a href="<?php the_field('header_button_url'); ?>" class="btn_green_header">
                            <?php the_field('header_button_text'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>


<div id="content" role="main" class="edge-page">
    <div class="p2p_new_section">
        <section class="edge_banner" id="home">
            <div class="container">
                <div class="banner_wrapper">
                    <div class="banner_content">
                        <div class="sub_heading_new">
                            <h4>
                                <?php the_field('banner_sub_heading'); ?>
                            </h4>
                        </div>
                        <h1>
                            <?php the_field('banner_heading'); ?>
                        </h1>
                        <?php if (have_rows('banner_edge_list')): ?>
                            <ul class="banner_list">
                                <?php while (have_rows('banner_edge_list')):
                                    the_row(); ?>
                                    <?php
                                    $edgeSingleItem = get_sub_field('edge_single_item');
                                    $edgeSingleItem = str_replace('?', '₹', $edgeSingleItem);
                                    ?>
                                    <li>
                                        <?php echo $edgeSingleItem; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="banner_buttons green">
                            <div class="btn">
                                <a href="<?php the_field('banner_button_one_url'); ?>" class="btn_dark">
                                    <?php the_field('banner_button_one_text'); ?>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="banner_img">
                        <?php
                        $image = get_field('banner_image');
                        if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="banner-description">
                        <p class="description">
                            <?php the_field('banner_description'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="smart_diversification" id="section-1">
        <div class="container">
            <div class="smart_diversification_content">
                <h2 class="section_title align_left"><span>
                        <?php the_field('smart_heading'); ?>
                    </span></h2>
                <p class="smart_desc">
                    <?php the_field('description'); ?>
                </p>
            </div>
            <div class="smart_diversification_img">
                <?php
                $image = get_field('smart_image');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                        class="mobile_hide" />
                <?php endif; ?>

                <?php
                $image = get_field('smart_image_mob');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                        class="desktop_hide" />
                <?php endif; ?>
            </div>


        </div>
    </section>
    <section class="interest_rates_sec">
        <div class="container">
            <div class="interest_block">
                <?php
                $image = get_field('return_image');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                        class="mobile_hide" />
                <?php endif; ?>

                <?php
                $image = get_field('return_image_mob');
                if (!empty($image)): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                        class="desktop_hide" />
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if (have_rows('investment_plans')): ?>
        <section class="money_plans" id="section-2">
            <div class="container">
                <div class="money_plans_content">
                    <h2 class="section_title"><span>
                            <?php the_field('investment_heading'); ?>
                        </span></h2>
                    <p class="smart_desc align_center">
                        <?php the_field('investment_sub_heading'); ?>
                    </p>

                    <div class="plans_wrap">
                        <?php while (have_rows('investment_plans')):
                            the_row(); ?>
                            <div class="single_plan">
                                <div class="plan_head">
                                    <div class="plan_icon">
                                        <?php
                                        $image = get_sub_field('plan_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>

                                    </div>
                                    <div class="return_rates">
                                        <div>
                                            <h5>
                                                <?php the_sub_field('returns_pa') ?>%
                                            </h5>
                                            <p>
                                                <?php the_sub_field('returns_duration') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan_detail">
                                    <h3 class="plan_title">
                                        <?php the_sub_field('investment_plan_title') ?>
                                    </h3>
                                    <?php if (!empty(get_sub_field('offer_label'))) {
                                        ?>
                                        <div class="offer_label">
                                            <div class="image_label">
                                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/balance.png" />
                                                <span>
                                                    <?php the_sub_field('offer_label') ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php
                                    } ?>
                                    <?php if (have_rows('plan_detail_list')): ?>
                                        <ul class="plans_list">
                                            <?php while (have_rows('plan_detail_list')):
                                                the_row(); ?>
                                                <li>
                                                    <?php the_sub_field('plan_single_list') ?>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="investment_value_row">
                                        <h4 class="investment_val_name">Min investment</h4>
                                        <h5 class="investment_val"> &#8377;
                                            <?php the_sub_field('min_investment_value') ?>
                                        </h5>
                                    </div>
                                    <div class="investment_value_row">
                                        <h4 class="investment_val_name">Lock-in</h4>
                                        <h5 class="investment_val">
                                            <?php the_sub_field('lock-in_period') ?>
                                        </h5>
                                    </div>
                                    <div class="add_invest_btn">
                                        <a href="<?php the_sub_field('investment_button_url') ?>">
                                            <?php the_sub_field('investment_button_text') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="fd_calc_sec" id="section-3">
        <div class="container">
            <div class="fd_calc_content">
                <h2 class="section_title align_left"><span>
                        <?php the_field('interest_calc_heading'); ?>
                    </span></h2>
                <div class="fd_calc_wrap">
                    <div class="fd_calc_col">
                        <div class="fd_calc">
                            <h4 class="calc_heading">Investment amount</h4>
                            <form class="fd_calc_form" onsubmit="return false;">
                                <div class="fd_calc_slide">
                                    <input type="text" id="investment_amt" value="50000">
                                    <input type="range" id="investment_range" value="50000" min="20000" max="5000000"
                                        oninput="investment_amt.value = '₹' + investment_range.value">
                                </div>
                                <div class="fd_plan_select">
                                    <h4>Select Plan</h4>
                                    <div class="plan_selection">
                                        <div class="single_plan_button">
                                            <input type="radio" name="plan-selection" id="liquid-plan" value="9">
                                            <label for="liquid-plan">Liquid</label>
                                        </div>
                                        <div class="single_plan_button">
                                            <input type="radio" name="plan-selection" id="fixed-term" value="12"
                                                checked>
                                            <label for="fixed-term">Fixed Term</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="fd_plan_select">
                                    <h4>Select Tenure</h4>
                                    <div class="plan_selection">
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="three-month" value="3">
                                            <label for="three-month">3M</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="six-month" value="6">
                                            <label for="six-month">6M</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="one-year" value="12"
                                                checked>
                                            <label for="one-year">1Y</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="two-year" value="24">
                                            <label for="two-year">2Y</label>
                                        </div>
                                        <div class="single_tenure_button">
                                            <input type="radio" name="tenure-selection" id="three-year" value="36">
                                            <label for="three-year">3Y</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="fd_result_col">
                        <div class="fd_result" id="fd_results">
                            <div class="result_row">
                                <div class="result_interest_val">
                                    <h3><span>&#8377;</span> <span class="extra_interest">&nbsp;3,000</span></h3>
                                    <p>Extra Interest</p>
                                </div>
                                <div class="other_result_wrap">
                                    <div class="other_result_val">
                                        <div class="other_result_single">
                                            <h3><span>&#8377;</span> <span
                                                    class="other_interest fd_interest">&nbsp;6,000</span></h3>
                                            <p>Interest on FD <br>@6%</p>
                                        </div>
                                    </div>
                                    <div class="other_result_val">
                                        <div class="other_result_single">
                                            <h3><span>&#8377;</span> <span
                                                    class="other_interest liquid_interest">&nbsp;9,000</span></h3>
                                            <p>Interest from Edge <br>@<span id="plan-selected"></span>%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (have_rows('edge_list')): ?>
        <section class="vested_edge_list">
            <div class="container">
                <div class="edge_list_row">
                    <h2 class="section_title light">
                        <?php the_field('edge_heading'); ?>
                    </h2>
                    <div class="edge_list_content">
                        <div class="edge_list_wrap">
                            <?php while (have_rows('edge_list')):
                                the_row(); ?>
                                <div class="single_edge_list">
                                    <div class="edge_list_icon">
                                        <?php
                                        $image = get_sub_field('edge_list_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <p class="edge_content">
                                        <?php the_sub_field('edge_list_description') ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <?php if (have_rows('portfolio_slider')): ?>
        <section class="portfolio_slider_sec"  id="section-4">
            <div class="container">
                <h2 class="section_title">
                    <span>
                        <?php the_field('portfolio_heading'); ?>
                    </span>
                </h2>
                <div class="portfolio_slider_wrap">
                    <div class="portfolio_slider slider single-item">
                        <?php while (have_rows('portfolio_slider')):
                            the_row(); ?>
                            <div class="single_portfolio_slider">
                                <?php
                                $image = get_sub_field('slider_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (have_rows('portfolio_slider')): ?>
                        <div class="portfolio_slider_content">
                            <?php while (have_rows('portfolio_slider')):
                                the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0
                                                <?php echo get_row_index(); ?>
                                            </span>
                                            <h3>
                                                <?php the_sub_field('slider_title') ?>
                                            </h3>
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
    <?php if (have_rows('faq_list')): ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section_title"><span>
                        <?php the_field('faqs_heading'); ?>
                    </span></h2>

                <div class="home_page_faq_wrap">
                    <?php while (have_rows('faq_list')):
                        the_row(); ?>
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

    <div class="container">


        <section id="section-5">
            <div class="contact-form" id="menu-item-5">

                <div class="contact-headinng">
                    <h2>
                        <?php the_field('form_heading') ?>
                    </h2>
                    <p>
                        <?php the_field('form-sub-heading') ?>
                    </p>
                </div>

                <?php echo do_shortcode('[contact-form-7 id="dc0ce5d" title="p2p-edge-form"]'); ?>

                <div class="social_links">
                    <a href="#"><img src="<?php the_field('facebook'); ?>" alt=""></a>
                    <a href="#"><img src="<?php the_field('insta'); ?>" alt=""></a>
                    <a href="#"><img src="<?php the_field('linkdin'); ?>" alt=""></a>
                </div>

            </div>
        </section>
    </div>
</div>
</div>

<section class="footer_section">
    <div class="container">
        <?php if (have_rows('footer_section')): ?>

            <?php while (have_rows('footer_section')):
                the_row(); ?>
                <?php
                $edgeSingleItem = get_sub_field('first_pera');
                $edgeSingleItem = str_replace('?', '₹', $edgeSingleItem);
                ?>
                <?php echo $edgeSingleItem; ?>
            <?php endwhile; ?>

        <?php endif; ?>

    </div>
</section>

<script>
    jQuery(document).ready(function ($) {
        $(".scroll-link").on("click", function (event) {
            closeMenu();
            event.preventDefault();
            const targetId = $(this).attr("href");
            const targetSection = $(targetId);

            if (targetSection.length) {
                $("html, body").animate({
                    scrollTop: targetSection.offset().top - 100
                }, 1000);
            }
        });
    });

    function toggleMenu() {
        var menu = document.getElementById('menu');
        var overlay = document.getElementById('overlay');
        menu.classList.toggle('show');
        overlay.style.display = (menu.classList.contains('show')) ? 'block' : 'none';
    }

    function closeMenu() {
        var menu = document.getElementById('menu');
        var overlay = document.getElementById('overlay');
        menu.classList.remove('show');
        overlay.style.display = 'none';
    }

    window.addEventListener('scroll', function () {
        var header = document.getElementById('main-header');
        if (window.scrollY > 0) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
</script>

<?php get_footer(); ?>
