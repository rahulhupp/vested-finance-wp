<?php
/*
Template name: Global Mutual Funds Page
*/
get_header(); ?>

<div id="content" role="main" class="mutual-funds-page">
    <section class="mutual-funds-info">
        <div class="container">
            <div class="funds-row">
                <div class="funds-content">
                    <?php the_field('funds_content_global'); ?>
                    <div class="bottom">
                        <div class="buttons">
                            <a class="btn_dark" href="<?php the_field('start_investing_link_global'); ?>" target="_blank"><?php the_field('start_investing_label_global'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="funds-image">
                    <?php
                    $image = get_field('funds_image_global');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt']); ?>" />
                    <?php endif; ?>
                </div>
            </div>
            <?php if (get_field('banner_disclosure')): ?>
                <p class="funds-disclosure"><?php the_field('banner_disclosure'); ?></p>
            <?php endif; ?>
        </div>

        <div class="banner_popup_overlay">
            <div class="banner_popup">
                <div class="close_btn"><i class="fa fa-times"></i></div>
                <p>This page contains information on investing in US Stocks and ETFs via Vested. Securities mentioned on this page are offered through VF Securities, Inc. (member FINRA/SIPC). Alternative investment options outside of US Stocks and ETFs, that are offered on other sections of the website are not FINRA regulated and not protected by the SIPC. Stocks displayed are a representative sample of the watchlist feature and is not intended as a recommendation.</p>
            </div>
        </div>
    </section>
    <section class="why-info">
        <div class="container">
            <h2 class="section-title"><?php the_field('why_heading'); ?></h2>
            <?php if (have_rows('why_list')): ?>
                <div class="why_wrap">
                    <?php while (have_rows('why_list')): the_row(); ?>
                        <div class="why-list-item">
                            <div class="icon">
                                <img src="<?php the_sub_field('icon'); ?>" alt="<?php the_sub_field('title'); ?>">
                            </div>
                            <div class="meta">
                                <h4 class="title"><?php the_sub_field('title'); ?></h4>
                                <p class="desc"><?php the_sub_field('description'); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <section class="advantages">
        <div class="container">
            <h2 class="section-title"><?php the_field('advantages_title'); ?></h2>
        </div>
        <div class="advantages-slider-wrap">
            <div class="advantages-slider">
                <?php while (have_rows('advantages_list')) : the_row(); ?>
                    <div class="advantages-slide">
                        <div class="advantages-slide-inner">
                            <div class="advantages-info">
                                <div class="advantages-img">
                                    <img src="<?php the_sub_field('advantages_image') ?>" alt="<?php the_sub_field('advantages_name') ?>">
                                </div>
                                <div class="advantages-detail">
                                    <h4 class="advantages-name">
                                        <?php the_sub_field('advantages_name') ?>
                                    </h4>
                                    <p class="advantages-designation">
                                        <?php the_sub_field('advantages_designation') ?>
                                    </p>
                                    <?php if (get_sub_field('tax_disclosure')): ?>
                                        <span class="tax_disclosure"><?php the_sub_field('tax_disclosure'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <section class="who-info">
        <div class="container">
            <div class="who-info-inner">
                <h2 class="section-title"><?php the_field('who_heading'); ?></h2>
                <?php if (have_rows('who_list')): ?>
                    <div class="who-wrap">
                        <?php while (have_rows('who_list')): the_row(); ?>
                            <div class="who-list-item">
                                <div class="icon">
                                    <img src="<?php the_sub_field('icon'); ?>" alt="<?php the_sub_field('title'); ?>">
                                </div>
                                <div class="meta">
                                    <h4 class="title"><?php the_sub_field('title'); ?></h4>
                                    <p class="desc"><?php the_sub_field('description'); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <div class="buttons">
                    <a class="btn_dark" href="<?php the_field('who_start_investing_link_global'); ?>" target="_blank"><?php the_field('who_start_investing_label_global'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="how-works-info">
        <div class="container">
            <h2 class="section-title"><?php the_field('how_works_heading'); ?></h2>
            <div class="portfolio_slider_wrap">
                <div class="portfolio_slider slider single-item">
                    <?php while (have_rows('portfolio_slider_global')) : the_row(); ?>
                        <div class="single_portfolio_slider">
                            <?php
                            $image = get_sub_field('slider_image_global');
                            if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="portfolio_slider_content_wrap">
                    <?php if (have_rows('portfolio_slider_global')) : ?>
                        <div class="portfolio_slider_content">
                            <?php while (have_rows('portfolio_slider_global')) : the_row(); ?>
                                <div class="single_portfolio_slider_content">
                                    <div class="portfolio_slider_content_inner">
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBar"></span>
                                        <span data-slick-index="<?php echo get_row_index(); ?>" class="progressBarMob"></span>
                                        <div class="portfolio_slider_inner_content">
                                            <span class="slider_index">0<?php echo get_row_index(); ?></span>
                                            <h3><?php the_sub_field('slider_title_global') ?></h3>
                                            <p class="single_slider_desc">
                                                <?php the_sub_field('slider_description_global') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('how_it_works_disclosure')) : ?>
                        <p class="how_it_works_disclosure"><?php the_field('how_it_works_disclosure'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title"><?php the_field('testimonials_heading'); ?></h2>
            <div class="testimonials-wrap">
                <?php if (have_rows('investors_reviews', 'option')): ?>
                    <div class="testimonials-slider">
                        <?php while (have_rows('investors_reviews', 'option')) : the_row(); ?>
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="leaders-info">
                                        <figure class="profile">
                                            <img src="<?php the_sub_field('investor_image') ?>" alt="<?php the_sub_field('investor_name') ?>">
                                        </figure>
                                        <div class="details">
                                            <h3><?php the_sub_field('investor_name') ?></h3>
                                            <p><?php the_sub_field('investor_designation'); ?></p>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <?php
                                        $review = get_sub_field('investor_review');
                                        $review = rtrim($review);
                                        if (substr($review, -4) === '</p>') {
                                            $review = substr_replace($review, ' <sup></sup>', -4, 0);
                                        } else {
                                            $review .= ' <sup></sup>';
                                        }
                                        echo $review;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <div class="testimonial-slider-nav">
                    <div class="testimonial-prev">
                        <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.1035 10.0566H1.74131M1.74131 10.0566L10.9639 0.833984M1.74131 10.0566L10.9639 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                        </svg>
                    </div>
                    <div class="testimonial-next">
                        <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.283203 10.0566H25.6454M25.6454 10.0566L16.4228 0.833984M25.6454 10.0566L16.4228 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                        </svg>
                    </div>
                </div>
            </div>
            <?php if (get_field('testimonial_disclosure')): ?>
                <p class="testimonial_disclosure"><?php the_field('testimonial_disclosure'); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php if (have_rows('faq_list_global')) : ?>
        <section class="home_page_faqs">
            <div class="container">
                <h2 class="section-title"><span><?php the_field('faqs_heading_global'); ?></span></h2>

                <div class="home_page_faq_wrap">
                    <?php while (have_rows('faq_list_global')) : the_row(); ?>
                        <div class="single_faq">
                            <div class="faq_que">
                                <h4>
                                    <?php the_sub_field('faq_question_global') ?>
                                </h4>
                            </div>
                            <div class="faq_content">
                                <?php the_sub_field('faq_answer_global') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="cta">
        <div class="container">
            <div class="cta_wrap">
                <div class="cta_query_col">
                    <h2 class="query_que section-title"><?php the_field('cta_heading'); ?></h2>
                </div>
                <div class="cta_btn_col">
                    <a href="<?php the_field('cta_button_url'); ?>" class="btn btn_light" target="_blank"><?php the_field('cta_button_text'); ?></a>
                </div>
            </div>
        </div>
    </section>
</div>
<?php if (have_rows('faq_list_global')) : ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                <?php $rowCount = 0; ?>
                <?php while (have_rows('faq_list_global')) : the_row(); ?> {
                        "@type": "Question",
                        "name": "<?php the_sub_field('faq_question_global') ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "
                            <?php the_sub_field('faq_answer_global') ?> "
                        }
                    }
                    <?php echo (++$rowCount === count(get_field('faq_list_global'))) ? '' : ','; ?>
                <?php endwhile; ?>
            ]
        }
    </script>
<?php endif; ?>
<?php get_footer(); ?>