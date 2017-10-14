@extends('layouts.layout')
@section('header')
    <link href="{{URL::asset('date/jquery.ui.all.css')}}" rel="stylesheet" type="text/css">
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Employee</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Create Employee</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data" action="{{URL::to('/employee/post_bulk_upload')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                        <label for="myDate"  class="col-md-4 control-label">Date :</label>
                            <div class="col-md-6">
                                   <input name="myDate" class="monthPicker form-control">
                                <p>Jan-2011 to Sep-203</p>
                                </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Import File</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="excel_file"required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{URL::asset('date/jquery.ui.core.js')}}"></script>
    <script src="{{URL::asset('date/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('date/jquery.ui.datepicker.js')}}"></script>
    <script>
        $(function() {
            $('.monthPicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm-dd'
            }).focus(function() {
                var thisCalendar = $(this);
                $('.ui-datepicker-calendar').detach();
                $('.ui-datepicker-close').click(function() {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    thisCalendar.datepicker('setDate', new Date(year, month, 1));
                });
            });
        });
    </script>
@stop




