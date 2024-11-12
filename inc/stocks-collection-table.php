<?php
/* stocks collection table */

// Ajax handler for stocks collection pagination
add_action('wp_ajax_fetch_stocks_data', 'fetch_stocks_data');
add_action('wp_ajax_nopriv_fetch_stocks_data', 'fetch_stocks_data');

function fetch_stocks_data()
{
    global $wpdb;

    $page_id = intval($_POST['page_id']);
    $ticker_type = get_field('ticker_list_type', $page_id);
    $table_name = $wpdb->prefix . 'stocks_list_details';
    if ($ticker_type === 'manual') {
        $stocks_list = get_field('stock_symbols', $page_id); // acf field
        $symbols = explode(',', $stocks_list); // Convert to array
        $placeholders = implode(',', array_fill(0, count($symbols), '%s'));
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE symbol IN ($placeholders)", $symbols);
        $results = $wpdb->get_results($query);
    } elseif ($ticker_type === 'algorithm') {
        $algorithm_type = get_field('algorithm_select', $page_id);

        if ($algorithm_type === 'gainers') {
            $query = "SELECT * FROM $table_name WHERE price IS NOT NULL AND price > 0 ORDER BY price_change DESC LIMIT 20";
        } elseif ($algorithm_type === 'losers') {
            $query = "SELECT * FROM $table_name WHERE price IS NOT NULL AND price > 0 ORDER BY price_change ASC LIMIT 20";
        } elseif ($algorithm_type === 'megaCap') {
            $query = "SELECT * FROM $table_name WHERE market_cap >= 200000000000 ORDER BY market_cap DESC";
        } elseif ($algorithm_type === 'largeCap') {
            $query = "SELECT * FROM $table_name WHERE market_cap >= 10000000000 AND market_cap <= 200000000000 ORDER BY market_cap DESC";
        } elseif ($algorithm_type === 'midCap') {
            $query = "SELECT * FROM $table_name WHERE market_cap >= 2000000000 AND market_cap <= 10000000000 ORDER BY market_cap DESC";
        } elseif ($algorithm_type === 'smallCap') {
            $query = "SELECT * FROM $table_name WHERE market_cap >= 300000000 AND market_cap <= 2000000000 ORDER BY market_cap DESC";
        } elseif ($algorithm_type === 'microCap') {
            $query = "SELECT * FROM $table_name WHERE market_cap <= 300000000 ORDER BY market_cap DESC";
        } elseif ($algorithm_type === 'oneYHigh') {
            $query = "SELECT * FROM $table_name WHERE ABS(((price - week_52_high) / week_52_high) * 100) < 20 ORDER BY ABS(((price - week_52_high) / week_52_high) * 100) ASC LIMIT 20";
        } elseif ($algorithm_type === 'oneYLow') {
            $query = "SELECT * FROM $table_name WHERE ABS(((price - week_52_low) / week_52_low) * 100) < 20 ORDER BY ABS(((price - week_52_low) / week_52_low) * 100) ASC LIMIT 20";
        }


        if (isset($query)) {
            $results = $wpdb->get_results($query);
        }
    }

    function format_market_cap($market_cap)
    {
        if ($market_cap >= 1_000_000_000_000) {
            return round($market_cap / 1_000_000_000_000, 1) . 'T';
        } elseif ($market_cap >= 1_000_000_000) {
            return round($market_cap / 1_000_000_000, 1) . 'B';
        } elseif ($market_cap >= 1_000_000) {
            return round($market_cap / 1_000_000, 1) . 'M';
        } elseif ($market_cap >= 1_000) {  // Use 1000 for "K" condition
            return round($market_cap / 1_000, 1) . 'K'; // Round to 1 decimal place
        } else {
            return number_format($market_cap);
        }
    }

    $all_data = [];
    foreach ($results as $row) {
        $all_data[] = [
            'name' => $row->name,
            'symbol' => $row->symbol,
            'price' => $row->price,
            'prev_close' => $row->previous_close,
            'week_52_high' => $row->week_52_high,
            'price_change' => $row->change_percent,
            'market_cap' => $row->market_cap,
            'pe_ratio' => $row->pe_ratio,
            'cagr_5_year' => $row->cagr_5_year,
            'one_year_returns' => $row->one_year_returns,
        ];
    }

    wp_send_json_success(['all_data' => $all_data]);
}

