<?php 
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $overview_data = fetch_overview_api_data($symbol, $token);
?>
<?php
    // Check if response is successful
    if ($overview_data) {
        $summary = $overview_data->summary;

        function getValueByLabel($summary, $label) {
            foreach ($summary as $item) {
                if ($item->label === $label) {
                    return $item->value;
                }
            }
            return ''; // Return empty string if label not found
        }

        $marketCapValue = getValueByLabel($summary, "Market Cap");
        $peRatio = getValueByLabel($summary, "P/E Ratio");
        $volumeValue = getValueByLabel($summary, "Volume");
        $avgVolumeValue = getValueByLabel($summary, "Avg Volume");
        $betaValue = getValueByLabel($summary, "Beta");
        $dividendYieldValue = getValueByLabel($summary, "Dividend Yield");
        $rangeItem = null;
        foreach ($summary as $item) {
            if ($item->label === "52-Week Range") {
                $rangeItem = $item;
                break;
            }
        }
        $lowRange = isset($rangeItem->raw->low) ? $rangeItem->raw->low : '';
        $highRange = isset($rangeItem->raw->high) ? $rangeItem->raw->high : '';
        $price = $overview_data->price;
        $rangePercentage = (($price - $lowRange) / ($highRange - $lowRange)) * 100;

        $aboutTitle = 'About ' . $overview_data->name . ', ' . $overview_data->type;
        $limitedDescription = substr($overview_data->description, 0, 250); // Assuming 100 characters limit
        $aboutTagsHTML = '';
        foreach ($overview_data->tags as $tag) {
            $aboutTagsHTML .= '<span>' . $tag->label . ': ' . $tag->value . '</span>';
        }

?>
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
                            <strong><?php echo $marketCapValue; ?></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                P/E Ratio
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">This is the ratio of a security’s current share price to its earnings per share. This ratio determines the relative value of a company’s share.</div>
                            </span>
                            <strong><?php echo $peRatio; ?></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Volume
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">This is the total number of shares traded during the most recent trading day.</div>
                            </span>
                            <strong><?php echo $volumeValue; ?></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Avg Volume
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">This is the average number of shares traded during the most recent 30 days.</div>
                            </span>
                            <strong><?php echo $avgVolumeValue; ?></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Dividend Yield
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">This ratio shows how much income you earn in dividend payouts per year for every dollar invested in the stock (or the stock’s annual dividend payment expressed as a percentage of its current price).</div>
                            </span>
                            <strong><?php echo $dividendYieldValue; ?></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Beta
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">This measures the expected move in a stock’s price relative to movements in the overall market. The market, such as the S&P 500 Index, has a beta of 1.0. If a stock has a Beta greater (or lower) than 1.0, it suggests that the stock is more (or less) volatile than the broader market.</div>
                            </span>
                            <strong><?php echo $betaValue; ?></strong>
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
                            <span><?php echo '$' . $lowRange; ?></span>
                            <strong>L</strong>
                        </div>
                        <div class="range_item range_high">
                            <span><?php echo '$' . $highRange; ?></span>
                            <strong>H</strong>
                        </div>
                        <div class="float_range_item">
                            <div class="float_range" style="left: calc(<?php echo $rangePercentage; ?>% - 28px);">
                                <span><?php echo '$' . $price; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stock_details_box stock_about_container">
            <h2 class="heading"><?php echo $aboutTitle; ?></h2>
            <div class="separator_line"></div>
            <div class="stock_about_wrapper">
                <p id="stock_about_description" class="stock_about_description"><?php echo $limitedDescription; ?>...<span onclick="showMore('<?php echo $overview_data->description; ?>')">more</span></p>
            </div>
            <div class="stock_tags"><?php echo $aboutTagsHTML; ?></div>
        </div>
    </div>

<?php
} else {
    echo "Error retrieving data"; // Handle error
}
?>
<script>
    function showMore(description) {
        document.getElementById('stock_about_description').innerHTML = description;
    }
</script>