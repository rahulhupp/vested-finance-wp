<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>
<script>
    callOverviewApi();

    function callOverviewApi() {
        const instrumentsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/overview'; // Replace with the actual URL of the second API

        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        
        fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            callChartApi('1Y', 'daily');
            bindOverviewData(data);
            updateMetaTags(data);            
         })
        .catch(error => console.error('Error:', error));
    }

    function bindOverviewData(data) {
        // setTextContent('stock_title', `${data.data.name}` + "," + `${data.data.type}`);
        // setTextContent('stock_exchange', data.data.exchange);
        // setTextContent('stock_price', `$${data.data.price}`);
        // setTextContent('stock_changePercent', `${data.data.changePercent}%`);
        

        var stockNameElements = document.querySelectorAll('#faq_stock_name');
        stockNameElements.forEach(function (element) {
            element.textContent = data.data.name;
        });

        var stockTickerElements = document.querySelectorAll('#faq_stock_ticker');
        stockTickerElements.forEach(function (element) {
            element.textContent = data.data.ticker;
        });

        var stockPriceElements = document.querySelectorAll('#faq_stock_price');
        stockPriceElements.forEach(function (element) {
            element.textContent = data.data.price;
        });

        const high52WeekRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).value.high;
        setTextContent('faq_stock_52_week_high', high52WeekRange);

        const low52WeekRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).value.low;
        setTextContent('faq_stock_52_week_low', low52WeekRange);

        const peRatio = (data.data.summary.find(item => item.label === "P/E Ratio") || {}).value;
        setTextContent('faq_stock_pe_ratio', peRatio);
        setTextContent('pe_ratio', peRatio);

        const dividendYieldValue = (data.data.summary.find(item => item.label === "Dividend Yield") || {}).value;
        setTextContent('faq_stock_dividend_yield', dividendYieldValue);
        setTextContent('dividend_yield', dividendYieldValue);

        const marketCapValue = (data.data.summary.find(item => item.label === "Market Cap") || {}).value;
        setTextContent('faq_stock_market_cap', marketCapValue);
        setTextContent('market_cap', marketCapValue);

        const volumeValue = (data.data.summary.find(item => item.label === "Volume") || {}).value;
        setTextContent('volume', volumeValue);
        const avgVolumeValue = (data.data.summary.find(item => item.label === "Avg Volume") || {}).value;
        setTextContent('avg_volume', avgVolumeValue);
        const betaValue = (data.data.summary.find(item => item.label === "Beta") || {}).value;
        setTextContent('beta', betaValue);
        

        // var stockChangeElement = document.getElementById('stock_change');
        // if (data.data.change < 0) {
        //     stockChangeElement.classList.add('negative');
        //     setTextContent('stock_change', `(-$${data.data.change.toString().replace('-', '')})`);
        // } else {
        //     setTextContent('stock_change', `($${data.data.change})`);
        // }
   
        // var stockChangePercentElement = document.getElementById('stock_changePercent');
        // if (data.data.changePercent < 0) {
        //     stockChangePercentElement.classList.add('negative');
        // }
        
        // var stockTags = document.getElementById('stock_tags');
        // data.data.tags.forEach(tag => stockTags.innerHTML += `<span>${tag.label}: ${tag.value}</span>`);
        
        
        setTextContent('stock_about_title', `About ${data.data.name}` + "," + `${data.data.type}`);
        
        var limitedDescription = data.data.description.split(' ').slice(0, 35).join(' ');
        var stockAboutDescription = document.getElementById('stock_about_description');
        stockAboutDescription.innerHTML += `${limitedDescription}...<span onclick="showMore('${data.data.description}')">more</span>`;
       
        var stockAboutTags = document.getElementById('stock_about_tags');
        data.data.tags.forEach(tag => stockAboutTags.innerHTML += `<span>${tag.label}: ${tag.value}</span>`);
        
        const highRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).raw.high;
        const lowRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).raw.low;
        setTextContent('range_low', `$${lowRange}`);
        setTextContent('range_high', `$${highRange}`);
        setTextContent('range_current', `$${data.data.price}`);
        const rangePercentage = ((data.data.price - lowRange) / (highRange - lowRange)) * 100;
        const rangeCurrentPercentage = document.getElementById('range_current_percentage');
        rangeCurrentPercentage.style.left = `calc(${rangePercentage}% - 28px)`;


        var ticker = data.data.ticker;
        var name = data.data.name;
        var formattedName = name.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        var formattedTicker = ticker.toLowerCase().replace(/\s+/g, '-');
        var signupurl = `https://app.vestedfinance.com/signup?redirect_uri=stocks/${formattedTicker}/${formattedName}-share-price`;
        
        setTimeout(function() {
            var elements = document.querySelectorAll(".signup_url");
            elements.forEach(function(element) {
                element.href = signupurl;
            });
        }, 1000);
        
        var feedbackLinkAdd = document.getElementById('feedback_link_add');
        var feedbackLinkIncorrect = document.getElementById('feedback_link_incorrect');

        feedbackLinkAdd.href = `https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=${formattedTicker}&company_name=${formattedName}&feedback_type=add_data`;
        feedbackLinkIncorrect.href = `https://vestedfinance.typeform.com/to/C5vDYzi5#ticker=${formattedTicker}&company_name=${formattedName}&feedback_type=incorrect_data`;

    }
</script>