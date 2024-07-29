<?php
    $bond_name_slug = get_query_var('bond_company');
    $bond = $args['bond'];
    if ($bond) {
        ?>
            <div id="faqs_tab" class="tab_content">
                <div class="stock_details_box">
                    <h2 class="heading">FAQs</h2>
                    <div class="separator_line"></div>
                    <div class="faqs_section">
                        <div class="faq_container">
                            <div class="list_faqs">
                                <div class="faq_item">
                                    <div class="faq_question">How to buy <?php echo $bond->displayName; ?> bond online?</div>
                                    <div class="faq_icon">
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="faq_answer">
                                    <p>
                                    Investing in <?php echo $bond->displayName; ?> bond online is a simple process that can be completed in under 5 minutes. Follow these steps:
                                    </p>
                                    <ul style="list-style: decimal">
                                        <li>Login/signup at Vested and navigate to INR Bonds.</li>
                                        <li>Complete your KYC by providing the necessary information.</li>
                                        <li>Make a payment to receive bond units in your demat account.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">What is the yield of <?php echo $bond->displayName; ?> bond?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>The yield of <?php echo $bond->displayName; ?> bond is approximately <?php echo $bond->yield; ?>%. Yield to Maturity or the IRR of the Bond is the total yield earned if the bond is held to maturity. It includes earning from coupon payments and capital appreciation.</p>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">What is the credit rating of <?php echo $bond->displayName; ?> bond?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>The credit rating of <?php echo $bond->displayName; ?> bond indicates the issuer's creditworthiness and ability to meet its financial obligations. This is an independent opinion provided by rating agencies. It indicates the likeliness of a company to default. Rating scale ranges from AAA(being the highest) to D (lowest). A higher rating generally suggests lower risk.</p>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">How to redeem <?php echo $bond->displayName; ?> bond?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>Upon reaching the maturity date, the funds are automatically credited to your linked bank account.</p>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">Is <?php echo $bond->displayName; ?> bond tax-free?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>No, the interest income from <?php echo $bond->displayName; ?> bonds is not tax-free. It is categorised as "income from other sources," and the applicable tax will be calculated based on your income tax slab. For detailed information on taxation, please refer to this article: <a href="#">here</a></p>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">How can I sell <?php echo $bond->displayName; ?> bond before the maturity date?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>To sell <?php echo $bond->displayName; ?> bond before its maturity date, please contact us at help@vestedfinance.co. Our dedicated support team will guide you through the process and assist you with selling your bond.</p>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">What are the benefits of investing in <?php echo $bond->displayName; ?> bond?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>Bond investments offer the below compelling benefits, making them a valuable addition to an investment portfolio.</p>
                                <ul>
                                    <li><strong>Principal Protection: </strong>Bonds ensure your initial investment remains safe, and you receive fixed annual returns based on the coupon rate, making them a secure place to park extra income.</li>
                                    <li><strong>Stable Returns: </strong>Bonds provide a stable and predictable source of income, which is beneficial for those seeking regular earnings during career breaks or financial instability.</li>
                                    <li><strong>Predictable Growth: </strong>Unlike stocks, bonds offer steady financial growth without the volatility associated with market fluctuations. You can plan and achieve specific financial goals based on the known returns.</li>
                                    <li><strong>Safety and Performance: </strong>Bonds are generally safer than equity investments and can outperform certain debt mutual funds. In times of crisis, bondholders are prioritized for repayment, enhancing their security.</li>
                                    <li><strong>Tax Efficiency: </strong>Bonds often offer tax advantages over debt mutual funds, and their fixed returns till maturity are backed by regulations and law, providing a reliable income stream.</li>
                                </ul>
                            </div>
                            <div class="faq_item">
                                <div class="faq_question">What are the risks associated with investing in <?php echo $bond->displayName; ?> bond?</div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <p>Bonds are usually low-risk, similar to Fixed Deposits. But it's good to know about the risks involved:</p>
                                <ul style="list-style: decimal">
                                    <li>Default Risk: This happens when the bond issuer can't repay the principal or interest. It could mean losses for us as investors.</li>
                                    <li>Liquidity Risk: Selling bonds before maturity might be tough if no buyers are there. We might have to sell at a discount, leading to potential losses.</li>
                                    <li>Interest-Rate Risk: Bond prices can change with interest rates. If rates go up, the bond value may decrease, and we might face losses if sold early. On the flip side, falling rates can mean higher bond prices and potential gains if sold at a premium to the purchase price.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="stock_details_box">
                <h2 class="heading">Feedback</h2>
                <div class="separator_line"></div>
                <div class="feedback_section">
                    <div class="feedback_list" style="margin-right: 15px">
                        <a href="https://vestedfinance.typeform.com/to/BuPt2Xwu#bondname=<?php echo $bond_name_slug; ?>" target="_blank">
                            <h2>Request to add more info/data</h2>
                        </a>
                    </div>
                    <div class="feedback_list">
                        <a href="https://vestedfinance.typeform.com/to/W6VPlghm#bondname=<?php echo $bond_name_slug; ?>" target="_blank">
                            <h2>Inform about wrong info/data</h2>
                        </a>
                    </div>
                </div>
            </div>
        <?php
    }
?>