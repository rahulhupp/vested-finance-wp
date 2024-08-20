<?php
    $bond = $args['bond'];
    if ($bond) {
        ?>
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
                                    <strong><span><?php echo formatIndianCurrency($bond->faceValue); ?></span></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Coupon
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Coupon is the fixed interest rate paid annually or semi-annually to bondholders, expressed as a percentage of the face value.</div>
                                    </span>
                                    <strong>
                                        <span>
                                            <span><?php echo $bond->couponRate; ?>%</span>
                                            <span>,&nbsp;</span>
                                            <span><?php echo $bond->couponType; ?></span>
                                        </span>
                                    </strong>
                                </div>
                                    
                                <div class="stock_summary_item">
                                    <span>
                                        Security
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Security indicates whether the bond is backed by specific assets (secured) or not (unsecured).</div>
                                    </span>
                                    <strong><span><?php echo $bond->secureUnsecure; ?></span></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Seniority
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Seniority is the order of priority in which bondholders are repaid in case of the issuer's bankruptcy, with senior bonds being repaid before junior ones.</div>
                                    </span>
                                    <strong><span><?php echo $bond->seniority; ?></span></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Mode of Issue
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Mode of issue refers to the method of issuing bonds, such as through public offerings or private placements.</div>
                                    </span>
                                    <strong><span><?php echo $bond->modeOfIssue; ?></span></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Tax Status
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Tax status is the tax treatment of bond interest payments, with some bonds offering tax-exempt interest under specific conditions.</div>
                                    </span>
                                    <strong>
                                        <?php echo $bond->isTaxfree ? '<span class="highlighted">Tax Free</span>' : '<span>Taxable</span>'; ?>
                                    </strong>
                                </div>
                                <?php if($bond->imDocUrl) : ?>
                                <div class="stock_summary_item">
                                    <span>
                                        Information Memorandum
                                    </span>
                                    <strong><a href="<?php echo $bond->imDocUrl; ?>" target="_blank" class="pdf_viewer">View  <i class="fa fa-chevron-right" aria-hidden="true"></i></a></strong>
                                    <!-- <strong><a href="<?php // echo get_stylesheet_directory_uri();?>/assets/94b89dfb-f949-4996-9345-0e89b429de53.pdf" target="_blank" class="pdf_viewer">View  <i class="fa fa-chevron-right" aria-hidden="true"></i></a></strong> -->
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>