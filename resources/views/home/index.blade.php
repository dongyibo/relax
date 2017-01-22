<!DOCTYPE html>
<html lang="en" style="background: #505D6E url(static/images/home/bg.jpg) no-repeat center center fixed">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Relax - Your Sports Community</title>

    <link rel="shortcut icon" href="{{asset('static/images/walk.png')}}">

    <!-- Bootstrap -->
    {{--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">--}}
    <link rel="stylesheet" href="{{asset('static/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('static/css/style.css')}}">
    <!-- 自定义css文件 -->
    <link rel="stylesheet" href="{{asset('static/css/home.css')}}">
    <!-- 部分需要提前的js文件 -->
    <script src="{{asset('static/js/eventHandler.js')}}"></script>
</head>

<body class="theme-invert">

    <nav class="mainmenu">
        <div class="container">
            <div class="dropdown">
                <button type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <!-- <a data-toggle="dropdown" href="#">Dropdown trigger</a> -->
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a id="login_link" href="javascript:void(0)" class="link btn btn-link">login</a></li>
                    <li><a id="register_link" href="javascript:void(0)" class="link btn btn-link">register</a></li>
                    <li><a id="back_link" href="javascript:void(0)" class="link btn btn-link">home</a></li>
                </ul>
            </div>
        </div>
    </nav>


<!-- Main (Home) section -->
    <section class="section" id="head">
        <div class="container">

            <div class="row">
                <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">

                    <!-- Site Title, your name, HELLO msg, etc. -->
                    <h1 class="title">Relax</h1>
                    <h2 class="subtitle">A free sports and social networking website</h2>
                    <!-- Short introductory (optional) -->
                    <h3 class="tagline">
                        @if(Request::getPathInfo()=='/home')
                        在Relax中，你将获得最佳的运动体验，你将与一群志同道合的朋友一起参与运动！
                        @else
                        Relax 大型运动社区，需要你们的管理~
                        @endif
                    </h3>

                    <!-- Nice place to describe your site in a sentence or two -->
                    <div clas="row">
                        <div class="col-md-2 col-md-offset-4">
                            <span><a id="login_btn" href="javascript:void(0)" class="btn btn-default btn-lg">登录</a></span>
                        </div>
                        <div class="col-md-2">
                            <span><a id="register_btn" href="javascript:void(0)" class="btn btn-default btn-lg">注册</a></span>
                        </div>
                    </div>

                </div> <!-- /col -->
            </div> <!-- /row -->

        </div>

    </section>

    @include('home.login');
    @include('home.register');
    @if(isset($error)&&$error=='注册失败')
        {{--保留原来的注册页面--}}
        <script>
            var main=document.getElementById('head');
            main.style.display='none';
            var register=document.getElementById('register');
            register.style.display='block';
        </script>
    @endif
    @if(isset($error)&&$error=='登陆失败')
        {{--保留原来的注册页面--}}
        <script>
            var main=document.getElementById('head');
            main.style.display='none';
            var login=document.getElementById('login');
            login.style.display='block';
            alert('登陆失败!');
        </script>
    @endif
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Relax 2016 </p>
        </div>
    </footer>
<!-- jQuery 文件 -->
<script src="{{asset('static/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap JavaScript 文件 -->
<script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('static/js/modernizr.custom.72241.js')}}"></script>
<!-- Custom template scripts -->
<script src="{{asset('static/js/eventHandler.js')}}"></script>
<script src="{{asset('static/js/home.js')}}"></script>
</body>
</html>