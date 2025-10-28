<?php
/*
Template name: Page - DSP Fund
*/
get_header();
$fund_access = get_field('disable_funds');
?>

<section class="nse-section">
    <div class="nse-container">
        <div class="nse-main-left-wrapper">
            <div class="nse-card">
                <div class="nse-logo">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vested-india-equity-opportunities-fund.png"
                        alt="Vested India Equity Opportunities Fund Logo">
                </div>
                <div class="nse-header-content">
                    <div class="nse-title">Vested India Equity Opportunities Fund</div>
                    <div class="nse-overview-section">
                        <div class="nse-overview-title">Overview</div>
                        <div class="nse-overview-grid">
                            <?php if ($fund_access == 'Yes'): ?>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Minimum Investment</span>
                                    <span class="nse-overview-value">$00,000</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Lock-in</span>
                                    <div class="nse-overview-value-wrapper">
                                        <span class="nse-overview-value">--</span>
                                        <span class="nse-overview-note">--</span>
                                    </div>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Performance Fee</span>
                                    <span class="nse-overview-value">--</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Total Expense Ratio</span>
                                    <span class="nse-overview-value">0%</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Fund Manager</span>
                                    <span class="nse-overview-value">--</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Administrator</span>
                                    <span class="nse-overview-value">--</span>
                                </div>
                                <div class="disabled-section">
                                    <div class="disabled-section-content">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="20" fill="#DBEAFE"/>
                                            <path d="M15 19V15C15 13.6739 15.5268 12.4021 16.4645 11.4645C17.4021 10.5268 18.6739 10 20 10C21.3261 10 22.5979 10.5268 23.5355 11.4645C24.4732 12.4021 25 13.6739 25 15V19M13 19H27C28.1046 19 29 19.8954 29 21V28C29 29.1046 28.1046 30 27 30H13C11.8954 30 11 29.1046 11 28V21C11 19.8954 11.8954 19 13 19Z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>Available after launch</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Minimum Investment</span>
                                    <span class="nse-overview-value">$50,000</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Lock-in</span>
                                    <div class="nse-overview-value-wrapper">
                                        <span class="nse-overview-value">None</span>
                                        <span class="nse-overview-note">(after exit window)</span>
                                    </div>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Performance Fee</span>
                                    <span class="nse-overview-value">None</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Total Expense Ratio</span>
                                    <span class="nse-overview-value">2%</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Fund Manager</span>
                                    <span class="nse-overview-value">Vested Finance Inc.</span>
                                </div>
                                <div class="nse-overview-item">
                                    <span class="nse-overview-label">Administrator</span>
                                    <span class="nse-overview-value">NAV Consulting, Inc</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($fund_access == 'Yes'): ?>
                        <a href="http://us.vestedfinance.com/en/us/offering-details/vested-equity-dsp?ctaClicked=true" target="_blank" class="nse-express-btn">
                            <span>Invest</span>
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 15L13 10L8 5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>          
                    <?php else: ?>
                        <a class="nse-express-btn" id="nseExpressBtn">
                        <span>
                            <?php
                            if (isset($_GET['cta'])) {
                                $cta = urldecode($_GET['cta']);
                                echo $cta;
                            } else {
                                echo 'Express Interest';
                            }
                            ?>
                        </span>

                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 15L13 10L8 5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"
                            stroke-linejoin="round" />
                        </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="nse-main-right-wrapper">
            <div class="nse-section-inner-block nse-overview">
                <div class="nse-overview-section">
                    <h2 class="nse-inner-section-title">Access Indian Equities in a Tax-Efficient Manner</h2>
                    <div class="nse-overview-desc">
                        Invest in a Delaware-domiciled US feeder fund that provides exposure to a Large & Mid Cap
                        SEBI-regulated Mutual Fund via a GIFT City Fund. Both the Mutual Fund and the GIFT Fund are
                        managed
                        by DSP,  a 160-year old asset manager in India.
                    </div>
                </div>
                <div class="nse-overview-section">
                    <h2 class="nse-inner-section-title">Investment Objective</h2>
                    <div class="nse-overview-desc">
                        To generate long-term capital appreciation by investing primarily in DSP Gift city fund and DSP Gift city fund will invest in DSP Large & Mid Cap Fund — which focuses on India-based companies with strong growth, healthy balance sheets, and compelling valuations.
                    </div>
                </div>
                <div class="nse-highlights">
                    <div class="nse-highlights-left">
                        <h3>Why Invest in Vested India Equity Opportunities Fund?</h3>
                        <ul class="nse-highlights-list">
                            <li>
                                <p>No PAN, No Local Bank Account Required</p>
                            </li>
                            <li>
                                <p>Invest & Redeem in USD</p>
                                <span class="nse-highlights-note">No INR conversion hassles</span>
                            </li>
                            <li>
                                <p>Mutual Fund exposure without PFIC filings</p>
                            </li>
                            <li>
                                <p>SEC-regulated structure</p>
                            </li>
                            <li>
                                <p>Full Capital Repatriation</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="nse-section-inner-block nse-ecosystem-section">
                <h2 class="nse-inner-section-title">Fund Structure</h2>
                <div class="nse-overview-desc">
                U.S. feeder fund investing in DSP India Equity Opportunities Fund (GIFT City), which invests in DSP Large & Mid Cap Fund (SEBI-regulated mutual fund). DSP Mutual Fund is managed by DSP Asset Managers Private Limited (DSPAM). DSP Gift City Fund is managed by DSP Fund Managers IFSC Private Limited, wholly-owned subsidiary company of DSPAM.
                </div>
            </div>

            <div class="nse-section-inner-block nse-ecosystem-section">
                <h2 class="nse-inner-section-title">Tax Treatment</h2>
                <div class="nse-highlights-list-wrapper">
                    <ul class="nse-highlights-list">
                        <li>
                            <p>No PFIC filing required</p>
                            <span class="nse-highlights-note">Vested handles all fund-level compliance</span>
                        </li>
                        <li>
                            <p>Capital gains and income are taxed at U.S. mutual fund ratescc</p>
                        </li>
                        <li>
                            <p>K-1 will be available for simple tax reporting</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="nse-section-inner-block ">
                <h2 class="nse-inner-section-title">Portfolio Composition</h2>
                <div class="nse-portfolio-composition">
                    <div class="nse-portfolio-top">
                        <div class="nse-portfolio-item">
                            <div class="nse-portfolio-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 15H13C13.5304 15 14.0391 14.7893 14.4142 14.4142C14.7893 14.0391 15 13.5304 15 13C15 12.4696 14.7893 11.9609 14.4142 11.5858C14.0391 11.2107 13.5304 11 13 11H10C9.4 11 8.9 11.2 8.6 11.6L3 17"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7 21.0003L8.6 19.6003C8.9 19.2003 9.4 19.0003 10 19.0003H14C15.1 19.0003 16.1 18.6003 16.8 17.8003L21.4 13.4003C21.7859 13.0356 22.0111 12.5326 22.0261 12.0018C22.0411 11.4711 21.8447 10.9562 21.48 10.5703C21.1153 10.1844 20.6123 9.95916 20.0816 9.94416C19.5508 9.92916 19.0359 10.1256 18.65 10.4903L14.45 14.3903"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 16L8 22" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M16 11.8996C17.6016 11.8996 18.9 10.6012 18.9 8.99961C18.9 7.39798 17.6016 6.09961 16 6.09961C14.3983 6.09961 13.1 7.39798 13.1 8.99961C13.1 10.6012 14.3983 11.8996 16 11.8996Z"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M6 8C7.65685 8 9 6.65685 9 5C9 3.34315 7.65685 2 6 2C4.34315 2 3 3.34315 3 5C3 6.65685 4.34315 8 6 8Z"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="nse-portfolio-content">
                                <h3>Underlying Holdings</h3>
                                <p>Stocks listed on NSE & BSE</p>
                            </div>
                        </div>
                        <div class="nse-portfolio-item">
                            <div class="nse-portfolio-icon">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.5 12.0004C22.052 12.0004 22.505 11.5514 22.45 11.0024C22.2195 8.70658 21.2021 6.56111 19.5703 4.92973C17.9386 3.29835 15.7929 2.28144 13.497 2.05141C12.947 1.99641 12.499 2.44941 12.499 3.00141V11.0014C12.499 11.2666 12.6044 11.521 12.7919 11.7085C12.9795 11.8961 13.2338 12.0014 13.499 12.0014L21.5 12.0004Z"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M21.71 15.8901C21.0738 17.3946 20.0788 18.7203 18.8119 19.7514C17.5449 20.7825 16.0447 21.4875 14.4424 21.8049C12.8401 22.1222 11.1844 22.0422 9.62012 21.5719C8.05585 21.1015 6.6306 20.2551 5.469 19.1067C4.30739 17.9583 3.44479 16.5428 2.95661 14.984C2.46843 13.4252 2.36954 11.7706 2.66857 10.1647C2.96761 8.55886 3.65547 7.05071 4.67202 5.77211C5.68857 4.49351 7.00286 3.4834 8.49998 2.83008"
                                        stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="nse-portfolio-content">
                                <h3>Minimum Exposure</h3>
                                <p>35% in Large Cap & 35% in Mid Cap stocks</p>
                            </div>
                        </div>
                    </div>
                    <div class="nse-portfolio-cards">
                        <div class="nse-portfolio-card">
                            <h3>Large Cap</h3>
                            <div class="nse-portfolio-card-details">
                                <p>Top 100 companies</p>
                                <div class="nse-portfolio-card-value">> ₹91,000 Cr / $10.7 Bn</div>
                            </div>
                        </div>
                        <div class="nse-portfolio-card">
                            <h3>Mid Cap stocks</h3>
                            <div class="nse-portfolio-card-details">
                                <p>Rank 101-250</p>
                                <div class="nse-portfolio-card-value">₹91,000 Cr–₹30,750 Cr</div>
                            </div>
                        </div>
                        <div class="nse-portfolio-card">
                            <h3>Small Cap</h3>
                            <div class="nse-portfolio-card-details">
                                <p>Rank 251 and beyond</p>
                                <div class="nse-portfolio-card-value">
                                    < ₹30,750 Cr</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nse-section-inner-block nse-financial">
                    <h2 class="nse-inner-section-title">Sector Allocation of the underlying DSP Large & Mid Cap Fund</h2>
                    <div class="nse-inner-section-desc">% as of June 30, 2025</div>
                    <div class="table-wrapper">
                        <table class="nse-financial-table">
                            <tr>
                                <th>Sector</th>
                                <th>Fund Weight</th>
                                <th>Nifty LMC 250</th>
                                <th>MSCI India</th>
                            </tr>
                            <tr>
                                <td>Financials</td>
                                <td><span>33.3%</span></td>
                                <td>29.0%</td>
                                <td>29.3%</td>
                            </tr>
                            <tr>
                                <td>Healthcare</td>
                                <td><span>10.1%</span></td>
                                <td>7.8%</td>
                                <td>5.6%</td>
                            </tr>
                            <tr>
                                <td>Consumer Discretionary</td>
                                <td><span>10.0%</span></td>
                                <td>11.1%</td>
                                <td>12.2%</td>
                            </tr>
                            <tr>
                                <td>Materials</td>
                                <td><span>9.5%</span></td>
                                <td>10.1%</td>
                                <td>8.0%</td>
                            </tr>
                            <tr>
                                <td>IT</td>
                                <td><span>8.4%</span></td>
                                <td>8.4%</td>
                                <td>9.9%</td>
                            </tr>
                            <tr>
                                <td>Energy</td>
                                <td><span>5.7%</span></td>
                                <td>6.0%</td>
                                <td>9.3%</td>
                            </tr>
                            <tr>
                                <td>Industrials</td>
                                <td><span>4.9%</span></td>
                                <td>13.0%</td>
                                <td>9.0%</td>
                            </tr>
                            <tr>
                                <td>Consumer Staples</td>
                                <td><span>3.8%</span></td>
                                <td>5.5%</td>
                                <td>6.3%</td>
                            </tr>
                            <tr>
                                <td>Utilities</td>
                                <td><span>3.5%</span></td>
                                <td>3.6%</td>
                                <td>3.7%</td>
                            </tr>
                            <tr>
                                <td>Communication Svcs</td>
                                <td><span>3.2%</span></td>
                                <td>3.7%</td>
                                <td>4.9%</td>
                            </tr>
                            <tr>
                                <td>Real Estate</td>
                                <td><span>0.9%</span></td>
                                <td>2.0%</td>
                                <td>1.6%</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="nse-section-inner-block">
                    <h2 class="nse-inner-section-title">Performance Track Record (USD)</h2>
                    <?php if ($fund_access == 'Yes'): ?>
                        <div class="table-wrapper">
                            <table class="nse-competitive-table">
                                <tr>
                                    <th><strong>Period</strong></th>
                                    <th><strong>Fund</strong></th>
                                    <th><strong>Nifty LMC 250</strong></th>
                                    <th><strong>MSCI India</strong></th>
                                    <th><strong>Alpha vs Nifty</strong></th>
                                    <th><strong>Alpha vs MSCI</strong></th>
                                </tr>
                                <tr>
                                    <td><strong>0 Year</strong></td>
                                    <td class="fund-value">00%</td>
                                    <td>00%</td>
                                    <td>00%</td>
                                    <td class="alpha-positive">00%</td>
                                    <td class="alpha-positive">00%</td>
                                </tr>
                                <tr>
                                    <td><strong>00 Year</strong></td>
                                    <td class="fund-value">00%</td>
                                    <td>00%</td>
                                    <td>00%</td>
                                    <td class="alpha-positive">00%</td>
                                    <td class="alpha-positive">00%</td>
                                </tr>
                                <tr>
                                    <td><strong>00 Year</strong></td>
                                    <td class="fund-value">00%</td>
                                    <td>00%</td>
                                    <td>00%</td>
                                    <td class="alpha-negative">00%</td>
                                    <td class="alpha-positive">00%</td>
                                </tr>
                                <tr>
                                    <td><strong>00 Year</strong></td>
                                    <td class="fund-value">00%</td>
                                    <td>00%</td>
                                    <td>00%</td>
                                    <td class="alpha-negative">00%</td>
                                    <td class="alpha-positive">00%</td>
                                </tr>
                                <tr>
                                    <td><strong>00 Year</strong></td>
                                    <td class="fund-value">00.0%</td>
                                    <td>00%</td>
                                    <td>00%</td>
                                    <td class="alpha-positive">00%</td>
                                    <td class="alpha-positive">00%</td>
                                </tr>
                                <tr>
                                    <td><strong>--</strong></td>
                                    <td class="fund-value">00.00%</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            </table>
                            <div class="disabled-section">
                                <div class="disabled-section-content">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="40" height="40" rx="20" fill="#DBEAFE"/>
                                        <path d="M15 19V15C15 13.6739 15.5268 12.4021 16.4645 11.4645C17.4021 10.5268 18.6739 10 20 10C21.3261 10 22.5979 10.5268 23.5355 11.4645C24.4732 12.4021 25 13.6739 25 15V19M13 19H27C28.1046 19 29 19.8954 29 21V28C29 29.1046 28.1046 30 27 30H13C11.8954 30 11 29.1046 11 28V21C11 19.8954 11.8954 19 13 19Z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Available after launch</span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-wrapper">
                            <table class="nse-competitive-table">
                                <tr>
                                    <th><strong>Period</strong></th>
                                    <th><strong>Fund</strong></th>
                                    <th><strong>Nifty LMC 250</strong></th>
                                    <th><strong>MSCI India</strong></th>
                                    <th><strong>Alpha vs Nifty</strong></th>
                                    <th><strong>Alpha vs MSCI</strong></th>
                                </tr>
                                <tr>
                                    <td><strong>1 Year</strong></td>
                                    <td class="fund-value">3.5%</td>
                                    <td>3.4%</td>
                                    <td>0.8%</td>
                                    <td class="alpha-positive">+0.2%</td>
                                    <td class="alpha-positive">+2.7%</td>
                                </tr>
                                <tr>
                                    <td><strong>3 Year</strong></td>
                                    <td class="fund-value">22.6%</td>
                                    <td>21.7%</td>
                                    <td>15.6%</td>
                                    <td class="alpha-positive">+0.9%</td>
                                    <td class="alpha-positive">+6.9%</td>
                                </tr>
                                <tr>
                                    <td><strong>5 Year</strong></td>
                                    <td class="fund-value">22.0%</td>
                                    <td>23.8%</td>
                                    <td>18.1%</td>
                                    <td class="alpha-negative">-1.7%</td>
                                    <td class="alpha-positive">+3.9%</td>
                                </tr>
                                <tr>
                                    <td><strong>10 Year</strong></td>
                                    <td class="fund-value">12.3%</td>
                                    <td>12.8%</td>
                                    <td>9.2%</td>
                                    <td class="alpha-negative">-0.5%</td>
                                    <td class="alpha-positive">+3.1%</td>
                                </tr>
                                <tr>
                                    <td><strong>20 Year</strong></td>
                                    <td class="fund-value">13.0%</td>
                                    <td>12.3%</td>
                                    <td>9.9%</td>
                                    <td class="alpha-positive">+0.7%</td>
                                    <td class="alpha-positive">+3.1%</td>
                                </tr>
                                <tr>
                                    <td><strong>Since Inception</strong></td>
                                    <td class="fund-value">14.82%</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="nse-warning-icon">
                        <p>
                            Data as of June 30, 2025. Returns are net of fees. Past performance is not indicative of
                            future results. The benchmarks used are representative of the investment's general
                            risk/return characteristics.  The fund's strategy may materially differ from the benchmarks
                            shown.
                        </p>
                    </div>
                </div>

                <div class="nse-section-inner-block nse-who-can-invest-section">
                    <h2 class="nse-inner-section-title">Who Can Invest?</h2>
                    <div class="nse-investor-requirement">
                        <div class="nse-requirement-icon">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 12.5C0 5.87258 5.37258 0.5 12 0.5C18.6274 0.5 24 5.87258 24 12.5C24 19.1274 18.6274 24.5 12 24.5C5.37258 24.5 0 19.1274 0 12.5Z"
                                    fill="#059669" />
                                <path d="M16.6666 9L10.25 15.4167L7.33331 12.5" stroke="#F8FAFB" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="nse-requirement-text">US Accredited Investors Only</span>
                    </div>
                </div>

                <div class="nse-section-inner-block">
                    <h2 class="nse-inner-section-title">Risk Metrics (USD)</h2>
                    <?php if ($fund_access == 'Yes'): ?>
                        <div class="table-wrapper">
                            <table class="nse-competitive-table">
                                <tr>
                                    <th><strong>Metric</strong></th>
                                    <th><strong>1Y</strong></th>
                                    <th><strong>3Y</strong></th>
                                    <th><strong>5Y</strong></th>
                                    <th><strong>10Y</strong></th>
                                </tr>
                                <tr>
                                    <td>Volatility (%)</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                </tr>
                                <tr>
                                    <td>Sharpe Ratio</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                    <td>00.0</td>
                                </tr>
                            </table>
                            <div class="disabled-section">
                                <div class="disabled-section-content">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="40" height="40" rx="20" fill="#DBEAFE"/>
                                        <path d="M15 19V15C15 13.6739 15.5268 12.4021 16.4645 11.4645C17.4021 10.5268 18.6739 10 20 10C21.3261 10 22.5979 10.5268 23.5355 11.4645C24.4732 12.4021 25 13.6739 25 15V19M13 19H27C28.1046 19 29 19.8954 29 21V28C29 29.1046 28.1046 30 27 30H13C11.8954 30 11 29.1046 11 28V21C11 19.8954 11.8954 19 13 19Z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Available after launch</span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-wrapper">
                            <table class="nse-competitive-table">
                                <tr>
                                    <th><strong>Metric</strong></th>
                                    <th><strong>1Y</strong></th>
                                    <th><strong>3Y</strong></th>
                                    <th><strong>5Y</strong></th>
                                    <th><strong>10Y</strong></th>
                                </tr>
                                <tr>
                                    <td>Volatility (%)</td>
                                    <td>15.9</td>
                                    <td>14.8</td>
                                    <td>15.4</td>
                                    <td>14.8</td>
                                </tr>
                                <tr>
                                    <td>Sharpe Ratio</td>
                                    <td>-0.1</td>
                                    <td>1.2</td>
                                    <td>0.5</td>
                                    <td>0.5</td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="nse-risk-disclaimer">
                        <p>
                            Risk Metrics such as Volatility and Sharpe Ratio are provided for informational purposes
                            only and are not intended to be a complete measure of investment risk, or performance. These
                            metrics are based on historical returns, which may not reflect actual fund performance or
                            investor experience. They may be calculated using gross returns, net returns, or model-based
                            estimates, and results may differ based on the assumptions used. The Sharpe ratio compares
                            the fund's return in excess of a risk-free rate to the standard deviation of its returns. A
                            higher Sharpe ratio does not guarantee superior risk-adjusted performance in the future.
                        </p>
                        <p>
                            Volatility (standard deviation) measures the dispersion of returns and does not capture
                            downside risk, liquidity risk, or other material risk factors. These metrics should not be
                            used in isolation to evaluate the merits of an investment and do not account for leverage,
                            liquidity constraints, fund expenses, or investor-specific tax impacts. Past performance and
                            historical risk characteristics are not indicative of future results.
                        </p>
                    </div>
                </div>

                <div class="nse-section-inner-block nse-summary-section">
                    <h2 class="nse-inner-section-title">Disclosures</h2>
                    <div class="nse-summary-desc">
                        <p>This page is intended solely for informational purposes and does not constitute an offer to
                            sell
                            or a solicitation of an offer to buy any securities, which may only be made pursuant to the
                            offering documents of the fund and only to qualified investors. Any such offer or
                            solicitation
                            will be made only by means of a private placement memorandum, subscription agreement, and
                            other
                            definitive fund documents, all of which must be read in their entirety.</p>
                        <p>The information contained herein is intended for U.S. accredited investors as defined under
                            Rule 501 of Regulation D of the Securities Act of 1933. Access to fund information may be
                            restricted for regulatory or compliance reasons.</p>
                        <p>Investments in private funds are speculative and involve a high degree of risk, including the
                            loss of principal. The fund may invest in foreign markets, which are subject to additional
                            risks, including political, economic, currency, tax, and regulatory risks, as well as
                            different accounting and reporting standards than those in the United States. These risks
                            may be greater in emerging or frontier markets.</p>
                        <p>No regulatory authority, including the U.S. Securities and Exchange Commission or any foreign
                            regulator, has approved or passed upon the merits of any offering or the adequacy of the
                            materials presented on this site.</p>
                    </div>
                </div>
            </div>
        </div>
</section>



<?php get_footer(); ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ctaBtn = document.getElementById('nseExpressBtn');

    if (ctaBtn) {
      ctaBtn.addEventListener('click', function(e) {
        console.log('clicked');
        e.preventDefault(); // stop opening Typeform
        window.parent.postMessage({ type: 'CTA_CLICKED' }, '*'); // trigger parent message
      });
    }
  });
</script>