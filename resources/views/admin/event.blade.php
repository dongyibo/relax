@extends('common.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>活动管理</h2>
            <hr class="star-primary">
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    发布活动
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12" id="info_div">
                        <div class="form-horizontal">{{--{{url('User/save')}}--}}

                            {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                            <div class="form-group">
                                <label for="name" class="col-lg-3 control-label">名称</label>

                                <div class="col-lg-5">
                                    <input type="text" name="Activity[name]" class="form-control input_data" id="name" placeholder="请输入活动名称">
                                </div>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger" id="name_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-lg-3 control-label">地点</label>

                                <div class="col-lg-5">
                                    <input type="text" name="Activity[address]" class="form-control input_data" id="address" placeholder="请输入活动地点">
                                </div>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger" id="address_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="time" class="col-lg-3 control-label">时间</label>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-1" style="width: 24%">
                                            <select  id="year" class="form-control">
                                                <option>2016</option>
                                                <option>2017</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">年</div>

                                        <div class="col-lg-1" style="width: 20%">
                                            <select id="month" class="form-control">
                                                @for($i=1;$i<13;$i++)
                                                    @if($i>=1&&$i<10)
                                                        <option>0{{$i}}</option>
                                                    @else
                                                        <option>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">月</div>

                                        <div class="col-lg-1" style="width: 20%">
                                            <select id="day" class="form-control">
                                                @for($i=1;$i<=31;$i++)
                                                    @if($i>=1&&$i<10)
                                                        <option>0{{$i}}</option>
                                                    @else
                                                        <option>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">日</div>
                                    </div>

                                    <div class="row time_row_div">
                                        <div class="col-lg-1" style="width: 24%">
                                            <select id="hour" class="form-control">
                                                @for($i=0;$i<24;$i++)
                                                    @if($i>=0&&$i<10)
                                                        <option>0{{$i}}</option>
                                                    @else
                                                        <option>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">时</div>

                                        <div class="col-lg-1 time_modify" style="width: 20%">
                                            <select id="minute" class="form-control">
                                                @for($i=0;$i<60;$i++)
                                                    @if($i>=0&&$i<10)
                                                        <option>0{{$i}}</option>
                                                    @else
                                                        <option>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">分</div>

                                        <div class="col-lg-1 time_modify" style="width: 20%">
                                            <select id="second" class="form-control">
                                                @for($i=0;$i<60;$i++)
                                                    @if($i>=0&&$i<10)
                                                        <option>0{{$i}}</option>
                                                    @else
                                                        <option>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-1 time_detail" style="width:1%">秒</div>
                                    </div>
                                    </div>

                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="peopleLimit" class="col-lg-3 control-label">限定人数</label>

                                <div class="col-lg-5">
                                    <input type="text" name="Activity[peopleLimit]" class="form-control input_data" id="peopleLimit" placeholder="请输入人数上限">
                                </div>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger" id="limit_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="detail" class="col-lg-3 control-label">详情</label>

                                <div class="col-lg-5">
                                    <textarea id="detail" name="Activity[detail]" class="form-control" rows="3" placeholder="请输入活动详情（100字以内）"></textarea>
                                </div>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger" id="detail_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::open( [ 'url' => ["ajax/activityImg"], 'method' => 'POST', 'id' => 'upload_img', 'files' => true ] ) !!}
                                <label for="detail" class="col-lg-3 control-label">添加图片</label>

                                <div class="col-lg-5">
                                    <input type="file" id="input_file" name="activity_img">
                                </div>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-danger">{{$errors->first('User.email')}}</p>
                                </div>
                                {!! Form::close() !!}
                            </div>

                            <div class="form-group" id="check_btn_div">
                                <div class="col-lg-offset-5 col-lg-2">
                                    <button id="release_btn" type="button" class="btn btn-info" onclick="releaseActivity({{$user->id}});">发布</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('common.activityList')
    @include('common.hotActivities')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-5">
            <a href="{{url('admin/activity/hot')}}">
                <button type="button" class="btn btn-danger">刷新热门活动</button>
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/activity.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/admin.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/event.css')}}" />
    <script type="text/javascript" src="{{asset('static/js/pptBox.js')}}"></script>
    <script src="{{asset('static/js/activity.js')}}"></script>
@stop()

@section('javascript')
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/admin.js')}}"></script>
    <script src="{{asset('static/js/activity.js')}}"></script>
@stop