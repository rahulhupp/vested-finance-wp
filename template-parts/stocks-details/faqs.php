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
        $summaryMapping = preprocessSummary($summary);
        $marketCapValue = getValueByLabel($summaryMapping, "Market Cap");
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
                'question' => 'What is <span>' . $name . '</span> share price today?',
                'answer' => '<p><span>' . $name . '</span> (<span>' . $ticker . '</span>) share price today is $<span>' . $price . '</span></p>'
            ),
            array(
                'position' => 1,
                'question' => 'Can Indians buy <span>' . $name . '</span> shares?',
                'answer' => '<p>Yes, Indians can buy shares of ' . $name . ' (' . $ticker . ') on Vested. To buy <company-name> from India, you can open a US Brokerage account on Vested today by clicking on Sign Up or Invest in ' . $ticker . ' stock at the top of this page. The account opening process is completely digital and secure, and takes a few minutes to complete.</p>'
            ),
            array(
                'position' => 2,
                'question' => 'Can Fractional shares of <span>' . $name . '</span> be purchased?',
                'answer' => '<p>Yes, you can purchase fractional shares of <span>' . $name . '</span> (<span>' . $ticker . '</span>) via the Vested app. You can start investing in <span>' . $name . '</span> (<span>' . $ticker . '</span>) with a minimum investment of $1.</p>'
            ),
            array(
                'position' => 3,
                'question' => 'How to invest in <span>' . $name . '</span> shares from India?',
                'answer' => '<p>You can invest in shares of ' . $name . ' (' . $ticker . ') via Vested in three simple steps:</p><ul><li>Click on Sign Up or Invest in ' . $ticker . ' stock at the top of this page</li><li>Breeze through our fully digital and secure KYC process and open your US Brokerage account in a few minutes</li><li>Transfer USD funds to your US Brokerage account and start investing in ' . $name . ' shares</li></ul>'
            ),
            array(
                'position' => 4,
                'question' => 'What is <span>' . $name . '</span> 52-week high and low stock price?',
                'answer' => '<p>The 52-week high price of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is <span>$' . $highRange . '</span>. The 52-week low price of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is <span>$' . $lowRange . '</span>.</p>'
            ),
            array(
                'position' => 5,
                'question' => 'What is <span>' . $name . '</span> price-to-earnings (P/E) ratio?',
                'answer' => '<p>The price-to-earnings (P/E) ratio of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is <span>' . $peRatio . '</span></p>'
            ),
            array(
                'position' => 6,
                'question' => 'What is <span>' . $name . '</span> price-to-book (P/B) ratio?',
                'answer' => '<p>The price-to-book (P/B) ratio of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is ' . $priceBookMRQ . '</p>'
            ),
            array(
                'position' => 7,
                'question' => 'What is <span>' . $name . '</span> dividend yield?',
                'answer' => '<p>The dividend yield of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is <span>' . ($dividendYieldValue ? $dividendYieldValue : '0.00%') . '</span></p>'
            ),
            array(
                'position' => 8,
                'question' => 'What is the Market Cap of <span>' . $name . '</span>?',
                'answer' => '<p>The market capitalization of <span>' . $name . '</span> (<span>' . $ticker . '</span>) is <span>' . $marketCapValue . '</span></p>'
            ),
            array(
                'position' => 9,
                'question' => 'What is <span>' . $name . '</span>\'s stock symbol?',
                'answer' => '<p>The stock symbol (or ticker) of <span>' . $name . '</span> is <span>' . $ticker . '</span></p>'
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
                                <h3 class="faq_question"><?php echo $faq['question']; ?></h3>
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
                <?php 
                $schema_items = array();
                foreach ($all_faqs as $faq) {
                    $question_text = strip_tags($faq['question']);
                    $answer_text = strip_tags($faq['answer']);
                    $schema_items[] = json_encode(array(
                        "@type" => "Question",
                        "name" => $question_text,
                        "acceptedAnswer" => array(
                            "@type" => "Answer",
                            "text" => $answer_text
                        )
                    ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
                echo implode(",\n                ", $schema_items);
                ?>
            ]
        }
    </script>
<?php
    } else {
        echo "Error retrieving data"; // Handle error
    }
?>