<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/9 0009
 * Time: 下午 14:41
 */

namespace App\Http\Controllers;

use App\Libs\Activity\Activity;
use App\Libs\Heat\Heat;
use App\Libs\JumpHelper\JumpHelper;
use App\Member;
use App\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Libs\Avatar\Avatar;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

/**
 * 用户的相关资料的控制器
 * Class DataController
 * @package App\Http\Controllers
 */
class DataController extends Controller {

    /**
     * 用户上传头像逻辑处理
     * @param Request $request
     * @param 需要更换头像的用户id
     */
    public function uploadPortrait(Request $request,$id){
        //得到头像的数据
        $file=Input::file('avatarToUpload');
        $file_arr=array();
        $file_arr['name']=$file->getClientOriginalName();
        $file_arr['size']=$file->getSize();
        $file_arr['type']=$file->getMimeType();
        $file_arr['tmp_name']=$file->getRealPath();
        $file_arr['error']=$file->getError();
//        return response()->json(array(
//                'msg' => '上传失败'));
        //上传到本地
        $msg=Avatar::uploadFile($file_arr);
        //如果文件上传成功
        if(is_array($msg)){
            //得到路径
            $new_path=$msg[0];
            //删除该用户原来的头像
            $user=Member::find($id);
            $split=explode('/',$new_path);
            $prefix="$split[0]/$split[1]";
            $old_path="$prefix/$user->portrait";
            Avatar::deleteFile($old_path);
            //将数据库中的头像路径更换成新的
            $user->portrait=end($split);
            //如果保存数据成功
            if($user->save()){
                return Response::json(['success'=>true,
                'avatar'=>$new_path]);
            }
            else{
                return Response::json(['success'=>false,
                    'error'=>'图片保存失败']);
            }
        }
        else{
            return Response::json(['success'=>false,'error'=>$msg]);
        }

    }

    /**
     * 用户运动页面
     */
    public function mySport(Request $request,$id=null){
        date_default_timezone_set("PRC");
        if ($request->isMethod('POST')) {
            $sh = $request->input('start_hour');
            $sm = $request->input('start_minute');
            $ss = $request->input('start_second');
            $eh = $request->input('end_hour');
            $em = $request->input('end_minute');
            $es = $request->input('end_second');
            $distance=$request->input('distance');
            $data=array('distance'=>$distance);
            //验证表单信息
            $validator = \Validator::make($data, ['distance' => "required|integer"],//多个规则用|分隔一下即可，必须，且最短为2个字符
                ['required' => ':attribute 为必填项',
                    'integer'=>':attribute 为整数'],     //attribute是占位符
                ['distance' => '距离']);
            //验证失败，重定向
            if ($validator->fails()) {
                Session::flash('error','上传运动失败');
                return redirect()->back()->withErrors($validator)->withInput();//数据保持，默认所有的request
            }
            //成功，并获取当前时间
            $year=date("y",time());
            $month=date('m',time());
            $day=date('d',time());
            //时间处理，转换为unix时间戳
            $startTime=strtotime('20'.$year.'-'.$month.'-'.$day.' '.$sh.':'.$sm.':'.$ss);
            $endTime=strtotime('20'.$year.'-'.$month.'-'.$day.' '.$eh.':'.$em.':'.$es);
            $date='20'.date("ymd",time());
            //获取用户体重
            $weight=Member::find($id)->weight;
            $heat=Heat::calculateHeat($weight,$startTime,$endTime,$distance);
            $sport_data=array('userId'=>$id,'startTime'=>$startTime,'endTime'=>$endTime,
                'date'=>$date,'distance'=>$distance,'heat'=>$heat);
            //创建新数据
            $sport=Sport::create($sport_data);
            //读取当天的运动数据
            $sports=Sport::where(['userId'=>$id,'date'=>$date])->get();
            //计算运动总公里数
            $all_distance=Heat::calculateAllDistance($sports);
            $all_hour=Heat::calculateAllHour($sports);
            $all_minute=Heat::calculateAllMinute($sports);
            $all_heat=Heat::calculateAllHeat($sports);
            //给用户增加活跃度
            Activity::addActivity($id);
            $arr=JumpHelper::jumpUIWith();
            if($arr){
                return view('myPage.sport',['user'=>$arr[0],
                                            'activity_show'=>$arr[1],
                                            'sports'=>$sports,
                                            'distance'=>$all_distance,
                                            'hour'=>$all_hour,
                                            'minute'=>$all_minute,
                                            'heat'=>$all_heat,
                                            'year'=>'20'.$year,
                                            'month'=>$month,
                                            'day'=>$day]);
            }
            else{
                return view('errors.503');
            }
        }
        //get请求
        else{
            $arr=JumpHelper::jumpUIWith();
            if($arr){
                //读取当天的运动数据
                $sports=Sport::where(['userId'=>$arr[0]->id,'date'=>'20'.date("ymd",time())])->get();
                //计算运动总公里数
                $all_distance=Heat::calculateAllDistance($sports);
                $all_hour=Heat::calculateAllHour($sports);
                $all_minute=Heat::calculateAllMinute($sports);
                $all_heat=Heat::calculateAllHeat($sports);
                if(Session::get('error')=='上传运动失败'){
                    return view('myPage.sport',['user'=>$arr[0],
                        'activity_show'=>$arr[1],
                        'sports'=>$sports,
                        'distance'=>$all_distance,
                        'hour'=>$all_hour,
                        'minute'=>$all_minute,
                        'heat'=>$all_heat,
                        'year'=>'20'.date("y",time()),
                        'month'=>date("m",time()),
                        'day'=>date("d",time()),
                        'error'=>'上传运动失败']);
                }
                else{
                    return view('myPage.sport',['user'=>$arr[0],
                        'activity_show'=>$arr[1],
                        'sports'=>$sports,
                        'distance'=>$all_distance,
                        'hour'=>$all_hour,
                        'minute'=>$all_minute,
                        'heat'=>$all_heat,
                        'year'=>'20'.date("y",time()),
                        'month'=>date("m",time()),
                        'day'=>date("d",time())]);
                }
            }
            else{
                return view('errors.503');
            }
        }
    }

