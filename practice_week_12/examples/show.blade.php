@extends('layout.app')

@section('title', 'Research Report')

@section('content')

    <h1 class="ui header">{{ $research->name }}</h1>


    <div id="chart"></div>


    <div class="ui two column grid">

        @foreach($research->surveys as $survey)
            <div class="column">
                <h2>{{ $survey->name }}</h2>
                {{ $survey->items }}
            </div>
        @endforeach


    </div>




@endsection

@section('styles')
    <style>
        #chart {
            width: 600px;
            height: 1000px;
        }
    </style>
@endsection

@section('scripts')
    @parent


    <script src="{{ asset('assets/vendor/echarts/dist/echarts.min.js') }}"></script>

    <script>

        let dataset = {
            source: []
        };


        let s, ovalues;
        @foreach($research->surveys as $survey)
            s = @json($survey->items);
            console.log(s);

            ovalues = Object.values(s);
            dataset.source.push(ovalues);
        @endforeach
            

        let chart = echarts.init(document.getElementById('chart'));
        let labels = [], opposites = [], values = [];

        fetch('/api/scales')
            .then(response => response.json())
            .then(json => {
                json.data.map(item => {
                    labels.push(item.value);
                    opposites.push(item.opposite);
                });

                console.log(dataset);

                dataset.dimensions = labels;

                drawChart();
            })
            .catch(error => console.error(error));

        function drawChart() {
            let options = {
                dataset: dataset,
                xAxis: {
                    min: -1,
                    max: 1,
                    interval: .1
                },
                yAxis: [
                    {
                        type: 'category',
                        data: labels,
                        position: 'left'
                    },
                    {
                        type: 'category',
                        data: opposites,
                        position: 'right'
                    }
                ],
                series: [
                    {type: 'bar'},
                    {type: 'bar'}
                ]
            }

            chart.setOption(options);
        }









    </script>






@endsection