<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/27 0027
 * Time: 上午 10:22
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户关注模型
 * Class Friend
 * @package App
 */
class Friend extends Model {

    protected $table='relax_friend';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=false;

    //指定允许批量赋值的字段
    protected $fillable=['userId','friendId'];

    //指定不允许批量赋值的字段
    protected $guarded=[];

}