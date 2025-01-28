<?php
if (function_exists('get_partner_tokens_from_database')) {
    $token = get_partner_tokens_from_database();
} else {
    $token = us_stocks_get_token();
}

$requested_url = $_SERVER['REQUEST_URI'];
$home_url = parse_url(home_url(), PHP_URL_PATH);
$path = substr($requested_url, strlen($home_url));
$get_path = explode("/", $path);

$api_calls = fetch_all_api_data($symbol, $token);
$overview_data = $api_calls['overview'];
$returns_data = $api_calls['returns'];

$price_chart_data = fetch_price_chart_api_data($symbol, $token);

if ($get_path[2] == 'etf') {
    $largest_holdings_data = $api_calls['holdings'];
    $sector_breakdowns_data = $api_calls['sector-breakdown'];
} else {
    $analysts_data = $api_calls['analysts-predictions'];
    $income_statement_data = $api_calls['income-statement'];
    $balance_sheet_data = $api_calls['balance-sheet'];
    $cash_flow_data = $api_calls['cash-flow'];
    $ratios_data = $api_calls['key-ratios'];
    $news_data = $api_calls['news'];
}

if ($overview_data) {
    if (!isset($overview_data->error) || $overview_data->error != 1) {
        $meta_settings = get_field('meta_settings', 'option');
        $ticker = $overview_data->ticker;
        $name = $overview_data->name;
        $formattedTicker = strtolower(str_replace(' ', '-', $ticker));
        $formattedName = strtolower($name);
        $formattedName = str_replace([' ', ','], '-', $formattedName);
        $formattedName = preg_replace('/[^a-zA-Z0-9\-]/', '', $formattedName);
        $formattedName = preg_replace('/-+/', '-', $formattedName);
        $formattedName = trim($formattedName, '-');

        $homeURL = home_url();
        $custom_title = '';
        $custom_description = '';

        if ($meta_settings) {
            foreach ($meta_settings as $meta_row) {
                if (!empty($meta_row['ticker']) && strtolower($meta_row['ticker']) === strtolower($ticker)) {
                    $custom_title = $meta_row['meta_title'];
                    $custom_description = $meta_row['meta_description'];
                    break;
                }
            }
        }

        if (!empty($custom_title)) {
            set_query_var('custom_stock_title_value', $custom_title);
        } else {
            if ($get_path[2] == 'etf') {
                set_query_var('custom_stock_title_value', "$ticker Stock Price, Invest in $name share today - Quotes & Returns");
            } else {
                set_query_var('custom_stock_title_value', "$name Share Price today - Invest in $ticker Stock  | Market Cap, Quote, Returns & More");
            }
        }

        if (!empty($custom_description)) {
            set_query_var('custom_stock_description_value', $custom_description);
        } else {
            if ($get_path[2] == 'etf') {
                set_query_var('custom_stock_description_value', "Get the live $name ($ticker) ETF stock quote, historical prices, returns, largest holdings, expense ratio, and more on Vested. Everything you need to invest in $name ($ticker) ETF and other US ETFs.");
            } else {
                set_query_var('custom_stock_description_value', "Get the Live stock price of $name ($ticker), Check its Financials, Fundamental Data, Overview, Technicals, Returns & Earnings over the years and Key ratios & Market news about the stock. Start Investing in $name and other US Stocks with Vested.");
            }
        }
        set_query_var('custom_stock_url_value', "$homeURL$path");
        set_query_var('custom_stock_image_value', "https://d13dxy5z8now6z.cloudfront.net/symbol/$ticker.png");
    }
}

