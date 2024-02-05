<div id="financials_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Financials</h2>
        <div class="separator_line"></div>
        <div class="financials_box_header">
            <div class="stock_box_tab_container">
                <button class="stock_box_tab_button active" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab1', this)">Income Statement</button>
                <button class="stock_box_tab_button" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab2', this)">Balance Sheet</button>
                <button class="stock_box_tab_button" onclick="changeStockBoxTab('financials_tab', 'financials_tab_tab3', this)">Cash Flow</button>
            </div>
            <div class="financials_select_container">
                <select id="value_type_select" onchange="updateFinancialSelection('value_type_select')">
                    <option value="change">Growth</option>
                    <option value="number" selected>Absolute</option>
                </select>

                <select id="data_type_select" onchange="updateFinancialSelection('data_type_select')">
                    <option value="quarter">Quarterly</option>
                    <option value="annual" selected>Annual</option>
                </select>
            </div>
        </div>
        <div id="financials_tab_tab1" class="stock_box_tab_content">
            <div class="stock_details_table_container">
                <div class="stock_details_table_wrapper">
                    <div id="income_statement_table"class="stock_details_table financial_table"></div>
                </div>
            </div>
        </div>
        <div id="financials_tab_tab2" class="stock_box_tab_content hidden">
            <div class="stock_details_table_container">
                <div class="stock_details_table_wrapper">
                    <div id="balance_sheet_table"class="stock_details_table financial_table"></div>
                </div>
            </div>
        </div>
        <div id="financials_tab_tab3" class="stock_box_tab_content hidden">
            <div class="stock_details_table_container">
                <div class="stock_details_table_wrapper">
                    <div id="cash_flow_table"class="stock_details_table financial_table"></div>
                </div>
            </div>
        </div>
    </div>
</div>