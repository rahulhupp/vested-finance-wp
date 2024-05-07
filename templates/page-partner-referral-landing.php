<?php
/*
Template name: Page : Partner Referral Landing
*/
get_header(); ?>
<div id="content" role="main" class="partner-referral-page">

    <section class="section-partner">
        <div class="container">
            <div class="partner-heading-content mobile-device">
                <?php the_field('referral_title'); ?>
            </div>
            <div class="row">
                <div class="left-part">
                    <div class="partner-left-content">
                        <div class="partner-heading-content">
                            <?php the_field('referral_title'); ?>
                        </div>
                        <p><?php the_field('referral_content'); ?></p>
                        <div class="hero-btn">
                            <a href="#" class="hero-blue-btn"><?php the_field('enroll_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="right-part">
                    <?php if (get_field('partner_image')): ?>
                        <img src="<?php the_field('partner_image'); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </section>

    <section class="section-benefits">
        <div class="container">
            <div class="benefits-heading-content">
                <h3> <?php the_field('benefits_title'); ?></h3>
                <p class="benefits-mobile-device"> <?php the_field('benefits_heading_content_mobile'); ?></p>
            </div>
            <div class="benefits-content">
                <div class="benefits-row">
                    <?php if (have_rows('benefits_content')): ?>
                        <?php while (have_rows('benefits_content')):
                            the_row(); ?>
                            <div class="benefits-block">
                                <div class="benefits-block-image">
                                    <img src="<?php the_sub_field('benefits_image'); ?>" />
                                </div>
                                <div class="benefits-block-content">
                                    <h6>
                                        <?php the_sub_field('benefits_block_title'); ?>
                                    </h6>
                                    <p>
                                        <?php the_sub_field('benefits_block_content'); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </section>

    <section class="section-vested-partner">
        <div class="container">
            <div class="partner-heading">
                <h3> <?php the_field('partner_heading_content'); ?></h3>
            </div>
            <div class="partner-content">
                <div class="partner-row">
                    <?php if (have_rows('partner_content')): ?>
                        <?php while (have_rows('partner_content')):
                            the_row(); ?>
                            <div class="partner-block">
                                <img src="<?php the_sub_field('partner_image'); ?>" />
                                <h6>
                                    <?php the_sub_field('partner_block_heading'); ?>
                                </h6>
                                <p>
                                    <?php the_sub_field('partner_block_content'); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="partner-btn">
                <div class="hero-btn">
                    <a href="#" class="hero-blue-btn"><?php the_field('partner_label_btn'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-process">
        <div class="container">
            <div class="process-heading-content">
                <h3><?php the_field('process-heading-content'); ?></h3>
            </div>
            <div class="process-content">
                <div class="process-row">
                    <?php if (have_rows('process_block_content')): ?>
                        <?php while (have_rows('process_block_content')):
                            the_row(); ?>
                            <div class="process-block">
                                <img src="<?php the_sub_field('process_block_image'); ?>" />
                                <h6>
                                    <?php the_sub_field('process_block_heading_content'); ?>
                                </h6>
                                <p>
                                    <?php the_sub_field('process_content'); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="process-faqs">
                <p><?php the_field('process_faqs'); ?></p>
            </div>
        </div>

    </section>
    <section class="section-network">
        <div class="container">
            <div class="network-row">
                <div class="network-left">
                    <h4 class="network-desktop"><?php the_field('network_title'); ?></h4>
                    <h5 class="network-mobile"><?php the_field('network_title_mobile'); ?></h5>
                    <h3><?php the_field('network_vested_content'); ?></h3>
                    <p class="network-mobile"><?php the_field('network_contact_mobile_device'); ?></p>
                </div>
                <div class="network-right">
                    <a href="#" class="hero-white-btn network-desktop"><?php the_field('network_label_btn'); ?></a>
                    <div class="network-mobile">
                        <a href="#" class="hero-white-btn"><?php the_field('network_label_btn_mobile'); ?></a>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <?php get_footer(); ?>