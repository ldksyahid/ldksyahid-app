@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Confusion Matrix Heatmap</h6>
                <div id="heatmap"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Bar Plot</h6>
                <div id="bar-plot"></div>
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
                    title: 'SVM Predicted Dataset Donation Class',
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
                const classLabels = ['0-25k', '26-50k', '51-100k', '101-250k', '>251k'];
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
    fetchConfusionMatrix();
    fetchBarData();
</script>
@endsection
