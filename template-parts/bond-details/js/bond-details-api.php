<script>
    let bondsData = [];
    const apiUrl = 'https://yield-api-prod.vestedfinance.com/bonds';
    function showLoader() {
    document.getElementById('bond-loader').style.display = 'flex';
    }

    // Function to hide the loader
    function hideLoader() {
        document.getElementById('bond-loader').style.display = 'none';
    }
    async function fetchBondData(apiUrl) {
        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'User-Agent': 'Vested_M#8Dfz$B-8W6',
                    'Content-Type': 'application/json'
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error fetching bond data:', error);
            throw error;
        }
    }

    async function initializePage() {
        showLoader();
        const currentUrl = window.location.href;
        const url = new URL(currentUrl);
        const pathname = url.pathname;
        const pathSegments = pathname.split('/');
        const bondNameSlug = pathSegments[pathSegments.length - 3];
        const bondIsin = pathSegments[pathSegments.length - 2];
        try {
            const data = await fetchBondData(apiUrl);
            bondsData = data.bonds;
            const foundBond = bondsData.find(bond =>
                bond.securityId.toLowerCase() === bondIsin.toLowerCase() &&
                toSlug(bond.displayName) === bondNameSlug
            );

            if (foundBond) {
                const bondOfferId = foundBond.offeringId;
                const singleBondApi = `https://yield-api-prod.vestedfinance.com/bond-details?offeringId=${bondOfferId}`;
                const bondDetails = await fetchBondData(singleBondApi);

                updatePageContent(bondDetails, bondNameSlug, bondIsin);
            } else {
                redirectToNotFound();
            }
        } catch (error) {
            console.error('Error:', error);
            redirectToNotFound();
        }
        finally {
            hideLoader();
        }
    }

    function updatePageContent(data, bondNameSlug, bondIsin) {
        const minInvest = formatNumber(data.bondDetails.minimumInvestment);
        const qtyInput = document.querySelector('.qty_stepper input[type=number]');
        const bondRatings = data.bondDetails.rating.toLowerCase();
        const bondRatingsArray = ['a', 'a+', 'a-', 'aa', 'aa+', 'aa-', 'aaa', 'bb', 'bbb', 'bbb+', 'bbb-'];
        const defaultRating = 'aa';
        const validRating = bondRatingsArray.includes(bondRatings) ? bondRatings : defaultRating;
        const collections = data.bondDetails.collections;
        const stockTagsContainer = document.querySelector('.stock_tags');
        const ratingCodes = data.bondDetails.ratingColorCode;
        const ratingCodesArray = ratingCodes.split(',');
        const ratingBG = ratingCodesArray[0];
        const ratingTextColor = ratingCodesArray[1];
        qtyInput.setAttribute('min', data.bondDetails.minimumQty);
        qtyInput.setAttribute('max', data.bondDetails.maximumQty);
        qtyInput.value = data.bondDetails.minimumQty;
        const inputLength = qtyInput.value.length;
        const bondNamesHTML = document.querySelectorAll('.bond-name');
        document.querySelector('.stock_img img').setAttribute('src', data.bondDetails.logo);
        bondNamesHTML.forEach(bondName => {
            bondName.innerHTML = data.bondDetails.displayName;
        });
        document.querySelector('#issuer-name').innerHTML = data.bondDetails.issuerName;
        document.querySelector('#security-id').innerHTML = 'ISIN: ' + data.bondDetails.securityId;
        document.querySelector('#bond-yield').innerHTML = data.bondDetails.yield.toFixed(2) + '%';
        document.querySelector('#bond-mature').innerHTML = convertMonthsToYearsAndMonths(data.bondDetails.maturityInMonths);
        document.querySelector('#bond-investment').innerHTML = '₹' + minInvest;
        document.querySelector('#bond-interest').innerHTML = capitalizeString(data.bondDetails.interestPayFreq);
        document.querySelector('#face-value').innerHTML = '₹' + data.bondDetails.faceValue.toLocaleString('en-IN');
        document.querySelector('#coupon-rate').innerHTML = data.bondDetails.couponRate + '%';
        document.querySelector('#coupon-type').innerHTML = data.bondDetails.couponType;
        document.querySelector('#bond-secure').innerHTML = data.bondDetails.secureUnsecure;
        document.querySelector('#seniority').innerHTML = data.bondDetails.seniority;
        document.querySelector('#issue-mode').innerHTML = data.bondDetails.modeOfIssue;
        document.querySelector('#tax-status').innerHTML = data.bondDetails.isTaxfree ? '<span class="highlighted">Tax Free</span>' : '<span>Taxable</span>';
        document.querySelector('#bond-display').innerHTML = data.bondDetails.issuerName;
        if(bondRatingsArray.includes(bondRatings)) {
            document.querySelector('#certificate_rating').innerHTML = validRating.toUpperCase();
            document.querySelector('.bond_certificate svg path').style.fill = ratingBG;
            document.querySelector('#certificate_rating').style.color = ratingTextColor;
        }
        else {
            document.querySelector('.bond_certificate').style.display = 'none';
            document.querySelector('.bond_certificate').style.opacity = '0';
        }
        

        if (data.bondDetails.issuerDescription) {
            document.querySelector('#issuer-desc').innerHTML = data.bondDetails.issuerDescription;
        } else {
            document.querySelector('#about_tab').style.display = 'none';
            document.querySelector('.tab_button[href="#about_tab"]').style.display = 'none';
        }

        document.querySelector('#faq-yield').innerHTML = data.bondDetails.yield.toFixed(2);
        if (bondRatings) {
            document.querySelector('#bond_ratings').setAttribute('src', `<?php echo get_stylesheet_directory_uri() ?>/assets/images/ratings/ratings-${validRating}.png`);
        } else {
            document.querySelector('#ratings_tab_wrap').style.display = 'none';
            document.querySelector('.tab_button[href="#rating_tab"]').style.display = 'none';
        }


        document.querySelectorAll('.faq-bond-name').forEach(element => {
            element.innerHTML = data.bondDetails.displayName;
        });

        document.querySelector('#request_info_url').setAttribute('href', `https://vestedfinance.typeform.com/to/BuPt2Xwu#bondname=${bondNameSlug}`);
        document.querySelector('#inform_data_url').setAttribute('href', `https://vestedfinance.typeform.com/to/W6VPlghm#bondname=${bondNameSlug}`);
        document.querySelector('#im-url').setAttribute('href', data.bondDetails.imDocUrl);
        document.querySelector('#ratings-url').setAttribute('href', data.bondDetails.ratingRationalUrl);

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
            const newPlusUnit = Number(qtyInput.value);
            const inputLength = qtyInput.value.length;
            updateInvestmentDetails(data, newPlusUnit);
            adjustQtyStepperWidth(inputLength);
        });
        document.querySelector('.qty_button.qty_minus').addEventListener('click', () => {
            const newPlusUnit = Number(qtyInput.value);
            const inputLength = qtyInput.value.length;
            updateInvestmentDetails(data, newPlusUnit);
            adjustQtyStepperWidth(inputLength);
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

        if(data.bondDetails.isTaxfree) {
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

    function redirectToNotFound() {
        // window.location.replace('/bond-not-found');
    }

    function toSlug(str) {
        return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }

    initializePage();

    // Bonds Dropdown Search


    function inputChangeCalc() {
        const inputValue = document.querySelector(".dropdown_search").value.trim();
        makeAPICallCalc(inputValue);
    }

    function makeAPICallCalc(inputValue) {
        const mainDropdown = document.querySelector('.select_box_new');
        const dynamicOptions = document.querySelector(".options_result");

        if (inputValue.length >= 1) {
            const filteredBonds = filterBonds(inputValue);
            updateDropdown(filteredBonds);
            dynamicOptions.style.display = "block";
            mainDropdown.classList.add("dropdown_collased");
        } else {
            dynamicOptions.style.display = "none";
            // Ensure the dropdown is collapsed
            mainDropdown.classList.remove("dropdown_collased");
        }
    }

    function filterBonds(searchTerm) {
        const lowerCasedTerm = searchTerm.toLowerCase();
        var resultdata = bondsData.filter(bond =>
            bond.displayName.toLowerCase().includes(lowerCasedTerm) ||
            bond.securityId.toLowerCase().includes(lowerCasedTerm)
        );
        return resultdata;
    }

    function updateDropdown(filteredBonds) {
        const optionsContainer = document.querySelector(".options_result");
        optionsContainer.innerHTML = ''; // Clear previous options

        filteredBonds.forEach(bond => {
            const option = document.createElement('li');
            const optionSlug = bond.displayName.toLowerCase().replace(/[^\w\s]/g, '').replace(/\s+/g, '-').trim();
            const optionIsin = bond.securityId.toLowerCase();
            const bondUrl = `<?php echo site_url(); ?>/bond/${optionSlug}/${optionIsin}`;
            option.classList.add('dropdown_option');
            option.innerHTML = `<strong>${bond.displayName}</strong> <span>${bond.securityId}</span>`;
            option.addEventListener('click', () => {
                document.querySelector(".dropdown_search").value = bond.displayName;
                optionsContainer.style.display = "none";
                window.location.href = bondUrl;
            });
            optionsContainer.appendChild(option);
        });
    }


    function updateInvestmentDetails(data, unit) {
        const accruedInterest = Number(((data.bondDetails.accruedInterest || 0) * unit).toFixed(2));
        const principalAmount = Number(((Number(data.bondDetails.principalAmount) || 0) * unit).toFixed(2));
        const totalInvestmentRaw = accruedInterest + principalAmount;
        const totalInvestment = formatNumber(totalInvestmentRaw);
        
        const interestEarned = (data.bondDetails.cashflows.reduce((acc, curr) => {
            if (curr.type === 'interest') {
                return acc + curr.amount;
            }
            return acc;
        }, 0) + (Number(data.bondDetails.faceValue) - Number(data.bondDetails.newPrice))) * unit - accruedInterest;

        let count = 0;
        const avgIncome = data.bondDetails.cashflows.reduce((acc, curr) => {
            if (curr.type === 'interest') {
                count += 1;
                return acc + (curr.amountPostDeduction || curr.amount) || 0;
            }
            return acc;
        }, 0);
        const averageInterestPayoutRaw = Math.floor((avgIncome * unit) / count);
        const averageInterestPayout = formatNumber(averageInterestPayoutRaw);

        // Calculate FD interest with 7% annual interest rate
        const annualRate = 0.07;
        const rate = Math.floor(totalInvestmentRaw);
        const fdInterestRaw = rate * annualRate;
        const fdInterest =  Math.floor(fdInterestRaw);
        const newTotal = rate + fdInterestRaw;
        const fdNewTotal = formatNumber(newTotal);

        const finalInterestEarned = formatNumber(interestEarned);
        const totalReceivableRaw = totalInvestmentRaw + interestEarned;
        const totalReceivable = formatNumber(totalReceivableRaw);

        document.querySelector('#bond_invest_amt').innerHTML = '₹' + totalInvestment;
        document.querySelector('#bond_receive_amt').innerHTML = '₹' + totalReceivable;
        document.querySelector('#bond_avg_interest').innerHTML = '₹' + averageInterestPayout + ' ' + capitalizeString(data.bondDetails.interestPayFreq);
        document.querySelector('#chart_invest_val').innerHTML = '₹' + totalInvestment;
        document.querySelector('#chart_fd_val').innerHTML = '₹' + fdNewTotal;
        document.querySelector('#chart_bond_val').innerHTML = '₹' + totalReceivable;
        document.querySelector('#interest_pay_frequency').innerHTML = capitalizeString(data.bondDetails.interestPayFreq);

        bondReturnsGraphFunction(totalInvestment, fdNewTotal, totalReceivable);

        document.querySelectorAll('.bonds_return_amt').forEach(element => {
            element.innerHTML = '₹' + finalInterestEarned;
        });
        document.querySelectorAll('.bonds_return_per').forEach(element => {
            element.innerHTML = data.bondDetails.yield.toFixed(2) + '%';
        });

        const cashflowResult = data.bondDetails.cashflows.reduce((accumulator, current) => {
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
        const firstAmount = cashflowResult[0].amount * unit;
        const secondAmount = cashflowResult[1].amount * unit;
        const lastAmount = cashflowResult[lastIndex].amount * unit;
        const secondLastAmount = cashflowResult[secondLastIndex].amount * unit;
        const maturityInYears = convertMonthsToYearsAndMonths(data.bondDetails.maturityInMonths, true);

        document.querySelector('#cashflow-inveset').innerHTML = '₹' + totalInvestment;
        document.querySelector('#cashflow-pricipal').innerHTML = '₹' + Number(principalAmount).toLocaleString('en-IN');
        document.querySelector('#cashflow-accured-interest').innerHTML = '₹' + formatNumber(accruedInterest);
        document.querySelector('#cashflow-total-returns').innerHTML = '₹' + totalReceivable;
        document.querySelector('#cashflow-payout').innerHTML = '₹' + totalInvestment;
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
        document.querySelector('#redemption-date').innerHTML = formatDate(data.bondDetails.redemptionDate);
        document.querySelectorAll('.bonds_returns_note .maturity').forEach(element => {
            element.innerHTML = maturityInYears;
        });

        if (cashflowResult.length >= 4) {

            document.querySelector('.vertical_dashed_divider').style.display = 'block';
        } else {
            document.querySelector('.vertical_dashed_divider').style.display = 'none';
        }
    }

    document.querySelector(".dropdown_search").addEventListener('input', inputChangeCalc);

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
        const formattedValue = Math.floor(Number(value.toFixed(2)));
        return formattedValue.toLocaleString('en-IN');
    }

    function convertMonthsToYearsAndMonths(months, longerFormat = false) {
    const years = Math.floor(months / 12);
    const remainingMonths = months % 12;
    let result = '';

    if (years > 0) {
        result += `${years}${longerFormat ? ` year${years > 1 ? 's' : ''}` : 'y'}`;
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

function bondReturnsGraphFunction(totalInvestment, fdNewTotal, totalReceivable) {
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

            chart.data.datasets.forEach((dataset, i) => {
                chart.getDatasetMeta(i).data.forEach((bar, index) => {
                    const percent = [' ', '7%', '12%'];
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

</script>