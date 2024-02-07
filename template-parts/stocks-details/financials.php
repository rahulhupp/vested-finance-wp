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
            <div class="stock_details_table_container" id="financials_skeleton_after">
                <div class="stock_details_table_wrapper">
                    <div id="income_statement_table"class="stock_details_table financial_table"></div>
                </div>
            </div>
            <div class="svg_skeleton" id="financials_skeleton">
                <svg width="728" height="806" viewBox="0 0 728 806" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_8_380)">
                        <path
                            d="M720 2H8C4.68629 2 2 4.68629 2 8V798C2 801.314 4.68629 804 8 804H720C723.314 804 726 801.314 726 798V8C726 4.68629 723.314 2 720 2Z"
                            fill="white" />
                        <path
                            d="M720 2H8C4.68629 2 2 4.68629 2 8V798C2 801.314 4.68629 804 8 804H720C723.314 804 726 801.314 726 798V8C726 4.68629 723.314 2 720 2Z"
                            fill="#002852" fill-opacity="0.08" />
                        <path
                            d="M720 1.5H8C4.41015 1.5 1.5 4.41015 1.5 8V798C1.5 801.59 4.41015 804.5 8 804.5H720C723.59 804.5 726.5 801.59 726.5 798V8C726.5 4.41015 723.59 1.5 720 1.5Z"
                            stroke="#002852" stroke-opacity="0.2" />
                        <g filter="url(#filter0_d_8_380)">
                            <path d="M2 8C2 4.68629 4.68629 2 8 2H299V42H2V8Z" fill="white" />
                            <path d="M2 8C2 4.68629 4.68629 2 8 2H299V42H2V8Z" fill="#002852" fill-opacity="0.08" />
                            <mask id="mask0_8_380" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="299" y="2" width="72"
                                height="40">
                                <path d="M370.167 2H299V42H370.167V2Z" fill="white" />
                            </mask>
                            <g mask="url(#mask0_8_380)">
                                <path d="M370.167 2H299V42H370.167V2Z" fill="white" />
                                <path d="M370.167 2H299V42H370.167V2Z" fill="#002852" fill-opacity="0.08" />
                            </g>
                            <path d="M441.334 2H370.167V42H441.334V2Z" fill="white" />
                            <path d="M441.334 2H370.167V42H441.334V2Z" fill="#002852" fill-opacity="0.08" />
                            <mask id="mask1_8_380" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="441" y="2" width="72"
                                height="40">
                                <path d="M512.5 2H441.333V42H512.5V2Z" fill="white" />
                            </mask>
                            <g mask="url(#mask1_8_380)">
                                <path d="M512.5 2H441.333V42H512.5V2Z" fill="white" />
                                <path d="M512.5 2H441.333V42H512.5V2Z" fill="#002852" fill-opacity="0.08" />
                            </g>
                            <path d="M583.667 2H512.5V42H583.667V2Z" fill="white" />
                            <path d="M583.667 2H512.5V42H583.667V2Z" fill="#002852" fill-opacity="0.08" />
                            <path d="M654.834 2H583.667V42H654.834V2Z" fill="white" />
                            <path d="M654.834 2H583.667V42H654.834V2Z" fill="#002852" fill-opacity="0.08" />
                            <path d="M654.833 2H720C723.314 2 726 4.68629 726 8V42H654.833V2Z" fill="white" />
                            <path d="M654.833 2H720C723.314 2 726 4.68629 726 8V42H654.833V2Z" fill="#002852" fill-opacity="0.08" />
                            <path d="M298.75 42.25H2.25V81.75H298.75V42.25Z" fill="white" />
                            <path d="M298.75 42.25H2.25V81.75H298.75V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 42.25H299.25V81.75H369.917V42.25Z" fill="white" />
                            <path d="M369.917 42.25H299.25V81.75H369.917V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 42.25H370.417V81.75H441.084V42.25Z" fill="white" />
                            <path d="M441.084 42.25H370.417V81.75H441.084V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 42.25H441.583V81.75H512.25V42.25Z" fill="white" />
                            <path d="M512.25 42.25H441.583V81.75H512.25V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 42.25H512.75V81.75H583.417V42.25Z" fill="white" />
                            <path d="M583.417 42.25H512.75V81.75H583.417V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 42.25H583.917V81.75H654.584V42.25Z" fill="white" />
                            <path d="M654.584 42.25H583.917V81.75H654.584V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 42.25H655.083V81.75H725.75V42.25Z" fill="white" />
                            <path d="M725.75 42.25H655.083V81.75H725.75V42.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 82.25H2.25V121.75H298.75V82.25Z" fill="white" />
                            <path d="M298.75 82.25H2.25V121.75H298.75V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 82.25H299.25V121.75H369.917V82.25Z" fill="white" />
                            <path d="M369.917 82.25H299.25V121.75H369.917V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 82.25H370.417V121.75H441.084V82.25Z" fill="white" />
                            <path d="M441.084 82.25H370.417V121.75H441.084V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 82.25H441.583V121.75H512.25V82.25Z" fill="white" />
                            <path d="M512.25 82.25H441.583V121.75H512.25V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 82.25H512.75V121.75H583.417V82.25Z" fill="white" />
                            <path d="M583.417 82.25H512.75V121.75H583.417V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 82.25H583.917V121.75H654.584V82.25Z" fill="white" />
                            <path d="M654.584 82.25H583.917V121.75H654.584V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 82.25H655.083V121.75H725.75V82.25Z" fill="white" />
                            <path d="M725.75 82.25H655.083V121.75H725.75V82.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 122.25H2.25V161.75H298.75V122.25Z" fill="white" />
                            <path d="M298.75 122.25H2.25V161.75H298.75V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 122.25H299.25V161.75H369.917V122.25Z" fill="white" />
                            <path d="M369.917 122.25H299.25V161.75H369.917V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 122.25H370.417V161.75H441.084V122.25Z" fill="white" />
                            <path d="M441.084 122.25H370.417V161.75H441.084V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 122.25H441.583V161.75H512.25V122.25Z" fill="white" />
                            <path d="M512.25 122.25H441.583V161.75H512.25V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 122.25H512.75V161.75H583.417V122.25Z" fill="white" />
                            <path d="M583.417 122.25H512.75V161.75H583.417V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 122.25H583.917V161.75H654.584V122.25Z" fill="white" />
                            <path d="M654.584 122.25H583.917V161.75H654.584V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 122.25H655.083V161.75H725.75V122.25Z" fill="white" />
                            <path d="M725.75 122.25H655.083V161.75H725.75V122.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 162.25H2.25V201.75H298.75V162.25Z" fill="white" />
                            <path d="M298.75 162.25H2.25V201.75H298.75V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 162.25H299.25V201.75H369.917V162.25Z" fill="white" />
                            <path d="M369.917 162.25H299.25V201.75H369.917V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 162.25H370.417V201.75H441.084V162.25Z" fill="white" />
                            <path d="M441.084 162.25H370.417V201.75H441.084V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 162.25H441.583V201.75H512.25V162.25Z" fill="white" />
                            <path d="M512.25 162.25H441.583V201.75H512.25V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 162.25H512.75V201.75H583.417V162.25Z" fill="white" />
                            <path d="M583.417 162.25H512.75V201.75H583.417V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 162.25H583.917V201.75H654.584V162.25Z" fill="white" />
                            <path d="M654.584 162.25H583.917V201.75H654.584V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 162.25H655.083V201.75H725.75V162.25Z" fill="white" />
                            <path d="M725.75 162.25H655.083V201.75H725.75V162.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 202.25H2.25V241.75H298.75V202.25Z" fill="white" />
                            <path d="M298.75 202.25H2.25V241.75H298.75V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 202.25H299.25V241.75H369.917V202.25Z" fill="white" />
                            <path d="M369.917 202.25H299.25V241.75H369.917V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 202.25H370.417V241.75H441.084V202.25Z" fill="white" />
                            <path d="M441.084 202.25H370.417V241.75H441.084V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 202.25H441.583V241.75H512.25V202.25Z" fill="white" />
                            <path d="M512.25 202.25H441.583V241.75H512.25V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 202.25H512.75V241.75H583.417V202.25Z" fill="white" />
                            <path d="M583.417 202.25H512.75V241.75H583.417V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 202.25H583.917V241.75H654.584V202.25Z" fill="white" />
                            <path d="M654.584 202.25H583.917V241.75H654.584V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 202.25H655.083V241.75H725.75V202.25Z" fill="white" />
                            <path d="M725.75 202.25H655.083V241.75H725.75V202.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 242.25H2.25V281.75H298.75V242.25Z" fill="white" />
                            <path d="M298.75 242.25H2.25V281.75H298.75V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 242.25H299.25V281.75H369.917V242.25Z" fill="white" />
                            <path d="M369.917 242.25H299.25V281.75H369.917V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 242.25H370.417V281.75H441.084V242.25Z" fill="white" />
                            <path d="M441.084 242.25H370.417V281.75H441.084V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 242.25H441.583V281.75H512.25V242.25Z" fill="white" />
                            <path d="M512.25 242.25H441.583V281.75H512.25V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 242.25H512.75V281.75H583.417V242.25Z" fill="white" />
                            <path d="M583.417 242.25H512.75V281.75H583.417V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 242.25H583.917V281.75H654.584V242.25Z" fill="white" />
                            <path d="M654.584 242.25H583.917V281.75H654.584V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 242.25H655.083V281.75H725.75V242.25Z" fill="white" />
                            <path d="M725.75 242.25H655.083V281.75H725.75V242.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 282.25H2.25V321.75H298.75V282.25Z" fill="white" />
                            <path d="M298.75 282.25H2.25V321.75H298.75V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 282.25H299.25V321.75H369.917V282.25Z" fill="white" />
                            <path d="M369.917 282.25H299.25V321.75H369.917V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 282.25H370.417V321.75H441.084V282.25Z" fill="white" />
                            <path d="M441.084 282.25H370.417V321.75H441.084V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 282.25H441.583V321.75H512.25V282.25Z" fill="white" />
                            <path d="M512.25 282.25H441.583V321.75H512.25V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 282.25H512.75V321.75H583.417V282.25Z" fill="white" />
                            <path d="M583.417 282.25H512.75V321.75H583.417V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 282.25H583.917V321.75H654.584V282.25Z" fill="white" />
                            <path d="M654.584 282.25H583.917V321.75H654.584V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 282.25H655.083V321.75H725.75V282.25Z" fill="white" />
                            <path d="M725.75 282.25H655.083V321.75H725.75V282.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 322.25H2.25V361.75H298.75V322.25Z" fill="white" />
                            <path d="M298.75 322.25H2.25V361.75H298.75V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 322.25H299.25V361.75H369.917V322.25Z" fill="white" />
                            <path d="M369.917 322.25H299.25V361.75H369.917V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 322.25H370.417V361.75H441.084V322.25Z" fill="white" />
                            <path d="M441.084 322.25H370.417V361.75H441.084V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 322.25H441.583V361.75H512.25V322.25Z" fill="white" />
                            <path d="M512.25 322.25H441.583V361.75H512.25V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 322.25H512.75V361.75H583.417V322.25Z" fill="white" />
                            <path d="M583.417 322.25H512.75V361.75H583.417V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 322.25H583.917V361.75H654.584V322.25Z" fill="white" />
                            <path d="M654.584 322.25H583.917V361.75H654.584V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 322.25H655.083V361.75H725.75V322.25Z" fill="white" />
                            <path d="M725.75 322.25H655.083V361.75H725.75V322.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 362.25H2.25V415.75H298.75V362.25Z" fill="white" />
                            <path d="M298.75 362.25H2.25V415.75H298.75V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 362.25H299.25V415.75H369.917V362.25Z" fill="white" />
                            <path d="M369.917 362.25H299.25V415.75H369.917V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 362.25H370.417V415.75H441.084V362.25Z" fill="white" />
                            <path d="M441.084 362.25H370.417V415.75H441.084V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 362.25H441.583V415.75H512.25V362.25Z" fill="white" />
                            <path d="M512.25 362.25H441.583V415.75H512.25V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 362.25H512.75V415.75H583.417V362.25Z" fill="white" />
                            <path d="M583.417 362.25H512.75V415.75H583.417V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 362.25H583.917V415.75H654.584V362.25Z" fill="white" />
                            <path d="M654.584 362.25H583.917V415.75H654.584V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 362.25H655.083V415.75H725.75V362.25Z" fill="white" />
                            <path d="M725.75 362.25H655.083V415.75H725.75V362.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 416.25H2.25V455.75H298.75V416.25Z" fill="white" />
                            <path d="M298.75 416.25H2.25V455.75H298.75V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 416.25H299.25V455.75H369.917V416.25Z" fill="white" />
                            <path d="M369.917 416.25H299.25V455.75H369.917V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 416.25H370.417V455.75H441.084V416.25Z" fill="white" />
                            <path d="M441.084 416.25H370.417V455.75H441.084V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 416.25H441.583V455.75H512.25V416.25Z" fill="white" />
                            <path d="M512.25 416.25H441.583V455.75H512.25V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 416.25H512.75V455.75H583.417V416.25Z" fill="white" />
                            <path d="M583.417 416.25H512.75V455.75H583.417V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 416.25H583.917V455.75H654.584V416.25Z" fill="white" />
                            <path d="M654.584 416.25H583.917V455.75H654.584V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 416.25H655.083V455.75H725.75V416.25Z" fill="white" />
                            <path d="M725.75 416.25H655.083V455.75H725.75V416.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 456.25H2.25V495.75H298.75V456.25Z" fill="white" />
                            <path d="M298.75 456.25H2.25V495.75H298.75V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 456.25H299.25V495.75H369.917V456.25Z" fill="white" />
                            <path d="M369.917 456.25H299.25V495.75H369.917V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 456.25H370.417V495.75H441.084V456.25Z" fill="white" />
                            <path d="M441.084 456.25H370.417V495.75H441.084V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 456.25H441.583V495.75H512.25V456.25Z" fill="white" />
                            <path d="M512.25 456.25H441.583V495.75H512.25V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 456.25H512.75V495.75H583.417V456.25Z" fill="white" />
                            <path d="M583.417 456.25H512.75V495.75H583.417V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 456.25H583.917V495.75H654.584V456.25Z" fill="white" />
                            <path d="M654.584 456.25H583.917V495.75H654.584V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 456.25H655.083V495.75H725.75V456.25Z" fill="white" />
                            <path d="M725.75 456.25H655.083V495.75H725.75V456.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 496.25H2.25V535.75H298.75V496.25Z" fill="white" />
                            <path d="M298.75 496.25H2.25V535.75H298.75V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 496.25H299.25V535.75H369.917V496.25Z" fill="white" />
                            <path d="M369.917 496.25H299.25V535.75H369.917V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 496.25H370.417V535.75H441.084V496.25Z" fill="white" />
                            <path d="M441.084 496.25H370.417V535.75H441.084V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 496.25H441.583V535.75H512.25V496.25Z" fill="white" />
                            <path d="M512.25 496.25H441.583V535.75H512.25V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 496.25H512.75V535.75H583.417V496.25Z" fill="white" />
                            <path d="M583.417 496.25H512.75V535.75H583.417V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 496.25H583.917V535.75H654.584V496.25Z" fill="white" />
                            <path d="M654.584 496.25H583.917V535.75H654.584V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 496.25H655.083V535.75H725.75V496.25Z" fill="white" />
                            <path d="M725.75 496.25H655.083V535.75H725.75V496.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 536.25H2.25V575.75H298.75V536.25Z" fill="white" />
                            <path d="M298.75 536.25H2.25V575.75H298.75V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 536.25H299.25V575.75H369.917V536.25Z" fill="white" />
                            <path d="M369.917 536.25H299.25V575.75H369.917V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 536.25H370.417V575.75H441.084V536.25Z" fill="white" />
                            <path d="M441.084 536.25H370.417V575.75H441.084V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 536.25H441.583V575.75H512.25V536.25Z" fill="white" />
                            <path d="M512.25 536.25H441.583V575.75H512.25V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 536.25H512.75V575.75H583.417V536.25Z" fill="white" />
                            <path d="M583.417 536.25H512.75V575.75H583.417V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 536.25H583.917V575.75H654.584V536.25Z" fill="white" />
                            <path d="M654.584 536.25H583.917V575.75H654.584V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 536.25H655.083V575.75H725.75V536.25Z" fill="white" />
                            <path d="M725.75 536.25H655.083V575.75H725.75V536.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 576.25H2.25V629.75H298.75V576.25Z" fill="white" />
                            <path d="M298.75 576.25H2.25V629.75H298.75V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 576.25H299.25V629.75H369.917V576.25Z" fill="white" />
                            <path d="M369.917 576.25H299.25V629.75H369.917V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 576.25H370.417V629.75H441.084V576.25Z" fill="white" />
                            <path d="M441.084 576.25H370.417V629.75H441.084V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 576.25H441.583V629.75H512.25V576.25Z" fill="white" />
                            <path d="M512.25 576.25H441.583V629.75H512.25V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 576.25H512.75V629.75H583.417V576.25Z" fill="white" />
                            <path d="M583.417 576.25H512.75V629.75H583.417V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 576.25H583.917V629.75H654.584V576.25Z" fill="white" />
                            <path d="M654.584 576.25H583.917V629.75H654.584V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 576.25H655.083V629.75H725.75V576.25Z" fill="white" />
                            <path d="M725.75 576.25H655.083V629.75H725.75V576.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 630.25H2.25V683.75H298.75V630.25Z" fill="white" />
                            <path d="M298.75 630.25H2.25V683.75H298.75V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 630.25H299.25V683.75H369.917V630.25Z" fill="white" />
                            <path d="M369.917 630.25H299.25V683.75H369.917V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 630.25H370.417V683.75H441.084V630.25Z" fill="white" />
                            <path d="M441.084 630.25H370.417V683.75H441.084V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 630.25H441.583V683.75H512.25V630.25Z" fill="white" />
                            <path d="M512.25 630.25H441.583V683.75H512.25V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 630.25H512.75V683.75H583.417V630.25Z" fill="white" />
                            <path d="M583.417 630.25H512.75V683.75H583.417V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 630.25H583.917V683.75H654.584V630.25Z" fill="white" />
                            <path d="M654.584 630.25H583.917V683.75H654.584V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 630.25H655.083V683.75H725.75V630.25Z" fill="white" />
                            <path d="M725.75 630.25H655.083V683.75H725.75V630.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 684.25H2.25V723.75H298.75V684.25Z" fill="white" />
                            <path d="M298.75 684.25H2.25V723.75H298.75V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 684.25H299.25V723.75H369.917V684.25Z" fill="white" />
                            <path d="M369.917 684.25H299.25V723.75H369.917V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 684.25H370.417V723.75H441.084V684.25Z" fill="white" />
                            <path d="M441.084 684.25H370.417V723.75H441.084V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 684.25H441.583V723.75H512.25V684.25Z" fill="white" />
                            <path d="M512.25 684.25H441.583V723.75H512.25V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 684.25H512.75V723.75H583.417V684.25Z" fill="white" />
                            <path d="M583.417 684.25H512.75V723.75H583.417V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 684.25H583.917V723.75H654.584V684.25Z" fill="white" />
                            <path d="M654.584 684.25H583.917V723.75H654.584V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 684.25H655.083V723.75H725.75V684.25Z" fill="white" />
                            <path d="M725.75 684.25H655.083V723.75H725.75V684.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M298.75 724.25H2.25V763.75H298.75V724.25Z" fill="white" />
                            <path d="M298.75 724.25H2.25V763.75H298.75V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 724.25H299.25V763.75H369.917V724.25Z" fill="white" />
                            <path d="M369.917 724.25H299.25V763.75H369.917V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 724.25H370.417V763.75H441.084V724.25Z" fill="white" />
                            <path d="M441.084 724.25H370.417V763.75H441.084V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 724.25H441.583V763.75H512.25V724.25Z" fill="white" />
                            <path d="M512.25 724.25H441.583V763.75H512.25V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 724.25H512.75V763.75H583.417V724.25Z" fill="white" />
                            <path d="M583.417 724.25H512.75V763.75H583.417V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 724.25H583.917V763.75H654.584V724.25Z" fill="white" />
                            <path d="M654.584 724.25H583.917V763.75H654.584V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M725.75 724.25H655.083V763.75H725.75V724.25Z" fill="white" />
                            <path d="M725.75 724.25H655.083V763.75H725.75V724.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path
                                d="M2.25 764.25H298.75V798C298.75 801.176 296.176 803.75 293 803.75H8.00001C4.82437 803.75 2.25 801.176 2.25 798V764.25Z"
                                fill="white" />
                            <path
                                d="M2.25 764.25H298.75V798C298.75 801.176 296.176 803.75 293 803.75H8.00001C4.82437 803.75 2.25 801.176 2.25 798V764.25Z"
                                stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M369.917 764.25H299.25V803.75H369.917V764.25Z" fill="white" />
                            <path d="M369.917 764.25H299.25V803.75H369.917V764.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M441.084 764.25H370.417V803.75H441.084V764.25Z" fill="white" />
                            <path d="M441.084 764.25H370.417V803.75H441.084V764.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M512.25 764.25H441.583V803.75H512.25V764.25Z" fill="white" />
                            <path d="M512.25 764.25H441.583V803.75H512.25V764.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M583.417 764.25H512.75V803.75H583.417V764.25Z" fill="white" />
                            <path d="M583.417 764.25H512.75V803.75H583.417V764.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path d="M654.584 764.25H583.917V803.75H654.584V764.25Z" fill="white" />
                            <path d="M654.584 764.25H583.917V803.75H654.584V764.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                            <path
                                d="M655.083 764.25H725.75V798C725.75 801.176 723.176 803.75 720 803.75H660.833C657.658 803.75 655.083 801.176 655.083 798V764.25Z"
                                fill="white" />
                            <path
                                d="M655.083 764.25H725.75V798C725.75 801.176 723.176 803.75 720 803.75H660.833C657.658 803.75 655.083 801.176 655.083 798V764.25Z"
                                stroke="#F5F5F5" stroke-width="0.5" />
                        </g>
                        <rect x="310" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="11" width="46" height="20" fill="#D9D9D9" />
                        <rect x="310" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="52" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="52" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="92" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="92" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="132" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="132" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="172" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="172" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="252" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="252" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="292" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="292" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="332" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="332" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="379" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="379" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="426" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="426" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="466" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="466" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="506" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="506" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="593" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="593" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="647" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="647" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="694" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="694" width="190" height="20" fill="#D9D9D9" />
                        <rect x="310" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="383" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="454" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="525" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="596" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="664" y="774" width="46" height="20" fill="#D9D9D9" />
                        <rect x="19" y="774" width="190" height="20" fill="#D9D9D9" />
                    </g>
                    <defs>
                        <filter id="filter0_d_8_380" x="0" y="0" width="728" height="806" filterUnits="userSpaceOnUse"
                            color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                result="hardAlpha" />
                            <feOffset />
                            <feGaussianBlur stdDeviation="1" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0" />
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_8_380" />
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_8_380" result="shape" />
                        </filter>
                        <clipPath id="clip0_8_380">
                            <rect width="728" height="806" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
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