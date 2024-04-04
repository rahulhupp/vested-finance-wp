<section class="explore-stock">
    <div class="container">
        <div class="head">
            <h2>Explore any US Stock</h2>
            <p>Discover the world of 5,000+ US Stocks and ETFs</p>
            <!-- <p class="desktop_hide">Issued by top rated companies with high <br>CRISIL ratings</p> -->
        </div>
        <form>
            <div class="field">
                <input placeholder="Search any US Stocks or ETF ..." type="text" id="searchInput" oninput="inputChange()">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/search-icon.webp">
                <div class="clear_icon" onclick="inputClear()"><i class="fa fa-times"></i></div>
            </div>
        </form>
        <div class="explore-image">
            <ul id="stocksResultsList"></ul>
            <ul>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/aapl/apple-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/apple.webp" alt="Apple" />
                            </div>
                            <span>Apple</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/googl/alphabet-inc-class-a-shares-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/google.webp" alt="Google" />
                            </div>
                            <span>Google</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/ivz/invesco-ltd-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/invesco.webp" alt="Invesco" />
                            </div>
                            <span>Invesco</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/msft/microsoft-corporation-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/microsoft.webp" alt="Microsoft"/>
                            </div>
                            <span>Microsoft</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/tsla/tesla-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tesla.webp" alt="Tesla"/>
                            </div>
                            <span>Tesla</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/meta/meta-platforms-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/meta.webp" alt="Meta"/>
                            </div>
                            <span>Meta</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/nflx/netflix-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/netflix.webp" alt="Netflix"/>
                            </div>
                            <span>Netflix</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/etf/bwx/spdr-bbg-barclays-international-treasury-bond-etf-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/spdr.webp" alt="Spdr"/>
                            </div>
                            <span>SPDR</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/amzn/amazoncom-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/amazon.webp" alt="Amazon"/>
                            </div>
                            <span>Amazon</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/spot/spotify-technology-sa-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/spotify.webp" alt="Spotify"/>
                            </div>
                            <span>Spotify</span>
                        </div>
                    </a>
                </li>
            </ul>
            <a class="btn_dark" href="https://app.vestedfinance.com/us-stocks-etfs">Explore ALL US Stocks</a>
        </div>
        <div class="bottom-content">
            <p>Disclosure: This list is representative of stocks available on Vested but is not intended to recommend any investment.</p>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/jsstore/dist/jsstore.min.js"></script>
