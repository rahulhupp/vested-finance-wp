<?php $analysts_data = $args['analysts_data']; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        bindAnalystForecastData(<?php echo json_encode($analysts_data); ?>); 
	});

    function bindAnalystForecastData(data) {
        var distributionData = data.distribution;
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