@extends('common.admin')

@section('content')
    @include('common.data')
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/admin.css')}}" />
    <script src="{{asset('static/js/data.js')}}"></script>
@stop()

@section('javascript')
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/admin.js')}}"></script>
    <script src="{{asset('static/js/data.js')}}"></script>
@stop