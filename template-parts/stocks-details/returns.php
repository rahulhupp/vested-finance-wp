<div id="returns_tab" class="tab_content">
    <div class="stock_details_box">
        <h2 class="heading">Returns</h2>
        <div class="separator_line"></div>
        <div class="stock_box_tab_container">
            <button class="stock_box_tab_button active" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab1', this)">Absolute returns</button>
            <button class="stock_box_tab_button" onclick="changeStockBoxTab('returns_tab', 'returns_tab_tab2', this)">Annualized returns</button>
        </div>
        <div id="returns_tab_tab1" class="stock_box_tab_content">
            <div class="stock_details_table_container" id="returns_skeleton_after">
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
        <div class="svg_skeleton" id="returns_skeleton">
            <svg width="726" height="370" viewBox="0 0 726 370" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_6_212)">
                    <path
                        d="M719 1H7C3.68629 1 1 3.68629 1 7V363C1 366.314 3.68629 369 7 369H719C722.314 369 725 366.314 725 363V7C725 3.68629 722.314 1 719 1Z"
                        fill="white" />
                    <path
                        d="M719 1H7C3.68629 1 1 3.68629 1 7V363C1 366.314 3.68629 369 7 369H719C722.314 369 725 366.314 725 363V7C725 3.68629 722.314 1 719 1Z"
                        fill="#002852" fill-opacity="0.08" />
                    <path
                        d="M719 0.5H7C3.41015 0.5 0.5 3.41015 0.5 7V363C0.5 366.59 3.41015 369.5 7 369.5H719C722.59 369.5 725.5 366.59 725.5 363V7C725.5 3.41015 722.59 0.5 719 0.5Z"
                        stroke="#002852" stroke-opacity="0.2" />
                    <path d="M1 7C1 3.68629 3.68629 1 7 1H228V49H1V7Z" fill="white" />
                    <path d="M1 7C1 3.68629 3.68629 1 7 1H228V49H1V7Z" fill="#002852" fill-opacity="0.08" />
                    <path d="M132 17H15V37H132V17Z" fill="#DDDDDD" />
                    <path d="M352.333 9H228V41H352.333V9Z" fill="white" />
                    <path d="M352.333 9H228V41H352.333V9Z" fill="#002852" fill-opacity="0.08" />
                    <path d="M329.167 17H251.167V33H329.167V17Z" fill="#DDDDDD" />
                    <path d="M476.666 9H352.333V41H476.666V9Z" fill="white" />
                    <path d="M476.666 9H352.333V41H476.666V9Z" fill="#002852" fill-opacity="0.08" />
                    <path d="M453.5 17H375.5V37H453.5V17Z" fill="#DDDDDD" />
                    <path d="M601 1H476.667V49H601V1Z" fill="white" />
                    <path d="M601 1H476.667V49H601V1Z" fill="#002852" fill-opacity="0.08" />
                    <path d="M577.833 17H499.833V37H577.833V17Z" fill="#DDDDDD" />
                    <path d="M227.75 49.25H1.25V88.75H227.75V49.25Z" fill="white" />
                    <path d="M227.75 49.25H1.25V88.75H227.75V49.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 49.25H228.25V88.75H352.083V49.25Z" fill="white" />
                    <path d="M329 59H251V79H329V59Z" fill="#DDDDDD" />
                    <path d="M329 59H251V79H329V59Z" fill="#DDDDDD" />
                    <path d="M352.083 49.25H228.25V88.75H352.083V49.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M329.167 17H251.167V37H329.167V17Z" fill="#DDDDDD" />
                    <path d="M329.167 17H251.167V37H329.167V17Z" fill="#DDDDDD" />
                    <path d="M476.416 49.25H352.583V88.75H476.416V49.25Z" fill="white" />
                    <path d="M454 59H376V79H454V59Z" fill="#DDDDDD" />
                    <path d="M476.416 49.25H352.583V88.75H476.416V49.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 49.25H476.917V88.75H600.75V49.25Z" fill="white" />
                    <path d="M600.75 49.25H476.917V88.75H600.75V49.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 89.25H1.25V128.75H227.75V89.25Z" fill="white" />
                    <path d="M227.75 89.25H1.25V128.75H227.75V89.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 89.25H228.25V128.75H352.083V89.25Z" fill="white" />
                    <path d="M352.833 130H229V169.5H352.833V130Z" fill="white" />
                    <path d="M352.833 210H229V249.5H352.833V210Z" fill="white" />
                    <path d="M476.833 168H353V207.5H476.833V168Z" fill="white" />
                    <path d="M476.833 330H353V369.5H476.833V330Z" fill="white" />
                    <path d="M352.083 89.25H228.25V128.75H352.083V89.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 89.25H352.583V128.75H476.416V89.25Z" fill="white" />
                    <path d="M476.416 89.25H352.583V128.75H476.416V89.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 89.25H476.917V128.75H600.75V89.25Z" fill="white" />
                    <path d="M600.75 89.25H476.917V128.75H600.75V89.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 129.25H1.25V168.75H227.75V129.25Z" fill="white" />
                    <path d="M227.75 129.25H1.25V168.75H227.75V129.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 129.25H228.25V168.75H352.083V129.25Z" stroke="white" stroke-width="0.5" />
                    <path d="M476.416 129.25H352.583V168.75H476.416V129.25Z" fill="white" />
                    <path d="M453 139H375V159H453V139Z" fill="#DDDDDD" />
                    <path d="M454 179H376V199H454V179Z" fill="#DDDDDD" />
                    <path d="M476.416 129.25H352.583V168.75H476.416V129.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 129.25H476.917V168.75H600.75V129.25Z" fill="white" />
                    <path d="M600.75 129.25H476.917V168.75H600.75V129.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 169.25H1.25V208.75H227.75V169.25Z" fill="white" />
                    <path d="M227.75 169.25H1.25V208.75H227.75V169.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 169.25H228.25V208.75H352.083V169.25Z" fill="white" />
                    <path d="M352.083 169.25H228.25V208.75H352.083V169.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 169.25H352.583V208.75H476.416V169.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 169.25H476.917V208.75H600.75V169.25Z" fill="white" />
                    <path d="M600.75 169.25H476.917V208.75H600.75V169.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 209.25H1.25V248.75H227.75V209.25Z" fill="white" />
                    <path d="M227.75 209.25H1.25V248.75H227.75V209.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 209.25H228.25V248.75H352.083V209.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 209.25H352.583V248.75H476.416V209.25Z" fill="white" />
                    <path d="M476.416 209.25H352.583V248.75H476.416V209.25Z" fill="white" />
                    <path d="M476.416 209.25H352.583V248.75H476.416V209.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 209.25H476.917V248.75H600.75V209.25Z" fill="white" />
                    <path d="M600.75 209.25H476.917V248.75H600.75V209.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 249.25H1.25V288.75H227.75V249.25Z" fill="white" />
                    <path d="M227.75 249.25H1.25V288.75H227.75V249.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 249.25H228.25V288.75H352.083V249.25Z" fill="white" />
                    <path d="M352.083 249.25H228.25V288.75H352.083V249.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 249.25H352.583V288.75H476.416V249.25Z" fill="white" />
                    <path d="M476.416 249.25H352.583V288.75H476.416V249.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 249.25H476.917V288.75H600.75V249.25Z" fill="white" />
                    <path d="M600.75 249.25H476.917V288.75H600.75V249.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M1.25 289.25H227.75V328.75H7C3.82437 328.75 1.25 326.176 1.25 323V289.25Z" fill="white" />
                    <path d="M1.25 289.25H227.75V328.75H7C3.82437 328.75 1.25 326.176 1.25 323V289.25Z" stroke="#F5F5F5"
                        stroke-width="0.5" />
                    <path d="M352.083 289.25H228.25V328.75H352.083V289.25Z" fill="white" />
                    <path d="M352.083 289.25H228.25V328.75H352.083V289.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 289.25H352.583V328.75H476.416V289.25Z" fill="white" />
                    <path d="M476.416 289.25H352.583V328.75H476.416V289.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 289.25H476.917V328.75H600.75V289.25Z" fill="white" />
                    <path d="M600.75 289.25H476.917V328.75H600.75V289.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M600.75 329.25H476.917V368.75H600.75V329.25Z" fill="white" />
                    <path d="M600.75 329.25H476.917V368.75H600.75V329.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M476.416 329.25H352.583V368.75H476.416V329.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M352.083 329.25H228.25V368.75H352.083V329.25Z" fill="white" />
                    <path d="M352.083 329.25H228.25V368.75H352.083V329.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M227.75 329.25H1.25V368.75H227.75V329.25Z" fill="white" />
                    <path d="M227.75 329.25H1.25V368.75H227.75V329.25Z" stroke="#F5F5F5" stroke-width="0.5" />
                    <path d="M601 1H719C722.314 1 725 3.68629 725 7V363C725 366.314 722.314 369 719 369H601V1Z" fill="white" />
                    <path d="M601 1H719C722.314 1 725 3.68629 725 7V363C725 366.314 722.314 369 719 369H601V1Z" fill="#002852"
                        fill-opacity="0.08" />
                    <path d="M131 58H14V78H131V58Z" fill="#DDDDDD" />
                    <path d="M132 101H15V121H132V101Z" fill="#DDDDDD" />
                    <path d="M131 137H14V157H131V137Z" fill="#DDDDDD" />
                    <path d="M131 178H14V198H131V178Z" fill="#DDDDDD" />
                    <path d="M131 221H14V241H131V221Z" fill="#DDDDDD" />
                    <path d="M131 257H14V277H131V257Z" fill="#DDDDDD" />
                    <path d="M131 298H14V318H131V298Z" fill="#DDDDDD" />
                    <path d="M131 340H14V360H131V340Z" fill="#DDDDDD" />
                    <path d="M329 101H251V121H329V101Z" fill="#DDDDDD" />
                    <path d="M330 141H252V161H330V141Z" fill="#DDDDDD" />
                    <path d="M330 180H252V200H330V180Z" fill="#DDDDDD" />
                    <path d="M330 221H252V241H330V221Z" fill="#DDDDDD" />
                    <path d="M330 259H252V279H330V259Z" fill="#DDDDDD" />
                    <path d="M329 299H251V319H329V299Z" fill="#DDDDDD" />
                    <path d="M330 339H252V359H330V339Z" fill="#DDDDDD" />
                    <path d="M454 99H376V119H454V99Z" fill="#DDDDDD" />
                    <path d="M453 219H375V239H453V219Z" fill="#DDDDDD" />
                    <path d="M454 259H376V279H454V259Z" fill="#DDDDDD" />
                    <path d="M453 299H375V319H453V299Z" fill="#DDDDDD" />
                    <path d="M454 339H376V359H454V339Z" fill="#DDDDDD" />
                    <path d="M578 59H500V79H578V59Z" fill="#DDDDDD" />
                    <path d="M578 99H500V119H578V99Z" fill="#DDDDDD" />
                    <path d="M578 137H500V157H578V137Z" fill="#DDDDDD" />
                    <path d="M578 179H500V199H578V179Z" fill="#DDDDDD" />
                    <path d="M578 219H500V239H578V219Z" fill="#DDDDDD" />
                    <path d="M578 257H500V277H578V257Z" fill="#DDDDDD" />
                    <path d="M578 299H500V319H578V299Z" fill="#DDDDDD" />
                    <path d="M578 339H500V359H578V339Z" fill="#DDDDDD" />
                    <path d="M702 92H624V292H702V92Z" fill="#DDDDDD" />
                </g>
                <defs>
                    <clipPath id="clip0_6_212">
                        <rect width="726" height="370" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>
    </div>
</div>