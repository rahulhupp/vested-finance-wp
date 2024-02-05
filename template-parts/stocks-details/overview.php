<div id="overview_tab" class="tab_content">
    <div class="stock_details_box stock_chart_container">
        <div class="stock_chart_header">
            <h2 class="heading">Price Chart</h2>
            <div class="stock_chart_buttons">
                <button onclick="callChartApi('1D', '')">1D</button>
                <button onclick="callChartApi('1W', '')">1W</button>
                <button onclick="callChartApi('1M', '')">1M</button>
                <button onclick="callChartApi('6M', 'daily')">6M</button>
                <button class="active" onclick="callChartApi('1Y', 'daily')">1Y</button>
                <button onclick="callChartApi('5Y', 'daily')">5Y</button>
                <button onclick="openACModal('advanced_chart')">Advanced Chart</button>
            </div>
        </div>
        <div class="separator_line"></div>
        <div class="chart_container">
            <canvas id="myLineChart" width="400" height="200"></canvas>
            <div id="verticalLine"></div>
            <div id="customTooltip"></div>
            <div id="chart_loader_container" class="chart_loader_container">
                <span class="chart_loader"></span>
            </div>
        </div>
    </div>

    <div class="stock_details_box stock_metrics_container">
        <h2 class="heading">Key Metrics</h2>
        <div class="separator_line"></div>
        <div class="stock_metrics_wrapper">
            <div class="stock_metrics_keyvalue">
            <div class="stock_summary">
                <div class="stock_summary_item">
                    <span>
                        Market Cap
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This is a company’s total value as determined by the stock market. It is calculated by multiplying the total number of a company's outstanding shares by the current market price of one share.</div>
                    </span>
                    <strong id="market_cap"></strong>
                </div>
                <div class="stock_summary_item">
                    <span>
                        P/E Ratio
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This is the ratio of a security’s current share price to its earnings per share. This ratio determines the relative value of a company’s share.</div>
                    </span>
                    <strong id="pe_ratio"></strong>
                </div>
                <div class="stock_summary_item">
                    <span>
                        Volume
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This is the total number of shares traded during the most recent trading day.</div>
                    </span>
                    <strong id="volume"></strong>
                </div>
                <div class="stock_summary_item">
                    <span>
                        Avg Volume
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This is the average number of shares traded during the most recent 30 days.</div>
                    </span>
                    <strong id="avg_volume"></strong>
                </div>
                <div class="stock_summary_item">
                    <span>
                        Dividend Yield
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This ratio shows how much income you earn in dividend payouts per year for every dollar invested in the stock (or the stock’s annual dividend payment expressed as a percentage of its current price).</div>
                    </span>
                    <strong id="dividend_yield"></strong>
                </div>
                <div class="stock_summary_item">
                    <span>
                        Beta
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                        <div class="info_text">This measures the expected move in a stock’s price relative to movements in the overall market. The market, such as the S&P 500 Index, has a beta of 1.0. If a stock has a Beta greater (or lower) than 1.0, it suggests that the stock is more (or less) volatile than the broader market.</div>
                    </span>
                    <strong id="beta"></strong>
                </div>
            </div>
            </div>
            <div class="stock_metrics_range">
                <h6>
                    <span>52-week Range</span>
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                    <div class="info_text">This shows the range of the stock’s price between the 52-week high (the highest price of the stock for the past 52 weeks) and the 52-week low (the lowest price of the stock for the past 52 weeks).</div>
                </h6>
                <div class="range_container">
                    <div class="range_item range_low">
                        <span id="range_low"></span>
                        <strong>L</strong>
                    </div>
                    <div class="range_item range_high">
                        <span id="range_high"></span>
                        <strong>H</strong>
                    </div>
                    <div class="float_range_item">
                        <div class="float_range" id="range_current_percentage">
                            <span id="range_current"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stock_details_box stock_about_container">
        <h2 id="stock_about_title" class="heading"></h2>
        <div class="separator_line"></div>
        <div class="stock_about_wrapper">
            <p id="stock_about_description" class="stock_about_description"></p>
        </div>
        <div id="stock_about_tags" class="stock_tags"></div>
    </div>
</div>