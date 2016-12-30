<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/6 0006
 * Time: 上午 9:50
 */
namespace App\Libs\Validator;
use Illuminate\Support\Facades\Session;

/**
 * 验证器工具
 */
class Validator{

    /**
     * 通过GD库做验证码
     * @param int $type
     * @param int $length
     * @param int $pixel
     * @param int $line
     * @param string $sess_name
     */
    public static function verifyImage($type = 1, $length = 4, $pixel = 0, $line = 0,$sess_name='verify'){
        //session_start();
        $width = 100;
        $height = 28;
        $image = imagecreatetruecolor($width, $height); //创建图像
        $white = imagecolorallocate($image, 255, 255, 255); //白色
        $black = imagecolorallocate($image, 0, 0, 0);    //黑色
        //用填充矩形填充画布
        imagefilledrectangle($image, 1, 1, $width - 2, $height - 2, $white);
        //int imagefilledrectangle(int im, int x1, int y1, int x2, int y2, int col);
        //本函数将图片的封闭长方形区域着色。参数 x1、y1 及 x2、y2 分别为矩形对角线的坐标。参数 col 表示欲涂上的颜色。
        $chars = self::buildRandomString($type, $length);

        //$_SESSION[$sess_name]=$chars;
        //存入session
        Session::flash($sess_name,$chars);

        $fontfiles = array("msyh.ttc", "simhei.ttf", "simkai.ttf", "simsun.ttc", "simyou.TTF");
        for ($i = 0; $i < $length; $i++) {
            $size = mt_rand(14, 18);//包含14,18，速度快
            $angle = mt_rand(-15, 15);
            $x = 20 + $i * $size;
            $y = mt_rand(20, 26);
            //$fontfile="E:\\PHPWorkspace\\shopImooc\\shopImooc\\fonts\\".$fontfiles[mt_rand(0,count($fontfiles)-1)];
            $fontfile = "static/fonts/" . $fontfiles[mt_rand(0, count($fontfiles) - 1)];
            $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
            $text = substr($chars, $i, 1);
            imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
        }
        //画点
        if ($pixel) {
            for ($i = 0; $i < $pixel; $i++) {
                imagesetpixel($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), $black);
            }
        }
        //画线
        if ($line) {
            for ($i = 1; $i < $line; $i++) {
                $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
                imageline($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), mt_rand(0, $width - 1), mt_rand(0, $height - 1), $color);
            }
        }
        //header("Cache-Control: no-cache, must-revalidate");
        header("content-type:image/gif");
        imagegif($image);
        imagedestroy($image);
    }

    /**
     * 生成随机字符串
     * @param int $type
     * @param int $length
     * @return string
     */
    public static function buildRandomString($type = 1, $length = 4)
    {
        if ($type == 1) {
            $chars = join("", range(0, 9));
        } elseif ($type == 2) {
            $chars = join("", array_merge(range("a", "z"), range("A", 'Z')));
        } elseif ($type == 3) {
            $chars = join("", array_merge(range("a", "z"), range("A", 'Z'), range(0, 9)));
        }
        if ($length > strlen($chars)) {
            exit("字符串长度不够");//终止
        }
        $chars = str_shuffle($chars);//随机地打乱字符串中的所有字符
        return substr($chars, 0, $length);
    }
}

