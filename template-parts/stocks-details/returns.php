<?php $returns_data = $args['returns_data']; ?>
<?php if ($returns_data) { ?>
    <div id="returns_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">Returns</h2>
            <div class="separator_line"></div>
            <div class="stock_box_tab_container">
                <button class="stock_box_tab_button active" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab1', this)">Absolute returns</button>
                <button class="stock_box_tab_button" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab2', this)">Annualized returns</button>
            </div>
            <div id="returns_tab_tab1" class="stock_box_tab_content">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper">
                        <div id="absolute_returns_table" class="stock_details_table">
                            <?php
                                if ($returns_data) {
                                    echo "<table id='ab_returns_table'>";
                                    echo "<tr>";
                                    if ($returns_data['timeFrames'] && isset($returns_data['timeFrames']['label'])) {
                                        echo "<th>{$returns_data['timeFrames']['label']}</th>";
                                    }
                                    if ($returns_data['current'] && isset($returns_data['current']['label'])) {
                                        echo "<th>{$returns_data['current']['label']}</th>";
                                    }
                                    if ($returns_data['sector'] && isset($returns_data['sector']['label'])) {
                                        echo "<th>{$returns_data['sector']['label']}</th>";
                                    }
                                    if ($returns_data['sp500'] && isset($returns_data['sp500']['label'])) {
                                        echo "<th>{$returns_data['sp500']['label']}</th>";
                                    }
                                    echo "</tr>";

                                
                                    foreach ($returns_data['timeFrames']['value'] as $timeFrame) {
                                        $key = $timeFrame['key'];
                                        $label = $timeFrame['label'];
                                        if ($returns_data['current'] && isset($returns_data['current']['label'])) {
                                            $stockValue = isset($returns_data['current']['value'][$key]['value']) ? $returns_data['current']['value'][$key]['value'] : "";
                                        }
                                        if ($returns_data['sector'] && isset($returns_data['sector']['label'])) {
                                            $sectorValue = isset($returns_data['sector']['value'][$key]['value']) ? $returns_data['sector']['value'][$key]['value'] : "";
                                        }
                                        if ($returns_data['sp500'] && isset($returns_data['sp500']['label'])) {
                                            $sp500Value = isset($returns_data['sp500']['value'][$key]['value']) ? $returns_data['sp500']['value'][$key]['value'] : "";
                                        }

                                        echo "<tr>";
                                        echo "<td>$label</td>";
                                        if ($stockValue) {
                                            echo "<td>$stockValue</td>";
                                        }
                                        if ($sectorValue) {
                                            echo "<td>$sectorValue</td>";
                                        }
                                        if ($sp500Value) {
                                            echo "<td>$sp500Value</td>";
                                        }
                                        echo "</tr>";
                                    }
                                
                                    echo "</table>";
                                }
                            ?>
                        </div>
                        <button class="stock_details_table_button" onclick="openModalAddTicker('absolute_returns')">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" />
                            <span>Add ticker to compare</span>
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
                                    echo "<tr>";
                                    if ($returns_data['timeFrames'] && isset($returns_data['timeFrames']['label'])) {
                                        echo "<th>{$returns_data['timeFrames']['label']}</th>";
                                    }
                                    if ($returns_data['current'] && isset($returns_data['current']['label'])) {
                                        echo "<th>{$returns_data['current']['label']}</th>";
                                    }
                                    if ($returns_data['sector'] && isset($returns_data['sector']['label'])) {
                                        echo "<th>{$returns_data['sector']['label']}</th>";
                                    }
                                    if ($returns_data['sp500'] && isset($returns_data['sp500']['label'])) {
                                        echo "<th>{$returns_data['sp500']['label']}</th>";
                                    }
                                    echo "</tr>";
                                    
                                    foreach ($returns_data['timeFrames']['value'] as $timeFrame) {
                                        $key = $timeFrame['key'];
                                        $label = $timeFrame['label'];
                                        if ($returns_data['current'] && isset($returns_data['current']['label'])) {
                                            $stockValue = isset($returns_data['current']['value'][$key]['value']) ? $returns_data['current']['value'][$key]['value'] : "";
                                        }
                                        if ($returns_data['sector'] && isset($returns_data['sector']['label'])) {
                                            $sectorValue = isset($returns_data['sector']['value'][$key]['value']) ? $returns_data['sector']['value'][$key]['value'] : "";
                                        }
                                        if ($returns_data['sp500'] && isset($returns_data['sp500']['label'])) {
                                            $sp500Value = isset($returns_data['sp500']['value'][$key]['value']) ? $returns_data['sp500']['value'][$key]['value'] : "";
                                        }

                                        $days = convertHeadingToDays($label);

                                        if ($stockValue) {
                                            $aaplNumericValue = floatval($stockValue);
                                            $stockValue = ((((1 + ($aaplNumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                            $stockValue = number_format($stockValue, 2);
                                        }

                                        if ($sectorValue) {
                                            $sectorNumericValue = floatval($sectorValue);
                                            $sectorValue = ((((1 + ($sectorNumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                            $sectorValue = number_format($sectorValue, 2);
                                        }
                                        
                                        if ($sp500Value) {
                                            $sp500NumericValue = floatval($sp500Value);
                                            $sp500Value = ((((1 + ($sp500NumericValue / 100)) ** (365 / $days)) - 1) * 100);
                                            $sp500Value = number_format($sp500Value, 2);
                                        }

                                        echo "<tr>";
                                        echo "<td>$label</td>";
                                        if ($stockValue) {
                                            echo "<td>$stockValue%</td>";
                                        }
                                        if ($sectorValue) {
                                            echo "<td>$sectorValue%</td>";
                                        }
                                        if ($sp500Value) {
                                            echo "<td>$sp500Value%</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    
                                    echo "</table>";
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
<?php } ?>