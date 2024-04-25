<?php
/*
Template name: Page - C2C-Landing
*/
get_header(); ?>

<div id="content" role="main" class="landing-page-c2c">

    <section class="landing-hero">
        <div class="container">
            <div class="mobile-device">
                <?php the_field('mobile_device_heading_content'); ?>
            </div>
            <div class="row">
                <div class="left-part">
                    <div class="hero-left-content">
                        <?php the_field('autopilot_content'); ?>
                        <p><?php the_field('refer_and_earn_content'); ?></p>
                        <div class="hero-btn">
                            <a href="<?php echo esc_attr( get_field('invite_link') ); ?>" class="hero-blue-btn" target="_blank"><?php the_field('autopilot_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="right-part">
                    <?php if (get_field('autopilot_image')): ?>
                        <img src="<?php the_field('autopilot_image'); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="vested-earn-while">
        <div class="container">
            <div class="vested-earn-heading">
                <h2><?php the_field('vested_earn_while_title'); ?></h2>
                <p><?php the_field('vested_earn_while_content'); ?></p>
            </div>
            <div class="earn-block">
                <div class="earn-block-grid">
                    <?php if (have_rows('vested_earn_block')): ?>
                        <?php while (have_rows('vested_earn_block')):
                            the_row(); ?>
                            <div class="earn-block-content"
                                style="background-color: <?php the_sub_field('block_background_color'); ?>;">
                                <div class="earn-block-top">
                                    <h6 style="color: <?php the_sub_field('text_color'); ?>;">
                                        <?php the_sub_field('block_title'); ?>
                                    </h6>
                                    <img src="<?php the_sub_field('block_title_image'); ?>" />
                                </div>
                                <div class="earn-block-middle">
                                    <h6 style="color: <?php the_sub_field('text_color'); ?>;">
                                        <?php the_sub_field('block_middle_title'); ?>
                                    </h6>
                                    <p style="color: <?php the_sub_field('text_color'); ?>;">
                                        <?php the_sub_field('block_middle_content'); ?>
                                    </p>
                                </div>
                                <div class="earn-block-bottom">
                                    <h6 style="color: <?php the_sub_field('text_color'); ?>;">
                                        <?php the_sub_field('block_earn_title'); ?>
                                    </h6>
                                    <p style="color: <?php the_sub_field('text_color'); ?>;">
                                        <?php the_sub_field('block_earn_content'); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="earn-terms">
                <a href="#"><?php the_field('earn-team'); ?></a>
            </div>
        </div>

    </section>

    <section class="landing-super-easy">
        <div class="container">
            <div class="super-easy-title">
                <h2><?php the_field('super_easy_title'); ?></h2>
            </div>
            <div class="super-easy-block">
                <div class="super-easy-grid">
                    <?php if (have_rows('super_easy_content')): ?>
                        <?php while (have_rows('super_easy_content')):
                            the_row(); ?>
                            <div class="super-block-content">
                                <div class="super-block">
                                    <img src="<?php the_sub_field('super_easy_block_image'); ?>" />
                                    <h3>
                                        <?php the_sub_field('super_easy_block_title'); ?>
                                    </h3>
                                    <p>
                                        <?php the_sub_field('super_easy_block_content'); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="super-easy-btn">
                <a href="<?php echo esc_attr( get_field('invite_link') ); ?>" target="_blank" class="hero-blue-btn"><?php the_field('easy_btn'); ?></a>
                <p><?php the_field('easy_faq_content'); ?></p>
            </div>
        </div>
    </section>

    <section class="landing-network">
        <div class="container">
            <div class="landing-network-row">
                <div class="landing-network-left">
                    <?php the_field('landing_network_title'); ?>
                    <p><?php the_field('landing_network_content'); ?></p>
                </div>
                <div class="landing-network-right">
                    <div class="network-btn">
                        <a href="<?php echo esc_attr( get_field('invite_link') ); ?>" target="_blank" class="hero-white-btn"><?php the_field('landing_network_btn'); ?></a>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?php get_footer(); ?>