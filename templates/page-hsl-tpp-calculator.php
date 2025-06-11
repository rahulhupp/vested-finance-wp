<?php
/*
Template name: Page - HSL TPP Calculator
*/
get_header(); ?>
<style>
	.hsi_tpp_calculator {
		padding: 42px 0;
	}

	h1 {
		color: #002852;
		font-style: normal;
		font-weight: 600;
		letter-spacing: -1.28px;
		margin-bottom: 10px;
		font-size: 32px;
		line-height: 35.2px;
	}

	.calculator {
		border-radius: 8px;
		border: 1px solid #b6c9db;
		margin-top: 20px;
		display: flex;
		flex-wrap: wrap;
		overflow: hidden;
	}

	.calculator_input {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.calculator form {
		width: 50%;
		padding: 36px;
	}

	.calculator__result {
		width: 50%;
		padding: 36px;
		background-color: #EEF5FC;
	}

	.calculator_input select, .calculator_input select:focus {
		border-radius: 4px;
		width: 100%;
		max-width: 260px;
		border: 1px solid #A9BDD0;
		background: #fff;
		color: #1F2937;
		font-size: 16px;
		line-height: 24px;
		font-weight: 500;
		position: relative;
		-webkit-appearance: none;
		-moz-appearance: none;
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAB6SURBVHgB7ZDBDYAgDEW/TKI31nAD46DGDVyDm0xiNEUPSFs6QN+JAH2PADiOM7C7cT3L4pqR9gyNuIxAOGidtul/HJTRMkiCrly8IwSelwNZjdTy/M408F8kCb7v0s7MAUlE2OT9ABshTHJboI3AKrcH6giscsdxCje0EzktB/V6CwAAAABJRU5ErkJggg==);
		background-size: 24px;
		background-repeat: no-repeat;
		background-position: 96% 50%;
		margin: 0;
		outline-color: #A9BDD0;
	}

	.calculator_input input, .calculator_input input:focus {
		border-radius: 4px;
		width: 100%;
		max-width: 260px;
		border: 1px solid #A9BDD0;
		background: #fff;
		color: #1F2937;
		font-size: 16px;
		line-height: 24px;
		font-weight: 500;
		position: relative;
		margin: 0;
		outline-color: #A9BDD0;
	}

	.calculator_input label {
		font-size: 16px;
		line-height: 20px;
		font-weight: 500;
		color: #1F2937;
	}

	.calculator_input:not(:last-child) {
		margin-bottom: 34px;
	}

	.calculator button {
		width: 100%;
		margin: 0;
		border-radius: 6px;
		background: #0CC886;
		border: 1px solid #0CC886;
		height: 56px;
		color: #FFF;
		font-size: 18px;
		font-weight: 700;
		line-height: 1em;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.5s ease;
	}

	.calculator__result h2 {
		font-size: 20px;
		line-height: 22px;
		font-weight: 600;
		color: #1F2937;
		margin-bottom: 4px;
	}

	.calculator__result p {
		font-size: 14px;
	}

	.calculator__result .result {
		display: flex;
		align-items: center;
		justify-content: space-between;
		border-bottom: 1px dashed rgba(6, 52, 98, 0.3);
		font-size: 16px;
		line-height: 17px;
		color: #1F2937;
		padding-bottom: 4px;
	}

	.calculator__result .result strong {
		font-size: 20px;
		line-height: 22px;
		font-weight: 600;
		color: #1F2937;
	}

	@media (max-width: 1199px) {
		.calculator form {
			padding: 20px;
		}

		.calculator__result {
			padding: 20px;
		}
	}

	@media (max-width: 1023px) {
		.calculator__result {
			width: 40%;
		}

		.calculator__result .result {
			flex-wrap: wrap;
			gap: 10px;
		}

		.calculator form {
			width: 60%;
		}

		.calculator_input label {
			font-size: 14px;
		}

		.calculator_input select, .calculator_input input {
			font-size: 14px;
			max-width: 220px;
		}
		.calculator button {
			font-size: 16px;
			height: 48px;
		}
	}

	@media (max-width: 767px) {
		.calculator form {
			width: 100%;
		}

		.calculator_input {
			display: block;
		}

		.calculator_input select, .calculator_input input {
			max-width: 100%;
		}

		.calculator__result {
			width: 100%;
		}

		.calculator_input:not(:last-child) {
			margin-bottom: 18px;
		}
	}

