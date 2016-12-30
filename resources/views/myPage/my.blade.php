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
    @include('common.hotUsers')
@stop