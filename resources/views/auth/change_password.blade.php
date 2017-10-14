@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header acl_page_header">Change Password</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                    </div>
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

                        <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/post_change_password')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Old Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="old_password" id="oldpassword" required>
                                </div>
                                @if(Session::has('message'))
                                <div  class="col-md-4 "></div> <div  class="col-md-6"><span class="spansohel"><p id="errorconfirmpassword" style="color: red;">{{ Session::get('message') }}</p></span></div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="new_password" id="newpassword" onkeyup="checkPassword()" required>
                                </div>
                                <div  class="col-md-4 "></div> <div  class="col-md-6"><span class="spansohel"><p id="errornewpassword" style="color: red;"></p></span></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="confirm_new_password" id="confirmnewPassword" onkeyup="checkPassword()" required>
                                </div>
                                <div  class="col-md-4 "></div> <div  class="col-md-6"><span class="spansohel"><p id="errorconfirmpassword" style="color: red;"></p></span></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" id="button" style="margin-right: 15px;">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

    <style>
        .spansohel{
            color: red;
            font-size: 20px;
        }
    </style>
    <script>

        function checkPassword()
        {

            var newPassword = document.getElementById('newpassword').value;
            var confirmnewPassword = document.getElementById('confirmnewPassword').value;

            if (newPassword.length < 6) {
                document.getElementById('errornewpassword').innerHTML = "Password need at least 6 characters";
                document.getElementById('button').disabled = true;
            }
            else{
                document.getElementById('errornewpassword').innerHTML = null;
                document.getElementById('button').disabled = true;
            }

            if (confirmnewPassword == newPassword && newPassword.length >= 6) {
                document.getElementById('confirmnewPassword').style.border = '1px solid #ccc';
                document.getElementById('errorconfirmpassword').innerHTML = null;
                document.getElementById('button').disabled = false;
            }
            else {

                if (confirmnewPassword != "" && confirmnewPassword != null) {
                    document.getElementById('confirmnewPassword').style.border = '1px solid red';
                    document.getElementById('errorconfirmpassword').innerHTML = "Password Mismatch";
                }
                document.getElementById('button').disabled = true;
            }
        }
    </script>
@stop