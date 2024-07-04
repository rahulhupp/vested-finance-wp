<style>
    .stocks_search_container {
        position: relative;
    }

    .dropdown_options ul {
        margin: 0;
        max-height: 240px;
        overflow: auto;
    }

    .dropdown_options ul li {
        list-style: none;
        padding: 16px;
        cursor: pointer;
        transition: all .3s;
    }

    .dropdown_options ul li strong {
        color: #1F2937;
        font-size: 16px;
        font-weight: 500;
        line-height: 24px;
        display: block;
        pointer-events: none;
    }

    .dropdown_options ul li span {
        color: #9CA3AF;
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        pointer-events: none;
    }

    .options_dropdown_wrap {
        background: #fff;
        border-radius: 0px 0px 6px 6px;
        border: 1px solid #D1D5DB;
        position: absolute;
        width: 100%;
        z-index: 1;
        display: none;
    }

    .dropdown_collased .options_dropdown_wrap {
        display: block;
    }

    .dropdown_collased .selected_option {
        border-radius: 6px 6px 0px 0px;
    }

    .options_dropdown_wrap input {
        width: 100%;
        border: 1px solid #002852;
        background: none;
        border-radius: 6px;
    }

    .dropdown_options ul li:hover {
        background: #F2F4F6;
    }

    .selected_option {
        border-radius: 6px;
        border: 1px solid #D1D5DB;
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
        font-weight: 400;
        line-height: 24px;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        border: none;
        background-color: #fff;
        padding-left: 36px;
    }

    .selected_option img {
        position: absolute;
        left: 12px;
        top: 17px;
        z-index: 1;
    }

    .selected_option .dropdown_search:focus, .selected_option .dropdown_search:active, .selected_option .dropdown_search:focus-within, .selected_option .dropdown_search:focus-visible {
        border: none;
        outline: none;
        box-shadow: none;
    }

    .options_dropdown_wrap input:focus,
    .options_dropdown_wrap input:focus-visible {
        border: 1px solid #002852;
        outline: none;
    }

    .dropdown_options ul p {
        margin: 0;
    }
</style>
<div class="select_box_new">
    <div class="selected_option" data-value="" data-type="" id="resultsList">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/search-icon.svg" />
        <input type="text" class="dropdown_search" placeholder="Search any bond name or ISIN" value="">
    </div>
    <div class="options_dropdown_wrap">
        <div id="loader" style="display: none;">
            <svg width="32px" height="32px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"></path>
                    </g>
                </g>
            </svg>
        </div>
        <div class="dropdown_options">
            <ul class="options_result">
            <li data-value="AAPL" data-type="stock"> <strong>Apple, Inc</strong> <span>AAPL</span> </li>
            </ul>
        </div>
    </div>
</div>