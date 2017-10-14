<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Access Control - Version2.0</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::asset('layouts/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{URL::asset('layouts/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{URL::asset('layouts/dist/css/timeline.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{URL::asset('layouts/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{URL::asset('layouts/bower_components/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{URL::asset('layouts/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{URL::asset('layouts/acl.css')}}" rel="stylesheet">
    @yield('header')
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            @include('partials.header_top_nav_left')
        </div>
        <!-- /.navbar-header -->

        @include('partials.header_top_nav_right')
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            @include('partials.left_menu2')
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
           @yield('content')
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{URL::asset('layouts/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{URL::asset('layouts/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{URL::asset('layouts/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

<script src="{{URL::asset('layouts/dist/js/sb-admin-2.js')}}"></script>

@yield('footer')
</body>
</html>