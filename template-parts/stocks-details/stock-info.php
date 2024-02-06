
<?php 
    $symbol_uppercase = strtoupper($symbol);
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
    $overview_data = fetch_overview_api_data($symbol, $token);
?>


<?php
    // Check if response is successful
    if ($overview_data) {
        $change = $overview_data->change;
        if ($change < 0) {
            $changeClass = 'negative';
            $changeText = '(-$' . abs($change) . ')';
        } else {
            $changeClass = '';
            $changeText = '($' . $change . ')';
        }
        $changePercent = $overview_data->changePercent;
        $changePercentClass = ($changePercent < 0) ? 'negative' : '';
        $tags = $overview_data->tags;

        $ticker = $overview_data->ticker;
        $name = $overview_data->name;
        $formattedName = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
        $formattedTicker = strtolower(str_replace(' ', '-', $ticker));
        $signupurl = 'https://app.vestedfinance.com/signup?redirect_uri=stocks/' . $formattedTicker . '/' . $formattedName . '-share-price';

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
        <h1><?php echo $name . ', ' . $overview_data->type; ?></h1>
        <h2><?php echo $symbol_uppercase; ?></h2>
        <h6><?php echo $overview_data->exchange; ?></h6>
        <div class="stock_price_box">
            <h3><?php echo $overview_data->price; ?></h3>
            <h4 class="<?php echo $changePercentClass; ?>"><?php echo $changePercent; ?></h4>
            <h4 class="<?php echo $changeClass; ?>"><?php echo $changeText; ?></h4>
            <span>1D</span>
        </div>
        <div class="stock_tags">
            <?php foreach ($tags as $tag): ?>
                <span><?php echo $tag->label . ': ' . $tag->value; ?></span>
            <?php endforeach; ?>
        </div>
        <a href="<?php echo $signupurl; ?>"><button class="primary_button">Invest in <?php echo $symbol_uppercase; ?> stock</button></a>
        <button class="secondary_button" onclick="openACModal('add_watchlist')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path opacity="0.8" d="M11.9662 13.6667L7.81807 10.7037L3.66992 13.6667V4.18519C3.66992 3.87085 3.79479 3.5694 4.01705 3.34713C4.23932 3.12487 4.54078 3 4.85511 3H10.781C11.0954 3 11.3968 3.12487 11.6191 3.34713C11.8414 3.5694 11.9662 3.87085 11.9662 4.18519V13.6667Z" stroke="#002852" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>    
            <span>Add to watchlist</span>
        </button>
    </div>

<?php
} else {
    echo "Error retrieving data"; // Handle error
}
?>