</style>

<div class="hsi_tpp_calculator">
	<h1>HSL TPP Calculator</h1>
	<p>The HSL TPP Calculator helps RMs quickly estimate their TPP income in INR based on a referred client’s tax residency, subscription plan, and deposit amount. Accessible via a direct link, this tool ensures accurate commission projections while remaining hidden from search engines.</p>
	<div class="calculator">
		<form id="tppCalculator">
			<div class="calculator_input">
				<label for="residency">Client Tax Residency:</label>
				<select id="residency" required>
					<option value="">-- Select --</option>
					<option value="RI">Resident Indian (RI)</option>
					<option value="NRI">Non-Resident Indian (NRI)</option>
				</select>
			</div>

			<div id="depositField" class="calculator_input">
				<label for="deposit">Deposit Amount ($):</label>
				<input type="number" id="deposit" min="0" />
			</div>

			<div class="calculator_input">
				<label for="plan">Subscription Plan:</label>
				<select id="plan" required>
					<option value="">-- Select --</option>
				</select>
			</div>

			<button type="submit">Calculate</button>
		</form>

		<div class="calculator__result">
			<h2>Result</h2>
			<p>Enter your details and click "Calculate" to see your TPP Income.</p>
			<div class="result">
				Your TPP Income in INR: <strong id="result">-----</strong>
			</div>
		</div>
	</div>
</div>

<script>
	const residencySelect = document.getElementById('residency');
	const planSelect = document.getElementById('plan');
	const depositField = document.getElementById('depositField');
	const depositInput = document.getElementById('deposit');
	const resultDiv = document.getElementById('result');

	const plans = {
		RI: [
			{ name: 'Silver (INR 3,999)', value: 3999 },
			{ name: 'Gold (INR 13,999)', value: 13999 },
			{ name: 'Super Gold (INR 49,999)', value: 49999 },
		],
		NRI: [
			{ name: 'Silver ($149)', value: 149 },
			{ name: 'Gold ($299)', value: 299 },
			{ name: 'Super Gold ($999)', value: 999 },
		]
	};

	residencySelect.addEventListener('change', () => {
		const selectedResidency = residencySelect.value;
		planSelect.innerHTML = '<option value="">-- Select --</option>';

		if (selectedResidency === 'RI') {
			depositField.style.display = 'flex';
		} else {
			depositField.style.display = 'none';
			depositInput.value = '';
		}

		plans[selectedResidency]?.forEach(plan => {
			const option = document.createElement('option');
			option.value = plan.value;
			option.textContent = plan.name;
			planSelect.appendChild(option);
		});
	});

	document.getElementById('tppCalculator').addEventListener('submit', (e) => {
		e.preventDefault();

		const residency = residencySelect.value;
		const planAmount = parseFloat(planSelect.value);
		const depositAmount = parseFloat(depositInput.value) || 0;

		if (!planAmount || (residency === 'RI' && isNaN(depositAmount))) {
			resultDiv.textContent = 'Please fill all fields correctly.';
			return;
		}

		let tppIncome = 0;

		if (residency === 'RI') {
			tppIncome = (planAmount * 0.492) + (depositAmount * 0.005 * 85);
		} else {
			tppIncome = planAmount * 0.6 * 85;
		}

		resultDiv.textContent = `INR ${tppIncome.toFixed(2)}`;
	});

	// Initial state
	depositField.style.display = 'none';
</script>
<?php get_footer(); ?>