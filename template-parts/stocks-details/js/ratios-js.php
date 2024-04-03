<?php
    if (function_exists('get_partner_tokens_from_database')) {
        $token = get_partner_tokens_from_database();
    } else {
        $token = us_stocks_get_token();
    }
?>

<script>
    function callRatiosCompareApi(ticker) {
        const ratiosApiUrl = `https://vested-woodpecker-prod.vestedfinance.com/instrument/<?php echo $symbol; ?>/key-ratios?compare=${ticker}`;
        headers = {
            'x-csrf-token': '<?php echo $token->csrf; ?>',
            'Authorization': 'Bearer <?php echo $token->jwToken; ?>'
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
        console.log('data', data);
        const ratiosData = data.data.ratios;
        const priceBookMRQValue = ratiosData.find(section => section.section === 'Valuation').data.current.value['priceBookMRQ'].value;
        setTextContent('faq_stock_pb_ratio', priceBookMRQValue);
        const ratiosContentDiv = document.getElementById('ratios_content');
        document.querySelectorAll(".ratios_section").forEach(e => e.remove());

        for (const section of ratiosData) {
            // Create a div for the section
            const sectionDiv = document.createElement('div');
            sectionDiv.innerHTML = `<h2>${section.section}</h2><p>${section.description}</p>`;
            sectionDiv.classList.add('ratios_section');

            // Check if current value exists
            if (Object.keys(section.data.current.value).length > 0) {
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
                headerRow.innerHTML = `<th></th><th>${section.data.current.label}</th>`;
                
                if (section.data.peers) {
                    headerRow.innerHTML += `<th>${section.data.peers.label}</th>`;
                }

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
                    

                    row.innerHTML = `<td class="${currentHighlight ? 'highlight' : ''}">${label}</td><td class="${currentHighlight ? 'highlight' : ''}">${section.data.current.value[ratio.key].value}</td>`;

                    if (section.data.peers) {
                        const peersHighlight = section.data.peers.value[ratio.key].highlight;
                        row.innerHTML += `<td class="${peersHighlight ? 'highlight' : ''}">${section.data.peers.value[ratio.key].value}</td>`;
                    }

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
            }

            // Append the sectionDiv to the ratiosContentDiv
            ratiosContentDiv.appendChild(sectionDiv);
        }
    }

</script>