<script>
    callStocksTokenApi();

    function callStocksTokenApi() {
        const firstApiUrl = 'https://vested-api-prod.vestedfinance.com/get-partner-token'; // Replace with the actual URL of the first API
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
            callNewsApi();
            localStorage.setItem('csrf', data.csrf);
            localStorage.setItem('jwToken', data.jwToken);
        })
        .catch(error => console.error('Error:', error));
    }
</script>