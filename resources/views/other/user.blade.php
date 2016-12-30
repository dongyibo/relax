@extends('common.templet')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>用户资料</h2>
            <hr class="star-primary">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">用户信息</h3>
                </div>
                <div class="panel-body">
                    {{--插入表单--}}
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-2" id="info_div">
                            <form class="form-horizontal" method="post" action="">{{--{{url('User/save')}}--}}

                                {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                                <div class="form-group">
                                    <label for="username" class="col-lg-2 control-label">用户名</label>

                                    <div class="col-lg-5">
                                        <input readonly="true" value="{{$other->username}}" type="text" name="User[username]" class="form-control input_data" id="username" placeholder="请输入您的用户名">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-lg-2 control-label">电子邮箱</label>

                                    <div class="col-lg-5">
                                        <input readonly="readonly" value='{{$other->email}}' type="text" name="User[email]" class="form-control input_data" id="email" placeholder="请输入您的电子邮箱">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="age" class="col-lg-2 control-label">年龄</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->age}}" readonly="readonly" type="text" name="User[age]" class="form-control input_data" id="age" placeholder="请输入您的年龄">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">性别</label>

                                    <div class="col-lg-5">
                                        <label class="radio-inline">
                                            <input disabled class="input_radio_data" id="radio_man" type="radio" name="User[sex]" value="男" {{$other->sex=='男'?'checked':''}}>男
                                        </label>
                                        <label class="radio-inline">
                                            <input disabled class="input_radio_data" id="radio_woman" type="radio" name="User[sex]" value="女" {{$other->sex=='女'?'checked':''}}>女
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="height" class="col-lg-2 control-label">身高</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->height}}" readonly="readonly" type="text" name="User[height]" class="form-control input_data" id="height" placeholder="请输入您的身高（cm）">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="weight" class="col-lg-2 control-label">体重</label>

                                    <div class="col-lg-5">
                                        <input value="{{$other->weight}}" readonly="readonly" type="text" name="User[weight]" class="form-control input_data" id="weight" placeholder="请输入您的体重（kg）">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 user_chart_div">
                            <div id="user_chart">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{asset('static/css/user.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/otherUser.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/otherUser.js')}}"></script>
@stop