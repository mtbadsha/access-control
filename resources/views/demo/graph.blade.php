@extends('layouts.layout')
@section('header')
<link href="{{URL::asset('layouts/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <br/>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading acl_heading_left">Demo Graph</div>
                <div class="panel-heading"><a href="#" class="acl_heading_right">Create Graph</a></div>
                <br/> </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <div style="width: 48%; height: 320px; float: left;" >
                        <div id="pie_chart" style="width: 100%; height: 300px"></div>
                        <label>Pie 3d chart</label>
                    </div>
                    <div style="width: 48%; height: 320px; float: left;" >
                        <div id="bar_chart" style="width: 100%; height: 300px"></div>
                        <label>Bar 3d chart</label>
                    </div>
                </div>
                <div style="clear: both">&nbsp;</div>
                <div style="width: 100%; height: 320px;" id="clustred_bar_chart"></div>
                <label>Clustered Chart</label>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection
@section('footer')

<script src="{{asset('assets/amcharts/amcharts.js')}}"></script>
<script src="{{asset('assets/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/amcharts/serial.js') }}" type="text/javascript"></script>

<script type="text/javascript">
var chart;
var legend;

var chartData = [
    {
        "country": "Lithuania",
        "value": 260
    },
    {
        "country": "Ireland",
        "value": 201
    },
    {
        "country": "Germany",
        "value": 65
    },
    {
        "country": "Australia",
        "value": 39
    },
    {
        "country": "UK",
        "value": 19
    },
    {
        "country": "Latvia",
        "value": 10
    }
];

AmCharts.ready(function () {
    // PIE CHART
    chart = new AmCharts.AmPieChart();
    chart.dataProvider = chartData;
    chart.titleField = "country";
    chart.valueField = "value";
    chart.outlineColor = "#FFFFFF";
    chart.outlineAlpha = 0.8;
    chart.outlineThickness = 2;
    chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
    // this makes the chart 3D
    chart.depth3D = 20;
    chart.angle = 50;

    // WRITE
    chart.write("pie_chart");
});

var chart;

var chartData1 = [
    {
        "year": 2005,
        "income": 23.5
    },
    {
        "year": 2006,
        "income": 26.2
    },
    {
        "year": 2007,
        "income": 30.1
    },
    {
        "year": 2008,
        "income": 29.5
    },
    {
        "year": 2009,
        "income": 24.6
    }
];

AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData1;
    chart.categoryField = "year";
    // this single line makes the chart a bar chart,
    // try to set it to false - your bars will turn to columns
    //chart.rotate = true;
    // the following two lines makes chart 3D
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

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisColor = "#DADADA";
    valueAxis.title = "Income in millions, USD";
    valueAxis.gridAlpha = 0.1;
    chart.addValueAxis(valueAxis);

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.title = "Income";
    graph.valueField = "income";
    graph.type = "column";
    graph.balloonText = "Income in [[category]]:[[value]]";
    graph.lineAlpha = 0;
    graph.fillColors = "#bf1c25";
    graph.fillAlphas = 1;
    chart.addGraph(graph);

    chart.creditsPosition = "top-left";

    // WRITE
    chart.write("bar_chart");
});



var chart;

var chartData2 = [
    {
        "year": 2005,
        "income": 23.5,
        "expenses": 18.1,
        "dummy": 10.1
    },
    {
        "year": 2006,
        "income": 26.2,
        "expenses": 22.8,
        "dummy": 20.1
    },
    {
        "year": 2007,
        "income": 30.1,
        "expenses": 23.9,
        "dummy": 50.1
    },
    {
        "year": 2008,
        "income": 29.5,
        "expenses": 25.1,
        "dummy": 50.1
    },
    {
        "year": 2009,
        "income": 24.6,
        "expenses": 25,
        "dummy": 30.1
    }
];


AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData2;
    chart.categoryField = "year";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    // this single line makes the chart a bar chart
    //chart.rotate = true;

    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    valueAxis.position = "top";
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Income";
    graph1.valueField = "income";
    graph1.balloonText = "Income:[[value]]";
    graph1.lineAlpha = 0;
    graph1.fillColors = "#ADD981";
    graph1.fillAlphas = 1;
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Expenses";
    graph2.valueField = "expenses";
    graph2.balloonText = "Expenses:[[value]]";
    graph2.lineAlpha = 0;
    graph2.fillColors = "#81acd9";
    graph2.fillAlphas = 1;
    chart.addGraph(graph2);
    
    // second graph
    var graph3 = new AmCharts.AmGraph();
    graph3.type = "column";
    graph3.title = "Dumy";
    graph3.valueField = "dummy";
    graph3.balloonText = "Dummy:[[value]]";
    graph3.lineAlpha = 0;
    graph3.fillColors = "#DADADA";
    graph3.fillAlphas = 1;
    chart.addGraph(graph3);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);

    chart.creditsPosition = "top-right";

    // WRITE
    chart.write("clustred_bar_chart");
});
</script>
@endsection


