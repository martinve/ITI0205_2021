@extends('layout.app')
@section('title', 'Survey Punch')


@section('content')
    <h1 class="ui header">Visualize Survey</h1>
    <div id="chart"></div>
@endsection


@section('styles')
    <style>
        #chart {
            width: 600px;
            height: 800px;
            background: #fcfcfe;
        }
    </style>
@endsection


@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/echarts/dist/echarts.js') }}"></script>

    <script>


        let scales = {!! $scales !!};

        let values = [3, 2, 1, -1, -2, -3];

        let results = @json($results);


        results = results.map((item) => {
            return item.map((value, index) => {
                return [value, index, 2];
            });
        });

        console.log(results);

        option = {
            title: {
                text: '{{ $survey->name }}',
                link: 'https://github.com/pissang/echarts-next/graphs/punch-card'
            },
            legend: {
                data: ['Punch Card'],
                left: 'right'
            },
            grid: {
                left: 10,
                bottom: 10,
                right: 10,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: values,
                boundaryGap: false,
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#999',
                        type: 'dashed'
                    }
                },
                axisLine: {
                    show: false
                }
            },
            yAxis: {
                type: 'category',
                data: scales,
                axisLine: {
                    show: false
                }
            },
            series: [{
                name: 'Punch Card',
                type: 'scatter',
                data: results
            }]
        };


        let myChart = echarts.init(document.getElementById("chart"));
        myChart.setOption(option);

    </script>


@endsection