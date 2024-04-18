<?php
    $inr_bonds_data = $args['inr_bonds_data'];
    // echo "<pre>";
	// print_r($inr_bonds_data);
	// echo "</pre>";
?>

<section class="bonds_calculator_section">
    <div class="container">
        <div class="bonds_calculator_wrapper">
            <h2>Your potential returns compared to a FD</h2>
            <div class="bonds_calculator_container">
                <div class="bonds_calculator_form">
                    <div class="bonds_select_box">
                        <label>Select a bond</label>
                        <select id="bonds_select">
                            <?php foreach ($inr_bonds_data as $bond): ?>
                                <option value="<?php echo $bond['displayName']; ?>" id="<?php echo $bond['offeringId']; ?>" minValue="<?php echo $bond['minimumQty']; ?>"><?php echo $bond['displayName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="units_select_box">
                        <div class="units_select_head">
                            <label>Number of units</label>
                            <div class="units_input_group">
                                <button onclick="decrement()">-</button>
                                <input type="number" id="units_select_input" />
                                <button onclick="increment()">+</button>
                            </div>
                        </div>
                        <input type="range" id="units_select_range" class="calculation_range_input">
                        <div class="units_range_steps">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="bonds_calculator_result">
                    <div class="calculator_result_top">
                        <span class="calculator_result_loader"></span>
                        <div class="calculator_result_box">
                            <div class="calculator_result_value">
                                <label>Investment amount</label>
                                <strong id="investment_amount">₹ 0,00,000</strong>
                            </div>
                            <div class="calculator_result_progress">
                                <div class="result_progress" id="investment_amount_progress"></div>
                            </div>
                        </div>  
                        <div class="calculator_result_box">
                            <div class="calculator_result_value">
                                <label>Bank Fixed Deposit</label>
                                <strong id="bank_fixed_deposit">₹ 0,00,000</strong>
                                <span>(6% Returns)</span>
                            </div>
                            <div class="calculator_result_progress">
                                <div class="result_progress" id="bank_fixed_deposit_progress"></div>
                            </div>
                        </div>  
                        <div class="calculator_result_box">
                            <div class="calculator_result_value">
                                <label>Selected Bonds</label>
                                <strong id="selected_bonds">₹ 0,00,000</strong>
                                <span id="selected_bonds_yield">(12% Returns)</span>
                            </div>
                            <div class="calculator_result_progress">
                                <div class="result_progress" id="selected_bonds_progress"></div>
                            </div>
                        </div>     
                    </div>
                    <div class="calculator_result_bottom" id="calculator_bottom_value">
                        ₹1,00,000 invested would earn you <strong>₹60,000 extra</strong> in 5 years
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function adjustInputValue(adjustment) {
        const input = document.getElementById('units_select_input');
        const minValue = parseFloat(input.getAttribute('min')) || 0;
        const maxValue = parseFloat(input.getAttribute('max')) || Infinity;

        let newValue = parseFloat(input.value) + adjustment;

        if (isNaN(newValue) || newValue < minValue) {
            newValue = minValue;
        } else if (newValue > maxValue) {
            newValue = maxValue;
        }

        input.value = newValue;

        const rangeInput = document.getElementById('units_select_range');
        rangeInput.value = newValue;

        updateGradient(rangeInput);
        bindSingleBondOnBond();
    }

    function increment() {
        adjustInputValue(1);
    }

    function decrement() {
        adjustInputValue(-1);
    }


    function updateGradient(progress) {
		const value = progress.value;
		const min = progress.min;
		const max = progress.max;
		const percentage = ((value - min) / (max - min)) * 100;
		progress.style.background = `linear-gradient(to right, #002852 0%, #002852 ${percentage}%, #EEEEEE ${percentage}%, #EEEEEE 100%)`;
	}

    document.getElementById('units_select_range').addEventListener('input', function () {
		document.getElementById('units_select_input').value = this.value;
        updateGradient(this);
        bindSingleBondOnBond();
	});

    document.getElementById('units_select_input').addEventListener('input', function () {
        const minValue = parseFloat(this.getAttribute('min'));
		const maxValue = parseFloat(this.getAttribute('max'));
        let value = parseFloat(this.value);
        if (isNaN(value) || value < minValue) {
            value = minValue;
        } else if (value > maxValue) {
            value = maxValue;
        }
        this.value = value;
        const rangeInput = document.getElementById('units_select_range');
		rangeInput.value = this.value;
        updateGradient(rangeInput);
        bindSingleBondOnBond();
	});

    let selectedBond = {};
    function bindSingleBond() {
        let bondData = {...selectedBond};
        console.log('bondData', bondData);
        const unitsInput = document.getElementById('units_select_input');
        const unitsRange = document.getElementById('units_select_range');

        unitsInput.setAttribute("min", bondData.minimumQty);
        unitsInput.setAttribute("max", bondData.maximumQty);
        unitsInput.value = bondData.minimumQty;
        unitsRange.setAttribute("min", bondData.minimumQty);
        unitsRange.setAttribute("max", bondData.maximumQty);
        unitsRange.value = bondData.minimumQty;
        updateGradient(unitsRange);
        bindSingleBondOnBond();        
    }

    function bindSingleBondOnBond() {
        let bondData = {...selectedBond};
        const unitsRange = document.getElementById('units_select_range');

        const investmentAmount = document.getElementById('investment_amount');
        const bankFixedDeposit = document.getElementById('bank_fixed_deposit');
        const selectedBonds = document.getElementById('selected_bonds');
        const selectedBondsYield = document.getElementById('selected_bonds_yield');
        const calculatorBottomValue = document.getElementById('calculator_bottom_value');

        const investmentAmountValue = unitsRange.value * bondData.newPrice;
        investmentAmount.textContent =  `₹ ${Math.round(investmentAmountValue).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        
        const periodInYears = bondData.maturityInMonths / 12;
        const bankFixedDepositValue = investmentAmountValue * Math.pow(1.06, periodInYears);
        bankFixedDeposit.textContent =  `₹ ${Math.round(bankFixedDepositValue).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        
        const accruedInterest = (Number(bondData.accruedInterest) || 0) * unitsRange.value;
        const principalAmount = (Number(bondData.principalAmount) || 0) * unitsRange.value;
        const totalInvestment = accruedInterest + principalAmount;
        
        const interestEarned =
            (bondData.cashflows.reduce((acc, curr) => {
                if (curr.type === 'interest') {
                    return acc + curr.amount;
                }
                return acc;
            }, 0) +
            (Number(bondData.faceValue) - Number(bondData.newPrice))) * unitsRange.value;
            
        const totalReceivable = totalInvestment + interestEarned;

        selectedBonds.textContent =  `₹ ${Math.round(totalReceivable).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        
        selectedBondsYield.textContent =  `(${bondData.yield.toFixed(2)}% Returns)`;

        const bottomInvestmentAmount = Math.round(investmentAmountValue).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        const extraAmount = Math.round(totalReceivable - bankFixedDepositValue).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        const months = bondData.maturityInMonths;
        const years = Math.floor(months / 12);
        const remainingMonths = months % 12;
        let formattedString = '';

        if (years > 0 && remainingMonths > 0) {
            formattedString = `${years} year${years > 1 ? 's' : ''} ${remainingMonths} month${remainingMonths > 1 ? 's' : ''}`;
        } else if (years > 0) {
            formattedString = `${years} year${years > 1 ? 's' : ''}`;
        } else {
            formattedString = `${months} month${months > 1 ? 's' : ''}`;
        }
        
        calculatorBottomValue.innerHTML = `₹${bottomInvestmentAmount} invested would earn you <br/> <strong>₹${extraAmount} extra</strong> in ${formattedString}`;
        
        progressbar();
    }

    function progressbar() {
        const investmentAmount = document.getElementById('investment_amount').innerText.replace(/\D/g, '');
        const bankFixedDeposit = document.getElementById('bank_fixed_deposit').innerText.replace(/\D/g, '');
        const selectedBonds = document.getElementById('selected_bonds').innerText.replace(/\D/g, '');
        console.log('2 investmentAmount', investmentAmount);
        console.log('2 bankFixedDeposit', bankFixedDeposit);
        console.log('2 selectedBonds', selectedBonds);

        const investmentAmountProgress = document.getElementById('investment_amount_progress');
        const bankFixedDepositProgress = document.getElementById('bank_fixed_deposit_progress');
        const selectedBondsProgress = document.getElementById('selected_bonds_progress');

        const maxValue = Math.max(investmentAmount, bankFixedDeposit, selectedBonds);
        const investmentAmountPercent = (investmentAmount / maxValue) * 100;
        const bankFixedDepositPercent = (bankFixedDeposit / maxValue) * 100;
        const selectedBondsPercent = (selectedBonds / maxValue) * 100;

        investmentAmountProgress.style.width = investmentAmountPercent + '%';
        bankFixedDepositProgress.style.width = bankFixedDepositPercent + '%';
        selectedBondsProgress.style.width = selectedBondsPercent + '%';
    }

    function callSinlgeBondApi(offeringID) {
        document.querySelector('.bonds_calculator_container').classList.add('loading');
        const apiUrl = `https://yield-api-staging.vestedfinance.com/bond-details?offeringId=${offeringID}`;
        const headers = { 'User-Agent': 'Vested_M#8Dfz$B-8W6' };

        return fetch(apiUrl, { headers })
            .then(response => response.json())
            .then(data => { 
                selectedBond = data.bondDetails;
                bindSingleBond(); 
                document.querySelector('.bonds_calculator_container').classList.remove('loading');
            })
            .catch(error => console.error('Error:', error));
    }

    function selectBond() {
        const bondsSelect = document.getElementById('bonds_select');
        const selectedOption = bondsSelect.options[bondsSelect.selectedIndex];
        const bondID = selectedOption.getAttribute('id');
        console.log('2 bondID', bondID);
        callSinlgeBondApi(bondID);
    }

    window.onload = selectBond;

    const bondsSelect = document.getElementById('bonds_select');
    bondsSelect.addEventListener('change', selectBond);
</script>