@extends('common.templet')

@section('nav')
    <nav class="mainmenu">
        <div class="container">
            <div class="dropdown">
                <div class="row">
                    <div class="col-lg-1 col-lg-offset-11">
                        <button type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a id="data_link" href='{{url('admin/data')}}' class="{{Request::getPathInfo()=="/admin/data"?'active':''}} link btn btn-link"><img src="{{asset('static/images/admin/nav/data.png')}}" /></span>我的资料</a></li>
                            <li><a id="user_link" href='{{url('admin/user')}}' class="{{Request::getPathInfo()=="/admin/user"?'active':''}} link btn btn-link"><img src="{{asset('static/images/admin/nav/user.png')}}" /></span>用户管理</a></li>
                            <li><a id="activity_link" href='{{url('admin/activity/start')}}' class="{{Request::getPathInfo()=="/admin/activity/start"?'active':''}} {{Request::getPathInfo()=="/admin/activity/release"?'active':''}} link btn btn-link"><img src="{{asset('static/images/admin/nav/event.png')}}" /></span>活动管理</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@stop

@section('logout')
    <a href="{{url('home/adminLogout')}}">
        <img src="{{asset('static/images/admin/nav/logout.png')}}" />
    </a>
@stop

