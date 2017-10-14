@extends('layouts.layout')
@section('header')
<link href="{{URL::asset('date/jquery.ui.all.css')}}" rel="stylesheet" type="text/css">

@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <br/>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading acl_heading_left">Employee Data</div>
                <div class="panel-heading"></a></div>
                <br/> </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper" style="text-align:left">
                    <form class="form-horizontal" role="form" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data" action="{{URL::to('/forecastemployee/new')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="myDate"  class="col-md-4 control-label">Select Date: </label>
                            <div class="col-md-6">
                                <input name="input_date" id="input_date" class="monthPicker form-control" style="width:200px">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Import File: </label>
                            <div class="col-md-6">
                                <input type="file"  name="employee_data" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                                Note: Make a copy of WD report file by save as, <br>File name format will be <strong>Employee Database 2015-12-03.xlsx<strong   
                            </div>
                        </div>
                        
                    </form>
                </div>
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

<script src="{{URL::to('layouts/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::to('layouts/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('date/jquery.ui.core.js')}}"></script>
<script src="{{URL::asset('date/jquery.ui.datepicker.js')}}"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
  $(function() {
    $( "#input_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });
  });
</script>
@endsection


