<div id="metrics_tab" class="tab_content">
<div class="stock_details_box stock_metrics_container">
            <h2 class="heading">Key Metrics</h2>
            <div class="separator_line"></div>
            <div class="stock_metrics_wrapper">
                <div class="stock_metrics_keyvalue">
                    <div class="stock_summary">
                       
                        <div class="stock_summary_item">
                            <span>
                                Face Value
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Face value is the nominal amount that will be repaid to the bondholder at maturity. Also referred to as “par value”.</div>
                            </span>
                            <strong><span id="face-value">&#8377;</span></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Coupon
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Coupon is the fixed interest rate paid annually or semi-annually to bondholders, expressed as a percentage of the face value.</div>
                            </span>
                            <strong><span><span id="coupon-rate"></span><span>,&nbsp;</span><span id="coupon-type"></span></span></strong>
                        </div>
                           
                        <div class="stock_summary_item">
                            <span>
                                Security
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Security indicates whether the bond is backed by specific assets (secured) or not (unsecured).</div>
                            </span>
                            <strong><span id="bond-secure"></span></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Seniority
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Seniority is the order of priority in which bondholders are repaid in case of the issuer's bankruptcy, with senior bonds being repaid before junior ones.</div>
                            </span>
                            <strong><span id="seniority"></span></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Mode of Issue
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Mode of issue refers to the method of issuing bonds, such as through public offerings or private placements.</div>
                            </span>
                            <strong><span id="issue-mode"></span></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Tax Status
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                <div class="info_text">Tax status is the tax treatment of bond interest payments, with some bonds offering tax-exempt interest under specific conditions.</div>
                            </span>
                            <strong id="tax-status"></strong>
                        </div>
                        <div class="stock_summary_item">
                            <span>
                                Information Memorandum
                            </span>
                            <strong><a id="im-url" target="_blank">View  <i class="fa fa-chevron-right" aria-hidden="true"></i></a></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>