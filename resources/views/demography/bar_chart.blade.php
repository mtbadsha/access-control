@extends('layouts.layout')
@section('header')
<link href="{{URL::asset('date/jquery.ui.all.css')}}" rel="stylesheet" type="text/css">
<style>
    .navbar-top-links li a
    {
        padding: 5px;
        min-height: 5px;
    }
</style>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header acl_page_header">Employee Trending</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Employee Trending Search</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data" action="{{URL::to('/employeetrending')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="form_table">
                        <tr>
                            <td>Date From</td>
                            <td>:</td>
                            <td><input name="from" class="monthPicker form-control" value="{{ $from}}"></td>
                            <td>&nbsp;</td>
                            <td>Date To</td>
                            <td>:</td>
                            <td><input name="to" class="monthPicker form-control" value="{{ $to}}"></td>
                            <td>&nbsp;</td>
                            <td>Type</td>
                            <td>:</td>
                            <td>
                                <select name="type" class="form-control">
                                    <option value="" >Select Type</option>
                                    <option value="yearly" <?php if ($type == 'yearly') echo "selected"; ?> >Yearly</option>
                                    <option value="monthly" <?php if ($type == 'monthly') echo "selected"; ?>>Monthly</option>
                                </select>
                            </td>
                            <td>&nbsp;</td>                            
                            <td><button type="submit" class="btn btn-primary"> Show </button></td>
                        </tr>                        
                    </table>
                </form>
            </div>
        </div>
    </div>        
</div>
@if ($graph_data != '0')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Regular Employee Trending</div>
            <div class="panel-body">
                <div     id="tabs">
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="#bar_chart">Bar Chart</a></li>
                        <li><a href="#line_chart">Line Chart</a></li>                        
                    </ul>

                    <div style="width: 100%; height: 320px;" id="bar_chart"></div>
                    <div style="width: 100%; height: 320px;" id="line_chart"></div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($graph_data_contractual != '0')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Contractual Employee Trending</div>
            <div class="panel-body">

                <div     id="tabs2">
                    <ul class="nav navbar-top-links navbar-left tab-change">
                        <li><a href="#bar_chart_contractual">Bar Chart</a></li>
                        <li><a href="#line_chart_contractual">Line Chart</a></li>
                    </ul>

                    <div style="width: 100%; height: 320px;" id="bar_chart_contractual"></div>
                    <div style="width: 100%; height: 320px;" id="line_chart_contractual"></div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@endsection

@section('footer')
<script src="{{URL::asset('date/jquery.ui.core.js')}}"></script>
<script src="{{URL::asset('date/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('date/jquery.ui.datepicker.js')}}"></script>
<script src="{{URL::asset('date/jquery-ui1.14.js')}}"></script>
<script src="{{asset('assets/amcharts/amcharts.js')}}"></script>
<script src="{{asset('assets/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/amcharts/serial.js') }}" type="text/javascript"></script>



<script>
$(function () {
    $('.monthPicker').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        minDate: new Date(2011, 1 - 1, 1),
        maxDate: new Date()
    }).focus(function () {
        var thisCalendar = $(this);
        $('.ui-datepicker-calendar').detach();
        $('.ui-datepicker-close').click(function () {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            thisCalendar.datepicker('setDate', new Date(year, month, 1));
        });
    });
});
// bar graph for regular employee

var chart;

var chartData1 = <?php echo $graph_data ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData1;
    chart.categoryField = "period";
    chart.depth3D = 20;
    chart.angle = 50;

    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.axisColor = "#DADADA";
    categoryAxis.fillAlpha = 1;
    categoryAxis.gridAlpha = 0;
    categoryAxis.fillColor = "#FAFAFA";
    categoryAxis.title = "Time Period";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisColor = "#DADADA";
    valueAxis.title = "Numbe of Employee";
    valueAxis.gridAlpha = 0.1;
    chart.addValueAxis(valueAxis);

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.title = "period";
    graph.valueField = "total";
    graph.type = "column";
    graph.balloonText = "Headcount in [[period]]:[[total]]";
    graph.lineAlpha = 0;
    graph.fillColors = "#3399FF";
    graph.fillAlphas = 1;
    graph.labelText = "[[total]]";
    graph.color = "#000000";
    graph.fontSize = "14";
    chart.addGraph(graph);

    chart.creditsPosition = "top-left";

    // WRITE
    chart.write("bar_chart");
});

// Line Graph for regular 
var chart;
var graph;

