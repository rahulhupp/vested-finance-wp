<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $api_calls = fetch_all_api_data($symbol, $token);
    $overview_data = $api_calls['overview'];
    $returns_data = $api_calls['returns'];
    $income_statement_data = $api_calls['income-statement'];
    $balance_sheet_data = $api_calls['balance-sheet'];
    $cash_flow_data = $api_calls['cash-flow'];
    $ratios_data = $api_calls['key-ratios'];
    $news_data = $api_calls['news'];
    $analysts_data = $api_calls['analysts-predictions'];
    $price_chart_data = fetch_price_chart_api_data($symbol, $token);

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
                <?php get_template_part('template-parts/stocks-details/stock-info', null, array('overview_data' => $overview_data)); ?>
                
                <div class="stock_details_box stock_forecast_container">
                    <h2 class="heading">Analyst Forecast</h2>
                    <div class="separator_line"></div>
                    <div class="analyst_forecast_chart_container">
                        <canvas id="analystForecastChart"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<?php get_template_part('template-parts/stocks-details/js/general-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/price-chart-js', null, array('price_chart_data' => $price_chart_data)); ?>
<?php get_template_part('template-parts/stocks-details/js/analyst-forecast-js', null, array('analysts_data' => $analysts_data)); ?>
<?php get_template_part('template-parts/stocks-details/js/returns-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/ratios-js'); ?>

<?php get_footer(); ?>