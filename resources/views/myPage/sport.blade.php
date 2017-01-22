@extends('common.templet')

@section('nav')
    @include('common.navigation')
@stop

@section('logout')
    <a href="{{url('home/userLogout')}}">
        <img src="{{asset('static/images/admin/nav/logout.png')}}" />
    </a>
@stop

@section('content')
    <script type="text/javascript">
        window.currentId={{$user->id}};
    </script>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>我的运动</h2>
            <hr class="star-primary">
        </div>
    </div>

    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">我的运动</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-1">
                        <img class="date_icon" src="{{asset('static/images/my/sport/date.png')}}">
                    </div>
                    <div class="col-lg-4 date_div">
                        <h4 id="year" class="date_h4 year_h4">{{$year}}</h4>&nbsp;年
                        <h4 id="month" class="date_h4">{{$month}}</h4>&nbsp;月
                        <h4 id="day" class="date_h4">{{$day}}</h4>&nbsp;日
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12" id="current_day_data_div">
                                        {{--今天你还未上传数据哦~--}}
                                        @if(count($sports)>0)
                                            <table class="table table-hover">
                                                <caption>您今天的运动数据~</caption>
                                                <thead>
                                                <tr>
                                                    <th>开始时间</th>
                                                    <th>结束时间</th>
                                                    <th>距离/m</th>
                                                    <th>时间/min</th>
                                                    <th>燃烧热量/大卡</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                @foreach($sports as $sport)
                                                    <tr>
                                                        <td>{{date('H:i:s',$sport->startTime)}}</td>
                                                        <td>{{date('H:i:s',$sport->endTime)}}</td>
                                                        <td>{{$sport->distance}}</td>
                                                        <td>{{ceil(($sport->endTime-$sport->startTime)/60)}}</td>
                                                        <td>{{$sport->heat}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            今天你还未上传数据哦~
                                        @endif

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-lg-offset-10">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <button id="upload_btn" type="button" class="btn btn-primary">上传</button>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="container">--}}
                                <div class="row" id="form_upload_div_row">
                                <HR class="HR" style="FILTER: progid:DXImageTransform.Microsoft.Glow(color=#987cb9,strength=10)" width="100%" color=#987cb9 SIZE=1>
                                    {{--表单--}}
                                    <div class="col-lg-12 form_upload_div">
                                        <form name="sport_form" class="form-horizontal" method="post" action="{{url('my/sport/'.$user->id)}}">{{--{{url('User/save')}}--}}

                                            {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                                            <div class="form-group">
                                                <label for="start_time" class="col-lg-3 control-label">开始时间</label>

                                                <div class="col-lg-1" style="width: 13%">
                                                    <select id="start_hour" name="start_hour" class="form-control">
                                                        @for($i=0;$i<24;$i++)
                                                            @if($i<10)
                                                                <option {{old('start_hour')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('start_hour')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">时</div>

                                                <div class="col-lg-1 time_modify" style="width: 13%">
                                                    <select id="start_minute" name="start_minute" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i<10)
                                                                <option {{old('start_minute')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('start_minute')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">分</div>

                                                <div class="col-lg-1 time_modify" style="width: 13%">
                                                    <select id="start_second" name="start_second" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i<10)
                                                                <option {{old('start_second')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('start_second')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">秒</div>


                                                <div class="col-lg-4 time_error_div">
                                                    <p id="time_fail" class="form-control-static text-danger"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="end_time" class="col-lg-3 control-label">结束时间</label>

                                                <div class="col-lg-1" style="width: 13%">
                                                    <select id="end_hour" name="end_hour" class="form-control">
                                                        @for($i=0;$i<24;$i++)
                                                            @if($i==1)
                                                                <option selected>01</option>
                                                            @elseif($i<10)
                                                                <option {{old('end_hour')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('end_hour')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">时</div>

                                                <div class="col-lg-1 time_modify" style="width: 13%">
                                                    <select id="end_minute" name="end_minute" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i<10)
                                                                <option {{old('end_minute')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('end_minute')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">分</div>

                                                <div class="col-lg-1 time_modify" style="width: 13%">
                                                    <select id="end_second" name="end_second" class="form-control">
                                                        @for($i=0;$i<60;$i++)
                                                            @if($i<10)
                                                                <option {{old('end_second')=="0$i"?'selected':''}}>0{{$i}}</option>
                                                            @else
                                                                <option {{old('end_second')=="$i"?'selected':''}}>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 time_detail" style="width:10%">秒</div>
                                                <div class="col-lg-4 time_error_div">
                                                    <p id="time_error" class="form-control-static text-danger"></p>
                                                </div>
                                            </div>


                                            <div class="form-group distance_div">
                                                <label for="distance" class="col-lg-3 control-label">运动距离</label>

                                                <div class="col-lg-5">
                                                    <input value="{{old('distance')?old('distance'):''}}" type="text" name="distance" class="form-control input_data" id="distance" placeholder="请输入您运动的距离（m）">
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="form-control-static text-danger">{{$errors->first('distance')}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group" id="check_btn_div">
                                                <div class="col-lg-offset-5 col-lg-2">
                                                    <button type="button" onclick="uploadSportData();" id="submit_btn" class="btn btn-primary">提交</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-lg-offset-1" style="width: 3%;">
                        <img src="{{asset('static/images/my/sport/muscle.png')}}"/>
                    </div>
                    <div class="col-lg-4 gain_title">
                        <h4>今日运动成果</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="col-lg-3">
                                            <img src="{{asset('static/images/my/sport/run.png')}}"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <h3>运动距离</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-3 col-lg-offset-2">
                                            <img src="{{asset('static/images/my/sport/clock.png')}}"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <h3>运动时长</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-3 col-lg-offset-3">
                                            <img src="{{asset('static/images/my/sport/heat.png')}}"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <h3>燃烧热量</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="col-lg-7 col-lg-offset-3">
                                            <span class="sport_data_span">{{$distance}}</span>
                                            <h4 class="unit">公里</h4>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-8 col-lg-offset-4">
                                            <span class="sport_data_span">{{$hour}}</span>
                                            <h4 class="unit">小时</h4>
                                            <span class="sport_data_span">{{$minute}}</span>
                                            <h4 class="unit">分</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-8 col-lg-offset-4 calorie_div">
                                            <span class="sport_data_span">{{$heat}}</span>
                                            <h4 class="unit">大卡</h4>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 chart_div">
                                        <div id="my_chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if(isset($error)&&$error=='上传运动失败')
    <script type="text/javascript">
        $('#upload_btn').text('收起');
        $('#upload_btn').removeClass('btn-primary');
        $('#upload_btn').addClass('btn-warning');
        $('#form_upload_div_row').css('display','block');
    </script>
@endif

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/auxiliary.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/sport.css')}}" />
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/sport.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/sport.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop