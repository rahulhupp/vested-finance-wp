<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
		setTimeout(() => {
			callAnalystForecastApi();
		}, 5000);
	});
    
    function callAnalystForecastApi() {
        const instrumentsApiUrl = 'https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/analysts-predictions'; // Replace with the actual URL of the second API

        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        
        fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            var analystChartSkeleton = document.getElementById('analyst_chart_skeleton');
            analystChartSkeleton.style.display = 'none';
            bindAnalystForecastData(data); 
        })
        .catch(error => console.error('Error:', error));
    }

    function bindAnalystForecastData(data) {
        var distributionData = data.data.distribution;
        distributionData = combineLabels(distributionData, "Strong Buy", "Buy", "Buy");
        distributionData = combineLabels(distributionData, "Strong Sell", "Sell", "Sell");

        var distributionDataLabels = distributionData.map(({ label }) => label);
        var distributionDataPercent = distributionData.map(({ percent }) => percent);

        var forecastChart = document.getElementById("analystForecastChart");
        var forecastData = {
            labels: distributionData.map(({ label }) => label),
            datasets: [
                {
                    data: distributionData.map(({ percent }) => percent),
                    backgroundColor: [
                        createGradient(201, "#01A86E", 0.0314, "#006744", 0.8388),
                        createGradient(201, "#002852", 0.0314, "#000D1B", 0.8388),
                        createGradient(201, "#DC2626", 0.0314, "#7F1D1D", 0.8388)
                    ],
                    borderWidth: 4
                }]
        };

        function createGradient(deg, color1, percentage1, color2, percentage2) {
            var ctx = forecastChart.getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(percentage1, color1);
            gradient.addColorStop(percentage2, color2);
            return gradient;
        }

        var options = {
            plugins: {
                tooltip: false,
                legend: {
                    display: false
                },
                datalabels: {
                    color: '#FFFFFF',
                    textAlign: 'center',
                    font: {
                        lineHeight: 1.6,
                        fontSize: '34px'
                    },
                    formatter: function(value, ctx) {
                        return  value + '%' + '\n' + ctx.chart.data.labels[ctx.dataIndex];
                    }
                }
            }
        };

        var pieChart = new Chart(forecastChart, {
            type: 'pie',
            data: forecastData,
            options: options,
            plugins: [ChartDataLabels]
        });
    }

    function combineLabels(data, label1, label2, combinedLabel) {
        const index1 = data.findIndex(item => item.label === label1);
        const index2 = data.findIndex(item => item.label === label2);

        if (index1 !== -1 && index2 !== -1) {
            const combinedValue = data[index1].value + data[index2].value;
            const combinedPercent = data[index1].percent + data[index2].percent;

            data[index1] = {
                "label": combinedLabel,
                "value": combinedValue,
                "percent": combinedPercent
            };

            data.splice(index2, 1);
        }

        return data;
    }
</script>