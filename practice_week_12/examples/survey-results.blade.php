@extends('layout.app')
@section('title', 'Visualize Survey Results');

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/echarts/dist/echarts.js') }}"></script>


    <script>

        let myChart = echarts.init(document.getElementById("chart"));
        let labels = [];
        let opposites = [];
        let series = [];


        function addLineSeries() {
            options.series.push({
                type: 'line',
                smooth: .5,
                showSymbol: false,
                lineStyle: { width: 1 }
            });
        }



        let options = {
            name: 'Pepsi vs Coca-Cola',
            grid: {
                containLabel: true,
                top: 30,
                bottom: 0,
            },
            legend: {
                show: false
            },
            dataset: {
                source: {}
            },
            series: []
        };


        loadScaleData = function () {
            return new Promise(resolve => {
                fetch('/api/scales')
                    .then(response => response.json())
                    .then(json => {

                        let data = json.data;

                        labels = data.map(item => {
                            return item.value
                        });
                        opposites = data.map(item => {
                            return item.opposite
                        });
                        options.dataset.source.labels = labels;
                        resolve();
                    })
                    .catch(err => console.error(err));
            });
        }

        //3, 13




        function initAxes() {
            return new Promise(resolve => {
                resolve();
            });
        }



        function loadSurveyResults(id) {
            return new Promise(resolve => {
                fetch(`/api/survey/${id}/results`)
                    .then(response => response.json())
                    .then(json => {
                        json.results.forEach((result, i) => {
                            options.dataset.source['series-' + i] = result;
                            addLineSeries();
                        });



                        resolve();
                    })
                    .catch(err => console.error(err));
            });
        }


        function drawChart() {

            options.tooltip = {
                trigger: 'axis',
                confine: true,
                transitionDuration: 0.2,
                backgroundColor: '#333',
                textStyle: {
                    fontSize: 11
                },
                borderRadius: 0,
                formatter: function(value) {
                    value = value[0].data[1];
                    return Math.round(value * 100) / 100;
                }
            };

            options.yAxis = [
                {
                    type: 'category',
                    boundaryGap: false,
                    data: labels,
                    position: 'left',
                    inverse: true,
                    nameLocation: 'start',
                    nameGap: 5,
                    axisLine: {
                        onZero: false
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            type: 'dotted',
                            color: '#d9d9d9'
                        }
                    },
                    axisTick: {
                        length: 3
                    }
                },
                {
                    type: 'category',
                    boundaryGap: false,
                    data: opposites,
                    position: 'right',
                    inverse: true,
                    nameLocation: 'start',
                    nameGap: 5,
                    axisLine: {
                        onZero: false
                    },
                    splitLine: {
                        show: false
                    },
                    axisTick: {
                        length: 3
                    }
                }
            ];

            options.xAxis = [{
                type: 'value',
                axisTick: {inside: true},
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#d9d9d9',
                        type: 'dotted'
                    }

                }
            }, {
                type: 'value',
                position: 'top',
                axisTick: {inside: true},
                splitLine: {show: false}
            }];


            myChart.setOption(options);


            console.log(options.series);
        }








        loadScaleData()
            .then(() => loadSurveyResults(5))
            .then(() => initAxes())
            .then(() => drawChart())
        ;


    </script>


@endsection

@section('content')
    <h1 class="ui header">Visualize Survey</h1>
    <div id="chart"></div>
@endsection


@section('styles')
    <style>
        #chart {
            width: 400px;
            height: 660px;
            background: #fcfcfe;
        }
    </style>
@endsection
