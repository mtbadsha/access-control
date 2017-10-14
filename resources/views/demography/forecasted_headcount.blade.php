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
        <br/>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-12 col-md-offset">
        <div class="panel panel-default">
            <div class="panel-heading">Forecast Vs Existing Employee Search</div>
            <div class="panel-body" style="text-align:center">
                <form class="form-horizontal" role="form" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data" action="{{URL::to('/forecastedheadcount')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="form_table" style="width: 500px">
                        <tr>
                            <td>Select Year</td>
                            <td>:</td>
                            <td><input name="monthPicker" class="monthPicker form-control" value="{{ $year}}"></td>
                            <td>&nbsp;</td>                          
                            <td><button type="submit" class="btn btn-primary"> Show </button></td>
                        </tr>                        
                    </table>
                </form>
            </div>
        </div>
    </div>        
</div>
@if ($total_employee != '0')
<div class="row">
    <div class="col-md-12 col-md-offset">
        <div class="panel panel-default">
            <div class="panel-heading">All Employee Forecast</div>
            <div class="panel-body">
                <div id="tabs-x">   
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="#all_headcount">All Employee</a></li>
                        <li><a href="#all_regular">Regular </a></li>  
                        <li><a href="#all_contractual">Contractual </a></li>  
                        <li><a href="#all_apprentice">Apprentice </a></li>  
                    </ul>                    
                    <div style="width: 100%; height: 320px;" id="all_headcount"></div>    
                    <div style="width: 100%; height: 320px;" id="all_regular"></div>    
                    <div style="width: 100%; height: 320px;" id="all_contractual"></div>    
                    <div style="width: 100%; height: 320px;" id="all_apprentice">cc</div>    
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
<script src="{{asset('assets/amcharts/serial.js') }}" type="text/javascript"></script>


<script>
$(function () {
    $('.monthPicker').datepicker({
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        minDate: new Date(2015, 1, 1),
        maxDate: new Date()

    }).focus(function () {
        var thisCalendar = $(this);
        $('.ui-datepicker-calendar').detach();
        $('.ui-datepicker-close').click(function () {
            //var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            thisCalendar.datepicker('setDate', new Date(year, 1, 1));
        });
    });
});
$(function () {
    $("#tabs-x").tabs();
});
// start all_headcount graph
var chart;
var chartData = <?php echo $total_employee ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "div_name";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    chart.rotate = false;

    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.title = "Data as of: <?php echo $as_of_data?>";

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    valueAxis.position = "left";
    valueAxis.title = "Data as of: <?php echo $as_of_data?>";
    chart.addValueAxis(valueAxis);

    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Forecasted Data";
    graph1.valueField = "forecast_data";
    graph1.balloonText = "Forecasted Data:[[value]]";
    graph1.lineAlpha = 0;
    graph1.fillColors = "blue";
    graph1.fillAlphas = 1;
    graph1.labelText = "[[forecast_data]]";
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Actual Headcount";
    graph2.valueField = "actual_worker";
    graph2.balloonText = "Actual Headcount:[[value]]";
    graph2.lineAlpha = 0;
    graph2.fillColors = "red";
    graph2.fillAlphas = 2;
    graph2.labelText = "[[actual_worker]]";
    chart.addGraph(graph2);
  
    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);
    chart.creditsPosition = "top-left";
    chart.write("all_headcount");
});

// start regular graph
var chart;
var chartData_regular = <?php echo $total_regular ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData_regular;
    chart.categoryField = "div_name";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    chart.rotate = false;

    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.title = "Data as of: <?php echo $as_of_data?>";

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    valueAxis.position = "left";
    valueAxis.title = "Data as of: <?php echo $as_of_data?>";
    chart.addValueAxis(valueAxis);

    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Forecasted Data";
    graph1.valueField = "forecast_data";
    graph1.balloonText = "Forecasted Data:[[value]]";
    graph1.lineAlpha = 0;
    graph1.fillColors = "blue";
    graph1.fillAlphas = 1;
    graph1.labelText = "[[forecast_data]]";
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Actual Headcount";
    graph2.valueField = "actual_worker";
    graph2.balloonText = "Actual Headcount:[[value]]";
    graph2.lineAlpha = 0;
    graph2.fillColors = "red";
    graph2.fillAlphas = 2;
    graph2.labelText = "[[actual_worker]]";
    chart.addGraph(graph2);
  
    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);
    chart.creditsPosition = "top-left";
    chart.write("all_regular");
});

// start contractual graph
var chart;
var chartData_contractual = <?php echo $total_contractual ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData_contractual;
    chart.categoryField = "div_name";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    chart.rotate = false;

    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.title = "Data as of: <?php echo $as_of_data?>";

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    valueAxis.position = "left";
    valueAxis.title = "Data as of: <?php echo $as_of_data?>";
    chart.addValueAxis(valueAxis);

    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Forecasted Data";
    graph1.valueField = "forecast_data";
    graph1.balloonText = "Forecasted Data:[[value]]";
    graph1.lineAlpha = 0;
    graph1.fillColors = "blue";
    graph1.fillAlphas = 1;
    graph1.labelText = "[[forecast_data]]";
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Actual Headcount";
    graph2.valueField = "actual_worker";
    graph2.balloonText = "Actual Headcount:[[value]]";
    graph2.lineAlpha = 0;
    graph2.fillColors = "red";
    graph2.fillAlphas = 2;
    graph2.labelText = "[[actual_worker]]";
    chart.addGraph(graph2);
  
    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);
    chart.creditsPosition = "top-left";
    chart.write("all_contractual");
});

// start contractual graph
var chart;
var chartData_apprentice = <?php echo $total_apprentice ?>;

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData_apprentice;
    chart.categoryField = "div_name";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    chart.rotate = false;

    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.title = "Data as of: <?php echo $as_of_data?>";

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    valueAxis.position = "left";
    valueAxis.title = "Data as of: <?php echo $as_of_data?>";
    chart.addValueAxis(valueAxis);

    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Forecasted Data";
    graph1.valueField = "forecast_data";
    graph1.balloonText = "Forecasted Data:[[value]]";
    graph1.lineAlpha = 0;
    graph1.fillColors = "blue";
    graph1.fillAlphas = 1;
    graph1.labelText = "[[forecast_data]]";
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Actual Headcount";
    graph2.valueField = "actual_worker";
    graph2.balloonText = "Actual Headcount:[[value]]";
    graph2.lineAlpha = 0;
    graph2.fillColors = "red";
    graph2.fillAlphas = 2;
    graph2.labelText = "[[actual_worker]]";
    chart.addGraph(graph2);
  
    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);
    chart.creditsPosition = "top-left";
    chart.write("all_apprentice");
});

</script>

@stop




