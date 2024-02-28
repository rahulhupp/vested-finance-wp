<script defer>
    document.querySelectorAll('.trend_chart').forEach(function(cell) {
        var trendData = JSON.parse(cell.textContent);
        if (trendData.length > 0) {
            cell.textContent = '';
            var chartContainer = document.createElement('div');
            cell.appendChild(chartContainer);
            var canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 400;
            chartContainer.appendChild(canvas);
            var dates = [];
            var values = [];
            trendData.forEach(function(trend) {
                dates.push(trend.date);
                values.push(trend.value);
            });
            // Create a chart
            var ctx = canvas.getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Values',
                        data: values,
                        borderWidth: 1,
                        backgroundColor: values.map(item => item < 0 ? "#b92406" : "#008a5a"),
                        borderColor: values.map(item => item < 0 ? "#b92406" : "#008a5a"),
                    }]
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
        }
    });

    const valueTypeSelect = document.getElementById("value_type_select");
    const dataTypeSelect = document.getElementById("data_type_select");

    valueTypeSelect.addEventListener("change", handleSelectChange);
    dataTypeSelect.addEventListener("change", handleSelectChange);

    // Ensure that annual_absolute is shown by default for each data_display
    const initialDisplays = document.querySelectorAll(".data_display");
    initialDisplays.forEach(display => {
        const defaultDisplay = display.querySelector(".annual_absolute");
        defaultDisplay.classList.remove("hidden");
    });

    function handleSelectChange() {
        const valueType = valueTypeSelect.value;
        const dataType = dataTypeSelect.value;

        // Hide all divs first
        hideAllDivs();

        // Determine which divs to show based on selected values for each data_display
        const dataDisplays = document.querySelectorAll(".data_display");
        dataDisplays.forEach(display => {
            const divToShow = display.querySelector(`.${dataType}_${valueType}`);
            if (divToShow) {
                divToShow.classList.remove("hidden");
            }
        });
    }

    function hideAllDivs() {
        const allDisplays = document.querySelectorAll(".data_display .stock_details_table");
        allDisplays.forEach(display => {
            display.classList.add("hidden");
        });
    }

</script>

