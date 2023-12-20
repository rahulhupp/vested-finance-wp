<style>
    .calculator.calc_page_block .main_heading {
        font-size: 32px;
        line-height: 35.2px;
    }

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
        margin-top: -16px;
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

    .cal_heading_wrap {
        max-width: 684px;
    }

    /* 18/12/23 */

    .dropdown_options ul {
        margin: 0;
        max-height: 240px;
        overflow: auto;
        margin-top: 15px;
    }

    .dropdown_options ul li {
        list-style: none;
        padding: 10px 0;
        cursor: pointer;
        transition: all .3s;
        color: rgba(33, 37, 41, 0.6);
    }

    .options_dropdown_wrap {
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius: 0 0 10px 10px;
        padding: 10px 20px;
        position: absolute;
        width: 100%;
        z-index: 1;
        display: none;
    }

    .dropdown_collased .options_dropdown_wrap {
        display: block;
    }

    .options_dropdown_wrap input {
        width: 100%;
        border: 1px solid #002852;
        background: none;
        border-radius: 6px;
    }

    .dropdown_options ul li:hover {
        color: #002852;
    }

    .selected_option {
        border-radius: 4px;
        border: 1px solid #A9BDD0;
        background: #FFF;
        height: 52px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        color: #002852;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        position: relative;
    }

    .selected_option:after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAB6SURBVHgB7ZDBDYAgDEW/TKI31nAD46DGDVyDm0xiNEUPSFs6QN+JAH2PADiOM7C7cT3L4pqR9gyNuIxAOGidtul/HJTRMkiCrly8IwSelwNZjdTy/M408F8kCb7v0s7MAUlE2OT9ABshTHJboI3AKrcH6giscsdxCje0EzktB/V6CwAAAABJRU5ErkJggg==);
        background-size: contain;
        background-repeat: no-repeat;
        right: 14px;
        transition: all .3s;
    }

    .options_dropdown_wrap input:focus,
    .options_dropdown_wrap input:focus-visible {
        border: 1px solid #002852;
        outline: none;
    }

    .dropdown_options ul p {
        margin: 0;
    }


    /* 20/12/23 */
    #stocks_chart {
        position: relative;
        margin-top: 30px;
    }

    .legend_color {
        width: 40px;
        height: 20px;
    }

    .legend_color.stock_color {
        background: #002852;
    }

    .legend_color.sp_color {
        background: #ec9235;
    }

    .legend_color.nifty_color {
        background: #3861f6;
    }

    .chart_legends {
        position: absolute;
        top: -30px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .single_legend {
        display: flex;
        align-items: center;
    }

    .legend_name {
        font-size: 12px;
        margin-left: 5px;
    }

    .single_legend:not(:first-child) {
        margin-left: 15px;
    }

    .nifty_legend {
        display: none;
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
<?php
$chart = isset($GLOBALS['chart']) ? $GLOBALS['chart'] : 'false';
$stock_data = isset($GLOBALS['stock_data']) ? $GLOBALS['stock_data'] : 'default_data';
?>
<section class="calculator <?php if (is_page_template('templates/page-calculator.php')) : ?> calc_page_block <?php endif; ?>">
    <div class="container">
        <div class="cal_heading_wrap">
            <h1 class="main_heading"><?php the_field('main_heading'); ?></h1>
            <p class="sub_heading"><?php the_field('main_sub_heading'); ?></p>
        </div>

        <div class="main_calc_wrap">
            <div class="calc_col">

                <div class="calc_form_wrap">
                    <form action="" class="calc_form" id="chart_form">

                        <div class="field_group">
                            <label for="stockSelector">Select any US Stock or ETF</label>
                            <div class="select_box_new">
                                <div class="selected_option" data-value="AAPL" id="resultsList">Apple</div>
                                <div class="options_dropdown_wrap">
                                    <input type="text" class="dropdown_search" oninput="inputChangeCalc()" placeholder="Type any US stock or ETF">
                                    <div class="dropdown_options">
                                        <ul class="static_options">
                                            <li data-value="AAPL">Apple</li>
                                            <li data-value="GOOGL">Google</li>
                                            <li data-value="AGPXX">Invesco</li>
                                            <li data-value="MSFT">Microsoft</li>
                                            <li data-value="TSLA">Tesla</li>
                                            <li data-value="META">Meta</li>
                                            <li data-value="NFLX">Netflix</li>
                                            <li data-value="BWX">SPDR</li>
                                            <li data-value="AMZN">Amazon</li>
                                            <li data-value="SPOT">Spotify</li>
                                        </ul>
                                        <ul class="dynamic_options"></ul>
                                    </div>
                                </div>
                            </div>
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
                        <p>If you had invested $<span id="content_invest_amt">0</span> in <span id="start_month">January 2021</span>, it would be worth <strong>$<span id="content_total_value">0</span></strong> by <span id="end_month">August 2023</span> with <strong><span id="content_cagr">0</span>% CAGR</strong></p>
                    </div>
                    <div class="cta_btn">
                        <a href="<?php the_field('cta_button_url'); ?>"><?php the_field('cta_button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
        <?php if (is_page_template('templates/page-us-stock-global.php') || is_page_template('templates/page-us-stock-india.php')) : ?>
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
            <div class="chart_legends">
                <div class="single_legend">
                    <div class="legend_color stock_color">

                    </div>
                    <div class="legend_name">
                        Stocks Value
                    </div>
                </div>
                <div class="single_legend">
                    <div class="legend_color sp_color">

                    </div>
                    <div class="legend_name">
                        S&P Value
                    </div>
                </div>
                <div class="single_legend nifty_legend">
                    <div class="legend_color nifty_color">

                    </div>
                    <div class="legend_name">
                        Nifty 50
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    // Add an event listener to the form for the "submit" event
    document.getElementById('chart_form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve and log the values of the form elements
        var stockSelector = document.getElementById('resultsList').dataset.value;
        var investmentAmount = document.getElementById('invest_val').value;
        var currency = document.querySelector('input[name="currency"]:checked').value;
        var startDate = document.getElementById('startMonth').value;
        var endDate = document.getElementById('endMonth').value;
        var inputDate = new Date(startDate);
        var inputDateEnd = new Date(endDate);
        var start_month = inputDate.toLocaleString('default', {
            month: 'long'
        });
        var end_month = inputDateEnd.toLocaleString('default', {
            month: 'long'
        });
        var year = inputDate.getFullYear();
        var endYear = inputDateEnd.getFullYear();
        var result = start_month + ' ' + year;
        var resultEnd = end_month + ' ' + endYear;
        document.querySelector('#start_month').textContent = result;
        document.querySelector('#end_month').textContent = resultEnd;
        triggerAPI(stockSelector, startDate, endDate)
            .then(data => {
                // Update the chart with the processed data
                renderChart(data.xValues, data.yValues, data.zValues, data.bValues);
            })
            .catch(error => alert("Something went wrong!"));
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
    const generateRandomValues = (count, min, max) => {
        const randomValues = [];
        for (let i = 0; i < count; i++) {
            const randomValue = Math.floor(Math.random() * (max - min + 1)) + min;
            randomValues.push(randomValue);
        }
        return randomValues;
    };
    const generateXValues = (count, start, step) => {
        const xValues = [];
        for (let i = 0; i < count; i++) {
            xValues.push(start + i * step);
        }
        return xValues;
    };
    var xValues = [];
    var yValues = [];
    var zValues = [];
    var bValues = [];
    renderChart(xValues, yValues, zValues, bValues);
    // Define the URL of the API you want to call
    function triggerAPI(stockSelector, startDate, endDate) {
        const apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/${stockSelector}/ohlcv?interval=daily&startDate=${startDate}&endDate=${endDate}`;
        const sp500Api = `https://vested-woodpecker-staging.vestedfinance.com/instrument/GSPC.INDX/ohlcv?interval=daily&startDate=${startDate}&endDate=${endDate}`;
        const niftyApi = `https://vested-woodpecker-staging.vestedfinance.com/instrument/NSEI.INDX/ohlcv?interval=daily&startDate=${startDate}&endDate=${endDate}`;
        const fetchStockData = fetch(apiUrl).then(response => response.json());
        const fetchSP500Data = fetch(sp500Api).then(response => response.json());
        const fetchNiftyData = fetch(niftyApi).then(response => response.json());
        return Promise.all([fetchStockData, fetchSP500Data, fetchNiftyData])
            .then(([stockData, sp500Data, niftyData]) => {
                // Process stockData
                var xValues = [];
                var yValues = [];
                var zValues = [];
                var bValues = [];
                const startPrice = stockData.data[0].Adj_Close;
                const endPrice = stockData.data[stockData.data.length - 1].Adj_Close;
                const firstDate = new Date(stockData.data[0].Date);
                const lastDate = new Date(stockData.data[stockData.data.length - 1].Date);
                const stockSelector = document.getElementById('resultsList').dataset.value;
                const investmentAmountString = document.getElementById('invest_val').value;
                const investmentAmount = parseFloat(investmentAmountString.replace(/[^0-9.]/g, ''));
                const startStockQty = parseFloat(investmentAmount / startPrice).toFixed(2);
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
                // var CACR = (Math.pow(initialPortfolioPrice, Periods) - 1) * 100;
                var CACR = (Math.pow(totalValue / investmentAmount, 1 / differenceInYears) - 1) * 100;
                CACR = CACR.toFixed(2);
                Per = parseFloat(lastPortfolioValue / investmentAmount).toFixed(2);
                var percentageInvestment = (investmentAmount / totalValue) * 100;
                var percentageEstimatedReturn = (estReturns / totalValue).toFixed(2);

                stockData.data.forEach(item => {
                    xValues.push(item.Date);
                    let finalAmount = item.Adj_Close * startStockQty;
                    let result = Math.round(finalAmount);
                    yValues.push(result);
                });

                // Process sp500Data

                sp500Data.data.forEach(item => {
                    let spResult = Math.round(item.Adj_Close);
                    zValues.push(spResult);
                });

                niftyData.data.forEach(item => {
                    let niftyResult = Math.round(item.Adj_Close);
                    bValues.push(niftyResult);
                });

                // Continue with the rest of your calculations and rendering
                // ...
                document.getElementById('invest_amt').textContent = finalInvestmentAmount;
                document.getElementById('total_calc_val').textContent = finalInvestmentAmount;
                document.getElementById('est_returns').textContent = Math.round(estReturns);
                document.getElementById('total_value').textContent = Math.round(totalValue);
                document.getElementById('cagr').textContent = CACR.toLocaleString();
                document.getElementById('content_invest_amt').textContent = finalInvestmentAmount;
                // document.getElementById('content_total_value').textContent = totalValue.toLocaleString();
                document.getElementById('content_total_value').textContent = Math.round(totalValue);
                document.getElementById('content_cagr').textContent = CACR.toLocaleString();
                document.querySelector('.calc_result_col').classList.remove('blur');
                document.getElementById('stocks_chart').classList.remove('blur');
                if (percentageEstimatedReturn > 0) {
                    bar.animate(percentageEstimatedReturn);
                } else {
                    bar.animate(0);
                }
                return {
                    xValues,
                    yValues,
                    zValues,
                    bValues
                };
            })
            .catch(error => alert("Something went wrong!"));
    }

    function renderChart(xValues, yValues, zValues, bValues) {
        const dateObjects = xValues.map(dateString => new Date(dateString));
        const inrCurrencyRadioButton = document.getElementById('inr_currency');
        const usdCurrencyRadioButton = document.getElementById('usd_currency');
        const formattedLabels = dateObjects.map(date => {
            const month = date.toLocaleString('default', {
                month: 'short'
            }); // Get short month name
            const day = date.getDate(); // Get day of the month
            const year = date.getFullYear(); // Get full year
            return `${month} ${day}, ${year}`;
        });
        const myChart = new Chart("myChart", {
            type: "line",
            data: {
                labels: formattedLabels,
                datasets: [{
                        label: 'Stocks Value',
                        data: yValues,
                        borderColor: "#002852",
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'S&P 500',
                        data: zValues,
                        borderColor: "#ec9235",
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Nifty 50',
                        data: bValues,
                        borderColor: "#3861f6",
                        fill: false,
                        pointRadius: 0,
                        hidden: true
                    }
                ]
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
        inrCurrencyRadioButton.addEventListener('change', function() {
            const nifty50DatasetIndex = 2;

            myChart.data.datasets[nifty50DatasetIndex].hidden = !inrCurrencyRadioButton.checked;
            document.querySelector('.nifty_legend').style.display = 'flex';
            myChart.update();
        });

        usdCurrencyRadioButton.addEventListener('change', function() {
            const nifty50DatasetIndex = 2;
            myChart.data.datasets[nifty50DatasetIndex].hidden = usdCurrencyRadioButton.checked;
            myChart.update();
            document.querySelector('.nifty_legend').style.display = 'none';
        });
    }
    document.querySelector('.selected_option').addEventListener("click", function() {
        const mainDropdown = document.querySelector('.select_box_new');
        if (mainDropdown.classList.contains("dropdown_collased")) {
            mainDropdown.classList.remove("dropdown_collased");
        } else {
            mainDropdown.classList.add("dropdown_collased");
        }
    });


    document.addEventListener('click', function(event) {
        const clickedElement = event.target;
        const mainDropdown = document.querySelector('.select_box_new');
        if (clickedElement.tagName === 'LI' && clickedElement.closest('.dropdown_options ul')) {

            const mainValue = document.querySelector('.selected_option');

            const selectedValue = clickedElement.dataset.value;

            mainValue.textContent = clickedElement.textContent;
            mainValue.dataset.value = selectedValue;

            if (mainDropdown.classList.contains("dropdown_collased")) {
                mainDropdown.classList.remove("dropdown_collased");
            } else {
                mainDropdown.classList.add("dropdown_collased");
            }
        }

        if (!mainDropdown.contains(clickedElement)) {
            mainDropdown.classList.remove("dropdown_collased");
        }
    });


    function fetchDataFromIndexedDB(searchTerm) {
        let db;
        const dbName = "stocks_list";

        const request = indexedDB.open(dbName, 2);

        request.onsuccess = function(event) {
            db = event.target.result;

            populateDropdownOptions(searchTerm);
        };

        request.onerror = function(event) {
            console.error("Error opening database:", event.target.error);
        };

        function populateDropdownOptions(searchTerm) {
            const transaction = db.transaction(["stocks"], "readonly");
            const objectStore = transaction.objectStore("stocks");

            const cursorRequest = objectStore.openCursor();

            const dropdownOptions = document.querySelector('.dropdown_options ul.dynamic_options');

            dropdownOptions.innerHTML = '';

            cursorRequest.onsuccess = function(event) {
                const cursor = event.target.result;

                if (cursor) {
                    const symbol = cursor.value.symbol;
                    const name = cursor.value.name;

                    if (name.toLowerCase().includes(searchTerm)) {
                        const listItem = document.createElement("li");
                        listItem.textContent = name;
                        listItem.dataset.value = symbol;

                        dropdownOptions.appendChild(listItem);
                    }

                    cursor.continue();
                } else {
                    db.close();
                }
            };

            cursorRequest.onerror = function(event) {
                console.error("Error opening cursor:", event.target.error);
            };
        }
    }

    /**/

    var timerId;
    var debounceFunctionCalc = function(func, delay) {
        // Cancels the setTimeout method execution
        clearTimeout(timerId)

        // Executes the func after delay time.
        timerId = setTimeout(func, delay)
    }

    // This represents a very heavy method. Which takes a lot of time to execute
    function makeAPICallCalc() {
        var inputValue = document.querySelector(".dropdown_search").value;
        var staticOptions = document.querySelector(".static_options");
        var dynamicOptions = document.querySelector(".dynamic_options");
        if (inputValue.length >= 1) {
            staticOptions.style.display = "none";
            dynamicOptions.style.display = "block";
            fetchResultCalc(inputValue);
        } else {
            staticOptions.style.display = "block";
            dynamicOptions.style.display = "none";
        }

    }

    function inputChangeCalc() {
        var inputValue = document.querySelector(".dropdown_search").value;
        let timeout;
        debounceFunctionCalc(makeAPICallCalc, 500)
    }

    async function fetchResultCalc(stock_name) {
        try {
            const results = await connection.select({
                from: 'stocks',
                order: {
                    by: 'symbol',
                    type: "asc"
                },
                where: {
                    symbol: {
                        like: `${stock_name}%`
                    },
                    or: {
                        name: {
                            like: `${stock_name}%`
                        }
                    }
                }
            });
            renderItemsCalc(results);
        } catch (err) {
            console.log(err);
        }
    }

    function renderItemsCalc(results) {
        const dropdownOptions = document.querySelector('.dropdown_options ul.dynamic_options');
        dropdownOptions.innerHTML = '';

        if (results.length > 0) {
            results.forEach(result => {
                const listItem = document.createElement("li");
                listItem.textContent = result.name;
                listItem.dataset.value = result.symbol;
                dropdownOptions.appendChild(listItem);
            });
        } else {
            // If there are no results and no input, display static options
            const inputValue = document.querySelector(".dropdown_search").value;
            if (inputValue.trim() === "") {
                const staticOptions = document.querySelectorAll('.static_options');
                staticOptions.forEach(staticOption => {
                    const listItem = document.createElement("li");
                    listItem.textContent = staticOption.textContent;
                    listItem.dataset.value = staticOption.dataset.value;
                    dropdownOptions.appendChild(listItem);
                });
            } else {
                // Display "No Result Found!" message when there are no matching API results
                const listItem = document.createElement("p");
                listItem.textContent = "No Result Found!";
                dropdownOptions.appendChild(listItem);
            }
        }
    }
</script>