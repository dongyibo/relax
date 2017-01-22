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
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>消息圈</h2>
            <hr class="star-primary">
        </div>
    </div>

    @include('common.search')

    @if(count($infos)>0)
    <div class="row" id="info_remind_div">
        <div class="col-lg-4 col-lg-offset-5 info_to_read">
            <button onclick="showInfos({{$user->id}});" type="button" class="btn btn-danger">您有 {{count($infos)}} 条未读消息</button>
        </div>
    </div>

    <div class="row" id="info_record_div">
        <div class="col-lg-8 col-lg-offset-2 info_to_read">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($infos as $info)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5>{{$info->username}} 给您的动态<span class="record_content">"{{substr($info->content,0,6)}}......"</span>
                                        @if(isset($info->commentId))
                                            评论了
                                        @else
                                            点赞了
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-lg-3 col-lg-offset-1">
                                    <h5>{{date('Y-m-d H:i:s',$info->created_at)}}</h5>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="col-lg-row">
                        <div class="col-lg-1 col-lg-offset-11">
                            <div class="col-lg-1 col-lg-offset-5">
                                <a href="javascript:closeRecord();"><img src="{{asset('static/images/my/friend/close2.png')}}"></a>
                            </div>
                            <script type="text/javascript">
                                function closeRecord() {
                                    document.getElementById('info_remind_div').style.display='none';
                                    document.getElementById('info_record_div').style.display='none';
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row friend_div">
        <div class="col-lg-4 friend_list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">关注列表</h3>
                </div>
                <div class="panel-body">
                    {{--好友列表--}}
                    <ul class="list-group" id="friend_list">
                        @foreach($friends as $friend)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img class="friend_list_avatar" src="{{$friend->portrait?asset('uploads/avatar/'.$friend->portrait):asset('static/images/my/temp.png')}}">
                                </div>
                                <div class="col-lg-6">
                                    <span>{{$friend->username}}</span>
                                </div>
                                <div class="col-lg-1 col-lg-offset-2">
                                    <a target="_blank" href="{{url('user/'.$friend->id)}}"><img title="用户资料" class="friend_list_icon" src="{{asset('static/images/my/friend/detail.png')}}"></a>
                                </div>
                                <div class="col-lg-1 delete_div_fork">
                                    {{--<a onclick="cancelFork({{$user->id}},{{$friend->id}},this);"><img class="friend_list_icon" src="{{asset('static/images/my/friend/delete.png')}}"></a>--}}
                                    <input title="取消关注" class="friend_list_icon" onclick="cancelFork({{$user->id}},{{$friend->id}},this);" type="image" src="{{asset('static/images/my/friend/delete.png')}}">
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{--发表动态--}}
        <div class="col-lg-8 blog_self_div">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">发表动态</h3>
                </div>
                <div class="panel-body">
                    {{--文本框--}}
                    <form enctype="multipart/form-data" name="blogForm" role="form" method="POST" action="{{url('my/blog/'.$user->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea id="blogContent" name="blogContent" placeholder="分享你的点点滴滴吧~" class="form-control" rows="3"></textarea>
                            <input type="file" name="blogImg" id="blog_file" onchange="fileChange();" style="display: none">
                        </div>
                    </form>
                </div>
                <div class="row publish_div">
                    <div class="row">
                        <div class="col-lg-3 error_prompt_div">
                            <p class="error_prompt_p">
                                @if(isset($picError))
                                    {{$picError}}
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-9">
                            <div class="col-lg-5 btn-group btn_double_group_div">
                                <button onclick="addPic();" type="button" class="btn btn-info">添加图片</button>
                                <button onclick="releaseBlog();" type="button" class="btn btn-primary">发布</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-9" id="file_path_icon" style="display:none;">
                            <span id="file_path"></span>
                            <a href="javascript:void(0)">
                                <img onclick="deleteFile();" src="{{asset('static/images/my/friend/close1.png')}}">
                            </a>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function releaseBlog() {
                            var blog=document.getElementById('blogContent').value;
                            if(blog==''){
                                alert('不能发空消息哦~');
                                return;
                            }
                            document.blogForm.submit();
                        }
                    </script>
                </div>
            </div>
            {{--朋友圈--}}
            <div class="container blog_div">
                @foreach($blogs as $blog)
                    <div class="row">
                        {{--每条动态--}}
                        <div class="col-lg-1">
                            <img  class="img-rounded blog_avatar" src="{{$blog->portrait?asset('uploads/avatar/'.$blog->portrait):asset('static/images/my/temp.png')}}">
                        </div>
                        <div class="col-lg-5">
                            <h4>{{$blog->username}}</h4>
                        </div>
                        <div class="col-lg-3 col-lg-offset-2" style="padding-left: 40px">
                            <h5>{{date('Y-m-d H:i:s',$blog->created_at)}}</h5>
                        </div>
                        @if($blog->userId==$user->id)
                        <div class="col-lg-1" style="padding-top: 5px">
                            <a href="javascript:void(0)"><img onclick="deleteBlog(this,{{$blog->blogId}});" src="{{asset('static/images/my/friend/delete1.png')}}"/></a>
                        </div>
                        @endif
                        <div class="col-lg-12 blog_content_div">
                            <p class="blog_content">{{$blog->content}}</p>
                        </div>
                        @if($blog->picture)
                        <div class="col-lg-12">
                            <img class="blog_img" src="{{asset('uploads/blog/'.$blog->picture)}}">
                        </div>
                        @endif
                        <div class="col-lg-2 col-lg-offset-9 blog_praise_div">
                            <div class="col-lg-4 col-lg-offset-2">
                                <a class="praise_btn" href="javascript:void(0)"><img onclick="praise(this,{{$user->id}},{{$blog->blogId}});" class="blog_icon" src="{{isset($blog->praiseOwn)?asset('static/images/my/friend/praise1.png'):asset('static/images/my/friend/praise.png')}}"></a>
                            </div>
                            <div class="col-lg-6 praise_count_div">
                                @if(isset($praises[$blog->blogId]))
                                <h5 class="praise_h5">{{count($praises[$blog->blogId])}}</h5>
                                @endif
                            </div>
                        </div>

                        {{--@if(isset($blog->praiseOwn))--}}
                            {{--hahah--}}
                        {{--@endif--}}
                        <div class="col-lg-1 blog_comment_div">
                            <a class="comment_btn" href="javascript:void(0)"><img class="blog_icon" src="{{asset('static/images/my/friend/comment.png')}}"></a>
                        </div>

                        <div class="col-lg-12">
                            @if(isset($praises[$blog->blogId]))
                            @foreach($praises[$blog->blogId] as $praise)
                            <h5 class="praise_users">{{$praise['username']}}</h5>
                            @endforeach
                            <h5 class="praise_users_set">觉得很赞</h5>
                            @endif
                        </div>

                        <div class="col-lg-12">
                            @if(isset($comments[$blog->blogId]))
                            @foreach($comments[$blog->blogId] as $comment)
                            <div class="row comment_content" onmouseover="showDelete(this,{{$user->id}},{{$comment['userId']}});" onmouseout="hideDelete(this,{{$user->id}},{{$comment['userId']}});">
                                <span class="comment_name">{{$comment['username']}}</span>
                                <span class="comment_name_colon">:</span>
                                <span>{{$comment['content']}}</span>
                                <a class="delete_span" href="javascript:void(0)"><span><img onclick="deleteComment(this,{{$comment['commentId']}});" src="{{asset('static/images/my/friend/close1.png')}}"></span></a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="comment_area panel-body col-lg-12 blog_comment_textarea">
                            {{--文本框--}}
                            <form role="form">
                                <div class="form-group">
                                    {{--<label for="name">文本框</label>--}}
                                    <textarea placeholder="发表您的观点吧~" class="form-control" rows="3"></textarea>
                                </div>
                            </form>
                            <div class="col-lg-1">
                                <a class="send_btn" href="javascript:void(0)"><img onclick="releaseComment(this,{{$blog->blogId}},{{$user->id}});" class="blog_icon" src="{{asset('static/images/my/friend/ok.png')}}"></a>
                            </div>
                            <div class="col-lg-1 blog_close_div">
                                <a class="close_btn" href="javascript:void(0)"><img class="blog_icon" src="{{asset('static/images/my/friend/close.png')}}"></a>
                            </div>
                        </div>
                    </div>
                    <HR class="HR" style="FILTER: progid:DXImageTransform.Microsoft.Glow(color=#987cb9,strength=10)" width="100%" color=#987cb9 SIZE=1>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{asset('static/css/auxiliary.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/fork.js')}}"></script>
    <link href="{{asset('static/css/friend.css')}}" rel="stylesheet">
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
    <script src="{{asset('static/js/friend.js')}}"></script>
@stop

@section('javascript')
    <script src="{{asset('static/js/friend.js')}}"></script>
    <script src="{{asset('static/js/avatarHandle.js')}}"></script>
@stop
