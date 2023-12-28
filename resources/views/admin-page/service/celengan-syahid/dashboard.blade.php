@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-light rounded h-100 p-4">
                <div id="bar-plot"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-light rounded h-100 p-4">
                <div id="age-pie-chart"></div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="bg-light rounded h-100 p-4">
                <div id="bar-plot-2"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    function fetchBarData() {
        fetch('/machine-learning/output/bar_plot_donation_class.json')
            .then(response => response.json())
            .then(data => {
                const classCounts = data.class_counts;

                const donationCategories = {
                    'Low (0 - 25k)': classCounts[0],
                    'Moderately Low (26k - 50k)': classCounts[1],
                    'Moderate (51k - 100k)': classCounts[2],
                    'Moderately High (101k - 250k)': classCounts[3],
                    'High (> 251k)': classCounts[4]
                };

                // Mendapatkan nilai donasi dalam urutan yang diinginkan
                const sortedCounts = Object.values(donationCategories);
                const sortedCategories = Object.keys(donationCategories);

                const barData = [{
                    x: sortedCategories,
                    y: sortedCounts,
                    type: 'bar',
                    marker: {
                        color: ['rgba(173, 216, 230, 0.7)', 'rgba(144, 238, 144, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(255, 165, 0, 0.7)', 'rgba(255, 69, 132, 0.7)'],
                        // Gunakan warna yang berbeda untuk setiap kategori donasi
                    },
                    name: 'Bar Plot',
                    hoverinfo: 'text',
                    text: sortedCounts.map(String),
                    textposition: 'inside',
                    hoverlabel: {
                        bgcolor: 'white',
                        bordercolor: 'black',
                        font: {
                            color: 'black'
                        }
                    }
                }];

                const barLayout = {
                    title: 'Donation Class',
                    xaxis: {
                        title: 'Donation Category'
                    },
                    yaxis: {
                        title: 'Donor Count'
                    },
                    margin: {
                        t: 50,
                        b: 120,
                        l: 50,
                        r: 60
                    }
                };

                Plotly.newPlot('bar-plot', barData, barLayout);
            })
            .catch(error => console.error('Error fetching bar plot data:', error));
    }
    fetchBarData();
</script>

<script>
    function fetchPieChartData() {
        fetch('/machine-learning/output/pie_chart_age_category_counts.json')
            .then(response => response.json())
            .then(data => {
                const ageLabels = Object.keys(data);
                const ageCounts = Object.values(data);

                const categoryOrder = [
                    'Children (5-11 years old)',
                    'Teenagers (12-25 years old)',
                    'Adults (26-45 years old)',
                    'Elderly (46-65 years old)',
                    'Other Ages'
                ];

                const sortedAgeData = categoryOrder.reduce((acc, label) => {
                    const index = ageLabels.indexOf(label);
                    if (index !== -1) {
                        acc.labels.push(label);
                        acc.values.push(ageCounts[index]);
                    }
                    return acc;
                }, {
                    labels: [],
                    values: []
                });

                const pieData = [{
                    labels: sortedAgeData.labels,
                    values: sortedAgeData.values,
                    type: 'pie',
                    marker: {
                        colors: ['rgba(173, 216, 230, 0.7)', 'rgba(144, 238, 144, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(255, 165, 0, 0.7)', 'rgba(255, 69, 132, 0.7)']
                        // Gunakan warna yang berbeda untuk setiap kategori usia
                    },
                    hole: 0.4 // Bagian tengah yang kosong untuk efek donat
                }];

                const pieLayout = {
                    title: 'Percentage of Donors Based on Age Category',
                    legend: {
                        x: 1,
                        y: 0.5,
                        traceorder: 'normal',
                        font: {
                            family: 'Arial',
                            size: 12,
                            color: '#000'
                        },
                        categoryorder: 'array',
                        categoryarray: categoryOrder
                    },
                };

                Plotly.newPlot('age-pie-chart', pieData, pieLayout);
            })
            .catch(error => console.error('Error fetching pie chart data:', error));
    }
    fetchPieChartData();
</script>

<script>
    function fetchBarData2() {
        fetch('/machine-learning/output/bar_plot_count_age_donation.json')
            .then(response => response.json())
            .then(data => {
                const ageCategories = data.age_category;
                const donationCategories = data.donation_category;
                const donorCounts = data.donor_count;

                const colors = ['rgba(173, 216, 230, 0.7)', 'rgba(144, 238, 144, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(255, 165, 0, 0.7)', 'rgba(255, 69, 132, 0.7)'];

                const dataDict = {};
                const order = ['Low (0 - 25k)', 'Moderately Low (26k - 50k)', 'Moderate (51k - 100k)', 'Moderately High (101k - 250k)', 'High (> 251k)'];
                const categoryOrder = [
                    'Children (5-11 years old)',
                    'Teenagers (12-25 years old)',
                    'Adults (26-45 years old)',
                    'Elderly (46-65 years old)',
                    'Other Ages'
                ];

                for (let i = 0; i < ageCategories.length; i++) {
                    const ageCategory = ageCategories[i];
                    const donationCategory = donationCategories[i];
                    const donorCount = donorCounts[i];

                    if (!dataDict[donationCategory]) {
                        dataDict[donationCategory] = {
                            x: [],
                            y: [],
                            type: 'bar',
                            name: donationCategory,
                            textposition: 'auto',
                            text: []
                        };
                    }

                    dataDict[donationCategory].x.push(ageCategory);
                    dataDict[donationCategory].y.push(donorCount);
                    dataDict[donationCategory].text.push(donorCount);
                }
                console.log(dataDict);
                const orderedBarData = order.map(category => dataDict[category]);

                // Filter out undefined values (categories that are not present in the data)
                const validBarData = orderedBarData.filter(bar => bar !== undefined && bar.x.length > 0);

                validBarData.forEach((bar, index) => {
                    // Check if bar is defined and has valid data before setting properties
                    if (bar && bar.x.length > 0) {
                        bar.marker = {
                            color: colors[index % colors.length]
                        };
                        bar.hoverinfo = 'name';
                    }
                });

                const barLayout = {
                    barmode: 'group',
                    title: 'Donor Counts by Age and Donation Category',
                    xaxis: {
                        title: 'Age Category',
                        categoryorder: 'array',
                        categoryarray: categoryOrder,
                        automargin: true
                    },
                    yaxis: {
                        title: 'Donor Count'
                    },
                    legend: {
                        title: {
                            text: 'Donation Category'
                        }
                    },
                    margin: {
                        t: 50,
                        b: 100,
                        l: 50,
                        r: 50
                    },
                    transition: {
                        duration: 500,
                        easing: 'cubic-in-out'
                    }
                };

                Plotly.newPlot('bar-plot-2', validBarData, barLayout);
            })
            .catch(error => console.error('Error fetching bar plot 2 data:', error));
    }
    fetchBarData2();
</script>

@endsection