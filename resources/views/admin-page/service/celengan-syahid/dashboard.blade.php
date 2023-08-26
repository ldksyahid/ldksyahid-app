@extends('admin-page.template.body')

@section('head')

@endsection

@section('content')
@php
use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Confusion Matrix Heatmap</h6>
                <div id="heatmap"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    // Data matriks kebingungan (contoh)
    const confusionMatrix = [
        [55, 2, 1],
        [3, 49, 0],
        [0, 0, 44]
    ];

    // Label kelas (contoh)
    const classLabels = ['Italy', 'France', 'Spain'];

    // Membuat heatmap menggunakan Plotly
    const heatmapData = [{
        z: confusionMatrix,
        x: classLabels,
        y: classLabels,
        type: 'heatmap',
        colorscale: 'Viridis'
    }];

    const heatmapLayout = {
        title: 'Confusion Matrix Heatmap',
        xaxis: { title: 'Predicted' },
        yaxis: { title: 'Actual' }
    };

    Plotly.newPlot('heatmap', heatmapData, heatmapLayout);
</script>
@endsection