function enqueue_custom_pagination_script()
{
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var page_id = '<?php echo get_the_ID(); ?>';
            var currentPage = 1;
            var allData = [];
            var stocksPerPage = $('#list_table').data('post-num') || -1;


            var sortBy = $('#list_table').data('sort-by') || 'market_cap'; // 'market_cap' or 'price'
            var sortOrder = $('#list_table').data('sort-order') || 'asc'; // 'asc' or 'dsc'

            // Sorting state
            var sortingState = {
                marketCap: {
                    order: 'asc'
                },
                peRatio: {
                    order: 'asc'
                },
                price: {
                    order: 'asc'
                },
                one_year_returns: {
                    order: 'asc'
                },
                cagr_5_year: {
                    order: 'asc'
                }
            };

            // Fetch data and render table
            loadStocksData();

            function loadStocksData() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'fetch_stocks_data',
                        page_id: page_id
                    },
                    success: function(response) {
                        if (response.success) {
                            allData = response.data.all_data;

                            // Apply default sorting based on ACF fields
                            applyDefaultSort();

                            // Render the table after sorting
                            renderTable(currentPage);
                            generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
                            updateStockCount(allData.length);
                        } else {
                            $('#stocks-table tbody').html('<tr><td colspan="6">Error loading data</td></tr>');
                        }
                    }
                });
            }

            function updateStockCount(totalStocks) {
                if (totalStocks > 0) {
                    $('#stocks_count').text(totalStocks + ' Stocks');
                } else {
                    $('#stocks_count').text('No Stocks');
                }
            }

            // Default sorting logic based on ACF fields
            function applyDefaultSort() {
                allData.sort(function(a, b) {
                    var valueA = 0, valueB = 0;
                    // Sorting by 'market_cap' or 'price' based on the ACF value
                    if (sortBy === 'market_cap') {
                        valueA = a.market_cap ? parseFloat(a.market_cap.replace(/,/g, '')) : 0;
                        valueB = b.market_cap ? parseFloat(b.market_cap.replace(/,/g, '')) : 0;
                    } else if (sortBy === 'price') {
                        valueA = a.price ? parseFloat(a.price) : 0;
                        valueB = b.price ? parseFloat(b.price) : 0;
                    } else if (sortBy === 'price_change') {
                        valueA = a.price_change ? parseFloat(a.price_change) : 0;
                        valueB = b.price_change ? parseFloat(b.price_change) : 0;
                    } else if (sortBy === 'one_year_returns') {
                        valueA = a.one_year_returns ? parseFloat(a.one_year_returns) : 0;
                        valueB = b.one_year_returns ? parseFloat(b.one_year_returns) : 0;
                    } else if (sortBy === 'cagr_5_year') {
                        valueA = a.cagr_5_year ? parseFloat(a.cagr_5_year) : 0;
                        valueB = b.cagr_5_year ? parseFloat(b.cagr_5_year) : 0;
                    }

                    // Sort ascending or descending based on the ACF 'sort_order'
                    if (sortOrder === 'asc') {
                        return valueA - valueB;
                    } else {
                        return valueB - valueA;
                    }
                });
            }

            function formatMarketCap(value) {
                if (value === null || value === undefined) {
                    return 'N/A';
                }
                if (value >= 1e12) {
                    return (value / 1e12).toFixed(2) + 'T';
                } else if (value >= 1e9) {
                    return (value / 1e9).toFixed(2) + 'B';
                } else if (value >= 1e6) {
                    return (value / 1e6).toFixed(2) + 'M';
                } else if (value >= 1e3) {
                    return (value / 1e3).toFixed(2) + 'K';
                } else {
                    return value.toString()
                }
            }

            // Render the table for the current page
            function renderTable(page) {
                $('#stocks-table tbody').empty();
                var start = (page - 1) * stocksPerPage;
                var end = start + stocksPerPage;

                var currentData = allData.slice(start, end);

                if (currentData.length === 0) {
                    $('#stocks-table tbody').html('<tr><td colspan="6">No results found</td></tr>');
                    return;
                }

                // Populate table rows
                currentData.forEach(function(stock) {
                    if(stock.pe_ratio == null) {
                        peRatio = 'N/A';
                    }
                    else{
                        peRatio = stock.pe_ratio;
                    }

                    if(stock.cagr_5_year == null) {
                        var cagr_5_year = 'N/A';
                    }
                    else {
                        var cagr_5_year = stock.cagr_5_year + '%';
                    }

                    if(stock.price == null) {
                        var stockPrice = 'N/A';
                    }
                    else {
                        var stockPrice = '$' + stock.price;
                    }

                    if(stock.price_change == null) {
                        var stockPriceChange = 'N/A';
                    }
                    else {
                        var stockPriceChange = (stock.price_change < 0 ? '' : '+') + stock.price_change + '%';
                    }
                    var changeClass = '';
                    if(stock.price_change == null || stock.price_change < 0) {
                        changeClass = 'minus_value';
                    }

                    if(stock.one_year_returns == null) {
                        var oneYearReturns = 'N/A';
                    }
                    else {
                        var oneYearReturns = stock.one_year_returns + '%';
                    }

                    $('#stocks-table tbody').append('<tr><td>' +
                        '<div class="stock_symbol_wrap"><div class="stock_symbol_img"><img src="https://d13dxy5z8now6z.cloudfront.net/symbol/' +
                        stock.symbol + '.png" alt="' + stock.symbol + '-img" /></div>' +
                        '<div class="stock_name"><p>' + stock.name + '</p>' +
                        '<span>(' + stock.symbol + ')</span></div></div></td>' +
                        '<td class="pricing_cols">' + stockPrice +
                        '<strong class="stock_change ' + changeClass + '">' + stockPriceChange + '</strong></td>' +
                        '<td>' + formatMarketCap(stock.market_cap) + '</td>' + // Use the formatting function here
                        '<td>' + peRatio + '</td>' +
                        '<td>'+ oneYearReturns +'</td><td>'+ cagr_5_year +'</td></tr>');
                });


            }

            function parseMarketCap(value) {
                if (typeof value === 'string') {
                    let numericValue = parseFloat(value.replace(/[$,]/g, ''));

                    if (value.includes('T')) {
                        return numericValue * 1_000_000_000_000;
                    } else if (value.includes('B')) {
                        return numericValue * 1_000_000_000;
                    } else if (value.includes('M')) {
                        return numericValue * 1_000_000;
                    }
                }
                return parseFloat(value) || 0;
            }

            $('.sort_data').on('click', function() {
                var sortField = $(this).closest('th').data('sort');
                var currentOrder = $(this).data('order') || 'asc';

                // Reset other sorting fields
                if (sortField === 'market_cap') {
                    sortingState.peRatio.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                } else if (sortField === 'pe_ratio') {
                    sortingState.marketCap.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                } else if (sortField === 'one_year_returns') {
                    sortingState.peRatio.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                    sortingState.marketCap.order = 'asc';
                } else if (sortField === 'cagr_5_year') {
                    sortingState.peRatio.order = 'asc';
                    sortingState.marketCap.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                }


                currentOrder = (currentOrder === 'asc') ? 'desc' : 'asc';
                $(this).data('order', currentOrder);


                allData.sort(function(a, b) {
                    var aValue, bValue;

                    if (sortField === 'market_cap') {
                        aValue = parseMarketCap(a.market_cap);
                        bValue = parseMarketCap(b.market_cap);
                    } else if (sortField === 'pe_ratio') {
                        aValue = parseFloat(a.pe_ratio) || 0;
                        bValue = parseFloat(b.pe_ratio) || 0;
                    } else if (sortField === 'one_year_returns') {
                        aValue = parseFloat(a.one_year_returns) || 0;
                        bValue = parseFloat(b.one_year_returns) || 0;
                    } else if (sortField === 'cagr_5_year') {
                        aValue = parseFloat(a.cagr_5_year) || 0;
                        bValue = parseFloat(b.cagr_5_year) || 0;
                    }

                    return (currentOrder === 'asc') ? (aValue - bValue) : (bValue - aValue);
                });

                renderTable(currentPage);
            });

            if($('.explore_market_leaders').data('sort-by') == 'price_change') {
                $('.table_sort_options ul li[data-sort="price_change"]').addClass('active');
            }

            else if($('.explore_market_leaders').data('sort-by') == 'market_cap') {
                $('.table_sort_options ul li[data-sort="market_cap"]').addClass('active');
            }

            else if($('.explore_market_leaders').data('sort-by') == 'one_year_returns') {
                $('.table_sort_options ul li[data-sort="one_year_returns"]').addClass('active');
            }

            else if($('.explore_market_leaders').data('sort-by') == 'cagr_5_year') {
                $('.table_sort_options ul li[data-sort="cagr_5_year"]').addClass('active');
            }

            else {
                $('.table_sort_options ul li[data-sort="price_change"]').addClass('active');
            }

            $('.table_sort_options ul li').click(function() {
                var sortField = $(this).data('sort');
                var currentOrder = $(this).data('order') || 'asc';

                $('.table_sort_options ul li.active').removeClass('active');
                $(this).addClass('active');

                if (sortField === 'market_cap') {
                    sortingState.peRatio.order = 'asc';
                    sortingState.price.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                } else if (sortField === 'pe_ratio') {
                    sortingState.marketCap.order = 'asc';
                    sortingState.price.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                } else if (sortField === 'price') {
                    sortingState.marketCap.order = 'asc';
                    sortingState.peRatio.order = 'asc';
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.cagr_5_year.order = 'asc';
                } else if (sortField === 'one_year_returns') {
                    sortingState.cagr_5_year.order = 'asc';
                    sortingState.marketCap.order = 'asc';
                    sortingState.price.order = 'asc';
                    sortingState.peRatio.order = 'asc';
                } else if (sortField === 'cagr_5_year') {
                    sortingState.one_year_returns.order = 'asc';
                    sortingState.marketCap.order = 'asc';
                    sortingState.price.order = 'asc';
                    sortingState.peRatio.order = 'asc';
                }


                currentOrder = (currentOrder === 'asc') ? 'desc' : 'asc';
                $(this).data('order', currentOrder);

                allData.sort(function(a, b) {
                    var aValue, bValue;

                    if (sortField === 'market_cap') {
                        aValue = parseMarketCap(a.market_cap);
                        bValue = parseMarketCap(b.market_cap);
                    } else if (sortField === 'pe_ratio') {
                        aValue = parseFloat(a.pe_ratio) || 0;
                        bValue = parseFloat(b.pe_ratio) || 0;
                    } else if (sortField === 'price') {
                        aValue = parseFloat(a.price) || 0;
                        bValue = parseFloat(b.price) || 0;
                    } else if (sortField === 'one_year_returns') {
                        aValue = parseFloat(a.one_year_returns) || 0;
                        bValue = parseFloat(b.one_year_returns) || 0;
                    } else if (sortField === 'cagr_5_year') {
                        aValue = parseFloat(a.cagr_5_year) || 0;
                        bValue = parseFloat(b.cagr_5_year) || 0;
                    }

                    return (currentOrder === 'asc') ? (aValue - bValue) : (bValue - aValue);
                });

                renderTable(currentPage);

                $('.table_sort_overlay').fadeOut();
                $('.table_sort_options').fadeOut();

            });

            $('.sort_icon').click(function() {
                $('.table_sort_overlay').fadeIn();
                $('.table_sort_options').fadeIn();
            });

            $('.table_sort_overlay').click(function() {
                $('.table_sort_overlay').fadeOut();
                $('.table_sort_options').fadeOut();
            })

            // Pagination functionality
            function generatePagination(totalPages, currentPage) {
                var paginationHtml = '';

                // Previous arrow
                if (currentPage > 1) {
                    paginationHtml += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.39846 1.9843V0.927467C7.39846 0.835866 7.29318 0.78528 7.22209 0.841334L1.05881 5.6552C1.00644 5.69592 0.964071 5.74807 0.934924 5.80766C0.905777 5.86725 0.890625 5.93271 0.890625 5.99905C0.890625 6.06539 0.905777 6.13085 0.934924 6.19044C0.964071 6.25003 1.00644 6.30217 1.05881 6.3429L7.22209 11.1568C7.29455 11.2128 7.39846 11.1622 7.39846 11.0706V10.0138C7.39846 9.9468 7.36701 9.88254 7.31506 9.84153L2.39318 5.99973L7.31506 2.15657C7.36701 2.11555 7.39846 2.0513 7.39846 1.9843Z" fill="black" fill-opacity="0.88"/></svg></a> ';
                } else {
                    paginationHtml += '<span class="page-link disabled"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.39846 1.9843V0.927467C7.39846 0.835866 7.29318 0.78528 7.22209 0.841334L1.05881 5.6552C1.00644 5.69592 0.964071 5.74807 0.934924 5.80766C0.905777 5.86725 0.890625 5.93271 0.890625 5.99905C0.890625 6.06539 0.905777 6.13085 0.934924 6.19044C0.964071 6.25003 1.00644 6.30217 1.05881 6.3429L7.22209 11.1568C7.29455 11.2128 7.39846 11.1622 7.39846 11.0706V10.0138C7.39846 9.9468 7.36701 9.88254 7.31506 9.84153L2.39318 5.99973L7.31506 2.15657C7.36701 2.11555 7.39846 2.0513 7.39846 1.9843Z" fill="black" fill-opacity="0.25"/></svg></span> ';
                }
                if (totalPages <= 5) {
                    for (var i = 1; i <= totalPages; i++) {
                        paginationHtml += '<a href="#" class="page-link ' + (i === currentPage ? 'active' : '') + '" data-page="' + i + '">' + i + '</a> ';
                    }
                } else {
                    paginationHtml += '<a href="#" class="page-link ' + (currentPage === 1 ? 'active' : '') + '" data-page="1">1</a> ';
                    if (currentPage > 3) {
                        paginationHtml += '<span class="ellipsis">...</span> ';
                    }

                    for (var i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                        paginationHtml += '<a href="#" class="page-link ' + (i === currentPage ? 'active' : '') + '" data-page="' + i + '">' + i + '</a> ';
                    }

                    if (currentPage < totalPages - 2) {
                        paginationHtml += '<span class="ellipsis">...</span> ';
                    }

                    paginationHtml += '<a href="#" class="page-link ' + (currentPage === totalPages ? 'active' : '') + '" data-page="' + totalPages + '">' + totalPages + '</a> ';
                }

                // Next arrow
                if (currentPage < totalPages) {
                    paginationHtml += '<a href="#" class="page-link" data-page="' + (currentPage + 1) + '"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.96854 5.65558L0.805274 0.841708C0.789169 0.829029 0.769815 0.82115 0.749434 0.818975C0.729052 0.8168 0.708471 0.820417 0.690053 0.829412C0.671635 0.838407 0.656128 0.852414 0.645312 0.869825C0.634496 0.887236 0.62881 0.907344 0.628907 0.927841V1.98468C0.628907 2.05167 0.660353 2.11593 0.712306 2.15694L5.63417 6.00011L0.712306 9.84327C0.658986 9.88429 0.628907 9.94855 0.628907 10.0155V11.0724C0.628907 11.164 0.734181 11.2146 0.805274 11.1585L6.96854 6.34464C7.02092 6.30378 7.0633 6.25151 7.09245 6.19181C7.12159 6.13211 7.13674 6.06654 7.13674 6.00011C7.13674 5.93367 7.12159 5.86811 7.09245 5.80841C7.0633 5.74871 7.02092 5.69644 6.96854 5.65558Z" fill="black" fill-opacity="0.88"/></svg></a>';
                } else {
                    paginationHtml += '<span class="page-link disabled"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.96854 5.65558L0.805274 0.841708C0.789169 0.829029 0.769815 0.82115 0.749434 0.818975C0.729052 0.8168 0.708471 0.820417 0.690053 0.829412C0.671635 0.838407 0.656128 0.852414 0.645312 0.869825C0.634496 0.887236 0.62881 0.907344 0.628907 0.927841V1.98468C0.628907 2.05167 0.660353 2.11593 0.712306 2.15694L5.63417 6.00011L0.712306 9.84327C0.658986 9.88429 0.628907 9.94855 0.628907 10.0155V11.0724C0.628907 11.164 0.734181 11.2146 0.805274 11.1585L6.96854 6.34464C7.02092 6.30378 7.0633 6.25151 7.09245 6.19181C7.12159 6.13211 7.13674 6.06654 7.13674 6.00011C7.13674 5.93367 7.12159 5.86811 7.09245 5.80841C7.0633 5.74871 7.02092 5.69644 6.96854 5.65558Z" fill="black" fill-opacity="0.25"/></svg></span>';
                }

                $('#pagination').html(paginationHtml);
            }

            $('#pagination').on('click', 'a.page-link', function(e) {
                e.preventDefault();

                var newPage = $(this).data('page');

                if (newPage !== currentPage) {
                    currentPage = newPage;

                    renderTable(currentPage);
                    generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
                }
            });

            // Search functionality
            $('#stock-search').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();

                if (searchTerm === "") {
                    renderTable(currentPage);
                    generatePagination(Math.ceil(allData.length / stocksPerPage), currentPage);
                    return;
                }

                var filteredData = allData.filter(function(stock) {
                    return stock.name.toLowerCase().includes(searchTerm) ||
                        stock.symbol.toLowerCase().includes(searchTerm);
                });

                if (filteredData.length === 0) {
                    $('#stocks-table tbody').html('<tr><td colspan="6">No results found</td></tr>');
                } else {
                    generatePagination(Math.ceil(filteredData.length / stocksPerPage), currentPage);
                    renderFilteredTable(filteredData);
                }
            });


            function renderFilteredTable(data) {
                $('#stocks-table tbody').empty();
                if (data.length === 0) {
                    $('#stocks-table tbody').html('<tr><td colspan="6">No results found</td></tr>');
                    return;
                }

                data.forEach(function(stock) {
                    if(stock.pe_ratio == null) {
                        var peRatio = 'N/A';
                    }
                    else{
                        var peRatio = stock.pe_ratio;
                    }
                    if(stock.cagr_5_year == null) {
                        var cagr_5_year = 'N/A';
                    }
                    else {
                        var cagr_5_year = stock.cagr_5_year + '%';
                    }

                    if(stock.price == null) {
                        var stockPrice = 'N/A';
                    }
                    else {
                        var stockPrice = '$' + stock.price;
                    }

                    if(stock.price_change == null) {
                        var stockPriceChange = 'N/A';
                    }
                    else {
                        var stockPriceChange = (stock.price_change < 0 ? '' : '+') + stock.price_change + '%';
                    }

                    if(stock.one_year_returns == null) {
                        var oneYearReturns = 'N/A';
                    }
                    else {
                        var oneYearReturns = stock.one_year_returns + '%';
                    }

                    var changeClass = '';
                    if(stock.price_change == null || stock.price_change < 0) {
                        changeClass = 'minus_value';
                    }
                    $('#stocks-table tbody').append('<tr><td>' +
                        '<div class="stock_symbol_wrap"><div class="stock_symbol_img"><img src="https://d13dxy5z8now6z.cloudfront.net/symbol/' +
                        stock.symbol + '.png" alt="' + stock.symbol + '-img" /></div>' +
                        '<div class="stock_name"><p>' + stock.name + '</p>' +
                        '<span>(' + stock.symbol + ')</span></div></div></td>' +
                        '<td class="pricing_cols">' + stockPrice +
                        '<strong class="stock_change ' + changeClass + '">' + stockPriceChange + '</strong></td>' +
                        '<td>' + formatMarketCap(stock.market_cap) + '</td>' + // Use the formatting function here
                        '<td>' + peRatio + '</td>' +
                        '<td>'+ oneYearReturns +'</td><td>'+ cagr_5_year +'</td></tr>');
                });
            }
        });
    </script>
<?php
}
add_action('wp_footer', 'enqueue_custom_pagination_script');
