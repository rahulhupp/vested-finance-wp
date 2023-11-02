<?php
/*
Template name: Page - INR Bonds
*/
get_header(); ?>
<div id="content" role="main" class="inr-bonds-page">
    <section class="bonds_banner">
        <div class="container">
            <div class="bonds_banner_wrap">
                <div class="bonds_banner_content">
                    <div class="sub_heading">
                        <div class="sub_heading_icon">
                            <img src="<?php the_field('banner_sub_heading_icon'); ?>" alt="banner icon">
                        </div>
                        <h3><?php the_field('banner_sub_heading'); ?></h3>
                    </div>
                    <h1><?php the_field('banner_heading'); ?></h1>
                    <?php if (have_rows('banner_bonds_list')) : ?>
                        <ul class="banner_list">
                            <?php while (have_rows('banner_bonds_list')) : the_row(); ?>
                                <li><?php the_sub_field('banner_single_bond_list') ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="banner_buttons">
                        <div class="btn">
                            <a href="<?php the_field('banner_button_one_url'); ?>" class="btn_dark"><?php the_field('banner_button_one_text'); ?></a>
                        </div>
                        <div class="btn">
                            <a href="<?php the_field('banner_button_two_url'); ?>" class="btn_link"><?php the_field('banner_button_two_text'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="bonds_banner_img">
                    <img src="<?php the_field('banner_banner_image'); ?>" alt="banner image">
                </div>
            </div>
        </div>
    </section>
    <section class="explore_bonds">
        <div class="container">
            <div class="explore_bonds_wrap">
                <div class="explore_bonds_img mobile_hide">
                    <img src="<?php the_field('explore_bonds_image'); ?>" alt="<?php the_field('explore_bonds_heading'); ?>">
                </div>
                <div class="explore_bonds_content">
                    <h2 class="section_title align_left mobile_hide"><span><?php the_field('explore_bonds_heading'); ?></span></h2>
                    <h2 class="section_title align_left desktop_hide"><span><?php the_field('explore_bonds_heading_mobile'); ?></span></h2>
                    <img src="<?php the_field('explore_bonds_image'); ?>" alt="<?php the_field('explore_bonds_heading'); ?>" class="desktop_hide">
                    <?php if (have_rows('explore_corporate_bonds_list')) : ?>
                        <div class="explore_bonds_list mobile_hide">
                            <?php while (have_rows('explore_corporate_bonds_list')) : the_row(); ?>
                                <div class="single_bond_list">
                                    <div class="single_bond_icon">
                                        <img src="<?php the_sub_field('corporate_bonds_list_icon') ?>" alt="<?php the_sub_field('corporate_bonds_list_text') ?>">
                                    </div>
                                    <p><?php the_sub_field('corporate_bonds_list_text') ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    <?php endif; ?>
                    <?php if (have_rows('explore_corporate_bonds_list_mobile')) : ?>
                        <div class="explore_bonds_list desktop_hide">
                            <?php while (have_rows('explore_corporate_bonds_list_mobile')) : the_row(); ?>
                                <div class="single_bond_list">
                                    <div class="single_bond_icon">
                                        <img src="<?php the_sub_field('corporate_bonds_list_icon_mobile') ?>" alt="<?php the_sub_field('corporate_bonds_list_text_mobile') ?>">
                                    </div>
                                    <p><?php the_sub_field('corporate_bonds_list_text_mobile') ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <div class="explore_bonds_buttons">
                        <a href="<?php the_field('explore_bonds_button_one_url'); ?>" class="btn_dark"><?php the_field('explore_bonds_button_one_text'); ?></a>
                        <a href="<?php the_field('explore_bonds_button_two_url'); ?>" class="btn_link"><?php the_field('explore_bonds_button_two_text'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="gold_bonds">
        <div class="container">
            <div class="gold_bond_wrap">
                <div class="gold_bond_img mobile_hide">
                    <img src="<?php the_field('gold_bond_image'); ?>" alt="<?php the_field('gold_bond_heading'); ?>">
                </div>
                <div class="gold_bond_content">
                    <h2 class="section_title align_left light"><span><?php the_field('gold_bond_heading'); ?></span></h2>
                    <img src="<?php the_field('gold_bond_image'); ?>" alt="<?php the_field('gold_bond_heading'); ?>" class="desktop_hide">
                    <?php if (have_rows('gold_bond_list')) : ?>
                        <div class="gold_bond_list">
                            <?php while (have_rows('gold_bond_list')) : the_row(); ?>
                                <div class="single_gold_bond_list">
                                    <div class="gold_bond_icon">
                                        <img src="<?php the_sub_field('gold_bond_list_icon') ?>" alt="<?php the_sub_field('gold_bond_list_text') ?>">
                                    </div>
                                    <p><?php the_sub_field('gold_bond_list_text') ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <div class="gold_bond_buttons">
                        <a href="<?php the_field('gold_bond_button_one_url'); ?>" class="btn_light"><?php the_field('gold_bond_button_one_text'); ?></a>
                        <a href="<?php the_field('gold_bond_button_two_url'); ?>" class="btn_link light"><?php the_field('gold_bond_button_two_text'); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php if (have_rows('portfolio_list')) : ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title"><span><?php the_field('diversify_heading'); ?></span></h2>
                <div class="portfolio_slider_wrap">
                    <div class="tab-menu">
                        <ul>
                            <li><a href="javascript:void(0)" class="tab-a active-a" data-id="tabcorporate">Corporate Bonds</a></li>
                            <li><a href="javascript:void(0)" class="tab-a" data-id="tabgovt">Gsecs</a></li>
                        </ul>
                    </div><!--end of tab-menu-->
                    <div class="tab tab-active" data-id="tabcorporate" id="tabcorporate">
                        <a href="#" class="btn_link">What are corporate bonds?</a>
                        <div class="bond_slider_wrap">
                            <div class="bond_portfolio_slider">
                                <?php
                                    // Replace this with the actual API endpoint URL
                                    $api_url = "https://yield-api-test.vestedfinance.com/bonds";

                                    // Fetch data from the API
                                    $response = wp_remote_get($api_url);

                                    if (is_array($response) && !is_wp_error($response)) {
                                        $data = json_decode(wp_remote_retrieve_body($response), true);
                                        // Check if data.bonds is an array
                                        if (isset($data['bonds']) && is_array($data['bonds'])) {
                                            foreach ($data['bonds'] as $bond) {
                                                if ($bond['bondCategory'] == "CORPORATE") {
                                                    ?>
                                                    <div class="single_portfolio_slide">
                                                        <div class="slide_icon_wrap">
                                                            <div class="slide_cion">
                                                                <img src="<?php echo esc_url($bond['logo']); ?>" />
                                                            </div>
                                                            <div class="slide_certi">
                                                                <img src="http://vested-wordpress-media-staging.s3.amazonaws.com/vestedfinance/wp-content/uploads/2023/09/21054133/certificate.png" alt="Certificate">
                                                            </div>
                                                        </div>
                                                        <div class="slide_info">
                                                            <h4><?php echo esc_html($bond['name']); ?></h4>
                                                            <p><?php echo esc_html($bond['issuerName']); ?></p>
                                                        </div>
                                                        <div class="slide_investment_info">

                                                            <div class="single_slide_info">
                                                                <p class="info_title">Min investment</p>
                                                                <p class="info_desc">₹ <?php echo esc_html($bond['minimumInvestment']); ?></p>
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Yield</p>
                                                                <p class="info_desc"><?php echo esc_html($bond['yield']); ?> %</p>
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Matures in</p>
                                                                <p class="info_desc">
                                                                    <?php 
                                                                        $result = monthsToYearsAndMonths($bond['maturityInMonths']);
                                                                        echo $result;
                                                                    ?>
                                                                </p>
                                                                <!-- 3 years 10 months  -->
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Payment Frequency</p>
                                                                <p class="info_desc"><?php echo esc_html($bond['interestPayFreq']); ?></p>
                                                            </div>

                                                        </div>

                                                        <div class="slider_button">
                                                            <a href="#" class="btn_dark" tabindex="0">Explore Now <i class="fa fa-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            echo "No bond data available.";
                                        }
                                    } else {
                                        echo "Error fetching data from the API.";
                                    }
                                ?>
                            </div>
                            <!-- <div class="bond_portfolio_slider_nav">
                                <div class="bond_prev">
                                    <i class="fa fa-caret-left"></i>
                                </div>
                                <div class="bond_next">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    
                    <div class="tab" data-id="tabgovt" id="tabgovt">
                        <a href="#" class="btn_link">What are gsecs?</a>
                        <div class="bond_slider_wrap">
                            <div class="bond_portfolio_slider">
                                <?php
                                    // Replace this with the actual API endpoint URL
                                    $api_url = "https://yield-api-test.vestedfinance.com/bonds";

                                    // Fetch data from the API
                                    $response = wp_remote_get($api_url);

                                    if (is_array($response) && !is_wp_error($response)) {
                                        $data = json_decode(wp_remote_retrieve_body($response), true);
                                        // Check if data.bonds is an array
                                        if (isset($data['bonds']) && is_array($data['bonds'])) {
                                            foreach ($data['bonds'] as $bond) {
                                                if ($bond['bondCategory'] == "GOVT") {
                                                    ?>
                                                    <div class="single_portfolio_slide">
                                                        <div class="slide_icon_wrap">
                                                            <div class="slide_cion">
                                                                <img src="<?php echo esc_url($bond['logo']); ?>" />
                                                            </div>
                                                            <div class="slide_certi">
                                                                <img src="http://vested-wordpress-media-staging.s3.amazonaws.com/vestedfinance/wp-content/uploads/2023/09/21054133/certificate.png" alt="Certificate">
                                                            </div>
                                                        </div>
                                                        <div class="slide_info">
                                                            <h4><?php echo esc_html($bond['name']); ?></h4>
                                                            <p><?php echo esc_html($bond['issuerName']); ?></p>
                                                        </div>
                                                        <div class="slide_investment_info">

                                                            <div class="single_slide_info">
                                                                <p class="info_title">Min investment</p>
                                                                <p class="info_desc">₹ <?php echo esc_html($bond['minimumInvestment']); ?></p>
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Yield</p>
                                                                <p class="info_desc"><?php echo esc_html($bond['yield']); ?> %</p>
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Matures in</p>
                                                                <p class="info_desc">
                                                                    <?php 
                                                                        $result = monthsToYearsAndMonths($bond['maturityInMonths']);
                                                                        echo $result;
                                                                    ?>
                                                                </p>
                                                                <!-- 3 years 10 months  -->
                                                            </div>
                                                            <div class="single_slide_info">
                                                                <p class="info_title">Payment Frequency</p>
                                                                <p class="info_desc"><?php echo esc_html($bond['interestPayFreq']); ?></p>
                                                            </div>

                                                        </div>

                                                        <div class="slider_button">
                                                            <a href="#" class="btn_dark" tabindex="0">Explore Now <i class="fa fa-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            echo "No bond data available.";
                                        }
                                    } else {
                                        echo "Error fetching data from the API.";
                                    }
                                ?>
                            </div>
                            <!-- <div class="bond_portfolio_slider_nav">
                                <div class="bond_prev">
                                    <i class="fa fa-caret-left"></i>
                                </div>
                                <div class="bond_next">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                            </div> -->
                        </div>
                    </div>


                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="returns_calc">
        <div class="container">
            <div class="returns-cal_wrap">
                <h2 class="section_title align_left mobile_hide"><span>Your potential returns compared to a FD</span></h2>
                <h2 class="section_title align_left desktop_hide"><span>Your returns compared to a Fixed Deposit</span></h2>

                <div class="return_calc_wrap">
                    <?php
                        // Replace this with the actual API endpoint URL
                        $api_url = "https://yield-api-test.vestedfinance.com/bonds";
                        // Fetch data from the API
                        $response = wp_remote_get($api_url);
                    ?>                

                    <div class="bond_select_col">
                        <div class="field_group">
                            <label for="bond">Select a bond</label>
                            <select name="bond" id="bond_selector">
                                <option value='' selected disabled>Please Select</option>
                            </select>
                            <div class="yield">
                                <label>Yield</label>
                                <span id="yield_price">7.28</span>
                            </div>
                        </div>
                        <div class="field_group number_units blur">
                            <div class="unit_field">
                                <p class="mobile_hide">Number of units</p>
                                <p class="desktop_hide">Select number of units</p>
                                <div class="qty_btn" input_value="0">
                                    <div class="plus_qty desktop_hide">+</div>
                                    <input type="text" id="units" value="0" min="0" max="1000" onkeypress='return restrictAlphabets(event)'>
                                    <div class="minus_qty desktop_hide">-</div>
                                </div>
                            </div>
                            <div class="range mobile_hide">
                                <input type="range" min="0" max="1000" id="unit_range" value="1">
                                <div class="ticks">
                                    <span class="tick"></span><span class="tick"></span><span class="tick"></span><span class="tick"></span><span class="tick"></span><span class="tick"></span><span class="tick"></span><span class="tick"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bond_result_col blur">

                        <div class="bond_result_wrap">
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Investment amount</p>
                                    <h3 id="bond_invest_amt">₹ <div newPrice="0" id="investment_amount">0.00</div></h3>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="invest_amt_progress"></div>
                                </div>
                            </div>
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Bank Fixed Deposit</p>
                                    <h3 id="bond_invest_amt">₹ <div maturity_months="0" id="bank_fixed_deposit">0.00</div></h3>
                                    <span id="fd_bond_return">(6% Returns)</span>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="invest_amt_progress"></div>
                                </div>
                            </div>
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Selected Bonds</p>
                                    <h3 id="bond_invest_amt">₹ <div sum_cash_flow="0" id="selected_bond">0.00</div></h3>
                                    <span id="fd_bond_return">(<span id="yield_returns">12</span>% Returns)</span>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="invest_amt_progress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="result_note">
                            <h3>₹<div id="result_note_investment_amount">0.00</div> invested would earn you <span>₹<div id="extra_amount">0.00</div> extra</span> in <div id="maturity_in_months">5 years<div></h3>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="vested_edge_list">
        <div class="container">
            <div class="edge_list_row">
                <h2 class="section_title light"><?php the_field('edge_heading'); ?></h2>
                <div class="edge_list_content">
                    <div class="edge_list_wrap">
                        <?php while (have_rows('edge_list')) : the_row(); ?>
                            <div class="single_edge_list">
                                <div class="edge_list_icon">
                                    <img src="<?php the_sub_field('edge_list_icon') ?>" alt="Edge List">
                                </div>
                                <p class="edge_content mobile_hide">
                                    <?php the_sub_field('edge_list_description') ?>
                                </p>
                                <p class="edge_content desktop_hide">
                                    <?php the_sub_field('edge_list_description_mobile') ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php if (have_rows('portfolio_slider')) : ?>
        <section class="portfolio_slider_sec steps_slides">
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
    <section class="invest_wisely_sec">
        <div class="container">
            <h2 class="section_title"><span><?php the_field('invest_wisely_heading'); ?></span></h2>
            <?php if (have_rows('learning_list')) : ?>
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
            <?php endif; ?>
        </div>
        <div class="invest_module_sec">
            <div class="container">
                <?php
                // Get the current term
                $term = 'us-equities';

                // Create a custom query to retrieve posts from the "module" post type with the current term
                $args = array(
                    'post_type' => 'module',
                    'posts_per_page' => 3,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'modules_category',
                            'field'    => 'slug', // Use 'slug' or 'id' depending on your preference
                            'terms'    => $term, // Use $term->term_id if you have the ID instead of slug
                        ),
                    ),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) : ?>
                    <div class="invest_wisely_wrap module_chapter_list">
                        <?php while ($query->have_posts()) :
                            $query->the_post();
                            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $author_image_url = get_avatar_url(get_the_author_meta('user_email'));
                            $reading_time = calculate_reading_time(get_the_content());
                            $post_date = get_the_date();
                        ?>
                            <div class="single_module_list">
                                <div class="single_module_img">
                                    <img src="<?php echo $featured_image_url; ?>" alt="">
                                </div>
                                <div class="single_module_content">
                                    <div class="module_date">
                                        <span><?php echo $post_date; ?></span>
                                    </div>
                                    <h4><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="author_info">
                                        <div class="reading_time">
                                            <h5><?php echo $reading_time; ?> mins read</h5>
                                        </div>
                                        <div class="author_meta">
                                            <div class="author_img">
                                                <img src="<?php echo $author_image_url; ?>" alt="Author">
                                            </div>
                                            <p class="author_name"><?php the_author(); ?></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); // Reset the post data 
                        ?>
                    </div>
                <?php else :
                    echo 'No posts found.';
                endif;
                ?>
            </div>
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
<script>
    

    document.addEventListener("DOMContentLoaded", function () {
    // The URL of the API you want to call
    const apiUrl = "https://yield-api-test.vestedfinance.com/bonds"; // Replace with your API endpoint
    // Select the <select> element
    const apiDataDropdown = document.getElementById("bond_selector");
    // Make an API request using the Fetch API
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Parse the response as JSON
        })
        .then(data => {
            // Populate the dropdown with data
            data.bonds.forEach(item => {
                const option = document.createElement("option");
                option.value = item.name; // Set the value for the option
                option.text = item.name; // Set the text to display in the dropdown
                option.setAttribute("id", item.offeringId);
                apiDataDropdown.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            apiDataDropdown.innerHTML = "<option value='' selected>Failed to fetch data</option>";
        });

        const bondSelector = document.getElementById('bond_selector');
        bondSelector.addEventListener('change', () => {
            const selectedOptionId = bondSelector.options[bondSelector.selectedIndex].id;
            const apiOfferingId = `https://yield-api-test.vestedfinance.com/bond-details?offeringId=${selectedOptionId}`;
            
            fetch(apiOfferingId)
            .then(response => {
                // Check if the response status is in the 200-299 range (indicating success)
                if (response.ok) {
                // Parse the response JSON data
                return response.json();
                } else {
                throw new Error(`HTTP Error: ${response.status}`);
                }
            })
            .then(data => {
                // Do something with the data received from the API
                let sumCashFlow = 0;

                data.bondDetails.cashflows.forEach(item => {
                    sumCashFlow = sumCashFlow + item.amount;
                });

                console.log ('data', data);

                const fristCashFlowPrice = data.bondDetails.cashflows[0].amount;
                const faceValue = data.bondDetails.faceValue;
                const newPrice = data.bondDetails.newPrice;
                const totalreturns = parseFloat(fristCashFlowPrice + (faceValue - newPrice)).toLocaleString();
                const minimumQuantity = data.bondDetails.minimumQty;
                const yieldPrice = data.bondDetails.yield;
                const investmentAmount = minimumQuantity * data.bondDetails.newPrice;
                const periodInYears = data.bondDetails.maturityInMonths/12;
                const bankFixedDeposit = investmentAmount * Math.pow(1.06, periodInYears);
                const selectedBonds = sumCashFlow * minimumQuantity;
                const extraAmount = selectedBonds - bankFixedDeposit;
                const periodInYearMonths = data.bondDetails.maturityInMonths;
                const years = Math.floor(periodInYearMonths / 12);
                const months = periodInYearMonths % 12;

                // const bankFixedDeposit (Math.pow(initialPortfolioPrice, Periods) -1) * 100;
                
                document.getElementById('units').value = minimumQuantity;
                document.getElementById('unit_range').value = minimumQuantity;
                document.getElementById('yield_price').textContent = yieldPrice.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('bank_fixed_deposit').textContent = bankFixedDeposit.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('selected_bond').textContent = selectedBonds.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('yield_returns').textContent = yieldPrice.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('investment_amount').textContent = investmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('result_note_investment_amount').textContent = investmentAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                document.getElementById('extra_amount').textContent = extraAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });

                document.querySelector('.qty_btn').setAttribute("input_value", minimumQuantity);
                document.getElementById('investment_amount').setAttribute("newPrice", newPrice);
                document.getElementById('bank_fixed_deposit').setAttribute("maturity_months", periodInYears);
                document.getElementById('selected_bond').setAttribute("sum_cash_flow", sumCashFlow);
                document.querySelector('.return_calc_wrap .yield').classList.add('show');
                document.querySelector('.bond_result_col').classList.remove('blur');
                document.querySelector('.number_units').classList.remove('blur');

                if (months <= 0) {
                    document.getElementById('maturity_in_months').textContent = years + ' Years ';
                }
                else {
                    document.getElementById('maturity_in_months').textContent = years + ' years ' + months + ' months ' ;
                }

                var slider = document.getElementById("unit_range");
                var color = "linear-gradient(90deg, rgba(0, 40, 52, 1)" + minimumQuantity + "%, rgba(229, 231, 235, 1)" + minimumQuantity + "%)";
                slider.style.background = color;
                
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error(`Error: ${error.message}`);
            });
        });
});
</script>
<?php get_footer(); ?>