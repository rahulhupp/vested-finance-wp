<section class="explore-stock">
    <div class="container">
        <div class="head">
            <h2>Explore US Stocks</h2>
            <p>Discover the world of 10,000+ US Stocks and ETFs</p>
            <!-- <p class="desktop_hide">Issued by top rated companies with high <br>CRISIL ratings</p> -->
        </div>
        <form>
            <div class="field">
                <input placeholder="Search any US Stocks or ETF ..." type="text" id="searchInput" oninput="handleStockSearchInput()">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/search-icon.webp" alt="search icon">
                <div class="clear_icon" onclick="clearSearchInput()"><i class="fa fa-times"></i></div>
            </div>
        </form>
        <div class="explore-image">
            <ul id="stocksResultsList"></ul>
            <ul id="defaultList">
                <li>
                    <a href="https://vestedfinance.com/us-stocks/aapl/apple-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/apple.webp" alt="Apple logo" />
                            </div>
                            <span>Apple</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/googl/alphabet-inc-class-a-shares-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/google.webp" alt="Google logo" />
                            </div>
                            <span>Google</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/ivz/invesco-ltd-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/invesco.webp" alt="Invesco logo" />
                            </div>
                            <span>Invesco</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/msft/microsoft-corporation-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/microsoft.webp" alt="Microsoft logo" />
                            </div>
                            <span>Microsoft</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/tsla/tesla-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tesla.webp" alt="Tesla logo" />
                            </div>
                            <span>Tesla</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/meta/meta-platforms-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/meta.webp" alt="Meta logo" />
                            </div>
                            <span>Meta</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/nflx/netflix-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/netflix.webp" alt="Netflix logo" />
                            </div>
                            <span>Netflix</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/etf/bwx/spdr-bbg-barclays-international-treasury-bond-etf-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/spdr.webp" alt="Spdr logo" />
                            </div>
                            <span>SPDR</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/amzn/amazoncom-inc-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/amazon.webp" alt="Amazon logo" />
                            </div>
                            <span>Amazon</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://vestedfinance.com/us-stocks/spot/spotify-technology-sa-share-price/">
                        <div class="box">
                            <div class="explore-icon">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/spotify.webp" alt="Spotify logo" />
                            </div>
                            <span>Spotify</span>
                        </div>
                    </a>
                </li>
            </ul>
            <p id="noResultsMessage" style="display: none; margin-bottom: 0;">No stocks to display.</p>
            <p id="stock-loader" style="display: none; margin-bottom: 0;"></p>
            <a class="btn_dark" href="<?php echo home_url('/us-stocks/collections/'); ?>">Explore US Stock Collections</a>
        </div>
        <div class="bottom-content">
            <p>Disclosure: This list is representative of stocks available but is not intended to recommend any investment.</p>
        </div>
    </div>
