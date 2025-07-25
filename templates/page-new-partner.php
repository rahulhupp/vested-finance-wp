<?php
/*
Template name: Partner New Landing Page
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
                        <?php
                            $banner_title = get_field('banner_title');
                            if (!$banner_title) {
                                $banner_title = get_field('banner_title', 'option');
                            }
                        ?>
                        <h1><?php echo esc_html($banner_title); ?></h1>
                        <?php if (have_rows('banner_points')) : ?>
                            <ul>
                                <?php while (have_rows('banner_points')): the_row(); ?>
                                    <li><?php the_sub_field('banner_point'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php elseif (have_rows('banner_points', 'option')) : ?>
                            <ul>
                                <?php while (have_rows('banner_points', 'option')): the_row(); ?>
                                    <li><?php the_sub_field('banner_point'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (have_rows('banner_button')) : ?>
                            <?php while (have_rows('banner_button')): the_row(); ?>
                                <a href="<?php the_sub_field('banner_button_link'); ?>"><?php the_sub_field('banner_button_text'); ?></a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php $banner_disclosure = get_field('banner_disclosure'); ?>
                        <?php if ($banner_disclosure) : ?>
                            <p class="banner_disclosure"><?php echo $banner_disclosure; ?></p>
                        <?php else: ?>
                            <p class="banner_disclosure">Offered by VF Securities Inc. Stock symbols shown here are representative of our offerings and are not meant to be a recommendation</p>
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
                    <span class="banner_metrics_disclosure">All numbers displayed are as of July 2025</span>
                </div>
            </div>
        </section>

        <?php if (have_rows('vests')) : ?>
            <section class="vested_features_section">
                <div class="container">
                    <div class="vested_features_wrapper">
                        <h2><?php the_field('vests_title'); ?></h2>
                        <?php 
                            // Collect vest IDs and minimum investments from the repeater field
                            $allowed_vest_ids = array();
                            $vest_min_investments = array();
                            while (have_rows('vests')): the_row(); 
                                $vest_id = get_sub_field('vest_id');
                                $vest_min_investment = get_sub_field('vest_min_investment');
                                if (!empty($vest_id)) {
                                    $allowed_vest_ids[] = $vest_id;
                                    $vest_min_investments[$vest_id] = $vest_min_investment ?: '$100'; // Default to $100 if empty
                                }
                            endwhile;

                            set_query_var('allowed_vest_ids', $allowed_vest_ids);
                            set_query_var('vest_min_investments', $vest_min_investments);
                            get_template_part('template-parts/new-partner-vests'); 
                        ?>
                        <?php if (have_rows('banner_button')) : ?>
                            <?php while (have_rows('banner_button')): the_row(); ?>
                                <a href="<?php the_sub_field('banner_button_link'); ?>" class="vested_features_button">Sign Up to Start Investing</a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <section class="services_section" id="whyusstocks">
            <div class="container">
                <div class="services_wrapper">
                    <h2><?php the_field('services_title', 'option'); ?></h2>
                    <p><?php the_field('services_description', 'option'); ?></p>
                    <?php if (have_rows('services_list', 'option')) : ?>
                        <div class="services_list">
                            <?php while (have_rows('services_list', 'option')): the_row(); ?>
                                <div class="service_item">
                                    <h3><?php the_sub_field('services_list_title'); ?></h3>
                                    <p><?php the_sub_field('services_list_description'); ?></p>
                                    <img src="<?php the_sub_field('services_list_image'); ?>" alt="<?php the_sub_field('service_title'); ?>" />
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="features_section" id="whyvested" style="background-image: url('<?php the_field('features_background_image', 'option'); ?>');">
            <div class="container">
                <div class="features_wrapper">
                    <h2><?php the_field('features_title', 'option'); ?></h2>
                    <p><?php the_field('features_description', 'option'); ?></p>
                    <?php if (have_rows('features_list', 'option')) : ?>
                        <div class="features_list">
                            <?php while (have_rows('features_list', 'option')): the_row(); ?>
                                <div class="feature_item">
                                    <img src="<?php the_sub_field("feature_list_icon") ?>" alt="<?php the_sub_field('feature_list_title'); ?>" />
                                    <h3><?php the_sub_field('feature_list_title'); ?></h3>
                                    <p><?php the_sub_field('feature_list_description'); ?></p>
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
            <button type="button" class="features_prev">
                <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="54" height="54" rx="27" fill="#002852"/>
                    <path d="M30 33L24 27L30 21" stroke="#F8FAFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button type="button" class="features_next">
                <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="54" height="54" rx="27" fill="#002852"/>
                    <path d="M24 33L30 27L24 21" stroke="#F8FAFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>          
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

        <section class="about_section">
            <div class="container">
                <div class="about_wrapper" style="background-color: <?php the_field('template_color'); ?>;">
                    <img src="<?php the_field('about_logo'); ?>" alt="Partner logo">
                    <div class="about_content" style="color:  <?php the_field('about_text_color'); ?>;">
                        <?php the_field('about_description'); ?>
                    </div>
                </div>    
            </div>
        </section>

        <?php get_template_part('template-parts/investors-slider'); ?>

        <?php
        $pricing_table_source = null;
        if (have_rows('pricing_table')) {
            $pricing_table_source = '';
        } elseif (have_rows('pricing_table', 'option')) {
            $pricing_table_source = 'option';
        }
        if ($pricing_table_source !== null) :
        ?>
            <section class="pricing_section" id="pricing">
                <div class="container">
                    <div class="pricing_wrapper">
                        <h2><?php echo esc_html(get_field('pricing_title', $pricing_table_source ?: get_the_ID())); ?></h2>
                        <div class="pricing_table">
                            <table>
                                <tr>
                                    <th></th>
                                    <th>Basic</th>
                                    <th>Premium</th>
                                </tr>
                                <?php while (have_rows('pricing_table', $pricing_table_source)) : the_row(); ?>
                                <?php $basic = get_sub_field('pricing_basic'); ?>
                                <?php $premium = get_sub_field('pricing_premium'); ?>
                                    <tr>
                                        <td><?php the_sub_field('pricing_label'); ?></td>
                                        <td>
                                            <?php 
                                                if ($basic === 'null') {
                                                   echo '<span class="not_available">-</span>';
                                                } else if ($basic === 'true') {
                                                   echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22Z" fill="#22C55E" stroke="#22C55E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9 12L11 14L15 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>';
                                                } else {
                                                   echo $basic;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($premium === 'null') {
                                                   echo '<span class="not_available">-</span>';
                                                } else if ($premium === 'true') {
                                                   echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22Z" fill="#22C55E" stroke="#22C55E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9 12L11 14L15 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>';
                                                } else {
                                                   echo $premium;
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

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
    </div>
<?php
endwhile;
get_footer();
