<?php
    // Step 1: Get the partner token
    $token_url = 'https://vested-api-prod.vestedfinance.com/get-partner-token';
    $headers = [
        'partner-id: 7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
        'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9',
        'vest-list-access: true'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $token = curl_exec($ch);
    curl_close($ch);

    if ($token) {
        // Step 2: Get the vests list
        $vests_url = 'https://vested-api-prod.vestedfinance.com/v1/partner/vests-list';
        $vests_headers = [
            'partner-authentication-token: ' . $token,
            'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9'
        ];

        $ch2 = curl_init($vests_url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $vests_headers);
        $vests_response = curl_exec($ch2);
        curl_close($ch2);

        $vests_data = json_decode($vests_response, true);

        if (!empty($vests_data['vests'])) {
            // Convert to array and sort by oneYearReturn
            $vests = array_values($vests_data['vests']);
            usort($vests, function($a, $b) {
                if ($a['oneYearReturn'] === "NaN%") return 1;
                if ($b['oneYearReturn'] === "NaN%") return -1;
                return floatval($b['oneYearReturn']) - floatval($a['oneYearReturn']);
            });
        }
    }

    // Get the dynamic allowed vest IDs from the main template
    $allowed_vest_ids = get_query_var('allowed_vest_ids', []);
?>

<div class="vests_list core_vests_list">
    <?php
        if ($vests && is_array($vests) && !empty($allowed_vest_ids)) {
            // Filter vests to only include the allowed IDs, preserving order
            $filtered_vests = array_filter($vests, function($vest) use ($allowed_vest_ids) {
                return in_array($vest['vestId'], $allowed_vest_ids);
            });

            // Sort filtered vests to match the order of $allowed_vest_ids
            usort($filtered_vests, function($a, $b) use ($allowed_vest_ids) {
                return array_search($a['vestId'], $allowed_vest_ids) - array_search($b['vestId'], $allowed_vest_ids);
            });

            if (count($filtered_vests) > 0) {
                foreach ($filtered_vests as $vest) {
                    $riskText = 'Aggressive';
                    if ($vest['risk'] >= 0 && $vest['risk'] <= 2) $riskText = 'Conservative';
                    elseif ($vest['risk'] == 3) $riskText = 'Moderate';
                    ?>
                    <div class="vest_item">
                        <div class="vest_content">
                            <h3><?php echo htmlspecialchars($vest['name']); ?></h3>
                            <p><?php echo htmlspecialchars($vest['blurb']); ?></p>
                        </div>
                        <div class="vest_details">
                            <a href="https://app.vestedfinance.com/vest-details?vestId=<?php echo htmlspecialchars($vest['vestId']); ?>" target="_blank">
                                <div class="vest_img">
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/img/vest/icon/<?php echo htmlspecialchars($vest['vestId']); ?>.svg" alt="solid-foundations" />
                                </div>
                                <div class="vest_name">
                                    <?php echo htmlspecialchars($vest['name']); ?>
                                </div>
                                <p><?php echo htmlspecialchars($vest['shortBlurb']); ?></p>
                                <div class="vest_return">
                                    <span>1Y Return</span>
                                    <?php echo htmlspecialchars($vest['oneYearReturn']); ?>
                                </div>
                                <div class="vest_metrics">
                                    <div class="vest_metric vest_metric_half">
                                        <span>Min. Investment</span>
                                        $100
                                    </div>
                                    <div class="vest_metric vest_metric_half">
                                        <span>Dividend Yield</span>
                                        2.5%
                                    </div>
                                    <div class="vest_metric">
                                        <span>Annualized Volatility</span>
                                        <?php echo htmlspecialchars($vest['oneYearVolatility']); ?>
                                    </div>
                                    <div class="vest_metric">
                                        <span>Allocations</span>
                                        20% Stocks, 80% Bonds
                                    </div>
                                </div>
                                <div class="vests_footer">
                                    <span><?php echo htmlspecialchars($vest['poweredByText']); ?></span>
                                    <img src="https://d13dxy5z8now6z.cloudfront.net/<?php echo htmlspecialchars($vest['poweredByLogo']); ?>" alt="solid-foundations" />
                                    <span><?php echo htmlspecialchars($vest['poweredBy']); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No vests found.</p>';
            }
        } else {
            echo '<p>No vests found.</p>';
        }
    ?>
</div>