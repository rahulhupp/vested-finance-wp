<style>
    .main_calc_wrap {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        border-radius: 8px;
        border: 1px solid #b6c9db;
        overflow: hidden;
    }

    .calculator {
        padding: 42px 0;
    }

    .calculator .main_heading {
        color: #002852;

        font-size: 38px;
        font-style: normal;
        font-weight: 600;
        line-height: 110%;
        letter-spacing: -1.28px;
        margin-bottom: 10px;
    }

    .calculator .sub_heading {
        margin-bottom: 32px;
        color: rgba(33, 37, 41, 0.6);
        font-size: 16px !important;
        font-style: normal;
        font-weight: 400;
        line-height: 140%;
        letter-spacing: -0.32px;
        text-align: left;
        max-width: 100%;
    }

    .calculator .calc_form select {
        height: 52px;
        padding: 8px 14px;
        box-shadow: none;
        border-radius: 4px;
        border: 1px solid #a9bdd0;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAB6SURBVHgB7ZDBDYAgDEW/TKI31nAD46DGDVyDm0xiNEUPSFs6QN+JAH2PADiOM7C7cT3L4pqR9gyNuIxAOGidtul/HJTRMkiCrly8IwSelwNZjdTy/M408F8kCb7v0s7MAUlE2OT9ABshTHJboI3AKrcH6giscsdxCje0EzktB/V6CwAAAABJRU5ErkJggg==);
        background-position: calc(100% - 14px);
        cursor: pointer;
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        background-repeat: no-repeat;
        -webkit-appearance: none;
        width: 100%;
    }

    .calculator .select2-container .select2-selection {
        border: 1px solid #a9bdd0;
        border-radius: 4px;
        height: 52px;
        padding: 8px 14px;
        cursor: pointer;
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-bottom: 1em;
        outline: none;
    }

    .calculator .select2-container .select2-selection span#select2-resultsList-container {
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: 34px;
    }

    .calculator .select2-container .select2-selection span.select2-selection__arrow {
        height: 52px;
    }

    /* select 2 */
    .stock-result-list {
        margin-top: 16px;
        border: 1px solid #a9bdd0;
        border-radius: 4px;
    }

    .stock-result-list .select2-search--dropdown .select2-search__field {
        border: 1px solid #a9bdd0;
        border-radius: 4px;
        padding: 8px 14px;
        height: auto;
        box-shadow: none;
    }

    .select2-container--default .stock-result-list .select2-results__option--selected,
    .select2-container--default .stock-result-list .select2-results__option--highlighted.select2-results__option--selectable {
        background: #002852;
        color: #fff;
    }

    .stock-result-list .select2-results__option--selectable,
    .stock-result-list .select2-results__option {
        padding: 12px 14px;

        font-size: 14px;
        font-style: normal;
        margin: 0 0 1px;
    }

    /* end select 2 */
    .calculator .calc_form label {
        color: #464646;

        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 6px;
        display: inline-block;
    }

    .calculator .field_group {
        position: relative;
    }

    .calculator .inner_field {
        position: relative;
    }

    .calculator #invest_val {
        padding: 4px 14px 4px 24px;
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        height: 52px;
        margin-bottom: 0;
        border-radius: 4px;
        border: 1px solid #a9bdd0;
    }

    .calculator .currency {
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
    }

    .calculator .currency_select input[type="radio"] {
        display: none;
    }

    .calculator .currency_select input[type="radio"]+label {
        color: #1f4267;

        font-size: 17px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .calculator .currency_select {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px;
        border-radius: 4px;
        background: #eef5fc;
        position: absolute;
        right: 7px;
        top: 7px;
    }

    .calculator .currency_select input[type="radio"]+label {
        color: #1f4267;

        font-size: 17px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        padding: 3px 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .calculator .currency_select input[type="radio"]:checked+label {
        background: #fff;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.08);
    }

    .calculator .field_note span {
        display: flex;
        align-items: center;
        color: #002852;

        font-size: 12px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        gap: 8px;
    }

    .calculator .field_note {
        padding: 8px;
        border-radius: 4px;
        background: #eef5fc;
        margin-top: 8px;
    }

    .calculator .submit_btn input[type="submit"] {
        width: 100%;
        margin: 0;
    }

    .calculator .submit_btn {
        margin-top: 32px;
    }

    .calculator .field_row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .calculator .field_col {
        width: calc(50% - 8px);
    }

    .calculator .result_graph_col {
        width: 222px;
    }

    .calculator .result_breakdown_info {
        width: 320px;
    }

    .calculator .result_breakdown_wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .calculator .calc_result_col h3 {
        color: #002852;

        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 110%;
        margin-bottom: 28px;
    }

    .calculator .list {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .calculator .list p {
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 110%;
        margin-bottom: 0;
    }

    .calculator .list h4 {
        color: #002852;
        font-size: 22px;
        font-style: normal;
        font-weight: 500;
        line-height: 110%;
        /* 24.2px */
        letter-spacing: -0.66px;
        margin-bottom: 0;
        display: inline-block;
        width: auto;
    }

    .calculator .invested_val.list {
        padding-bottom: 18px;
        border-bottom: 1px dashed rgb(6 52 98 / 30%);
    }

    .calculator .est_return.list {
        margin-top: 18px;
        padding-bottom: 29px;
        border-bottom: 1px solid rgb(6 52 98 / 30%);
    }

    .calculator .total_val.list {
        margin-top: 29px;
        padding-bottom: 16px;
        border-bottom: 1px dashed rgb(6 52 98 / 30%);
    }

    .calculator .cagr_val.list {
        margin-top: 16px;
    }

    .calculator .cagr_val.list h4,
    .calculator .total_val.list h4 {
        font-weight: 600;
        font-size: 24px;
        letter-spacing: -0.96px;
        line-height: 110%;
    }

    .calculator .investment_cta {
        margin: 0 16px 16px 16px;
        border-radius: 6px;
        background: #002852;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .calculator .cta_content_col {
        width: 383px;
    }

    .calculator .cta_btn {
        width: 184px;
    }

    .calculator .cta_content_col p {
        color: #bed3ea;

        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 147.5%;
        margin-bottom: 0;
    }

    .calculator .cta_content_col p strong {
        font-weight: 600;
        color: #fff;
    }

    .calculator .cta_btn a {
        color: #0cc886;

        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        display: inline-block;
        padding: 12px 14px 12px 18px;
        border-radius: 6px;
        border: 1px solid #146045;
        transition: all 0.3s;
    }

    .calculator .cta_btn a i {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        margin-left: 2px;
    }

    .calculator .cta_btn a:hover {
        background: #146045;
        color: #fff;
    }

    .calculator .result_circle_wrap {
        position: relative;
    }

    .calculator .investment_amount_data {
        width: 184px;
        height: 184px;
        background-image: radial-gradient(circle closest-side,
                white 0,
                white 87%,
                transparent 0,
                transparent 100%,
                white 0),
            conic-gradient(from 58deg,
                #b3d2f1 100%,
                transparent 0%,
                transparent 0,
                transparent 0);
        margin: 0 auto;
        border-radius: 50%;
    }

    .calculator .returns_data {
        width: 200px;
        height: 200px;
        background-image: radial-gradient(circle closest-side,
                white 0,
                white 80%,
                transparent 0,
                transparent 100%,
                white 0),
            conic-gradient(from 0deg,
                #002852 40%,
                transparent 0%,
                transparent 0,
                transparent 0);
        margin: 0 auto;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .calc_desc {
        margin-bottom: 0;
        margin-top: 34px;
        color: rgba(33, 37, 41, 0.7);

        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .sub_heading {
        color: #505a64;
        text-align: center;
        font-size: 18px !important;
        font-style: normal;
        font-weight: 500;
        line-height: 120%;
        margin-top: 10px;
        max-width: 807px;
        margin-left: auto;
        margin-right: auto;
    }

    .calc-page .container {
        max-width: 1170px;
    }

    .calculator .field_col input[type="date"] {
        width: 100%;
    }

    .calculator .field_group {
        margin-bottom: 18px;
    }

    .calculator .currency_select input[type="radio"]+label {
        margin-bottom: 0;
    }

    .calculator #invest_val {
        width: 100%;
    }

    .calculator .submit_btn input[type="submit"] {
        width: 100%;
        margin: 0;
        border-radius: 6px;
        background: #0CC886;
        height: 56px;
        padding: 15px 0px 14px 0px;
        color: #FFF;
        font-size: 18px;
        font-weight: 700;
        line-height: 1em;
    }

    .calculator .container {
        padding: 0;
    }

    .calculator .field_col input[type="date"] {
        padding: 4px 14px 4px 24px;
        color: #002852;

        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        height: 52px;
        margin-bottom: 0;
        border-radius: 4px;
        border: 1px solid #a9bdd0;
    }

    .calculator .submit_btn input[type="submit"].btn-disabled {
        background: grey !important;
        pointer-events: none;
    }

    .fd_result svg+svg {
        display: none;
    }

    .calc_result_col.blur {
        filter: blur(4px);
        pointer-events: none;
    }

    #stocks_chart.blur {
        filter: blur(4px);
        pointer-events: none;
    }

    .chart.hidden {
        display: none;
    }

    .calc_col {
        width: 498px;
        padding: 36px;
    }

    .calc_result_col {
        width: 670px;
        background: #eef5fc;
    }

    .calculator .field_col input[type="date"]:focus,
    .calculator .field_col input[type="date"]:focus-visible {
        border: 1px solid #a9bdd0 !important;
        outline: none;
    }

    .calculator #invest_val:focus,
    .calculator #invest_val:focus-visible {
        border: 1px solid #a9bdd0;
        outline: none;
    }

    @media (max-width: 1200px) {

        .calc_col,
        .calc_result_col {
            width: 50%;
        }

        .calculator .result_breakdown_info {
            width: 270px;
        }

        .calculator .cta_btn {
            margin-top: 15px;
        }
    }

    @media (max-width: 1100px) {
        .calculator .result_breakdown_info {
            width: 248px;
        }

        .calculator .result_graph_col {
            width: 200px;
        }
    }

    @media (max-width: 1024px) {

        .calc_col,
        .calc_result_col {
            width: 100%;
        }

        .calculator .result_breakdown_info {
            width: calc(100% - 285px);
        }

        .calculator .cta_btn {
            margin-top: 0;
        }
    }


    @media (max-width: 767px) {
        .calculator .container {
            padding: 0 24px;
        }

        .calculator .result_breakdown_wrap {
            flex-direction: column;
        }

        .calculator .result_breakdown_info {
            width: 100%;
            margin-top: 40px;
        }

        .calc_desc {
            font-size: 14px !important;
        }

        .calculator .cta_btn a {
            margin-top: 15px;
            align-items: center;
            display: flex;
        }

        .sub_heading {
            font-size: 14px !important;
        }

        .about_calc_col,
        .other_calc_list {
            width: 100%;
        }

        .calc_cont p {
            font-size: 14px !important;
        }

        .main_calc_wrap {
            flex-direction: column;
        }

        .calc_col {
            padding: 16px;
        }

        .calculator .submit_btn input[type="submit"] {
            height: 48px;
            font-size: 16px;
        }

        .calculator .submit_btn {
            margin-top: 30px;
        }
    }
</style>
<section class="calculator">
    <div class="container">
        <h1 class="main_heading"><?php the_field('main_heading'); ?></h1>
        <p class="sub_heading"><?php the_field('main_sub_heading'); ?></p>


        <div class="main_calc_wrap">
            <div class="calc_col">

                <div class="calc_form_wrap">
                    <form action="" class="calc_form" id="chart_form">

                        <div class="field_group">
                            <label for="stockSelector">Select any US Stock or ETF</label>
                            <select name="stockSelector" id="resultsList">
                                <option value="AAPL">Appl, Inc - AAPL </option>
                                <option value="GOOGL">Alphabet </option>
                                <option value="META">Meta </option>
                                <option value="AMZN">Amazon </option>
                                <option value="NFLX">Netflix </option>
                            </select>
                        </div>

                        <div class="field_group">
                            <label for="invest_val">Enter Investment Amount</label>

                            <div class="inner_field">
                                <span class="currency">$</span>
                                <input type="text" id="invest_val" value="1,000">

                                <div class="currency_select">
                                    <div>
                                        <input type="radio" name="currency" id="inr_currency" value="inr">
                                        <label for="inr_currency">INR</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="currency" id="usd_currency" value="usd" checked>
                                        <label for="usd_currency">USD</label>
                                    </div>
                                </div>
                            </div>
                            <div class="field_note">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                        <path d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18Z" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10.5 13.5V10.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10.5 7.5H10.5075" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> Choose INR for adjusted returns considering INR<>USD conversion. FX rates based on Google's 1 USD price.</span>
                            </div>
                        </div>

                        <?php $currentDate = date('Y-m-d'); ?>
                        <div class="field_group">
                            <div class="field_row">
                                <div class="field_col">
                                    <label for="startMonth">Start Month</label>
                                    <input type="date" name="startMonth" id="startMonth" max="<?php echo $currentDate; ?>">
                                </div>
                                <div class="field_col">
                                    <label for="endMonth">End Month</label>
                                    <input type="date" name="endMonth" id="endMonth" max="<?php echo $currentDate; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="submit_btn">
                            <input type="submit" value="Calculate">
                        </div>
                    </form>
                </div>

            </div>
            <div class="calc_result_col blur">
                <div class="result_inner_col">
                    <h3>Return Breakdown</h3>
                    <div class="result_breakdown_wrap">
                        <div class="result_graph_col">
                            <!-- <div class="result_circle_wrap">
                                    <div class="investment_amount_data"></div>
                                    <div class="returns_data"></div>
                                </div> -->
                            <div class="fd_result" id="fd_results">
                                <div class="total_value">
                                    <p>Total Value</p>
                                    <h4><span class="calc_currency">$</span> <span id="total_calc_val">0</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="result_breakdown_info">

                            <div class="breakdown_list">
                                <div class="invested_val list">
                                    <p>Invested Amount</p>
                                    <h4><span class="calc_currency">$</span> <span id="invest_amt">0</span></h4>
                                </div>
                                <div class="est_return list">
                                    <p>Est. Returns</p>
                                    <h4><span class="calc_currency">$</span> <span id="est_returns">0</span></h4>
                                </div>
                                <div class="total_val list">
                                    <p>Total Value</p>
                                    <h4><span class="calc_currency">$</span> <span id="total_value">0</span></h4>
                                </div>
                                <div class="cagr_val list">
                                    <p>CAGR</p>
                                    <h4><span id="cagr">0</span> %</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="investment_cta">
                    <div class="cta_content_col">
                        <p>If you had invested $<span id="content_invest_amt">0</span> in January 2021, it would be worth <strong>$<span id="content_total_value">0</span></strong> by August 2023 with <strong><span id="content_cagr">0</span>% CAGR</strong></p>
                    </div>
                    <div class="cta_btn">
                        <a href="<?php the_field('cta_button_url'); ?>"><?php the_field('cta_button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
        <?php if (is_page_template('templates/page-us-stock-global.php')) : ?>
            <p class="calc_desc">
                <?php the_field('calc_disclaimer'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>



<section class="chart <?php if (is_page_template('templates/page-us-stock-global.php') || is_page_template('templates/page-us-stock-india.php')) : ?> hidden <?php endif; ?>">
    <div class="container">
        <div id="stocks_chart" class="blur">
            <canvas id="myChart" style="width:100%;max-width:1170px"></canvas>
        </div>

    </div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    // Add an event listener to the form for the "submit" event
    document.getElementById('chart_form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve and log the values of the form elements
        var stockSelector = document.getElementById('resultsList').value;
        var investmentAmount = document.getElementById('invest_val').value;
        var currency = document.querySelector('input[name="currency"]:checked').value;
        var startDate = document.getElementById('startMonth').value;
        var endDate = document.getElementById('endMonth').value;

        // console.log('Stock Selector: ' + stockSelector);
        // console.log('Investment Amount: ' + investmentAmount);
        // console.log('Currency: ' + currency);
        // console.log('Start Date: ' + startDate);
        // console.log('End Date: ' + endDate);

        // document.getElementById('invest_amt').textContent = investmentAmount;

        triggerAPI(stockSelector, startDate, endDate)
    });

    // Event handler for currency radio buttons
    document.querySelectorAll('.currency_select input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Check which radio button is checked
            var selectedOption = document.querySelector('input[name="currency"]:checked').value;

            // Update the text based on the selected radio button
            if (selectedOption === "inr") {
                document.querySelectorAll('.currency').forEach(function(element) {
                    element.textContent = "₹";
                });
                document.querySelectorAll('.calc_currency').forEach(function(element) {
                    element.textContent = "₹";
                });
            } else if (selectedOption === "usd") {
                document.querySelectorAll('.currency').forEach(function(element) {
                    element.textContent = "$";
                });
                document.querySelectorAll('.calc_currency').forEach(function(element) {
                    element.textContent = "$";
                });
            }
        });
    });

    // Function to update button status
    function btnStatus() {
        var startDate = document.getElementById('startMonth').value;
        var endDate = document.getElementById('endMonth').value;

        if (startDate === '' || endDate === '') {
            document.querySelector('.submit_btn input').classList.add('btn-disabled');
        } else {
            document.querySelector('.submit_btn input').classList.remove('btn-disabled');
        }
    }

    btnStatus();

    // Event listeners for date input changes
    document.getElementById('startMonth').addEventListener('input', btnStatus);
    document.getElementById('endMonth').addEventListener('input', btnStatus);

    var Per;
    var bar = new ProgressBar.Circle(fd_results, {
        strokeWidth: 11,
        easing: "easeInOut",
        duration: 1400,
        color: "#002852",
        trailColor: "#B3D2F1",
        trailWidth: 7,
        svgStyle: null,
    });
    bar.animate(0.5);
    const xValues = [];
    const yValues = [1, 1000];
    renderChart(xValues, yValues);
    // Define the URL of the API you want to call
    function triggerAPI(stockSelector, startDate, endDate) {
        const apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/${stockSelector}/ohlcv?interval=daily&startDate=${startDate}&endDate=${endDate}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log('inn dataArray', data.data);

                const xValues = [];
                data.data.forEach(item => {
                    xValues.push(item.Date);

                });

                const yValues = [];
                const startPrice = data.data[0].Adj_Close;
                const endPrice = data.data[data.data.length - 1].Adj_Close;
                const firstDate = new Date(data.data[0].Date);
                const lastDate = new Date(data.data[data.data.length - 1].Date);
                const startStockQty = parseFloat(10000 / startPrice).toFixed(2);
                const stockSelector = document.getElementById('resultsList').value;
                const investmentAmountString = document.getElementById('invest_val').value;
                const investmentAmount = parseFloat(investmentAmountString.replace(/[^0-9.]/g, ''));
                const finalInvestmentAmount = investmentAmount.toLocaleString();
                const currency = document.querySelector('input[name="currency"]:checked').value;

                const stockQty = parseFloat(investmentAmount / startPrice).toFixed(2);
                const lastPortfolioValue = parseFloat(endPrice * stockQty).toFixed(2);
                const estReturns = parseFloat(lastPortfolioValue - investmentAmount);
                const totalValue = parseFloat(Number(investmentAmount) + Number(estReturns));
                const initialPortfolioPrice = parseFloat(Number(lastPortfolioValue) / investmentAmount).toFixed(2);
                const differenceInMilliseconds = lastDate - firstDate;
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                const differenceInYears = parseFloat(differenceInDays / 365.25).toFixed(2);
                const Periods = parseFloat(1 / differenceInYears).toFixed(2);
                var CACR = (Math.pow(initialPortfolioPrice, Periods) - 1) * 100;
                Per = parseFloat(lastPortfolioValue / investmentAmount).toFixed(2);

                data.data.forEach(item => {
                    let finalAmount = item.Adj_Close * startStockQty;
                    // let result = parseFloat(finalAmount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    let result = parseFloat(item.Adj_Close * startStockQty);
                    result = Math.round(result);
                    // console.log('Final price', result);
                    yValues.push(result);
                });



                console.log('startPrice', startPrice);
                console.log('endPrice', endPrice);
                console.log('stockSelector', stockSelector);
                console.log('investmentAmount', finalInvestmentAmount);
                console.log('currency', currency);
                console.log('stockQty', stockQty);
                console.log('estReturns', estReturns.toLocaleString());
                console.log('lastPortfolioValue', lastPortfolioValue);
                console.log('totalValue', totalValue);
                console.log('initialPortfolioPrice', initialPortfolioPrice);
                console.log('firstDate', firstDate);
                console.log('lastDate', lastDate);
                console.log('differenceInDays', differenceInDays);
                console.log('differenceInYears', differenceInYears);
                console.log('Periods', Periods);
                console.log('CACR', CACR);
                console.log('calculatePercentage', Per);

                document.getElementById('invest_amt').textContent = finalInvestmentAmount;
                document.getElementById('total_calc_val').textContent = finalInvestmentAmount;
                document.getElementById('est_returns').textContent = estReturns.toLocaleString();
                document.getElementById('total_value').textContent = totalValue.toLocaleString();
                document.getElementById('cagr').textContent = CACR.toLocaleString();
                document.getElementById('content_invest_amt').textContent = finalInvestmentAmount;
                document.getElementById('content_total_value').textContent = totalValue.toLocaleString();
                document.getElementById('content_cagr').textContent = CACR.toLocaleString();
                document.querySelector('.calc_result_col').classList.remove('blur');
                document.getElementById('stocks_chart').classList.remove('blur');
                bar.animate(Per);
                renderChart(xValues, yValues);

            })
            .catch(error => alert("Something went wrong!"));
    }


    function renderChart(xValues, yValues) {
        const dateObjects = xValues.map(dateString => new Date(dateString));

        const formattedLabels = dateObjects.map(date => {
            const month = date.toLocaleString('default', {
                month: 'short'
            }); // Get short month name
            const day = date.getDate(); // Get day of the month
            const year = date.getFullYear(); // Get full year
            return `${month} ${day}, ${year}`;
        });

        new Chart("myChart", {
            type: "line",
            data: {
                labels: formattedLabels,
                datasets: [{
                    data: yValues,
                    borderColor: "#002852",
                    fill: false,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    xAxis: {
                        ticks: {
                            maxTicksLimit: 10
                        }
                    },
                    yAxes: [{
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '' + value.toLocaleString();
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                            });
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        });
    }
</script>