<?php
    $overview_data = $args['overview_data'];
    $ratios_data = $args['ratios_data'];
    $valuationIndex = array_search('Valuation', array_column($ratios_data['ratios'], 'section'));
    $priceBookMRQ = $ratios_data['ratios'][$valuationIndex]['data']['current']['value']['priceBookMRQ']['value'];

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
        $feedbackLinkAdd = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $ticker . '&company_name=' . $formattedName . '&feedback_type=add_data';
        $feedbackLinkIncorrect = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $ticker . '&company_name=' . $formattedName . '&feedback_type=incorrect_data';
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
                        <p>Yes, Indians can buy shares of <?php echo $name; ?> (<?php echo $ticker; ?>) on Vested. To buy <company-name> from India, you can open a US Brokerage account on Vested today by clicking on Sign Up or Invest in <?php echo $ticker; ?> stock at the top of this page. The account opening process is completely digital and secure, and takes a few minutes to complete.</p>
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
                        <p>You can invest in shares of <?php echo $name; ?> (<?php echo $ticker; ?>) via Vested in three simple steps:</p>
                        <ul>
                            <li>Click on Sign Up or Invest in <?php echo $ticker; ?> stock at the top of this page</li>
                            <li>Breeze through our fully digital and secure KYC process and open your US Brokerage account in a few minutes</li>
                            <li>Transfer USD funds to your US Brokerage account and start investing in <?php echo $name; ?> shares</li>
                        </ul>
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
                        <p>The price-to-book (P/B) ratio of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <?php echo $priceBookMRQ; ?></p>
                    </div>
                    <div class="faq_item">
                        <div class="faq_question">What is <span><?php echo $name; ?></span> dividend yield?</div>
                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <div class="faq_answer">
                        <p>The dividend yield of <span><?php echo $name; ?></span> (<span><?php echo $ticker; ?></span>) is <span><?php if ($dividendYieldValue) { echo $dividendYieldValue; } else { echo "0.00%"; }?></span></p>
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

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?> share price today?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<?php echo $name; ?> (<?php echo $ticker; ?>) share price today is $<?php echo $price; ?>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can Indians buy <?php echo $name; ?> shares?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, Indians can buy shares of <?php echo $name; ?> (<?php echo $ticker; ?>) on Vested. To buy <company-name> from India, you can open a US Brokerage account on Vested today by clicking on Sign Up or Invest in <?php echo $ticker; ?> stock at the top of this page. The account opening process is completely digital and secure, and takes a few minutes to complete."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can Fractional shares of <?php echo $name; ?> be purchased?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, you can purchase fractional shares of <?php echo $name; ?> (<?php echo $ticker; ?>) via the Vested app. You can start investing
                            in <?php echo $name; ?> (<?php echo $ticker; ?>) with a minimum investment of $1."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How to invest in <?php echo $name; ?> shares from India?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<p>You can invest in shares of <?php echo $name; ?> (<?php echo $ticker; ?>) via Vested in three simple steps:</p>
                        <ul>
                            <li>Click on Sign Up or Invest in <?php echo $ticker; ?> stock at the top of this page</li>
                            <li>Breeze through our fully digital and secure KYC process and open your US Brokerage account in a few minutes</li>
                            <li>Transfer USD funds to your US Brokerage account and start investing in <?php echo $name; ?> shares</li>
                        </ul>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?> 52-week high and low stock price?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The 52-week high price of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $highRange; ?>. The 52-week low price of <?php echo $name; ?> (<?php echo $ticker; ?>)
                            is <?php echo $lowRange; ?>."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?> price-to-earnings (P/E) ratio?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The price-to-earnings (P/E) ratio of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $peRatio; ?>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?> price-to-book (P/B) ratio?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The price-to-book (P/B) ratio of <?php echo $name; ?> (<?php echo $ticker; ?>) is <span id='faq_stock_pb_ratio'></span>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?> dividend yield?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The dividend yield of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php if ($dividendYieldValue) { echo $dividendYieldValue; } else { echo "0.00%"; }?>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the Market Cap of <?php echo $name; ?>?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The market capitalization of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $marketCapValue; ?>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?>’s stock symbol?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The stock symbol (or ticker) of <?php echo $name; ?> is <?php echo $ticker; ?>"
                    }
                }
            ]
        }
    </script>
<?php
    } else {
        echo "Error retrieving data"; // Handle error
    }
?>