<?php
$not = \App\Notification::where('employee_id','=',Auth::user()->global_id)->orderBy('id','DESC')->get();
$notifications = \App\Notification::where('employee_id','=',Auth::user()->global_id)->where('viewed','=','false')->get();
  //  $count = 0;
        $count = count($notifications);

$message = \App\Message::where('employee_id','=',Auth::user()->global_id)->orderBy('id','DESC')->get();
$mv = \App\Message::where('employee_id','=',Auth::user()->global_id)->where('viewed','=','false')->get();
//$count1 = 0;
$count1 = count($mv);
?>

<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i>
            @if($count!=0)
            {{$count}}
            @else
              @endif  <i class="fa fa-caret-down"></i>
        </a>

        <ul class="dropdown-menu dropdown-messages">
            @if($not!='[]')
                @foreach($not as $n)
                    @if($n->viewed=="false")
            <li>
                <a href="{{URL::to('notification/'.$n->id)}}">
                    <div>
                        <strong>{{$n->title}}</strong>
                        <span class="pull-right text-muted">
                            <em>{{$n->display_date}}</em>
                        </span>
                    </div>
                    <div>{{substr($n->description,50)}}</div>
                </a>
            </li>
                    @else
                        <li>
                            <a href="{{URL::to('notification/'.$n->id)}}">
                                <div>
                                    {{$n->title}}
                        <span class="pull-right text-muted">
                            <em>{{$n->display_date}}</em>
                        </span>
                                </div>
                                
                            </a>
                        </li>
                    @endif
            <li class="divider"></li>
                @endforeach
            <li>
                <a class="text-center" href="{{URL::to('/notifications')}}">
                    <strong>Read All Notifications</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
                @else
                <li>
                <strong>No Notifications</strong>
                </li>
                @endif
        </ul>
        <!-- /.dropdown-messages -->
    </li>
    <!-- /.dropdown -->
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa  fa-envelope fa-fw"></i>   @if($count1!=0)
                {{$count1}}
            @else
            @endif <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-messages">
            @if($message!='[]')
                @foreach($message as $m)
                    @if($m->viewed=="false")
                        <li style="background-color: #b0bed9">
                            <a href="{{URL::to('message/'.$m->id)}}">
                                <div>
                                    <strong>{{$m->title}}</strong>
                        <span class="pull-right text-muted">
                            <em>{{$m->display_date}}</em>
                        </span>
                                </div>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{URL::to('message/'.$m->id)}}">
                                <div>
                                   {{$m->title}}
                        <span class="pull-right text-muted">
                            <em>{{$m->display_date}}</em>
                        </span>
                                </div>
                            </a>
                        </li>
                    @endif
                    <li class="divider"></li>
                @endforeach
                <li>
                    <a class="text-center" href="{{URL::to('/messages')}}">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <strong>No Messages</strong>
                </li>
            @endif
        </ul>
        <!-- /.dropdown-alerts -->
    </li>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{URL::to('/change_password')}}"><i class="fa fa-user fa-fw"></i> Change Password</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{URL::to('/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>