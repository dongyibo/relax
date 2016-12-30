@extends('common.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>用户管理</h2>
            <hr class="star-primary">
        </div>
    </div>

    @include('common.search')

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 count_div">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        @if(isset($count))
                            <div class="col-lg-3 col-lg-offset-4">
                                <h4>搜索到的用户数为</h4>
                            </div>
                            <div class="col-lg-2 h_search_user_div">
                                <h3 class="h_color">{{$count}}</h3>
                            </div>
                        @else
                            <div class="col-lg-3 col-lg-offset-1">
                                <h4>目前用户数为</h4>
                            </div>
                            <div class="col-lg-2 h_user_div">
                                <h3 class="h_color">{{$count_user}}</h3>
                            </div>
                        @endif

                        @if(!isset($count))
                            <div class="col-lg-3">
                                <h4>管理员数为</h4>
                            </div>
                            <div class="col-lg-1 h_admin_div">
                                <h3 class="h_color">{{$count_admin}}</h3>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <img src="{{asset('static/images/admin/user/boy.png')}}">
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>{{$count_man}}</h4>
                                    </div>
                                    <div class="col-lg-2">
                                        <img src="{{asset('static/images/admin/user/girl.png')}}">
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>{{$count_woman}}</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 user_list_div">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">用户列表</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($users as $u)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img class="friend_list_avatar" src="{{$u->portrait?asset('uploads/avatar/'.$u->portrait):asset('static/images/my/temp.png')}}"/>
                                </div>
                                <div class="col-lg-9 user_name_div">
                                    <span class="name_h4">{{$u->username}}</span><img src="{{$u->sex=='男'?asset('static/images/admin/user/man.png'):asset('static/images/admin/user/woman.png')}}"/>
                                </div>
                                <div class="col-lg-1 detail_icon_div">
                                    <a href="{{url('user/'.$u->id)}}" target="_blank"><img class="friend_list_icon" src="{{asset('static/images/my/friend/detail.png')}}"></a>
                                </div>
                                <div class="col-lg-1 delete_icon_div">
                                    <a href="javascript:void(0)"><img onclick="deleteUser({{$u->id}})" class="friend_list_icon" src="{{asset('static/images/my/friend/delete.png')}}"></a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-6">
                            <div class="col-lg-10 col-lg-offset-2">
                                <div class="pull-right">
                                    {{$users->render()}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/admin.css')}}" />
    <link href="{{asset('static/css/friend.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/userOpreation.css')}}" rel="stylesheet">
@stop()

@section('javascript')
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/admin.js')}}"></script>
    <script src="{{asset('static/js/users.js')}}"></script>
@stop