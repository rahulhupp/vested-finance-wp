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
        <input type="text" class="dropdown_search" oninput="inputChangeCalc()" placeholder="Search any stock or ETF" value="">
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
            <ul class="static_options">
                <li data-value="AAPL" data-type="stock">
                    <strong>Apple, Inc</strong>
                    <span>AAPL</span>
                </li>
                <li data-value="SPY" data-type="etf">
                    <strong>S&amp;P 500 ETF Trust SPDR</strong>
                    <span>SPY</span>
                </li>
                <li data-value="GOOGL" data-type="stock">
                    <strong>Alphabet Inc. - Class A Shares</strong>
                    <span>GOOGL</span>
                </li>
                <li data-value="MSFT" data-type="stock">
                    <strong>Microsoft Corporation</strong>
                    <span>MSFT</span>
                </li>
                <li data-value="META" data-type="stock">
                    <strong>Meta Platforms Inc</strong>
                    <span>META</span>
                </li>
                <li data-value="NFLX" data-type="stock">
                    <strong>Netflix, Inc.</strong>
                    <span>NFLX</span>
                </li>
                <li data-value="AMZN" data-type="stock">
                    <strong>Amazon.com Inc.</strong>
                    <span>AMZN</span>
                </li>
                <li data-value="SPOT" data-type="stock">
                    <strong>Spotify Technology SA</strong>
                    <span>SPOT</span>
                </li>
            </ul>
            <ul class="dynamic_options"></ul>
        </div>
    </div>
</div>




<script>

    function inputChangeCalc() {
        var inputValue = document.querySelector(".dropdown_search").value;
        console.log('1 inputValue', inputValue);
        makeAPICallCalc(inputValue);
    }

    function makeAPICallCalc(inputValue) {
        console.log('makeAPICallCalc', inputValue);
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

    async function fetchResultCalc(stock_name) {
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
        renderItemsCalc(filteredStocks);
    }

    function showLoader() {
        document.getElementById('loader').style.display = 'block';
        document.querySelector(".static_options").style.display = 'none';
        document.querySelector(".dynamic_options").style.display = 'none';
    }

    // Add this function to hide the loader
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
        document.querySelector(".static_options").style.display = 'none';
        document.querySelector(".dynamic_options").style.display = 'block';
    }

    function renderItemsCalc(results) {
        const dropdownOptions = document.querySelector('.dropdown_options ul.dynamic_options');
        dropdownOptions.innerHTML = '';

        if (results.length > 0) {
            results.forEach(result => {
                const listItem = document.createElement("li");
                listItem.innerHTML = `<strong>${result.name}</strong><span>${result.symbol}</span>`;
                listItem.dataset.value = result.symbol;
                listItem.dataset.type = result.type;
                dropdownOptions.appendChild(listItem);
            });
        } else {
            // If there are no results and no input, display static options
            const inputValue = document.querySelector(".dropdown_search").value;
            if (inputValue.trim() === "") {
                const staticOptions = document.querySelectorAll('.static_options');
                staticOptions.forEach(staticOption => {
                    const listItem = document.createElement("li");
                    listItem.innerHTML = `<strong>${result.name}</strong><span>${result.symbol}</span>`;
                    listItem.dataset.value = staticOption.dataset.value;
                    listItem.dataset.type = staticOption.dataset.type;
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

    document.querySelector('.selected_option').addEventListener("click", function() {
        const mainDropdown = document.querySelector('.select_box_new');
        mainDropdown.classList.add("dropdown_collased");
    });


    document.addEventListener('click', function(event) {
        const clickedElement = event.target;
        const mainDropdown = document.querySelector('.select_box_new');
        if (clickedElement.tagName === 'LI' && clickedElement.closest('.dropdown_options ul')) {

            const mainValue = document.querySelector('.selected_option');
            const searchValue = document.querySelector('.dropdown_search');

            const selectedValue = clickedElement.dataset.value;
            const selectedType = clickedElement.dataset.type;
            var selectedText = clickedElement.querySelector('strong').innerText;
            console.log('2 selectedType', selectedType);
            // var formattedText = selectedText.trim().toLowerCase().replace(/\s+/g, '-').replace(/\.$/, '');
            // var formattedText = selectedText.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            var formattedText = selectedText.toLowerCase()
                                            .replace(/ /g, '-')
                                            .replace(/,/g, '-')
                                            .replace(/[^a-zA-Z0-9\-]/g, '')
                                            .replace(/-+/g, '-')
                                            .replace(/^-+|-+$/g, '');
            var formattedValue = selectedValue.toLowerCase().replace(/\s+/g, '-');

            var redirectToURL = '';
            if (selectedType === "etf") {
                redirectToURL = `<?php echo home_url(); ?>/us-stocks/etf/${formattedValue}/${formattedText}-share-price`;
            } else {
                redirectToURL = `<?php echo home_url(); ?>/us-stocks/${formattedValue}/${formattedText}-share-price`;
            }
            console.log('redirectToURL', redirectToURL);
            window.location.href = redirectToURL;
            
            searchValue.value = selectedText;
            mainValue.dataset.value = selectedValue;
            mainValue.dataset.type = selectedType;

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

</script>