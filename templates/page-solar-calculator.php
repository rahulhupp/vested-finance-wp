<?php
/* 
Template Name: Page - Solar Calculator
*/
get_header();

?>
<div class="solar_calc_page">
    <div class="page_headings">
        <h1><?php the_title(); ?></h1>
        <p class="page_sub_heading">
            P2P Lending Calculator is a simple tool that calculates the potential return on investment when you’re lending at a P2P lending platform.
        </p>
    </div>
    <div class="solar_calc_section">
        <div class="solar_calc_wrap">
            <div class="solar_calc_col">
                <div class="solar_calc_inner_wrap">
                    <div class="solar_calc_fields">
                        <div class="single_solar_calc_field">
                            <label for="project_selection">Select Project</label>
                            <select id="project_selection">
                                <option value="radhey_heritage">Radhey Heritage</option>
                                <option value="greenfield_homes">Greenfield Homes</option>
                                <option value="madhav_villas">Madhav Villas</option>
                            </select>
                        </div>
                        <div class="single_solar_calc_field">
                            <label for="panel_cost">Panel Cost</label>
                            <input type="text" id="panel_cost_text" class="format_value">
                            <div class="range_selector">
                                <input type="range" id="panel_cost" class="format_value" min="25000" max="50000" value="30000" oninput="panel_cost_text.value = '₹' + panel_cost.value">
                                <div class="range_ticks">
                                    <div class="min_range small_range">25,000</div>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <div class="max_range small_range">50,000</div>
                                </div>
                            </div>
                        </div>
                        <div class="single_solar_calc_field">
                            <label for="panel_num">Number of Panels</label>
                            <input type="text" id="panel_num_text">
                            <div class="range_selector">
                                <input type="range" id="panel_num" min="1" max="500" value="100" oninput="panel_num_text.value = panel_num.value">
                                <div class="range_ticks">
                                <div class="min_range small_range">1</div>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <div class="max_range small_range">500</div>
                                </div>
                            </div>
                        </div>
                        <div class="single_solar_calc_field years_field">
                            <label for="tenure">Tenure</label>
                            <input type="text" id="tenure_text">
                            <span class="label_after">Years</span>
                            <div class="range_selector">
                                <input type="range" id="tenure" min="1" max="20" value="15" oninput="tenure_text.value = tenure.value">
                                <div class="range_ticks">
                                    <div class="min_range small_range">1</div>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <div class="max_range small_range">20</div>
                                </div>
                            </div>
                        </div>
                        <div class="single_solar_calc_field">
                            <label for="estimate_income">Estimated Monthly Income</label>
                            <input type="text" id="estimate_income_text" class="format_value">
                            <div class="range_selector">
                                <input type="range" id="estimate_income" class="format_value" min="10" max="1000" value="400" oninput="estimate_income_text.value = '₹' + estimate_income.value">
                                <div class="range_ticks">
                                    <div class="min_range small_range">10</div>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <span class="single_range"></span>
                                    <div class="max_range small_range">1000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="solar_calc_info">
                <div class="solar_returns_block">
                    <div class="solar_returns_wrap">
                        <div class="single_solar_return">
                            <p>Total Purchase Value</p>
                            <strong id="total_purchase_value">₹ 3,00,000</strong>
                        </div>
                        <div class="single_solar_return">
                            <p>Estimated Returns</p>
                            <strong id="estimate_returns">₹ 6,50,000 - ₹ 7,00,000</strong>
                        </div>
                        <div class="single_solar_return">
                            <p>Post Tax Income
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_26138_127145)">
                                        <path d="M10.0003 18.3334C14.6027 18.3334 18.3337 14.6024 18.3337 10C18.3337 5.39765 14.6027 1.66669 10.0003 1.66669C5.39795 1.66669 1.66699 5.39765 1.66699 10C1.66699 14.6024 5.39795 18.3334 10.0003 18.3334Z" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10 13.3333V10" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10 6.66669H10.0083" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_26138_127145">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span class="solar_tooltip">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque aliquam iste ullam adipisci similique illum dolorem, rem obcaecati aperiam assumenda.
                                </span>
                            </p>
                            <strong id="post_tax_income">₹ 4,50,000 - ₹5,00,000</strong>
                        </div>
                        <div class="single_solar_return">
                            <p>Post Tax XIRR</p>
                            <strong id="post_tax_xirr">10% - 11%</strong>
                        </div>
                    </div>
                </div>
                <div class="environment_contribution">
                    <h3>Your contribution to environment</h3>

                    <div class="env_contribution_inner">

                        <div class="contribution_list">
                            <div class="single_contribution">
                                <p>Clean Energy</p>
                                <strong id="clean_energy">43,234kW</strong>
                            </div>
                            <div class="single_contribution">
                                <p>CO2 Offset</p>
                                <strong id="co2_offset">9.74 tonnes</strong>
                            </div>
                        </div>
                        <div class="savings_list">
                            <h4>You’re creating an impact by saving <span id="co2_savings">9.74 tonne</span> CO2 emission which is equivalent to</h4>

                            <div class="savings_list_wrap">
                                <div class="single_saving_list">
                                    <div class="saving_icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mobile-icon.png" alt="mobile">
                                    </div>
                                    <div class="savings_info">
                                        <p>Producing</p>
                                        <h5>20 smartphones</h5>
                                    </div>
                                </div>
                                <div class="single_saving_list">
                                    <div class="saving_icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/car-icon.png" alt="car">
                                    </div>
                                    <div class="savings_info">
                                        <p>Driving</p>
                                        <h5>6,000 kilometres</h5>
                                    </div>
                                </div>
                                <div class="single_saving_list">
                                    <div class="saving_icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/plan-icon.png" alt="plane">
                                    </div>
                                    <div class="savings_info">
                                        <p>Flying</p>
                                        <h5>1,800 kilometres</h5>
                                    </div>
                                </div>
                                <div class="single_saving_list">
                                    <div class="saving_icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tree-icon.png" alt="tree">
                                    </div>
                                    <div class="savings_info">
                                        <p>Growing</p>
                                        <h5>487 trees</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="solar_calc_cta">
                    <div class="solar_cta_inner">
                        <div class="cta_text">
                            <h4>Invest in solar for a greener future</h4>
                        </div>
                        <a href="#" class="cta_btn">Start Investing</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="solar_graph">
        <h4 class="chart_heading">Yearly Chart</h4>
        <canvas id="barChart" width="1160px" height="419px"></canvas>
    </div>

    <div class="solar_calc_more_info">
        <div class="more_info_wap">
            <div class="about_solar_calc">
                <h2>What is Solar Calculator?</h2>
                <div class="about_calc_content">
                    <?php the_field('about_solar_calculator'); ?>
                </div>
            </div>
            <div class="other_calc_col">
                <h3>Other Calculators</h3>

                <div class="other_calc_lists">
                    <div class="single_calc">
                        <h5>
                            <a href="#">US Stocks Returns calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">P2P lending calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">Stock SIP/lumpsum Calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">US Stocks Returns calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">SGB Bond calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">FD Returns calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                    <div class="single_calc">
                        <h5>
                            <a href="#">Retirement calculator
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/faq_arrow.svg" alt="arrow">
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="solar_faqs">
        <div class="solar_faqs_wrap">
            <h2 class="faq_sec_heading">Frequently Asked Questions</h2>
            <div class="faqs_lists">
                <div class="single_faq">
                    <div class="faq_que">
                        <h4>What is P2P lending?</h4>
                    </div>
                    <div class="faq_content">
                        <p>Peer-to-peer (P2P) lending refers to an online lending model where individuals or businesses can borrow money directly from other individuals or investors through a platform. It eliminates the need for traditional financial intermediaries, such as banks or financial institutions, and enables direct interaction between borrowers and lenders.</p>
                    </div>
                </div>
                <div class="single_faq">
                    <div class="faq_que">
                        <h4>Why is P2P lending becoming popular?</h4>
                    </div>
                    <div class="faq_content">
                        <p>Peer-to-peer (P2P) lending refers to an online lending model where individuals or businesses can borrow money directly from other individuals or investors through a platform. It eliminates the need for traditional financial intermediaries, such as banks or financial institutions, and enables direct interaction between borrowers and lenders.</p>
                    </div>
                </div>
                <div class="single_faq">
                    <div class="faq_que">
                        <h4>How is P2P regulated in India?</h4>
                    </div>
                    <div class="faq_content">
                        <p>Peer-to-peer (P2P) lending refers to an online lending model where individuals or businesses can borrow money directly from other individuals or investors through a platform. It eliminates the need for traditional financial intermediaries, such as banks or financial institutions, and enables direct interaction between borrowers and lenders.</p>
                    </div>
                </div>
                <div class="single_faq">
                    <div class="faq_que">
                        <h4>How safe are these P2P lending investments? What happens in case of a default?</h4>
                    </div>
                    <div class="faq_content">
                        <p>Peer-to-peer (P2P) lending refers to an online lending model where individuals or businesses can borrow money directly from other individuals or investors through a platform. It eliminates the need for traditional financial intermediaries, such as banks or financial institutions, and enables direct interaction between borrowers and lenders.</p>
                    </div>
                </div>
                <div class="single_faq">
                    <div class="faq_que">
                        <h4>Who are the borrowers of these loans?</h4>
                    </div>
                    <div class="faq_content">
                        <p>Peer-to-peer (P2P) lending refers to an online lending model where individuals or businesses can borrow money directly from other individuals or investors through a platform. It eliminates the need for traditional financial intermediaries, such as banks or financial institutions, and enables direct interaction between borrowers and lenders.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    
</script>
<?php
get_footer();