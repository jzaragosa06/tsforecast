<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Time Series Chart with Plotly</title>
    <!-- Include Plotly.js -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body>
    <div id="time-series-chart"></div>

    <script>
        // Sample time series data
        const dates = ['2024-01-01', '2024-02-01', '2024-03-01', '2024-04-01', '2024-05-01'];
        const values = [32, 45, 28, 49, 36];

        // Create a trace object
        const trace = {
            x: dates,
            y: values,
            mode: 'lines+markers',
            type: 'scatter'
        };

        // Define layout
        const layout = {
            title: 'Time Series Chart',
            xaxis: {
                title: 'Date'
            },
            yaxis: {
                title: 'Value'
            }
        };

        // Create the chart
        Plotly.newPlot('time-series-chart', [trace], layout);
    </script>
</body>

</html>
