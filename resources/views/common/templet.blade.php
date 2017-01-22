<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Relax - Your Sports Community</title>
        <link rel="shortcut icon" href="{{asset('static/images/walk.png')}}">
        <link href="{{asset('static/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('static/css/my.css')}}" rel="stylesheet">
        <link href="{{asset('static/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        @section('css')
        @show
        <!-- 部分需要提前的js文件 -->
        <script src="{{asset('static/js/eventHandler.js')}}"></script>
        <script src="{{asset('static/jquery/jquery.form.js')}}"></script>
        <script src="{{asset('static/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('static/js/my.js')}}"></script>
    </head>

    <body id="page-top" class="index">
{{--    {{Request::getPathInfo()}}--}}
    {{--@if(Request::getPathInfo()!="/user/$user->id")--}}
    {{--@endif--}}
    @section('nav')
    @show
        <header id="head">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div id="prompt_head">   {{--style="height: 20px;--}}
                            <span class="prompt_text" id="prompt_head_span"></span>
                        </div>
                        <a href="javascript:void(0)"><img id="img_face" class="img-circle" @if($user->portrait==null)src="{{asset('static/images/my/temp.png')}}" @else src="{{asset('uploads/avatar/'.$user->portrait)}}"@endif alt="点击更换头像"></a>
                        {{--<form id="form_face" enctype="multipart/form-data" >--}}
                            {!! Form::open( [ 'url' => ["ajax/portrait/$user->id"], 'method' => 'POST', 'id' => 'upload', 'files' => true ] ) !!}
{{--                            {!! csrf_field() !!}--}}
                            <input type="file" name="avatarToUpload" id="form_file" onchange="fileSelected()" style="display:none;">
                            {{--<input type="submit" id="form_btn" style="display:none;">--}}
                            {!! Form::close() !!}
                        {{--</form>--}}
                    </div>
                    <div class="col-lg-10 intro-text">
                        <div class="row" style="margin-left: -150px">
                            <span id="user_name" class="col-lg-4 name">{{$user->username}}</span>
                        </div>
                        <div class="row">
                            <h4 id="my_level" class="col-lg-1">level:&nbsp;{{$user->level}}</h4>
                            <div id="prompt_activity" class="col-lg-2 col-lg-offset-2">
                                <span class="prompt_text" id="prompt_activity_span"></span>
                            </div>
                            @if(Request::getPathInfo()!="/user/$user->id")
                            <div class="col-lg-1 col-lg-offset-6" >
                                @section('logout')@show
                            </div>
                            @endif
                        </div>
                        <div id="progress" onmouseover="showActivity({{$user->level}},{{$user->activity}});" class="progress progress-striped active" style="width:1000px ;background-color: #fdfdc9">
                            <div id="activity" class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$activity_show}};">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <!-- content Grid Section -->
        <section id="content">
            <div class="container">
            @section('content')
            @show
            </div>
        </section>
    <!-- Footer -->
        <footer class="text-center">
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            Copyright &copy; Relax 2016.
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{asset('static/js/echarts.min.js')}}"></script>
        <script src="{{asset('static/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('static/js/my.js')}}"></script>
        <script src="{{asset('static/jquery/jquery.form.js')}}"></script>
        @section('javascript')
        @show
    </body>
</html>