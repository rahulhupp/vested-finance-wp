<?php
/*
Template name: Page - Calculator
*/
get_header(); ?>
<script src="https://cdn.jsdelivr.net/npm/jsstore/dist/jsstore.min.js"></script>
<div id="content" role="main" class="calc-page">

<?php get_template_part('template-parts/stocks-calculator'); ?>


<section class="about_calc">
    <div class="container">
        <div class="about_calc_wrap">
            <div class="about_calc_col">
                <!-- <h3 class="section_heading_med">What is US Stocks Returns Calculator</h3> -->

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
<section class="popular_stocks">
    <div class="container">
        <h2 class="popular_stocks_heading">Know your returns when investing in popular US Stocks or ETFs</h2>

        <ul class="stocks_list_wrap">
            <li class="single_stock"><a href="#">3M Company</a></li>
            <li class="single_stock"><a href="#">Alphabet</a></li>
            <li class="single_stock"><a href="#">Amazon</a></li>
            <li class="single_stock"><a href="#">AmerisourceBergen</a></li>
            <li class="single_stock"><a href="#">Berkshire Hathaway</a></li>
            <li class="single_stock"><a href="#">BlackBerry Limited</a></li>
            <li class="single_stock"><a href="#">Brilliant Earth Group</a></li>
            <li class="single_stock"><a href="#">Chevron</a></li>
            <li class="single_stock"><a href="#">Cloudflare</a></li>
            <li class="single_stock"><a href="#">Coca-Cola</a></li>
            <li class="single_stock"><a href="#">Disney</a></li>
            <li class="single_stock"><a href="#">Facebook</a></li>
            <li class="single_stock"><a href="#">Finserv</a></li>
            <li class="single_stock"><a href="#">For Motors</a></li>
            <li class="single_stock"><a href="#">Forward Industried</a></li>
            <li class="single_stock"><a href="#">General Motors Company</a></li>
            <li class="single_stock"><a href="#">Google</a></li>
            <li class="single_stock"><a href="#">Home Depot</a></li>
            <li class="single_stock"><a href="#">Lululemon</a></li>
            <li class="single_stock"><a href="#">Marathon Digital Holdings</a></li>
            <li class="single_stock"><a href="#">Mastercard</a></li>
            <li class="single_stock"><a href="#">Match Group</a></li>
            <li class="single_stock"><a href="#">Microsoft</a></li>
            <li class="single_stock"><a href="#">Morgan Stanley</a></li>
            <li class="single_stock"><a href="#">Netflix</a></li>
            <li class="single_stock"><a href="#">Nike</a></li>
            <li class="single_stock"><a href="#">NIO</a></li>
            <li class="single_stock"><a href="#">NVIDIA</a></li>
            <li class="single_stock"><a href="#">Parker-Hannifin</a></li>
        </ul>
        <button class="see_more_btn"><span>See More</span> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
<path d="M5 7.5L10 12.5L15 7.5" stroke="#1F2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button>
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
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsstore/dist/jsstore.min.js"></script>
<script>
    if (sessionStorage.getItem('last_api_call_timestamp')) {
        const current_time = Math.floor(Date.now() / 1000);
        const last_api_call_time = parseInt(sessionStorage.getItem('last_api_call_timestamp'), 10);
        const time_difference = current_time - last_api_call_time;
        const cooldown_period = 3 * 60 * 60;

        if (time_difference < cooldown_period) {
            indexedDBConnection();
            console.log('Test You can make another API call in ' + (cooldown_period - time_difference) + ' seconds.');
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
        const firstApiUrl = 'https://vested-api-staging.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
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
        const instrumentsApiUrl = 'https://vested-api-staging.vestedfinance.com/v1/partner/instruments-list'; // Replace with the actual URL of the second API

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
        } else {
            console.log("db opened");
        }
    }

    async function storeStockList(instruments) {
        indexedDBConnection();
        var rowsDeleted = await connection.remove({ from: 'stocks' });
        var insertCount = await connection.insert({ into: 'stocks', values: instruments });
        var results = await connection.select({ from: 'stocks' });
    }


    function inputClear() {
        var inputElement = document.querySelector(".dropdown_search");
        let timeout;

        inputElement.value = '';
        var inputValue = inputElement.value;

        if(timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            fetchResult(inputValue);
        }, 500);
    }
</script>
<?php get_footer(); ?>