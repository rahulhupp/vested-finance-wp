<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $overview_data = fetch_overview_api_data($symbol, $token);
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
?>
<?php
    $symbol = get_query_var('symbol');
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
                <?php get_template_part('template-parts/stocks-details/returns'); ?>
                <?php get_template_part('template-parts/stocks-details/financials'); ?>

                <div id="ratios_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">Ratios</h2>
                        <div class="separator_line"></div>
                        <div id="ratios_content"></div>
                        <div class="svg_skeleton" id="ratios_skeleton">
                            <svg width="720" height="1339" viewBox="0 0 720 1339" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_10_996)">
                                    <path
                                        d="M713 35H7C3.68629 35 1 37.6863 1 41V197C1 200.314 3.68629 203 7 203H713C716.314 203 719 200.314 719 197V41C719 37.6863 716.314 35 713 35Z"
                                        fill="white" />
                                    <path
                                        d="M713 35H7C3.68629 35 1 37.6863 1 41V197C1 200.314 3.68629 203 7 203H713C716.314 203 719 200.314 719 197V41C719 37.6863 716.314 35 713 35Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 34.5H7C3.41015 34.5 0.5 37.4101 0.5 41V197C0.5 200.59 3.41015 203.5 7 203.5H713C716.59 203.5 719.5 200.59 719.5 197V41C719.5 37.4101 716.59 34.5 713 34.5Z"
                                        stroke="#002852" stroke-opacity="0.2" />
                                    <path d="M1 41C1 37.6863 3.68629 35 7 35H436V83H1V41Z" fill="white" />
                                    <path d="M1 41C1 37.6863 3.68629 35 7 35H436V83H1V41Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M537 35H436V83H537V35Z" fill="white" />
                                    <path d="M537 35H436V83H537V35Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M638 35H537V83H638V35Z" fill="white" />
                                    <path d="M638 35H537V83H638V35Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M434.75 83.25H1.25V122.75H434.75V83.25Z" fill="white" />
                                    <path d="M434.75 83.25H1.25V122.75H434.75V83.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 83.25H435.25V122.75H536.25V83.25Z" fill="white" />
                                    <path d="M536.25 83.25H435.25V122.75H536.25V83.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 83H536.5V123H638V83Z" fill="#EFF6FF" />
                                    <path d="M434.75 123.25H1.25V162.75H434.75V123.25Z" fill="white" />
                                    <path d="M434.75 123.25H1.25V162.75H434.75V123.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 123H435V163H536.5V123Z" fill="#EFF6FF" />
                                    <path d="M637.75 123.25H536.75V162.75H637.75V123.25Z" fill="white" />
                                    <path d="M637.75 123.25H536.75V162.75H637.75V123.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M1.25 163.25H434.75V202.75H7C3.82436 202.75 1.25 200.176 1.25 197V163.25Z" fill="white" />
                                    <path d="M1.25 163.25H434.75V202.75H7C3.82436 202.75 1.25 200.176 1.25 197V163.25Z" stroke="#F5F5F5"
                                        stroke-width="0.5" />
                                    <path d="M536.25 163.25H435.25V202.75H536.25V163.25Z" fill="white" />
                                    <path d="M536.25 163.25H435.25V202.75H536.25V163.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 163H536.5V203H638V163Z" fill="#EFF6FF" />
                                    <path d="M638 35H713C716.314 35 719 37.6863 719 41V197C719 200.314 716.314 203 713 203H638V35Z"
                                        fill="white" />
                                    <path d="M638 35H713C716.314 35 719 37.6863 719 41V197C719 200.314 716.314 203 713 203H638V35Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 330H7C3.68629 330 1 332.686 1 336V492C1 495.314 3.68629 498 7 498H713C716.314 498 719 495.314 719 492V336C719 332.686 716.314 330 713 330Z"
                                        fill="white" />
                                    <path
                                        d="M713 330H7C3.68629 330 1 332.686 1 336V492C1 495.314 3.68629 498 7 498H713C716.314 498 719 495.314 719 492V336C719 332.686 716.314 330 713 330Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 329.5H7C3.41015 329.5 0.5 332.41 0.5 336V492C0.5 495.59 3.41015 498.5 7 498.5H713C716.59 498.5 719.5 495.59 719.5 492V336C719.5 332.41 716.59 329.5 713 329.5Z"
                                        stroke="#002852" stroke-opacity="0.2" />
                                    <path d="M1 336C1 332.686 3.68629 330 7 330H435V378H1V336Z" fill="white" />
                                    <path d="M1 336C1 332.686 3.68629 330 7 330H435V378H1V336Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M536.5 330H435V378H536.5V330Z" fill="white" />
                                    <path d="M536.5 330H435V378H536.5V330Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M638 330H536.5V378H638V330Z" fill="white" />
                                    <path d="M638 330H536.5V378H638V330Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M434.75 378.25H1.25V417.75H434.75V378.25Z" fill="white" />
                                    <path d="M434.75 378.25H1.25V417.75H434.75V378.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 378.25H435.25V417.75H536.25V378.25Z" fill="white" />
                                    <path d="M536.25 378.25H435.25V417.75H536.25V378.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 378H536.5V418H638V378Z" fill="#EFF6FF" />
                                    <path d="M434.75 418.25H1.25V457.75H434.75V418.25Z" fill="white" />
                                    <path d="M434.75 418.25H1.25V457.75H434.75V418.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 418.25H435.25V457.75H536.25V418.25Z" fill="white" />
                                    <path d="M536.25 418.25H435.25V457.75H536.25V418.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 418H536.5V458H638V418Z" fill="#EFF6FF" />
                                    <path d="M1.25 458.25H434.75V497.75H7C3.82436 497.75 1.25 495.176 1.25 492V458.25Z" fill="white" />
                                    <path d="M1.25 458.25H434.75V497.75H7C3.82436 497.75 1.25 495.176 1.25 492V458.25Z" stroke="#F5F5F5"
                                        stroke-width="0.5" />
                                    <path d="M536.25 458.25H435.25V497.75H536.25V458.25Z" fill="white" />
                                    <path d="M536.25 458.25H435.25V497.75H536.25V458.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 458H536.5V498H638V458Z" fill="#EFF6FF" />
                                    <path d="M638 330H713C716.314 330 719 332.686 719 336V492C719 495.314 716.314 498 713 498H638V330Z"
                                        fill="white" />
                                    <path d="M638 330H713C716.314 330 719 332.686 719 336V492C719 495.314 716.314 498 713 498H638V330Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 605H7C3.68629 605 1 607.686 1 611V857C1 860.314 3.68629 863 7 863H713C716.314 863 719 860.314 719 857V611C719 607.686 716.314 605 713 605Z"
                                        fill="white" />
                                    <path
                                        d="M713 605H7C3.68629 605 1 607.686 1 611V857C1 860.314 3.68629 863 7 863H713C716.314 863 719 860.314 719 857V611C719 607.686 716.314 605 713 605Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 604.5H7C3.41015 604.5 0.5 607.41 0.5 611V857C0.5 860.59 3.41015 863.5 7 863.5H713C716.59 863.5 719.5 860.59 719.5 857V611C719.5 607.41 716.59 604.5 713 604.5Z"
                                        stroke="#002852" stroke-opacity="0.2" />
                                    <path d="M1 611C1 607.686 3.68629 605 7 605H435V653H1V611Z" fill="white" />
                                    <path d="M1 611C1 607.686 3.68629 605 7 605H435V653H1V611Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M536.5 605H435V653H536.5V605Z" fill="white" />
                                    <path d="M536.5 605H435V653H536.5V605Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M638 605H536.5V653H638V605Z" fill="white" />
                                    <path d="M638 605H536.5V653H638V605Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M434.75 653.25H1.25V707.75H434.75V653.25Z" fill="white" />
                                    <path d="M434.75 653.25H1.25V707.75H434.75V653.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 653H435V708H536.5V653Z" fill="#EFF6FF" />
                                    <path d="M637.75 653.25H536.75V707.75H637.75V653.25Z" fill="white" />
                                    <path d="M637.75 653.25H536.75V707.75H637.75V653.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M434.75 708.25H1.25V777.75H434.75V708.25Z" fill="white" />
                                    <path d="M434.75 708.25H1.25V777.75H434.75V708.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 708H435V778H536.5V708Z" fill="#EFF6FF" />
                                    <path d="M637.75 708.25H536.75V777.75H637.75V708.25Z" fill="white" />
                                    <path d="M637.75 708.25H536.75V777.75H637.75V708.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M1.25 778.25H434.75V862.75H7C3.82436 862.75 1.25 860.176 1.25 857V778.25Z" fill="white" />
                                    <path d="M1.25 778.25H434.75V862.75H7C3.82436 862.75 1.25 860.176 1.25 857V778.25Z" stroke="#F5F5F5"
                                        stroke-width="0.5" />
                                    <path d="M536.5 778H435V863H536.5V778Z" fill="#EFF6FF" />
                                    <path d="M637.75 778.25H536.75V862.75H637.75V778.25Z" fill="white" />
                                    <path d="M637.75 778.25H536.75V862.75H637.75V778.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 605H713C716.314 605 719 607.686 719 611V857C719 860.314 716.314 863 713 863H638V605Z"
                                        fill="white" />
                                    <path d="M638 605H713C716.314 605 719 607.686 719 611V857C719 860.314 716.314 863 713 863H638V605Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 970H7C3.68629 970 1 972.686 1 976V1332C1 1335.31 3.68629 1338 7 1338H713C716.314 1338 719 1335.31 719 1332V976C719 972.686 716.314 970 713 970Z"
                                        fill="white" />
                                    <path
                                        d="M713 970H7C3.68629 970 1 972.686 1 976V1332C1 1335.31 3.68629 1338 7 1338H713C716.314 1338 719 1335.31 719 1332V976C719 972.686 716.314 970 713 970Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <path
                                        d="M713 969.5H7C3.41015 969.5 0.5 972.41 0.5 976V1332C0.5 1335.59 3.41015 1338.5 7 1338.5H713C716.59 1338.5 719.5 1335.59 719.5 1332V976C719.5 972.41 716.59 969.5 713 969.5Z"
                                        stroke="#002852" stroke-opacity="0.2" />
                                    <path d="M1 976C1 972.686 3.68629 970 7 970H435V1018H1V976Z" fill="white" />
                                    <path d="M1 976C1 972.686 3.68629 970 7 970H435V1018H1V976Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M536.5 970H435V1018H536.5V970Z" fill="white" />
                                    <path d="M536.5 970H435V1018H536.5V970Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M638 970H536.5V1018H638V970Z" fill="white" />
                                    <path d="M638 970H536.5V1018H638V970Z" fill="#002852" fill-opacity="0.08" />
                                    <path d="M434.75 1018.25H1.25V1057.75H434.75V1018.25Z" fill="white" />
                                    <path d="M434.75 1018.25H1.25V1057.75H434.75V1018.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 1018.25H435.25V1057.75H536.25V1018.25Z" fill="white" />
                                    <path d="M536.25 1018.25H435.25V1057.75H536.25V1018.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 1018H536.5V1058H638V1018Z" fill="#EFF6FF" />
                                    <path d="M434.75 1058.25H1.25V1097.75H434.75V1058.25Z" fill="white" />
                                    <path d="M434.75 1058.25H1.25V1097.75H434.75V1058.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 1058.25H435.25V1097.75H536.25V1058.25Z" fill="white" />
                                    <path d="M536.25 1058.25H435.25V1097.75H536.25V1058.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 1058H536.5V1098H638V1058Z" fill="#EFF6FF" />
                                    <path d="M434.75 1098.25H1.25V1137.75H434.75V1098.25Z" fill="white" />
                                    <path d="M434.75 1098.25H1.25V1137.75H434.75V1098.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 1098H435V1138H536.5V1098Z" fill="#EFF6FF" />
                                    <path d="M637.75 1098.25H536.75V1137.75H637.75V1098.25Z" fill="white" />
                                    <path d="M637.75 1098.25H536.75V1137.75H637.75V1098.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M434.75 1138.25H1.25V1177.75H434.75V1138.25Z" fill="white" />
                                    <path d="M434.75 1138.25H1.25V1177.75H434.75V1138.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 1138.25H435.25V1177.75H536.25V1138.25Z" fill="white" />
                                    <path d="M536.25 1138.25H435.25V1177.75H536.25V1138.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 1138H536.5V1178H638V1138Z" fill="#EFF6FF" />
                                    <path d="M434.75 1178.25H1.25V1217.75H434.75V1178.25Z" fill="white" />
                                    <path d="M434.75 1178.25H1.25V1217.75H434.75V1178.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.25 1178.25H435.25V1217.75H536.25V1178.25Z" fill="white" />
                                    <path d="M536.25 1178.25H435.25V1217.75H536.25V1178.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 1178H536.5V1218H638V1178Z" fill="#EFF6FF" />
                                    <path d="M434.75 1218.25H1.25V1257.75H434.75V1218.25Z" fill="white" />
                                    <path d="M434.75 1218.25H1.25V1257.75H434.75V1218.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 1218H435V1258H536.5V1218Z" fill="#EFF6FF" />
                                    <path d="M637.75 1218.25H536.75V1257.75H637.75V1218.25Z" fill="white" />
                                    <path d="M637.75 1218.25H536.75V1257.75H637.75V1218.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M434.75 1258.25H1.25V1297.75H434.75V1258.25Z" fill="white" />
                                    <path d="M434.75 1258.25H1.25V1297.75H434.75V1258.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M536.5 1258H435V1298H536.5V1258Z" fill="#EFF6FF" />
                                    <path d="M637.75 1258.25H536.75V1297.75H637.75V1258.25Z" fill="white" />
                                    <path d="M637.75 1258.25H536.75V1297.75H637.75V1258.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M1.25 1298.25H434.75V1337.75H7C3.82436 1337.75 1.25 1335.18 1.25 1332V1298.25Z" fill="white" />
                                    <path d="M1.25 1298.25H434.75V1337.75H7C3.82436 1337.75 1.25 1335.18 1.25 1332V1298.25Z" stroke="#F5F5F5"
                                        stroke-width="0.5" />
                                    <path d="M536.25 1298.25H435.25V1337.75H536.25V1298.25Z" fill="white" />
                                    <path d="M536.25 1298.25H435.25V1337.75H536.25V1298.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                                    <path d="M638 1298H536.5V1338H638V1298Z" fill="#EFF6FF" />
                                    <path d="M638 970H713C716.314 970 719 972.686 719 976V1332C719 1335.31 716.314 1338 713 1338H638V970Z"
                                        fill="white" />
                                    <path d="M638 970H713C716.314 970 719 972.686 719 976V1332C719 1335.31 716.314 1338 713 1338H638V970Z"
                                        fill="#002852" fill-opacity="0.08" />
                                    <rect x="461" y="49" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="49" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="93" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="93" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="93" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="133" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="133" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="133" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="173" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="173" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="173" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="649" y="85" width="60" height="90" fill="#D9D9D9" />
                                    <rect width="94" height="20" fill="#D9D9D9" />
                                    <rect y="248" width="145" height="20" fill="#D9D9D9" />
                                    <rect y="277" width="705" height="20" fill="#D9D9D9" />
                                    <rect x="461" y="343" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="343" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="387" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="387" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="387" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="427" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="427" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="427" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="467" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="467" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="467" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="649" y="379" width="60" height="90" fill="#D9D9D9" />
                                    <rect y="908" width="145" height="20.5858" fill="#D9D9D9" />
                                    <rect y="937.849" width="705" height="20.5858" fill="#D9D9D9" />
                                    <rect x="461" y="985.782" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="985.782" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1028.07" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1028.07" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1028.07" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1068.24" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1068.24" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1068.24" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1108.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1108.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1108.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1148.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1148.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1148.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1188.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1188.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1188.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1228.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1228.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1228.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1268.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1268.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1268.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="9" y="1308.41" width="270" height="20.5858" fill="#D9D9D9" />
                                    <rect x="462" y="1308.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="562" y="1308.41" width="50" height="20.5858" fill="#D9D9D9" />
                                    <rect x="649" y="1102.84" width="60" height="92.636" fill="#D9D9D9" />
                                    <rect y="545" width="145" height="20" fill="#D9D9D9" />
                                    <rect y="574" width="705" height="20" fill="#D9D9D9" />
                                    <rect x="461" y="620" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="620" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="671" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="671" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="671" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="734" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="734" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="734" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="9" y="806" width="270" height="20" fill="#D9D9D9" />
                                    <rect x="462" y="806" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="562" y="806" width="50" height="20" fill="#D9D9D9" />
                                    <rect x="649" y="688" width="60" height="90" fill="#D9D9D9" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_10_996">
                                        <rect width="720" height="1339" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>

                <div id="news_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">News</h2>
                        <div class="separator_line"></div>
                        <div id="news_content"></div>
                        <div class="svg_skeleton" id="news_skeleton">
                            <svg width="714" height="303" viewBox="0 0 714 303" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_11_1406)">
                                    <path
                                        d="M32 3H12C6.47715 3 2 7.13501 2 12.2358V30.7074C2 35.8082 6.47715 39.9432 12 39.9432H32C37.5228 39.9432 42 35.8082 42 30.7074V12.2358C42 7.13501 37.5228 3 32 3Z"
                                        fill="#D9D9D9" />
                                    <rect x="54" y="3.27295" width="600" height="20" fill="#D9D9D9" />
                                    <rect x="54" y="30.2729" width="658" height="30" fill="#D9D9D9" />
                                    <rect x="54" y="68.2729" width="280" height="20" fill="#D9D9D9" />
                                    <path d="M2 99.2729H726V100.197H2V99.2729Z" fill="#F4F7FE" />
                                    <path
                                        d="M32 111.197H12C6.47715 111.197 2 115.332 2 120.432V138.904C2 144.005 6.47715 148.14 12 148.14H32C37.5228 148.14 42 144.005 42 138.904V120.432C42 115.332 37.5228 111.197 32 111.197Z"
                                        fill="#D9D9D9" />
                                    <rect x="54" y="111.469" width="600" height="20" fill="#D9D9D9" />
                                    <rect x="54" y="138.469" width="658" height="30" fill="#D9D9D9" />
                                    <rect x="54" y="176.469" width="280" height="20" fill="#D9D9D9" />
                                    <path d="M2 207.469H726V208.393H2V207.469Z" fill="#F4F7FE" />
                                    <path
                                        d="M32 219.393H12C6.47715 219.393 2 223.528 2 228.629V247.1C2 252.201 6.47715 256.336 12 256.336H32C37.5228 256.336 42 252.201 42 247.1V228.629C42 223.528 37.5228 219.393 32 219.393Z"
                                        fill="#D9D9D9" />
                                    <rect x="54" y="219.666" width="600" height="20" fill="#D9D9D9" />
                                    <rect x="54" y="246.666" width="658" height="30" fill="#D9D9D9" />
                                    <rect x="54" y="284.666" width="280" height="20" fill="#D9D9D9" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_11_1406">
                                        <rect width="714" height="303" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>
                <?php get_template_part('template-parts/stocks-details/discover'); ?>
                <?php get_template_part('template-parts/stocks-details/faqs', null, array('overview_data' => $overview_data)); ?>
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
<?php get_template_part('template-parts/stocks-details/js/store-stocks-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/price-chart-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/analyst-forecast-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/returns-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/financial-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/ratios-js'); ?>
<?php get_template_part('template-parts/stocks-details/js/news-js'); ?>

<?php get_footer(); ?>