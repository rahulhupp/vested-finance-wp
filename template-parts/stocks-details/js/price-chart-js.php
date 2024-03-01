<script defer>
	document.addEventListener("DOMContentLoaded", function() {
		setTimeout(() => {
			callChartApi('1Y', 'daily');
		}, 5000);
	});
	
    function handleButtonClick(button) {
        var buttons = document.querySelectorAll('.stock_chart_buttons button');
        buttons.forEach(function (btn) {
            btn.classList.remove('active');
        });
        button.classList.add('active');
    }

    function callChartApi(timeframe, interval) {
        if (event) {
            var button = event.target;
            handleButtonClick(button); // Add or remove active class
        }
        var chartLoaderContainer = document.getElementById('chart_loader_container');
		var priceChartSkeleton = document.getElementById('price_chart_skeleton');
        chartLoaderContainer.style.opacity = '1';

        // const apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/ohlcv?timeframe=${timeframe}&hermes=true`;
        let apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/ohlcv?timeframe=${timeframe}`;
        if (interval === 'daily') {
            apiUrl += '&interval=daily';
        }

        fetch(apiUrl, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            bindChartData(data, timeframe, interval);
            chartLoaderContainer.style.opacity = '0';
			priceChartSkeleton.style.display = 'none';
        })
        .catch(error => console.error('Error:', error));
    }

    function bindChartData(data, timeframe, interval) {
			var existingChart = Chart.getChart("stocksLineChart");
			if (existingChart) {
				document.getElementById('stocksLineChart').removeEventListener('mousemove', handleMouseMove);
        		document.getElementById('stocksLineChart').removeEventListener('mouseleave', handleMouseLeave);
				existingChart.destroy();
			}
			const labels = data.data.map(item => item.Date);
			const dataValues = data.data.map(item => interval === 'daily' ? item.Adj_Close : item.Close);

			const chartData = {
				labels: labels,
				datasets: [{
					data: dataValues,
					borderColor: '#002852',
					borderWidth: 2,
					fill: false,
					pointBackgroundColor: "#15803D",
					pointBorderColor: "rgba(21, 128, 61, 0.2)",
					pointBorderWidth: 10,
					pointStyle: 'circle',
					pointRadius: 0, // Set initial point radius to 0
				}]
			};

			var chartOptions = {
				scales: {
					y: {
						grid: {
							color: 'rgba(0,0,0,0)', // Set the grid color to transparent
							drawBorder: false, // Hide the border of the scale
						},
						ticks: {
							callback: function(value, index, ticks) {
								return '$' + value;
							}
						}
					},
					x: {
						grid: {
							color: 'rgba(0,0,0,0)', // Set the grid color to transparent
							drawBorder: false, // Hide the border of the scale
						},
						type: 'timeseries',
						ticks: {
							source: 'labels',
							maxTicksLimit: timeframe === '1Y' ? 5 : 6,
							labelOffset: 30,
						},
						time: {
							unit: getTimeUnit(timeframe),
							displayFormats: {
								'day': 'dd-MMM',
								'year': 'MMM yyyy',
							}
						},
					},
				},
				plugins: {
					tooltip: false,
					legend: {
						display: false
					}
				},
				animation: false
			};


			var ctx = document.getElementById('stocksLineChart').getContext('2d');
			var stocksLineChart = new Chart(ctx, {
				type: 'line',
				data: chartData,
				options: chartOptions
			});

			var throttledHandleMouseMove = throttle(function(event) {
				handleMouseMove(event, stocksLineChart, labels);
			}, 100); // Adjust the delay as needed

			document.getElementById('stocksLineChart').onmousemove = function(event) {
				throttledHandleMouseMove(event);
			};

			document.getElementById('stocksLineChart').onmouseleave = function() {
				handleMouseLeave(stocksLineChart);
			};
			
		}

		function throttle(func, delay) {
			let lastCall = 0;
			return function(...args) {
				const now = new Date().getTime();
				if (now - lastCall >= delay) {
					lastCall = now;
					func(...args);
				}
			};
		}

		function handleMouseMove(event, chartInstance, labels) {
			var chartArea = chartInstance.chartArea;
			var rect = chartInstance.canvas.getBoundingClientRect();
			var mouseX = event.clientX - rect.left;
			var mouseY = event.clientY - rect.top;

			if (mouseX >= chartArea.left && mouseX <= chartArea.right) {
				verticalLine.style.display = 'block';
				verticalLine.style.left = mouseX + 'px';

				// Show the tooltip for the current point
				var activePoints = chartInstance.getElementsAtEventForMode(event, 'index', { intersect: false });
				if (activePoints && activePoints.length > 0) {
					var index = activePoints[0].index;
					chartInstance.options.plugins.tooltip.enabled = true;
					chartInstance.data.datasets[0].pointRadius = function(ctx) {
						return ctx.dataIndex === index ? 6 : 0;
					};
					chartInstance.update();

					var label = labels[index];
					var date = new Date(label);
                   
					var optionsDate = {
						year: 'numeric',
						month: 'short',
						day: 'numeric',
                        timeZone: 'UTC'
					};

					var optionsTime = {
						hour: 'numeric',
						minute: 'numeric',
						hour12: true,
						timeZone: 'UTC'
					};

					var formattedDate = date.toLocaleDateString('en-US', optionsDate);
					var formattedTime = date.toLocaleTimeString('en-US', optionsTime);
					var timeZoneAbbreviation = Intl.DateTimeFormat('en-US', { timeZoneName: 'short', timeZone: 'America/New_York' }).formatToParts(new Date()).find(part => part.type === 'timeZoneName').value;

					var value = chartInstance.data.datasets[0].data[index];

					// Position and display the custom tooltip
					customTooltip.style.left = (mouseX - chartArea.left - 120) + 'px';
					customTooltip.style.top = (mouseY - chartArea.top) + 'px';
					customTooltip.style.display = 'block';
					customTooltip.innerHTML = `<div class="stock_chart_label"><strong>$${value}</strong>on ${formattedDate} <br>${formattedTime} ${timeZoneAbbreviation}</div>`;
				}
			} else {
				handleMouseLeave(chartInstance);
			}
		}

		function handleMouseLeave(chartInstance) {
			verticalLine.style.display = 'none';
			chartInstance.options.plugins.tooltip.enabled = false;
			chartInstance.data.datasets[0].pointRadius = 0;
			chartInstance.update();
			customTooltip.style.display = 'none';
		}

		function getTimeUnit(timeframe) {
			switch (timeframe) {
				case "5Y":
					return 'year';
				case "1M":
					return 'week';
				case "1W":
					return 'day';
				case "1D":
					return 'hour';
				default:
					return 'month';
			}
		}
</script>