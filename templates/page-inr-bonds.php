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
                            <?php
                            $image = get_field('banner_sub_heading_icon');
                            if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php endif; ?>
                        </div>
                        <h3>
                            <?php the_field('banner_sub_heading'); ?>
                        </h3>
                    </div>
                    <h1>
                        <?php the_field('banner_heading'); ?>
                    </h1>
                    <?php if (have_rows('banner_bonds_list')): ?>
                        <ul class="banner_list">
                            <?php while (have_rows('banner_bonds_list')):
                                the_row(); ?>
                                <li>
                                    <?php the_sub_field('banner_single_bond_list') ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="banner_buttons">
                        <div class="btn">
                            <a href="<?php the_field('banner_button_one_url'); ?>" class="btn_dark" target="_blank">
                                <?php the_field('banner_button_one_text'); ?>
                            </a>
                        </div>
                        <?php $button_text = get_field('banner_button_two_text'); ?>
                        <?php
                        if (!empty($button_text)) {
                            ?>
                            <div class="btn">
                                <a href="<?php the_field('banner_button_two_url'); ?>" class="btn_link">
                                    <?php the_field('banner_button_two_text'); ?>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="bonds_banner_img">
                    <?php
                    $image = get_field('banner_banner_image');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="explore_bonds">
        <div class="container">
            <div class="explore_bonds_wrap">
                <div class="explore_bonds_img mobile_hide">
                    <?php
                    $image = get_field('explore_bonds_image');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    <?php endif; ?>
                </div>
                <div class="explore_bonds_content">
                    <h2 class="section_title align_left mobile_hide"><span>
                            <?php the_field('explore_bonds_heading'); ?>
                        </span></h2>
                    <h2 class="section_title align_left desktop_hide"><span>
                            <?php the_field('explore_bonds_heading_mobile'); ?>
                        </span></h2>
                    <?php
                    $image = get_field('explore_bonds_image');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                            class="desktop_hide" />
                    <?php endif; ?>
                    <?php if (have_rows('explore_corporate_bonds_list')): ?>
                        <div class="explore_bonds_list mobile_hide">
                            <?php while (have_rows('explore_corporate_bonds_list')):
                                the_row(); ?>
                                <div class="single_bond_list">
                                    <div class="single_bond_icon">
                                        <?php
                                        $image = get_sub_field('corporate_bonds_list_icon');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <?php the_sub_field('corporate_bonds_list_text') ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    <?php endif; ?>
                    <?php if (have_rows('explore_corporate_bonds_list_mobile')): ?>
                        <div class="explore_bonds_list desktop_hide">
                            <?php while (have_rows('explore_corporate_bonds_list_mobile')):
                                the_row(); ?>
                                <div class="single_bond_list">
                                    <div class="single_bond_icon">
                                        <?php
                                        $image = get_sub_field('corporate_bonds_list_icon_mobile');
                                        if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <?php the_sub_field('corporate_bonds_list_text_mobile') ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <div class="explore_bonds_buttons">
                        <a href="<?php the_field('explore_bonds_button_one_url'); ?>" class="btn_dark" target="_blank">
                            <?php the_field('explore_bonds_button_one_text'); ?>
                        </a>
                        <?php $button_text = get_field('explore_bonds_button_two_text'); ?>
                        <?php
                        if (!empty($button_text)) {
                            ?>
                            <a href="<?php the_field('explore_bonds_button_two_url'); ?>" class="btn_link">
                                <?php the_field('explore_bonds_button_two_text'); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php /*
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
*/ ?>
    <?php
    if (have_rows('portfolio_list')): ?>
        <section class="portfolio_slider_sec">
            <div class="container">
                <h2 class="section_title"><span>
                        <?php the_field('diversify_heading'); ?>
                    </span></h2>
                <div class="portfolio_slider_wrap">
                    <div class="tab-menu">
                        <ul>
                            <li><a href="javascript:void(0)" class="tab-a active-a" data-id="tabcorporate">Corporate
                                    Bonds</a></li>
                            <!-- <li><a href="javascript:void(0)" class="tab-a" data-id="tabsgbs">SGBs</a></li> -->
                            <li><a href="javascript:void(0)" class="tab-a" data-id="tabgovt">Govt Bonds</a></li>
                        </ul>
                    </div>
                    <!--end of tab-menu-->
                    <div class="tab tab-active" data-id="tabcorporate" id="tabcorporate">
                        <!-- <a href="#" class="btn_link">What are corporate bonds?</a> -->

                        <div class="bond_slider_wrap" id="corporateBondSlider">
                            <div class="sub_title">
                                <a href="#">
                                    What are corporate bonds?
                                </a>
                            </div>
                            <!-- Placeholder for corporate bond data -->
                        </div>
                    </div>

                    <!-- <div class="tab" data-id="tabsgbs" id="tabsgbs">
                    <div class="sub_title">
                        <a href="#" class="p-lg">
                        What are SGBs bonds?
                    </a>
                    </div>
                       <h2 class="alert_danger">There are no SGBs bonds available.</h2>
                    </div> -->

                    <div class="tab" data-id="tabgovt" id="tabgovt">
                        <!-- <a href="#" class="btn_link">What are gsecs?</a> -->
                        <div class="sub_title">
                            <a href="#" class="p-lg">
                                What are Govt Bonds?
                            </a>
                        </div>
                        <div class="bond_slider_wrap" id="govtBondSlider">
                            <!-- Placeholder for government bond data -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="returns_calc">
        <div class="container">
            <div class="returns-cal_wrap">
                <h2 class="section_title align_left mobile_hide"><span>Your potential returns compared to a FD</span>
                </h2>
                <h2 class="section_title align_left desktop_hide"><span>Your returns compared to a Fixed Deposit</span>
                </h2>

                <div class="return_calc_wrap">
                    <div class="bond_select_col">
                        <div class="field_group">
                            <label for="bond">Select a bond</label>
                            <select name="bond" id="bond_selector">
                                <!-- <option value='' selected disabled>Please Select</option> -->
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
                                    <input type="text" id="units" value="0" min="0" max="1000"
                                        onkeypress='return restrictAlphabets(event)'>
                                    <div class="minus_qty desktop_hide">-</div>
                                </div>
                            </div>
                            <div class="range mobile_hide">
                                <input type="range" min="0" max="1000" id="unit_range" value="1">
                                <div class="ticks">
                                    <span class="tick"></span><span class="tick"></span><span class="tick"></span><span
                                        class="tick"></span><span class="tick"></span><span class="tick"></span><span
                                        class="tick"></span><span class="tick"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bond_result_col blur">

                        <div class="bond_result_wrap">
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Investment amount</p>
                                    <h3 id="bond_invest_amt">₹ <div newPrice="0" id="investment_amount">0.00</div>
                                    </h3>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="invest_amt_progress"></div>
                                </div>
                            </div>
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Bank Fixed Deposit</p>
                                    <div class="return_flex">
                                        <h3 id="bond_invest_amt">₹ <div maturity_months="0" id="bank_fixed_deposit">0.00
                                            </div>
                                        </h3>
                                        <span id="fd_bond_return">(6% Returns)</span>
                                    </div>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="bond_amt_progress"></div>
                                </div>
                            </div>
                            <div class="bond_result_single">
                                <div class="left_part">
                                    <p>Selected Bonds</p>
                                    <div class="return_flex">
                                        <h3 id="bond_invest_amt">₹ <div sum_cash_flow="0" id="selected_bond">0.00</div>
                                        </h3>
                                        <span id="fd_bond_return">(<span id="yield_returns">12</span>% Returns)</span>
                                    </div>
                                </div>
                                <div class="progressed">
                                    <div class="bong_progress" id="selected_bond_progress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="result_note">
                            <h3>₹ <div id="result_note_investment_amount">0.00</div> invested would earn you <span>₹<div
                                        id="extra_amount">0.00</div> extra</span> in <div id="maturity_in_months">5
                                    years<div>
                            </h3>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
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
    <?php if (have_rows('portfolio_slider')): ?>
        <section class="portfolio_slider_sec steps_slides">
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
    <section class="invest_wisely_sec">
        <div class="container">
            <h2 class="section_title"><span>
                    <?php the_field('invest_wisely_heading'); ?>
                </span></h2>
            <?php if (have_rows('learning_list')): ?>
                <div class="invest_wisely_wrap">
                    <?php while (have_rows('learning_list')):
                        the_row(); ?>
                        <div class="single_wisely_list">
                            <div class="single_wisely_img">
                                <img src="<?php the_sub_field('learning_image') ?>"
                                    alt="<?php the_sub_field('learning_title') ?>">
                            </div>
                            <div class="single_wisely_content">
                                <h3>
                                    <?php the_sub_field('learning_title') ?>
                                </h3>
                                <p>
                                    <?php the_sub_field('learning_description') ?>
                                </p>
                                <a href="<?php the_sub_field('learning_cta_url') ?>" class="btn_dark">
                                    <?php the_sub_field('learning_cta_text') ?>
                                </a>
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
                            'field' => 'slug', // Use 'slug' or 'id' depending on your preference
                            'terms' => $term, // Use $term->term_id if you have the ID instead of slug
                        ),
                    ),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()): ?>
                    <div class="invest_wisely_wrap module_chapter_list">
                        <?php while ($query->have_posts()):
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
                                        <span>
                                            <?php echo $post_date; ?>
                                        </span>
                                    </div>
                                    <h4><a href="<?php echo the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a></h4>
                                    <div class="author_info">
                                        <div class="reading_time">
                                            <h5>
                                                <?php echo $reading_time; ?> mins read
                                            </h5>
                                        </div>
                                        <div class="author_meta">
                                            <div class="author_img">
                                                <img src="<?php echo $author_image_url; ?>" alt="Author">
                                            </div>
                                            <p class="author_name">
                                                <?php the_author(); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); // Reset the post data 
                        ?>
                    </div>
                <?php else: ?>
                    <p class="no_post_msg">No Post Found !!!</p>
                <?php endif;
                ?>
            </div>
        </div>
    </section>
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
        const corporateApiUrl = "https://yield-api-test.vestedfinance.com/bonds";
        const corporateContainerId = "corporateBondSlider";
        const govtContainerId = "govtBondSlider";
        const apiDataDropdown = document.getElementById("bond_selector");
        // Make an API request using the Fetch API
        fetch(corporateApiUrl, {
            headers: {
                'User-Agent': 'Vested_M#8Dfz$B-8W6'
            }
        })
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
                    option.setAttribute("minValue", item.minimumQty);
                    apiDataDropdown.appendChild(option);
                });
                // on load select first option and trigger it
                var selectElement = document.getElementById("bond_selector");
                if (selectElement && selectElement.options.length > 0) {
                    selectElement.options[0].selected = true;
                    var event = new Event('change');
                    selectElement.dispatchEvent(event);
                }
                // on load select first option and trigger it
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                apiDataDropdown.innerHTML = "<option value='' selected>Failed to fetch data</option>";
            });

        const bondSelector = document.getElementById('bond_selector');
        bondSelector.addEventListener('change', () => {
            const selectedOptionId = bondSelector.options[bondSelector.selectedIndex].id;
            const selectedOptionMinVal = bondSelector.options[bondSelector.selectedIndex].getAttribute("minValue");
            const apiOfferingId = `https://yield-api-test.vestedfinance.com/bond-details?offeringId=${selectedOptionId}`;
            fetch(apiOfferingId, {
                headers: {
                    'User-Agent': 'Vested_M#8Dfz$B-8W6'
                }
            })
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
                    document.getElementById('units').min = selectedOptionMinVal;
                    document.getElementById('unit_range').min = selectedOptionMinVal;

                    function handleResult() {
                        if (document.getElementById('units').value < 0 || document.getElementById('units').value == '') {
                            document.getElementById('units').value = selectedOptionMinVal;
                            document.getElementById('unit_range').value = selectedOptionMinVal;
                            document.querySelector('.bond_result_col').classList.add('blur');
                            document.querySelector('.number_units').classList.add('blur');
                            document.querySelector('.return_calc_wrap .yield').classList.remove('show');
                        } else {
                            document.querySelector('.bond_result_col').classList.remove('blur');
                            document.querySelector('.number_units').classList.remove('blur');
                            document.querySelector('.return_calc_wrap .yield').classList.add('show');
                        }
                    }

                    function updateMinVal() {
                        if (document.getElementById('units').value < selectedOptionMinVal) {
                            document.getElementById('units').value = selectedOptionMinVal;
                            document.getElementById('unit_range').value = selectedOptionMinVal;
                            document.getElementById('unit_range').min = selectedOptionMinVal
                            document.getElementById('unit_range').style.background = 'linear-gradient(90deg, rgba(0, 40, 52, 1) 0%, rgba(229, 231, 235, 1) 0%)';
                            document.querySelector('.bond_result_col').classList.add('blur');
                            console.log(document.getElementById('unit_range').value);
                        }
                    }

                    document.getElementById('units').addEventListener('change', handleResult);
                    document.getElementById('units').addEventListener('change', updateMinVal);
                    document.getElementById('units').addEventListener('input', handleResult);
                    let sumCashFlow = 0;

                    data.bondDetails.cashflows.forEach(item => {
                        sumCashFlow = sumCashFlow + item.amount;
                    });

                    // console.log('data', data);

                    const fristCashFlowPrice = data.bondDetails.cashflows[0].amount;
                    const faceValue = data.bondDetails.faceValue;
                    const newPrice = data.bondDetails.newPrice;
                    const totalreturns = parseFloat(fristCashFlowPrice + (faceValue - newPrice)).toLocaleString();
                    const minimumQuantity = data.bondDetails.minimumQty;
                    const yieldPrice = data.bondDetails.yield;
                    const investmentAmount = minimumQuantity * data.bondDetails.newPrice;
                    const periodInYears = data.bondDetails.maturityInMonths / 12;
                    const bankFixedDeposit = investmentAmount * Math.pow(1.06, periodInYears);
                    const selectedBonds = sumCashFlow * minimumQuantity;
                    const extraAmount = selectedBonds - bankFixedDeposit;
                    const periodInYearMonths = data.bondDetails.maturityInMonths;
                    const years = Math.floor(periodInYearMonths / 12);
                    const months = periodInYearMonths % 12;
                    const maxValue = 1000;
                    const unitVal = document.getElementById('units');

                    // Round to two decimal places

                  // Assuming investmentAmount is already declared somewhere else in your code



                    // unitVal.setAttribute("min", data.bondDetails.minimumQty);

                    // const bankFixedDeposit (Math.pow(initialPortfolioPrice, Periods) -1) * 100;
                    document.getElementById('units').value = minimumQuantity;
                    document.getElementById('unit_range').value = minimumQuantity;
                    document.getElementById('yield_price').textContent = Math.round(yieldPrice);
                    document.getElementById('bank_fixed_deposit').textContent = Math.round(bankFixedDeposit);
                    document.getElementById('selected_bond').textContent = Math.round(selectedBonds);
                    document.getElementById('yield_returns').textContent = Math.round(yieldPrice);
                    document.getElementById('investment_amount').textContent = Math.round(investmentAmount);
                    document.getElementById('result_note_investment_amount').textContent = Math.round(investmentAmount);
                    document.getElementById('extra_amount').textContent = Math.round(extraAmount);
                    document.querySelector('.qty_btn').setAttribute("input_value", minimumQuantity);
                    document.getElementById('investment_amount').setAttribute("newPrice", newPrice);
                    document.getElementById('bank_fixed_deposit').setAttribute("maturity_months", periodInYears);
                    document.getElementById('selected_bond').setAttribute("sum_cash_flow", sumCashFlow);
                    document.querySelector('.return_calc_wrap .yield').classList.add('show');
                    document.querySelector('.bond_result_col').classList.remove('blur');
                    document.querySelector('.number_units').classList.remove('blur');

                    const fdAmt = parseFloat(document.getElementById('bank_fixed_deposit').innerText.replace(/,/g, ''));
                    const investedVal = parseFloat(document.getElementById('investment_amount').innerText.replace(/,/g, ''));
                    const selectedBondVal = parseFloat(document.getElementById('selected_bond').innerText.replace(/,/g, ''));
                    const investProgress = document.getElementById('invest_amt_progress');
                    const fdProgress = document.getElementById('bond_amt_progress');
                    const bondProgress = document.getElementById('selected_bond_progress');
                    const maxVal = Math.max(fdAmt, investedVal, selectedBondVal);
                    const fdAmtPercent = (fdAmt / maxVal) * 100;
                    const investedValPercent = (investedVal / maxVal) * 100;
                    const selectedBondValPercent = (selectedBondVal / maxVal) * 100;
                    
                    investProgress.style.width = investedValPercent + '%';
                    fdProgress.style.width = fdAmtPercent + '%';
                    bondProgress.style.width = selectedBondValPercent + '%';

                    if (months <= 0) {
                        document.getElementById('maturity_in_months').textContent = years + ' Years ';
                    } else {
                        document.getElementById('maturity_in_months').textContent = years + ' years ' + months + ' months ';
                    }

                    var slider = document.getElementById("unit_range");
                    var newVal = ((minimumQuantity - 1) / (maxValue - 1)) * 99 + 1;
                    var color = "linear-gradient(90deg, rgba(0, 40, 52, 1) 0%, rgba(229, 231, 235, 1) 0%)";
                    slider.style.background = color;

                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch request
                    console.error(`Error: ${error.message}`);
                });
        });

        /* api call function to get data for bonds tab section */
        function monthsToYearsAndMonth(months) {
            const years = Math.floor(months / 12);
            const remainingMonths = months % 12;

            if (years > 0 && remainingMonths > 0) {
                return `${years} years ${remainingMonths} months`;
            } else if (years > 0) {
                return `${years} years`;
            } else if (remainingMonths > 0) {
                return `${remainingMonths} months`;
            } else {
                return '0 months';
            }
        }

        function createBondElements(bondData) {
            const bondDiv = document.createElement('div');
            bondDiv.className = 'single_portfolio_slide';

            // Create and append elements with bond data
            const slideIconWrap = document.createElement('div');
            slideIconWrap.className = 'slide_icon_wrap';

            const slideCion = document.createElement('div');
            slideCion.className = 'slide_cion';

            const img = document.createElement('img');
            img.src = bondData.logo;
            slideCion.appendChild(img);
            slideIconWrap.appendChild(slideCion);

            const ratingColorCode = bondData.ratingColorCode.split(',');
            const background_color = ratingColorCode[0].trim();
            const text_color = ratingColorCode[1].trim();

            const slideCerti = document.createElement('div');
            slideCerti.className = 'slide_certi';
            // slideCerti.style.backgroundColor = background_color;
            const svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svgElement.setAttribute("width", "70");
            svgElement.setAttribute("height", "70");


            const pathElement = document.createElementNS("http://www.w3.org/2000/svg", "path");
            pathElement.setAttribute("d", "M58.8057 26.7612C57.6787 25.4407 57.3159 23.6266 57.8528 21.9772C58.6122 19.6408 57.5577 17.1013 55.3713 15.984C53.8234 15.1955 52.798 13.6572 52.6625 11.9255C52.469 9.47788 50.5245 7.53333 48.0769 7.33985C46.3452 7.20441 44.807 6.17892 44.0185 4.63101C42.9012 2.4446 40.3617 1.39008 38.0253 2.14952C36.371 2.68646 34.5619 2.32366 33.2414 1.19659C31.3742 -0.399678 28.6219 -0.399678 26.7548 1.19659C25.4342 2.32366 23.6203 2.68646 21.9708 2.14952C19.6393 1.39008 17.095 2.4446 15.9824 4.63101C15.194 6.17892 13.6558 7.20441 11.9241 7.33985C9.47644 7.53333 7.53191 9.47788 7.33842 11.9255C7.20298 13.6572 6.17751 15.1955 4.62962 15.984C2.44323 17.1013 1.38873 19.6408 2.14816 21.9772C2.68509 23.6315 2.3223 25.4407 1.19524 26.7612C-0.401017 28.6284 -0.401017 31.3807 1.19524 33.2478C2.3223 34.5685 2.68509 36.3824 2.14816 38.0319C1.38873 40.3634 2.44323 42.903 4.62962 44.0204C6.17751 44.8088 7.20298 46.347 7.33842 48.0787C7.53191 50.5263 9.47644 52.471 11.9241 52.6645C13.6558 52.7999 15.194 53.8254 15.9824 55.3733C17.0998 57.5597 19.6393 58.6141 21.9757 57.8547C23.63 57.3178 25.439 57.6806 26.7596 58.8076C28.6267 60.4039 31.3791 60.4039 33.2462 58.8076C34.5668 57.6806 36.3807 57.3178 38.0301 57.8547C40.3665 58.6141 42.906 57.5597 44.0234 55.3733C44.8118 53.8254 46.35 52.7999 48.0817 52.6645C50.5293 52.471 52.4739 50.5263 52.6674 48.0787C52.8028 46.347 53.8283 44.8088 55.3762 44.0204C57.5626 42.903 58.6171 40.3634 57.8576 38.027C57.3207 36.3727 57.6835 34.5636 58.8105 33.243C60.3971 31.3759 60.3971 28.6284 58.8057 26.7612ZM30.0005 54.5413C16.4468 54.5413 5.46161 43.556 5.46161 30.0021C5.46161 16.4483 16.4468 5.46301 30.0005 5.46301C43.5542 5.46301 54.5393 16.4483 54.5393 30.0021C54.5393 43.556 43.5542 54.5413 30.0005 54.5413Z");
            pathElement.setAttribute("fill", background_color);

            svgElement.appendChild(pathElement);

            slideCerti.appendChild(svgElement);

            const sliderRating = document.createElement('p');
            sliderRating.className = 'slider_rating';
            sliderRating.style.color = text_color;
            sliderRating.textContent = bondData.rating;

            slideCerti.appendChild(sliderRating);
            slideIconWrap.appendChild(slideCerti);
            bondDiv.appendChild(slideIconWrap);

            const slideInfo = document.createElement('div');
            slideInfo.className = 'slide_info';

            const h4 = document.createElement('h4');
            h4.textContent = bondData.displayName;

            const p = document.createElement('p');
            p.textContent = bondData.issuerName;

            const investVal = document.createElement('p');
            investVal.className = 'info_title';
            investVal.textContent = bondData.minimumInvestment;

            slideInfo.appendChild(h4);
            slideInfo.appendChild(p);
            bondDiv.appendChild(slideInfo);

            const slideInvestmentInfo = document.createElement('div');
            slideInvestmentInfo.className = 'slide_investment_info';

            // Create and append individual investment info elements
            function createInvestmentInfo(title, data) {
                const singleSlideInfo = document.createElement('div');
                singleSlideInfo.className = 'single_slide_info';


                const infoTitle = document.createElement('p');
                infoTitle.className = 'info_title';
                infoTitle.textContent = title;

                const infoDesc = document.createElement('p');
                infoDesc.className = 'info_desc';


                // Function to capitalize the first letter of each word
                function capitalizeEachWord(str) {
                    return str.toLowerCase().replace(/\b\w/g, function (char) {
                        return char.toUpperCase();
                    });
                }
                // Assuming 'data' contains the text you want to capitalize
                infoDesc.textContent = capitalizeEachWord(data);


                singleSlideInfo.appendChild(infoTitle);
                singleSlideInfo.appendChild(infoDesc);
                slideInvestmentInfo.appendChild(singleSlideInfo);
            }

           
            createInvestmentInfo('Min investment', `₹ ${bondData.minimumInvestment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`);
            createInvestmentInfo('Yield', `${bondData.yield.toFixed(2)} %`);
            function monthsToYearsAndMonth(months) {
                const years = Math.floor(months / 12);
                const remainingMonths = months % 12;
                if (years === 0) {
                    return `${remainingMonths}m`;
                } else if (remainingMonths === 0) {
                    return `${years}y`;
                } else {
                    return `${years}y ${remainingMonths}m`;
                }
            }
            const maturityInMonths = bondData.maturityInMonths;
            const convertedMaturity = monthsToYearsAndMonth(maturityInMonths);


            createInvestmentInfo('Matures in', convertedMaturity);

            createInvestmentInfo('Payment Frequency', bondData.interestPayFreq);

            bondDiv.appendChild(slideInvestmentInfo);

            const sliderButton = document.createElement('div');
            sliderButton.className = 'slider_button';

            const exploreLink = document.createElement('a');
            exploreLink.href = '#';
            exploreLink.className = 'btn_dark';
            exploreLink.tabIndex = 0;
            exploreLink.textContent = 'Explore Now';

            const icon = document.createElement('i');
            icon.className = 'fa fa-chevron-right';

            exploreLink.appendChild(icon);
            sliderButton.appendChild(exploreLink);
            bondDiv.appendChild(sliderButton);

            return bondDiv;
        }

        function fetchDataAndDisplay(apiUrl, containerId) {
            fetch(apiUrl, {
                headers: {
                    'User-Agent': 'Vested_M#8Dfz$B-8W6'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const bondContainer = document.getElementById(containerId);

                    const bondsForCategory = data.bonds.filter(bond => {
                        if (containerId === "govtBondSlider") {
                            return bond.bondCategory === "GOVT";
                        } else if (containerId === "corporateBondSlider") {
                            return bond.bondCategory === "CORPORATE";
                        }
                        return false;
                    });

                    if (bondsForCategory.length > 0) {
                        const bondPortfolioSlider = document.createElement('div');
                        bondPortfolioSlider.className = 'bond_portfolio_slider';

                        bondsForCategory.forEach(bond => {
                            const bondDiv = createBondElements(bond);
                            bondPortfolioSlider.appendChild(bondDiv);
                        });

                        bondContainer.appendChild(bondPortfolioSlider);

                        // jQuery(`#${containerId} .bond_portfolio_slider`).slick({
                        //     infinite: false,
                        //     arrows: true,
                        //     dots: false,
                        //     autoplay: false,
                        //     speed: 800,
                        //     slidesToShow: 2,
                        //     slidesToScroll: 1,
                        //     centerMode: false,
                        //     nextArrow: '<div class="bond_next"><i class="fa fa-caret-right"></i></div>',
                        //     prevArrow: '<div class="bond_prev"><i class="fa fa-caret-left"></i></div>',
                        //     responsive: [{
                        //         breakpoint: 768,
                        //         settings: {
                        //             slidesToShow: 1,
                        //             slidesToScroll: 1,
                        //         },
                        //     }],
                        // });

                        const singleSlides = bondContainer.querySelectorAll('.single_portfolio_slide');
                        if (singleSlides.length < 3) {
                            bondPortfolioSlider.classList.add('slide_wo_shadow');
                        } else {
                            bondPortfolioSlider.classList.remove('slide_wo_shadow');
                        }
                    } else {
                        const noDataMessage = document.createElement('p');
                        noDataMessage.className = 'no-data-message';
                        noDataMessage.textContent = 'No bonds available.';
                        bondContainer.appendChild(noDataMessage);

                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }


        fetchDataAndDisplay(corporateApiUrl, corporateContainerId);
        fetchDataAndDisplay(corporateApiUrl, govtContainerId);

    });

document.addEventListener("DOMContentLoaded", function() {
  var images = document.getElementsByClassName("slide_cion");
  // Check if there are images with the class "image"
  if (images.length > 0) {
      for (var i = 0; i < images.length; i++) {
          images[i].onerror = function() {
              // If the image fails to load (i.e., returns 404), replace it with a default image
              this.src = "http://localhost/vested-testing/wp-content/uploads/2024/04/Corporate-Bonds.png";
          };
      }
  }
});
</script>
<?php if (have_rows('faq_list')): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php $rowCount = 0; ?>
            <?php while (have_rows('faq_list')):
                the_row(); ?>
                    {
                        "@type": "Question",
                        "name": "<?php the_sub_field('faq_question') ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "
                                <?php the_sub_field('faq_answer') ?>
                            "
                        }
                    }<?php echo (++$rowCount === count(get_field('faq_list'))) ? '' : ','; ?>
            <?php endwhile; ?>
        ]
    }
    </script>
<?php endif; ?>

<?php get_footer(); ?>