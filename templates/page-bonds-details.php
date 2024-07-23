<?php
get_header();
$bond_name_slug = get_query_var('bond_company');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<div class="bond_details_main">
    <div class="container">
        <div class="bond_details_wrapper">
            <div class="bond_details_left_column">
                <div class="stocks_search_container">
                    <?php get_template_part('template-parts/bond-details/bond-search-link'); ?>
                </div>
                <div class="stock_details_box stock_info_container">
                    <div class="stock_info_icons">
                        <div class="stock_img">
                            <img src="" alt="" />
                        </div>
                        <h1 class="bond-name desktop_hide"></h1>
                        <div class="share_icon mobile_hide" onclick="copyLink()">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                        </div>
                    </div>
                    <h1 class="bond-name mobile_hide"></h1>
                    <h2 id="issuer-name"></h2>
                    <h6 id="security-id"></h6>
                    <div class="bonds_info_box">
                        <div class="bond_details_box">
                            <div class="bond_detail_col">
                                    <div class="bond_single_detail">
                                        <p class="detail_info">Yield</p>
                                        <h4 id="bond-yield" class="highlighted"></h4>
                                    </div>
                                    <div class="bond_single_detail">
                                        <p class="detail_info">Matures in</p>
                                        <h4 id="bond-mature"></h4>
                                    </div>
                            </div>
                            <div class="bond_detail_col">
                                <div class="bond_single_detail">
                                        <p class="detail_info">Min. Investment</p>
                                        <h4 id="bond-investment" class="highlighted"></h4>
                                    </div>
                                    <div class="bond_single_detail">
                                        <p class="detail_info">Interest Payment</p>
                                        <h4 id="bond-interest"></h4>
                                    </div>
                            </div>
                        </div>
                        <div class="stock_tags">
                        </div>
                    </div>
                    <div class="stock_share_buttons">
                        <a href="#">
                            <button class="primary_button">
                                Invest now
                            </button>
                        </a>
                        <div class="share_icon desktop_hide" onclick="copyLink()">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                        </div>
                    </div>
                    <div class="bond_certificate desktop_hide">
                        <span id="certificate_rating">-</span>
                        <div class="certificate_bg">
                            <svg width="50" height="29" viewBox="0 0 50 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M56 4C56 1.79086 54.2091 0 52 0H13.1316C11.5345 0 10.0905 0.950035 9.45833 2.41668L0.406601 23.4167C-0.731503 26.0571 1.20466 29 4.0799 29H52C54.2091 29 56 27.2091 56 25V4Z" fill="#4ADE80"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bond_details_right_column">
                <div class="stock_tabs_menu_position"></div>
                <div class="stock_tabs_menu">
                    <div class="stock_tabs_menu_wrapper">
                        <a class="tab_button active" href="#returns_tab">Returns</a>
                        <a class="tab_button" href="#rating_tab">Rating</a>
                        <a class="tab_button" href="#metrics_tab">Key Metrics</a>
                        <a class="tab_button" href="#about_tab">About Issuer</a>
                        <!-- <a class="tab_button" href="#compare_tab">Compare</a> -->
                        <a class="tab_button" href="#faqs_tab">FAQs</a>
                    </div>
                </div>

                <?php 
                    get_template_part(
                        'template-parts/bond-details/returns'); 
                ?>
                <div class="ratings_tab_wrap">
                    <div class="ratings_tab" id="ratings_tab_wrap">
                <?php 
                    get_template_part(
                        'template-parts/bond-details/ratings'); 
                ?>
                </div>
                <div class="ratings_tab" id="metrics_tab_wrap">
                <?php 
                    get_template_part(
                        'template-parts/bond-details/metrics'); 
                ?>
                </div>
                </div>
                <?php 
                    get_template_part(
                        'template-parts/bond-details/issuer-details'); 
                ?>
                <?php 
                    get_template_part(
                        'template-parts/bond-details/fixed-income-products'); 
                ?>
                 <?php 
                    get_template_part(
                        'template-parts/bond-details/faqs'); 
                ?>
        </div>
        </div>
    </div>
</div>
<div id="bond-loader">
    <div class="bond_loader"></div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>
<?php get_template_part('template-parts/bond-details/js/bond-details-api'); ?>
<?php get_template_part('template-parts/bond-details/js/general-js'); ?>

<?php get_footer(); ?>