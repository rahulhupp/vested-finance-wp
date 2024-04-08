<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem("stocks_list_db_connected")) {
            callStocksInstrumentsTokenApi();
            localStorage.setItem('stocks_list_db_connected', true);
        } else {
            console.log("stocks_list_db_connected found in local storage");
        }
    });

    function callStocksInstrumentsTokenApi() {
        const firstApiUrl = 'https://vested-api-prod.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
        const headers = {
            'partner-id': '7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
            'instrument-list-access': true,
        };
        fetch(firstApiUrl, {  method: 'GET', headers: headers })
        .then(response => response.text())
        .then(token => { callStocksInstrumentsApi(token) })
        .catch(error => console.error('Error:', error));
    }

    function callStocksInstrumentsApi(token) {
        const instrumentsApiUrl = 'https://vested-api-prod.vestedfinance.com/v1/partner/instruments-list'; // Replace with the actual URL of the second API

        const headers = {
            'partner-authentication-token': token,
            'partner-key': '4b766258-6495-40ed-8fa0-83182eda63c9',
        };
        
        fetch(instrumentsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => { storeStocksPageList(data.instruments); })
        .catch(error => console.error('Error:', error));
    }

    async function stocksIndexedDBConnection() {
        var connection = new JsStore.Connection(new Worker('<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jsstore.worker.min.js'));
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

    async function storeStocksPageList(instruments) {
        stocksIndexedDBConnection();
        var rowsDeleted = await connection.remove({ from: 'stocks' });
        var insertCount = await connection.insert({ into: 'stocks', values: instruments });
    }
</script>