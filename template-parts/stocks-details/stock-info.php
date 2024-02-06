<?php $symbol_uppercase = strtoupper($symbol); ?>
<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>
<?php
    $instrumentsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/' . $symbol . '/overview';

    // Set headers
    $headers = array(
        'x-csrf-token: ' . $token->csrf,
        'Authorization: Bearer ' . $token->jwToken
    );

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $instrumentsApiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for cURL errors
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response);

    // Check if response is successful
    if ($data && isset($data->data)) {
        $change = $data->data->change;
        if ($change < 0) {
            $changeClass = 'negative';
            $changeText = '(-$' . abs($change) . ')';
        } else {
            $changeClass = '';
            $changeText = '($' . $change . ')';
        }
        $changePercent = $data->data->changePercent;
        $changePercentClass = ($changePercent < 0) ? 'negative' : '';
        $tags = $data->data->tags;
?>
    <div class="stock_details_box stock_info_container">
        <div class="stock_info_icons">
            <div class="stock_img">
                <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/<?php echo $symbol_uppercase; ?>.png" alt="<?php echo $symbol; ?>-img" />
            </div>
            <div class="share_icon" onclick="copyLink()">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
            </div>
        </div>
        <h1><?php echo $data->data->name . ', ' . $data->data->type; ?></h1>
        <h2><?php echo $symbol_uppercase; ?></h2>
        <h6><?php echo $data->data->exchange; ?></h6>
        <div class="stock_price_box">
            <h3><?php echo $data->data->price; ?></h3>
            <h4 class="<?php echo $changePercentClass; ?>"><?php echo $changePercent; ?></h4>
            <h4 class="<?php echo $changeClass; ?>"><?php echo $changeText; ?></h4>
            <span>1D</span>
        </div>
        <div class="stock_tags">
            <?php foreach ($tags as $tag): ?>
                <span><?php echo $tag->label . ': ' . $tag->value; ?></span>
            <?php endforeach; ?>
        </div>
        <a href="#" class="signup_url"><button class="primary_button">Invest in <?php echo $symbol_uppercase; ?> stock</button></a>
        <button class="secondary_button" onclick="openACModal('add_watchlist')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path opacity="0.8" d="M11.9662 13.6667L7.81807 10.7037L3.66992 13.6667V4.18519C3.66992 3.87085 3.79479 3.5694 4.01705 3.34713C4.23932 3.12487 4.54078 3 4.85511 3H10.781C11.0954 3 11.3968 3.12487 11.6191 3.34713C11.8414 3.5694 11.9662 3.87085 11.9662 4.18519V13.6667Z" stroke="#002852" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>    
            <span>Add to watchlist</span>
        </button>
    </div>

<?php
    } else {
        // Handle error or no data scenario
        echo "Error retrieving data";
        // Output response for debugging
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }
?>