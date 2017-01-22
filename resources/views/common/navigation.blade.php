<nav class="mainmenu">
    <div class="container">
        <div class="dropdown">
            <div class="row">
                <div class="col-lg-1">
                    <button onclick="roll();" type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <!-- <a data-toggle="dropdown" href="#">Dropdown trigger</a> -->
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a id="login_link" href='{{url("my/sport")}}' class="{{Request::getPathInfo()=="/my/sport"?'active':''}} link btn btn-link"><img src="{{asset('static/images/my/nav/run.png')}}" /><span>&nbsp;&nbsp;&nbsp;我的运动</span></a></li>
                        <li><a id="register_link" href='{{url("my/data")}}' class="{{Request::getPathInfo()=="/my/data"?'active':''}} link btn btn-link"><img src="{{asset('static/images/my/nav/data.png')}}" /><span>&nbsp;&nbsp;&nbsp;我的资料</span></a></li>
                        <li><a id="back_link" href='{{url("my/statistic")}}' class="{{Request::getPathInfo()=="/my/statistic"?'active':''}} link btn btn-link"><img src="{{asset('static/images/my/nav/chart.png')}}" /><span>&nbsp;&nbsp;&nbsp;历史数据</span></a></li>
                    </ul>
                </div>

                <div class="col-lg-1 col-lg-offset-10">
                    <button onclick="roll();" type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <!-- <a data-toggle="dropdown" href="#">Dropdown trigger</a> -->
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a id="activity_link" href='{{url("my/activity")}}' class="{{Request::getPathInfo()=="/my/activity"?'active':''}} link btn btn-link"><img src="{{asset('static/images/my/nav/event.png')}}" /><span>&nbsp;&nbsp;&nbsp;活&nbsp;&nbsp;动</span></a></li>
                        <li><a id="friend_link" href='{{url("my/friend")}}' class="{{Request::getPathInfo()=="/my/friend"?'active':''}} link btn btn-link"><img src="{{asset('static/images/my/nav/friend.png')}}" /><span>&nbsp;&nbsp;&nbsp;消息圈</span></a></li>
                        <li><a id="hotUsers_link" href='{{url("my/hot")}}' class="{{Request::getPathInfo()=="/my/hot"?'active':''}} link btn btn-link">&nbsp;&nbsp;&nbsp;<img src="{{asset('static/images/my/nav/hot.png')}}" /><span>&nbsp;&nbsp;&nbsp;热门用户</span></a></li>
                        {{--<li><a id="logout_link" href="#" class="link btn btn-link"><img src="{{asset('static/images/my/nav/hot.png')}}" /></span>&nbsp;注销</a></li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
    function roll() {
        window.scroll(0,0);
    }
</script>