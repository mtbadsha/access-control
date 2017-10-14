@extends('layouts.layout')
@section('header')
    <link href="{{URL::asset('layouts/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Employee Report</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Search Division</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/post_search_department')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Division Name</label>
                            <div class="col-md-6">
                                <select name="division" id="division" class="form-control" required>
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{$division->organization_name}}">{{$division->organization_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Department Name</label>
                            <div class="col-md-6">
                                <select name="department" id="department" class="form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if($employees!=null)  <hr>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="resource-name">Global ID</th>
                                <th class="resource-name">Local ID</th>
                                <th class="resource-name">Employee Name</th>
                                <th class="resource-name">Department Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->global_id}}</td>
                                    <td>{{$employee->local_id}}</td>
                                    <td>{{$employee->employee_name}}</td>
                                    <td>{{$employee->department_name}}</td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')

    <script src="{{URL::to('layouts/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('layouts/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                "lengthMenu": [[10, 25, 50,500,2000,10000,50000, -1], [10, 25, 50,500,2000,10000,50000, "All"]]
            });
        });


        $("#division").on('change',function (e) {
         //   console.log(e);
      //  document.write('hello');
            var division = e.target.value;
      //document.write(division);
            $.get('/ajaxdivision?division=' +division,function(data)
            {
                $('#department').empty();
                $.each(data,function(index,subcatObj)
                {
                    $('#department').append('<option value="'+subcatObj.id+'">'+subcatObj.organization_name+'</option>');
                })

            });
        });
    </script>
@endsection