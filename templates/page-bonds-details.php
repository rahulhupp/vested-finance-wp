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
                        <div class="share_icon" onclick="copyLink()">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                        </div>
                    </div>
                    <h1 id="bond-name"></h1>
                    <h2 id="issuer-name"></h2>
                    <h6 id="security-id"></h6>
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
                    <a href="#">
                        <button class="primary_button">
                            Invest now
                        </button>
                    </a>
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