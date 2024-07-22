<div id="returns_tab" class="tab_content">
        <div class="stock_details_box stock_chart_container">
            <div class="stock_chart_header">
                <h2 class="heading">Know Your Returns</h2>
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
                <div class="bonds_returns_data">
                    <div class="returns_data_wrap">
                    <div class="bond_investment_info">
                        <div class="single_invest_info">
                            <p>You Invest</p>
                            <h4 class="highlighted" id="bond_invest_amt">-</h4>
                        </div>
                        <div class="single_invest_info">
                            <p>You Receive</p>
                            <h4 class="highlighted" id="bond_receive_amt">-</h4>
                        </div>
                        <div class="single_invest_info">
                            <p>Average. Interest Payout</p>
                            <h4 class="highlighted" id="bond_avg_interest">-</h4>
                        </div>
                    </div>
                    <div class="bonds_returns_note desktop_hide">
                        <h3>Earn <span class="bonds_return_amt highlighted">-</span> in <span class="maturity">-</span> at <span class="bonds_return_per">-</span> p.a</h3>
                    </div>
                    <div class="potential_chart_col">
                        <div class="bond_chart_temp">
                            <h3>Potential Returns</h3>
                            <div class="potential_returns_graph">
                                <canvas id="bondReturnsGraph"
                                    width="324"
                                    height="105">
                                </canvas>
                                </div>
                                <div class="chart_lables">
                                    <div class="single_label">
                                        <p>You Invest</p>
                                        <h5 id="chart_invest_val">₹21,150</h5>
                                    </div>
                                    <div class="single_label">
                                        <p>Bank FD*</p>
                                        <h5 id="chart_fd_val">₹22,150</h5>
                                    </div>
                                    <div class="single_label">
                                        <p>Bond</p>
                                        <h5 id="chart_bond_val">₹24,150</h5>
                                    </div>
                                </div>
                                <span>*FD rate data sourced from State Bank of India. </span>
                            </div>
                        
                        </div>
                    </div>
                    
                </div>
                <div class="separator_line"></div>

                <div class="view_more_content">
                    <p class="view_more_btn"><span>View</span> cash flow details <i class="fa fa-chevron-down" aria-hidden="true"></i></p>

                    <div class="cashflow_content">
                        <div class="cashflow_inner_wrapper">
                            <div class="cashflow_row">
                                <div class="single_cashflow">
                                    <div class="cashflow_single_name">
                                        <h4>You Invest</h4>
                                        <p id="cashflow-initial-date">10 May ‘24</p>
                                    </div>
                                    <div class="cashflow_numbers">
                                        <h3 id="cashflow-inveset">₹21,150</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="principal_amt_block">
                                <div class="pricipal_amt_row">
                                    <h4>Principal Amount(Last traded price) <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" /></h4>
                                    <p id="cashflow-pricipal">₹20,150</p>
                                </div>
                                <div class="pricipal_amt_row">
                                    <h4>Accrued Interest <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" /></h4>
                                    <p id="cashflow-accured-interest">₹1,000</p>
                                </div>
                            </div>
                            <div class="separator_line smaller_margins"></div>
                            <div class="interest_payment_block">
                                <div class="single_interest_payment">
                                    <div class="interest_single_name">
                                        <h4>Interest Payment (<span id="interest_pay_frequency">Monthly</span>)</h4>
                                    </div>
                                </div>
                                <div class="single_interest_payment">
                                    <div class="interest_single_name">
                                        <p id="cashflow-first-date">10 Jun ‘24</p>
                                    </div>
                                    <div class="interest_numbers">
                                        <h3 id="cashflow-first-interest">₹850</h3>
                                        <div class="interest_link">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="12" fill="#F0FDF4"/>
                                                <path d="M14.75 8.25003L7.25 15.75" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.75 15.75H7.25V8.25003" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator_line smaller_margins"></div>
                                <div class="single_interest_payment">
                                    <div class="interest_single_name">
                                        <p id="cashflow-second-date">10 Jun ‘24</p>
                                    </div>
                                    <div class="interest_numbers">
                                        <h3 id="cashflow-second-interest">₹850</h3>
                                        <div class="interest_link">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="12" fill="#F0FDF4"/>
                                                <path d="M14.75 8.25003L7.25 15.75" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.75 15.75H7.25V8.25003" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="vertical_dashed_divider">
                                    <svg width="2" height="21" viewBox="0 0 2 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="1" y1="1" x2="1" y2="20" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-dasharray="5 5"/>
                                    </svg>
                                </div>
                                <div class="single_interest_payment">
                                    <div class="interest_single_name">
                                        <p id="cashflow-second-last-date">10 Nov ‘25</p>
                                    </div>
                                    <div class="interest_numbers">
                                        <h3 id="cashflow-second-last-interest">₹850</h3>
                                        <div class="interest_link">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="12" fill="#F0FDF4"/>
                                                <path d="M14.75 8.25003L7.25 15.75" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.75 15.75H7.25V8.25003" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator_line smaller_margins"></div>
                                <div class="single_interest_payment">
                                    <div class="interest_single_name">
                                        <p id="cashflow-last-date">10 Dec ‘25</p>
                                    </div>
                                    <div class="interest_numbers">
                                        <h3 id="cashflow-last-interest">₹850</h3>
                                        <div class="interest_link">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="12" fill="#F0FDF4"/>
                                                <path d="M14.75 8.25003L7.25 15.75" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.75 15.75H7.25V8.25003" stroke="#16A34A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator_line smaller_margins"></div>
                                <div class="cashflow_row">
                                    <div class="single_cashflow">
                                        <div class="cashflow_single_name">
                                            <h4>Total Returns on</h4>
                                            <p id="redemption-date">10 Dec ‘25</p>
                                        </div>
                                        <div class="cashflow_numbers">
                                            <h3 id="cashflow-total-returns">₹24,550</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="principal_amt_block margin_b_none">
                                    <div class="pricipal_amt_row">
                                        <h4>Principal Payout <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" /></h4>
                                        <p class="bolder" id="cashflow-payout">₹21,150</p>
                                    </div>
                                    <div class="pricipal_amt_row">
                                        <h4>Total Interest Earned <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" /></h4>
                                        <p class="bolder" id="cashflow-interest-earned">₹3,400</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>