@extends('layouts.layout')
@section('header')
    <link href="{{URL::asset('css/ui/auto.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">UserWise Role</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                    <div class="panel-heading">Create Permission</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/post_role_to_user')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group">
                                <label class="col-md-4 control-label">Select User Name</label>
                                <div class="col-md-5">
                                    <input id="tags" size="35" name="user" onkeyup="data()"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Role Name</label>
                                <div class="col-md-5">
                                    <input id="tags2" size="35" name="role"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-4">
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
    <?php
    $user_name = \App\User::all();
      $arr_name = array();
     foreach($user_name as $name)
         {
             $arr_name[]= $name->user_name;
         }
      $role_names = \App\Role::all();
    $arr_role = array();
    foreach($role_names as $role)
    {
        $arr_role[]= $role->role_name;
    }

    ?>
@endsection
@section('footer')
    <script src="{{URL::asset('css/jquery-1.7.1.js')}}"></script>
    <script src="{{URL::asset('css/ui/jquery.ui.core.js')}}"></script>
    <script src="{{URL::asset('css/ui/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('css/ui/jquery.ui.position.js')}}"></script>
    <script src="{{URL::asset('css/ui/jquery.ui.autocomplete.js')}}"></script>
    {{--<script src="{{URL::asset('css/ui/my.js')}}"></script>--}}

    <script>
        $(function() {
            var availableTags = <?php echo json_encode($arr_name)?>;
            var availableTags2 = <?php echo json_encode($arr_role)?>;
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags" ).bind( "keydown", function( event ) {

                        if ( event.keyCode === $.ui.keyCode.TAB &&
                                $( this ).data( "autocomplete" ).menu.active ) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 0,
                        source: function( request, response ) {
                            // delegate back to autocomplete, but extract the last term
                            response( $.ui.autocomplete.filter(
                                    availableTags, extractLast( request.term ) ) );
                        },
                        focus: function() {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function( event, ui ) {
                            var terms = split( this.value );
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push( ui.item.value );
                            // add placeholder to get the comma-and-space at the end
                            terms.push( "" );
                            this.value = terms.join( ", " );
                            return false;
                        }
                    });
            $( "#tags2" ).bind( "keydown", function( event ) {

                if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).data( "autocomplete" ).menu.active ) {
                    event.preventDefault();
                }
            })
                    .autocomplete({
                        minLength: 0,
                        source: function( request, response ) {
                            // delegate back to autocomplete, but extract the last term
                            response( $.ui.autocomplete.filter(
                                    availableTags2, extractLast( request.term ) ) );
                        },
                        focus: function() {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function( event, ui ) {
                            var terms = split( this.value );
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push( ui.item.value );
                            // add placeholder to get the comma-and-space at the end
                            terms.push( "" );
                            this.value = terms.join( ", " );
                            return false;
                        }
                    });
        });
    </script>

@endsection
