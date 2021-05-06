@extends('layout.static')

@section('title', 'Chart')

@section('content')

    <div id="chart" style="width:1200px; height:400px;"></div>


@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/echarts/dist/echarts.min.js') }}"></script>
    <script>
        let chart = echarts.init(document.getElementById('chart'));

        // show title. legend and empty axis
        chart.setOption({
            title: {
                text: 'Scales'
            },
            tooltip: {},
            legend: {
                show: false
            },
            xAxis: {
                data: [],
                axisLabel: {
                    rotate: 90,
                    margin: 8,
                    height: "100%",
                }
            },
            yAxis: {
                min: -2,
                max: 2,
            },
            series: []
        });

        fetch('/api/scales')
            .then(response => response.json())
            .then(json => {

                let labels = json.data.map(item => {
                    return item.value + '-' + item.opposite;
                });

                fetch('/api/survey/13/results')
                    .then(response => response.json())
                    .then(json => {

                        console.log(json.results);
                        let s = [{
                            data: json.results,
                            type: 'scatter'
                        }];

                        chart.setOption({
                            series: s
                        });

                        return;

                        //console.log(json.results);
                        let series = json.results.map(resultSet => {
                            return {
                                type: 'line',
                                data: resultSet
                            };
                        });

                        chart.setOption({series: series});
                    })
                    .catch(error => console.error(error));

                chart.setOption({
                    xAxis: {
                        name: 'Scale',
                        nameRotate: 90,
                        data: labels
                    }
                });





            })
            .catch(error => console.error(error));


        function makeChart() {
            // based on prepared DOM, initialize echarts instance
            var myChart = echarts.init(document.getElementById('main'));
            // specify chart configuration item and data
            var option = {
                title: {
                    text: 'ECharts entry example'
                },
                tooltip: {},
                legend: {
                    data: ['Sales']
                },
                xAxis: {
                    data: ["shirt", "cardign", "chiffon shirt", "pants", "heels", "socks"]
                },
                yAxis: {},
                series: [
                    {
                        name: 'Sales',
                        type: 'line',
                        data: [5, 20, 36, 10, 10, 20]
                    },
                    {
                        name: 'sales2',
                        type: 'line',
                        data: [12, 5, 11, 4, 1, 12]
                    }

                ]
            };

            // use configuration item and data specified to show chart
            myChart.setOption(option);
        }


    </script>
@endsection
