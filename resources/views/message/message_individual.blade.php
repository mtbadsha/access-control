@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Message</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h3>{{$message->title}}</h3>
                    <p>{{$message->description}}</p><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
