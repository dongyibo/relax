<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/11 0011
 * Time: 下午 15:08
 */
namespace App\Libs\Activity;
/**
 * 用户等级活跃度工具类
 * Class Activity
 * @package App\Libs\Activity
 */
use App\Member;

/**
 * 用户权限处理
 * Class Activity
 * @package App\Libs\Activity
 */
class Activity{

    /**
     * 等级常量
     */
    const DEGREE=50;

    /**
     * 活力值以及等级处理
     */
    public static function calculateActivity($id,$isLogin=false){
        $user=Member::find($id);
        //每次登陆活力度+5
        if($isLogin){
            $user->activity+=5;
        }
        $activity=$user->activity;
        $level=$user->level;
        $lower=self::DEGREE*$level*($level-1);
        $upper=self::DEGREE*$level*($level+1);
        $new_lower=self::DEGREE*$level*($level+1);
        $new_upper=self::DEGREE*($level+1)*($level+2);
        if($activity>$upper){
            //活力度大于当前上限制，升级
            $user->level+=1;
            $activity_sum=$new_upper-$new_lower;
            $activity_show=$activity-$new_lower;
        }
        else{
            //未升级
            $activity_sum=$upper-$lower;
            $activity_show=$activity-$lower;
        }
        //保存
        if($isLogin){
            $user->save();
        }

        $value=(($activity_show*1.0)/$activity_sum)*100;
        $show=$value."%";
        return array($user,$show);
    }

    /**
     * 是否可关注用户
     * @param $level
     * @param $haveForked
     * @return bool
     */
    public static function canFork($level,$haveForked){
        $upper=($level-($level%10)+10)*10;
        if($haveForked>$upper){
            return false;
        }
        return true;
    }

    /**
     * 给上传运动数据的用户增加活跃度
     */
    public static function addActivity($id){
        $user=Member::find($id);
        //活力度+10
        $user->activity+=10;
        $activity=$user->activity;
        $level=$user->level;
        $upper=self::DEGREE*$level*($level+1);
        if($activity>$upper){
            //活力度大于当前上限制，升级
            $user->level+=1;
        }
        //保存
        $user->save();
    }

}
