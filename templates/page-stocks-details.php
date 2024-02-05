<?php
$symbol = get_query_var('symbol');
$symbol_uppercase = strtoupper($symbol);
set_query_var('custom_stock_title_value', "$symbol_uppercase Share Price today - Invest in $symbol_uppercase Stock  | Market Cap, Quote, Returns & More");
set_query_var('custom_stock_description_value', "Get the Live stock price of $symbol_uppercase ($symbol_uppercase), Check its Financials, Fundamental Data, Overview, Technicals, Returns & Earnings over the years and Key ratios & Market news about the stock. Start Investing in $symbol_uppercase and other US Stocks with Vested."); // Replace this with your actual description
get_header();
?>
<script src="https://cdn.jsdelivr.net/npm/jsstore/dist/jsstore.min.js"></script>
<div class="stock_details_main">
    <div class="container">
        <div class="stock_details_wrapper">
            <div class="stock_details_left_column">
                <div class="stocks_search_container">
                    <?php get_template_part('template-parts/stocks-details/stock-search-link'); ?>
                </div>
                <?php get_template_part('template-parts/stocks-details/stock-info'); ?>
                
                <div class="stock_details_box stock_forecast_container">
                    <h2 class="heading">Analyst Forecast</h2>
                    <div class="separator_line"></div>
                    <div class="analyst_forecast_chart_container">
                        <canvas id="analystForecastChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="stock_details_right_column">
                <div class="stock_tabs_menu">
                    <div class="stock_tabs_menu_wrapper">
                        <a class="tab_button active" href="#overview_tab">Overview</a>
                        <a class="tab_button" href="#returns_tab">Returns</a>
                        <a class="tab_button" href="#financials_tab">Financials</a>
                        <a class="tab_button" href="#ratios_tab">Ratios</a>
                        <a class="tab_button" href="#news_tab">News</a>
                        <a class="tab_button" href="#faqs_tab">FAQs</a>
                    </div>
                </div>

                
                <?php get_template_part('template-parts/stocks-details/overview'); ?>
                <?php get_template_part('template-parts/stocks-details/returns'); ?>
                <?php get_template_part('template-parts/stocks-details/financials'); ?>

                <div id="ratios_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">Ratios</h2>
                        <div class="separator_line"></div>
                        <div id="ratios_content"></div>
                    </div>
                </div>

                <div id="news_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">News</h2>
                        <div class="separator_line"></div>
                        <div id="news_content"></div>
                    </div>
                </div>
                <?php get_template_part('template-parts/stocks-details/discover'); ?>
                <?php get_template_part('template-parts/stocks-details/faqs'); ?>
            </div>
        </div>
    </div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>
                            
<?php get_template_part('template-parts/stocks-details/advanced-chart-modal'); ?>
<?php get_template_part('template-parts/stocks-details/add-ticker-modal'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


<script>
    function updateMetaTags(data) {
        var head = document.head || document.getElementsByTagName('head')[0];

        // Update title
        var titleTag = head.querySelector('title');

        if (titleTag) {
            titleTag.textContent = `${data.data.name} Share Price today - Invest in ${data.data.ticker} Stock | Market Cap, Quote, Returns & More`;
        }
    }
</script>
<?php get_template_part('template-parts/stocks-details/js/store-stocks-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/overview-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/price-chart-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/analyst-forecast-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/returns-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/financial-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/ratios-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/news-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/general-js'); ?>
<?php get_footer(); ?>