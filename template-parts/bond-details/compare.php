<div id="compare_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">Compare with other bonds</h2>
            <div class="separator_line"></div>
            <div id="returns_tab_tab1" class="stock_box_tab_content">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper">
                        <div id="absolute_returns_table" class="stock_details_table">
                            <table id='ab_returns_table'>
                                <tr>
                                    <th>Bond name</th>
                                    <th>Indiabulls Housing Finance Limited 03 Aug 2025</th>
                                    <th>Indiabulls Housing Finance Limited 03 Aug 2026</th>
                                    <th>Indiabulls Housing Finance Limited 03 Aug 2027</th>
                                </tr>
                                <tr>
                                    <td>Rating</td>
                                    <td class="highlighted">AAA</td>
                                    <td class="highlighted">AAA</td>
                                    <td class="highlighted">AA</td>
                                </tr>
                                <tr>
                                    <td>Min investment</td>
                                    <td>₹10,000</td>
                                    <td>₹10,000</td>
                                    <td>₹10,000</td>
                                </tr>
                                <tr>
                                    <td>Yield</td>
                                    <td>12.48%</td>
                                    <td>11.96%</td>
                                    <td>10.56%</td>
                                </tr>
                                <tr>
                                    <td>Matures in</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td>Interest Payment</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td>Face Value</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td>Coupon</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td>Security</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td>Seniority</td>
                                    <td>AAA</td>
                                    <td>AAA</td>
                                    <td>AA</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Selected</td>
                                    <td class="small_paddings"><a href="#" class="table_view_btn">View details</a></td>
                                    <td class="small_paddings"><a href="#" class="table_view_btn">View details</a></td>
                                </tr>
                            </table>
                        </div>
                        <button class="stock_details_table_button" onclick="openModalAddTicker('absolute_returns')">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" />
                            <span>Add bond to compare</span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="returns_tab_tab2" class="stock_box_tab_content hidden">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper">
                        <div id="annualized_returns_table" class="stock_details_table">
                            <?php
                                if ($returns_data) {
                                    if ($get_path[2] == 'etf') {
                                        function convertHeadingToDays($heading) {
                                            switch ($heading) {
                                                case '1-Week Return':
                                                    return 7;
                                                case '1-Month Return':
                                                    return 30;
                                                case '3-Month Return':
                                                    return 90;
                                                case '6-Month Return':
                                                    return 180;
                                                case '1-Year Return':
                                                    return 365;
                                                case '3-Year Return':
                                                    return 3 * 365;
                                                case '5-Year Return':
                                                    return 5 * 365;
                                                case '10-Year Return':
                                                    return 10 * 365;
                                                default:
                                                    return null; // Handle the case where the heading is not recognized
                                            }
                                        }
                                        
                                        echo "<table id='an_returns_table'>";
                                        echo "<tr><th>{$returns_data['timeFrames']['label']}</th><th>{$returns_data['current']['label']}</th><th>".htmlspecialchars($returns_data['sp500']['label'])."</th></tr>";
                                        
                                        foreach ($returns_data['timeFrames']['value'] as $timeFrame) {
                                            $key = $timeFrame['key'];
                                            $label = $timeFrame['label'];
                                            $stockValue = isset($returns_data['current']['value'][$key]['value']) ? $returns_data['current']['value'][$key]['value'] : "";
                                            $sp500Value = isset($returns_data['sp500']['value'][$key]['value']) ? $returns_data['sp500']['value'][$key]['value'] : "";
                                        
                                            // Convert numeric values and apply formula if they are not empty
                                            if ($stockValue && $sp500Value) {
                                                $aaplNumericValue = floatval($stockValue);
                                                $sp500NumericValue = floatval($sp500Value);
                                                
                                                $days = convertHeadingToDays($label);
                                                $stockValue = ((((1 + ($aaplNumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                                $sp500Value = ((((1 + ($sp500NumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                                $stockValue = number_format($stockValue, 2);
                                                $sp500Value = number_format($sp500Value, 2);
                                            }
                                        
                                            echo "<tr><td>$label</td><td>$stockValue%</td><td>$sp500Value%</td></tr>";
                                        }
                                        
                                        echo "</table>";
                                    } else {
                                        function convertHeadingToDays($heading) {
                                            switch ($heading) {
                                                case '1-Week Return':
                                                    return 7;
                                                case '1-Month Return':
                                                    return 30;
                                                case '3-Month Return':
                                                    return 90;
                                                case '6-Month Return':
                                                    return 180;
                                                case '1-Year Return':
                                                    return 365;
                                                case '3-Year Return':
                                                    return 3 * 365;
                                                case '5-Year Return':
                                                    return 5 * 365;
                                                case '10-Year Return':
                                                    return 10 * 365;
                                                default:
                                                    return null; // Handle the case where the heading is not recognized
                                            }
                                        }
                                        
                                        echo "<table id='an_returns_table'>";
                                        echo "<tr><th>{$returns_data['timeFrames']['label']}</th><th>{$returns_data['current']['label']}</th><th>{$returns_data['sector']['label']}</th><th>".htmlspecialchars($returns_data['sp500']['label'])."</th></tr>";
                                        
                                        foreach ($returns_data['timeFrames']['value'] as $timeFrame) {
                                            $key = $timeFrame['key'];
                                            $label = $timeFrame['label'];
                                            $stockValue = isset($returns_data['current']['value'][$key]['value']) ? $returns_data['current']['value'][$key]['value'] : "";
                                            $sectorValue = isset($returns_data['sector']['value'][$key]['value']) ? $returns_data['sector']['value'][$key]['value'] : "";
                                            $sp500Value = isset($returns_data['sp500']['value'][$key]['value']) ? $returns_data['sp500']['value'][$key]['value'] : "";
                                        
                                            // Convert numeric values and apply formula if they are not empty
                                            if ($stockValue && $sectorValue && $sp500Value) {
                                                $aaplNumericValue = floatval($stockValue);
                                                $sectorNumericValue = floatval($sectorValue);
                                                $sp500NumericValue = floatval($sp500Value);
                                                
                                                $days = convertHeadingToDays($label);
                                                $stockValue = ((((1 + ($aaplNumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                                $sectorValue = ((((1 + ($sectorNumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                                $sp500Value = ((((1 + ($sp500NumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                                $stockValue = number_format($stockValue, 2);
                                                $sectorValue = number_format($sectorValue, 2);
                                                $sp500Value = number_format($sp500Value, 2);
                                            }
                                        
                                            echo "<tr><td>$label</td><td>$stockValue%</td><td>$sectorValue%</td><td>$sp500Value%</td></tr>";
                                        }
                                        
                                        echo "</table>";
                                    }
                                    
                                }
                            ?>
                        </div>
                        <button class="stock_details_table_button" onclick="openModalAddTicker('annualized_returns')">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" />
                            <span>Add ticker to compare</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>