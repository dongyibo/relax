<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test',['uses'=>'AdminController@test']);

//把web加入中间件，设置群路由
Route::group(['middleware'=>['web']],function(){
    //主页
    Route::any('home',['uses'=>'LoginController@home']);
    //用户登陆处理
    Route::any('home/userLogin',['uses'=>'LoginController@userLogin']);
    //管理员登陆处理
    Route::any('home/adminLogin',['uses'=>'LoginController@adminLogin']);
    //注册处理
    Route::any('home/register',['uses'=>'LoginController@register']);
    //验证码处理
    Route::any('home/validate/{sole}',['uses'=>'LoginController@validator']);
    //用户登出处理
    Route::any('home/userLogout',['uses'=>'LoginController@userLogout']);
    //管理员登出处理
    Route::any('home/adminLogout',['uses'=>'LoginController@adminLogout']);
    //个人主页处理
    Route::any('my',['uses'=>'LoginController@myPage']);
    //个人运动页面
    Route::any('my/sport/{id?}',['uses'=>'DataController@mySport']);
    //个人资料页面
    Route::any('my/data',['uses'=>'DataController@myData']);
    //历史数据页面
    Route::any('my/statistic',['uses'=>'DataController@historyStatistic']);
    //活动页面
    Route::any('my/activity',['uses'=>'EventController@activity']);
    //朋友圈页面
    Route::any('my/friend',['uses'=>'EventController@friend']);
    //热门用户页面
    Route::any('my/hot',['uses'=>'EventController@hotUsers']);
    //查看其它用户资料界面
    Route::any('user/{id}',['uses'=>'DataController@checkData']);
    //管理员登陆
    Route::any('admin',['uses'=>'LoginController@home']);
    //管理员资料管理
    Route::any('admin/data',['uses'=>'AdminController@adminData']);
    //管理员用户管理
    Route::any('admin/user/{tag?}/{user_id?}',['uses'=>'AdminController@manageUsers']);
    //管理员活动管理
    Route::any('admin/activity/{tag}',['uses'=>'AdminController@manageActivities']);
    //用户修改资料
    Route::any('data/modify/{id}/{tag?}',['uses'=>'DataController@modifyData']);
    //用户修改密码
    Route::any('data/password/{id}/{tag?}',['uses'=>'DataController@modifyPassword']);
    //用户搜索
    Route::any('my/user/search',['uses'=>'EventController@searchUsers']);
    //用户微博
    Route::any('my/blog/{id}',['uses'=>'EventController@releaseBlog']);
});

//ajax处理
Route::group(['prefix' => 'ajax'],function (){
    //判断用户名唯一性
    Route::post('register', ['uses'=>'LoginController@judgeNameUnique']);
    //上传头像
    Route::post('portrait/{id}',['uses'=>'DataController@uploadPortrait']);
    //上传活动数据
    Route::post('activity',['uses'=>'AdminController@releaseActivity']);
    //上传活动图片
    Route::post('activityImg',['uses'=>'AdminController@releaseActivityImg']);
    //用户参与与取消活动
    Route::post('activity/{tag}',['uses'=>'EventController@handleActivity']);
    //获取用户资料
    Route::get('data/{id}',['uses'=>'DataController@getUserData']);
    //获取用户每日的运动资料
    Route::get('userPerDay/{id}',['uses'=>'DataController@getSportPerDay']);
    //获取用户运动的最近七天的资料
    Route::get('userRecentDay/{id}',['uses'=>'DataController@getSportRecentDay']);
    //获取系统男女性别人数
    Route::get('sex',['uses'=>'DataController@getSex']);
    //获取系用户运动统计
    Route::get('sport/{id}/{year}/{month?}',['uses'=>'DataController@getSportStatistic']);
    //关注用户
    Route::post('fork',['uses'=>'EventController@forkUser']);
    //关注用户
    Route::post('cancelFork',['uses'=>'EventController@cancelFork']);
    //发表评论
    Route::post('comment',['uses'=>'EventController@releaseComment']);
    //删除评论
    Route::post('delComment',['uses'=>'EventController@deleteComment']);
    //删除微博
    Route::post('delBlog',['uses'=>'EventController@deleteBlog']);
    //点赞
    Route::post('praise',['uses'=>'EventController@praise']);
    //消息反馈
    Route::post('info',['uses'=>'EventController@recordInfo']);
//    //刷新热门消息
//    Route::get('hotActivities',['uses'=>'AdminController@refreshHot']);
//    //刷新热门消息
//    Route::get('hotActivitiesShow',['uses'=>'EventController@showHotActivities']);
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
