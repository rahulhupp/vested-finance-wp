<div id="returns_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Returns</h2>
        <div class="separator_line"></div>
        <div class="stock_box_tab_container">
            <button class="stock_box_tab_button active" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab1', this)">Absolute returns</button>
            <button class="stock_box_tab_button" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab2', this)">Annualized returns</button>
        </div>
        <div id="returns_tab_tab1" class="stock_box_tab_content">
            <div class="stock_details_table_container">
                <div class="stock_details_table_wrapper">
                    <div id="absolute_returns_table" class="stock_details_table"></div>
                    <button class="stock_details_table_button" onclick="openModalAddTicker('absolute_returns')">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" />
                        <span>Add ticker to compare</span>
                    </button>
                </div>
            </div>
        </div>
        <div id="returns_tab_tab2" class="stock_box_tab_content hidden">
            <div class="stock_details_table_container">
                <div class="stock_details_table_wrapper">
                    <div id="annualized_returns_table" class="stock_details_table"></div>
                    <button class="stock_details_table_button" onclick="openModalAddTicker('annualized_returns')">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" />
                        <span>Add ticker to compare</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>