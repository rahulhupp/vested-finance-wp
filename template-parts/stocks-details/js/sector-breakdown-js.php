
<script>
    // Extract data from the table
    const tableRows = document.querySelectorAll('#sectorBreakdownTable tbody tr');
    const sectors = [];
    const weights = [];
    const backgroundColors = [];
    const borderColors = [];

    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td'); // Selecting cells (td elements) inside each row
        if (cells.length === 2) { // Ensure that each row has exactly two cells
            const colorSpan = cells[0].querySelector('.sector_breakdown_name span');
            const sectorName = cells[0].textContent.trim().replace(colorSpan.textContent.trim(), '');
            sectors.push(sectorName);
            weights.push(parseFloat(cells[1].textContent.trim().replace('%', '')));
            backgroundColors.push(colorSpan.style.backgroundColor);
            borderColors.push(colorSpan.style.backgroundColor);
        }
    });

    // Create doughnut chart
    const ctx = document.getElementById('sectorBreakdownChart').getContext('2d');
        
    const sectorBreakdownChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: sectors,
            datasets: [{
                label: 'Sector Weight',
                data: weights,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Hide legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            const value = context.parsed.toFixed(2);
                            return label + value + '%';
                        }
                    }
                }
            },
            title: {
                display: true,
                text: 'Sector Weights'
            }
        }
    });
</script>