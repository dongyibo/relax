<section id="register">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top" style="background: #f8f8f8">
                    @if(!count($errors))
                    <div class="form-top-left">
                        <h3>欢迎来到Relax运动社区</h3>
                    </div>
                    @endif
                    @include('common.validator')
                    <div class="form-top-right">
                        <i class="fa fa-key"></i>
                    </div>
                    {{--<div class="">--}}
                        {{--<p id="username_repeat" class="form-control-static text-danger"></p>--}}
                    {{--</div>--}}
                </div>
                {{--style="background-image: url(static/images/a.png)"--}}
                <div class="form-bottom" style="background-image: url(static/images/home/panel.jpg)">
                    <form name="register_form" role="form" action="{{url('home/register')}}" method="post" class="form-horizontal">
                        {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}
                        <p id="username_repeat" class="form-control-static text-danger"></p>
                        <div class="form-group">
                            {{--<label class="control-label col-lg-1" for="form-username">用户名</label>--}}
                            <label for="form-username" class="col-lg-2 control-label">用户名</label>
                            <div class="col-lg-10">
                            <input value="{{old('User')['username']}}" type="text" name="User[username]" placeholder="请输入您的用户名" class="form-username form-control" id="form-username">
                            </div>
                            {{--<div class="col-lg-5">--}}
                                {{--<p class="form-control-static text-danger"></p>--}}
                            {{--</div>--}}
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2" for="form-password">密码</label>
                            <div class="col-lg-10">
                            <input value="{{old('User')['password']}}" type="password" name="User[password]" placeholder="请输入您的密码（6~20位）" class="form-password form-control" id="form-password">
                            </div>
                            {{--<div class="col-lg-5">--}}
                                {{--<p class="form-control-static text-danger"></p>--}}
                            {{--</div>--}}
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2" for="form-email">邮箱</label>
                            <div class="col-lg-10">
                                <input value="{{old('User')['email']}}" type="text" name="User[email]" placeholder="请输入您的邮箱" class="form-email form-control" id="form-email">
                            </div>
                            {{--<div class="col-lg-5">--}}
                                {{--<p class="form-control-static text-danger"></p>--}}
                            {{--</div>--}}
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2" for="form-sex">性别</label>
                            <div class="col-lg-10">
                                <label class="radio-inline">
                                    <input type="radio" name="User[sex]" value="男" {{isset(old('User')['sex'])&&old('User')['sex']=='男'?"checked='checked'":''}}>男
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="User[sex]" value="女" {{isset(old('User')['sex'])&&old('User')['sex']=='女'?"checked='checked'":''}}>女
                                </label>
                            </div>
                        </div>
                        {{--隐藏的管理员属性--}}
                        @if(Request::getPathInfo()=='/admin')
                        <input value="1" type="hidden" name="User[isAdmin]" id="form-isAdmin">
                        @endif

                        <div class="form-group validate_div">
                            {{--验证码--}}
                            <label class="control-label col-lg-2" for="form-validate">验证码</label>
                            <div class="col-lg-5">
                                <input type="text" name="User[validate]" placeholder="请输入验证码" class="form-validate form-control" id="form-validate">
                            </div>
                            <div class="col-lg-5">
                                {{--{{Validator::verifyImage()}}--}}
                                <img id="validator" src="{{url('home/validate',['sole'=>0])}}">
                                <br>
                                <a role="button"  href="javascript:void(0)" id="validator_link">看不清？换一张</a>
                                <script type="text/javascript">
//                                    var num=1;
                                    var validator=document.getElementById('validator_link');
                                    var sole=0;
                                    eventUtil.addHandler(validator,'click',function () {
                                        //切换验证图片
                                        sole++;
                                        var img=document.getElementById('validator');
                                        var url="home/validate/"+sole;
                                        img.src=url;
                                        //alert(img.src);
                                    });
                                </script>
                                {{--<p class="form-control-static text-danger"></p>--}}
                            </div>
                        </div>
                        
                        <button onclick="submitRegister();" type="button" class="btn">注  册</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>