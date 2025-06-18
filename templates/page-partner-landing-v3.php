<?php
/*
Template name: Partner Landing Page V3
Template Post Type: post, page, partners
*/
get_header();

while (have_posts()) :
    the_post();
?>
    <?php get_template_part('template-parts/new-partner-header'); ?>
    <div class="partner_landing_page">
        <section class="partner_hero_section">
            <div class="container">
                <div class="partner_hero_wrapper">
                    <div class="partner_hero_content">
                        <h1><?php the_field('banner_title'); ?></h1>
                        <p><?php the_field('banner_description'); ?></p>
                        <?php if (have_rows('banner_button')) : ?>
                            <?php while (have_rows('banner_button')): the_row(); ?>
                                <a href="<?php the_sub_field('banner_button_link'); ?>"><?php the_sub_field('banner_button_text'); ?></a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="partner_hero_image">
                        <img src="<?php the_field('banner_image'); ?>" alt="<?php the_field('banner_title'); ?>" />
                    </div>
                </div>
            </div>
        </section>

        <section class="banner_metrics">
            <div class="container">
                <div class="banner_metrics_wrapper">
                    <?php if (have_rows('banner_metrics', 'option')) : ?>
                        <?php while (have_rows('banner_metrics', 'option')): the_row(); ?>
                            <div class="metric_item">
                                <h2><?php the_sub_field('banner_metric_count'); ?></h2>
                                <p><?php the_sub_field('banner_metric_label'); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="benefits_section" id="whyusstocks">
            <div class="container">
                <div class="benefits_wrapper">
                    <h2><?php the_field('benefits_title'); ?></h2>
                    <div class="benefits_list">
                        <div class="benefits_single_item">
                            <div class="benefits_item_title">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 12.1198C0 5.4924 5.37258 0.119812 12 0.119812C18.6274 0.119812 24 5.4924 24 12.1198C24 18.7472 18.6274 24.1198 12 24.1198C5.37258 24.1198 0 18.7472 0 12.1198Z" fill="#059669"/>
                                    <path d="M16.6673 8.61981L10.2507 15.0365L7.33398 12.1198" stroke="#F8FAFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span><?php the_field('benefits_premium_upgrade_title'); ?></span>
                            </div>
                            <?php if (have_rows('benefits_premium_upgrade')) : ?>
                                <div class="benefits_item_content">
                                    <?php while (have_rows('benefits_premium_upgrade')): the_row(); ?>
                                        <div class="benefits_item_list">
                                            <img src="<?php the_sub_field('benefits_premium_upgrade_icon'); ?>" />
                                            <p><?php the_sub_field('benefits_premium_upgrade_text'); ?></p>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (have_rows('benefits_right_items')) : ?>
                            <div class="benefits_right_list">
                                <?php while (have_rows('benefits_right_items')): the_row(); ?>
                                    <div class="benefits_item">
                                        <div class="benefits_item_title">
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 12.1198C0 5.4924 5.37258 0.119812 12 0.119812C18.6274 0.119812 24 5.4924 24 12.1198C24 18.7472 18.6274 24.1198 12 24.1198C5.37258 24.1198 0 18.7472 0 12.1198Z" fill="#059669"/>
                                                <path d="M16.6673 8.61981L10.2507 15.0365L7.33398 12.1198" stroke="#F8FAFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <span><?php the_sub_field('benefits_right_items_text'); ?></span>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="invest_section" id="whyvested">
            <div class="container">
                <div class="invest_wrapper">
                    <div class="invest_content">
                        <h2><?php the_field('invest_title'); ?></h2>
                        <p><?php the_field('invest_description'); ?></p>
                        <?php if (have_rows('invest_button')) : ?>
                            <?php while (have_rows('invest_button')): the_row(); ?>
                                <a href="<?php the_sub_field('invest_button_link'); ?>"><?php the_sub_field('invest_button_text'); ?></a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="invest_image">
                        <img src="<?php the_field('invest_image'); ?>" alt="<?php the_field('invest_title'); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="explore_section" id="explore">
            <div class="container">
                <div class="explore_wrapper">
                    <h2><?php the_field('explore_title'); ?></h2>
                    <p><?php the_field('explore_description'); ?></p>
                    <div class="explore_list">
                        <?php if (have_rows('explore_list')) : ?>
                            <?php while (have_rows('explore_list')): the_row(); ?>
                                <div class="explore_item">
                                    <div class="explore_item_header">
                                        <img src="<?php the_sub_field('explore_list_icon'); ?>" alt="<?php the_sub_field('explore_list_title'); ?>" />
                                        <h3><?php the_sub_field('explore_list_title'); ?></h3>
                                    </div>
                                    <h5><?php the_sub_field('explore_list_sub_title'); ?></h5>
                                    <p><?php the_sub_field('explore_list_description'); ?></p>
                                    <?php 
                                        $coming_soon = get_sub_field('coming_soon');
                                        if( $coming_soon ): ?>
                                            <span class="coming_soon">Coming Soon</span>
                                        <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (have_rows('banner_button')) : ?>
                        <?php while (have_rows('banner_button')): the_row(); ?>
                            <a href="<?php the_sub_field('banner_button_link'); ?>"><?php the_sub_field('banner_button_text'); ?></a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="global_section" id="global">
            <div class="container">
                <div class="global_wrapper">
                    <div class="global_content">
                        <h2><?php the_field('global_title'); ?></h2>
                        <?php the_field('global_description'); ?>
                    </div>
                    <div class="global_image">
                        <img src="<?php the_field('global_image'); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <section class="tab-section">
            <div class="container">
                <div class="tabs">
                    <div class="head">
                        <h2><?php the_field('tab_heading'); ?></h2>
                        <p><?php the_field('tab_description'); ?></p>
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
                                            <?php if ($index === 3 || $index === 1) : ?><p class="img_source">Source: Bloomberg and CNBC<?php endif; ?></p>
                                        </div>
                                        <!-- <?php if ($index === 1) : ?><p class="img_source mt-0">Source: Bloomberg and CNBC<?php endif; ?></p> -->
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

        <section class="security_section" id="safetysecurity">
            <div class="container">
                <div class="security_wrapper">
                    <h2><?php the_field('security_title', 'option'); ?></h2>
                    <?php if (have_rows('security_list', 'option')) : ?>
                        <div class="security_list">
                            <?php while (have_rows('security_list', 'option')): the_row(); ?>
                                <div class="security_item">
                                    <img src="<?php the_sub_field('security_list_image'); ?>" alt="<?php the_sub_field('security_title'); ?>" />
                                    <p><?php the_sub_field('security_list_text'); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/investors-slider'); ?>

        <section class="process_section" id="stepstoinvest">
            <div class="container">
                <div class="process_wrapper">
                    <h2><?php the_field('process_title', 'option'); ?></h2>
                    <?php if (have_rows('process_list', 'option')) : ?>
                        <div class="process_steps">
                            <?php while (have_rows('process_list', 'option')): the_row(); ?>
                                <div class="process_step">
                                    <div class="process_step_content">
                                        <h3><?php the_sub_field('process_step_title'); ?></h3>
                                        <p><?php the_sub_field('process_step_description'); ?></p>
                                    </div>
                                    <img src="<?php the_sub_field('process_step_image'); ?>" alt="<?php the_sub_field('process_step_title'); ?>" />
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (have_rows('banner_button')) : ?>
                        <?php while (have_rows('banner_button')): the_row(); ?>
                            <a href="<?php the_sub_field('banner_button_link'); ?>"><?php the_sub_field('banner_button_text'); ?></a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php if (have_rows('faqs_list')) : ?>
            <section class="faqs_section">
                <div class="container">
                    <div class="faqs_wrapper">
                        <h2 class="section_title"><?php the_field('faqs_title'); ?></h2>
                        <?php while (have_rows('faqs_list')) : the_row(); ?>
                            <div class="single_faq">
                                <div class="faq_que">
                                    <h4><?php the_sub_field('faq_question') ?></h4>
                                    <svg width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 7.7998L7 1.7998L13 7.7998" stroke="#002852" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
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
<?php
endwhile;
get_footer();