    /**
     * 用户资料页面
     */
    public function myData(Request $request){
        $arr=JumpHelper::jumpUIWith();
        if(Session::get('error')=='修改资料失败'){
            if($arr){
                return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改资料失败']);
            }
            else{
                return view('errors.503');
            }
        }
        if(Session::get('error')=='修改密码失败'){
            if($arr){
                return view('myPage.data',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改密码失败']);
            }
            else{
                return view('errors.503');
            }
        }
        return JumpHelper::jumpUI('myPage.data');
    }

    /**
     * 用户历史数据页面
     */
    public function historyStatistic(Request $request){
        return JumpHelper::jumpUI('myPage.statistic');
    }

    /**
     * 查看其它用户资料
     */
    public function checkData(Request $request,$id){
        if(JumpHelper::isSessionSet()||JumpHelper::isCookieSet()){
            $arr=Activity::calculateActivity($id);
            //获取查看的用户信息
            $other=Member::find($id);
            return view('other.user',['user'=>$arr[0],'activity_show'=>$arr[1],'other'=>$other]);
        }
        return view('errors.503');
    }

    /**
     * 用户修改资料
     * @param $id
     */
    public function modifyData(Request $request,$id,$tag=null){
        if ($request->isMethod('POST')) {
            $data = $request->input('User');
            //验证表单信息
            $validator = \Validator::make($data, ['username' => "required|min:2|max:20",
                'age'=>'required|integer',
                'sex' => 'required',
                'email' => 'required|email',
                'height'=>'required|regex:/^\d+\.?\d*$/',
                'weight'=>'required|regex:/^\d+\.?\d*$/',],//多个规则用|分隔一下即可，必须，且最短为2个字符
                ['required' => ':attribute 为必填项',
                    'min' => ':attribute 长度不符合要求',
                    'max' => ':attribute 长度不符合要求',
                    'email' => ':attribute 格式不正确',
                    'integer'=>':attribute 为整数',
                    'regex'=>':attribute 为数字'],     //attribute是占位符
                ['username' => '用户名',
                    'email' => '邮箱',
                    'age'=>'年龄',
                    'sex' => '性别',
                    'height'=>'身高',
                    'weight'=>'体重']);
            //验证失败，重定向
            if ($validator->fails()) {
                Session::flash('error','修改资料失败');
                return redirect()->back()->withErrors($validator)->withInput();//数据保持，默认所有的request
            }
            //验证成功
            $user=Member::find($id);
            $user->username=$data['username'];
            $user->age=$data['age'];
            $user->email=$data['email'];
            $user->sex=$data['sex'];
            $user->height=$data['height'];
            $user->weight=$data['weight'];
            $user->save();
            //管理员
            if($tag=='admin'){
                return redirect('admin/data');
            }
            return redirect('my/data');

        }
    }

    /**
     * 用户修改密码
     */
    public function modifyPassword(Request $request,$id,$tag=null){
        if ($request->isMethod('post')) {
            $user=Member::find($id);
            $password=$user->password;
            $data = $request->input('User');
            $data['old']=md5($data['old']);
            //验证表单信息
            $validator = \Validator::make($data, ['old' => "required|regex:/$password/",
                'new'=>'required|min:6|max:20'],//多个规则用|分隔一下即可，必须，且最短为2个字符
                ['required' => ':attribute 为必填项',
                    'min' => ':attribute 长度不符合要求',
                    'max' => ':attribute 长度不符合要求',
                    'regex'=>':attribute 错误'],     //attribute是占位符
                ['old' => '原密码',
                    'new' => '新密码']);
            //验证失败，重定向
            if ($validator->fails()) {
                Session::flash('error','修改密码失败');
                return redirect()->back()->withErrors($validator);//数据保持，默认所有的request
            }

            //成功
            $user->password=md5($data['new']);
            $user->save();
            //管理员
            if($tag=='admin'){
                return redirect('admin/data');
            }
            return redirect('my/data');
        }
    }


    /**
     * 获取用户资料
     */
    public function getUserData(Request $request,$id){
//        return response()->json(array('msg'=>$id));
        $user=Member::find($id);
        return response()->json(array('username'=>$user->username,'email'=>$user->email,
            'age'=>$user->age,'sex'=>$user->sex,
            'height'=>$user->height,'weight'=>$user->weight));
    }

    /**
     * 得到用户每天的运动信息
     * @param Request $request
     * @param $id
     */
    public function getSportPerDay(Request $request,$id){
        date_default_timezone_set("PRC");
        $date=date("Ymd",time());
        $sports=Sport::where(['userId'=>$id,'date'=>$date])->get();
        $arr=array();
        for($i=0;$i<24;$i++){
            $arr[$this->transferDouble($i)]='0';
        }
        foreach ($sports as $sport){
            $st=$sport->startTime;
            $et=$sport->endTime;
            $lower=date("H",$st);
            $upper=date("H",$et);
            for($i=$lower;$i<=$upper;$i++){
                if($i==$lower){
                    if($arr[$lower]!=0){
                        $arr[$this->transferDouble($i)]=$arr[$lower]>$sport->distance?$arr[$lower]:$sport->distance;
                    }
                    else{
                        $arr[$this->transferDouble($i)]=$sport->distance;
                    }
                }
                else{
                    $arr[$this->transferDouble($i)]=$sport->distance;
                }
            }
        }
        return response()->json($arr);
    }

    /**
     * 单字节数字变为双字节
     * @param $i
     * @return string
     */
    private function transferDouble($i){
        if($i<10&&strlen($i)==1){
            return '0'.$i;
        }
        return $i;
    }

    /**
     * 得到用户最近运动的最近七天记录
     * @param Request $request
     * @param $id
     */
    public function getSportRecentDay(Request $request,$id){
        $sports=DB::table('relax_sport')->select(DB::raw('date,sum(distance) as dist'))
            ->where('userId','=',$id)->groupBy('date')->
            orderBy('date','desc')->take(7)->get();
        //数据处理
        $arr=array();
        $i=0;
        foreach ($sports as $sport){
            $month=substr($sport->date,4,2);
            $day=substr($sport->date,6,2);
            $arr[$i]=array('date'=>$month.'-'.$day,'dist'=>$sport->dist);
            $i++;
        }

        return response()->json($arr);
    }

    /**
     * 得到男女性别人数
     */
    public function getSex(Request $request){
        $count_man=Member::where(['sex'=>'男','isAdmin'=>0])->count();
        $count_woman=Member::where(['sex'=>'女','isAdmin'=>0])->count();
        return response()->json(array('man'=>$count_man,'woman'=>$count_woman));
    }


    /**
     * 得到用户的运动统计
     */
    public function getSportStatistic(Request $request,$id,$year,$month=null){
        if($month==null){
            $sports=Sport::where('date','like',"$year%")->where('userId','=',$id)->get();
            $arr=array('01'=>0,'02'=>0,'03'=>0,'04'=>0,'05'=>0,'06'=>0,'07'=>0,
                '08'=>0,'09'=>0,'10'=>0,'11'=>0,'12'=>0);
            foreach ($sports as $sport){
                $arr[substr($sport->date,4,2)]+=$sport->distance;
            }
            return response()->json($arr);
        }
        else{
            $sports=Sport::where('date','like',"$year$month%")->where('userId','=',$id)->get();
            $arr=array();
            $day=$this->returnDayPerMonth($year,$month);
            for($i=1;$i<=$day;$i++){
                if($i<10){
                    $arr['0'.$i]=0;
                }
                else{
                    $arr[$i]=0;
                }
            }
            foreach ($sports as $sport){
                $arr[substr($sport->date,6,2)]+=$sport->distance;
            }
            return response()->json($arr);
        }

    }

    /**
     * 返回每月天数
     */
    private function returnDayPerMonth($year,$month){
        $arr=array(31,28,31,30,31,30,31,31,30,31,30,31);
        if($this->isLeapYear($year)&&$month==2){
            return 29;
        }
        else{
            return $arr[$month-1];
        }
    }

    /**
     * 判断闰年
     * @param $year
     * @return bool
     */
    private function isLeapYear($year){
        return (($year%4==0&&$year%100!=0)||$year%400==0);
    }

}