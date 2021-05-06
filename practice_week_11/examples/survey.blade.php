@extends('layout.app')
@section('title', 'Visualize Survey');

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/echarts/dist/echarts.js') }}"></script>

    <script>

        let myChart = echarts.init(document.getElementById("chart"));
        let labels = [];
        let opposites = [];
        let series = [];

        let options = {
            name: 'Pepsi vs Coca-Cola',
            grid: {
                containLabel: true,
                top: 30,
                bottom: 0,
            },
            legend: {
                show: true
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

       loadScaleData()
           .then(() => loadSurveyData(8))
           .then(() => loadSurveyData(31))
           .then(() => initAxes())
           .then(() => drawChart())
        ;


        function initAxes() {
            return new Promise(resolve => {
                resolve();
            });
        }



        function loadSurveyData(id) {

            return new Promise(resolve => {
                fetch(`/api/survey/${id}/summary`)
                    .then(response => response.json())
                    .then(json => {
                        options.dataset.source[json.name] = json.values;
                        options.series.push({
                            type: 'line',
                            smooth: .1,
                            showSymbol: false,
                            lineStyle: { width: 1 }
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
                min: -1,
                max: 1,
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
                min: -1,
                max: 1,
                type: 'value',
                position: 'top',
                axisTick: {inside: true},
                splitLine: {show: false}
            }];


            myChart.setOption(options);

            console.log(options.dataset.source);
            console.log(options.series);
        }


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


{{--
function f() {
            let ds = {
                dimensions: ['Name', '2010', '2011', '2012'],
                source: [
                    ['Matcha Latte', 43.3, 85.8, 93.7],
                    ['Milk Tea', 83.1, 73.4, 55.1],
                    ['Cheese Cocoa', 86.4, 65.2, 82.5],
                    ['Walnut Brownie', 72.4, 53.9, 39.1]
                ]
            };


            let ds2 = {
                source: {
                    'product': ['Matcha Latte', 'Milk Tea', 'Cheese Cocoa', 'Walnut Brownie'],
                    'count': [823, 235, 1042, 988],
                    'score': [95.8, 81.4, 91.2, 76.9],
                },
                dimensions2: ['Beer', 'Vodka', 'Cheese', 'Cucumber']
            }


            ds = ds2;


            options = {
                grid: {
                    containLabel: true
                },
                legend: {},
                tooltip: {},
                dataset: ds,
                // Declare X axis, which is a category axis, mapping
                // to the first column by default.
                xAxis: {},
                // Declare Y axis, which is a value axis.
                yAxis: [
                    {
                        type: 'category'
                    },
                    {
                        data: ds.dimensions2,
                        type: 'category',
                        positon: 'right'
                    }
                ],
                // Declare several series, each of them mapped to a
                // column of the dataset by default.
                series: [
                    {type: 'bar'},
                    {type: 'line'},
                    {type: 'bar'}
                ]
            };


            myChart.setOption(options);
        }--}}