<?php

namespace App\Libs\JumpHelper;
use Illuminate\Http\Request;
use App\Libs\Activity\Activity;
use App\Member;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
/**
 * 界面跳转工具类
 * Class JumpHelper
 * @package App\Libs\JumpHelper
 */
class JumpHelper{

    /**
     * 当前用户的各个界面跳转
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function jumpUI($view){
        //session 访问
        if(self::isSessionSet()){
            $id_session=self::getIdBySession();
            $arr=Activity::calculateActivity($id_session,false);
            return view($view,['user'=>$arr[0],'activity_show'=>$arr[1]]);
        }
        //cookie 访问
        elseif (self::isCookieSet()){
            $id_cookie=self::getIdByCookie();
            $arr=Activity::calculateActivity($id_cookie,false);
            return view($view,['user'=>$arr[0],'activity_show'=>$arr[1]]);
        }
        else{
            return view('errors.503');
        }
    }

    /**
     * 当前用户的各个界面跳转
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function jumpUIWith(){
        //session 访问
        if(self::isSessionSet()){
            $id_session=self::getIdBySession();
            $arr=Activity::calculateActivity($id_session,false);
            return $arr;
        }
        //cookie 访问
        elseif (self::isCookieSet()){
            $id_cookie=self::getIdByCookie();
            $arr=Activity::calculateActivity($id_cookie,false);
            return $arr;
        }
        else{
            return false;
        }
    }

    /**
     * 用户登录跳转到个人主页
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function jumpLogin($view_user,$view_admin){
        //session 登陆
        if(self::isSessionSet()){
            $id_session=self::getIdBySession();
            $isAdmin=Member::find($id_session)->isAdmin;
            //增加活跃度
            $arr=Activity::calculateActivity($id_session,true);
            //管理员
            if($isAdmin){
                if(Session::get('error')=='修改资料失败'){
                        return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改资料失败']);
                }
                if(Session::get('error')=='修改密码失败'){
                        return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改密码失败']);
                }
                return view($view_admin,['user'=>$arr[0],'activity_show'=>$arr[1]]);
            }
            //普通用户
            else{
                $users=Member::where('isAdmin','=',0)->orderby('activity','desc')->take(6)->get();
                return view($view_user,['user'=>$arr[0],'activity_show'=>$arr[1],'users'=>$users]);
            }
        }
        //cookie 登陆
        elseif (self::isCookieSet()){
            $id_cookie=self::getIdByCookie();
            $isAdmin=Member::find($id_cookie)->isAdmin;
            //增加活跃度
            $arr=Activity::calculateActivity($id_cookie,true);
            //管理员
            if($isAdmin){
                if(Session::get('error')=='修改资料失败'){
                    return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改资料失败']);
                }
                if(Session::get('error')=='修改密码失败'){
                    return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改密码失败']);
                }
                return view($view_admin,['user'=>$arr[0],'activity_show'=>$arr[1]]);
            }
            //普通用户
            else{
                $users=Member::where('isAdmin','=',0)->orderby('activity','desc')->take(6)->get();
                return view($view_user,['user'=>$arr[0],'activity_show'=>$arr[1],'users'=>$users]);
            }
        }
        else{
            return view('errors.503');
        }
    }

    /**
     * 判断是否设置了session
     * 如果设置了返回用户id，否则返回null
     * @return null
     */
    public static function isSessionSet(){
        $username_session=Session::get('username');
        if(isset($username_session)){
            return true;
        }
        return false;
    }

    /**
     * 判断是否设置了session
     * 如果设置了返回用户id，否则返回null
     * @return null
     */
    public static function isCookieSet(){
        $username_cookie=Cookie::get('username');
        if(isset($username_cookie)){
            return true;
        }
        return false;
    }

    /**
     * 通过session返回用户id
     * @return mixed
     */
    public static function getIdBySession(){
        $id_session=Session::get('userid');
        return $id_session;
    }

    /**
     * 通过cookie返回用户id
     * @return mixed
     */
    public static function getIdByCookie(){
        $id_cookie=Cookie::get('userid');
        return $id_cookie;
    }



}