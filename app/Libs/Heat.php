<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/22 0022
 * Time: 下午 12:10
 */

namespace App\Libs\Heat;
use App\Sport;

/**
 * 用户热量计算工具类
 * Class Heat
 * @package App\Libs\Heat
 */
class Heat{

    /**
     * 计算用户运动消耗的热量
     */
    public static function calculateHeat($weight,$startTime,$endTime,$distance){
        //分钟
        $time=(($endTime-$startTime)*1.0)/60.0;
        //指数K
        $K=30.0/(400.0*$time/$distance);
        //根据公式计算热量
        $heat=ceil($weight*($time/60.0)*$K);

        return $heat;
    }

    /**
     * 计算用户当天运动的总距离km
     * @param $sports
     */
    public static function calculateAllDistance($sports){
        $all_distance=0;
        foreach ($sports as $sport){
            $all_distance+=$sport->distance;
        }
        return ceil($all_distance*1.0/1000);
    }

    /**
     * 计算用户当天运动的总小时
     * @param $sports
     */
    public static function calculateAllHour($sports){
        $all_time=0;
        foreach ($sports as $sport){
            $all_time+=($sport->endTime-$sport->startTime);
        }
        return floor($all_time/3600);
    }

    /**
     * 计算用户当天运动的总分钟km
     * @param $sports
     */
    public static function calculateAllMinute($sports){
        $all_time=0;
        foreach ($sports as $sport){
            $all_time+=($sport->endTime-$sport->startTime);
        }
        $hour=floor($all_time/3600);
        return floor(($all_time-$hour*3600)/60);
    }

    /**
     * 计算用户当天运动的总热量
     * @param $sports
     */
    public static function calculateAllHeat($sports){
        $all_heat=0;
        foreach ($sports as $sport){
            $all_heat+=$sport->heat;
        }
        return $all_heat;
    }
}