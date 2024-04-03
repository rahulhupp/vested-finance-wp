<style>
    .stocks_search_container {
        position: relative;
    }

    .ticker_dropdown_options ul {
        margin: 0;
        max-height: 240px;
        overflow: auto;
    }

    .ticker_dropdown_options ul li {
        list-style: none;
        padding: 16px;
        cursor: pointer;
        transition: all .3s;
    }

    .ticker_dropdown_options ul li strong {
        color: #1F2937;
        font-size: 16px;
        font-weight: 500;
        line-height: 24px;
        display: block;
        pointer-events: none;
    }

    .ticker_dropdown_options ul li span {
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

    .ticker_dropdown_collased .options_dropdown_wrap {
        display: block;
    }

    .ticker_dropdown_collased .ticker_selected_option {
        border-radius: 6px 6px 0px 0px;
    }

    .options_dropdown_wrap input {
        width: 100%;
        border: 1px solid #002852;
        background: none;
        border-radius: 6px;
    }

    .ticker_dropdown_options ul li:hover {
        background: #F2F4F6;
    }

    .ticker_selected_option {
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

    .ticker_selected_option .ticker_dropdown_search {
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

    .ticker_selected_option img {
        position: absolute;
        left: 12px;
        top: 17px;
        z-index: 1;
    }

    .ticker_selected_option .ticker_dropdown_search:focus, .ticker_selected_option .ticker_dropdown_search:active, .ticker_selected_option .ticker_dropdown_search:focus-within, .ticker_selected_option .ticker_dropdown_search:focus-visible {
        border: none;
        outline: none;
        box-shadow: none;
    }

    .options_dropdown_wrap input:focus,
    .options_dropdown_wrap input:focus-visible {
        border: 1px solid #002852;
        outline: none;
    }

    .ticker_dropdown_options ul p {
        margin: 0;
    }
</style>
<div class="ticker_select_box_new">
    <div class="ticker_selected_option" data-value="" id="tickerResultsLists">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/search-icon.svg" />
        <input type="text" class="ticker_dropdown_search" oninput="tickerInputChangeCalc()" placeholder="Search any stock or ETF" value="">
    </div>
    <div class="options_dropdown_wrap">
        <div id="ticker_loader" style="display: none;">
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
        <div class="ticker_dropdown_options">
            <ul class="ticker_static_options">
            <li data-value="AAPL">
                    <strong>Apple, Inc</strong>
                    <span>AAPL</span>
                </li>
                <li data-value="GOOGL">
                    <strong>Alphabet Inc. - Class A Shares</strong>
                    <span>GOOGL</span>
                </li>
                <li data-value="MSFT">
                    <strong>Microsoft Corporation</strong>
                    <span>MSFT</span>
                </li>
                <li data-value="META">
                    <strong>Meta Platforms Inc</strong>
                    <span>META</span>
                </li>
                <li data-value="NFLX">
                    <strong>Netflix, Inc.</strong>
                    <span>NFLX</span>
                </li>
                <li data-value="AMZN">
                    <strong>Amazon.com Inc.</strong>
                    <span>AMZN</span>
                </li>
                <li data-value="SPOT">
                    <strong>Spotify Technology SA</strong>
                    <span>SPOT</span>
                </li>
            </ul>
            <ul class="ticker_dynamic_options"></ul>
        </div>
    </div>
</div>

<script>

    function tickerInputChangeCalc() {
        var inputValue = document.querySelector(".ticker_dropdown_search").value;
        console.log('inputValue', inputValue);
        tickerMakeAPICallCalc(inputValue);
    }
    function tickerMakeAPICallCalc(inputValue) {
        var staticOptions = document.querySelector(".ticker_static_options");
        var dynamicOptions = document.querySelector(".ticker_dynamic_options");
        if (inputValue.length >= 1) {
            staticOptions.style.display = "none";
            dynamicOptions.style.display = "block";
            tickerFetchResultCalction(inputValue);
        } else {
            staticOptions.style.display = "block";
            dynamicOptions.style.display = "none";
        }
    }
    
    function tickerFetchResultCalction(stock_name) {
        <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'stocks_list';
            $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        ?>
        var dbStocksList = <?php echo json_encode($results); ?>;
        // console.log('dbStocksList', dbStocksList);

        var filteredStocks = dbStocksList.filter(function(stock) {
            return stock.symbol.toLowerCase().startsWith(stock_name.toLowerCase()) || 
                stock.name.toLowerCase().startsWith(stock_name.toLowerCase());
        });

        console.log('filteredStocks', filteredStocks);
        tickerRenderItemsCalc(filteredStocks);
    }

    function tickerShowLoader() {
        document.getElementById('ticker_loader').style.display = 'block';
        document.querySelector(".ticker_static_options").style.display = 'none';
        document.querySelector(".ticker_dynamic_options").style.display = 'none';
    }

    // Add this function to hide the loader
    function tickerHideLoader() {
        document.getElementById('ticker_loader').style.display = 'none';
        document.querySelector(".ticker_static_options").style.display = 'none';
        document.querySelector(".ticker_dynamic_options").style.display = 'block';
    }

    function tickerRenderItemsCalc(results) {
        const dropdownOptions = document.querySelector('.ticker_dropdown_options ul.ticker_dynamic_options');
        dropdownOptions.innerHTML = '';

        if (results.length > 0) {
            results.forEach(result => {
                const listItem = document.createElement("li");
                listItem.innerHTML = `<strong>${result.name}</strong><span>${result.symbol}</span>`;
                listItem.dataset.value = result.symbol;
                dropdownOptions.appendChild(listItem);
            });
        } else {
            // If there are no results and no input, display static options
            const inputValue = document.querySelector(".ticker_dropdown_search").value;
            if (inputValue.trim() === "") {
                const staticOptions = document.querySelectorAll('.ticker_static_options');
                staticOptions.forEach(staticOption => {
                    const listItem = document.createElement("li");
                    listItem.innerHTML = `<strong>${result.name}</strong><span>${result.symbol}</span>`;
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

    document.querySelector('.ticker_selected_option').addEventListener("click", function() {
        const mainDropdown = document.querySelector('.ticker_select_box_new');
        mainDropdown.classList.add("ticker_dropdown_collased");
    });


    document.addEventListener('click', function(event) {
        const clickedElement = event.target;
        const mainDropdown = document.querySelector('.ticker_select_box_new');
        if (clickedElement.tagName === 'LI' && clickedElement.closest('.ticker_dropdown_options ul')) {

            const mainValue = document.querySelector('.ticker_selected_option');
            const searchValue = document.querySelector('.ticker_dropdown_search');

            const selectedValue = clickedElement.dataset.value;
            var selectedText = clickedElement.querySelector('strong').innerText;

            var tickerModalName = document.getElementById('at_stock_search');
            var returnData = tickerModalName.dataset.value;
            console.log('tickerModalName.dataset.value', tickerModalName.dataset.value);
            console.log('selectedValue', selectedValue);
            if (returnData === 'ratios_compare') {
                callRatiosCompareApi(selectedValue);
            } else {
                callReturnsCompareApi(returnData, selectedValue);
            }
            
            var modal = document.getElementById('at_modal');
            modal.style.display = 'none';


            searchValue.value = selectedText;
            mainValue.dataset.value = selectedValue;

            if (mainDropdown.classList.contains("ticker_dropdown_collased")) {
                mainDropdown.classList.remove("ticker_dropdown_collased");
            } else {
                mainDropdown.classList.add("ticker_dropdown_collased");
            }
        }

        if (!mainDropdown.contains(clickedElement)) {
            mainDropdown.classList.remove("ticker_dropdown_collased");
        }
    });

</script>