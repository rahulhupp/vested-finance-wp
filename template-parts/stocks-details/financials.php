<?php 
    $income_statement_data = $args['income_statement_data']; 
    $balance_sheet_data = $args['balance_sheet_data'];
    $cash_flow_data = $args['cash_flow_data'];
?>
<?php if($income_statement_data && $balance_sheet_data && $cash_flow_data) { ?>
    <div id="financials_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">Financials</h2>
            <div class="separator_line"></div>
            <div class="financials_box_header">
                <div class="stock_box_tab_container">
                    <button class="stock_box_tab_button active" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab1', this)">Income Statement</button>
                    <button class="stock_box_tab_button" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab2', this)">Balance Sheet</button>
                    <button class="stock_box_tab_button" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab3', this)">Cash Flow</button>
                </div>
                <div class="financials_select_container">
                    <select id="value_type_select">
                        <option value="growth">Growth</option>
                        <option value="absolute" selected>Absolute</option>
                    </select>

                    <select id="data_type_select">
                        <option value="quarter">Quarterly</option>
                        <option value="annual" selected>Annual</option>
                    </select>
                </div>
            </div>
            <div id="financials_tab_tab1" class="stock_box_tab_content">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper data_display">
                        <?php
                            function incomeStatementPrintTable($header_items, $body_items, $type, $visible) {
                                $visibility_class = $visible ? '' : 'hidden';
                                echo "<div class=\"stock_details_table financial_table $type $visibility_class\">";
                                echo "<table>";
                                echo "<tr><th></th>";
                                foreach ($header_items as $item) {
                                    echo "<th>{$item['label']}</th>";
                                }
                                echo "</tr>";
                                foreach ($body_items as $parent_item) {
                                    $years = [];
                                    foreach ($parent_item['data'] as $item) {
                                        foreach ($item as $key => $value) {
                                            if (is_numeric($key) || preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                                                $years[$key] = true;
                                            }
                                        }
                                    }
                                    ksort($years);
                                    foreach ($parent_item['data'] as $item) {
                                        echo "<tr>";
                                        echo "<td class='". ($item['highlight'] ? "highlighted-info" : "") ."'>" . $item['info'] . "</td>";
                                        foreach ($years as $year => $_) {
                                            echo "<td>";
                                            if (isset($item[$year])) {
                                                if ($type === 'quarter_growth' || $type === 'annual_growth') {
                                                    echo $item[$year]['change']['value'];
                                                } else {
                                                    echo $item[$year]['number']['value'];
                                                }
                                            }
                                            echo "</td>";
                                        }
                                        echo "<td class='trend_chart'>";
                                        echo json_encode($item['trend'][$type === 'quarter_growth' || $type === 'annual_growth' ? 'change' : 'number']);
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                }
                                echo "</table></div>";
                            }

                            if ($income_statement_data) {
                                $income_statement_exclude_keys = array("info", "trend");
                                $income_statement_annual_header_items = array_filter($income_statement_data['meta']['header']['annual'], function($item) use ($income_statement_exclude_keys) {
                                    return !in_array($item['key'], $income_statement_exclude_keys);
                                });
                                usort($income_statement_annual_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $income_statement_annual_trend_label = $income_statement_data['meta']['header']['annual'][6];
                                array_push($income_statement_annual_header_items, $income_statement_annual_trend_label);
                                $income_statement_annual_body_items = $income_statement_data['data']['annual'];

                                incomeStatementPrintTable($income_statement_annual_header_items, $income_statement_annual_body_items, 'annual_absolute', true);
                                incomeStatementPrintTable($income_statement_annual_header_items, $income_statement_annual_body_items, 'annual_growth', false);

                                $income_statement_quarter_header_items = array_filter($income_statement_data['meta']['header']['quarter'], function($item) use ($income_statement_exclude_keys) {
                                    return !in_array($item['key'], $income_statement_exclude_keys);
                                });
                                usort($income_statement_quarter_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $income_statement_quarter_trend_label = $income_statement_data['meta']['header']['quarter'][6];
                                array_push($income_statement_quarter_header_items, $income_statement_quarter_trend_label);
                                $income_statement_quarter_body_items = $income_statement_data['data']['quarter'];

                                incomeStatementPrintTable($income_statement_quarter_header_items, $income_statement_quarter_body_items, 'quarter_absolute', false);
                                incomeStatementPrintTable($income_statement_quarter_header_items, $income_statement_quarter_body_items, 'quarter_growth', false);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div id="financials_tab_tab2" class="stock_box_tab_content hidden">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper data_display">
                        <?php
                            function balanceSheetPrintTable($header_items, $body_items, $type, $visible) {
                                $visibility_class = $visible ? '' : 'hidden';
                                echo "<div class=\"stock_details_table financial_table $type $visibility_class\">";
                                echo "<table>";
                                echo "<tr><th></th>";
                                foreach ($header_items as $item) {
                                    echo "<th>{$item['label']}</th>";
                                }
                                echo "</tr>";
                                foreach ($body_items as $parent_item) {
                                    if (isset($parent_item['section'])) {
                                        echo "<tr>";
                                        echo "<td class='highlighted-info'>" . $parent_item['section'] . "</td>";
                                        echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
                                        echo "</tr>";
                                    }

                                    $years = [];
                                    foreach ($parent_item['data'] as $item) {
                                        foreach ($item as $key => $value) {
                                            if (is_numeric($key) || preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                                                $years[$key] = true;
                                            }
                                        }
                                    }
                                    ksort($years);
                                    foreach ($parent_item['data'] as $item) {
                                        echo "<tr>";
                                        echo "<td class='". ($item['highlight'] ? "highlighted-info" : "") ."'>" . $item['info'] . "</td>";
                                        foreach ($years as $year => $_) {
                                            echo "<td>";
                                            if (isset($item[$year])) {
                                                if ($type === 'quarter_growth' || $type === 'annual_growth') {
                                                    echo $item[$year]['change']['value'];
                                                } else {
                                                    echo $item[$year]['number']['value'];
                                                }
                                            }
                                            echo "</td>";
                                        }
                                        echo "<td class='trend_chart'>";
                                        echo json_encode($item['trend'][$type === 'quarter_growth' || $type === 'annual_growth' ? 'change' : 'number']);
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                }
                                echo "</table></div>";
                            }

                            if ($balance_sheet_data) {
                                $balance_sheet_exclude_keys = array("info", "trend");
                                $balance_sheet_annual_header_items = array_filter($balance_sheet_data['meta']['header']['annual'], function($item) use ($balance_sheet_exclude_keys) {
                                    return !in_array($item['key'], $balance_sheet_exclude_keys);
                                });
                                usort($balance_sheet_annual_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $balance_sheet_annual_trend_label = $balance_sheet_data['meta']['header']['annual'][6];
                                array_push($balance_sheet_annual_header_items, $balance_sheet_annual_trend_label);
                                $balance_sheet_annual_body_items = $balance_sheet_data['data']['annual'];

                                balanceSheetPrintTable($balance_sheet_annual_header_items, $balance_sheet_annual_body_items, 'annual_absolute', true);
                                balanceSheetPrintTable($balance_sheet_annual_header_items, $balance_sheet_annual_body_items, 'annual_growth', false);

                                $balance_sheet_quarter_header_items = array_filter($balance_sheet_data['meta']['header']['quarter'], function($item) use ($balance_sheet_exclude_keys) {
                                    return !in_array($item['key'], $balance_sheet_exclude_keys);
                                });
                                usort($balance_sheet_quarter_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $balance_sheet_quarter_trend_label = $balance_sheet_data['meta']['header']['quarter'][6];
                                array_push($balance_sheet_quarter_header_items, $balance_sheet_quarter_trend_label);
                                $balance_sheet_quarter_body_items = $balance_sheet_data['data']['quarter'];

                                balanceSheetPrintTable($balance_sheet_quarter_header_items, $balance_sheet_quarter_body_items, 'quarter_absolute', false);
                                balanceSheetPrintTable($balance_sheet_quarter_header_items, $balance_sheet_quarter_body_items, 'quarter_growth', false);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div id="financials_tab_tab3" class="stock_box_tab_content hidden">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper data_display">
                        <?php
                            function cashFlowPrintTable($header_items, $body_items, $type, $visible) {
                                $visibility_class = $visible ? '' : 'hidden';
                                echo "<div class=\"stock_details_table financial_table $type $visibility_class\">";
                                echo "<table>";
                                echo "<tr><th></th>";
                                foreach ($header_items as $item) {
                                    echo "<th>{$item['label']}</th>";
                                }
                                echo "</tr>";
                                foreach ($body_items as $parent_item) {
                                    if (isset($parent_item['section'])) {
                                        echo "<tr>";
                                        echo "<td class='highlighted-info'>" . $parent_item['section'] . "</td>";
                                        echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
                                        echo "</tr>";
                                    }
                                    $years = [];
                                    foreach ($parent_item['data'] as $item) {
                                        foreach ($item as $key => $value) {
                                            if (is_numeric($key) || preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                                                $years[$key] = true;
                                            }
                                        }
                                    }
                                    ksort($years);
                                    foreach ($parent_item['data'] as $item) {
                                        echo "<tr>";
                                        echo "<td class='". ($item['highlight'] ? "highlighted-info" : "") ."'>" . $item['info'] . "</td>";
                                        foreach ($years as $year => $_) {
                                            echo "<td>";
                                            if (isset($item[$year])) {
                                                if ($type === 'quarter_growth' || $type === 'annual_growth') {
                                                    echo $item[$year]['change']['value'];
                                                } else {
                                                    echo $item[$year]['number']['value'];
                                                }
                                            }
                                            echo "</td>";
                                        }
                                        echo "<td class='trend_chart'>";
                                        echo json_encode($item['trend'][$type === 'quarter_growth' || $type === 'annual_growth' ? 'change' : 'number']);
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                }
                                echo "</table></div>";
                            }

                            if ($cash_flow_data) {
                                $cash_flow_exclude_keys = array("info", "trend");
                                $cash_flow_annual_header_items = array_filter($cash_flow_data['meta']['header']['annual'], function($item) use ($cash_flow_exclude_keys) {
                                    return !in_array($item['key'], $cash_flow_exclude_keys);
                                });
                                usort($cash_flow_annual_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $cash_flow_annual_trend_label = $cash_flow_data['meta']['header']['annual'][6];
                                array_push($cash_flow_annual_header_items, $cash_flow_annual_trend_label);
                                $cash_flow_annual_body_items = $cash_flow_data['data']['annual'];

                                cashFlowPrintTable($cash_flow_annual_header_items, $cash_flow_annual_body_items, 'annual_absolute', true);
                                cashFlowPrintTable($cash_flow_annual_header_items, $cash_flow_annual_body_items, 'annual_growth', false);

                                $cash_flow_quarter_header_items = array_filter($cash_flow_data['meta']['header']['quarter'], function($item) use ($cash_flow_exclude_keys) {
                                    return !in_array($item['key'], $cash_flow_exclude_keys);
                                });
                                usort($cash_flow_quarter_header_items, function($a, $b) {
                                    return strcmp($a['key'], $b['key']);
                                }); 
                                $cash_flow_quarter_trend_label = $cash_flow_data['meta']['header']['quarter'][6];
                                array_push($cash_flow_quarter_header_items, $cash_flow_quarter_trend_label);
                                $cash_flow_quarter_body_items = $cash_flow_data['data']['quarter'];

                                cashFlowPrintTable($cash_flow_quarter_header_items, $cash_flow_quarter_body_items, 'quarter_absolute', false);
                                cashFlowPrintTable($cash_flow_quarter_header_items, $cash_flow_quarter_body_items, 'quarter_growth', false);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>