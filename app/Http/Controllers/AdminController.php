<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/15 0015
 * Time: 下午 15:45
 */
namespace App\Http\Controllers;
use App\ActivityAttend;
use App\Blog;
use App\Comment;
use App\Friend;
use App\Info;
use App\Libs\Heat\Heat;
use App\Libs\JumpHelper\JumpHelper;
use App\Libs\Sort\Sort;
use App\Member;
use App\Praise;
use App\Sport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Activity;
use App\Libs\Avatar\Avatar;
use Illuminate\Support\Facades\Session;
/**
 * 管理员控制逻辑
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller {

    /**
     * 管理员查看资料
     */
    public function adminData(Request $request){
        $arr=JumpHelper::jumpUIWith();
        if(Session::get('error')=='修改资料失败'){
            if($arr){
                return view('admin.my',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改资料失败']);
            }
            else{
                return view('errors.503');
            }
        }
        if(Session::get('error')=='修改密码失败'){
            if($arr){
                return view('admin.my',['user'=>$arr[0],'activity_show'=>$arr[1],'error'=>'修改密码失败']);
            }
            else{
                return view('errors.503');
            }
        }
        return JumpHelper::jumpUI('admin.my');
    }

    /**
     * 管理员用户管理界面
     */
    public function manageUsers(Request $request,$tag=null,$user_id=null){
        if($tag=='delete'){
            Member::where(['id'=>$user_id])->delete();
        }

        $users=Member::where('isAdmin','=',0)->paginate(10);
        $users_admin=Member::where('isAdmin','=',1)->get();
        $users_man=Member::where(['sex'=>'男','isAdmin'=>0])->get();
        $users_women=Member::where(['sex'=>'女','isAdmin'=>0])->get();
        $count_man=count($users_man);
        $count_woman=count($users_women);
        $count_user=$count_man+$count_woman;
        $count_admin=count($users_admin);
        $arr=JumpHelper::jumpUIWith();

        if($arr){
            if($tag=='search'){
                $name=$request->input('username');
                $temp=Member::where('username','like','%'.$name.'%')
                    ->where(function($query){
                        $query->where('isAdmin','=',0);
                    });
                $count=count($temp->get());
                $users=$temp->paginate(10);
                return view('admin.user',['user'=>$arr[0],'activity_show'=>$arr[1],
                    'users'=>$users,'count'=>$count]);
            }
            return view('admin.user',['user'=>$arr[0],'activity_show'=>$arr[1],
                'users'=>$users,'count_user'=>$count_user,'count_man'=>$count_man,'count_woman'=>$count_woman,
            'count_admin'=>$count_admin]);
        }
        else{
            return view('errors.503');
        }
    }

    /**
     * 管理员管理活动界面
     */
    public function manageActivities(Request $request,$tag){
        //按照活动开始时间降序
        if($tag=='start'){
            $activities=Activity::latest('time')->paginate(6);
        }
        //按照活动发布时间降序
        elseif($tag=='release'){
            $activities=Activity::latest('created_at')->paginate(6);
        }
        //刷新最热活动
        elseif($tag=='hot'){
            $activities=Activity::latest('time')->paginate(6);
            $this->refreshHot();
        }
        //删除某个活动
        else{
            $path=Activity::find($tag)->picture;
            Activity::destroy($tag);
            //删除图片文件
            $destination='uploads/activity/'.$path;
            Avatar::deleteFile($destination);
            //还要删除活动参与表的该活动相关数据
            ActivityAttend::where(['activityId'=>$tag])->delete();
            //每页取6个
            //$activities=Activity::latest('time')->paginate(6);
            return redirect('admin/activity/start');
        }

        $arr=JumpHelper::jumpUIWith();
        if($arr){
            return view('admin.event',['user'=>$arr[0],'activity_show'=>$arr[1],'activities'=>$activities]);
        }
        else{
            return view('errors.503');
        }
    }

    /**
     * 处理管理员上传的活动文字
     * @return mixed
     */
    public function releaseActivity(){
        $sponsorId=Input::get('sponsorId');
        $name=Input::get('name');
        $address=Input::get('address');
        $year=Input::get('year');
        $month=Input::get('month');
        $day=Input::get('day');
        $hour=Input::get('hour');
        $minute=Input::get('minute');
        $second=Input::get('second');
        $limit=Input::get('limit');
        $detail=Input::get('detail');
        //时间处理，转换为unix时间戳
        $time=strtotime($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second);
        $data=array('name'=>$name,'address'=>$address,'time'=>$time,'peopleLimit'=>$limit,
            'detail'=>$detail,'sponsorId'=>$sponsorId);
        //检验
        $validator = \Validator::make($data, ['name' => "required|min:2|max:30",
            'address' => 'required|min:2|max:30',
            'peopleLimit' => 'required|integer',
            'detail' => 'required|min:2|max:50'],//多个规则用|分隔一下即可，必须，且最短为2个字符
            ['required' => ':attribute 为必填项',
                'min' => ':attribute 长度不符合要求',
                'max' => ':attribute 长度不符合要求',
                'integer' => ':attribute 为整数'],     //attribute是占位符
            ['name' => '活动名称',
                'address' => '活动地址',
                'peopleLimit' => '人数上限',
                'detail' => '活动详情']);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }
        //插入数据库
        $activity=Activity::create($data);
        if($activity){
            //插入成功
            return response()->json(array('msg'=>'success','id'=>$activity->id));
        }
        else{
            return response()->json(array('msg'=>'database error'));
        }
    }

    /**
     * 处理管理员上传的活动图片
     * @return mixed
     */
    public function releaseActivityImg(){
        $file=Input::file('activity_img');
        $file_arr=array();
        $file_arr['name']=$file->getClientOriginalName();
        $file_arr['size']=$file->getSize();
        $file_arr['type']=$file->getMimeType();
        $file_arr['tmp_name']=$file->getRealPath();
        $file_arr['error']=$file->getError();
//        return response()->json(array(
//                'msg' => '上传失败'));
        //上传到本地
        $msg=Avatar::uploadFile($file_arr,'uploads/activity');
        //如果文件上传成功
        if(is_array($msg)){
            //得到路径
            $new_path=$msg[0];
            $split=explode('/',$new_path);
            //获取刚刚插入的id
            $id=Activity::max('id');
            $activity=Activity::find($id);
            //将图片途径添加上
            $activity->picture=end($split);
            if($activity->save()){
                return Response::json(['success'=>'活动发布成功！']);
            }
            else{
                return Response::json(['success'=>'图片保存失败']);
            }
        }
        return Response::json(['success'=>$msg]);

    }

    /**
     * 刷新热门运动
     */
    private function refreshHot(){
        $path="uploads/hot/";
        //清空文件夹
        Avatar::clearDir($path);
        $activities=Activity::limit(6)->orderBy("peopleSign","desc")->get();
        $arr=array();
        $i=0;
        foreach($activities as $activity){
            //copy("uploads/activity/".$activity->picture,$path.$activity->picture);
            $arr[$i]['picture']=$activity->picture;
            $arr[$i]['name']=$activity->name;
            $arr[$i]['address']=$activity->address;
            $arr[$i]['time']=date("Y-m-d H:i:s",$activity->time);
            $i++;
        }
        //生成水印
        Avatar::makeString($arr);
//        return response()->json(array("msg"=>"success"));
    }


    public function test(){
        date_default_timezone_set("PRC");
        $year='16';
        $month='11';
        $sm='00';
        $ss='00';
        $em='00';
        $es='00';
        $id=6;
        for($i=1;$i<=29;$i++){
            if($i<10){
                $day='0'.$i;
            }
            else{
                $day=$i;
            }
            for($j=5;$j<=21;$j+=2){
                if($j<10){
                    $b='0'.$j;
                    if($j!=9){
                        $c='0'.($j+1);
                    }
                    else{
                        $c=$j+1;
                    }
                }
                else{
                    $b=$j;
                    $c=$b+1;
                }
                $startTime=strtotime('20'.$year.'-'.$month.'-'.$day.' '.$b.':'.$sm.':'.$ss);
                $endTime=strtotime('20'.$year.'-'.$month.'-'.$day.' '.$c.':'.$em.':'.$es);
                $date='2016'.$month.$day;
                //获取用户体重
                $weight=Member::find($id)->weight;
                $distance=rand(3000,6000);
                $heat=Heat::calculateHeat($weight,$startTime,$endTime,$distance);
                $sport_data=array('userId'=>$id,'startTime'=>$startTime,'endTime'=>$endTime,
                    'date'=>$date,'distance'=>$distance,'heat'=>$heat);
                //创建新数据
                $sport=Sport::create($sport_data);

            }
        }


    }


}