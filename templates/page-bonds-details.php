<?php
get_header();
$bond_name_slug = get_query_var('bond_company');
?>

<section class="stock_details_main">
    <div class="container">
        <div class="stock_details_wrapper">
            <div class="stock_details_left_column">
                <div class="stocks_search_container">
                    <?php get_template_part('template-parts/bond-details/bond-search-link'); ?>
                </div>
                <div class="stock_details_box stock_info_container">
                    <div class="stock_info_icons">
                        <div class="stock_img">
                            <img src="" alt="" />
                        </div>
                        <div class="share_icon" onclick="copyLink()">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                        </div>
                    </div>
                    <h1 id="bond-name"></h1>
                    <h2 id="issuer-name"></h2>
                    <h6 id="security-id"></h6>
                    <div class="bond_details_box">
                        <div class="bond_detail_col">
                                <div class="bond_single_detail">
                                    <p class="detail_info">Yield</p>
                                    <h4 id="bond-yield" class="highlighted"></h4>
                                </div>
                                <div class="bond_single_detail">
                                    <p class="detail_info">Matures in</p>
                                    <h4 id="bond-mature"></h4>
                                </div>
                        </div>
                        <div class="bond_detail_col">
                            <div class="bond_single_detail">
                                    <p class="detail_info">Min. Investment</p>
                                    <h4 id="bond-investment" class="highlighted"></h4>
                                </div>
                                <div class="bond_single_detail">
                                    <p class="detail_info">Interest Payment</p>
                                    <h4 id="bond-interest"></h4>
                                </div>
                        </div>
                    </div>
                    <div class="stock_tags">
                        <span>Industry: Technology Hardware</span>
                        <span>Sector: Technology</span>
                        <span>Large Cap</span>
                    </div>
                    <a href="<?php echo $signupurl; ?>">
                        <button class="primary_button">
                            Invest now
                        </button>
                    </a>
                </div>
            </div>
            <div class="stock_details_right_column">
                <div class="stock_tabs_menu_position"></div>
                <div class="stock_tabs_menu">
                    <div class="stock_tabs_menu_wrapper">
                        <a class="tab_button active" href="#returns_tab">Returns</a>
                        <a class="tab_button" href="#rating_tab">Rating</a>
                        <a class="tab_button" href="#metrics_tab">Metrics</a>
                        <a class="tab_button" href="#about_tab">About</a>
                        <a class="tab_button" href="#compare_tab">Compare</a>
                        <a class="tab_button" href="#faqs_tab">FAQs</a>
                    </div>
                </div>

                <?php 
                    get_template_part(
                        'template-parts/bond-details/returns'); 
                ?>
                <div class="ratings_tab_wrap">
                    <div class="ratings_tab">
                <?php 
                    get_template_part(
                        'template-parts/bond-details/ratings'); 
                ?>
                </div>
                <div class="ratings_tab">
                <?php 
                    get_template_part(
                        'template-parts/bond-details/metrics'); 
                ?>
                </div>
                </div>
                <?php 
                    get_template_part(
                        'template-parts/bond-details/issuer-details'); 
                ?>
                 <?php 
                    get_template_part(
                        'template-parts/bond-details/compare'); 
                ?>
                <?php 
                    get_template_part(
                        'template-parts/bond-details/fixed-income-products'); 
                ?>
                 <?php 
                    get_template_part(
                        'template-parts/bond-details/faqs'); 
                ?>
        </div>
        </div>
    </div>
</section>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>

