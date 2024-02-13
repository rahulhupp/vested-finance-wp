<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
		setTimeout(() => {
			callReturnsApi();
		}, 1000);
	});

    function callReturnsApi() {
        const returnsApiUrl = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/returns';
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        fetch(returnsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            var returnsSkeleton = document.getElementById('returns_skeleton');
            var returnsSkeletonAfter = document.getElementById('returns_skeleton_after');
            returnsSkeleton.style.display = 'none';
            returnsSkeletonAfter.style.display = 'block';
            bindAbsoluteReturnsData(data); 
            bindAnnualizedReturnsData(data); 
        })
        .catch(error => console.error('Error:', error));
    }

    function callReturnsCompareApi(returnData, ticker) {
        const returnsCompareApiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/returns?compare=${ticker}`;
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        fetch(returnsCompareApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            bindAbsoluteReturnsData(data);
            bindAnnualizedReturnsData(data);
            var currentTable = document.getElementById('absolute_returns_table');
            currentTable.classList.add('ticker_added');
            var currentTable = document.getElementById('annualized_returns_table');
            currentTable.classList.add('ticker_added');
        })
        .catch(error => console.error('Error:', error));
    }

    function bindAbsoluteReturnsData(data) {
        var table = document.getElementById('ab_returns_table');
        
        if (table) {
            table.parentNode.removeChild(table);
        }

        const returnTableData = data.data;
        var table = document.createElement('table');
        table.id = 'ab_returns_table';
        var thead = document.createElement('thead');
        var tbody = document.createElement('tbody');

        // Add table header
        var headerRow = document.createElement('tr');
        for (var key in returnTableData) {
            if (returnTableData.hasOwnProperty(key) && returnTableData[key].value) {
                var label = returnTableData[key].label;
                if (key === 'reference') {
                    headerRow.innerHTML += `<th>${label}<button onclick="openModalAddTicker('absolute_returns')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>`;
                } else {
                    headerRow.innerHTML += `<th>${label}</th>`;
                }
            }
        }
        thead.appendChild(headerRow);
        

        for (var timeFrameKey in returnTableData.timeFrames.value) {
            var timeFrame = returnTableData.timeFrames.value[timeFrameKey].key;

            var row = document.createElement('tr');
            row.innerHTML = `<td>${returnTableData.timeFrames.value[timeFrameKey].label}</td>`;

            for (var key in returnTableData) {
                if (returnTableData.hasOwnProperty(key) && returnTableData[key].value && returnTableData[key].value[timeFrame]) {
                    var value = returnTableData[key].value[timeFrame].value;
                    row.innerHTML += `<td>${value}</td>`;
                }
            }

            tbody.appendChild(row);
        }

        // Append thead and tbody to the table
        table.appendChild(thead);
        table.appendChild(tbody);

        // Append the table to the "returns_table" div
        document.getElementById('absolute_returns_table').appendChild(table);
    }

    function bindAnnualizedReturnsData(data) {
        var table = document.getElementById('an_returns_table');
        
        if (table) {
            table.parentNode.removeChild(table);
        }

        const returnTableData = data.data;
        var table = document.createElement('table');
        table.id = 'an_returns_table';
        var thead = document.createElement('thead');
        var tbody = document.createElement('tbody');

        // Add table header
        var headerRow = document.createElement('tr');
        for (var key in returnTableData) {
            if (returnTableData.hasOwnProperty(key) && returnTableData[key].value) {
                var label = returnTableData[key].label;
                if (key === 'reference') {
                    headerRow.innerHTML += `<th>${label}<button onclick="openModalAddTicker('annualized_returns')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>`;
                } else {
                    headerRow.innerHTML += `<th>${label}</th>`;
                }
            }
        }

        thead.appendChild(headerRow);

        

        // Add table rows
        for (var key in returnTableData.timeFrames.value) {
            var timeFrameKey = returnTableData.timeFrames.value[key].key;

            // Check if the required properties exist
            if (returnTableData) {
                var heading = returnTableData.timeFrames.value[key].label;

                var days = convertHeadingToDays(heading);

                var stockValue = returnTableData.current.value[timeFrameKey].value;
                var sectorValue = returnTableData.sector.value[timeFrameKey].value;
                var sp500Value = returnTableData.sp500.value[timeFrameKey].value;

                if (returnTableData.reference) {
                    var referenceValue = returnTableData.reference.value[timeFrameKey].value;
                }
                
              
                let stockNumericValue = parseFloat(stockValue.replace("%", ""));
                if (isNaN(stockNumericValue)) {
                    var stockPercentChange = stockValue;
                } else {
                    var stockPercentChange = `${((((1 + (stockNumericValue / 100)) ** (365/days)) - 1) * 100).toFixed(2)}%`;
                    // (((1 + (1089 / 100)) ^ (1/10)) - 1) * 100
                }
                

                let sectorNumericValue = parseFloat(sectorValue.replace("%", ""));
                if (isNaN(sectorNumericValue)) {
                    var sectorPercentChange = stockValue;
                } else {
                    var sectorPercentChange = `${((((1 + (sectorNumericValue / 100)) ** (365/days)) - 1) * 100).toFixed(2)}%`;
                }

                let spNumericValue = parseFloat(sp500Value.replace("%", ""));
                if (isNaN(spNumericValue)) {
                    var spPercentChange = stockValue;
                } else {
                    var spPercentChange = `${((((1 + (spNumericValue / 100)) ** (365/days)) - 1) * 100).toFixed(2)}%`;
                }

                if (returnTableData.reference) {
                    let referenceNumericValue = parseFloat(referenceValue.replace("%", ""));
                    if (isNaN(referenceNumericValue)) {
                        var referencePercentChange = referenceValue;
                    } else {
                        var referencePercentChange = `${((((1 + (referenceNumericValue / 100)) ** (365/days)) - 1) * 100).toFixed(2)}%`;
                    }
                }

                var row = document.createElement('tr');
                if (returnTableData.reference) {
                    row.innerHTML = `<td>${heading}</td><td>${stockPercentChange}</td><td>${sectorPercentChange}</td><td>${spPercentChange}</td><td>${referencePercentChange}</td>`;
                } else {
                    row.innerHTML = `<td>${heading}</td><td>${stockPercentChange}</td><td>${sectorPercentChange}</td><td>${spPercentChange}</td>`;
                }
                
                tbody.appendChild(row);
            } else {
                console.error('Data structure is not as expected for time frame: ', timeFrameKey);
            }
        }

        function convertHeadingToDays(heading) {
            switch (heading) {
                case '1-Week Return':
                    return 7;
                case '1-Month Return':
                    return 30;
                case '3-Month Return':
                    return 90;
                case '6-Month Return':
                    return 180;
                case '1-Year Return':
                    return 365;
                case '3-Year Return':
                    return 3 * 365;
                case '5-Year Return':
                    return 5 * 365;
                case '10-Year Return':
                    return 10 * 365;
                default:
                    return null; // Handle the case where the heading is not recognized
            }
        }

        // Append thead and tbody to the table
        table.appendChild(thead);
        table.appendChild(tbody);

        // Append the table to the "returns_table" div
        document.getElementById('annualized_returns_table').appendChild(table);
    }
</script>