<div class="row">
    <div class="col-lg-12 text-center">
        <h2>我的资料</h2>
        <hr class="star-primary">
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">个人信息</h3>
            </div>
            <div class="panel-body">
                {{--插入表单--}}
                <div class="row">
                    <div class="col-lg-1 col-lg-offset-1">
                        <div class="btn-group-vertical">
                            <button id="data_btn" type="button" class="btn btn-default active">基本资料</button>
                            <button id="pwd_btn" type="button" class="btn btn-default">重置密码</button>
                        </div>
                    </div>
                    <div class="col-lg-10" id="info_div">
                        @if(!$user->isAdmin)
                        <form name="modifyData_form" class="form-horizontal" method="post" action="{{url('data/modify/'.$user->id)}}">{{--{{url('User/save')}}--}}
                        @else
                        <form name="modifyData_form" class="form-horizontal" method="post" action="{{url('data/modify/'.$user->id.'/admin')}}">
                        @endif
                            {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}
                            <input id="nameToJudge" type="hidden" value="{{$user->username}}">
                            <div class="form-group">
                                <label for="username" class="col-lg-2 control-label">用户名</label>

                                <div class="col-lg-5">
                                    <input readonly="true" value="{{old('User')['username']?old('User')['username']:$user->username}}" type="text" name="User[username]" class="form-control input_data" id="username" placeholder="请输入您的用户名">
                                </div>
                                <div class="col-lg-5">
                                    <p id="username_repeat" class="form-control-static text-danger">{{$errors->first('username')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label">电子邮箱</label>

                                <div class="col-lg-5">
                                    <input readonly="readonly" value="{{old('User')['email']?old('User')['email']:$user->email}}" type="text" name="User[email]" class="form-control input_data" id="email" placeholder="请输入您的电子邮箱">
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('email')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="age" class="col-lg-2 control-label">年龄</label>

                                <div class="col-lg-5">
                                    <input value="{{old('User')['age']?old('User')['age']:$user->age}}" readonly="readonly" type="text" name="User[age]" class="form-control input_data" id="age" placeholder="请输入您的年龄">
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('age')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">性别</label>

                                <div class="col-lg-5">
                                    <label class="radio-inline">
                                        <input disabled class="input_radio_data" id="radio_man" type="radio" name="User[sex]" value="男" {{$user->sex=='男'?'checked':''}}>男
                                    </label>
                                    <label class="radio-inline">
                                        <input disabled class="input_radio_data" id="radio_woman" type="radio" name="User[sex]" value="女" {{$user->sex=='女'?'checked':''}}>女
                                    </label>
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('sex')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="height" class="col-lg-2 control-label">身高</label>

                                <div class="col-lg-5">
                                    <input value="{{old('User')['height']?old('User')['height']:$user->height}}" readonly="readonly" type="text" name="User[height]" class="form-control input_data" id="height" placeholder="请输入您的身高（cm）">
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('height')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="weight" class="col-lg-2 control-label">体重</label>

                                <div class="col-lg-5">
                                    <input value="{{old('User')['weight']?old('User')['weight']:$user->weight}}" readonly="readonly" type="text" name="User[weight]" class="form-control input_data" id="weight" placeholder="请输入您的体重（kg）">
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('weight')}}</p>
                                </div>
                            </div>

                            <div class="form-group" id="check_btn_div">
                                <div class="col-lg-offset-4 col-lg-2">
                                    <button type="button" id="edit_btn" class="btn btn-primary">编辑</button>
                                </div>
                            </div>

                            <div class="form-group" style="display: none;" id="edit_btn_div">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <div class="col-lg-3">
                                        <button type="button" onclick="submitModifyData();" id="data_submit_btn" class="btn btn-primary">提交</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button onclick="restoreData({{$user->id}});" type="button" id="data_cancel_btn" class="btn btn-primary">取消</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div style="display: none" class="col-lg-10" id="password_div">
                        @if(!$user->isAdmin)
                        <form name="password_form" class="form-horizontal" method="post" action="{{url('data/password/'.$user->id)}}">{{--{{url('User/save')}}--}}
                        @else
                        <form name="password_form" class="form-horizontal" method="post" action="{{url('data/password/'.$user->id.'/admin')}}">
                        @endif
                            {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}

                            <div class="form-group">
                                <label for="old_password" class="col-lg-2 control-label">原密码</label>

                                <div class="col-lg-5">
                                    <input type="password" name="User[old]" class="form-control" id="old_password" placeholder="请输入您的原密码">
                                </div>
                                <div class="col-lg-5">
                                    <p class="form-control-static text-danger">{{$errors->first('old')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new_password" class="col-lg-2 control-label">新密码</label>

                                <div class="col-lg-5">
                                    <input type="password" name="User[new]" class="form-control" id="new_password" placeholder="请输入您的新密码">
                                </div>
                                <div class="col-lg-5">
                                    <p id="new_pwd_prompt" class="form-control-static text-danger">{{$errors->first('new')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="again_password" class="col-lg-2 control-label">再次输入新密码</label>

                                <div class="col-lg-5">
                                    <input type="password" name="User[newAgain]" class="form-control" id="again_password" placeholder="请再次输入您的新密码">
                                </div>
                                <div class="col-lg-5">
                                    <p id="again_pwd_prompt" class="form-control-static text-danger">{{$errors->first('newAgain')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-2">
                                    <button type="button" class="btn btn-primary" onclick="confirmPwd({{$user->id}});">提交</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($error)&&$error=='修改资料失败')
    <script type="text/javascript">
        edit();
    </script>
@endif
@if(isset($error)&&$error=='修改密码失败')
    <script type="text/javascript">
        resetPWD();
    </script>
@endif