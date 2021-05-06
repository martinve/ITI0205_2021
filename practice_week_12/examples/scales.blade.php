@extends('layout.app')
@section('title', '3D');

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/echarts/dist/echarts.js') }}"></script>
    <script src="{{ asset('assets/js/lib/echarts-gl/echarts-gl.js') }}"></script>

    <script>

        let myChart = echarts.init(document.getElementById("chart"));
        var app = {};
        option = null;


        let scaleAttributes = {
            min: -1, max: 1, step: .1,
            nameTextStyle: {
                fontSize: 12
            },
            axisLine: {
                lineStyle: {
                    opacity: 0
                }
            },
            nameGap: 20,
            scale: true
        };

        let dimensions = ['Evaluation', 'Potency', 'Activity'];

        let sx = Object.assign({name: dimensions[0]}, scaleAttributes);
        let sy = Object.assign({name: dimensions[1]}, scaleAttributes);
        let sz = Object.assign({name: dimensions[2]}, scaleAttributes);


        let seriesAttributes = {
            type: 'scatter3D',
            symbolSize: 12,
            label: {
                show: true,
                formatter: '{a}'
            },
            encode: {
                x: 'Evaluation',
                y: 'Potency',
                z: 'Activity',
                tooltip: 4
            },
            //name: 'Empty',
            //data: []
        };


        draw();


        function draw() {

            fetch('/api/scale-items')
                .then(response => response.json())
                .then(data => {

                    let mySeries = [];
                    let record = {};

                    data.forEach(item => {
                        record = Object.assign({name: item[0], data: [item[1], item[2], item[3]]}, seriesAttributes);
                        mySeries.push(record);
                    });

                    console.log(mySeries[0].data, mySeries[0].name);



                    option = {
                        grid3D: {
                            boxWidth: 80,
                            boxHeigt: 80,
                            viewControl: {
                                distance: 250,
                                alpha: 40,
                                beta: 20
                            },
                            axisTick: {
                                show: false,
                            },
                            axisPointer: {
                                lineStyle: {
                                    opacity: .2
                                }
                            },
                            splitArea: true
                        },
                        xAxis3D: sx,
                        yAxis3D: sy,
                        zAxis3D: sz,
                        series: mySeries
                    };

                    myChart.setOption(option);
                });


        }
    </script>
@endsection

@section('content')
    <h1 class="ui header">3D Scatterplot</h1>
    <div id="chart"></div>
@endsection


@section('styles')
    <style>
        #chart {
            width: 600px;
            height: 600px;
            background: #ececec;
        }
    </style>
@endsection