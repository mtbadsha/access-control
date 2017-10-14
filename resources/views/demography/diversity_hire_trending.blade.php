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
                <form class="form-horizontal" role="form" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data" action="{{URL::to('/diversityhiringvsternover')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="form_table" width="100%">
                        <tr>
                            <td>Date From</td>
                            <td>:</td>
                            <td><input name="from" class="monthPicker form-control" value="{{ $from}}"></td>
                            <td>&nbsp;</td>
                            <td>Date To</td>
                            <td>:</td>
                            <td><input name="to" class="monthPicker form-control" value="{{ $to}}"></td>
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
            <div class="panel-heading">New Joiner's Diversity</div>
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
            <div class="panel-heading">Turnover Diversity</div>
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
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function () {
    $('.monthPicker').datepicker({
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        minDate: new Date(2011, 1 - 1, 1),
        maxDate: new Date()
    }).focus(function () {
        var thisCalendar = $(this);
        $('.ui-datepicker-calendar').detach();
        $('.ui-datepicker-close').click(function () {
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            thisCalendar.datepicker('setDate', new Date(year, 1, 1));
        });
    });
});
$(function () {
    $("#tabs").tabs();
});

$(function () {
    $("#tabs2").tabs();
});

</script>

@stop




