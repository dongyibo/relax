<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/8 0008
 * Time: 下午 12:50
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
/**
 * 用户实体模型
 * Class Member
 * @package App
 */
class Member extends Model {

    protected $table='relax_user';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=true;

    //指定允许批量赋值的字段
    protected $fillable=['username','password','email','sex','age',
        'portrait','created_at','updated_at','level','activity',
        'height','weight','isAdmin'];

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