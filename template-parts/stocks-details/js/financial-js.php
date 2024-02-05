<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>
<script>
    callIncomeStatementApi('annual', 'number');
    callBalanceSheetApi('annual', 'number');
    callCashFlowApi('annual', 'number');

    function callIncomeStatementApi(dataType, valueType){
        const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/income-statement';
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        fetch(returnsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => { 
            bindIncomeStatementData(data.data, dataType, valueType);
        })
        .catch(error => console.error('Error:', error));
    }

    function callBalanceSheetApi(dataType, valueType){
        const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/balance-sheet';
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
        }
        fetch(returnsApiUrl, { method: 'GET',  headers: headers })
        .then(response => response.json())
        .then(data => { 
            bindBalanceSheetData(data.data, dataType, valueType);
        })
        .catch(error => console.error('Error:', error));
    }

    function callCashFlowApi(dataType, valueType){
        const returnsApiUrl = 'https://vested-woodpecker-staging.vestedfinance.com/instrument/<?php echo $symbol; ?>/cash-flow';
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
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
            // var originalArray = data.columns.slice(); // Creates a shallow copy of the array
            // var reversedArray = originalArray.reverse();

            // console.log('originalArray', originalArray); // Original array remains unchanged
            // console.log('reversedArray', reversedArray); // Reversed array

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
            // result[dataType].columns.sort((a, b) => a.key - b.key);
            result[dataType].columns.sort((a, b) => {
                const keyA = isNaN(a.key) ? new Date(a.key).getTime() : parseInt(a.key);
                const keyB = isNaN(b.key) ? new Date(b.key).getTime() : parseInt(b.key);

                return keyA - keyB;
            });
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
            result[dataType].columns.sort((a, b) => {
                const keyA = isNaN(a.key) ? new Date(a.key).getTime() : parseInt(a.key);
                const keyB = isNaN(b.key) ? new Date(b.key).getTime() : parseInt(b.key);

                return keyA - keyB;
            });
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
            result[dataType].columns.sort((a, b) => {
                const keyA = isNaN(a.key) ? new Date(a.key).getTime() : parseInt(a.key);
                const keyB = isNaN(b.key) ? new Date(b.key).getTime() : parseInt(b.key);

                return keyA - keyB;
            });
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
</script>