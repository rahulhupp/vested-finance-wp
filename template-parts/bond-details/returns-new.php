<?php
    $bond = $args['bond'];
    if ($bond) {
        ?>
            <div id="returns_tab" class="tab_content">
                <div class="stock_details_box stock_chart_container">
                    <div class="stock_chart_header">
                        <h2 class="heading">2 Know Your Returns</h2>
                    </div>
                    <div class="separator_line"></div>
                    <div class="returns_unit_number">
                        <div class="returns_qty_wrap">
                            <div class="returns_qty_inner_wrap">
                                <label for="">Number of Units</label>
                                <div class="qty_stepper">
                                    <button class="qty_button qty_minus">-</button>
                                    <input type="number" value="1" min="0" max="5">
                                    <button class="qty_button qty_plus">+</button>
                                </div>
                            </div>
                            <div class="bonds_returns_note mobile_hide">
                                <h3>Earn <span class="bonds_return_amt highlighted">-</span> in <span class="maturity">-</span> at <span class="bonds_return_per">-</span> p.a</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>