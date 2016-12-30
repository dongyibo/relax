{{--搜索框--}}
<div class="row">
    <div class="col-lg-12">
        @if($user->isAdmin)
        <form name="search_user" class="form-horizontal" method="post" action="{{url('admin/user/search')}}">
        @else
        <form name="search_user" class="form-horizontal" method="post" action="{{url('my/user/search')}}">
        @endif
            {{csrf_field()}}
            <div class="col-lg-8 col-lg-offset-2">
                <input type="text" name="username" class="form-control" id="name" placeholder="请输入用户名">
    </div>
        </form>
        <div class="col-lg-2">
            <span>
                <input onclick="searchUsers();" type="image" src="{{asset('static/images/my/friend/search.png')}}">
            </span>
            <script type="text/javascript">
                function searchUsers() {
                    var name=document.getElementById('name').value;
                    if(name==''){
                        return;
                    }
                    document.search_user.submit();
                }
            </script>
        </div>
    </div>
</div>

@if(!$user->isAdmin&&isset($users))
<div class="row search_div" id="search_div">
    <div class="col-lg-12 search_list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">搜索列表</h3>
            </div>
            <div class="panel-body search_body_div">
                <div class="row">
                    @if(count($users)>0)
                        @foreach($users as $u)
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-1 search_list_avatar_div">
                                        <img class="search_list_avatar" src="{{$u->portrait?asset('uploads/avatar/'.$u->portrait):asset('static/images/my/temp.png')}}">
                                    </div>
                                    <div class="col-lg-8 search_list_avatar_div">
                                        <a href="{{url('user/'.$u->id)}}" target="_blank"><span class="search_name">{{$u->username}}</span></a>
                                    </div>
                                    <div class="col-lg-1 search_list_avatar_div">
                                        <a href="javascript:forkUser({{$user->id}},{{$u->id}});"><img class="search_list_avatar" src="{{asset('static/images/my/friend/fork.png')}}"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-2">
                            <h5>没有该用户~</h5>
                        </div>
                    @endif
                </div>
                <HR style="FILTER: progid:DXImageTransform.Microsoft.Shadow(color:#987cb9,direction:145,strength:15)" width="100%" color=#987cb9 SIZE=1>
                {{--分页--}}
                <div class="container pagination_div">
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-6">
                            <div class="col-lg-10 col-lg-offset-2">
                                <div class="pull-right">
                                    {{$users->render()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-lg-offset-11 close_panel_div">
                        <div class="col-lg-1 col-lg-offset-7">
                            <a href="javascript:closeSearch();"><img src="{{asset('static/images/my/friend/close2.png')}}"></a>
                        </div>
                        <script type="text/javascript">
                            function closeSearch() {
                                document.getElementById('search_div').style.display='none';
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
