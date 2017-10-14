@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">My Profile</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10">
                <div class="panel panel-default">

                    <div class="panel-body">
                        @if(Auth::user()!=null)
                    <h2>{{Auth::user()->user_name}}</h2>
                            @endif
                    </div>
                </div>
        </div>
    </div>

@endsection
