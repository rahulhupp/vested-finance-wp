<script>
let bondsData = [];
const apiUrl = 'https://yield-api-prod.vestedfinance.com/bonds';

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
}

function updatePageContent(data, bondNameSlug, bondIsin) {
    const minInvest = data.bondDetails.minimumInvestment.toFixed(2);
    const qtyInput = document.querySelector('.qty_stepper input[type=number]');
    const bondRatings = data.bondDetails.rating.toLowerCase();
    qtyInput.setAttribute('min', data.bondDetails.minimumQty);
    qtyInput.setAttribute('max', data.bondDetails.maximumQty);
    qtyInput.value = data.bondDetails.minimumQty;
    document.querySelector('.stock_img img').setAttribute('src', data.bondDetails.logo);
    document.querySelector('#bond-name').innerHTML = data.bondDetails.displayName;
    document.querySelector('#issuer-name').innerHTML = data.bondDetails.issuerName;
    document.querySelector('#security-id').innerHTML = 'ISIN: ' + data.bondDetails.securityId;
    document.querySelector('#bond-yield').innerHTML = data.bondDetails.yield.toFixed(2) + '%';
    document.querySelector('#bond-mature').innerHTML = data.bondDetails.maturityInMonths;
    document.querySelector('#bond-investment').innerHTML = '₹' + minInvest;
    document.querySelector('#bond-interest').innerHTML = data.bondDetails.interestPayFreq;
    document.querySelector('#face-value').innerHTML = '₹' + data.bondDetails.faceValue.toLocaleString('en-IN');
    document.querySelector('#coupon-rate').innerHTML = data.bondDetails.couponRate + '%';
    document.querySelector('#coupon-type').innerHTML = data.bondDetails.couponType;
    document.querySelector('#bond-secure').innerHTML = data.bondDetails.secureUnsecure;
    document.querySelector('#seniority').innerHTML = data.bondDetails.seniority;
    document.querySelector('#issue-mode').innerHTML = data.bondDetails.modeOfIssue;
    document.querySelector('#tax-status').innerHTML = data.bondDetails.isTaxfree ? '<span class="highlighted">Tax Free</span>' : '<span>Taxable</span>';
    document.querySelector('#bond-display').innerHTML = data.bondDetails.issuerName;

    if(data.bondDetails.issuerDescription) {
        document.querySelector('#issuer-desc').innerHTML = data.bondDetails.issuerDescription;
    }
    else {
        document.querySelector('#about_tab').style.display = 'none';
        document.querySelector('.tab_button[href="#about_tab"]').style.display = 'none';
    }
    
    document.querySelector('#faq-yield').innerHTML = data.bondDetails.yield.toFixed(2);
    if(bondRatings) {
        document.querySelector('#bond_ratings').setAttribute('src', `<?php echo get_stylesheet_directory_uri() ?>/assets/images/ratings/ratings-${bondRatings}.png`);
    }
    else {
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
    const accruedInterest = Number(((data.bondDetails.accruedInterest || 0) * unit).toFixed(2));
    const principalAmount = Number(((Number(data.bondDetails.principalAmount) || 0) * unit).toFixed(2));
    const totalInvestment = Number((accruedInterest + principalAmount).toFixed(2));
    const interestEarned =
		(data.bondDetails.cashflows.reduce((acc, curr) => {
			if (curr.type === 'interest') {
				return acc + curr.amount;
			}
			return acc;
		}, 0) +
			(Number(data.bondDetails.faceValue) - Number(data.bondDetails.newPrice))) *
			unit -
		accruedInterest;

        let count = 0;
	const avgIncome = data.bondDetails.cashflows.reduce((acc, curr) => {
		if (curr.type === 'principal') {
			count += 1;
			return acc + (curr.amountPostDeduction || curr.amount) || 0;
		}
		return acc;
	}, 0);
	const averageInterestPayout  = Math.floor((avgIncome * unit) / count);
    const finalInterestEarned = Number(interestEarned.toFixed(2));
    const totalReceivable = Number((Number(totalInvestment) + finalInterestEarned).toFixed(2));
    document.querySelector('#bond_invest_amt').innerHTML = '₹' + totalInvestment;
    document.querySelector('#bond_receive_amt').innerHTML = '₹' + totalReceivable;
    document.querySelector('#bond_avg_interest').innerHTML = '₹' + averageInterestPayout + ' ' + data.bondDetails.interestPayFreq;
    document.querySelector('#interest_pay_frequency').innerHTML = data.bondDetails.interestPayFreq;

    document.querySelectorAll('.bonds_return_amt').forEach(element => {
        element.innerHTML = '₹' + finalInterestEarned;
    });

    document.querySelectorAll('.bonds_return_per').forEach(element => {
        element.innerHTML = data.bondDetails.yield.toFixed(2) + '%';
    });

    const cashflowResult = data.bondDetails.cashflows.reduce((accumulator, current) => {
    if (current.type === 'principal') {
        accumulator.push({ date: current.date, amount: current.amount });
    }
    return accumulator;
}, []);

    const lastIndex = cashflowResult.length - 1;
    const secondLastIndex = cashflowResult.length - 2;
    const firstDate = cashflowResult[0].date;
    const secondDate = cashflowResult[1].date;
    const lastDate = cashflowResult[lastIndex].date;
    const secondLastDate = cashflowResult[secondLastIndex].date;
    const firstAmount = cashflowResult[0].amount;
    const secondAmount = cashflowResult[1].amount;
    const lastAmount = cashflowResult[lastIndex].amount;
    const secondLastAmount = cashflowResult[secondLastIndex].amount;
    const maturityInYears = Number((data.bondDetails.maturityInMonths / 12).toFixed(2));

    document.querySelector('#cashflow-inveset').innerHTML = '₹' + totalInvestment;
    document.querySelector('#cashflow-pricipal').innerHTML = '₹' + principalAmount;
    document.querySelector('#cashflow-accured-interest').innerHTML = '₹' + accruedInterest;
    document.querySelector('#cashflow-total-returns').innerHTML = '₹' + totalReceivable;
    document.querySelector('#cashflow-payout').innerHTML = '₹' + totalInvestment;
    document.querySelector('#cashflow-interest-earned').innerHTML = '₹' + finalInterestEarned;


    
    document.querySelector('#cashflow-initial-date').innerHTML = formatDate(firstDate);
    document.querySelector('#cashflow-first-date').innerHTML = formatDate(firstDate);
    document.querySelector('#cashflow-first-interest').innerHTML = firstAmount.toFixed(2);
    document.querySelector('#cashflow-second-date').innerHTML = formatDate(secondDate);
    document.querySelector('#cashflow-second-interest').innerHTML = secondAmount.toFixed(2);
    document.querySelector('#cashflow-second-last-date').innerHTML = formatDate(secondLastDate);
    document.querySelector('#cashflow-second-last-interest').innerHTML = secondLastAmount.toFixed(2);
    document.querySelector('#cashflow-last-date').innerHTML = formatDate(lastDate);
    document.querySelector('#cashflow-last-interest').innerHTML = lastAmount.toFixed(2);
    document.querySelectorAll('.bonds_returns_note .maturity').forEach(element => {
        element.innerHTML = maturityInYears;
    });
    
    console.log(cashflowResult.length, 'cashflowResult.length');

    if(cashflowResult.length >= 4) {
    
    document.querySelector('.vertical_dashed_divider').style.display = 'block';
}
else {
    document.querySelector('.vertical_dashed_divider').style.display = 'none';
}

}

function redirectToNotFound() {
    // window.location.replace('/bond-not-found');
}

// function toSlug(str) {
//     return str.toLowerCase().replace(/[^\w\s]/g, '').replace(/\s+/g, '-').trim();
// }
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

document.querySelector(".dropdown_search").addEventListener('input', inputChangeCalc);

function formatDate(dateString) {
    const date = new Date(dateString);
    
    // Months list for conversion
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    // Extracting components from the date object
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear().toString().slice(-2); // Get last two digits of the year
    
    // Formatting the date as required
    const formattedDate = `${day} ${month} '${year}`;
    
    return formattedDate;
}

</script>