<script>
    if (sessionStorage.getItem('last_api_call_timestamp')) {
        const current_time = Math.floor(Date.now() / 1000);
        const last_api_call_time = parseInt(sessionStorage.getItem('last_api_call_timestamp'), 10);
        const time_difference = current_time - last_api_call_time;
        const cooldown_period = 3 * 60 * 60;
        
        if (time_difference < cooldown_period) {
            indexedDBConnection();
        } else {
            usstockapi();
        }
    } else {
        usstockapi();
    }

    function usstockapi() {
        callInstrumentsTokenApi();
        const current_time = Math.floor(Date.now() / 1000); // Current time in seconds
        sessionStorage.setItem('last_api_call_timestamp', current_time);
    }

    function callInstrumentsTokenApi() {
        const firstApiUrl = 'https://vested-api-prod.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
        const headers = {
            'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
            'instrument-list-access': true,
        };
        fetch(firstApiUrl, {  method: 'GET', headers: headers })
        .then(response => response.text())
        .then(token => { callInstrumentsApi(token); })
        .catch(error => console.error('Error:', error));
    }

    function callInstrumentsApi(token) {
        const instrumentsApiUrl = 'https://vested-api-prod.vestedfinance.com/v1/partner/instruments-list'; // Replace with the actual URL of the second API

        const headers = {
            'partner-authentication-token': token,
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
        };
        
        fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => { storeStockList(data.instruments); })
        .catch(error => console.error('Error:', error));
    }

    var connection;

    async function indexedDBConnection() {
        connection = new JsStore.Connection(new Worker('<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jsstore.worker.min.js'));
        var dbName ='stocks_list';
        var tblstocks = {
            name: 'stocks',
            columns: {
                id: { primaryKey: true, autoIncrement: true },
                name: { notNull: true, dataType: "string" },
                symbol: { notNull: true, dataType: "string" },
            }
        };
        var database = { name: dbName, tables: [tblstocks], version: 2 }
        const isDbCreated = await connection.initDb(database);
        if(isDbCreated === true){
            console.log("db created");
            setTimeout(function() {
                fetchResultAll('');
            }, 1000);
        } else {
            console.log("db opened");
            fetchResultAll('');
        }
    }

    async function storeStockList(instruments) {
        indexedDBConnection();
        var rowsDeleted = await connection.remove({ from: 'stocks' });
        var insertCount = await connection.insert({ into: 'stocks', values: instruments });
        var results = await connection.select({ from: 'stocks' });
    }

    // Debounce function: Input as function which needs to be debounced and delay is the debounced time in milliseconds
    var  timerId;
    var  debounceFunction  =  function (func, delay) {
        // Cancels the setTimeout method execution
        clearTimeout(timerId)

        // Executes the func after delay time.
        timerId  =  setTimeout(func, delay)
    }

    // This represents a very heavy method. Which takes a lot of time to execute
    function  makeAPICall() {
        var inputValue = document.getElementById("searchInput").value;
        fetchResult(inputValue);
    }

    function inputChange() {
        var inputValue = document.getElementById("searchInput").value;
        var inputClearbtn = document.querySelector('.clear_icon');
        let timeout;

        // Debounces makeAPICall method
        debounceFunction(makeAPICall, 500)

        if(inputValue.length > 0) {
            inputClearbtn.style.display = 'flex';
        }
        else {
            inputClearbtn.style.display = 'none';
        }
    }
    

    async function fetchResult(stock_name) {
        try {
            if (stock_name.length == 0) {
                var ulElement = document.getElementById('stocksResultsList');
                ulElement.nextElementSibling.style.display = 'flex';
                ulElement.style.display = 'none';
                return;
            }
            if (stock_name.length > 0) {
                var ulElement = document.getElementById('stocksResultsList');
                ulElement.nextElementSibling.style.display = 'none';
                ulElement.style.display = 'flex';
            }

            const regex = new RegExp(`\\b${stock_name}`, 'i');
            const results = await connection.select({
                from: 'stocks',
                order: {
                    by: 'symbol',
                    type: "asc"
                },
                where: {
                    symbol: {
                        like: `${stock_name}%`
                    },
                    or: {
                        name: {
                            regex: regex
                        }
                    }
                }
            });
            renderItems(results);
            console.log('renderItems results', results);
        } catch (err) {
            console.log(err);
        }
    }

    async function renderItems(dataArray) {
        var ulElement = document.getElementById('stocksResultsList');
        ulElement.innerHTML = '';
        if (dataArray.length === 0) {
            var messageElement = document.createElement('p');
            messageElement.textContent = 'No stocks to display.';
            ulElement.appendChild(messageElement);
            return; // Exit the function
        }

        var limit = 10;
            var count = 0;
            dataArray.forEach(function(object) {
                if (count < limit) {
                    var liElement = document.createElement('li');
                    var aElement = document.createElement('a'); // Create an anchor element
                    var selectedText = object.name;
                    var selectedValue = object.symbol;
                    var formattedText = selectedText.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                    var formattedValue = selectedValue.toLowerCase().replace(/\s+/g, '-');
                    if (object.type === 'stock') {
                        aElement.href = `https://vestedfinance.com/us-stocks/${formattedValue}/${formattedText}-share-price/`;
                    } else if (object.type === 'etf') {
                        aElement.href = `https://vestedfinance.com/us-stocks/etf/${formattedValue}/${formattedText}-share-price/`;
                    }
                    var divBoxElement = document.createElement('div');
                    divBoxElement.className = 'box';
                    var divExploreIconElement = document.createElement('div');
                    divExploreIconElement.className = 'explore-icon';
                    var imgElement = document.createElement('img');
                    imgElement.src = `https://d13dxy5z8now6z.cloudfront.net/symbol/${object.symbol}.png`; 
                    var spanElement = document.createElement('span');
                    spanElement.textContent = object.name;
                    divExploreIconElement.appendChild(imgElement);
                    divBoxElement.appendChild(divExploreIconElement);
                    divBoxElement.appendChild(spanElement);
                    aElement.appendChild(divBoxElement); // Append the .box element to the anchor
                    liElement.appendChild(aElement); // Append the anchor to the list item
                    ulElement.appendChild(liElement);
                    count++;
                }
            });

    }

    function inputClear() {
        var inputElement = document.getElementById("searchInput");
        var inputClearbtn = document.querySelector('.clear_icon');
        let timeout;

        inputElement.value = '';
        inputClearbtn.style.display = 'none';
        var inputValue = inputElement.value;

        if(timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            fetchResult(inputValue);
        }, 500);
    }

    async function fetchResultAll(stock_name) {
        try {
            const results = await connection.select({
                from: 'stocks',
                order: {
                    by: 'symbol',
                    type: "asc"
                },
                where: {
                    symbol: {
                        like: `${stock_name}%`
                    },
                    or: {
                        name: {
                            like: `${stock_name}%`
                        }
                    }
                }
            });
            console.log('results', results);
        } catch (err) {
            console.log(err);
        }
    }
    
    <?php
        // Set the value for $stock_data
        $stock_data = 'data from us-stock-search';

        // Set the global variable for $stock_data
        $GLOBALS['stock_data'] = $json_data;
    ?>
</script>