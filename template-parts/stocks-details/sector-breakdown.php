<?php 
    $sector_breakdowns_data = $args['sector_breakdowns_data'];
    $colors = array(
        '#EA580C',
        '#C026D3',
        '#7C3AED',
        '#2563EB',
        '#E11D48',
        '#047857'
    );
    for ($i = 0; $i < count($sector_breakdowns_data); $i++) {
        $sector_breakdowns_data[$i]['color'] = $colors[$i];
    }
?>
<div id="sector_breakdown_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Sector Breakdown</h2>
        <div class="separator_line"></div>
        <div class="sector_breakdown_section">
            <div class="sector_breakdown_table_wrapper">
                <div class="stock_details_table_container">
                    <div class="stock_details_table_wrapper">
                        <div class="stock_details_table full_width_table">
                            <table id="sectorBreakdownTable">
                                <tr>
                                    <th>Sector</th>
                                    <th>Weight</th>
                                </tr>
                                <?php
                                    foreach ($sector_breakdowns_data as $breakdown) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="sector_breakdown_name">
                                                        <span style="background-color: <?php echo $breakdown['color']; ?>"></span>
                                                        <?php echo $breakdown['name']; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo number_format($breakdown['value'], 2); ?>%
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
            <div class="sector_breakdown_chart_wrapper">
                <canvas id="sectorBreakdownChart" width="234" height="234"></canvas>
            </div>
        </div>
    </div>
</div>
