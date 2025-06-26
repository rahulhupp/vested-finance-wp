<?php
/*
Template name: Page - Managed Portfolios Page
Template Post Type: post, page
*/
get_header();

while (have_posts()) :
    the_post();
?>
<?php
    // Step 1: Get the partner token
    $token_url = 'https://vested-api-prod.vestedfinance.com/get-partner-token';
    $headers = [
        'partner-id: 7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
        'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9',
        'vest-list-access: true'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $token = curl_exec($ch);
    curl_close($ch);

    if ($token) {
        // Step 2: Get the vests list
        $vests_url = 'https://vested-api-prod.vestedfinance.com/v1/partner/vests-list';
        $vests_headers = [
            'partner-authentication-token: ' . $token,
            'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9'
        ];

        $ch2 = curl_init($vests_url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $vests_headers);
        $vests_response = curl_exec($ch2);
        curl_close($ch2);

        $vests_data = json_decode($vests_response, true);

        if (!empty($vests_data['vests'])) {
            // Convert to array and sort by oneYearReturn
            $vests = array_values($vests_data['vests']);
            usort($vests, function($a, $b) {
                if ($a['oneYearReturn'] === "NaN%") return 1;
                if ($b['oneYearReturn'] === "NaN%") return -1;
                return floatval($b['oneYearReturn']) - floatval($a['oneYearReturn']);
            });
        }
    }
?>
    <div class="managed_portfolios_page">
        <section class="banner_section">
            <div class="container">
                <div class="banner_wrapper">
                    <div class="banner_content">
                        <img src="<?php the_field('banner_advisory_logo'); ?>" alt="advisory_logo" />
                        <h1><?php the_field('banner_title'); ?></h1>
                        <p><?php the_field('banner_description'); ?></p>
                        <?php if (have_rows('banner_button')) : ?>
                            <?php while (have_rows('banner_button')): the_row(); ?>
                                <a href="<?php the_sub_field('banner_button_link'); ?>"><?php the_sub_field('banner_button_text'); ?></a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <span class="banner_desktop_image"><?php the_field('banner_disclosure'); ?></span>
                    </div>
                    <div class="banner_image">
                        <img src="<?php the_field('banner_desktop_image'); ?>" alt="banner_desktop_image" class="banner_desktop_image" />
                        <img src="<?php the_field('banner_mobile_image'); ?>" alt="banner_mobile_image" class="banner_mobile_image" />
                        <span class="banner_mobile_image"><?php the_field('banner_disclosure'); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="services_section">
            <div class="container">
                <div class="services_wrapper">
                    <h2 class="section_title"><?php the_field('services_title'); ?></h2>
                    <p><?php the_field('services_description'); ?></p>
                    <?php if (have_rows('services_list')) : ?>
                        <div class="services_list">
                            <?php while (have_rows('services_list')): the_row(); ?>
                                <div class="service_item">
                                    <img src="<?php the_sub_field('service_item_icon'); ?>" alt="service_icon" />
                                    <p><?php the_sub_field('service_item_text'); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="portfolio_section">
            <div class="container">
                <div class="portfolio_wrapper">
                    <h2 class="section_title"><?php the_field('first_vests_title'); ?></h2>
                    <p><?php the_field('first_vests_description'); ?></p>
                    <div class="vests_list core_vests_list">
                        <?php
                            // Define the allowed vest IDs
                            $allowed_vest_ids = [
                                '7d3d7ec1-27b3-4e21-9d56-6b8df7a62622',
                                '8f35449c-6497-4f90-8569-4408bf388386',
                                '5299078d-6895-4266-87f8-d407802fa719'
                            ];

                            if ($vests && is_array($vests)) {
                                // Filter vests to only include the allowed IDs, preserving order
                                $filtered_vests = array_filter($vests, function($vest) use ($allowed_vest_ids) {
                                    return in_array($vest['vestId'], $allowed_vest_ids);
                                });

                                // Sort filtered vests to match the order of $allowed_vest_ids
                                usort($filtered_vests, function($a, $b) use ($allowed_vest_ids) {
                                    return array_search($a['vestId'], $allowed_vest_ids) - array_search($b['vestId'], $allowed_vest_ids);
                                });

                                if (count($filtered_vests) > 0) {
                                    foreach ($filtered_vests as $vest) {
                                        $riskText = 'Aggressive';
                                        if ($vest['risk'] >= 0 && $vest['risk'] <= 2) $riskText = 'Conservative';
                                        elseif ($vest['risk'] == 3) $riskText = 'Moderate';
                                        ?>
                                        <a href="https://app.vestedfinance.com/vest-details?vestId=<?php echo htmlspecialchars($vest['vestId']); ?>" target="_blank" class="vest_item">
                                            <div class="vest_img">
                                                <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/<?php echo htmlspecialchars($vest['vestId']); ?>.svg" alt="solid-foundations" />
                                            </div>
                                            <div class="vest_name">
                                                <?php echo htmlspecialchars($vest['name']); ?>
                                            </div>
                                            <p><?php echo htmlspecialchars($vest['shortBlurb'] ?? $vest['blurb']); ?></p>
                                            <div class="vest_return">
                                                <span>1Y Return</span>
                                                <?php echo htmlspecialchars($vest['oneYearReturn']); ?>
                                            </div>
                                            <div class="vest_metrics">
                                                <div class="vest_metric vest_metric_half">
                                                    <span>Min. Investment</span>
                                                    $10
                                                </div>
                                                <!-- <div class="vest_metric vest_metric_half">
                                                    <span>Dividend Yield</span>
                                                    $100
                                                </div> -->
                                                <div class="vest_metric vest_metric_half">
                                                    <span>Annualized Volatility</span>
                                                    <?php echo htmlspecialchars($vest['oneYearVolatility']); ?>
                                                </div>
                                                <!-- <div class="vest_metric">
                                                    <span>Allocations</span>
                                                    60% Stocks, 40% Bonds
                                                </div> -->
                                            </div>
                                            <div class="vests_footer">
                                                <span><?php echo htmlspecialchars($vest['poweredByText']); ?></span>
                                                <img src="https://d13dxy5z8now6z.cloudfront.net/<?php echo htmlspecialchars($vest['poweredByLogo']); ?>" alt="solid-foundations" />
                                                <span><?php echo htmlspecialchars($vest['poweredBy']); ?></span>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    echo '<p>No vests found.</p>';
                                }
                            } else {
                                echo '<p>No vests found.</p>';
                            }
                        ?>
                    </div>
                    <div class="vests_slider_nav">
                        <div class="core_vests_list_prev">
                            <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.1035 10.0566H1.74131M1.74131 10.0566L10.9639 0.833984M1.74131 10.0566L10.9639 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                        <div class="core_vests_list_next">
                            <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.283203 10.0566H25.6454M25.6454 10.0566L16.4228 0.833984M25.6454 10.0566L16.4228 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="portfolio_section secondary_portfolio_section">
            <div class="container">
                <div class="portfolio_wrapper">
                    <h2 class="section_title"><?php the_field('second_vests_title'); ?></h2>
                    <p><?php the_field('second_vests_description'); ?></p>
                    <div class="vests_list thematic_vests_list">
                        <?php
                            // Define the allowed vest IDs
                            $allowed_vest_ids = [
                                '4b374ef4-3c14-4cc4-9bbe-727215dd1812',
                                'f2038674-50a7-4a1f-a079-9038a266f6ee',
                                '20f7bd6c-9b62-476c-9778-4e555e0e8dc6'
                            ];

                            if ($vests && is_array($vests)) {
                                // Filter vests to only include the allowed IDs, preserving order
                                $filtered_vests = array_filter($vests, function($vest) use ($allowed_vest_ids) {
                                    return in_array($vest['vestId'], $allowed_vest_ids);
                                });

                                // Sort filtered vests to match the order of $allowed_vest_ids
                                usort($filtered_vests, function($a, $b) use ($allowed_vest_ids) {
                                    return array_search($a['vestId'], $allowed_vest_ids) - array_search($b['vestId'], $allowed_vest_ids);
                                });

                                if (count($filtered_vests) > 0) {
                                    foreach ($filtered_vests as $vest) {
                                        $riskText = 'Aggressive';
                                        if ($vest['risk'] >= 0 && $vest['risk'] <= 2) $riskText = 'Conservative';
                                        elseif ($vest['risk'] == 3) $riskText = 'Moderate';
                                        ?>
                                        <a href="https://app.vestedfinance.com/vest-details?vestId=<?php echo htmlspecialchars($vest['vestId']); ?>" target="_blank" class="vest_item">
                                            <div class="vest_img">
                                                <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/<?php echo htmlspecialchars($vest['vestId']); ?>.svg" alt="solid-foundations" />
                                            </div>
                                            <div class="vest_name">
                                                <?php echo htmlspecialchars($vest['name']); ?>
                                            </div>
                                            <p><?php echo htmlspecialchars($vest['shortBlurb'] ?? $vest['blurb']); ?></p>
                                            <div class="vest_return">
                                                <span>1Y Return</span>
                                                <?php echo htmlspecialchars($vest['oneYearReturn']); ?>
                                            </div>
                                            <div class="vest_metrics">
                                                <div class="vest_metric vest_metric_half">
                                                    <span>Min. Investment</span>
                                                    $10
                                                </div>
                                                <!-- <div class="vest_metric vest_metric_half">
                                                    <span>Dividend Yield</span>
                                                    $100
                                                </div> -->
                                                <div class="vest_metric vest_metric_half">
                                                    <span>Annualized Volatility</span>
                                                    <?php echo htmlspecialchars($vest['oneYearVolatility']); ?>
                                                </div>
                                                <!-- <div class="vest_metric">
                                                    <span>Allocations</span>
                                                    60% Stocks, 40% Bonds
                                                </div> -->
                                            </div>
                                            <div class="vests_footer">
                                                <span><?php echo htmlspecialchars($vest['poweredByText']); ?></span>
                                                <img src="https://d13dxy5z8now6z.cloudfront.net/<?php echo htmlspecialchars($vest['poweredByLogo']); ?>" alt="solid-foundations" />
                                                <span><?php echo htmlspecialchars($vest['poweredBy']); ?></span>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    echo '<p>No vests found.</p>';
                                }
                            } else {
                                echo '<p>No vests found.</p>';
                            }
                        ?>
                    </div>
                    <div class="vests_slider_nav">
                        <div class="thematic_vests_list_prev">
                            <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.1035 10.0566H1.74131M1.74131 10.0566L10.9639 0.833984M1.74131 10.0566L10.9639 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                        <div class="thematic_vests_list_next">
                            <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.283203 10.0566H25.6454M25.6454 10.0566L16.4228 0.833984M25.6454 10.0566L16.4228 19.2792" stroke="#002852" stroke-opacity="0.6" stroke-width="1.7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="vests_disclosure"><?php the_field('vests_disclosure'); ?></div>
            </div>
        </section>

        <section class="cta_section">
            <div class="container">
                <div class="cta_wrapper">
                    <h2 class="section_title"><?php the_field('cta_title'); ?></h2>
                    <?php if (have_rows('cta_button')) : ?>
                        <?php while (have_rows('cta_button')): the_row(); ?>
                            <a href="<?php the_sub_field('cta_button_link'); ?>">
                                <?php the_sub_field('cta_button_text'); ?>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="calculator_section">
            <div class="container">
                <div class="calculator_wrapper">
                    <div class="calculator_content">
                        <h2 class="section_title"><?php the_field('calculator_title'); ?></h2>
                        <?php the_field('calculator_description'); ?>
                    </div>
                    <div class="calculator_box">
                        <?php get_template_part('template-parts/risk-appetite-calculator'); ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="metrics_section">
            <div class="container">
                <div class="metrics_wrapper">
                    <div class="metrics_content">
                        <h2 class="section_title"><?php the_field('metrics_title'); ?></h2>
                    </div>
                    <div class="metrics_list">
                        <?php if (have_rows('metrics_list')) : ?>
                            <?php while (have_rows('metrics_list')): the_row(); ?>
                                <div class="metric_item">
                                    <strong><?php the_sub_field('metric_value'); ?></strong>
                                    <span><?php the_sub_field('metric_label'); ?></span>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials_section">
            <div class="container">
                <h2 class="section_title">Here's what our customers have to say</h2>
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
                <p class="testimonial_disclosure">Disclosure: These customers were not paid for their testimonials and may not be representative of the experience of other customers. These testimonials are no guarantee of future performance or success.</p>
            </div>
        </section>

        <section class="partners_section">
            <div class="container">
                <div class="partners_wrapper">
                    <h2 class="section_title"><?php the_field('partners_title'); ?></h2>
                    <p><?php the_field('partners_description'); ?></p>
                    <div class="partners_list">
                        <?php if (have_rows('partners_list')) : ?>
                            <?php while (have_rows('partners_list')): the_row(); ?>
                                <div class="partner_item">
                                    <img src="<?php the_sub_field('partner_image'); ?>" alt="partner_name" />
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
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
