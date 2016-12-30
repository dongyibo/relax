<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/29 0029
 * Time: 上午 9:25
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * 未读消息模型
 * Class Info
 * @package App
 */
class Info extends Model {

    protected $table='relax_info';

    //设置是否自动设置时间值 create_at,update_at,delete_at,默认为true
    public $timestamps=false;

    //指定允许批量赋值的字段
    protected $fillable=['userId','time'];

    //指定不允许批量赋值的字段
    protected $guarded=[];
}