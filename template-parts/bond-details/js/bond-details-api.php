<?php
$bond_name_slug = get_query_var('bond_company');
$bond_isin = get_query_var('securityId');
if($bond_isin) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bonds_list';
    $bond = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE securityId = %s", strtoupper($bond_isin)));
    $collections = unserialize($bond->collections);
    $cashflows = unserialize($bond->cashflows);
    $collections_json = json_encode($collections);
    $bond_json = json_encode($bond);
    $cashflows_json = json_encode($cashflows);
    $isTax = $bond->isTaxfree;
    if($bond->isTaxfree) {
        $taxFree = 'true';
    }
    else {
        $taxFree = 'false';
    }
?>
<script>
    function showLoader() {
    document.getElementById('bond-loader').style.display = 'flex';
    }

    // Function to hide the loader
    function hideLoader() {
        document.getElementById('bond-loader').style.display = 'none';
    }
    hideLoader();
    function updatePageContent() {
        const minInvest = formatNumber(<?php echo $bond->minimumInvestment; ?>);
        var qtyInput = document.querySelector('.qty_stepper input[type=number]');
        const bondRatingDB = '<?php echo $bond->rating; ?>';
        const bondRatings = bondRatingDB.toLowerCase();
        const bondRatingsArray = ['a', 'a+', 'a-', 'aa', 'aa+', 'aa-', 'aaa', 'bb', 'bbb', 'bbb+', 'bbb-'];
        const defaultRating = 'a+';
        const validRating = bondRatingsArray.includes(bondRatings) ? bondRatings : defaultRating;
        const collections = <?php echo $collections_json; ?>;
        const stockTagsContainer = document.querySelector('.stock_tags');
        const ratingCodes = '<?php echo $bond->ratingColorCode; ?>';
        const ratingCodesArray = ratingCodes.split(',');
        const ratingBG = ratingCodesArray[0];
        const ratingTextColor = ratingCodesArray[1];
        const data = <?php echo $bond_json; ?>;
        qtyInput.setAttribute('min', <?php echo $bond->minimumQty; ?>);
        qtyInput.setAttribute('max', <?php echo $bond->maximumQty; ?>);
        qtyInput.value = <?php echo $bond->minimumQty; ?>;
        const inputLength = qtyInput.value.length;
        
        if(bondRatingsArray.includes(bondRatings)) {
            document.querySelector('#certificate_rating').innerHTML = validRating.toUpperCase();
            document.querySelector('.bond_certificate svg path').style.fill = ratingBG;
            document.querySelector('#certificate_rating').style.color = ratingTextColor;
        }
        else {
            document.querySelector('.bond_certificate').style.display = 'none';
            document.querySelector('.bond_certificate').style.opacity = '0';
        }

        const unit = Number(qtyInput.value);
        updateInvestmentDetails(data, unit);
        adjustQtyStepperWidth(inputLength);
        qtyInput.addEventListener('input', () => {
            const newUnit = Number(qtyInput.value);
            const inputLength = qtyInput.value.length;
            updateInvestmentDetails(data, newUnit);
            adjustQtyStepperWidth(inputLength);
        });
        document.querySelector('.qty_button.qty_plus').addEventListener('click', () => {
            setTimeout(() => {
            const newPlusUnit = Number(qtyInput.value);
            const inputLength = qtyInput.value.length;
            updateInvestmentDetails(data, newPlusUnit);
            adjustQtyStepperWidth(inputLength);
        }, 0);
        });
        document.querySelector('.qty_button.qty_minus').addEventListener('click', () => {
            setTimeout(() => {
            const newMinusUnit = Number(qtyInput.value);
            const inputLength = qtyInput.value.length;
            updateInvestmentDetails(data, newMinusUnit);
            adjustQtyStepperWidth(inputLength);
        }, 0);
        });

        function adjustQtyStepperWidth(inputLength) {
            const stepperWidth = 100;
            const qtyWidth = 32;

            if (inputLength > 3) {
                const newStepperWidth = stepperWidth + (inputLength * 5);
                const newQtyWidth = qtyWidth + (inputLength * 5);
                document.querySelector('.qty_stepper').style.width = `${newStepperWidth}px`;
                document.querySelector('.qty_stepper input[type=number]').style.width = `${newQtyWidth}px`;
            } else {
                document.querySelector('.qty_stepper').style.width = `${stepperWidth}px`;
                document.querySelector('.qty_stepper input[type=number]').style.width = `${qtyWidth}px`;
            }
        }
        if(<?php echo $isTax; ?>) {
            const chartWrapper = document.querySelector('.bond_chart_temp');
            const postTax = document.createElement('span');
            postTax.textContent = '**Assumes a 30% tax slab under the new tax regime.';
            postTax.style.marginTop = '0';
            chartWrapper.append(postTax);
            document.querySelector('.bond_chart_temp h3').textContent = 'Potential Returns - post tax';
        }

        stockTagsContainer.innerHTML = '';

        collections.forEach(collection => {
            const spanElement = document.createElement('span');
            const imgElement = document.createElement('img');

            imgElement.src = collection.icon;
            imgElement.alt = collection.label;
            spanElement.appendChild(imgElement);

            const textNode = document.createTextNode(` ${collection.label}`);
            spanElement.appendChild(textNode);

            stockTagsContainer.appendChild(spanElement);
        });

    }
    // initializePage();


    function updateInvestmentDetails(data, unit) {
        const accruedInterest = Number(((data.accruedInterest || 0) * unit).toFixed(2));
        const principalAmount = Number(((Number(data.principalAmount) || 0) * unit).toFixed(2));
        const totalInvestmentRaw = accruedInterest + principalAmount;
        const totalInvestment = formatNumber(totalInvestmentRaw);
        const bondCashflows = <?php echo $cashflows_json; ?>;
        const interestEarned = (bondCashflows.reduce((acc, curr) => {
            if (curr.type === 'interest') {
                return acc + curr.amount;
            }
            return acc;
        }, 0) + (Number(data.faceValue) - Number(data.newPrice))) * unit - accruedInterest;
        let count = 0;
        const avgIncome = bondCashflows.reduce((acc, curr) => {
            if (curr.type === 'interest') {
                count += 1;
                return acc + (curr.amountPostDeduction || curr.amount) || 0;
            }
            return acc;
        }, 0);
        const averageInterestPayoutRaw = Math.floor((avgIncome * unit) / count);
        const averageInterestPayout = formatNumber(averageInterestPayoutRaw);

        // Calculate FD interest with 7% annual interest rate
        let annualRate;
        if(<?php echo $isTax; ?> === 0) {
            annualRate = 0.07;
            document.querySelector('#tds_note').style.display = 'block';
        }
        else {
            annualRate = 0.049;
            document.querySelector('#tds_note').style.display = 'none';
        }
        const rate = Math.floor(totalInvestmentRaw);
        const fdInterestRaw = rate * annualRate;
        const fdInterest =  Math.floor(fdInterestRaw);
        const newTotal = rate + fdInterestRaw;
        const fdNewTotal = formatNumber(newTotal);

        const finalInterestEarned = formatNumber(interestEarned);
        const totalReceivableRaw = totalInvestmentRaw + interestEarned;
        const totalReceivable = formatNumber(totalReceivableRaw);
        const bondYield = Number(data.yield);
        document.querySelector('#bond_invest_amt').innerHTML = '₹' + totalInvestment;
        document.querySelector('#bond_receive_amt').innerHTML = '₹' + totalReceivable;
        document.querySelector('#bond_avg_interest').innerHTML = '₹' + averageInterestPayout + ' ' + capitalizeString(data.interestPayFreq);
        document.querySelector('#chart_invest_val').innerHTML = '₹' + totalInvestment;
        document.querySelector('#chart_fd_val').innerHTML = '₹' + fdNewTotal;
        document.querySelector('#chart_bond_val').innerHTML = '₹' + totalReceivable;
        document.querySelector('#interest_pay_frequency').innerHTML = capitalizeString(data.interestPayFreq);

        bondReturnsGraphFunction(totalInvestment, fdNewTotal, totalReceivable, bondYield);
        
        document.querySelectorAll('.bonds_return_amt').forEach(element => {
            element.innerHTML = '₹' + finalInterestEarned;
        });
        document.querySelectorAll('.bonds_return_per').forEach(element => {
            element.innerHTML = bondYield.toFixed(2) + '%';
        });

        const cashflowResult = bondCashflows.reduce((accumulator, current) => {
            if (current.type === 'interest') {
                accumulator.push({
                    date: current.date,
                    amount: current.amount
                });
            }
            return accumulator;
        }, []);

        const lastIndex = cashflowResult.length - 1;
        const secondLastIndex = cashflowResult.length - 2;
        const firstDate = cashflowResult[0].date;
        const secondDate = cashflowResult[1].date;
        const lastDate = cashflowResult[lastIndex].date;
        const secondLastDate = cashflowResult[secondLastIndex].date;
        let firstAmount = cashflowResult[0].amount * unit;
        let secondAmount = cashflowResult[1].amount * unit;
        let lastAmount = cashflowResult[lastIndex].amount * unit;
        let secondLastAmount = cashflowResult[secondLastIndex].amount * unit;
        let DeductedAmount = bondCashflows[bondCashflows.length - 1].amountPostDeduction;
        const deduction = bondCashflows[0].amountPostDeduction;
        const maturityInYears = convertMonthsToYearsAndMonths(data.maturityInMonths, true);
        let cashflowPayout = totalInvestment;
        if(<?php echo $isTax; ?> === 0) { 
            firstAmount = unit * deduction;
            secondAmount = unit * deduction;
            lastAmount = unit * deduction;
            secondLastAmount = unit * deduction;
            cashflowPayout = unit * DeductedAmount;
        }
        
        document.querySelector('#cashflow-inveset').innerHTML = '₹' + totalInvestment;
        document.querySelector('#cashflow-pricipal').innerHTML = '₹' + Number(principalAmount).toLocaleString('en-IN');
        document.querySelector('#cashflow-accured-interest').innerHTML = '₹' + formatNumber(accruedInterest);
        document.querySelector('#cashflow-total-returns').innerHTML = '₹' + totalReceivable;
        document.querySelector('#cashflow-payout').innerHTML = '₹' + cashflowPayout;
        document.querySelector('#cashflow-interest-earned').innerHTML = '₹' + finalInterestEarned;
        document.querySelector('#cashflow-initial-date').innerHTML = formatDate(firstDate);
        document.querySelector('#cashflow-first-date').innerHTML = formatDate(firstDate);
        document.querySelector('#cashflow-first-interest').innerHTML = '₹' + formatNumber(firstAmount);
        document.querySelector('#cashflow-second-date').innerHTML = formatDate(secondDate);
        document.querySelector('#cashflow-second-interest').innerHTML = '₹' + formatNumber(secondAmount);
        document.querySelector('#cashflow-second-last-date').innerHTML = formatDate(secondLastDate);
        document.querySelector('#cashflow-second-last-interest').innerHTML = '₹' + formatNumber(secondLastAmount);
        document.querySelector('#cashflow-last-date').innerHTML = formatDate(lastDate);
        document.querySelector('#cashflow-last-interest').innerHTML = '₹' + formatNumber(lastAmount);
        document.querySelector('#redemption-date').innerHTML = formatDate(data.redemptionDate);
        document.querySelectorAll('.bonds_returns_note .maturity').forEach(element => {
            element.innerHTML = maturityInYears;
        });

        if (cashflowResult.length >= 4) {

            document.querySelector('.vertical_dashed_divider').style.display = 'block';
        } else {
            document.querySelector('.vertical_dashed_divider').style.display = 'none';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear().toString().slice(-2);
        const formattedDate = `${day} ${month} '${year}`;

        return formattedDate;
    }

    function capitalizeString(input) {
        const lowerCaseString = input.toLowerCase();
        const capitalizedString = lowerCaseString.charAt(0).toUpperCase() + lowerCaseString.slice(1);
        return capitalizedString;
    }

    function formatNumber(value) {
    if (typeof value === 'string') {
        value = Math.floor(Number(value));
    }
    
    let formattedValue = Math.floor(Number(value.toFixed(2)));
    return formattedValue.toLocaleString('en-IN');
}


    function convertMonthsToYearsAndMonths(months, longerFormat = false) {
    const years = Math.floor(months / 12);
    const remainingMonths = months % 12;
    let result = '';

    if (years > 0) {
        result += years > 0 ? `${years}${longerFormat ? ` year${years > 1 ? 's' : ''}` : 'y'}` : '';
    }
    if (remainingMonths > 0) {
        if (years > 0) {
            result += ' ';
        }
        result += ` ${remainingMonths}${longerFormat ? ` month${remainingMonths > 1 ? 's' : ''}` : 'm'}`;
    }
    return result;
}

let bondReturnsBarChart; // Variable to track the chart instance

function bondReturnsGraphFunction(totalInvestment, fdNewTotal, totalReceivable, bondYield) {
    const totalInvestmentStr = totalInvestment.toString().replace(/,/g, '');
    const fdNewTotalStr = fdNewTotal.toString().replace(/,/g, '');
    const totalReceivableStr = totalReceivable.toString().replace(/,/g, '');

    const ctx = document.getElementById('bondReturnsGraph').getContext('2d');

    const data = {
        labels: ['You Invest', 'Bank FD', 'Bond'],
        datasets: [{
            label: 'Potential Returns',
            data: [totalInvestmentStr, fdNewTotalStr, totalReceivableStr],
            backgroundColor: ['#2D3A6A', '#1D2F3C', '#007F3D'],
            hoverBackgroundColor: ['#2D3A6A', '#1D2F3C', '#007F3D'],
            borderColor: ['#2D3A6A', '#1D2F3C', '#007F3D'],
            borderWidth: 1,
            borderRadius: 8
        }]
    };

    const options = {
        scales: {
            y: {
                display: false,
                grid: {
                    color: 'rgba(0,0,0,0)',
                    drawBorder: false,
                },
                ticks: {
                    display: false
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0)',
                    drawBorder: false,
                },
                ticks: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            }
        },
    layout: {
        padding: {
            top: 20
        }
    }
        
    };

    const customPlugin = {
        id: 'customPlugin',
        afterDatasetsDraw: (chart) => {
            const { ctx, chartArea: { top, bottom, width, height } } = chart;
            ctx.save();
            const isSmallScreen = window.innerWidth < 768;
            let fdRate;
            if(<?php echo $isTax; ?> === 0) {
                fdRate = '7%';
            }
            else {
                fdRate = '4.9%'
            }
            chart.data.datasets.forEach((dataset, i) => {
                chart.getDatasetMeta(i).data.forEach((bar, index) => {
                    const percent = [' ', fdRate, bondYield.toFixed(2) + '%'];
                    const value = dataset.data[index];
                    const y = bar.y;
                    const x = bar.x;
                    const barHeight = y - bar.base; // Height of the bar

                    // Draw percentage text
                    ctx.fillStyle = isSmallScreen ? '#ffffff' : '#002852';
                    ctx.font = 'bold 12px Inter, sans-serif'; // Font weight and family
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    const textYPosition = isSmallScreen ? y + 35 : y - 5;
                    ctx.fillText(percent[index], x, textYPosition);
                });
            });

            ctx.restore();
        }
    };



    // Destroy the existing chart if it exists
    if (bondReturnsBarChart) {
        bondReturnsBarChart.destroy();
    }

    // Create a new chart instance
    bondReturnsBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
        plugins: [customPlugin]
    });
}

updatePageContent();

</script>

<?php
}
?>