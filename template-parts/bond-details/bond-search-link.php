<style>
    .bonds_search_container {
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
<div class="bonds_search_container">
<div class="select_box_new">
    <div class="selected_option" data-value="" id="resultsList">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/search-icon.svg" />
        <input type="text" class="dropdown_search" oninput="inputChangeCalc()" placeholder="Search any bond name or ISIN" value="">
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
            <ul class="dynamic_options"></ul>
        </div>
    </div>
</div>
</div>



<script>
    var debounceTimer;

    function inputChangeCalc() {
        var inputValue = document.querySelector(".dropdown_search").value;

        // Clear the previous timer
        clearTimeout(debounceTimer);

        // Set a new timer
        debounceTimer = setTimeout(function () {
            makeAPICallCalc(inputValue);
        }, 100);
    }
    function makeAPICallCalc(inputValue) {
        var dynamicOptions = document.querySelector(".dynamic_options");
        if (inputValue.length >= 1) {
            dynamicOptions.style.display = "block";
            fetchResultCalc(inputValue);
        } else {
            dynamicOptions.style.display = "none";
        }
    }

    var debounceTimer;

    function debounce(func, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    function fetchResultCalc(bond_name) {
        debounce(function () {
            <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'bonds_list';
                $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
            ?>
            var dbStocksList = <?php echo json_encode($results); ?>;

            var filteredStocks = dbStocksList.filter(function (bond) {
                return bond.securityId.toLowerCase().startsWith(bond_name.toLowerCase()) ||
                    bond.displayName.toLowerCase().startsWith(bond_name.toLowerCase());
            });

            renderItemsCalc(filteredStocks);
        }, 300);
    }

    function showLoader() {
        document.getElementById('loader').style.display = 'block';
        document.querySelector(".dynamic_options").style.display = 'none';
    }

    // Add this function to hide the loader
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
        document.querySelector(".dynamic_options").style.display = 'block';
    }

    function renderItemsCalc(results) {
        const dropdownOptions = document.querySelector('.dropdown_options ul.dynamic_options');
        dropdownOptions.innerHTML = '';

        if (results.length > 0) {
            results.forEach(result => {
                const listItem = document.createElement("li");
                const bondType = result.bondCategory.toLowerCase();
                let bondIssuer = result.issuerName.toLowerCase().replace(/[^a-z0-9-]/g, '-');
                bondIssuer = bondIssuer.replace(/-+/g, '-').replace(/^-|-$/g, '');
                listItem.innerHTML = `<strong>${result.displayName}</strong><span>${result.securityId}</span>`;
                listItem.dataset.value = result.securityId;
                listItem.setAttribute('data-bond', bondType);
                listItem.setAttribute('data-issuer', bondIssuer);
                dropdownOptions.appendChild(listItem);
            });
        } else {
            const listItem = document.createElement("p");
            listItem.textContent = "No Result Found!";
            dropdownOptions.appendChild(listItem);
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
            var selectedText = clickedElement.querySelector('strong').innerText;
            var selectedBondType = clickedElement.getAttribute('data-bond');
            var selectedIssuer = clickedElement.getAttribute('data-issuer');
            var finalBondType;
            if(selectedBondType === 'govt') {
                finalBondType = 'government-bonds';
            }
            else {
                finalBondType = 'corporate-bonds';
            }
            var formattedValue = selectedValue.toLowerCase().replace(/\s+/g, '-');

            var redirectToURL = '';
            redirectToURL = `<?php echo home_url(); ?>/in/inr-bonds/${finalBondType}/${selectedIssuer}/${formattedValue}`;
            window.location.href = redirectToURL;
            console.log(selectedIssuer);
            
            searchValue.value = selectedText;
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

</script>