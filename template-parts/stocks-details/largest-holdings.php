<?php 
    $largest_holdings_data = $args['largest_holdings_data'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'stocks_list';
    $wpdb->query("SET SESSION group_concat_max_len = 100000");
    $symbols_concatenated = $wpdb->get_var("SELECT GROUP_CONCAT(symbol SEPARATOR ',') AS symbols FROM $table_name");
    $wpdb->query("SET SESSION group_concat_max_len = @@group_concat_max_len");
    $symbols = explode(',', $symbols_concatenated);
?>
<?php if ($largest_holdings_data['error'] != 1) { ?>
    <div id="largest_holdings_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">Largest Holdings</h2>
            <div class="separator_line"></div>
            <div class="largest_holdings_section">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper">
                        <div class="stock_details_table full_width_table">
                            <table>
                                <tr>
                                    <th>Stock name</th>
                                    <th>Ticker</th>
                                    <th>Weight</th>
                                </tr>
                                <?php
                                    foreach ($largest_holdings_data as $holdings) {
                                        $holdingTicker = preg_replace('/[^a-zA-Z0-9]/', '.', $holdings['ticker']);
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="holdings_stock_name">
                                                        <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/<?php echo $holdingTicker; ?>.png" alt="<?php echo $holdingTicker; ?>-img" class="holdings_image" />
                                                        <span><?php echo $holdings['name']; ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                        $symbol = strtolower($holdingTicker);
                                                        $name = strtolower($holdings['name']);
                                                        $name = str_replace([' ', ','], '-', $name);
                                                        $name = preg_replace('/[^a-zA-Z0-9\-]/', '', $name);
                                                        $name = preg_replace('/-+/', '-', $name);
                                                        $name = trim($name, '-');
                                                    ?>
                                                    <a <?php if (in_array($holdingTicker, $symbols)) { ?> href="<?php echo home_url(); ?>/us-stocks/<?php echo $symbol; ?>/<?php echo $name ?>-share-price/" <?php } ?> >
                                                        <?php echo $holdingTicker; ?>
                                                    </a>
                                                    
                                                </td>
                                                <td class="holdings_stock_weight_td">
                                                    <div class="holdings_stock_weight">
                                                        <span><?php echo $holdings['assetsPercent']; ?>%</span>
                                                        <div class="holdings_progress_bar">
                                                            <div class="holdings_progress" data-value="<?php echo $holdings['assetsPercent']; ?>"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        updateProgressBars();

        function updateProgressBars() {
            var progressBars = document.querySelectorAll('.holdings_progress');
            progressBars.forEach(function (progressBar) {
                var percentage = parseFloat(progressBar.dataset.value);
                var actualPercentage = percentage * 5;
                var threshold = 0.20 * 100;
                if (actualPercentage >= threshold) {
                    progressBar.style.width = '100%';
                } else {
                    var lastPercentage = (actualPercentage / threshold) * 100;
                    progressBar.style.width = lastPercentage + '%';
                }                
            });
        }
    </script>
<?php } ?>