<script>
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    const pathname = url.pathname;
    const pathSegments = pathname.split('/');
    const bondNameSlug = pathSegments[pathSegments.length - 2];
    const stockImg = document.querySelector('.stock_img img');
    const bondName = document.querySelector('#bond-name');
    const issuerName = document.querySelector('#issuer-name');
    const securityId = document.querySelector('#security-id');
    const bondYield = document.querySelector('#bond-yield');
    const bondMature = document.querySelector('#bond-mature');
    const bondInvestment = document.querySelector('#bond-investment');
    const bondInterest = document.querySelector('#bond-interest');
    const qtyInput = document.querySelector('.qty_stepper input[type=number]');
    const faceValue= document.querySelector('#face-value');
    const couponRate = document.querySelector('#coupon-rate');
    const couponType = document.querySelector('#coupon-type');
    const security = document.querySelector('#bond-secure');
    const seniority = document.querySelector('#seniority');
    const issueMode = document.querySelector('#issue-mode');
    const taxStatus = document.querySelector('#tax-status');
    const bondDisplayer = document.querySelector('#bond-display');
    const issuerDesc = document.querySelector('#issuer-desc');
    const faqBondNameElements = document.querySelectorAll('.faq-bond-name');
    const requestInfoUrl = document.querySelector('#request_info_url');
    const informDataUrl = document.querySelector('#inform_data_url');
    const apiUrl = 'https://yield-api-prod.vestedfinance.com/bonds';
    fetch(apiUrl, {
            method: 'GET',
            headers: {
                'User-Agent': 'Vested_M#8Dfz$B-8W6',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const foundBond = data.bonds.find(bond => toSlug(bond.displayName) === bondNameSlug);
            if (foundBond) {
                const bondOfferId = foundBond.offeringId;
                const singleBondApi = 'https://yield-api-prod.vestedfinance.com/bond-details?offeringId='+bondOfferId;
                fetch(singleBondApi)
                .then(response => response.json())
                .then(data => {
                    minInvest = data.bondDetails.minimumInvestment;
                    minInvest = minInvest.toFixed(2);
                    qtyInput.setAttribute("min", data.bondDetails.minimumQty);
                    qtyInput.setAttribute("max", data.bondDetails.maximumQty);
                    qtyInput.value = data.bondDetails.minimumQty;
                    stockImg.setAttribute('src', data.bondDetails.logo);
                    bondName.innerHTML = data.bondDetails.displayName;
                    issuerName.innerHTML = data.bondDetails.issuerName;
                    securityId.innerHTML = 'ISIN: ' + data.bondDetails.securityId;
                    bondYield.innerHTML = data.bondDetails.yield + '%';
                    bondMature.innerHTML = data.bondDetails.maturityInMonths;
                    bondInvestment.innerHTML = '₹'+minInvest;
                    bondInterest.innerHTML = data.bondDetails.interestPayFreq;
                    faceValue.innerHTML = '₹'+data.bondDetails.faceValue.toLocaleString('en-IN');
                    couponRate.innerHTML = data.bondDetails.couponRate + '%';
                    couponType.innerHTML = data.bondDetails.couponType;
                    security.innerHTML = data.bondDetails.secureUnsecure;
                    seniority.innerHTML = data.bondDetails.seniority;
                    issueMode.innerHTML = data.bondDetails.modeOfIssue;
                    if(data.bondDetails.seniority === false) {
                        taxStatus.innerHTML = '<span>Taxable</span>';
                    }
                    else {
                        taxStatus.innerHTML = '<span class="highlighted">Tax Free</span>';
                    }
                    bondDisplayer.innerHTML = data.bondDetails.issuerName;
                    issuerDesc.innerHTML = data.bondDetails.issuerDescription;
                    faqBondNameElements.forEach(element => {
                        element.innerHTML = data.bondDetails.displayName;
                    });
                    
                    requestInfoUrl.setAttribute('href', 'https://vestedfinance.typeform.com/to/BuPt2Xwu#bondname='+bondNameSlug);
                    informDataUrl.setAttribute('href', 'https://vestedfinance.typeform.com/to/W6VPlghm#bondname='+bondNameSlug);
                });
            }
            else {
                window.location.replace('/bond-not-found');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

    function toSlug(str) {
        return str
            .toLowerCase()
            .replace(/[^\w\s]/g, '')
            .replace(/\s+/g, '-')
            .trim();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<?php get_template_part('template-parts/bond-details/js/general-js'); ?>

<?php get_footer(); ?>