<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/18 0018
 * Time: 下午 16:33
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户参与活动模型
 * Class ActivityAttend
 * @package App
 */
class ActivityAttend extends Model {

    protected $table='relax_activity_attend';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=false;

    //指定允许批量赋值的字段
    protected $fillable=['userId','activityId'];

    //指定不允许批量赋值的字段
    protected $guarded=[];
}