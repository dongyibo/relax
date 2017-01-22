<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                全部活动
            </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @for($i=0;$i<3;$i++)
                    @if($i<count($activities))
                    <div class="col-lg-4 content-item">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1">
                                <a href="javascript:void(0)" class="more_detail content-link" data-
                                   toggle="modal">
                                    <div class="caption">
                                        <div class="caption-content">
                                            <i class="fa fa-hand-o-right fa-3x"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <img class="event_img img-rounded" src="{{asset('uploads/activity/'.$activities[$i]->picture)}}">
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>{{$activities[$i]->name}}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{asset('static/images/my/activity/address.png')}}">
                                    </div>
                                    <div class="col-lg-10 address_div">
                                        <span class="activity_address">{{$activities[$i]->address}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{asset('static/images/my/activity/time.png')}}">
                                    </div>
                                    <div class="col-lg-10 time_div">
                                        <span class="activity_time">{{date('Y-m-d H:i:s',$activities[$i]->time)}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>已报名：</h5>
                                    </div>
                                    <div class="col-lg-6 people_num_div">
                                        <h4 class="h4_num">{{$activities[$i]->peopleSign}}</h4><span class="sprit">/</span><h4 class="h4_num">&nbsp;{{$activities[$i]->peopleLimit}}</h4>
                                    </div>
                                    <div class="col-lg-2 col-lg-offset-1">
                                        @if(!$user->isAdmin)
                                            <button onclick="joinActivity(this,{{$user->id}},{{$activities[$i]->id}},{{$activities[$i]->time}});" type="button" class="{{$attend[$i]==1?'btn-warning':'btn-primary'}} join_btn btn">{{$attend[$i]==1?'取消参与':'参与'}}</button>
                                        @else
                                            <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});" type="button" class="off_btn btn btn-primary">下台</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 content-item event_detail_div">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    详情
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12 event_detail_content">{{$activities[$i]->detail}}</div>
                                    <div class="col-lg-1 col-lg-offset-10">
                                        <a class="back_to_introduction" href="javascript:void(0)"><img class="back_icon" src="{{asset('static/images/my/activity/back.png')}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endfor
                </div>

                <div class="row">
                @for($i=3;$i<6;$i++)
                    @if($i<count($activities))
                    <div class="col-lg-4 content-item">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1">
                                <a href="javascript:void(0)" class="more_detail content-link" data-
                                   toggle="modal">
                                    <div class="caption">
                                        <div class="caption-content">
                                            <i class="fa fa-hand-o-right fa-3x"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <img class="event_img img-rounded" src="{{asset('uploads/activity/'.$activities[$i]->picture)}}">
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>{{$activities[$i]->name}}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{asset('static/images/my/activity/address.png')}}">
                                    </div>
                                    <div class="col-lg-10 address_div">
                                        <span class="activity_address">{{$activities[$i]->address}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="{{asset('static/images/my/activity/time.png')}}">
                                    </div>
                                    <div class="col-lg-10 time_div">
                                        <span class="activity_time">{{date('Y-m-d H:i:s',$activities[$i]->time)}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>已报名：</h5>
                                    </div>
                                    <div class="col-lg-6 people_num_div">
                                        <h4 class="h4_num">{{$activities[$i]->peopleSign}}</h4><span class="sprit">/</span><h4 class="h4_num">&nbsp;{{$activities[$i]->peopleLimit}}</h4>
                                    </div>
                                    <div class="col-lg-2 col-lg-offset-1">
                                        @if(!$user->isAdmin)
                                            <button onclick="joinActivity(this,{{$user->id}},{{$activities[$i]->id}},{{$activities[$i]->time}});" type="button" class="{{$attend[$i]==1?'btn-warning':'btn-primary'}} join_btn btn">{{$attend[$i]==1?'取消参与':'参与'}}</button>
                                        @else
                                            <button onclick="deleteActivity({{$activities[$i]->id}},{{$activities[$i]->time}});" type="button" class="off_btn btn btn-primary">下台</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 content-item event_detail_div">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    详情
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12 event_detail_content">{{$activities[$i]->detail}}</div>
                                    <div class="col-lg-1 col-lg-offset-10">
                                        <a class="back_to_introduction" href="javascript:void(0)"><img class="back_icon" src="{{asset('static/images/my/activity/back.png')}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endfor
            </div>

            {{--分页--}}
            <div class="row" id="desc_div">
                <div class="col-lg-6">
                    <div class="btn-toolbar btn_group_div" role="toolbar">
                        <div class="btn-group">
                            @if($user->isAdmin)
                                <a href="{{url('admin/activity/start')}}"><button type="button" class="{{Request::getPathInfo()=="/admin/activity/start"?'active':''}} btn btn-warning">按活动开始时间降序</button></a>
                                <a href="{{url('admin/activity/release')}}"><button id="release_desc_btn" type="button" class="{{Request::getPathInfo()=="/admin/activity/release"?'active':''}} btn btn-warning">按活动发布时间降序</button></a>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pull-right">
                        {{$activities->render()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>