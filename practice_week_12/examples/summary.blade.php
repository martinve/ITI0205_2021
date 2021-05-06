@extends('layout.app')

@section('title', 'Survey Summary')

@section('content')

    <h1 class="ui left floated header">Summary: {{ $survey->name }}</h1>
    <a class="ui right floated small positive button" href="{{ admin_url('surveys/' . $survey->id . '/results') }}">Result Breakdown</a>

    <div class="ui hidden clearing divider"></div>

    <div class="ui info message">
        <strong>Strength:</strong> {{ f2($survey->strength) }}
    </div>

    <div class="ui two column grid">
        <div class="column">
            <table class="ui striped compact tablet stackable green table">
                <thead>
                <tr>
                    <th>Attribute</th>
                    <th class="right aligned">Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($survey->normalized as $key => $metric)
                    @php($scale = $scales->where('id', $key)->first())
                    <tr>
                        <td>
                            {{ $metric['item']->name }}
                        </td>
                        <td class="right aligned">{{ abs(f3($metric['normalized'])) }}</td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        <div class="column">
            <div id="chart"></div>
        </div>
    </div>


@endsection

@section('styles')
    @parent
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


        let summary = @json($summary);

        let chart = echarts.init(document.getElementById('chart'));
        let labels = [], values = [];

        function showChart() {

            Object.entries(summary).forEach(entry => {
                labels.push(entry[0]);
                values.push(entry[1]);
            });


            let option = {
                tooltip: {
                    trigger: 'item'
                },
                title: {
                    show: false
                },
                legend: {
                    show: true
                },
                yAxis: {
                    inverse: true,
                    type: 'category',
                    data: labels
                },
                xAxis: {
                    type: 'value',
                    min: 0,
                    max: 1,
                    interval: .1
                },
                series: [{
                    data: values,
                    type: 'line'
                },{
                    data: values,
                    type: 'line'
                }]
            };

            chart.setOption(option);
        }


        //showChart()

        fetch('/api/survey/5/summary')
            .then(response => response.json())
            .then(json => {
                console.log(json);
                showChart();
            })
            .catch(error => console.error(error));




    </script>


@endsection