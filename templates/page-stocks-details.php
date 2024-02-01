<?php
$symbol = get_query_var('symbol');
$symbol_uppercase = strtoupper($symbol);
set_query_var('custom_stock_title_value', "$symbol_uppercase Share Price today - Invest in $symbol_uppercase Stock  | Market Cap, Quote, Returns & More");
set_query_var('custom_stock_description_value', "Get the Live stock price of $symbol_uppercase ($symbol_uppercase), Check its Financials, Fundamental Data, Overview, Technicals, Returns & Earnings over the years and Key ratios & Market news about the stock. Start Investing in $symbol_uppercase and other US Stocks with Vested."); // Replace this with your actual description
get_header();
?>

<div class="stock_details_main">
    <div class="container">
        <div class="stock_details_wrapper">
            <div class="stock_details_left_column">
                <div class="stocks_search_container">
                    <?php get_template_part('template-parts/stock-search-link'); ?>
                </div>
                <div class="stock_details_box stock_info_container">
                    <div class="stock_info_icons">
                        <div class="stock_img">
                            <img src="https://d13dxy5z8now6z.cloudfront.net/symbol/<?php echo $symbol_uppercase; ?>.png" alt="<?php echo $symbol; ?>-img" />
                        </div>
                        <div class="share_icon" onclick="copyLink()">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/share-icon.svg" alt="share-icon" />
                        </div>
                    </div>
                    <h1 id="stock_title"></h1>
                    <h2><?php echo $symbol_uppercase; ?></h2>
                    <h6 id="stock_exchange"></h6>
                    <div class="stock_price_box">
                        <h3 id="stock_price"></h3>
                        <h4 id="stock_changePercent"></h4>
                        <h4 id="stock_change"></h4>
                        <span>1D</span>
                    </div>
                    <div id="stock_tags" class="stock_tags"></div>
                    <a href="https://app.vestedfinance.com/signup"><button class="primary_button">Invest in <?php echo $symbol_uppercase; ?> stock</button></a>
                    <a href="https://app.vestedfinance.com/signup">
                    <button class="secondary_button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path opacity="0.8" d="M11.9662 13.6667L7.81807 10.7037L3.66992 13.6667V4.18519C3.66992 3.87085 3.79479 3.5694 4.01705 3.34713C4.23932 3.12487 4.54078 3 4.85511 3H10.781C11.0954 3 11.3968 3.12487 11.6191 3.34713C11.8414 3.5694 11.9662 3.87085 11.9662 4.18519V13.6667Z" stroke="#002852" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>    
                        <span>Add to watchlist</span>
                    </button>
                    </a>
                </div>
                <div class="stock_details_box stock_forecast_container">
                    <h2 class="heading">Analyst Forecast</h2>
                    <div class="separator_line"></div>
                    <div class="analyst_forecast_chart_container">
                        <canvas id="analystForecastChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="stock_details_right_column">
                <div class="stock_tabs_menu">
                    <div class="stock_tabs_menu_wrapper">
                        <a class="tab_button active" href="#overview_tab">Overview</a>
                        <a class="tab_button" href="#returns_tab">Returns</a>
                        <a class="tab_button" href="#financials_tab">Financials</a>
                        <a class="tab_button" href="#ratios_tab">Ratios</a>
                        <a class="tab_button" href="#news_tab">News</a>
                        <a class="tab_button" href="#faqs_tab">FAQs</a>
                    </div>
                </div>

                <div id="overview_tab" class="tab_content">
                    <div class="stock_details_box stock_chart_container">
                        <div class="stock_chart_header">
                            <h2 class="heading">Price Chart</h2>
                            <div class="stock_chart_buttons">
                                <button onclick="callChartApi('1D', '')">1D</button>
                                <button onclick="callChartApi('1W', '')">1W</button>
                                <button onclick="callChartApi('1M', '')">1M</button>
                                <button onclick="callChartApi('6M', 'daily')">6M</button>
                                <button class="active" onclick="callChartApi('1Y', 'daily')">1Y</button>
                                <button onclick="callChartApi('5Y', 'daily')">5Y</button>
                                <button id="open_ac_modal">Advanced Chart</button>
                            </div>
                        </div>
                        <div class="separator_line"></div>
                        <div class="chart_container">
                            <canvas id="myLineChart" width="400" height="200"></canvas>
                            <div id="verticalLine"></div>
                            <div id="customTooltip"></div>
                            <div id="chart_loader_container" class="chart_loader_container">
                                <span class="chart_loader"></span>
                            </div>
                        </div>
                    </div>

                    <div class="stock_details_box stock_metrics_container">
                        <h2 class="heading">Key Metrics</h2>
                        <div class="separator_line"></div>
                        <div class="stock_metrics_wrapper">
                            <div class="stock_metrics_keyvalue">
                            <div class="stock_summary">
                                <div class="stock_summary_item">
                                    <span>
                                        Market Cap
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This is a company’s total value as determined by the stock market. It is calculated by multiplying the total number of a company's outstanding shares by the current market price of one share.</div>
                                    </span>
                                    <strong id="market_cap"></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        P/E Ratio
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This is the ratio of a security’s current share price to its earnings per share. This ratio determines the relative value of a company’s share.</div>
                                    </span>
                                    <strong id="pe_ratio"></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Volume
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This is the total number of shares traded during the most recent trading day.</div>
                                    </span>
                                    <strong id="volume"></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Avg Volume
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">Text Missing</div>
                                    </span>
                                    <strong id="avg_volume"></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Dividend Yield
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This ratio shows how much income you earn in dividend payouts per year for every dollar invested in the stock (or the stock’s annual dividend payment expressed as a percentage of its current price).</div>
                                    </span>
                                    <strong id="dividend_yield"></strong>
                                </div>
                                <div class="stock_summary_item">
                                    <span>
                                        Beta
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                        <div class="info_text">This measures the expected move in a stock’s price relative to movements in the overall market. The market, such as the S&P 500 Index, has a beta of 1.0. If a stock has a Beta greater (or lower) than 1.0, it suggests that the stock is more (or less) volatile than the broader market.</div>
                                    </span>
                                    <strong id="beta"></strong>
                                </div>
                            </div>
                            </div>
                            <div class="stock_metrics_range">
                                <h6>
                                    <span>52-week Range</span>
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info-icon.svg" alt="info-icon" />
                                    <div class="info_text">This shows the range of the stock’s price between the 52-week high (the highest price of the stock for the past 52 weeks) and the 52-week low (the lowest price of the stock for the past 52 weeks).</div>
                                </h6>
                                <div class="range_container">
                                    <div class="range_item range_low">
                                        <span id="range_low"></span>
                                        <strong>L</strong>
                                    </div>
                                    <div class="range_item range_high">
                                        <span id="range_high"></span>
                                        <strong>H</strong>
                                    </div>
                                    <div class="float_range_item">
                                        <div class="float_range" id="range_current_percentage">
                                            <span id="range_current"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stock_details_box stock_about_container">
                        <h2 id="stock_about_title" class="heading"></h2>
                        <div class="separator_line"></div>
                        <div class="stock_about_wrapper">
                            <p id="stock_about_description" class="stock_about_description"></p>
                        </div>
                        <div id="stock_about_tags" class="stock_tags"></div>
                    </div>
                </div>

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

                <div id="ratios_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">Ratios</h2>
                        <div class="separator_line"></div>
                        <div id="ratios_content"></div>
                    </div>
                </div>

                <div id="news_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">News</h2>
                        <div class="separator_line"></div>
                        <div class="news_section">
                            <div class="news_content">
                                <div class="news_image">
                                    <a href="#">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/news/new_img_one.svg" alt="">
                                    </a>
                                </div>
                                <div class="news-content_wrap">
                                    <a href="#">
                                        <h2>Beyond Evergrande, China’s Property Market Faces a $5 Trillion Reckoning</h2>
                                    </a>
                                    <p>Developers have run up huge debts. Now home sales are down, Beijing is imposing borrowing
                                        curbs and buyers are balking at that
                                    </p>
                                    <span>25 Dec, 2023 at 4:30 pm • NewYorkTimes</span>
                                </div>
                            </div>
                            <div class="news_content">
                                <div class="news_image">
                                    <a href="">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/news/news_img_two.svg" alt="">
                                    </a>
                                </div>
                                <div class="news-content_wrap">
                                    <a href="#">
                                        <h2>Investors Watch for Rising Costs in Earnings This Week</h2>
                                    </a>
                                    <p>JPMorgan Chase, Delta Air Lines, UnitedHealth and Domino’s Pizza are among companies set to
                                        report.
                                    </p>
                                    <span>25 Dec, 2023 at 4:30 pm • NewYorkTimes</span>
                                </div>
                            </div>
                            <div class="news_content">
                                <div class="news_image">
                                    <a href="#">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/news/news_img_three.svg" alt="">
                                    </a>
                                </div>
                                <div class="news-content_wrap">
                                    <a href="#">
                                        <h2>SEC Digs Deeper Into Companies’ EPS Manipulation</h2>
                                    </a>
                                    <p>Regulator uses analytics database based on research that spotted absence of numeral ‘4’ in
                                        companies’ quarterly reports to detect
                                    </p>
                                    <span>25 Dec, 2023 at 4:30 pm • NewYorkTimes</span>
                                </div>
                            </div>
                        </div>
                        <div class="button_secondary">
                            <a href="#"><button type="button" class="read_more_btn">More</button></a>
                        </div>
                    </div>

                    <div id="discover_tab" class="stock_details_box">
                        <h2 class="heading">Discover more</h2>
                        <div class="separator_line"></div>
                        <div class="explore_stocks">
                            <div class="box_warrp" data-symbol="tsal">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/tsal/tesla-inc">
                                    <div class="stocks_img">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/tesla_logo.svg" alt="Tsla">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Tesla, Inc.</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="aapl">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/aapl/apple-inc">
                                    <div class="stocks_img" id="stock_img">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/apple_logo.svg" alt="aaple">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Apple, Inc.</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="googl">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/googl/alphabet-inc-class-a">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/google_logo.svg" alt="GOOGL">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Alphabet Inc. - Class A Shares</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="meta">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/meta/meta-platforms-inc">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/meta_logo.svg" alt="META">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Meta Platforms Inc</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="amzn">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/amzn/amazoncom-inc">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/amazon_logo.svg" alt="AMZN">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Amazon.com Inc.</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="msft">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/msft/microsoft-corporation">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/microsoft_logo.svg" alt="Microsoft">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Microsoft Corporation</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="nvda">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/nvda/nvidia-corporation">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/navida_logo.svg" alt="NVDA">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>NVIDIA Corporation</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="brk.b">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/brk.b/berkshire-hathaway-inc">
                                    <div class="stocks_img brk_stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/BRK.B.png"
                                        alt="BRK">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Berkshire Hathaway Inc. Hld B</h2>
                                    </div>
                                </a>
                            </div>
                            <div class="box_warrp" data-symbol="lly">
                                <a href="<?php echo get_site_url(); ?>/us-stocks/lly/eli-lilly-and-company">
                                    <div class="stocks_img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/discover-images/lilly_logo.svg" alt="LLY">
                                    </div>
                                    <div class="stocks_details">
                                    <h2>Eli Lilly and Company</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>

              

                <div id="faqs_tab" class="tab_content">
                    <div class="stock_details_box">
                        <h2 class="heading">FAQs</h2>
                        <div class="separator_line"></div>
                        <div class="faqs_section">
                            <div class="faq_container">
                                <div class="list_faqs">
                                    <div class="faq_item">
                                        <div class="faq_question">What is <span id="faq_stock_name"></span> share price today?</div>
                                        <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="faq_answer">
                                        <p><span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) share price today is <span id="faq_stock_price"></span></p>
                                    </div>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">Can Indians buy <span id="faq_stock_name"></span> shares?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>Yes, Indians can buy shares of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>). There are two primary methods to buy <span id="faq_stock_name"></span> via Vested.
                                        i.e., direct investing and investing through instruments. You can open your US brokerage account via the
                                        Vested app and purchase shares of <span id="faq_stock_name"></span> directly or invest in <span id="faq_stock_name"></span> via international mutual funds and
                                        exchange-traded funds. If you want an alternative, you can also go for domestic (Indian) funds investing
                                        in the US stock market.</p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">Can Fractional shares of <span id="faq_stock_name"></span> be purchased?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>Yes, you can purchase fractional shares of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) via the Vested app. You can start investing
                                        in <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) with a minimum investment of $1.</p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">How to invest in <span id="faq_stock_name"></span> shares from India?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>You can invest in shares of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) via the Vested app in 3 simple steps:
                                    <ul>
                                        <li>
                                            Download the Vested app or visit app.vestedfinance.com and Sign up with a new account
                                        </li>
                                        <li>
                                            Breeze through our fully digital and secure KYC process and open your US Brokerage account in less
                                            than 2 minutes</li>
                                        <li>
                                            Transfer USD funds to your US Brokerage account and start investing in <span id="faq_stock_name"></span> shares</li>
                                    </ul>
                                    </p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is <span id="faq_stock_name"></span> 52-week high and low stock price?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The 52-week high price of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) is <span id="faq_stock_52_week_high"></span>. The 52-week low price of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>)
                                        is <span id="faq_stock_52_week_low"></span>.</p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is <span id="faq_stock_name"></span> price-to-earnings (P/E) ratio?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The price-to-earnings (P/E) ratio of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) is <span id="faq_stock_pe_ratio"></span></p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is <span id="faq_stock_name"></span> price-to-book (P/B) ratio?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The price-to-book (P/B) ratio of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) is {P/B ratio}</p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is <span id="faq_stock_name"></span> dividend yield?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The dividend yield of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) is <span id="faq_stock_dividend_yield"></span></p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is the Market Cap of <span id="faq_stock_name"></span>?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The market capitalization of <span id="faq_stock_name"></span> (<span id="faq_stock_ticker"></span>) is <span id="faq_stock_market_cap"></span></p>
                                </div>
                                <div class="faq_item">
                                    <div class="faq_question">What is <span id="faq_stock_name"></span>’s stock symbol?</div>
                                    <div class="icon_container"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>
                                <div class="faq_answer">
                                    <p>The stock symbol (or ticker) of <span id="faq_stock_name"></span> is <span id="faq_stock_ticker"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stock_details_box">
                    <h2 class="heading">Feedback</h2>
                    <div class="separator_line"></div>
                    <div class="feedback_section">
                        <div class="feedback_list" style="margin-right: 15px">
                            <a href="#">
                            <h2>Request to add more info/data</h2>
                            
                            </a>
                        </div>
                        <div class="feedback_list">
                            <a href="#">
                            <h2>Inform about wrong info/data</h2>
                        </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="copy_link_message">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/checkmark.png" />
    <span>Link copied</span>
