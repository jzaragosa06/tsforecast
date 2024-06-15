<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Series Forecasting</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Plotly.js -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        body {
            background-color: #cbd5e0;
        }

        .navbar {
            background-color: #2d3748 !important;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .forecast-image {
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            padding: 10px;
            /* Add padding here */

        }

        .form-control {
            background-color: #4a5568;
            color: white;
            border: none;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #357abd;
        }

        .text-muted {
            color: #a0aec0 !important;
        }

        #myChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">TSForecast</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Get Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="time-series-chart"></div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-dark mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Forecast</h4>
                        <p>Forecasted results and explanation...</p>
                        {{-- <div class="forecast-image bg-secondary mb-3" style="height: 200px;"> --}}
                        <div class="forecast-image bg-secondary mb-3" style="height: 200px;">
                            {{-- <div id="myChart" width="800" height="400"></div> --}}
                            {{-- <div id="myChart" style="width: 500px; height: 400px;"></div> --}}
                            <div id="myChart"></div>



                        </div>
                        <p class="card-text">{{ $text_result }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-dark mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Chat</h4>
                        <p>Ask question about the results...</p>
                        <textarea id="responseArea" class="form-control bg-secondary text-white mb-3" rows="10"
                            placeholder="e.g., what is the possible cause of fluctuation in March?"></textarea>
                        <div class="input-group">
                            <input type="text" id="questionInput" class="form-control bg-secondary text-white"
                                placeholder="Question...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="sendButton">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Pass PHP data to JavaScript
        const dates = <?php echo json_encode($dates); ?>;
        const values = <?php echo json_encode($values); ?>;
        const context = <?php echo json_encode($context); ?>;
        const text_result = <?php echo json_encode($text_result); ?>;


        console.log(dates);
        console.log(values);

        // Create a trace object
        const trace = {
            x: dates,
            y: values,
            mode: 'lines+markers',
            type: 'scatter',
            line: {
                color: '#FF5733' // Change this to your desired line color
            }
        };

        // Define layout
        const layout = {
            autosize: true,
            width: 475,
            height: 200,
            margin: {
                l: 50,
                r: 50,
                b: 50,
                t: 50,
                pad: 4
            },
            xaxis: {
                color: '#FFFFFF' // Change this to your desired x-axis color
            },
            yaxis: {
                title: 'Value',
                color: '#FFFFFF' // Change this to your desired y-axis color
            },
            plot_bgcolor: 'rgba(0,0,0,0)', // Transparent plot area background
            paper_bgcolor: 'rgba(0,0,0,0)' // Transparent paper background


        };

        Plotly.newPlot('myChart', [trace], layout);
        // Plotly.newPlot('time-series-chart', [trace], layout);



        //CHAT--------------------------------------------
        document.getElementById('sendButton').addEventListener('click', function() {
            const question = document.getElementById('questionInput').value;
            fetch('http://localhost:5000/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        question: question,
                        context: context,
                        text_result: text_result,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseArea').value = data.response;
                })
                .catch(error => console.error('Error:', error));
        });
        //------------------------------------------------
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
