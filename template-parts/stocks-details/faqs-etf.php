<?php
    $overview_data = $args['overview_data'];
    if ($overview_data) {
        $name = $overview_data->name;
        $ticker = $overview_data->ticker;
        $price = $overview_data->price;
        $summary = $overview_data->summary;
        $summaryMapping = preprocessSummary($summary);
        $expenseRatio = getValueByLabel($summaryMapping, "Expense Ratio");
        $peRatio = getValueByLabel($summaryMapping, "P/E Ratio");
        $dividendYieldValue = getValueByLabel($summaryMapping, "Dividend Yield");
        $rangeItem = isset($summaryMapping["52-Week Range"]) ? $summaryMapping["52-Week Range"] : null;
        $lowRange = isset($rangeItem['low']) ? $rangeItem['low'] : '';
        $highRange = isset($rangeItem['high']) ? $rangeItem['high'] : '';
        $formattedName = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
        $feedbackLinkAdd = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $ticker . '&company_name=' . $formattedName . '&feedback_type=add_data';
        $feedbackLinkIncorrect = 'https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=' . $ticker . '&company_name=' . $formattedName . '&feedback_type=incorrect_data';
         // Build static FAQs array with positions
        $static_faqs = array(
            array(
                'position' => 0,
                'question' => 'What is ' . $name . ' (' . $ticker . ') ETF share price today?',
                'answer' => '<p>' . $name . ' (' . $ticker . ') share price today is $' . $price . '.</p>'
            ),
            array(
                'position' => 1,
                'question' => 'Can Indians buy ' . $name . ' shares?',
                'answer' => '<p>Yes, Indians can buy shares of ' . $name . ' (' . $ticker . ') on Vested. To buy ' . $ticker . ' from India, you can open a US Brokerage account by signing up on Vested. The account opening process is completely digital and secure, and takes 3-5 minutes to complete.</p>'
            ),
            array(
                'position' => 2,
                'question' => 'Can Fractional shares of ' . $name . ' be purchased?',
                'answer' => '<p>Yes, you can purchase fractional shares of ' . $name . ' (' . $ticker . ') on Vested. You can start investing in ' . $name . ' (' . $ticker . ') with a minimum investment of $1.</p>'
            ),
            array(
                'position' => 3,
                'question' => 'How to invest in ' . $name . ' shares from India?',
                'answer' => '<ul><li>Click on Sign Up or Invest in ' . $ticker . ' ETF at the top of this page</li><li>Breeze through our fully digital and secure KYC process and open your US Brokerage account in a few minutes</li><li>Transfer USD funds to your US Brokerage account and start investing in ' . $name . ' shares</li></ul>'
            ),
            array(
                'position' => 4,
                'question' => 'What is ' . $name . '\'s 52-week high and low ETF share price?',
                'answer' => '<p>The 52-week high price of ' . $name . ' (' . $ticker . ') is $' . $highRange . '. The 52-week low price of ' . $name . ' (' . $ticker . ') is $' . $lowRange . '.</p>'
            ),
            array(
                'position' => 5,
                'question' => 'What is ' . $name . '\'s ticker or symbol?',
                'answer' => '<p>The stock symbol (or ticker) of ' . $name . ' is ' . $ticker . '.</p>'
            ),
            array(
                'position' => 6,
                'question' => 'Can I set up automatic investments (SIP) in ' . $name . ' shares?',
                'answer' => '<p>Yes, you can setup SIP in ' . $name . ' shares. Follow the below steps to create the SIP:</p><ul><li>Sign up on Vested and complete your KYC for US Stocks</li><li>Transfer funds to your US Stocks account</li><li>Navigate to ' . $ticker . ' tickr page and set up your recurring investment</li></ul>'
            ),
            array(
                'position' => 7,
                'question' => 'What is the historical performance of ' . $name . ' ETF?',
                'answer' => '<p>Here is the historical performance of ' . $ticker . ' on the Vested app.</p><ul><li>1 Year Return - {X%}</li><li>3 Year Return</li><li>5 Year</li><li>You can also access the top holdings, the expense ratio, and the sector breakdown for ' . $name . ' on Vested.</li></ul>'
            ),
            array(
                'position' => 8,
                'question' => 'What is the expense ratio of ' . $name . '?',
                'answer' => '<p>The expense ratio of ' . $name . ' (' . $ticker . ') is ' . $expenseRatio . '.</p>'
            ),
        );

        // Get custom FAQs from ACF
        $custom_faqs = get_custom_faqs_for_ticker($ticker);
        
        // Merge static and custom FAQs
        $all_faqs = merge_faqs($static_faqs, $custom_faqs);
?>
    <div id="faqs_tab" class="tab_content">
        <div class="stock_details_box">
            <h2 class="heading">FAQs</h2>
            <div class="separator_line"></div>
            <div class="faqs_section">
                <div class="faq_container">
                    <div class="list_faqs">
                       <?php foreach ($all_faqs as $faq): ?>
                            <div class="faq_item">
                                <div class="faq_question"><?php echo $faq['question']; ?></div>
                                <div class="faq_icon">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="faq_answer">
                                <?php echo $faq['answer']; ?>
                            </div>
                        <?php endforeach; ?>
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
                    <div class="feedback_list_title">Request to add more info/data</div>
                </a>
            </div>
            <div class="feedback_list">
                <a href="<?php echo $feedbackLinkIncorrect; ?>" target="_blank">
                <div class="feedback_list_title">Inform about wrong info/data</div>
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
                    "name": "What is <?php echo $name; ?> (<?php echo $ticker; ?>) ETF share price today?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<?php echo $name; ?> (<?php echo $ticker; ?>) share price today is $<?php echo $price; ?>."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can Indians buy <?php echo $name; ?> shares?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, Indians can buy shares of <?php echo $name; ?> (<?php echo $ticker; ?>) on Vested. To buy <?php echo $ticker; ?> from India, you can open a US Brokerage account by signing up on Vested. The account opening process is completely digital and secure, and takes 3-5 minutes to complete."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can Fractional shares of <?php echo $name; ?> be purchased?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, you can purchase fractional shares of <?php echo $name; ?> (<?php echo $ticker; ?>) on Vested. You can start investing in <?php echo $name; ?> (<?php echo $ticker; ?>) with a minimum investment of $1."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How to invest in <?php echo $name; ?> shares from India?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Click on Sign Up or Invest in <?php echo $ticker; ?> ETF at the top of this page, Breeze through our fully digital and secure KYC process and open your US Brokerage account in a few minutes, Transfer USD funds to your US Brokerage account and start investing in <?php echo $name; ?> shares"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?>'s 52-week high and low ETF share price?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The 52-week high price of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $highRange; ?>. The 52-week low price of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $lowRange; ?>."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is <?php echo $name; ?>'s ticker or symbol?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The stock symbol (or ticker) of <?php echo $name; ?> is <?php echo $ticker; ?>."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I set up automatic investments (SIP) in <?php echo $name; ?> shares?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<p>Yes, you can setup SIP in <?php echo $name; ?> shares. Follow the below steps to create the SIP:</p>
                        <ul>
                            <li>Sign up on Vested and complete your KYC for US Stocks</li>
                            <li>Transfer funds to your US Stocks account</li>
                            <li>Navigate to <?php echo $ticker; ?> tickr page and set up your recurring investment</li>
                        </ul>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the historical performance of <?php echo $name; ?> ETF?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<p>Here is the historical performance of <?php echo $ticker; ?> on the Vested app.</p>
                        <ul>
                            <li>1 Year Return - {X%}</li>
                            <li>3 Year Return</li>
                            <li>5 Year</li>
                            <li>You can also access the top holdings, the expense ratio, and the sector breakdown for <?php echo $name; ?> on Vested.</li>
                        </ul>"
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the expense ratio of <?php echo $name; ?>?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The expense ratio of <?php echo $name; ?> (<?php echo $ticker; ?>) is <?php echo $expenseRatio; ?>."
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