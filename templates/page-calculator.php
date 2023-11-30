<?php
/*
Template name: Page - Calculator
*/
get_header(); ?>
<script src="https://cdn.jsdelivr.net/npm/jsstore/dist/jsstore.min.js"></script>
<div id="content" role="main" class="calc-page">
<section class="calculator">
        <div class="container">
            <h1 class="main_heading">Test <?php the_field('main_heading'); ?></h1>
            <p class="sub_heading"><?php the_field('main_sub_heading'); ?></p>


            <div class="main_calc_wrap">
                <div class="calc_col">

                    <div class="calc_form_wrap">
                        <form action="" class="calc_form" id="chart_form">

                            <div class="field_group">
                                <label for="stockSelector">Select Stock</label>
                                <select name="stockSelector" id="resultsList">
                                    <option value="AAPL">Appl, Inc - AAPL </option>
                                    <option value="GOOGL">Alphabet </option>
                                    <option value="META">Meta </option>
                                    <option value="AMZN">Amazon </option>
                                    <option value="NFLX">Netflix </option>
                                </select>
                            </div>

                            <div class="field_group">
                                <label for="invest_val">Enter Investment Amount</label>

                                <div class="inner_field">
                                    <span class="currency">$</span>
                                    <input type="text" id="invest_val" value="1,000">

                                    <div class="currency_select">
                                        <div>
                                            <input type="radio" name="currency" id="inr_currency" value="inr">
                                            <label for="inr_currency">INR</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="currency" id="usd_currency" value="usd" checked>
                                            <label for="usd_currency">USD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="field_note">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                            <path d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18Z" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.5 13.5V10.5" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.5 7.5H10.5075" stroke="#002852" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg> Choosing INR will incorporate the FX rate changes as well</span>
                                </div>
                            </div>

                            <?php $currentDate = date('Y-m-d'); ?>
                            <div class="field_group">
                                <div class="field_row">
                                    <div class="field_col">
                                        <label for="startMonth">Select Stock</label>
                                        <input type="date" name="startMonth" id="startMonth" max="<?php echo $currentDate; ?>">
                                    </div>
                                    <div class="field_col">
                                        <label for="endMonth">Select Stock</label>
                                        <input type="date" name="endMonth" id="endMonth" max="<?php echo $currentDate; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="submit_btn">
                                <input type="submit" value="calculate">
                            </div>
                        </form>
                    </div>

                </div>
                <div class="calc_result_col blur">
                    <div class="result_inner_col">
                        <h3>Return Breakdown</h3>
                        <div class="result_breakdown_wrap">
                            <div class="result_graph_col">
                                <!-- <div class="result_circle_wrap">
                                    <div class="investment_amount_data"></div>
                                    <div class="returns_data"></div>
                                </div> -->
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
                                        <p>Est. Returns</p>
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
                        <p>If you had invested $<span id="content_invest_amt">0</span> in January 2021, it would be worth <strong>$<span id="content_total_value">0</span></strong> by August 2023 with <strong><span id="content_cagr">0</span>% CAGR</strong></p>
                        </div>
                        <div class="cta_btn">
                            <a href="<?php the_field('cta_button_url'); ?>"><?php the_field('cta_button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="chart">
        <div class="container">
            <div id="stocks_chart" class="blur">
                <canvas id="myChart" style="width:100%;max-width:1170px"></canvas>
            </div>
            
        </div>

    </section>

<section class="about_calc">
    <div class="container">
        <div class="about_calc_wrap">
            <div class="about_calc_col">
                <h3 class="section_heading_med">What is US Stocks Returns Calculator</h3>

                <div class="calc_cont">
                    <?php the_field('calc_cont'); ?>
                </div>
            </div>
            <div class="other_calc_list">

            <h3 class="section_heading_small">Other Calculators</h3>

            <ul class="calc_list">
                <li><a href="#">Lumpsum/SIP calculator</a></li>
                <li><a href="#">P2P lending calculator</a></li>
                <li><a href="#">Stock SIP/lumpsum Calculator</a></li>
                <li><a href="#">SGB Bond calculator</a></li>
                <li><a href="#">FD Returns calculator</a></li>
                <li><a href="#">Retirement calculator</a></li>
            </ul>

            </div>
        </div>
    </div>
</section>
<?php if (have_rows('faq_list')) : ?>
    <section class="faqs">
        <div class="container">
            <h2 class="section_heading_med"><?php the_field('faqs_heading'); ?></h2>

            <div class="faq_wrap">
                <?php while (have_rows('faq_list')) : the_row(); ?>
                    <div class="single_faq">
                        <div class="faq_que">
                            <h4>
                                <?php the_sub_field('faq_question') ?>
                            </h4>
                        </div>
                        <div class="faq_content">
                            <?php the_sub_field('faq_answer') ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <div id="output"></div>
<?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    // Add an event listener to the form for the "submit" event
    document.getElementById('chart_form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Retrieve and log the values of the form elements
        var stockSelector = document.getElementById('resultsList').value;
        var investmentAmount = document.getElementById('invest_val').value;
        var currency = document.querySelector('input[name="currency"]:checked').value;
        var startDate = document.getElementById('startMonth').value;
        var endDate = document.getElementById('endMonth').value;

        // console.log('Stock Selector: ' + stockSelector);
        // console.log('Investment Amount: ' + investmentAmount);
        // console.log('Currency: ' + currency);
        // console.log('Start Date: ' + startDate);
        // console.log('End Date: ' + endDate);

        // document.getElementById('invest_amt').textContent = investmentAmount;

        triggerAPI(stockSelector, startDate, endDate)
    });

    // Event handler for currency radio buttons
    document.querySelectorAll('.currency_select input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            // Check which radio button is checked
            var selectedOption = document.querySelector('input[name="currency"]:checked').value;

            // Update the text based on the selected radio button
            if (selectedOption === "inr") {
                document.querySelectorAll('.currency').forEach(function (element) {
                    element.textContent = "₹";
                });
                document.querySelectorAll('.calc_currency').forEach(function (element) {
                    element.textContent = "₹";
                });
            } else if (selectedOption === "usd") {
                document.querySelectorAll('.currency').forEach(function (element) {
                    element.textContent = "$";
                });
                document.querySelectorAll('.calc_currency').forEach(function (element) {
                    element.textContent = "$";
                });
            }
        });
    });

    // Function to update button status
    function btnStatus() {
        var startDate = document.getElementById('startMonth').value;
        var endDate = document.getElementById('endMonth').value;

        if (startDate === '' || endDate === '') {
            document.querySelector('.submit_btn input').classList.add('btn-disabled');
        } else {
            document.querySelector('.submit_btn input').classList.remove('btn-disabled');
        }
    }

    btnStatus();

    // Event listeners for date input changes
    document.getElementById('startMonth').addEventListener('input', btnStatus);
    document.getElementById('endMonth').addEventListener('input', btnStatus);

    var Per;    
    var bar = new ProgressBar.Circle(fd_results, {
        strokeWidth: 11,
        easing: "easeInOut",
        duration: 1400,
        color: "#002852",
        trailColor: "#B3D2F1",
        trailWidth: 7,
        svgStyle: null,
    });
    bar.animate(0.5);
    const xValues = [];
    const yValues = [1,1000];
    renderChart(xValues, yValues);
    // Define the URL of the API you want to call
    function triggerAPI (stockSelector, startDate, endDate) {
        const apiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/${stockSelector}/ohlcv?interval=daily&startDate=${startDate}&endDate=${endDate}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log('inn dataArray', data.data);

                const xValues = [];
                data.data.forEach(item => {
                    xValues.push(item.Date);

                });

                const yValues = [];
                const startPrice = data.data[0].Adj_Close;
                const endPrice = data.data[data.data.length-1].Adj_Close;
                const firstDate = new Date(data.data[0].Date);
                const lastDate = new Date(data.data[data.data.length-1].Date);
                const startStockQty = parseFloat(10000/startPrice).toFixed(2);
                const stockSelector = document.getElementById('resultsList').value;
                const investmentAmountString = document.getElementById('invest_val').value;
                const investmentAmount = parseFloat(investmentAmountString.replace(/[^0-9.]/g, ''));
                const finalInvestmentAmount = investmentAmount.toLocaleString();
                const currency = document.querySelector('input[name="currency"]:checked').value;

                const stockQty = parseFloat(investmentAmount/startPrice).toFixed(2);
                const lastPortfolioValue = parseFloat(endPrice*stockQty).toFixed(2);
                const estReturns = parseFloat(lastPortfolioValue - investmentAmount);
                const totalValue =  parseFloat(Number(investmentAmount)+Number(estReturns));
                const initialPortfolioPrice = parseFloat(Number(lastPortfolioValue)/investmentAmount).toFixed(2);
                const differenceInMilliseconds = lastDate - firstDate;
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                const differenceInYears = parseFloat(differenceInDays/365.25).toFixed(2);
                const Periods = parseFloat(1/differenceInYears).toFixed(2);
                var CACR = (Math.pow(initialPortfolioPrice, Periods) -1) * 100;
                Per = parseFloat(lastPortfolioValue / investmentAmount).toFixed(2);

                data.data.forEach(item => {
                    let finalAmount = item.Adj_Close*startStockQty;
                    // let result = parseFloat(finalAmount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    let result = parseFloat(item.Adj_Close*startStockQty);
                    result = Math.round(result);
                    // console.log('Final price', result);
                    yValues.push(result);
                });

                
                
                console.log ('startPrice', startPrice);
                console.log ('endPrice', endPrice);
                console.log ('stockSelector', stockSelector);
                console.log ('investmentAmount', finalInvestmentAmount);
                console.log ('currency', currency);
                console.log ('stockQty', stockQty);
                console.log ('estReturns', estReturns.toLocaleString());
                console.log ('lastPortfolioValue', lastPortfolioValue);
                console.log ('totalValue', totalValue);
                console.log ('initialPortfolioPrice', initialPortfolioPrice);
                console.log ('firstDate', firstDate);
                console.log ('lastDate', lastDate);
                console.log ('differenceInDays', differenceInDays);
                console.log ('differenceInYears', differenceInYears);
                console.log ('Periods', Periods);
                console.log ('CACR', CACR);
                console.log ('calculatePercentage',Per);
                
                document.getElementById('invest_amt').textContent = finalInvestmentAmount;
                document.getElementById('total_calc_val').textContent = finalInvestmentAmount;
                document.getElementById('est_returns').textContent = estReturns.toLocaleString();
                document.getElementById('total_value').textContent = totalValue.toLocaleString();
                document.getElementById('cagr').textContent = CACR.toLocaleString();
                document.getElementById('content_invest_amt').textContent = finalInvestmentAmount;
                document.getElementById('content_total_value').textContent = totalValue.toLocaleString();
                document.getElementById('content_cagr').textContent = CACR.toLocaleString();
                document.querySelector('.calc_result_col').classList.remove('blur');
                document.getElementById('stocks_chart').classList.remove('blur');
                bar.animate(Per);
                renderChart(xValues, yValues);

            })
            .catch(error => alert("Something went wrong!"));
    }
       

    function renderChart(xValues, yValues) {
        const dateObjects = xValues.map(dateString => new Date(dateString));
    
        const formattedLabels = dateObjects.map(date => {
            const month = date.toLocaleString('default', { month: 'short' }); // Get short month name
            const day = date.getDate(); // Get day of the month
            const year = date.getFullYear(); // Get full year
            return `${month} ${day}, ${year}`;
        });

        new Chart("myChart", {
            type: "line",
            data: {
                labels: formattedLabels,
                datasets: [{ 
                    data: yValues,
                    borderColor: "#002852",
                    fill: false,
                    pointRadius: 0 
                }]
            },
            options: {
                scales: {
                    xAxis: {
                        ticks: {
                            maxTicksLimit: 10
                        }
                    },
                    yAxes: [{
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '' + value.toLocaleString();
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                            });
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        });
    }
</script>
<?php

    // Start or resume the user's session
    session_start();

    // Check if the user's last API call timestamp is stored in the session
    if (isset($_SESSION['last_api_call_timestamp'])) {
        // Calculate the time difference between the current time and the last API call time
        $current_time = time();
        $last_api_call_time = $_SESSION['last_api_call_timestamp'];
        $time_difference = $current_time - $last_api_call_time;

        // Define the minimum cooldown period in seconds (3 hours in this case)
        $cooldown_period = 3 * 60 * 60; // 3 hours in seconds

        if ($time_difference < $cooldown_period) {
            ?>
                <script>
                    var connection;
                    async function getData() {
                        try {
                            console.log('getdata');
                            connection = new JsStore.Connection(new Worker('<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jsstore.worker.min.js'));
                            var dbName ='stocks_list';
                            var tblstocks = {
                                name: 'stocks',
                                columns: {
                                    // Here "Id" is name of column 
                                    id:{ primaryKey: true, autoIncrement: true },
                                    name: { notNull: true, dataType: "string" },
                                }
                            };
                            var database = {
                                name: dbName,
                                tables: [tblstocks]
                            }
                            window.addEventListener("load", (event) => {
                                console.log("page is fully loaded");
                                initDB();
                            });
                            async function initDB() {
                                const isDbCreated = await connection.initDb(database);
                                if(isDbCreated === true){
                                    console.log("db created");
                                        // here you can prefill database with some data
                                    }
                                    else {
                                        console.log("db opened");
                                }
                            }
                            
                            const results = await connection.select({
                                from: 'stocks'
                            });

                            renderItems(results);
                            
                        } catch (err) {
                            console.log(err);
                        }
                    }

                    async function renderItems(dataArray) {
                        var selectElement = document.getElementById('resultsList');

                        // Clear existing LI elements
                        selectElement.innerHTML = '';
                        var limit = 50;
                        var count = 0;
                        dataArray.forEach(function(object) {
                            if (count < limit) {
                                var optionElement = document.createElement('option');
                                optionElement.textContent = object.name;
                                optionElement.value = object.symbol;
                                selectElement.appendChild(optionElement);
                                count++;
                            }
                        });
                    }
                    getData();
                    jQuery(document).ready(function() {
                        jQuery('#resultsList').select2({
                            dropdownCssClass: 'stock-result-list'
                        });
                    });    
                </script>
            <?php
            // The cooldown period has not elapsed, so another API call is not allowed yet
            // echo 'You can make another API call in ' . ($cooldown_period - $time_difference) . ' seconds.';
        } else {
            usstockapi();
        }
    } else {
        usstockapi();
    }

    function usstockapi() {
        ?>
        <script>
            var connection = new JsStore.Connection(new Worker('<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jsstore.worker.min.js'));
            var dbName ='stocks_list';
            var tblstocks = {
                name: 'stocks',
                columns: {
                    // Here "Id" is name of column 
                    id: { primaryKey: true, autoIncrement: true },
                    name: { notNull: true, dataType: "string" },
                }
            };
            var database = {
                name: dbName,
                tables: [tblstocks]
            }
            window.addEventListener("load", (event) => {
                console.log("page is fully loaded");
                initDB();
            });
            async function initDB() {
                const isDbCreated = await connection.initDb(database);
                if(isDbCreated === true){
                    console.log("db created");
                        // here you can prefill database with some data
                    }
                    else {
                        console.log("db opened");
                }
            }
        </script>
        <?php
        // Your partner ID and key
        $partner_id = '7bcc5a97-3a00-45f0-bb7d-2df254a467c4';
        $partner_key = '4b766258-6495-40ed-8fa0-83182eda63c9';

        // Step 1: Obtain the authentication token from the first API
        $token_request_url = 'https://vested-api-prod.vestedfinance.com/get-partner-token';

        // Build an array of headers for the first API request
        $headers_token_request = array(
            'partner-id' => $partner_id,
            'partner-key' => $partner_key,
            'instrument-list-access' => true
        );

        $args_token_request = array(
            'headers' => $headers_token_request,
        );

        $response_token_request = wp_remote_get($token_request_url, $args_token_request);

        
        if (is_array($response_token_request) && !is_wp_error($response_token_request)) {
            $token_data = json_encode($response_token_request['body']);

            // Check if the token was obtained successfully
            if (isset($token_data)) {
                $authentication_token = str_replace('"', '', $token_data);
                $_SESSION['last_api_call_timestamp'] = time();
                
                // Step 2: Use the token to make a request to the second API
                $second_api_url = 'https://vested-api-prod.vestedfinance.com/v1/partner/instruments-list'; // Replace with the actual URL
                $headers_second_api = array(
                    'partner-authentication-token' => $authentication_token,
                    'partner-key' => $partner_key,
                );

                $args_second_api = array(
                    'headers' => $headers_second_api,
                );

                $response_second_api = wp_remote_get($second_api_url, $args_second_api);

                if (is_array($response_second_api) && !is_wp_error($response_second_api)) {
                    $second_api_data = json_decode(wp_remote_retrieve_body($response_second_api), true);
                    ?>
                        <script>
                            addData();
                            async function addData() {

                                var rowsDeleted = await connection.remove({
                                    from: 'stocks',
                                });

                                var insertCount = await connection.insert({
                                    into: 'stocks',
                                    values: <?php echo json_encode($second_api_data['instruments']); ?>
                                });

                                var results = await connection.select({
                                    from: 'stocks',
                                });
                                console.log('record found', results.length + ' record found');
                                renderItems(results);
                            };

                            async function renderItems(dataArray) {
                                var selectElement = document.getElementById('resultsList');

                                // Clear existing LI elements
                                selectElement.innerHTML = '';
                                var limit = 100;
                                var count = 0;
                                dataArray.forEach(function(object) {
                                    if (count < limit) {
                                        var optionElement = document.createElement('option');
                                        optionElement.textContent = object.name;
                                        optionElement.value = object.symbol;
                                        selectElement.appendChild(optionElement);
                                        count++;
                                    }
                                });
                            }
                        </script>
                    <?php
                } else {
                    // Handle the error from the second API request and display it
                    echo '<h2>Second API Error:</h2>';
                    echo '<p>Error: ' . wp_remote_retrieve_response_message($response_second_api) . '</p>';
                }
            } else {
                echo 'Token not obtained.';
            }
        } else {
            // Handle the error from the token request and display it
            echo 'Error fetching token.';
        }
    }
?>
<?php get_footer(); ?>