</section>
<script>
    (function() {
        let debounceTimer;

        function handleStockSearchInput() {
            const inputElement = document.getElementById("searchInput");
            const inputValue = inputElement.value.trim();
            const clearButton = document.querySelector('.clear_icon');
            const resultUl = document.querySelector('#stocksResultsList');
            const defaultUl = document.querySelector('#defaultList');
            const noResultsMessage = document.querySelector('#noResultsMessage');
            const loader = document.querySelector('#stock-loader');

            debounce(() => {
                if (inputValue.length > 0) {
                    loader.style.display = 'block';
                    fetchStockResults(inputValue);
                }
            }, 300);

            if (inputValue.length > 0) {
                clearButton.style.display = 'flex';
                resultUl.style.display = 'flex';
                defaultUl.style.display = 'none';
            } else {
                clearButton.style.display = 'none';
                resultUl.style.display = 'none';
                defaultUl.style.display = 'flex';
                noResultsMessage.style.display = 'none';
                loader.style.display = 'none';
            }
        }

        function clearSearchInput() {
            const inputElement = document.getElementById("searchInput");
            const clearButton = document.querySelector('.clear_icon');
            const resultUl = document.querySelector('#stocksResultsList');
            const defaultUl = document.querySelector('#defaultList');
            const noResultsMessage = document.querySelector('#noResultsMessage');
            const loader = document.querySelector('#stock-loader');

            inputElement.value = '';
            clearButton.style.display = 'none';
            resultUl.style.display = 'none';
            defaultUl.style.display = 'flex';
            noResultsMessage.style.display = 'none';
            loader.style.display = 'none';
            resultUl.innerHTML = '';
            clearSearchInput();
        }

        function fetchStockResults(stockName) {
            const limit = 10;
            const resultUl = document.querySelector('#stocksResultsList');
            const noResultsMessage = document.querySelector('#noResultsMessage');
            const loader = document.querySelector('#stock-loader');

            resultUl.innerHTML = '';
            noResultsMessage.style.display = 'none';

            fetch(`/wp-json/api/stocks?query=${encodeURIComponent(stockName)}`)
                .then(response => response.json())
                .then(data => {
                    loader.style.display = 'none';
                    if (data.length === 0) {

                        noResultsMessage.textContent = 'No stocks to display.';
                        noResultsMessage.style.display = 'block';
                        return;
                    }

                    data.sort((a, b) => {
                        const aMatchScore = getMatchScore(stockName, a.name, a.symbol);
                        const bMatchScore = getMatchScore(stockName, b.name, b.symbol);
                        return bMatchScore - aMatchScore;
                    });


                    data.slice(0, limit).forEach(stock => {
                        const liElement = document.createElement('li');
                        const aElement = document.createElement('a');

                        const formattedText = stock.name.trim().toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                        const formattedValue = stock.symbol.toLowerCase().replace(/\s+/g, '-');

                        if (stock.type === 'stock') {
                            aElement.href = `https://vestedfinance.com/us-stocks/${formattedValue}/${formattedText}-share-price/`;
                        } else if (stock.type === 'etf') {
                            aElement.href = `https://vestedfinance.com/us-stocks/etf/${formattedValue}/${formattedText}-share-price/`;
                        }

                        const divBox = document.createElement('div');
                        divBox.className = 'box';

                        const divIcon = document.createElement('div');
                        divIcon.className = 'explore-icon';

                        const imgElement = document.createElement('img');
                        imgElement.src = `https://d13dxy5z8now6z.cloudfront.net/symbol/${stock.symbol}.png`;
                        imgElement.alt = `${stock.name} logo`;

                        imgElement.onerror = () => {
                            imgElement.src = 'https://vested-wordpress-media-prod.s3.amazonaws.com/wp-content/uploads/2025/01/22081511/broken-image.png';
                        };

                        const spanElement = document.createElement('span');
                        spanElement.textContent = stock.name;

                        divIcon.appendChild(imgElement);
                        divBox.appendChild(divIcon);
                        divBox.appendChild(spanElement);
                        aElement.appendChild(divBox);
                        liElement.appendChild(aElement);
                        resultUl.appendChild(liElement);
                    });
                })
                .catch(error => {
                    console.error('Error fetching stocks:', error);
                    loader.style.display = 'none';

                    resultUl.innerHTML = '<li class="error">Failed to load stock data. Please try again later.</li>';
                });
        }

        function getMatchScore(searchTerm, stockName, stockSymbol) {

            const searchLower = searchTerm.toLowerCase();
            const nameLower = stockName.toLowerCase();
            const symbolLower = stockSymbol.toLowerCase();

            let score = 0;

            if (nameLower.startsWith(searchLower)) {
                score += 3;
            } else if (nameLower.includes(searchLower)) {
                score += 2;
            }

            if (symbolLower.startsWith(searchLower)) {
                score += 2;
            } else if (symbolLower.includes(searchLower)) {
                score += 1;
            }

            return score;
        }

        function debounce(func, delay) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(func, delay);
        }

        window.handleStockSearchInput = handleStockSearchInput;
        window.clearSearchInput = clearSearchInput;
    })();
</script>