<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/29 0029
 * Time: 上午 10:21
 */

namespace App\Libs\Sort;

/**
 * 排序算法
 * Class Sort
 * @package App\Libs\Sort
 */
class Sort{

    /**
     * 将两个有序数组合并成一个有序数组
     * @param $arrA,
     * @param $arrB,
     * @return array
     */
    public static function mergeArray($arrA, $arrB) {
        $a_i = $b_i = 0;//设置两个起始位置标记
        $a_len = count($arrA);
        $b_len = count($arrB);
        $arrC=array();
        while($a_i<$a_len && $b_i<$b_len) {
            //当数组A和数组B都没有越界时
            if($arrA[$a_i]->created_at > $arrB[$b_i]->created_at) {
                $arrC[] = $arrA[$a_i++];
            } else {
                $arrC[] = $arrB[$b_i++];
            }
        }
        //判断 数组A内的元素是否都用完了，没有的话将其全部插入到C数组内：
        while($a_i < $a_len) {
            $arrC[] = $arrA[$a_i++];
        }
        //判断 数组B内的元素是否都用完了，没有的话将其全部插入到C数组内：
        while($b_i < $b_len) {
            $arrC[] = $arrB[$b_i++];
        }
        return $arrC;
    }
}