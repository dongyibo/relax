@extends('common.templet')

@section('nav')
    @include('common.navigation')
@stop

@section('logout')
    <a href="{{url('home/userLogout')}}">
        <img src="{{asset('static/images/my/nav/logout.png')}}" />
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>活&nbsp;&nbsp;动</h2>
            <hr class="star-primary">
        </div>
    </div>

    @include('common.hotActivities')

    @include('common.activityList')
@stop


@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/activity.css')}}" />
    <script type="text/javascript" src="{{asset('static/js/pptBox.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/activity.js')}}"></script>
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('static/js/activity.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop