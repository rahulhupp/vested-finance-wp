<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
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
        background-color: #fff;
    }

    .calculator .main_heading {
        color: #002852;
        font-size: 38px;
        font-style: normal;
        font-weight: 800;
        line-height: 110%;
        letter-spacing: -1.28px;
        margin-bottom: 10px;
    }

    .calculator .sub_heading {
        margin-bottom: 32px;
        color: rgba(33, 37, 41, 0.6);
        font-family: "Inter", sans-serif;
        font-size: 18px !important;
        font-style: normal;
        font-weight: 400;
        line-height: 130%;
        text-align: center;
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
        line-height: 21px;
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
        color: #002852;
        font-size: 12px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        width: calc(100% - 21px);
        padding-left: 8px;
    }

    .calculator .field_note {
        padding: 8px;
        border-radius: 4px;
        background: #eef5fc;
        margin-top: 8px;
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .calculator .submit_btn {
        margin-top: 50px;
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
        position: relative;
    }

    .calculator .result_graph_col {
        width: 222px;
    }

        .result_inner_col {
        padding: 36px;
    }

    .total_value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
    }

    .fd_result {position: relative;}

    .total_value p {
        color: #002852;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.1;
        margin-bottom: 7px;
        text-align: center;
    }

    .total_value h4 {
        color: #002852;
        font-weight: 600;
        font-size: 18px;
        line-height: 1.1;
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

    .calculator .invested_val.list p {
        position: relative;
        padding-left: 30px;
    }

    .calculator .invested_val.list p:before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        background: #b3d2f1;
        border-radius: 50%;
        left: 0px;
        top: 50%;
        transform: translateY(-50%);
    }

    .est_return.list p {
        position: relative;
        padding-left: 30px;
    }

    .est_return.list p:before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        background: #002852;
        border-radius: 50%;
        left: 0px;
        top: 50%;
        transform: translateY(-50%);
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
        padding-left: 0;
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
        margin: 0 16px 0px 16px;
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
        color: #0CC886;
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        display: inline-block;
        padding: 12px 14px 12px 18px;
        border-radius: 6px;
        border: 1px solid #0CC886;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calculator .cta_btn a span {
        display: block;
    }

    .calculator .cta_btn a svg {
        margin: 0 0 0 9px;
        position: relative;
        top: 1px;
    }

    .calculator .cta_btn a:hover svg path {
        stroke: #fff;
    }

    .calculator .cta_btn a:hover {
        background: #0CC886;
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


    .sub_heading {
        color: rgba(33, 37, 41, 0.6);
        font-family: "Inter", sans-serif;
        font-size: 18px !important;
        font-style: normal;
        font-weight: 400;
        line-height: 130%;
        text-align: center;
        margin-top: 10px;
        max-width: 807px;
        margin-left: auto;
        margin-right: auto;
    }

    .calculator .field_col .flatpickr-input {
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

    .calculator .submit_btn button {
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

    .calculator .submit_btn button span {
        pointer-events: none;
    }


    .calculator .submit_btn button svg {
        width: 0;
        height: 0;
        margin-right: 0;
        transition: all 0.5s ease;
        pointer-events: none;
    }

    .calculator .submit_btn button svg.show_loader {
        margin-right: 8px;
        width: 32px;
        height: 32px;
    }

    .calculator .field_col .flatpickr-input {
        padding: 4px 14px;
        color: #002852;
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        height: 52px;
        margin-bottom: 0;
        border-radius: 4px;
        border: 1px solid #a9bdd0;
        background: #fff;
    }

    .calculator .field_col:before {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAB6SURBVHgB7ZDBDYAgDEW/TKI31nAD46DGDVyDm0xiNEUPSFs6QN+JAH2PADiOM7C7cT3L4pqR9gyNuIxAOGidtul/HJTRMkiCrly8IwSelwNZjdTy/M408F8kCb7v0s7MAUlE2OT9ABshTHJboI3AKrcH6giscsdxCje0EzktB/V6CwAAAABJRU5ErkJggg==);
        background-size: contain;
        background-repeat: no-repeat;
        right: 14px;
        bottom: 13px;
        pointer-events: none;
        transition: all .3s;
    }

    .flatpickr-monthSelect-month.selected {
        background-color: #002852;
        border-color: #002852;
    }

    .flatpickr-current-month {
        padding-top: 12px;
    }

    .flatpickr-months .flatpickr-prev-month:hover svg,
    .flatpickr-months .flatpickr-next-month:hover svg {
        fill: #002852;
    }

    .calculator .submit_btn button.btn-disabled {
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


    .calc_col {
        width: 498px;
        padding: 36px;
    }

    .calc_result_col {
        width: 670px;
        background: #FAFAFA;
    }

    .calculator .field_col .flatpickr-input:focus,
    .calculator .field_col .flatpickr-input:focus-visible {
        border: 1px solid #a9bdd0 !important;
        outline: none;
    }

    .calculator #invest_val:focus,
    .calculator #invest_val:focus-visible {
        border: 1px solid #a9bdd0;
        outline: none;
    }


    /* 18/12/23 */

    .dropdown_options ul {
        margin: 0;
        max-height: 240px;
        overflow: auto;
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
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .selected_option .dropdown_search {
        color: #002852;
        font-size: 16px;
        font-weight: 500;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        border: none;
        background-color: #fff;
    }

    .selected_option .dropdown_search:focus,
    .selected_option .dropdown_search:active,
    .selected_option .dropdown_search:focus-within,
    .selected_option .dropdown_search:focus-visible {
        border: none;
        outline: none;
        box-shadow: none;
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


    #loader {
        display: none;
        width: 32px;
        height: 32px;
        animation: loaderamin 0.5s infinite;
    }

    .loader_svg {
        animation: loaderamin 0.5s infinite;
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
        .main_calc_wrap {
            flex-wrap: wrap;
        }

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

        .calculator .submit_btn button {
            height: 48px;
            font-size: 16px;
        }

        .calculator .submit_btn {
            margin-top: 30px;
        }


        .main_calc_wrap {
            border: none;
            padding: 0;
        }

        .main_calc_wrap .calc_col {
            padding: 20px;
        }

        .calculator .calc_form label {
            font-size: 12px;
        }

        .selected_option {
            font-size: 14px;
            height: 42px;
        }

        .options_dropdown_wrap {
            border: 1px solid #A9BDD0;
            padding: 10px 10px;
        }

        .options_dropdown_wrap input {
            font-size: 14px;
        }

        .calculator #invest_val {
            font-size: 14px;
            height: 42px;
            padding-right: 130px;
        }

        .calculator .currency {
            font-size: 14px;
        }

        .calculator .currency_select input[type="radio"]+label {
            font-size: 14px;
            padding: 5px 14px;
        }

        .calculator .currency_select {
            top: 1px;
            right: 1px;
        }

        .calculator .field_col .flatpickr-input {
            font-size: 14px;
            padding-left: 10px;
        }

        .calc_result_col {
            margin-top: 36px;
        }

        .result_inner_col {
            padding: 30px 20px;
        }

        .calculator .list p {
            font-size: 14px;
        }

        .calculator .list h4 {
            font-size: 18px;
        }

        .calculator .invested_val.list {
            padding-bottom: 12px;
            padding-left: 0;
        }

        .calculator .est_return.list {
            margin-top: 12px;
            padding-bottom: 12px;
            padding-left: 0;
        }

        .calculator .total_val.list {
            margin-top: 12px;
            padding-bottom: 12px;
        }

        .calculator .cagr_val.list {
            margin-top: 12px;
            padding-left: 0;
        }

        .calculator .cagr_val.list h4,
        .calculator .total_val.list h4 {
            font-size: 18px;
        }

        .calculator .investment_cta {
            margin: 0;
            padding: 16px;
        }

        .calculator .cta_content_col {
            width: 100%;
        }

        .calculator .cta_content_col p {
            font-size: 14px;
        }

        .calculator .sub_heading {
            font-size: 14px !important;
            text-align: left;
        }
    }

    @keyframes loaderamin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?php
$chart = isset($GLOBALS['chart']) ? $GLOBALS['chart'] : 'false';
$stock_data = isset($GLOBALS['stock_data']) ? $GLOBALS['stock_data'] : 'default_data';
$currentDate = date('Y-m');
$startMonthDefaultValue = '2010-01';
$endMonthDefaultValue = date('Y-m', strtotime($currentDate));
?>

<section class="calculator">
    <div class="main_calc_wrap">
        <div class="calc_col">
            <div class="calc_form_wrap">
                <form action="" class="calc_form" id="chart_form">
                    <div class="field_group">
                        <label for="stockSelector">Select any US Stock or ETF</label>
                        <div class="select_box_new">
                            <div class="selected_option" data-value="QQQ" id="resultsList">
                                <input type="text" class="dropdown_search"
                                    placeholder="Type any US stock or ETF" value="Invesco QQQ Trust Series 1">
                            </div>
                            <div class="options_dropdown_wrap">
                                <div id="loader" style="display: none;">
                                    <svg width="32px" height="32px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                            stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="dropdown_options">
                                    <ul class="static_options">
                                        <li data-value="SPY">INVESCO NASDAQ 100 ETF</li>
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
                            <input type="text" id="invest_val" value="1,000" maxlength="10" />

                            <div class="currency_select">
                                <div>
                                    <input type="radio" name="currency" id="usd_currency" value="usd" checked>
                                    <label for="usd_currency">USD</label>
                                </div>
                                <div>
                                    <input type="radio" name="currency" id="inr_currency" value="inr">
                                    <label for="inr_currency">INR</label>
                                </div>
                            </div>
                        </div>
                        <div class="field_note">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21"
                                fill="none">
                                <path
                                    d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18Z"
                                    stroke="#002852" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M10.5 13.5V10.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M10.5 7.5H10.5075" stroke="#002852" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Select INR to view returns adjusted for INR to USD conversion. FX rates use Google’s published USD/INR price.</span>
                        </div>
                    </div>
                    <div class="field_group">
                        <div class="field_row">
                            <div class="field_col">
                                <label for="startMonth">Start Month</label>
                                <input type="text" id="startMonth"
                                    data-value="<?php echo $startMonthDefaultValue; ?>" />
                            </div>
                            <div class="field_col">
                                <label for="endMonth">End Month</label>
                                <input type="text" class="flatpickr-input" id="endMonth"
                                    data-value="<?php echo $endMonthDefaultValue; ?>" />
                            </div>
                        </div>
                    </div>


                    <div class="submit_btn">
                        <button type="submit" class="US_Stock_return_calculator">
                            <svg width="32px" height="32px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                fill="#ffffff" class="loader_svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"></path>
                                    </g>
                                </g>
                            </svg>
                            <span>Calculate</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
        <div class="calc_result_col blur">
            <div class="result_inner_col">
                <h3 id="returnBreakdownTitle">Return Breakdown of Invesco QQQ Trust Series 1</h3>
                <div class="result_breakdown_wrap">
                    <div class="result_graph_col">
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
                                <p>Total Return</p>
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
                    <p>
                        If you had invested
                        <span class="calc_currency">$</span>
                        <span id="content_invest_amt">0</span> in
                        <span id="start_month">January 2021</span>,
                        it would be worth
                        <strong>
                            <span class="calc_currency">$</span>
                            <span id="content_total_value">0</span>
                        </strong> by
                        <span id="end_month">August 2023</span> with
                        <strong><span id="content_cagr">0</span>% CAGR</strong>
                    </p>
                </div>
                <div class="cta_btn">
                    <a href="https://app.vestedfinance.com/signup" target="_blank">
                        <span>Start Investing</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                            fill="none">
                            <path d="M1 18.5L7 12.5L0.999999 6.5" stroke="#0CC886" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
    function parseDate(dateStr) {
        const [monthName, year] = dateStr.split(' ');
        const monthIndex = new Date(Date.parse(`${monthName} 1, 2020`)).getMonth();
        return new Date(parseInt(year, 10), monthIndex, 1);
    }
    function formatDateToISOString(date, offset = 0) {
        const adjustedDate = new Date(date);
        adjustedDate.setMonth(date.getMonth() + offset);
        return adjustedDate.toISOString().slice(0, 7);
    }
    function updateTextContent(selector, text) {
        document.querySelector(selector).textContent = text;
    }
    function initializeFlatpickr(selector, options) {
        return flatpickr(selector, options);
    }
    function handleStartDateChange(selectedDates, dateStr) {
        const startDate = parseDate(dateStr);
        const nextMonth = formatDateToISOString(startDate, 1);
        const twoMonthsAhead = formatDateToISOString(startDate, 2);
        document.getElementById('startMonth').setAttribute('data-value', nextMonth);
        updateTextContent('#start_month', dateStr);
        initializeEndDatePicker(twoMonthsAhead);
    }
    function handleEndDateChange(selectedDates, dateStr) {
        try {
            const endDate = parseDate(dateStr);
            const formattedDate = `${endDate.getFullYear()}-${(endDate.getMonth() + 1).toString().padStart(2, '0')}`;
            const endMonthElement = document.getElementById('endMonth');
            if (endMonthElement) endMonthElement.setAttribute('data-value', formattedDate);
            const endMonthTextElement = document.querySelector('#end_month');
            if (endMonthTextElement) updateTextContent('#end_month', dateStr);
        } catch (error) {
            console.error('Error in handleEndDateChange:', error);
        }
    }
    function initializeStartDatePicker() {
        initializeFlatpickr("#startMonth", {
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "F Y",
                })
            ],
            defaultDate: "January 2010",
            maxDate: "today",
            disableMobile: "true",
            onReady: handleStartDateChange,
            onClose: handleStartDateChange,
        });
    }
    function initializeEndDatePicker(minDate) {
        initializeFlatpickr("#endMonth", {
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "F Y",
                })
            ],
            defaultDate: "February 2024",
            minDate: minDate,
            maxDate: "today",
            disableMobile: "true",
            onReady: handleEndDateChange,
            onClose: handleEndDateChange,
        });
    }
    initializeStartDatePicker();

    function addEvent(selector, event, handler) {
        document.querySelectorAll(selector).forEach(element => {
            element.addEventListener(event, handler);
        });
    }
    function getCurrencySymbol(currency) {
        return currency === "inr" ? "₹" : "$";
    }
    function updateCurrencySymbols(currency) {
        const currencySymbol = getCurrencySymbol(currency);
        document.querySelectorAll('.currency, .calc_currency').forEach(element => {
            element.textContent = currencySymbol;
        });
    }
    function calculateDateRange(startDate, endDate) {
        const differenceInMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12 + endDate.getMonth() - startDate.getMonth();

        if (differenceInMonths < 6) return "week";
        if (differenceInMonths >= 12 && differenceInMonths <= 36) return "month";
        if (differenceInMonths > 36) return "year";
        return "month";
    }
    function updateButtonStatus() {
        const startDate = document.getElementById('startMonth').getAttribute('data-value');
        const endDate = document.getElementById('endMonth').getAttribute('data-value');
        const button = document.querySelector('.submit_btn button');
        button.classList.toggle('btn-disabled', !startDate || !endDate);
        document.querySelector('.calc_result_col').classList.add('blur');
    }
    function triggerAndRender(stockSelector, startDate, endDate, stockName, showNifty, currencySymbol, dateRange) {
        triggerAPI(stockSelector, startDate, endDate)
            .then(data => {
                // Chart rendering removed
            })
            .catch(error => console.log("Something went wrong!", error));
    }
    document.getElementById('chart_form').addEventListener('submit', function (event) {
        event.preventDefault();
        const stockSelector = document.getElementById('resultsList').dataset.value;
        const stockName = document.querySelector('.dropdown_search').value;
        const currency = document.querySelector('input[name="currency"]:checked').value;
        const startDate = document.getElementById('startMonth').getAttribute('data-value');
        const endDate = document.getElementById('endMonth').getAttribute('data-value');
        const startDateObj = new Date(startDate);
        const endDateObj = new Date(endDate);
        const dateRange = calculateDateRange(startDateObj, endDateObj);
        triggerAndRender(stockSelector, startDate, endDate, stockName, currency !== "inr", getCurrencySymbol(currency), dateRange);
    });
    addEvent('.currency_select input[type="radio"]', 'change', function () {
        const selectedCurrency = document.querySelector('input[name="currency"]:checked').value;
        document.querySelector('.calc_result_col').classList.add('blur');
        updateCurrencySymbols(selectedCurrency);
    });
    document.addEventListener('DOMContentLoaded', function () {
        addEvent('.currency_select input[type="radio"]', 'change', function () {
            const selectedCurrency = document.querySelector('input[name="currency"]:checked').value;
            document.querySelector('.calc_result_col').classList.add('blur');
            updateCurrencySymbols(selectedCurrency);
        });
        setTimeout(() => {
            const stockSelector = document.getElementById('resultsList').dataset.value;
            const startDate = document.getElementById('startMonth').getAttribute('data-value');
            const endDate = document.getElementById('endMonth').getAttribute('data-value');

            triggerAndRender(stockSelector, startDate, endDate, "Invesco QQQ Trust Series 1", true, "$", "month");
        }, 500);
    });
    addEvent('#startMonth, #endMonth', 'input', updateButtonStatus);
    const bar = new ProgressBar.Circle(fd_results, {
        strokeWidth: 11,
        easing: "easeInOut",
        duration: 1400,
        color: "#002852",
        trailColor: "#B3D2F1",
        trailWidth: 7,
        svgStyle: null
    });
    bar.animate(0);
    function generateRandomValues(count, min, max) {
        return Array.from({ length: count }, () => Math.floor(Math.random() * (max - min + 1)) + min);
    }
    function triggerAPI(stockSelector, startDate, endDate) {
        const svgElement = document.querySelector('.calculator .submit_btn button svg');
        svgElement.classList.add('show_loader');
        
        // Format dates for API - convert YYYY-MM to YYYY-MM-DD (first day of start month, last day of end month)
        let formattedStartDate = startDate ? startDate : '2010-01';
        let formattedEndDate = endDate ? endDate : new Date().toISOString().slice(0, 7);
        
        // If dates are in YYYY-MM format, convert to full dates
        if (formattedStartDate.match(/^\d{4}-\d{2}$/)) {
            formattedStartDate = formattedStartDate + '-01'; // First day of month
        }
        if (formattedEndDate.match(/^\d{4}-\d{2}$/)) {
            // Get last day of the month
            const endDateObj = new Date(formattedEndDate + '-01');
            endDateObj.setMonth(endDateObj.getMonth() + 1);
            endDateObj.setDate(0); // Last day of the month
            const year = endDateObj.getFullYear();
            const month = String(endDateObj.getMonth() + 1).padStart(2, '0');
            const day = String(endDateObj.getDate()).padStart(2, '0');
            formattedEndDate = `${year}-${month}-${day}`;
        }
        
        const apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/${stockSelector}/ohlcv?interval=daily&startDate=${formattedStartDate}&endDate=${formattedEndDate}`;
        const USDINRApi = `https://vested-woodpecker-prod.vestedfinance.com/instrument/USDINR.FOREX/ohlcv?interval=daily&startDate=${formattedStartDate}&endDate=${formattedEndDate}`;
        
        const fetchStockData = fetch(apiUrl).then(response => {
            if (!response.ok) {
                throw new Error(`Stock API error: ${response.status}`);
            }
            return response.json();
        });
        
        // Make USDINR optional - if it fails, we can still calculate USD results
        const fetchUSDINRData = fetch(USDINRApi)
            .then(response => {
                if (!response.ok) {
                    console.warn('USDINR API failed, INR calculations will not be available');
                    return null;
                }
                return response.json();
            })
            .catch(error => {
                console.warn('USDINR API error:', error);
                return null;
            });

        return Promise.all([fetchStockData, fetchUSDINRData])
            .then(([stockData, usdinrData]) => {
                // Validate API response data
                if (!stockData || !stockData.data || stockData.data.length === 0) {
                    throw new Error('Stock data is empty or invalid');
                }
                
                // USDINR is optional - only validate if we got data
                if (usdinrData && (!usdinrData.data || usdinrData.data.length === 0)) {
                    console.warn('USDINR data is invalid, INR calculations disabled');
                    usdinrData = null;
                }
                const selectedCurrency = document.querySelector('input[name="currency"]:checked');
                const startPrice = stockData.data[0].Adj_Close;
                const endPrice = stockData.data[stockData.data.length - 1].Adj_Close;
                const firstDate = new Date(stockData.data[0].Date);
                const lastDate = new Date(stockData.data[stockData.data.length - 1].Date);
                const stockSelector = document.getElementById('resultsList').dataset.value;
                const investmentAmountString = document.getElementById('invest_val').value;
                const investmentAmount = parseFloat(investmentAmountString.replace(/[^0-9.]/g, ''));
                const startStockQty = parseFloat(investmentAmount / startPrice);
                const finalInvestmentAmount = investmentAmount.toLocaleString();
                const currency = document.querySelector('input[name="currency"]:checked').value;
                const stockQty = parseFloat(investmentAmount / startPrice);
                const lastPortfolioValue = parseFloat(endPrice * stockQty);
                const estReturns = parseFloat(lastPortfolioValue - investmentAmount);
                const totalValue = parseFloat(Number(investmentAmount) + Number(estReturns));
                const differenceInMilliseconds = lastDate - firstDate;
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                const differenceInYears = parseFloat(differenceInDays / 365.25).toFixed(2);
                const CAGR = ((Math.pow(totalValue / investmentAmount, 1 / differenceInYears) - 1) * 100).toFixed(2);
                Per = parseFloat(lastPortfolioValue / investmentAmount).toFixed(2);
                const percentageEstimatedReturn = (estReturns / totalValue).toFixed(2);
                
                // Calculate INR values only if USDINR data is available
                let inrEstReturns = 0;
                let inrTotalValue = investmentAmount;
                let inrCAGR = 0;
                let inrPercentageEstimatedReturn = 0;
                
                if (usdinrData && usdinrData.data && usdinrData.data.length > 0) {
                    const inrStartPrice = usdinrData.data[0].Adj_Close;
                    const inrEndPrice = usdinrData.data[usdinrData.data.length - 1].Adj_Close;
                    const inrStartStockQty = investmentAmount / (startPrice * inrStartPrice);
                    const inrLastPortfolioValue = parseFloat(inrStartStockQty * endPrice * inrEndPrice).toFixed(2);
                    inrEstReturns = parseFloat(inrLastPortfolioValue - investmentAmount);
                    inrTotalValue = parseFloat(Number(investmentAmount) + Number(inrEstReturns));
                    inrCAGR = ((Math.pow(inrTotalValue / investmentAmount, 1 / differenceInYears) - 1) * 100).toFixed(2);
                    inrPercentageEstimatedReturn = (inrEstReturns / inrTotalValue).toFixed(2);
                }
                
                svgElement.classList.remove('show_loader');

                const targetCurrency = selectedCurrency.value === "inr" ? "inr" : "usd";
                let isINR = targetCurrency === "inr";
                
                // If INR is selected but USDINR data is not available, fall back to USD
                if (isINR && !usdinrData) {
                    console.warn('INR selected but USDINR data unavailable, showing USD results');
                    isINR = false; // Fall back to USD
                }
                const values = {
                    returns: Math.round(isINR ? inrEstReturns : estReturns).toLocaleString(),
                    total: Math.round(isINR ? inrTotalValue : totalValue).toLocaleString(),
                    cagr: (isINR ? inrCAGR : CAGR).toLocaleString(),
                    investment: finalInvestmentAmount,
                };
                document.getElementById('est_returns').textContent = values.returns;
                document.getElementById('total_value').textContent = values.total;
                document.getElementById('content_total_value').textContent = values.total;
                document.getElementById('cagr').textContent = values.cagr;
                document.getElementById('content_cagr').textContent = values.cagr;
                document.getElementById('invest_amt').textContent = values.investment;
                document.getElementById('total_calc_val').textContent = values.total;
                document.getElementById('content_invest_amt').textContent = values.investment;
                document.querySelector('.calc_result_col').classList.remove('blur');
                const percentageToAnimate = isINR ? inrPercentageEstimatedReturn : percentageEstimatedReturn;
                bar.animate(Math.max(percentageToAnimate, 0));
                return {};
            })
            .catch(error => {
                console.error("API Error:", error);
                svgElement.classList.remove('show_loader');
                // Remove blur even on error so user can see the form
                document.querySelector('.calc_result_col').classList.remove('blur');
                alert('Unable to fetch data. Please check your internet connection and try again.');
            });
    }
    document.querySelector('.selected_option').addEventListener('click', () => {
        document.querySelector('.select_box_new').classList.add('dropdown_collased');
    });
    document.addEventListener('click', event => {
        const mainDropdown = document.querySelector('.select_box_new');
        const clickedElement = event.target;
        if (clickedElement.tagName === 'LI' && clickedElement.closest('.dropdown_options ul')) {
            const selectedOption = document.querySelector('.selected_option');
            const searchInput = document.querySelector('.dropdown_search');
            const returnTitle = document.getElementById('returnBreakdownTitle');
            selectedOption.dataset.value = clickedElement.dataset.value;
            searchInput.value = clickedElement.textContent;
            returnTitle.textContent = `Return Breakdown of ${clickedElement.textContent}`;
            document.querySelectorAll('.calc_result_col').forEach(el => el.classList.add('blur'));
            mainDropdown.classList.toggle('dropdown_collased');
        }
        if (!mainDropdown.contains(clickedElement)) mainDropdown.classList.remove('dropdown_collased');
    });

    const cachedData = [];
    function fetchDataFromIndexedDB(searchTerm) {
        if (!searchTerm) return;
        const searchLower = searchTerm.toLowerCase();
        const dropdown = document.querySelector('.dropdown_options ul.dynamic_options');
        if (!dropdown) return;
        dropdown.innerHTML = '';
        if (cachedData.length > 0) {
            const filteredData = filterData(cachedData, searchLower);
            updateDropdown(filteredData, dropdown);
        } else {
            const request = indexedDB.open('stocks_list', 2);
            request.onsuccess = event => {
                const db = event.target.result;
                const transaction = db.transaction(['stocks'], 'readonly');
                const store = transaction.objectStore('stocks');
                const cursor = store.openCursor();
                const data = [];
                cursor.onsuccess = e => {
                    const result = e.target.result;
                    if (result) {
                        const { symbol, name } = result.value;
                        data.push({ symbol, name });
                        result.continue();
                    } else {
                        cachedData.push(...data);
                        const filteredData = filterData(data, searchLower);
                        updateDropdown(filteredData, dropdown);
                    }
                };
                cursor.onerror = () => {
                    console.error('Error accessing cursor in IndexedDB.');
                };
            };
            request.onerror = () => {
                console.error('Failed to open IndexedDB.');
            };
        }
    }

    function filterData(data, searchTerm) {
        return data.filter(({ name }) => name.toLowerCase().startsWith(searchTerm));
    }

    function updateDropdown(data, dropdown) {
        if (data.length === 0) {
            dropdown.innerHTML = '<p>No Result Found!</p>';
            return;
        }
        const fragment = document.createDocumentFragment();
        data.forEach(({ symbol, name }) => {
            const li = document.createElement('li');
            li.textContent = name;
            li.dataset.value = symbol;
            fragment.appendChild(li);
        });
        dropdown.appendChild(fragment);
    }

    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }
    function handleInputChange() {
        const inputValue = document.querySelector('.dropdown_search').value.trim();
        const staticOptions = document.querySelector('.static_options');
        const dynamicOptions = document.querySelector('.dynamic_options');

        if (inputValue.length >= 1) {
            staticOptions.style.display = 'none';
            dynamicOptions.style.display = 'block';
            fetchDataFromIndexedDB(inputValue);
        } else {
            staticOptions.style.display = 'block';
            dynamicOptions.style.display = 'none';
        }
    }

    function toggleLoader(show) {
        document.getElementById('loader').style.display = show ? 'block' : 'none';
        document.querySelector('.static_options').style.display = show ? 'none' : 'block';
        document.querySelector('.dynamic_options').style.display = show ? 'none' : 'block';
    }
    async function fetchResults(stockName) {
        try {
            toggleLoader(true);
            const results = await connection.select({
                from: 'stocks',
                order: { by: 'symbol', type: 'asc' },
                where: {
                    symbol: { like: `${stockName}%` },
                    or: { name: { like: `${stockName}%` } },
                },
            });
            renderResults(results);
        } catch (err) {
            console.error('Error fetching results:', err);
        } finally {
            toggleLoader(false);
        }
    }
    function renderResults(results) {
        const dropdown = document.querySelector('.dropdown_options ul.dynamic_options');
        dropdown.innerHTML = '';

        if (results.length > 0) {
            const fragment = document.createDocumentFragment();
            results.forEach(({ name, symbol }) => {
                const li = document.createElement('li');
                li.textContent = name;
                li.dataset.value = symbol;
                fragment.appendChild(li);
            });
            dropdown.appendChild(fragment);
        } else {
            dropdown.innerHTML = '<p>No Result Found!</p>';
        }
    }
    function handleInvestInput() {
        document.querySelectorAll('.calc_result_col').forEach(el => el.classList.add('blur'));
    }
    document.querySelector('.dropdown_search').addEventListener('input', debounce(handleInputChange, 500));
    document.getElementById('invest_val').addEventListener('input', handleInvestInput);
</script>