function preprocessSummary($summary)
{
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

function getValueByLabel($summaryMapping, $label)
{
    return isset($summaryMapping[$label]) ? $summaryMapping[$label] : '';
}
?>
<?php
$symbol = get_query_var('symbol');
get_header(); ?>
<style>
    .stock_error_block {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stock_error_inner {
        background-color: #fee2e2;
        padding: 14px;
        border-radius: 5px;
        text-align: center;
        max-width: 560px;
    }

    .stock_error_inner p {
        letter-spacing: 0;
        font-weight: 400;
        line-height: 1.4;
        color: #7f1d1d;
        font-size: 16px;
        margin-bottom: 0;
    }
</style>
<?php
if ($overview_data) {
    if (!isset($overview_data->error) || $overview_data->error != 1) { ?>
        <div class="stock_details_main">
            <div class="container">
                <div class="stock_details_wrapper">
                    <div class="stock_details_left_column">
                        <div class="stocks_search_container">
                            <?php get_template_part('template-parts/stocks-details/stock-search-link'); ?>
                        </div>
                        <?php
                        get_template_part(
                            'template-parts/stocks-details/stock-info',
                            null,
                            array(
                                'overview_data' => $overview_data,
                                'get_path' => $get_path
                            )
                        );
                        ?>

                        <?php if ($get_path[2] !== 'etf'): ?>
                            <div class="stock_details_box stock_forecast_container">
                                <h2 class="heading">Analyst Forecast</h2>
                                <div class="separator_line"></div>
                                <div class="analyst_forecast_chart_container">
                                    <canvas id="analystForecastChart"></canvas>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="stock_details_right_column">
                        <div class="stock_tabs_menu_position">
                            <div class="stock_tabs_menu">
                                <div class="stock_tabs_menu_wrapper">
                                    <a class="tab_button active" href="#overview_tab">Overview</a>
                                    <a class="tab_button" href="#returns_tab">Returns</a>
                                    <?php if ($get_path[2] !== 'etf'): ?>
                                        <a class="tab_button" href="#financials_tab">Financials</a>
                                        <a class="tab_button" href="#ratios_tab">Ratios</a>
                                        <a class="tab_button" href="#news_tab">News</a>
                                    <?php else: ?>
                                        <a class="tab_button" href="#largest_holdings_tab">Holdings</a>
                                        <a class="tab_button" href="#sector_breakdown_tab">Sector Breakdown</a>
                                    <?php endif; ?>
                                    <a class="tab_button" href="#faqs_tab">FAQs</a>
                                </div>
                            </div>

                            <?php
                            get_template_part(
                                'template-parts/stocks-details/overview',
                                null,
                                array(
                                    'overview_data' => $overview_data,
                                    'get_path' => $get_path,
                                    'price_chart_data' => $price_chart_data
                                )
                            );
                            ?>

                            <?php
                            if($returns_data) :
                                get_template_part(
                                    'template-parts/stocks-details/returns',
                                    null,
                                    array(
                                        'returns_data' => $returns_data,
                                        'get_path' => $get_path
                                    )
                                );
                            endif;
                            ?>

                            <?php if ($get_path[2] !== 'etf'): ?>
                                <?php
                                    if($income_statement_data && $balance_sheet_data && $cash_flow_data):
                                        get_template_part(
                                            'template-parts/stocks-details/financials',
                                            null,
                                            array(
                                                'income_statement_data' => $income_statement_data,
                                                'balance_sheet_data' => $balance_sheet_data,
                                                'cash_flow_data' => $cash_flow_data
                                            )
                                        );
                                    endif;
                                ?>

                                <?php 
                                    if($ratios_data):
                                        get_template_part('template-parts/stocks-details/ratios', null, array('ratios_data' => $ratios_data));
                                    endif;
                                ?>
                                <?php
                                    if($news_data):
                                        get_template_part('template-parts/stocks-details/news', null, array('news_data' => $news_data));
                                    endif;
                                ?>
                            <?php else: ?>
                                <?php
                                if ($largest_holdings_data) {
                                    get_template_part('template-parts/stocks-details/largest-holdings', null, array('largest_holdings_data' => $largest_holdings_data));
                                }
                                ?>
                                <?php
                                if ($sector_breakdowns_data) {
                                    get_template_part('template-parts/stocks-details/sector-breakdown', null, array('sector_breakdowns_data' => $sector_breakdowns_data));
                                }
                                ?>
                            <?php endif; ?>

                            <?php
                                if($get_path):
                                    get_template_part('template-parts/stocks-details/discover', null, array('get_path' => $get_path));
                                endif;
                            ?>

                            <?php if ($get_path[2] !== 'etf'): ?>
                                <?php
                                    if($overview_data && $ratios_data):
                                        get_template_part(
                                            'template-parts/stocks-details/faqs',
                                            null,
                                            array(
                                                'overview_data' => $overview_data,
                                                'ratios_data' => $ratios_data
                                            )
                                        );
                                    endif;
                                ?>
                            <?php else: ?>
                                <?php
                                    if ($overview_data && $ratios_data):
                                        get_template_part(
                                            'template-parts/stocks-details/faqs-etf',
                                            null,
                                            array(
                                                'returns_data' => $returns_data,
                                                'overview_data' => $overview_data
                                            )
                                        );
                                    endif;
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="copy_link_message">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" alt="checkmark icon" />
                <span>Link copied</span>
            </div>

            <?php get_template_part('template-parts/stocks-details/advanced-chart-modal', null, array('overview_data' => $overview_data)); ?>
            <?php get_template_part('template-parts/stocks-details/add-ticker-modal'); ?>

            <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
            <?php get_template_part('template-parts/stocks-details/js/general-js'); ?>
            <?php
            if ($price_chart_data) {
                get_template_part('template-parts/stocks-details/js/price-chart-js', null, array('price_chart_data' => $price_chart_data));
            }
            ?>

            <?php if ($get_path[2] !== 'etf'): ?>
                <?php get_template_part('template-parts/stocks-details/js/analyst-forecast-js', null, array('analysts_data' => $analysts_data)); ?>
                <?php get_template_part('template-parts/stocks-details/js/ratios-js'); ?>
                <?php get_template_part('template-parts/stocks-details/js/financial-js'); ?>
                <?php get_template_part('template-parts/stocks-details/js/returns-js'); ?>
            <?php else: ?>
                <?php get_template_part('template-parts/stocks-details/js/sector-breakdown-js'); ?>
                <?php get_template_part('template-parts/stocks-details/js/returns-etf-js'); ?>
            <?php endif; ?>

        <?php } else { ?>
            <div class="stock_error_block">
                <div class="stock_error_inner">
                    <p><i class="fa fa-info-circle" aria-hidden="true"></i> Error Retrieving Data</p>
                </div>
            </div>
    <?php }
}
    ?>

    <?php get_footer(); ?>