<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top" style="background: #f8f8f8">
                    <div class="form-top-left">
                        <h2>Relax运动社区</h2>
                        <h4>请输入您的用户名和密码 ~</h4>
                    </div>
                    <div class="form-top-right">
                        <i class="fa fa-key"></i>
                    </div>
                </div>
                <div class="form-bottom" style="background-image: url(static/images/home/panel3.png)">
                    @if(Request::getPathInfo()=='/home')
                    <form role="form" action="{{url('home/userLogin')}}" method="post" class="login-form">
                    @else
                    <form role="form" action="{{url('home/adminLogin')}}" method="post" class="login-form">
                    @endif
                        {{csrf_field()}} {{-- 生成一个隐藏的表单，生成一个token字段 --}}
                        <div class="form-group">
                            <label class="sr-only" for="login-username">Username</label>
                            <input type="text" name="User[username]" placeholder="请输入您的用户名" class="form-username form-control" id="login-username">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="login-password">Password</label>
                            <input type="password" name="User[password]" placeholder="请输入您的密码" class="form-password form-control" id="login-password">
                        </div>
                        <div class="form-group">
                            <div class="col-lg-1">
                                <input id="login-auto" value="1" type="checkbox" name="User[auto_login]">
                            </div>
                            <label for="login-auto" class="control-label col-lg-4" style="margin-left: -20px">自动登录（一周内）</label>
                        </div>
                        <br>
                        <button type="submit" class="btn">登  录</button>
                        <a href="javascript:void(0)" onclick="showRegister();">
                            <h6 class="control-label col-lg-4" style="margin-top: 5px">还没账号？请<span style="color: red">注册</span></h6>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>