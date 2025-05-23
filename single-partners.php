<?php

get_header();
while (have_posts()) :
    the_post();
    $primaryColor = get_field('primary_color') ? get_field('primary_color') : '#262626';
?>
    <style>
        .mudrex-vested h1 span,
        .pricing .pricing-cards .pricing-card .pricing-content:nth-child(2) h5,
        .about-mudrex .about-mudrex-content h2 span {
            color: <?php echo $primaryColor; ?>;
        }

        .pricing-content.true svg path {
            stroke: <?php echo $primaryColor; ?>;
        }
    </style>
    <div class="lending-page">
        <section class="mudrex-vested">
            <div class="container">
                <div class="stock-row">
                    <div class="stock-content">
                        <?php if (get_field('hero_section_title')): ?>
                            <h1><?php the_field('hero_section_title'); ?></h1>
                        <?php endif; ?>

                        <?php if (get_field('hero_subtitle')): ?>
                            <p><?php the_field('hero_subtitle'); ?></p>
                        <?php endif; ?>

                        <div class="stock-contact">
                            <?php if (get_field('cta_button_link') && get_field('cta_button_text')): ?>
                                <a class="btn_dark" href="<?php the_field('cta_button_link'); ?>">
                                    <?php the_field('cta_button_text'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (get_field('hero_section_description')): ?>
                                <p><?php the_field('hero_section_description'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stock-image">
                        <?php
                        $hero_image = get_field('hero_image');
                        if ($hero_image):
                        ?>
                            <figure>
                                <img src="<?php echo esc_url($hero_image['url']); ?>"
                                    alt="<?php echo esc_attr($hero_image['alt']); ?>">
                            </figure>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (get_field('slider_images')): ?>
                <div class="logo-slider">
                    <?php
                    $gallery = get_field('slider_images');
                    foreach ($gallery as $image):
                    ?>
                        <div class="slick-slide">
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt'] ? $image['alt'] : 'Default Alt Text'); ?>">
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>

            <?php if (get_field('hero_section_disclaimer')): ?>
                <div class="container disclosure">
                    <p><?php the_field('hero_section_disclaimer'); ?></p>
                </div>
            <?php endif; ?>
        </section>
        <section class="our-offers">
            <div class="container our-offers-row">
                <div class="offers-future-image">
                    <?php
                    $offers_image = get_field('our_offers_section_image');
                    if ($offers_image):
                    ?>
                        <figure>
                            <img src="<?php echo esc_url($offers_image['url']); ?>"
                                alt="<?php echo esc_attr($offers_image['alt']); ?>">
                        </figure>
                    <?php endif; ?>
                </div>
                <div class="offers-content">
                    <?php if (get_field('our_offers_section_heading')): ?>
                        <h2><?php the_field('our_offers_section_heading'); ?></h2>
                    <?php endif; ?>

                    <?php if (have_rows('unique_offering_list')) : ?>
                        <ul class="unique-offers-list">
                            <?php while (have_rows('unique_offering_list')): the_row(); ?>
                                <li><?php the_sub_field('single_offer'); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                </div>
            </div>
        </section>
        <section class="invest-stock-market">
            <div class="container">
                <div class="section-title">
                    <?php if (get_field('why_choose_us_title')): ?>
                        <h2><?php the_field('why_choose_us_title'); ?></h2>
                    <?php endif; ?>
                </div>
                <div class="stock-market-row">
                    <div class="future-image">
                        <?php
                        $section_image = get_field('why_choose_us_image');
                        if ($section_image):
                        ?>
                            <figure>
                                <img src="<?php echo esc_url($section_image['url']); ?>"
                                    alt="<?php echo esc_attr($section_image['alt']); ?>">
                            </figure>
                        <?php endif; ?>
                    </div>
                    <div class="section-title">
                        <?php if (get_field('why_choose_us_title')): ?>
                            <h2><?php the_field('why_choose_us_title'); ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="stock-market-content-grid">
                        <?php if (have_rows('why_choose_us_description')): ?>
                            <?php while (have_rows('why_choose_us_description')):
                                the_row(); ?>
                                <div class="grid-item">
                                    <?php if (get_sub_field('item_title')): ?>
                                        <h3><?php the_sub_field('item_title'); ?></h3>
                                    <?php endif; ?>
                                    <?php if (get_sub_field('item_description')): ?>
                                        <p><?php the_sub_field('item_description'); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="our-process">
            <div class="container">
                <?php if (get_field('process_steps_section_title')): ?>
                    <div class="section-title">
                        <h2><?php the_field('process_steps_section_title'); ?></h2>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('process_steps')): ?>
                    <div class="process-steps">
                        <?php while (have_rows('process_steps')):
                            the_row();
                            $rowIndex = get_row_index(); ?>
                            <div class="process-step">
                                <div class="count"><?php echo $rowIndex; ?></div>

                                <div class="step-content">
                                    <?php
                                    $step_logo = get_sub_field('step_logo');
                                    if ($step_logo):
                                    ?>
                                        <div class="logo">
                                            <img src="<?php echo esc_url($step_logo['url']); ?>"
                                                alt="<?php echo esc_attr($step_logo['alt']); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('step_title')): ?>
                                        <h3><?php the_sub_field('step_title'); ?></h3>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('step_description')): ?>
                                        <p><?php the_sub_field('step_description'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="about-vested">
            <div class="container about-vested-row">
                <div class="about-us-content">
                    <?php if (get_field('about_section_title')): ?>
                        <h2><?php the_field('about_section_title'); ?></h2>
                    <?php endif; ?>

                    <?php if (get_field('about_section_title_description')): ?>
                        <div class="description">
                            <?php the_field('about_section_title_description'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (have_rows('benefits_list')): ?>
                        <ul>
                            <?php while (have_rows('benefits_list')):
                                the_row(); ?>
                                <li>
                                    <?php if (get_sub_field('benefit_icon')): ?>
                                        <?php
                                        $benefit_icon = get_sub_field('benefit_icon');
                                        $icon_url = $benefit_icon['url'];
                                        $icon_alt = $benefit_icon['alt'] ?: 'Benefit Icon';
                                        ?>
                                        <span class="benefit-icon">
                                            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>">
                                        </span>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('benefit_text')): ?>
                                        <p><?php the_sub_field('benefit_text'); ?></p>
                                    <?php endif; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="our-logo">
                    <?php
                    $company_logo = get_field('company_logo');
                    if ($company_logo):
                    ?>
                        <figure>
                            <img src="<?php echo esc_url($company_logo['url']); ?>"
                                alt="<?php echo esc_attr($company_logo['alt']); ?>">
                        </figure>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="invest-through">
            <div class="container">
                <?php if (get_field('invest_through_section_title')): ?>
                    <div class="section-title">
                        <h2><?php the_field('invest_through_section_title'); ?></h2>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('invest_through_cards')): ?>
                    <div class="grid-icon-cards">
                        <?php while (have_rows('invest_through_cards')):
                            the_row(); ?>
                            <div class="icon-card">
                                <div class="icon">
                                    <?php
                                    $icon_image = get_sub_field('icon_image');
                                    if ($icon_image):
                                    ?>
                                        <img src="<?php echo esc_url($icon_image['url']); ?>"
                                            alt="<?php echo esc_attr($icon_image['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                                <?php if (get_sub_field('card_title')): ?>
                                    <h3><?php the_sub_field('card_title'); ?></h3>
                                <?php endif; ?>

                                <?php if (get_sub_field('card_description')): ?>
                                    <p><?php the_sub_field('card_description'); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="pricing">
            <div class="container">
                <?php if (get_field('pricing_section_title')): ?>
                    <div class="section-title">
                        <h2><?php the_field('pricing_section_title'); ?></h2>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('plans')): ?>
                    <div class="pricing-cards">
                        <div class="pricing-info">
                            <?php
                            $features = [];
                            if (have_rows('plans')):
                                while (have_rows('plans')):
                                    the_row();
                                    if (have_rows('features')):
                                        while (have_rows('features')):
                                            the_row();
                                            $feature_name = get_sub_field('feature_name');
                                            if (!in_array($feature_name, $features)) {
                                                $features[] = $feature_name;
                                            }
                                        endwhile;
                                    endif;
                                endwhile;
                            endif;

                            foreach ($features as $feature): ?>
                                <div class="pricing-content">
                                    <h6><?php echo $feature; ?></h6>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="pricing-cards-wapper">
                            <div class="flex-row">
                                <?php if (have_rows('plans')): ?>
                                    <?php while (have_rows('plans')):
                                        the_row(); ?>
                                        <div class="pricing-card">
                                            <h3><?php the_sub_field('plan_name'); ?></h3>
                                            <?php
                                            foreach ($features as $feature):
                                                $feature_found = false;
                                                if (have_rows('features')):
                                                    while (have_rows('features')):
                                                        the_row();
                                                        if (get_sub_field('feature_name') === $feature):
                                                            $feature_value = get_sub_field('feature_value');
                                                            $feature_found = true; ?>
                                                            <div class="pricing-content true">
                                                                <h5><?php echo $feature_value; ?></h5>
                                                            </div>
                                                    <?php break;
                                                        endif;
                                                    endwhile;
                                                endif;
                                                if (!$feature_found): ?>
                                                    <div class="pricing-content">
                                                        <svg width="35" height="35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M25 10L10 25M10 10L25 25" stroke="#595959" stroke-width="3.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="investors-and-partners">
            <div class="container flex-box">
                <div class="content">
                    <?php if (get_field('investors_section_title')): ?>
                        <h2><?php the_field('investors_section_title'); ?></h2>
                    <?php endif; ?>

                    <?php if (get_field('investors_section_description')): ?>
                        <p><?php the_field('investors_section_description'); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (have_rows('investors_and_partners')): ?>
                    <div class="logo-grid">
                        <?php while (have_rows('investors_and_partners')):
                            the_row(); ?>
                            <div class="grid-item">
                                <?php
                                $partner_logo = get_sub_field('partner_logo');
                                $partner_name = get_sub_field('partner_name');
                                ?>

                                <?php if ($partner_logo): ?>
                                    <figure>
                                        <img src="<?php echo esc_url($partner_logo['url']); ?>"
                                            alt="<?php echo esc_attr($partner_logo['alt'] ?: $partner_name ?: 'Partner Logo'); ?>">
                                    </figure>
                                <?php endif; ?>

                                <?php if ($partner_name): ?>
                                    <h3><?php echo esc_html($partner_name); ?></h3>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="about-mudrex">
            <div class="container flex-box">
                <?php if(get_field('about_mudrex_image')): ?>
                <div class="about-mudrex-image">
                    <?php
                    $about_mudrex_image = get_field('about_mudrex_image');
                    $about_mudrex_title = get_field('about_mudrex_title');
                    ?>
                    <?php if ($about_mudrex_image): ?>
                        <figure>
                            <img src="<?php echo esc_url($about_mudrex_image['url']); ?>"
                                alt="<?php echo esc_attr($about_mudrex_image['alt'] ?: $about_mudrex_title ?: 'About Mudrex Image'); ?>">
                        </figure>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="about-mudrex-content<?php if(!get_field('about_mudrex_image')): ?> w-full<?php endif;?>">
                    <?php if (get_field('about_mudrex_title')): ?>
                        <h2><?php the_field('about_mudrex_title'); ?></h2>
                    <?php endif; ?>

                    <?php if (get_field('about_mudrex_description')): ?>
                        <?php the_field('about_mudrex_description'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="investing-faqs">
            <div class="container flex-box">
                <div class="section-title">
                    <?php if (get_field('faq_section_title')): ?>
                        <h2><?php the_field('faq_section_title'); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if (have_rows('investing_faqs')): ?>
                    <div class="accordionRow">
                        <?php
                        $faqs = [];
                        while (have_rows('investing_faqs')):
                            the_row();
                            $faqs[] = [
                                'faq_question' => get_sub_field('faq_question'),
                                'faq_answer' => get_sub_field('faq_answer'),
                            ];
                        endwhile;

                        $split_index = ceil(count($faqs) / 2);
                        $faqs_col_1 = array_slice($faqs, 0, $split_index);
                        $faqs_col_2 = array_slice($faqs, $split_index);
                        ?>
                        <div class="col-2">
                            <?php foreach ($faqs_col_1 as $faq): ?>
                                <div class="accordion-item">
                                    <div class="accordion-trigger">
                                        <h3><?php echo esc_html($faq['faq_question']); ?></h3>
                                        <div class="accordionIcon">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="accordion-content">
                                        <p><?php echo esc_html($faq['faq_answer']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-2">
                            <?php foreach ($faqs_col_2 as $faq): ?>
                                <div class="accordion-item">
                                    <div class="accordion-trigger">
                                        <h3><?php echo esc_html($faq['faq_question']); ?></h3>
                                        <div class="accordionIcon">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="accordion-content">
                                        <p><?php echo esc_html($faq['faq_answer']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </section>
        <?php if(get_field("contact_form_shortcode")): ?>
        <section class="contact-us">
            <div class="container">
                <div class="inner-container">
                    <div class="section-info">
                        <?php if (get_field('contact_section_title')): ?>
                            <h2><?php the_field('contact_section_title'); ?></h2>
                        <?php endif; ?>

                        <?php if (get_field('contact_section_subtitle')): ?>
                            <p><?php the_field('contact_section_subtitle'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-container">
                        <?php echo do_shortcode(get_field("contact_form_shortcode")); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (get_field('footer_contact_info')): ?>
            <section class="footer-top-contact-info">
                <div class="container">
                    <p><?php the_field('footer_contact_info'); ?></p>
                </div>
            </section>
        <?php endif; ?>
    </div>

<?php
endwhile;
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var signUpLink = "<?php the_field('cta_button_link'); ?>";
        var signUpBtns = document.querySelectorAll('.account-menu .menu-wrapper .primary-btn a');

        signUpBtns.forEach((btn) => {
            btn.href = signUpLink;
        });
    });
</script>
<?php get_footer();
