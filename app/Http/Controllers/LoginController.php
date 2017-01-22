<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/5 0005
 * Time: 下午 15:30
 */
namespace App\Http\Controllers;
use App\Friend;
use App\Info;
use App\Libs\JumpHelper\JumpHelper;
use App\Libs\Validator\Validator;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

/**
 * 用户登陆注册以及主页展示
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller {

    /**
     * 主页
     * @return 返回主页视图
     */
    public function home(Request $request){
        if(Session::get('error')=='注册失败'){
            //return 'hello';
            return view('home.index',['error'=>'注册失败']);
        }
        if(Session::get('error')=='登陆失败'){
            return view('home.index',['error'=>'登陆失败']);
        }
        return view('home.index');
    }

    /**
     * 用户登陆的逻辑处理
     */
    public function userLogin(Request $request){
        if($request->isMethod('POST')){
            $data=$request->input('User');
            $username=$data['username'];
            $password=md5($data['password']);
            $autoFlag=isset($data['auto_login'])?$data['auto_login']:0;
            $user=Member::where('username','=',$username)->first();
            //如果用户名和密码匹配成功
            if(isset($user->password)&&$user->password==$password&&!$user->isAdmin){
                //如果设置了自动登陆,设置cookie
                if($autoFlag){
                    $this->setCookie($user->id,$user->username);
                }
                //存入Session
                $this->setSession($user->id,$user->username);
                //跳转到个人主页
                return redirect('my');
            }
            else{
                return redirect()->back()->with('error','登陆失败');
            }
        }

        return view('errors.503');
    }

    /**
     * 管理员登陆的逻辑处理
     */
    public function adminLogin(Request $request){
        if($request->isMethod('POST')){
            $data=$request->input('User');
//            dd($data);exit;
            $username=$data['username'];
            $password=md5($data['password']);
            $autoFlag=isset($data['auto_login'])?$data['auto_login']:0;
            $user=Member::where('username','=',$username)->first();
            //如果用户名和密码匹配成功
            if(isset($user->password)&&$user->password==$password&&$user->isAdmin){
                //如果设置了自动登陆,设置cookie
                if($autoFlag){
                    $this->setCookie($user->id,$user->username);
                }
                //存入Session
                $this->setSession($user->id,$user->username);
                //跳转到个人主页
                return redirect('my');
            }
            else{
                return redirect()->back()->with('error','登陆失败');
            }
        }

        return view('errors.503');
    }

    /**
     * 注册的逻辑处理
     */
    public function register(Request $request){
        date_default_timezone_set("PRC");
        if ($request->isMethod('POST')) {
            //取得后台验证码,并转换成小写字符串
            $verify = strtolower(Session::get('verify'));
            //将表单的验证码同时转换为小写
            $data = $request->input();
            $data['User']['validate'] = strtolower($data['User']['validate']);
            //dd($data);
            //dd($verify);exit;
            //验证表单信息
            $validator = \Validator::make($data, ['User.username' => "required|min:2|max:20",
                'User.password' => 'required|min:6|max:20',
                'User.email' => 'required|email',
                'User.sex' => 'required',
                'User.validate' => "required|regex:/^$verify$/"],//多个规则用|分隔一下即可，必须，且最短为2个字符
                ['required' => ':attribute 为必填项',
                    'min' => ':attribute 长度不符合要求',
                    'max' => ':attribute 长度不符合要求',
                    'email' => ':attribute 格式不正确',
                    'regex' => ':attribute 错误'],     //attribute是占位符
                ['User.username' => '用户名',
                    'User.password' => '密码',
                    'User.email' => '邮箱',
                    'User.sex' => '性别',
                    'User.validate' => '验证码']);
            //验证失败，重定向
            if ($validator->fails()) {
//                dd($validator->errors()->all());exit;
                Session::flash('error', '注册失败');
                return redirect()->back()->withErrors($validator)->withInput();//数据保持，默认所有的request
            }
            //注册成功
            $user = $data['User'];
            //删除数据中的验证码字段
            unset($user['validate']);
            //密码采用MD5加密
            $user['password'] = md5($user['password']);
            //身高体重默认值
            if ($user['sex']=='男'){
                $user['height'] = 170;
                $user['weight'] = 60;
            }
            else{
                $user['height'] = 160;
                $user['weight'] = 50;
            }
            //新的用户插入数据库
            $new_user = Member::create($user);
            //并且为用户建立好友表数据（自己对自己）
            $id=Member::max('id');
            if(!isset($user['isAdmin'])){
                $friend=Friend::create(['userId'=>$id,'friendId'=>$id]);
            }
            //并且为自己建立未读消息列表
            Info::create(['userId'=>$id,'time'=>time()]);
            if ($new_user) {      //这个方法要在model里设置批量赋值
                //存入Session
                $this->setSession($new_user->id,$new_user->username);
                //跳转到个人主页
                return redirect('my')->with('success', '添加成功！');
            } else {
                return redirect()->back();
            }
        }
        return view('errors.503');
    }

    /**
     * 生成验证码图片
     */
    public function validator($sole){
        //调用验证码生成器，param分别为验证码类型，验证字符个数，点数，线条数
        Validator::verifyImage(3,4,20,5);
    }

    /**
     * 判断注册时用户名的唯一性(ajax)
     */
    public function judgeNameUnique(){
        $username=Input::get('username');
        //得到所有用户
        //$users=Member::all();
        //遍历是否用户名与已有的重复，算法效率较低，可以选择索引优化
        //另一种思路，因为已为用户表的username字段设置了唯一约束
        //所以若插入失败，则代表重复；插入成功再删除
        //直接上第三种思路，如下
        if(Member::where('username','=',$username)->first()){
            return response()->json(array(
                'msg' => '用户名重复'));
        }
        return response()->json(array(
            'msg' => '用户名唯一'));
    }

    /**
     * 跳转到个人主页
     * @param Request $request
     */
    public function myPage(Request $request){
        return JumpHelper::jumpLogin('myPage.my','admin.my');
    }

    /**
     * 用户注销当前账号，登出
     */
    public function userLogout(Request $request){
        return $this->logout('home');
    }

    /**
     * 管理员注销当前账号，登出
     */
    public function adminLogout(Request $request){
        return $this->logout('admin');
    }


    /**
     * 设置cookie
     */
    private function setCookie($id,$username){
        Cookie::queue('userid',$id,time()+7*24*3600);
        Cookie::queue('username',$username,time()+7*24*3600);
    }

    /**
     * 设置session
     */
    private function setSession($id,$username){
        Session::put('userid',$id);
        Session::put('username',$username);
    }

    /**
     * 注销登陆
     * @param $view
     * @return
     */
    private function logout($view){
        //清空session
        Session::flush();
        $session_name=Cookie::get(session_name());
        if(isset($session_name)){
            Session::queue(session_name(),"",time()-1);
        }
        //重定向到主页
        return redirect($view);
    }


}
