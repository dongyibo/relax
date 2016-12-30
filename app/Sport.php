<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/22 0022
 * Time: 上午 9:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户运动数据模型
 * Class Sport
 * @package App
 */
class Sport extends Model{

    protected $table='relax_sport';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=false;

    //指定允许批量赋值的字段
    protected $fillable=['userId','startTime','endTime','date','distance','heat'];

    //指定不允许批量赋值的字段
    protected $guarded=[];
}