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
    document.querySelector('#bond-yield').innerHTML = data.bondDetails.yield + '%';
    document.querySelector('#bond-mature').innerHTML = data.bondDetails.maturityInMonths;
    document.querySelector('#bond-investment').innerHTML = '₹' + minInvest;
    document.querySelector('#bond-interest').innerHTML = data.bondDetails.interestPayFreq;
    document.querySelector('#face-value').innerHTML = '₹' + data.bondDetails.faceValue.toLocaleString('en-IN');
    document.querySelector('#coupon-rate').innerHTML = data.bondDetails.couponRate + '%';
    document.querySelector('#coupon-type').innerHTML = data.bondDetails.couponType;
    document.querySelector('#bond-secure').innerHTML = data.bondDetails.secureUnsecure;
    document.querySelector('#seniority').innerHTML = data.bondDetails.seniority;
    document.querySelector('#issue-mode').innerHTML = data.bondDetails.modeOfIssue;
    document.querySelector('#tax-status').innerHTML = data.bondDetails.seniority ? '<span class="highlighted">Tax Free</span>' : '<span>Taxable</span>';
    document.querySelector('#bond-display').innerHTML = data.bondDetails.issuerName;
    if(data.bondDetails.issuerDescription) {
        document.querySelector('#issuer-desc').innerHTML = data.bondDetails.issuerDescription;
    }
    else {
        document.querySelector('#about_tab').style.display = 'none';
        document.querySelector('.tab_button[href="#about_tab"]').style.display = 'none';
    }
    
    document.querySelector('#faq-yield').innerHTML = data.bondDetails.yield;
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
}

function redirectToNotFound() {
    window.location.replace('/bond-not-found');
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


</script>