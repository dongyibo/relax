<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/17 0017
 * Time: 上午 10:23
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 活动实体模型
 * Class Activity
 * @package App
 */
class Activity extends Model {

    protected $table='relax_activity';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=true;

    //指定允许批量赋值的字段
    protected $fillable=['id','name','time','address','detail','picture',
        'peopleLimit','peopleSign','sponsorId','created_at','updated_at'];

    //指定不允许批量赋值的字段
    protected $guarded=[];

    /**
     * 设置为Unix时间戳，是已经格式化好的
     * @return int
     */
    protected function getDateFormat(){
        return time();
    }

    /**
     * 取消格式化，保持Unix时间戳，便于自主实现格式化
     * @param mixed $val
     * @return mixed
     */
    protected function asDateTime($val){
        return $val;
    }
}