var chartData = <?php echo $graph_data ?>;
AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();

    chart.dataProvider = chartData;
    //chart.marginLeft = 10;
    chart.categoryField = "period";
    chart.dataDateFormat = "YYYY-MM";

    // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
    // chart.addListener("dataUpdated", zoomChart);

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
    categoryAxis.minPeriod = "MM"; // our data is yearly, so we set minPeriod to YYYY
    categoryAxis.dashLength = 3;
    categoryAxis.minorGridEnabled = true;
    categoryAxis.minorGridAlpha = 0.1;

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.inside = true;
    valueAxis.dashLength = 3;
    chart.addValueAxis(valueAxis);

    // GRAPH
    graph = new AmCharts.AmGraph();
    graph.type = "smoothedLine"; // this line makes the graph smoothed line.
    graph.lineColor = "#d1655d";
    graph.negativeLineColor = "#637bb6"; // this line makes the graph to change color when it drops below 0
    graph.bullet = "round";
    graph.bulletSize = 14;
    graph.bulletBorderColor = "#FFFFFF";
    graph.bulletBorderAlpha = 1;
    graph.bulletBorderThickness = 2;
    graph.lineThickness = 2;
    graph.valueField = "total";
    graph.balloonText = "[[period]]<br><b><span style='font-size:14px;'>[[total]]</span></b>";
    graph.labelText = "[[total]]";
    chart.addGraph(graph);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorAlpha = 0;
    chartCursor.cursorPosition = "mouse";
    chartCursor.categoryBalloonDateFormat = "MM";
    chart.addChartCursor(chartCursor);

    

    // WRITE
    chart.write("line_chart");
});

// graph for Contractual employee
var chart;

var chartData2 = <?php echo $graph_data_contractual ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData2;
    chart.categoryField = "period";
    chart.depth3D = 20;
    chart.angle = 50;

    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.axisColor = "#3399FF";
    categoryAxis.fillAlpha = 1;
    categoryAxis.gridAlpha = 0;
    categoryAxis.fillColor = "#FAFAFA";
    categoryAxis.title = "Time Period";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisColor = "#DADADA";
    //valueAxis.title = "Income in millions, USD";
    valueAxis.title = "Number Of Employees";
    valueAxis.gridAlpha = 0.1;
    chart.addValueAxis(valueAxis);

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.title = "period";
    graph.valueField = "total";
    graph.type = "column";
    graph.balloonText = "Headcount in [[period]]:[[total]]";
    graph.lineAlpha = 0;
    graph.fillColors = "#3399FF";
    graph.fillAlphas = 1;
    graph.labelText = "[[total]]";
    graph.color = "#000000";
    graph.fontSize = "14";
    chart.addGraph(graph);

    chart.creditsPosition = "top-left";

    // WRITE
    chart.write("bar_chart_contractual");
});



// Line Graph for regular
var chart;
var graph;

var chartData3 = <?php echo $graph_data_contractual ?>;
AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();

    chart.dataProvider = chartData3;
    //chart.marginLeft = 10;
    chart.categoryField = "period";
    chart.dataDateFormat = "YYYY-MM";

    // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
    // chart.addListener("dataUpdated", zoomChart);

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
    categoryAxis.minPeriod = "MM"; // our data is yearly, so we set minPeriod to YYYY
    categoryAxis.dashLength = 3;
    categoryAxis.minorGridEnabled = true;
    categoryAxis.minorGridAlpha = 0.1;

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.inside = true;
    valueAxis.dashLength = 3;
    chart.addValueAxis(valueAxis);

    // GRAPH
    graph = new AmCharts.AmGraph();
    graph.type = "smoothedLine"; // this line makes the graph smoothed line.
    graph.lineColor = "#d1655d";
    graph.negativeLineColor = "#637bb6"; // this line makes the graph to change color when it drops below 0
    graph.bullet = "round";
    graph.bulletSize = 8;
    graph.bulletBorderColor = "#FFFFFF";
    graph.bulletBorderAlpha = 1;
    graph.bulletBorderThickness = 2;
    graph.lineThickness = 2;
    graph.valueField = "total";
    graph.balloonText = "[[period]]<br><b><span style='font-size:14px;'>[[total]]</span></b>";
    graph.labelText = "[[total]]";
    chart.addGraph(graph);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorAlpha = 0;
    chartCursor.cursorPosition = "mouse";
    chartCursor.categoryBalloonDateFormat = "MM";
    chart.addChartCursor(chartCursor);

    // SCROLLBAR
    var chartScrollbar = new AmCharts.ChartScrollbar();
    chart.addChartScrollbar(chartScrollbar);

    chart.creditsPosition = "bottom-right";

    // WRITE
    chart.write("line_chart_contractual");
});


$(function () {
    $("#tabs").tabs();
});

$(function () {
    $("#tabs2").tabs();
});

</script>


@stop




