<?php 
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $overview_data = fetch_overview_api_data($symbol, $token);
?>
<?php
    if ($overview_data) {
        $name = $overview_data->name;
        $ticker = $overview_data->ticker;
        $price = $overview_data->price;
        $summary = $overview_data->summary;

        function getValueByLabelFAQ($summary, $label) {
            foreach ($summary as $item) {
                if ($item->label === $label) {
                    return $item->value;
                }
            }
            return ''; // Return empty string if label not found
        }
        $marketCapValue = getValueByLabelFAQ($summary, "Market Cap");
        $peRatio = getValueByLabelFAQ($summary, "P/E Ratio");
        $dividendYieldValue = getValueByLabelFAQ($summary, "Dividend Yield");
        $rangeItem = null;
        foreach ($summary as $item) {
            if ($item->label === "52-Week Range") {
                $rangeItem = $item;
                break;
            }
        }
        $lowRange = isset($rangeItem->value->low) ? $rangeItem->value->low : '';
        $highRange = isset($rangeItem->value->high) ? $rangeItem->value->high : '';
        
        $formattedName = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
        $formattedTicker = strtolower(str_replace(' ', '-', $ticker));
        $feedbackLinkAdd = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $formattedTicker . '&company_name=' . $formattedName . '&feedback_type=add_data';
        $feedbackLinkIncorrect = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $formattedTicker . '&company_name=' . $formattedName . '&feedback_type=incorrect_data';
?>
    <div id="faqs_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">FAQs</h2>
            <div class="separator_line"></div>
            <div class="faqs_section">
                <div class="faq_container">
                    <div class="list_faqs">
                        <div class="faq_item">
                            <div class="faq_question">What is <span><?php echo $name; ?></span> share price today?</div>
                            <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                        </div>
                        <div class="faq_answer">
                            <p><span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) share price today is $<span><?php echo $price; ?></span></p>
                        </div>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">Can Indians buy <span><?php echo $name; ?></span> shares?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>Yes, Indians can buy shares of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>). There are two primary methods to buy <span><?php echo $name; ?></span> via Vested.
                            i.e., direct investing and investing through instruments. You can open your US brokerage account via the
                            Vested app and purchase shares of <span><?php echo $name; ?></span> directly or invest in <span><?php echo $name; ?></span> via international mutual funds and
                            exchange-traded funds. If you want an alternative, you can also go for domestic (Indian) funds investing
                            in the US stock market.</p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">Can Fractional shares of <span><?php echo $name; ?></span> be purchased?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>Yes, you can purchase fractional shares of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) via the Vested app. You can start investing
                            in <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) with a minimum investment of $1.</p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">How to invest in <span><?php echo $name; ?></span> shares from India?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>You can invest in shares of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) via the Vested app in 3 simple steps:
                        <ul>
                            <li>
                                Download the Vested app or visit app.vestedfinance.com and Sign up with a new account
                            </li>
                            <li>
                                Breeze through our fully digital and secure KYC process and open your US Brokerage account in less
                                than 2 minutes</li>
                            <li>
                                Transfer USD funds to your US Brokerage account and start investing in <span><?php echo $name; ?></span> shares</li>
                        </ul>
                        </p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span> 52-week high and low stock price?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The 52-week high price of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span><?php echo $highRange; ?></span>. The 52-week low price of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>)
                            is <span><?php echo $lowRange; ?></span>.</p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span> price-to-earnings (P/E) ratio?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The price-to-earnings (P/E) ratio of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span><?php echo $peRatio; ?></span></p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span> price-to-book (P/B) ratio?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The price-to-book (P/B) ratio of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span id="faq_stock_pb_ratio"></span></p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span> dividend yield?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The dividend yield of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span><?php echo $dividendYieldValue; ?></span></p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is the Market Cap of <span><?php echo $name; ?></span>?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The market capitalization of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span><?php echo $marketCapValue; ?></span></p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span>’s stock symbol?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The stock symbol (or ticker) of <span><?php echo $name; ?></span> is <span><?php echo $ticker; ?></span></p>
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
                <a href="<?php echo $feedbackLinkAdd; ?>" target="_blank">
                    <h2>Request to add more info/data</h2>
                </a>
            </div>
            <div class="feedback_list">
                <a href="<?php echo $feedbackLinkIncorrect; ?>" target="_blank">
                <h2>Inform about wrong info/data</h2>
            </a>
            </div>
        </div>
    </div>
<?php
    } else {
        echo "Error retrieving data"; // Handle error
    }
?>