</div>
                            
<?php get_template_part('template-parts/advanced-chart-modal'); ?>
<?php get_template_part('template-parts/add-ticker-modal'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


<script>

    function changeStockBoxTab(sectionId, tabId, clickedTab) {
        var tabs = document.getElementById(sectionId).getElementsByClassName('stock_box_tab_content');
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.add('hidden');
        }
        var allTabs = document.getElementById(sectionId).getElementsByClassName('stock_box_tab_button');
        for (var i = 0; i < allTabs.length; i++) {
            allTabs[i].classList.remove('active');
        }
        document.getElementById(tabId).classList.remove('hidden');
        clickedTab.classList.add('active');
    }


    document.addEventListener('DOMContentLoaded', function() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                anchorLinks.forEach(function(anchor) {
                    anchor.classList.remove('active');
                });
                link.classList.add('active');
                const targetId = link.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    });

    var stockTabsMenu = document.querySelector('.stock_tabs_menu');
    function addClassOnScroll() {
      var scrollPosition = window.scrollY;
      if (scrollPosition >= stockTabsMenu.offsetTop && scrollPosition >= 100) {
        stockTabsMenu.classList.add('highlighted');
      } else {
        stockTabsMenu.classList.remove('highlighted');
      }
    }

    window.addEventListener('scroll', addClassOnScroll);

    function moveElements() {
        // Get the elements to be moved
        var tabsMenu = document.querySelector('.stock_tabs_menu');
        var searchContainer = document.querySelector('.stocks_search_container');
        var forecastContainer = document.querySelector('.stock_forecast_container');
        var metricsContainer = document.querySelector('.stock_metrics_container');
        var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if (windowWidth < 1024) {
            searchContainer.parentNode.insertBefore(tabsMenu, searchContainer.nextSibling);
            metricsContainer.parentNode.insertBefore(forecastContainer, metricsContainer.nextSibling);
        }
    }

    // Call the function on page load and window resize
    document.addEventListener('DOMContentLoaded', moveElements);
    window.addEventListener('resize', moveElements);



    
    callInstrumentsTokenApi();

    function callInstrumentsTokenApi() {
        const firstApiUrl = 'https://vested-api-staging.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
        const headers = {
            'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
            'lead-token-access': true,
        };
        fetch(firstApiUrl, {  method: 'GET', headers: headers })
        .then(response => response.json())
        .then(data => {
            callOverviewApi(data);
            callAnalystForecastApi(data);
            callReturnsApi(data);
            callIncomeStatementApi('annual', 'number');
            callBalanceSheetApi('annual', 'number');
            callCashFlowApi('annual', 'number');
            callRatiosApi();
            localStorage.setItem('csrf', data.csrf);
            localStorage.setItem('jwToken', data.jwToken);
        })
        .catch(error => console.error('Error:', error));
    }

    function callOverviewApi(data) {
        const instrumentsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/overview'; // Replace with the actual URL of the second API

        headers = {
            'x-csrf-token': data.csrf,
            'Authorization': `Bearer ${data.jwToken}`
        }
        
        fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            callChartApi('1Y', 'daily');
            bindOverviewData(data);
            updateMetaTags(data);
         })
        .catch(error => console.error('Error:', error));
    }

    function bindOverviewData(data) {
        setTextContent('stock_title', `${data.data.name}` + "," + `${data.data.type}`);
        setTextContent('stock_exchange', data.data.exchange);
        setTextContent('stock_price', `$${data.data.price}`);
        setTextContent('stock_changePercent', `${data.data.changePercent}%`);
        setTextContent('stock_change', `($${data.data.change})`);

        var stockNameElements = document.querySelectorAll('#faq_stock_name');
        stockNameElements.forEach(function (element) {
            element.textContent = data.data.name;
        });

        var stockTickerElements = document.querySelectorAll('#faq_stock_ticker');
        stockTickerElements.forEach(function (element) {
            element.textContent = data.data.ticker;
        });

        var stockPriceElements = document.querySelectorAll('#faq_stock_price');
        stockPriceElements.forEach(function (element) {
            element.textContent = data.data.price;
        });

        const high52WeekRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).value.high;
        setTextContent('faq_stock_52_week_high', high52WeekRange);

        const low52WeekRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).value.low;
        setTextContent('faq_stock_52_week_low', low52WeekRange);

        const peRatio = (data.data.summary.find(item => item.label === "P/E Ratio") || {}).value;
        setTextContent('faq_stock_pe_ratio', peRatio);
        setTextContent('pe_ratio', peRatio);

        const dividendYieldValue = (data.data.summary.find(item => item.label === "Dividend Yield") || {}).value;
        setTextContent('faq_stock_dividend_yield', dividendYieldValue);
        setTextContent('dividend_yield', dividendYieldValue);

        const marketCapValue = (data.data.summary.find(item => item.label === "Market Cap") || {}).value;
        setTextContent('faq_stock_market_cap', marketCapValue);
        setTextContent('market_cap', marketCapValue);

        const volumeValue = (data.data.summary.find(item => item.label === "Volume") || {}).value;
        setTextContent('volume', volumeValue);
        const avgVolumeValue = (data.data.summary.find(item => item.label === "Avg Volume") || {}).value;
        setTextContent('avg_volume', avgVolumeValue);
        const betaValue = (data.data.summary.find(item => item.label === "Beta") || {}).value;
        setTextContent('beta', betaValue);
        

        var stockChangeElement = document.getElementById('stock_change');
        if (data.data.change < 0) {
            stockChangeElement.classList.add('negative');
        }
   
        var stockChangePercentElement = document.getElementById('stock_changePercent');
        if (data.data.changePercent < 0) {
            stockChangePercentElement.classList.add('negative');
        }
        
        var stockTags = document.getElementById('stock_tags');
        data.data.tags.forEach(tag => stockTags.innerHTML += `<span>${tag.label}: ${tag.value}</span>`);
        
        
        setTextContent('stock_about_title', `About ${data.data.name}` + "," + `${data.data.type}`);
        
        var limitedDescription = data.data.description.split(' ').slice(0, 35).join(' ');
        var stockAboutDescription = document.getElementById('stock_about_description');
        stockAboutDescription.innerHTML += `${limitedDescription}...<span onclick="showMore('${data.data.description}')">more</span>`;
       
        var stockAboutTags = document.getElementById('stock_about_tags');
        data.data.tags.forEach(tag => stockAboutTags.innerHTML += `<span>${tag.label}: ${tag.value}</span>`);
        
        const highRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).raw.high;
        const lowRange = (data.data.summary.find(item => item.label === "52-Week Range") || {}).raw.low;
        setTextContent('range_low', `$${lowRange}`);
        setTextContent('range_high', `$${highRange}`);
        setTextContent('range_current', `$${data.data.price}`);
        const rangePercentage = ((data.data.price - lowRange) / (highRange - lowRange)) * 100;
        const rangeCurrentPercentage = document.getElementById('range_current_percentage');
        rangeCurrentPercentage.style.left = `calc(${rangePercentage}% - 28px)`;;


    }

    function updateMetaTags(data) {
        var head = document.head || document.getElementsByTagName('head')[0];

        // Update title
        var titleTag = head.querySelector('title');

        if (titleTag) {
            titleTag.textContent = `${data.data.name} Share Price today - Invest in ${data.data.ticker} Stock | Market Cap, Quote, Returns & More`;
        }

        // Update description
        // var descriptionTag = head.querySelector('meta[name="description"]');
        // console.log('descriptionTag', descriptionTag);
        // if (descriptionTag) {
        //     descriptionTag.setAttribute('content', 'New Description');
        // }
    }

    function setTextContent(elementId, text) {
        var element = document.getElementById(elementId);
        if (element) {
            element.textContent = text;
        } else {
            console.error('Element with id ' + elementId + ' not found.');
        }
    }

    function showMore(data) {
        setTextContent('stock_about_description', data);
    }

    function callReturnsApi(data) {
        const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/returns';
        headers = {
            'x-csrf-token': data.csrf,
            'Authorization': `Bearer ${data.jwToken}`
        }
        fetch(returnsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => { 
            bindAbsoluteReturnsData(data); 
            bindAnnualizedReturnsData(data); 
        })
        .catch(error => console.error('Error:', error));
    }

    function callReturnsCompareApi(returnData, ticker) {
        var csrf = localStorage.getItem('csrf');
        var jwToken = localStorage.getItem('jwToken');
        const returnsCompareApiUrl = `https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/returns?compare=${ticker}`;
        headers = {
            'x-csrf-token': csrf,
            'Authorization': `Bearer ${jwToken}`
        }
        fetch(returnsCompareApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => {
            bindAbsoluteReturnsData(data);
            bindAnnualizedReturnsData(data);
            var currentTable = document.getElementById('absolute_returns_table');
            currentTable.classList.add('ticker_added');
            var currentTable = document.getElementById('annualized_returns_table');
            currentTable.classList.add('ticker_added');
        })
        .catch(error => console.error('Error:', error));
    }

    function bindAbsoluteReturnsData(data) {
        var table = document.getElementById('ab_returns_table');
        
        if (table) {
            table.parentNode.removeChild(table);
        }

        const returnTableData = data.data;
        var table = document.createElement('table');
        table.id = 'ab_returns_table';
        var thead = document.createElement('thead');
        var tbody = document.createElement('tbody');

        // Add table header
        var headerRow = document.createElement('tr');
        for (var key in returnTableData) {
            if (returnTableData.hasOwnProperty(key) && returnTableData[key].value) {
                var label = returnTableData[key].label;
                if (key === 'reference') {
                    headerRow.innerHTML += `<th>${label}<button onclick="openModalAddTicker('absolute_returns')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>`;
                } else {
                    headerRow.innerHTML += `<th>${label}</th>`;
                }
            }
        }
        thead.appendChild(headerRow);
        

        for (var timeFrameKey in returnTableData.timeFrames.value) {
            var timeFrame = returnTableData.timeFrames.value[timeFrameKey].key;

            var row = document.createElement('tr');
            row.innerHTML = `<td>${returnTableData.timeFrames.value[timeFrameKey].label}</td>`;

            for (var key in returnTableData) {
                if (returnTableData.hasOwnProperty(key) && returnTableData[key].value && returnTableData[key].value[timeFrame]) {
                    var value = returnTableData[key].value[timeFrame].value;
                    row.innerHTML += `<td>${value}</td>`;
                }
            }

            tbody.appendChild(row);
        }

        // Append thead and tbody to the table
        table.appendChild(thead);
        table.appendChild(tbody);

        // Append the table to the "returns_table" div
        document.getElementById('absolute_returns_table').appendChild(table);
    }

    function bindAnnualizedReturnsData(data) {
        var table = document.getElementById('an_returns_table');
        
        if (table) {
            table.parentNode.removeChild(table);
        }

        const returnTableData = data.data;
        var table = document.createElement('table');
        table.id = 'an_returns_table';
        var thead = document.createElement('thead');
        var tbody = document.createElement('tbody');

        // Add table header
        var headerRow = document.createElement('tr');
        for (var key in returnTableData) {
            if (returnTableData.hasOwnProperty(key) && returnTableData[key].value) {
                var label = returnTableData[key].label;
                if (key === 'reference') {
                    headerRow.innerHTML += `<th>${label}<button onclick="openModalAddTicker('annualized_returns')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>`;
                } else {
                    headerRow.innerHTML += `<th>${label}</th>`;
                }
            }
        }

        thead.appendChild(headerRow);

        

        // Add table rows
        for (var key in returnTableData.timeFrames.value) {
            var timeFrameKey = returnTableData.timeFrames.value[key].key;

            // Check if the required properties exist
            if (returnTableData) {
                var heading = returnTableData.timeFrames.value[key].label;

                var days = convertHeadingToDays(heading);

                var stockValue = returnTableData.current.value[timeFrameKey].value;
                var sectorValue = returnTableData.sector.value[timeFrameKey].value;
                var sp500Value = returnTableData.sp500.value[timeFrameKey].value;

                if (returnTableData.reference) {
                    var referenceValue = returnTableData.reference.value[timeFrameKey].value;
                }
                
              
                let stockNumericValue = parseFloat(stockValue.replace("%", ""));
                if (isNaN(stockNumericValue)) {
                    var stockPercentChange = stockValue;
                } else {
                    var stockPercentChange = `${((1 + stockNumericValue) ^ (365/days)) - 1}%`;
                }
                

                let sectorNumericValue = parseFloat(sectorValue.replace("%", ""));
                if (isNaN(sectorNumericValue)) {
                    var sectorPercentChange = stockValue;
                } else {
                    var sectorPercentChange = `${((1 + sectorNumericValue) ^ (365/days)) - 1}%`;
                }

                let spNumericValue = parseFloat(sp500Value.replace("%", ""));
                if (isNaN(spNumericValue)) {
                    var spPercentChange = stockValue;
                } else {
                    var spPercentChange = `${((1 + spNumericValue) ^ (365/days)) - 1}%`;
                }

                if (returnTableData.reference) {
                    let referenceNumericValue = parseFloat(referenceValue.replace("%", ""));
                    if (isNaN(referenceNumericValue)) {
                        var referencePercentChange = referenceValue;
                    } else {
                        var referencePercentChange = `${((1 + referenceNumericValue) ^ (365/days)) - 1}%`;
                    }
                }

                var row = document.createElement('tr');
                if (returnTableData.reference) {
                    row.innerHTML = `<td>${heading}</td><td>${stockPercentChange}</td><td>${sectorPercentChange}</td><td>${spPercentChange}</td><td>${referencePercentChange}</td>`;
                } else {
                    row.innerHTML = `<td>${heading}</td><td>${stockPercentChange}</td><td>${sectorPercentChange}</td><td>${spPercentChange}</td>`;
                }
                
                tbody.appendChild(row);
            } else {
                console.error('Data structure is not as expected for time frame: ', timeFrameKey);
            }
        }

        function convertHeadingToDays(heading) {
            switch (heading) {
                case '1-Week Return':
                    return 7;
                case '1-Month Return':
                    return 30;
                case '3-Month Return':
                    return 90;
                case '6-Month Return':
                    return 180;
                case '1-Year Return':
                    return 365;
                case '3-Year Return':
                    return 3 * 365;
                case '5-Year Return':
                    return 5 * 365;
                case '10-Year Return':
                    return 10 * 365;
                default:
                    return null; // Handle the case where the heading is not recognized
            }
        }

        // Append thead and tbody to the table
        table.appendChild(thead);
        table.appendChild(tbody);

        // Append the table to the "returns_table" div
        document.getElementById('annualized_returns_table').appendChild(table);
    }

    function handleButtonClick(button) {
        var buttons = document.querySelectorAll('.stock_chart_buttons button');
        buttons.forEach(function (btn) {
            btn.classList.remove('active');
        });
        button.classList.add('active');
    }

    function callChartApi(timeframe, interval) {
        if (event) {
            var button = event.target;
            handleButtonClick(button); // Add or remove active class
        }
        var chartLoaderContainer = document.getElementById('chart_loader_container');
        chartLoaderContainer.style.opacity = '1';

        // const apiUrl = `https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/ohlcv?timeframe=${timeframe}&hermes=true`;
        let apiUrl = `https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/ohlcv?timeframe=${timeframe}`;
        if (interval === 'daily') {
            apiUrl += '&interval=daily';
        }

        fetch(apiUrl, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            bindChartData(data, timeframe, interval);
            chartLoaderContainer.style.opacity = '0';
        })
        .catch(error => console.error('Error:', error));
    }

    function bindChartData(data, timeframe, interval) {
			var existingChart = Chart.getChart("myLineChart");
			if (existingChart) {
				document.getElementById('myLineChart').removeEventListener('mousemove', handleMouseMove);
        		document.getElementById('myLineChart').removeEventListener('mouseleave', handleMouseLeave);
				existingChart.destroy();
			}
			const labels = data.data.map(item => item.Date);
			const dataValues = data.data.map(item => interval === 'daily' ? item.Adj_Close : item.Close);

			const chartData = {
				labels: labels,
				datasets: [{
					data: dataValues,
					borderColor: '#002852',
					borderWidth: 2,
					fill: false,
					pointBackgroundColor: "#15803D",
					pointBorderColor: "rgba(21, 128, 61, 0.2)",
					pointBorderWidth: 10,
					pointStyle: 'circle',
					pointRadius: 0, // Set initial point radius to 0
				}]
			};

			var chartOptions = {
				scales: {
					y: {
						grid: {
							color: 'rgba(0,0,0,0)', // Set the grid color to transparent
							drawBorder: false, // Hide the border of the scale
						},
						ticks: {
							callback: function(value, index, ticks) {
								return '$' + value;
							}
						}
					},
					x: {
						grid: {
							color: 'rgba(0,0,0,0)', // Set the grid color to transparent
							drawBorder: false, // Hide the border of the scale
						},
						type: 'timeseries',
						ticks: {
							source: 'labels',
							maxTicksLimit: timeframe === '1Y' ? 5 : 6,
							labelOffset: 30,
						},
						time: {
							unit: getTimeUnit(timeframe),
							displayFormats: {
								'day': 'dd-MMM',
							}
						},
					},
				},
				plugins: {
					tooltip: false,
					legend: {
						display: false
					}
				},
				animation: false
			};


			var ctx = document.getElementById('myLineChart').getContext('2d');
			var myLineChart = new Chart(ctx, {
				type: 'line',
				data: chartData,
				options: chartOptions
			});

			var throttledHandleMouseMove = throttle(function(event) {
				handleMouseMove(event, myLineChart, labels);
			}, 100); // Adjust the delay as needed

			document.getElementById('myLineChart').onmousemove = function(event) {
				throttledHandleMouseMove(event);
			};

			document.getElementById('myLineChart').onmouseleave = function() {
				handleMouseLeave(myLineChart);
			};
			
		}

		function throttle(func, delay) {
			let lastCall = 0;
			return function(...args) {
				const now = new Date().getTime();
				if (now - lastCall >= delay) {
					lastCall = now;
					func(...args);
				}
			};
		}

		function handleMouseMove(event, chartInstance, labels) {
			var chartArea = chartInstance.chartArea;
			var rect = chartInstance.canvas.getBoundingClientRect();
			var mouseX = event.clientX - rect.left;
			var mouseY = event.clientY - rect.top;

			if (mouseX >= chartArea.left && mouseX <= chartArea.right) {
				verticalLine.style.display = 'block';
				verticalLine.style.left = mouseX + 'px';

				// Show the tooltip for the current point
				var activePoints = chartInstance.getElementsAtEventForMode(event, 'index', { intersect: false });
				if (activePoints && activePoints.length > 0) {
					var index = activePoints[0].index;
					chartInstance.options.plugins.tooltip.enabled = true;
					chartInstance.data.datasets[0].pointRadius = function(ctx) {
						return ctx.dataIndex === index ? 6 : 0;
					};
					chartInstance.update();

					var label = labels[index];
                    console.log('label', label);
					var date = new Date(label);
                    console.log('date', date);
                   
					var optionsDate = {
						year: 'numeric',
						month: 'short',
						day: 'numeric',
                        timeZone: 'UTC'
					};

					var optionsTime = {
						hour: 'numeric',
						minute: 'numeric',
						hour12: true,
						timeZone: 'UTC'
					};

					var formattedDate = date.toLocaleDateString('en-US', optionsDate);
                    console.log('formattedDate', formattedDate);
					var formattedTime = date.toLocaleTimeString('en-US', optionsTime);
					var timeZoneAbbreviation = Intl.DateTimeFormat('en-US', { timeZoneName: 'short', timeZone: 'America/New_York' }).formatToParts(new Date()).find(part => part.type === 'timeZoneName').value;

					var value = chartInstance.data.datasets[0].data[index];

					// Position and display the custom tooltip
					customTooltip.style.left = (mouseX - chartArea.left - 120) + 'px';
					customTooltip.style.top = (mouseY - chartArea.top) + 'px';
					customTooltip.style.display = 'block';
					customTooltip.innerHTML = `<div class="stock_chart_label"><strong>$${value}</strong>on ${formattedDate} <br>${formattedTime} ${timeZoneAbbreviation}</div>`;
				}
			} else {
				handleMouseLeave(chartInstance);
			}
		}

		function handleMouseLeave(chartInstance) {
			verticalLine.style.display = 'none';
			chartInstance.options.plugins.tooltip.enabled = false;
			chartInstance.data.datasets[0].pointRadius = 0;
			chartInstance.update();
			customTooltip.style.display = 'none';
		}

		function getTimeUnit(timeframe) {
			switch (timeframe) {
				case "5Y":
					return 'year';
				case "1M":
					return 'week';
				case "1W":
					return 'day';
				case "1D":
					return 'hour';
				default:
					return 'month';
			}
		}

        function callAnalystForecastApi(data) {
            const instrumentsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/analysts-predictions'; // Replace with the actual URL of the second API

            headers = {
                'x-csrf-token': data.csrf,
                'Authorization': `Bearer ${data.jwToken}`
            }
            
            fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => { bindAnalystForecastData(data); })
            .catch(error => console.error('Error:', error));
        }

        function bindAnalystForecastData(data) {
            var distributionData = data.data.distribution;
            distributionData = combineLabels(distributionData, "Strong Buy", "Buy", "Buy");
            distributionData = combineLabels(distributionData, "Strong Sell", "Sell", "Sell");

            var distributionDataLabels = distributionData.map(({ label }) => label);
            var distributionDataPercent = distributionData.map(({ percent }) => percent);

            var forecastChart = document.getElementById("analystForecastChart");
            var forecastData = {
                labels: distributionData.map(({ label }) => label),
                datasets: [
                    {
                        data: distributionData.map(({ percent }) => percent),
                        backgroundColor: [
                            createGradient(201, "#01A86E", 0.0314, "#006744", 0.8388),
                            createGradient(201, "#002852", 0.0314, "#000D1B", 0.8388),
                            createGradient(201, "#DC2626", 0.0314, "#7F1D1D", 0.8388)
                        ],
                        borderWidth: 4
                    }]
            };

            function createGradient(deg, color1, percentage1, color2, percentage2) {
                var ctx = forecastChart.getContext("2d");
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(percentage1, color1);
                gradient.addColorStop(percentage2, color2);
                return gradient;
            }

            var options = {
                plugins: {
                    tooltip: false,
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#FFFFFF',
                        textAlign: 'center',
                        font: {
                            lineHeight: 1.6,
                            fontSize: '24px'
                        },
                        formatter: function(value, ctx) {
                            return  value + '%' + '\n' + ctx.chart.data.labels[ctx.dataIndex];
                        }
                    }
                }
            };

            var pieChart = new Chart(forecastChart, {
                type: 'pie',
                data: forecastData,
                options: options,
                plugins: [ChartDataLabels]
            });
        }

        function combineLabels(data, label1, label2, combinedLabel) {
            const index1 = data.findIndex(item => item.label === label1);
            const index2 = data.findIndex(item => item.label === label2);

            if (index1 !== -1 && index2 !== -1) {
                const combinedValue = data[index1].value + data[index2].value;
                const combinedPercent = data[index1].percent + data[index2].percent;

                data[index1] = {
                    "label": combinedLabel,
                    "value": combinedValue,
                    "percent": combinedPercent
                };

                data.splice(index2, 1);
            }

            return data;
        }

        function callIncomeStatementApi(dataType, valueType){
            var csrf = localStorage.getItem('csrf');
            var jwToken = localStorage.getItem('jwToken');

            const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/income-statement';
            headers = {
                'x-csrf-token': csrf,
                'Authorization': `Bearer ${jwToken}`
            }
            fetch(returnsApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => { 
                bindIncomeStatementData(data.data, dataType, valueType);
            })
            .catch(error => console.error('Error:', error));
        }

        function callBalanceSheetApi(dataType, valueType){
            var csrf = localStorage.getItem('csrf');
            var jwToken = localStorage.getItem('jwToken');

            const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/balance-sheet';
            headers = {
                'x-csrf-token': csrf,
                'Authorization': `Bearer ${jwToken}`
            }
            fetch(returnsApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => { 
                bindBalanceSheetData(data.data, dataType, valueType);
            })
            .catch(error => console.error('Error:', error));
        }

        function callCashFlowApi(dataType, valueType){
            var csrf = localStorage.getItem('csrf');
            var jwToken = localStorage.getItem('jwToken');

            const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/cash-flow';
            headers = {
                'x-csrf-token': csrf,
                'Authorization': `Bearer ${jwToken}`
            }
            fetch(returnsApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => { 
                bindCashFlowData(data.data, dataType, valueType);
            })
            .catch(error => console.error('Error:', error));
        }
        
        function createFinancialsTable(data, valueType) {
            var tableHTML = '<table border="1"><thead><tr>';

            // Add column headers
            data.columns.forEach(function (column) {
                tableHTML += '<th>' + column.label + '</th>';
            });

            tableHTML += '</tr></thead><tbody>';

            // Add data rows
            data.data.forEach(function (rowData) {
                tableHTML += '<tr>';

                // Loop through columns
                data.columns.forEach(function (column) {
                    var key = column.key;

                    // Check if it's a year column or other type of column
                    if (rowData[key]) {
                        if (key === "info") {
                            var classToAdd = rowData[key][1] ? 'highlighted-info' : '';
                            tableHTML += '<td class="' + classToAdd + '">' + (rowData[key][0] || '') + '</td>';
                        } else if (key === "trend") {
                            var chartData = rowData[key];
                            var canvasId = 'chart_' + Math.random().toString(36).substring(7); // Generate a unique ID for the canvas
                            tableHTML += '<td><canvas id="' + canvasId + '" width="38" height="20"></canvas></td>';

                            // Wait for the canvas to be rendered before getting its context
                            setTimeout(function () {
                                var ctx = document.getElementById(canvasId).getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: chartData[valueType].map(item => item.date),
                                        datasets: [{
                                            label: 'Number',
                                            backgroundColor: chartData[valueType].map(item => item.value < 0 ? "#b92406" : "#008a5a"),
                                            borderColor: chartData[valueType].map(item => item.value < 0 ? "#b92406" : "#008a5a"),
                                            borderWidth: 1,
                                            data: chartData[valueType].map(item => item.value),
                                        }],
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                display: false, // Hide x-axis labels
                                            },
                                            y: {
                                                display: false, // Hide y-axis labels
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false // Hide legends
                                            },
                                            tooltip: {
                                                enabled: false // Hide tooltips
                                            }
                                        }
                                    },
                                });
                            }, 0);
                        } else {
                            tableHTML += '<td>' + (rowData[key][valueType] ? rowData[key][valueType].value : '') + '</td>';
                        }
                    } else {
                        tableHTML += '<td></td>';
                    }
                });

                tableHTML += '</tr>';
            });

            tableHTML += '</tbody></table>';

            return tableHTML;
        }

        // Function to add the table to the target div
        function addFinancialsTable(data, divId, valueType) {
            var targetDiv = document.getElementById(divId);
            if (targetDiv) {
                targetDiv.innerHTML = createFinancialsTable(data, valueType);
            } else {
                console.error('Target div with id ' + divId + ' not found.');
            }
        }

        function bindIncomeStatementData(data, dataType, valueType) {
            if (!data) {return null;}
            try {
                const result = {
                    annual: {
                        columns: data.meta.header.annual,
                        data: [],
                    },
                    quarter: {
                        columns: data.meta.header.quarter,
                        data: [],
                    },
                };
                // if (isEmpty(data.data.annual) || isEmpty(data.data.quarter)) {return result;}
                const annualData = data.data.annual;
                const quarterData = data.data.quarter;
                prepareDataForTable(annualData, result, 'annual');
                prepareDataForTable(quarterData, result, 'quarter');
                addFinancialsTable(result[dataType], 'income_statement_table', valueType);
                return result;
            } catch (err) {
                console.log('err', err);
                return {};
            }
        }

        function bindBalanceSheetData(data, dataType, valueType) {
            if (!data) {return null;}
            try {
                const result = {
                    annual: {
                        columns: data.meta.header.annual,
                        data: [],
                    },
                    quarter: {
                        columns: data.meta.header.quarter,
                        data: [],
                    },
                };
                // if (isEmpty(data.data.annual) || isEmpty(data.data.quarter)) {return result;}
                const annualData = data.data.annual;
                const quarterData = data.data.quarter;
                prepareDataForTable(annualData, result, 'annual');
                prepareDataForTable(quarterData, result, 'quarter');
                addFinancialsTable(result[dataType], 'balance_sheet_table', valueType);
                return result;
            } catch (err) {
                console.log('err', err);
                return {};
            }
        }

        function bindCashFlowData(data, dataType, valueType) {
            if (!data) {return null;}
            try {
                const result = {
                    annual: {
                        columns: data.meta.header.annual,
                        data: [],
                    },
                    quarter: {
                        columns: data.meta.header.quarter,
                        data: [],
                    },
                };
                // if (isEmpty(data.data.annual) || isEmpty(data.data.quarter)) {return result;}
                const annualData = data.data.annual;
                const quarterData = data.data.quarter;
                prepareDataForTable(annualData, result, 'annual');
                prepareDataForTable(quarterData, result, 'quarter');
                addFinancialsTable(result[dataType], 'cash_flow_table', valueType);
                return result;
            } catch (err) {
                console.log('err', err);
                return {};
            }
        }


        function prepareDataForTable(framedData, result, frame) {
            for(let i = 0; i < framedData.length; i++) {
                if (framedData[i].section) {
                    const section = {
                        info: [framedData[i].section, true],
                    };
                    result[frame].data.push(section);
                }
                for(let j = 0; j < framedData[i].data.length; j++) {
                    const sectionData = {
                        info: [framedData[i].data[j].info, framedData[i].data[j].highlight],
                    };
                    const years = findYears(result[frame].columns);
                    years.forEach((year) => {
                        sectionData[year] = framedData[i].data[j][year];
                    });
                    sectionData.trend = framedData[i].data[j].trend;
                    years.forEach((year, index) => {
                        sectionData.trend.change[index].displayValue =
                framedData[i].data[j][year].change.value;
                        sectionData.trend.number[index].displayValue =
                framedData[i].data[j][year].number.value;
                    });
                    if (framedData[i].data[j].breakdown) {
                        const breakdown = framedData[i].data[j].breakdown;
                        const breakdownResult = [];
                        for(let k = 0; k < breakdown.length; k++) {
                            const breakdownData = {
                                info: [breakdown[k].info, breakdown[k].highlight, 'child'],
                            };
                            years.forEach((year) => {
                                breakdownData[year] = breakdown[k][year];
                            });
                            breakdownData.trend = breakdown[k].trend;
                            years.forEach((year, index) => {
                                breakdownData.trend.change[index].displayValue =
                    breakdown[k][year].change.value;
                                breakdownData.trend.number[index].displayValue =
                    breakdown[k][year].number.value;
                            });
                            breakdownResult.push(breakdownData);
                        }
                        sectionData.children = breakdownResult;
                    }
                    result[frame].data.push(sectionData);
                }
                if (i !== framedData.length - 1) {
                    result[frame].data.push({});
                }
            }
        }

        function findYears(columns) {
            const years = [...columns];
            years.shift();
            years.pop();
            return years.map((year) => year.key);
        };

        function updateFinancialSelection(selectNumber) {
            var selectElement = document.getElementById(selectNumber);
            var selectedOption = selectElement.options[selectElement.selectedIndex].value;
            var dataType = document.getElementById('data_type_select').value;
            var valueType = document.getElementById('value_type_select').value;
            callIncomeStatementApi(dataType, valueType);
            callBalanceSheetApi(dataType, valueType);
            callCashFlowApi(dataType, valueType);
        }

        function callRatiosApi() {
            var csrf = localStorage.getItem('csrf');
            var jwToken = localStorage.getItem('jwToken');
            const ratiosApiUrl = `https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/key-ratios`;
            headers = {
                'x-csrf-token': csrf,
                'Authorization': `Bearer ${jwToken}`
            }
            fetch(ratiosApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => {
                bindRatiosData(data);
            })
            .catch(error => console.error('Error:', error));
        }

        function callRatiosCompareApi(ticker) {
            var csrf = localStorage.getItem('csrf');
            var jwToken = localStorage.getItem('jwToken');
            const ratiosApiUrl = `https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/key-ratios?compare=${ticker}`;
            headers = {
                'x-csrf-token': csrf,
                'Authorization': `Bearer ${jwToken}`
            }
            fetch(ratiosApiUrl, { method: 'GET',  headers: headers })
            .then(response => response.json())
            .then(data => {
                bindRatiosData(data);
                var currentTable = document.getElementById('ratios_content');
                currentTable.classList.add('ticker_added');
            })
            .catch(error => console.error('Error:', error));
        }

        function bindRatiosData(data) {
            const ratiosData = data.data.ratios;
            const ratiosContentDiv = document.getElementById('ratios_content');
            document.querySelectorAll(".ratios_section").forEach(e => e.remove());


            for (const section of ratiosData) {
                // Create a div for the section
                const sectionDiv = document.createElement('div');
                sectionDiv.innerHTML = `<h2>${section.section}</h2><p>${section.description}</p>`;
                sectionDiv.classList.add('ratios_section');

                // Create a container div for the table and button
                const tableContainerDiv = document.createElement('div');
                tableContainerDiv.classList.add('stock_details_table_container');

                // Create a wrapper div for the table
                const tableWrapperDiv = document.createElement('div');
                tableWrapperDiv.classList.add('stock_details_table_wrapper');

                // Create a div for the table
                const ratiosTableDiv = document.createElement('div');
                ratiosTableDiv.classList.add('stock_details_table', 'ratios_table');

                // Create a table for ratios in each section
                const ratioTable = document.createElement('table');

                // Create thead for the header row
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                headerRow.innerHTML = `<th></th><th>${section.data.current.label}</th><th>${section.data.peers.label}</th>`;
                
                // Check if reference data exists, and add a column for it
                if (section.data.reference) {
                    headerRow.innerHTML += `<th>${section.data.reference.label}<button onclick="openModalAddTicker('ratios_compare')" class="ticker_button"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/repeat.svg">Ticker</button></th>`;
                }

                thead.appendChild(headerRow);

                // Append the thead to the ratioTable
                ratioTable.appendChild(thead);

                // Create tbody for the rows
                const tbody = document.createElement('tbody');

                // Loop through ratios in each section
                for (const ratio of section.data.ratios.value) {
                    // Create a row for each ratio
                    const row = document.createElement('tr');
                    const label = ratio.subtext ? `${ratio.label} <span>${ratio.subtext}</span>` : ratio.label;
                    const currentHighlight = section.data.current.value[ratio.key].highlight;
                    const peersHighlight = section.data.peers.value[ratio.key].highlight;

                    row.innerHTML = `<td class="${currentHighlight ? 'highlight' : ''}">${label}</td><td class="${currentHighlight ? 'highlight' : ''}">${section.data.current.value[ratio.key].value}</td><td class="${peersHighlight ? 'highlight' : ''}">${section.data.peers.value[ratio.key].value}</td>`;

                    // Check if reference data exists, and add a column for it
                    if (section.data.reference) {
                        row.innerHTML += `<td>${section.data.reference.value[ratio.key].value}</td>`;
                    }

                    tbody.appendChild(row);
                }

                // Append the tbody to the ratioTable
                ratioTable.appendChild(tbody);

                // Append the ratioTable to the ratiosTableDiv
                ratiosTableDiv.appendChild(ratioTable);

                // Append the ratiosTableDiv to the tableWrapperDiv
                tableWrapperDiv.appendChild(ratiosTableDiv);

                // Create a button for adding a ticker
                const addButton = document.createElement('button');
                addButton.classList.add('stock_details_table_button');
                addButton.innerHTML = `<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/plus-icon.svg" alt="plus-icon" /><span>Add ticker to compare</span>`;
                addButton.addEventListener('click', () => openModalAddTicker('ratios_compare'));

                // Append the button to the tableWrapperDiv
                tableWrapperDiv.appendChild(addButton);

                // Append the tableWrapperDiv to the tableContainerDiv
                tableContainerDiv.appendChild(tableWrapperDiv);

                // Append the tableContainerDiv to the sectionDiv
                sectionDiv.appendChild(tableContainerDiv);

                // Append the sectionDiv to the ratiosContentDiv
                ratiosContentDiv.appendChild(sectionDiv);
            }
        }
