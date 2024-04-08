<section class="calculator_section">
	<div class="container">
		<div class="calculator_wrapper">
			<h1>Lumpsum Calculator</h1>
			<?php the_field('description'); ?>
			<div class="calculator_box_container">
				<div class="calculator_box_calculation">
					<div class="calculation_tabs">
                        <a href="<?php echo home_url(); ?>/calculators/sip-calculator/">SIP</a>
						<span>Lumpsum</span>
					</div>
					<div class="calculation_input_container">
						<label>Total Investments</label>
						<div class="investment_input_group">
							<span id="currencySymbol">₹</span>
							<input type="number" id="totalInvestment" min="500" max="100000" value="25000" class="calculation_input" />
							<div class="currency_switcher">
								<input type="radio" id="inr" name="currency" value="INR" checked>
								<label for="inr">INR</label>
								<input type="radio" id="usd" name="currency" value="USD">
								<label for="usd">USD</label>
							</div>
						</div>
						<div class="investment_range_container">
							<input type="range" min="500" max="100000" value="25000" id="totalInvestmentRange" class="calculation_range_input" />
							<div class="investment_range_wrapper">
								<h6>₹500</h6>
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
								<h6>₹1L</h6>
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
	function updateCurrencySymbol() {
		const currencySymbol = document.getElementById('currencySymbol');
		const selectedCurrency = document.querySelector('input[name="currency"]:checked').value;
		currencySymbol.textContent = selectedCurrency === 'INR' ? '₹' : '$';
		calculateSIP();
	}

	calculateSIP();

	function calculateSIP() {
		const totalInvestment = parseFloat(document.getElementById('totalInvestment').value);
		const expectedReturns = parseFloat(document.getElementById('expectedReturns').value) / 100;
		const timePeriod = parseFloat(document.getElementById('timePeriod').value);
		const currencySymbol = document.getElementById('currencySymbol').textContent;

		let totalValue = totalInvestment * Math.pow((1 + expectedReturns / 1), 1 * timePeriod);

        const investedAmount = totalInvestment;
		const estimatedReturns = totalValue - investedAmount;
		const investmentPercentage = (investedAmount / totalValue) * 100;
		const returnPercentage = (estimatedReturns / totalValue) * 100;

		console.log("Percentage of Investment Amount:", investmentPercentage.toFixed(2) + "%");
		console.log("Percentage of Return Value:", returnPercentage.toFixed(2) + "%");
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

	document.getElementById('totalInvestment').addEventListener('input', function () {
		var maxValue = parseFloat(this.getAttribute('max'));
		if (parseFloat(this.value) > maxValue) {
			this.value = maxValue;
		}
		
		const rangeValue = document.getElementById('totalInvestmentRange');
		rangeValue.value = this.value;
		updateGradient(rangeValue);
		calculateSIP();
	});

	document.getElementById('expectedReturns').addEventListener('input', function () {
		var maxValue = parseFloat(this.getAttribute('max'));
		if (parseFloat(this.value) > maxValue) {
			this.value = maxValue;
		}

		const rangeValue = document.getElementById('expectedReturnsRange');
		rangeValue.value = this.value;
		updateGradient(rangeValue);
		calculateSIP();
	});

	document.getElementById('timePeriod').addEventListener('input', function () {
		var maxValue = parseFloat(this.getAttribute('max'));
		if (parseFloat(this.value) > maxValue) {
			this.value = maxValue;
		}

		const rangeValue = document.getElementById('timePeriodRange');
		rangeValue.value = this.value;
		updateGradient(rangeValue);
		calculateSIP();
	});

	document.getElementById('totalInvestmentRange').addEventListener('input', function () {
		document.getElementById('totalInvestment').value = this.value;
		calculateSIP();
	});

	document.getElementById('expectedReturnsRange').addEventListener('input', function () {
		document.getElementById('expectedReturns').value = this.value;
		calculateSIP();
	});

	document.getElementById('timePeriodRange').addEventListener('input', function () {
		document.getElementById('timePeriod').value = this.value;
		calculateSIP();
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