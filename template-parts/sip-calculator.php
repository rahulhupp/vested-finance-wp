<section class="calculator_section">
	<div class="container">
		<div class="calculator_wrapper">
			<h1>SIP Calculator</h1>
			<p>A SIP calculator is a tool that helps investors calculate the maturity value of their investments made through the Systematic Investment Plan (SIP) route.</p>
			<div class="calculator_box_container">
				<div class="calculator_box_calculation">
					<div class="calculation_tabs">
						<span>SIP</span>
						<a href="<?php echo home_url(); ?>/calculators/lumpsum-calculator/">Lumpsum</a>
					</div>
					<div class="calculation_input_container">
						<label>Monthly Investment</label>
						<div class="investment_input_group">
							<span id="currencySymbol">₹</span>
							<input type="number" id="monthlyInvestment" min="500" max="100000" value="25000" class="calculation_input" />
							<div class="currency_switcher">
								<input type="radio" id="inr" name="currency" value="INR" checked>
								<label for="inr">INR</label>
								<input type="radio" id="usd" name="currency" value="USD">
								<label for="usd">USD</label>
							</div>
						</div>
						<div class="investment_range_container">
							<input type="range" min="500" max="100000" value="25000" id="monthlyInvestmentRange" class="calculation_range_input" />
							<div class="investment_range_wrapper">
								<h6 id="minMonthlyInvestment">₹500</h6>
								<div class="investment_range_steps">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
								<h6 id="maxMonthlyInvestment">₹1L</h6>
							</div>
						</div>
					</div>
					<div class="calculation_input_container">
						<div class="calculation_input_wrapper">
							<label>Expected Returns Rate (P.A.)</label>
							<div class="returns_input_group">
								<input type="number" id="expectedReturns" min="1" max="25" step="0.1" value="12" class="calculation_input" />
								<span>%</span>
							</div>
						</div>
						<div class="investment_range_container">
							<input type="range" min="1" max="25" value="12" step="0.1" id="expectedReturnsRange" class="calculation_range_input" />
							<div class="investment_range_wrapper">
								<h6>1%</h6>
								<div class="investment_range_steps">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
								<h6>25%</h6>
							</div>
						</div>
					</div>
					<div class="calculation_input_container">
						<div class="calculation_input_wrapper">
							<label>Time Period</label>
							<div class="time_input_group">
								<input type="number" id="timePeriod" min="1" max="50" value="10" class="calculation_input" />
								<span>years</span>
							</div>
						</div>
						<div class="investment_range_container">
							<input type="range" min="1" max="50" value="10" id="timePeriodRange" class="calculation_range_input" />
							<div class="investment_range_wrapper">
								<h6>1Y</h6>
								<div class="investment_range_steps">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
								<h6>50Y</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="calculator_box_result">
					<h2>Your Returns</h2>
					<div class="calculator_result_wrapper">
						<div class="calculator_progressbar">
							<div class="progressbar_container">
								<div class="progressbar">
									<svg class="progressbar__svg">
										<circle cx="80" cy="80" r="70" class="progressbar__svg-circle circle-html shadow-html" id="investedCircle"> </circle>
									</svg>
								</div>
								<div class="progressbar">
									<svg class="progressbar__svg">
										<circle cx="80" cy="80" r="70" class="progressbar__svg-circle circle-html shadow-html" id="estimatedCircle"> </circle>
									</svg>
								</div>
								<div class="progressbar_total">
									<span>Total Value</span>
									<strong id="totalValue">0</strong>
								</div>
							</div>
						</div>
						<div class="calculator_result_content">
							<div class="result_item">
								<span style="background-color: #B3D2F1;"></span>
								<h6>Invested Amount</h6>
								<h5 id="investedAmount"></h5>
							</div>
							<div class="result_item">
								<span style="background-color: #002852;"></span>
								<h6>Estimated Returns</h6>
								<h5 id="estimatedReturns"></h5>
							</div>
							<div class="result_item">
								<span style="background-color: transparent;"></span>
								<h6>Total Value</h6>
								<h5 id="totalValue"></h5>
							</div>
						</div>
					</div>
					<div class="calculator_result_footer">
						<p>Easily diversify into US Stocks, P2P Lending, Bonds and Solar with Vested</p>
						<a href="#">Start Investing</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	console.log('Hello');
	function updateCurrencySymbol() {
		const currencySymbol = document.getElementById('currencySymbol');
		const selectedCurrency = document.querySelector('input[name="currency"]:checked').value;
		currencySymbol.textContent = selectedCurrency === 'INR' ? '₹' : '$';

		const monthlyInvestmentRange = document.getElementById("monthlyInvestmentRange");
    	const monthlyInvestment = document.getElementById("monthlyInvestment");

		if (selectedCurrency === 'USD') {
			setRangeValues(monthlyInvestmentRange, 10, 10000, 2500);
			setAttributeValues(monthlyInvestment, 10, 10000, 2500);
		} else {
			setRangeValues(monthlyInvestmentRange, 500, 100000, 25000);
			setAttributeValues(monthlyInvestment, 500, 100000, 25000);
		}
		
		updateGradient(monthlyInvestmentRange);
    	calculateSIP();
	}

	function setRangeValues(element, min, max, value) {
		element.min = min;
		element.max = max;
		element.value = value;
	}

	function setAttributeValues(element, min, max, value) {
		element.setAttribute("min", min);
		element.setAttribute("max", max);
		element.value = value;
	}

	function convertToShortForm(number) {
		if (number === 100000) {
			return '1L';
		} else if (number >= 1000000) {
			return (number / 1000000).toFixed(0) + 'M';
		} else if (number >= 1000) {
			return (number / 1000).toFixed(0) + 'K';
		} else {
			return number;
		}
	}


	calculateSIP();

	function calculateSIP() {
		const monthlyInvestmentId = document.getElementById('monthlyInvestment');
		const monthlyInvestment = parseFloat(monthlyInvestmentId.value);
		const expectedReturns = parseFloat(document.getElementById('expectedReturns').value) / 100;
		const timePeriod = parseFloat(document.getElementById('timePeriod').value);
		const currencySymbol = document.getElementById('currencySymbol').textContent;
		const minValue = parseFloat(monthlyInvestmentId.getAttribute('min'));
		const maxValue = parseFloat(monthlyInvestmentId.getAttribute('max'));
		document.getElementById('minMonthlyInvestment').textContent = `${currencySymbol}${minValue}`;
		document.getElementById('maxMonthlyInvestment').textContent = `${currencySymbol}${convertToShortForm(maxValue)}`;

		let totalValue = 0;
		let investedAmount = 0;

		for (let i = 1; i <= timePeriod * 12; i++) {
			totalValue = (totalValue + monthlyInvestment) * (1 + expectedReturns / 12);
			investedAmount += monthlyInvestment;
		}

		const estimatedReturns = totalValue - investedAmount;
		const investmentPercentage = (investedAmount / totalValue) * 100;
		const returnPercentage = (estimatedReturns / totalValue) * 100;
		
		updateInvestedDashOffset(investmentPercentage.toFixed(2));
		updateEstimatedDashOffset(returnPercentage.toFixed(2));

		document.getElementById('investedAmount').innerHTML = `${currencySymbol}${maskCurrency(investedAmount.toFixed(0))}`;
		document.getElementById('estimatedReturns').innerHTML = `${currencySymbol}${maskCurrency(estimatedReturns.toFixed(0))}`;
		var totalValueText = document.querySelectorAll('#totalValue');
		totalValueText.forEach(function(total) {
			total.innerHTML = `${currencySymbol}${maskCurrency(totalValue.toFixed(0))}`;
		});
		
	}

	function updateInvestedDashOffset(value) {
		var circleElement = document.getElementById('investedCircle');
		if (circleElement) {
			circleElement.style.strokeDashoffset = 440 - (440 * value) / 100;
		}
	}

	function updateEstimatedDashOffset(value) {
		var circleElement = document.getElementById('estimatedCircle');
		if (circleElement) {
			circleElement.style.strokeDashoffset = 440 - (440 * value) / 100;
		}
	}

	function calculatePercentage(totalValue, investedAmount) {
		return ((totalValue - investedAmount) / investedAmount) * 100;
	}

	function addRangeInputListener(inputId, rangeId) {
		const input = document.getElementById(inputId);
		const range = document.getElementById(rangeId);
		
		input.addEventListener('blur', function () {
			const minValue = parseFloat(input.getAttribute('min'));
			const maxValue = parseFloat(input.getAttribute('max'));
			let value = parseFloat(this.value);
			if (isNaN(value) || value < minValue) {
				value = minValue;
			} else if (value > maxValue) {
				value = maxValue;
			}

			this.value = value;
			range.value = value;
			updateGradient(range);
			calculateSIP();
		});

		range.addEventListener('input', function () {
			input.value = this.value;
			calculateSIP();
		});
	}

	window.addEventListener('DOMContentLoaded', function () {
		addRangeInputListener('monthlyInvestment', 'monthlyInvestmentRange');
		addRangeInputListener('expectedReturns', 'expectedReturnsRange');
		addRangeInputListener('timePeriod', 'timePeriodRange');
	});

	document.querySelectorAll('input[name="currency"]').forEach(function (radio) {
		radio.addEventListener('change', function () {
			updateCurrencySymbol();
		});
	});

	updateCurrencySymbol(); // Initialize currency symbol



	// Function to update the gradient based on the current value of the input range
	function updateGradient(progress) {
		const value = progress.value;
		const min = progress.min;
		const max = progress.max;
		const percentage = ((value - min) / (max - min)) * 100;
		progress.style.background = `linear-gradient(to right, #002852 0%, #002852 ${percentage}%, #EEEEEE ${percentage}%, #EEEEEE 100%)`;
	}

	// Range Input
	const progresses = document.querySelectorAll('.calculation_range_input');
	progresses.forEach(progress => {
		updateGradient(progress);
	});

	progresses.forEach(progress => {
		progress.addEventListener('input', function() {
			updateGradient(this);
		});
	});

	function maskCurrency(amount) {
		let parts = amount.toString().split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		return parts.join('.');
	}
</script>