</script>


<!-- discover more -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var symbol = "<?php echo $symbol; ?>";
        var stockBoxes = document.querySelectorAll('.box_warrp');
        var hideLastDiv = true;
        stockBoxes.forEach(function (box) {
            if (box.getAttribute('data-symbol') === symbol) {
                hideLastDiv = false;
                box.style.display = 'none';
            }
        });
        if (hideLastDiv) {
            var lastDiv = stockBoxes[stockBoxes.length - 1];
            lastDiv.style.display = 'none';
        }
    });
</script>

<!-- discover more-->

<!-- faqs -->
<script>
 const faqItems = document.querySelectorAll('.faq_item');

faqItems.forEach(item => {
  const question = item.querySelector('.faq_question');
  const answer = item.nextElementSibling;
  const icon = item.querySelector('i');

  item.addEventListener('click', () => {
    faqItems.forEach(otherItem => {
      if (otherItem !== item) {
        const otherAnswer = otherItem.nextElementSibling;
        const otherIcon = otherItem.querySelector('i');

        otherAnswer.classList.remove('active');
        otherIcon.classList.remove('active');
        otherAnswer.style.maxHeight = "0";
      }
    });
    answer.classList.toggle('active');
    icon.classList.toggle('active');
    if (answer.classList.contains('active')) {
      answer.style.maxHeight = answer.scrollHeight + "px";
    } else {
      answer.style.maxHeight = "0";
    }
  });
});

function copyLink() {
    console.log('copyLink');
    var inputElement = document.createElement("input");
    inputElement.value = "<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/images/share-icon.svg";
    document.body.appendChild(inputElement);
    inputElement.select();
    document.body.removeChild(inputElement);

    // Display the message multiple times
    for (var i = 0; i < 5; i++) {
        displayMessage();
    }
}

function displayMessage() {
    var copyMessage = document.getElementById("copy_link_message");
    copyMessage.classList.add('active');
    setTimeout(function () {
        copyMessage.classList.remove('active');
    }, 2000);
}
</script>
<!-- end -faqs -->
<?php get_footer(); ?>