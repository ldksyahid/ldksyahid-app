@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Confusion Matrix Heatmap</h6>
                <div id="heatmap"></div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Bar Plot</h6>
                <div id="bar-plot"></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Scatter Plot</h6>
                <div id="scatter-plot"></div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Pie Chart</h6>
                <div id="pie-chart"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    function fetchConfusionMatrix() {
        fetch('/svm-machine-output/confusion_matrix.json')
            .then(response => response.json())
            .then(data => {
                const classLabels = ['4', '3', '2', '1', '0'];
                const heatmapData = [{
                    z: data,
                    x: classLabels,
                    y: classLabels,
                    type: 'heatmap',
                    colorscale: 'Viridis'
                }];

                const annotations = [];
                for (let i = 0; i < classLabels.length; i++) {
                    for (let j = 0; j < classLabels.length; j++) {
                        annotations.push({
                            x: classLabels[j],
                            y: classLabels[i],
                            text: data[i][j],
                            showarrow: false,
                        });
                    }
                }

                const heatmapLayout = {
                    title: 'SVM Predicted Donation Class',
                    xaxis: { title: 'Predicted' },
                    yaxis: { title: 'Actual' },
                    annotations: annotations
                };
                Plotly.newPlot('heatmap', heatmapData, heatmapLayout);
            })
            .catch(error => console.error('Error fetching confusion matrix data:', error));
    }

    function fetchBarData() {
        fetch('/svm-machine-output/bar_plot_data.json')
            .then(response => response.json())
            .then(data => {
                const classLabels = data.class_labels;
                const classCounts = data.class_counts;

                const barData = [{
                    x: classLabels,
                    y: classCounts,
                    type: 'bar',
                    marker: {
                        color: 'green'
                    },
                    name: 'Bar Plot'
                }];

                const barLayout = {
                    title: 'SVM Predicted Donation Class',
                    xaxis: { title: 'Donation Class' },
                    yaxis: { title: 'Frequency' }
                };

                Plotly.newPlot('bar-plot', barData, barLayout);
            })
            .catch(error => console.error('Error fetching bar plot data:', error));
    }

    function fetchScatterData() {
        fetch('/svm-machine-output/scatter_data.json')
            .then(response => response.json())
            .then(data => {
                const scatterData = [{
                    x: data.x,
                    y: data.y,
                    mode: 'markers',
                    type: 'scatter',
                    marker: {
                        size: 10,
                        color: 'blue'
                    },
                    name: 'Donatur Data'
                }];

                const scatterLayout = {
                    title: 'Relationship Age and Donation Class',
                    xaxis: { title: 'Age' },
                    yaxis: { title: 'Donation Class' },
                    showlegend: true,
                    legend: {
                        x: 0.5,
                        y: 1.15,
                        orientation: 'h'
                    }
                };

                Plotly.newPlot('scatter-plot', scatterData, scatterLayout);
            })
            .catch(error => console.error('Error fetching scatter plot data:', error));
    }

    function fetchPieChart() {
        fetch('/svm-machine-output/payment_method_data.json')
            .then(response => response.json())
            .then(data => {
                const pieData = [{
                    values: data.payment_counts,
                    labels: data.payment_methods,
                    type: 'pie',
                    marker: {
                        colors: ['red', 'orange', 'yellow', 'green', 'blue']
                    },
                    name: 'Pie Chart'
                }];

                const pieLayout = {
                    title: 'Distribution of Payment Methods'
                };

                Plotly.newPlot('pie-chart', pieData, pieLayout);
            })
            .catch(error => console.error('Error fetching payment method data:', error));
    }
fetchPieChart();
fetchConfusionMatrix();
fetchScatterData();
fetchBarData();

</script>
@endsection
