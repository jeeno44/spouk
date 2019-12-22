<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    function getBaseURL()
    {
        var url = location.href;
        var baseURL = url.substring(0, url.indexOf('/', 14));

        if (baseURL.indexOf('http://localhost') != -1) {
            var url = location.href;
            var pathname = location.pathname;
            var index1 = url.indexOf(pathname);
            var index2 = url.indexOf("/", index1 + 1);
            var baseLocalUrl = url.substr(0, index2);

            return baseLocalUrl + "/";
        }
        else {
            return baseURL + "/";
        }
    }

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart()
    {
        var jsonData = $.ajax({
            url: getBaseURL() + "dynamics-to-chart",
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData);
        var options = {
            title: 'Динамика добавления абитуриентов',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>


@extends('layouts.master')

@section('title')Статистика@stop

@section('content')
    <section>
        <div class="section-body">

         <div id="curve_chart" style="width: 100%; height: 500px"></div>



        </div>
    </section>
@endsection

