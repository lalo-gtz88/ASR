@extends('layout')
@section('content')
<div class="container py-4">
    <h1 class="display-4">Dashboard</h1>
    <hr>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h4>{{ $chart1->options['chart_title'] }}</h4>
                {!! $chart1->renderHtml() !!}
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <h4>{{ $chart3->options['chart_title'] }}</h4>
                {!! $chart3->renderHtml() !!}
            </div>
            <br>
            <div class="card">
            <h4>{{ $chart5->options['chart_title'] }}</h4>
                {!! $chart5->renderHtml() !!}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h4>{{ $chart2->options['chart_title'] }}</h4>
                {!! $chart2->renderHtml() !!}
            </div>
            <br>
            <div class="card">
                <h4>{{ $chart4->options['chart_title'] }}</h4>
                {!! $chart4->renderHtml() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')

{!! $chart1->renderChartJsLibrary() !!}

{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
{!! $chart4->renderJs() !!}
{!! $chart5->renderJs() !!}


<script>
    setInterval(function(){
        window.location.reload()
    },180000)
</script>

@endsection