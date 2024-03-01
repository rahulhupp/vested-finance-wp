<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $start_time = microtime(true);
    $api_calls = fetch_all_api_data($symbol, $token);
    $end_time = microtime(true);
    $time_taken = $end_time - $start_time;
    $overview_data = $api_calls['overview'];
    $returns_data = $api_calls['returns'];
    $income_statement_data = $api_calls['income-statement'];
    $balance_sheet_data = $api_calls['balance-sheet'];
    $cash_flow_data = $api_calls['cash-flow'];
    $ratios_data = $api_calls['key-ratios'];
    $news_data = $api_calls['news'];
    
    if ($overview_data) {
        $ticker = $overview_data->ticker;
        $name = $overview_data->name;
        $formattedTicker = strtolower(str_replace(' ', '-', $ticker));
        $formattedName = strtolower($name);
        $formattedName = str_replace([' ', ','], '-', $formattedName);
        $formattedName = preg_replace('/[^a-zA-Z0-9\-]/', '', $formattedName);
        $formattedName = preg_replace('/-+/', '-', $formattedName);
        $formattedName = trim($formattedName, '-');
        $homeURL = home_url();
        set_query_var('custom_stock_title_value', "$name Share Price today - Invest in $ticker Stock  | Market Cap, Quote, Returns & More");
        set_query_var('custom_stock_description_value', "Get the Live stock price of $name ($ticker), Check its Financials, Fundamental Data, Overview, Technicals, Returns & Earnings over the years and Key ratios & Market news about the stock. Start Investing in $name and other US Stocks with Vested.");
        set_query_var('custom_stock_url_value', "$homeURL/us-stocks/$formattedTicker/$formattedName-share-price/");
        set_query_var('custom_stock_image_value', "https://d13dxy5z8now6z.cloudfront.net/symbol/$ticker.png");
    }

    function preprocessSummary($summary) {
        $mapping = [];
        foreach ($summary as $item) {
            if ($item->label === "52-Week Range") {
                $mapping[$item->label] = [
                    'low' => isset($item->raw->low) ? $item->raw->low : '',
                    'high' => isset($item->raw->high) ? $item->raw->high : ''
                ];
            } else {
                $mapping[$item->label] = $item->value;
            }
        }
        return $mapping;
    }

    function getValueByLabel($summaryMapping, $label) {
        return isset($summaryMapping[$label]) ? $summaryMapping[$label] : '';
    }
?>
<?php
    $symbol = get_query_var('symbol');
    get_header();
?>
<div class="stock_details_main">
    <div class="container">
        <div class="stock_details_wrapper">
            <div class="stock_details_left_column">
                <div class="stocks_search_container">
                    <?php get_template_part('template-parts/stocks-details/stock-search-link'); ?>
                </div>
                <?php echo "Time taken for API call: " . $time_taken . " seconds"; ?>
                <?php get_template_part('template-parts/stocks-details/stock-info', null, array('overview_data' => $overview_data)); ?>
                
                <div class="stock_details_box stock_forecast_container">
                    <h2 class="heading">Analyst Forecast</h2>
                    <div class="separator_line"></div>
                    <div class="analyst_forecast_chart_container">
                        <canvas id="analystForecastChart"></canvas>
                        <div class="svg_skeleton" id="analyst_chart_skeleton">
                            <svg width="158" height="157" viewBox="0 0 158 157" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M42.2362 10.2748C53.2403 4.34518 65.5109 1.16758 78 1.00645V76.6442L14.8272 35.0478C21.83 24.7054 31.2321 16.2045 42.2362 10.2748Z"
                                    fill="#DDDDDD" stroke="white" stroke-width="2" />
                                <mask id="path-2-inside-1_3_2" fill="white">
                                    <path
                                        d="M9.26159 114.539C2.83475 102.102 -0.149495 88.1736 0.618096 74.1957C1.38569 60.2178 5.87719 46.6994 13.6272 35.0415L79 78.5L9.26159 114.539Z" />
                                </mask>
                                <path
                                    d="M9.26159 114.539C2.83475 102.102 -0.149495 88.1736 0.618096 74.1957C1.38569 60.2178 5.87719 46.6994 13.6272 35.0415L79 78.5L9.26159 114.539Z"
                                    fill="#DDDDDD" stroke="white" stroke-width="4" mask="url(#path-2-inside-1_3_2)" />
                                <mask id="path-3-inside-2_3_2" fill="white">
                                    <path
                                        d="M79 0C92.9362 1.66188e-07 106.621 3.71005 118.649 10.749C130.677 17.788 140.614 27.9021 147.44 40.0523C154.266 52.2025 157.734 65.9509 157.488 79.8849C157.242 93.8189 153.291 107.436 146.041 119.338C138.791 131.24 128.503 140.997 116.234 147.608C103.966 154.218 90.1582 157.443 76.2306 156.951C62.3031 156.459 48.7575 152.269 36.9854 144.81C25.2133 137.351 15.6391 126.893 9.24629 114.509L79 78.5L79 0Z" />
                                </mask>
                                <path
                                    d="M79 0C92.9362 1.66188e-07 106.621 3.71005 118.649 10.749C130.677 17.788 140.614 27.9021 147.44 40.0523C154.266 52.2025 157.734 65.9509 157.488 79.8849C157.242 93.8189 153.291 107.436 146.041 119.338C138.791 131.24 128.503 140.997 116.234 147.608C103.966 154.218 90.1582 157.443 76.2306 156.951C62.3031 156.459 48.7575 152.269 36.9854 144.81C25.2133 137.351 15.6391 126.893 9.24629 114.509L79 78.5L79 0Z"
                                    fill="#DDDDDD" stroke="white" stroke-width="4" mask="url(#path-3-inside-2_3_2)" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stock_details_right_column">
                <div class="stock_tabs_menu_position" />
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

                
                <?php get_template_part('template-parts/stocks-details/overview', null, array('overview_data' => $overview_data)); ?>
                <?php get_template_part('template-parts/stocks-details/returns', null, array('returns_data' => $returns_data)); ?>
                <?php 
                    get_template_part(
                        'template-parts/stocks-details/financials', 
                        null, 
                        array(
                            'income_statement_data' => $income_statement_data,
                            'balance_sheet_data' => $balance_sheet_data,
                            'cash_flow_data' => $cash_flow_data
                        )
                    ); 
                ?>

                <?php get_template_part('template-parts/stocks-details/ratios', null, array('ratios_data' => $ratios_data)); ?>
                <?php get_template_part('template-parts/stocks-details/news', null, array('news_data' => $news_data)); ?>
                <?php get_template_part('template-parts/stocks-details/discover'); ?>
                <?php 
                    get_template_part(
                        'template-parts/stocks-details/faqs', 
                        null, 
                        array(
                            'overview_data' => $overview_data,
                            'ratios_data' => $ratios_data
                        )
                    ); 
                ?>
            </div>
        </div>
    </div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>
                            
<?php get_template_part('template-parts/stocks-details/advanced-chart-modal', null, array('overview_data' => $overview_data)); ?>
<?php get_template_part('template-parts/stocks-details/add-ticker-modal'); ?>

<script defer src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script defer src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<?php get_template_part('template-parts/stocks-details/js/general-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/price-chart-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/analyst-forecast-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/returns-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/financial-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/ratios-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/news-js'); ?>

<?php get_footer(); ?>