<?php
/**
 * Created by PhpStorm.
 * User: 董轶波
 * Date: 2016/10/9 0009
 * Time: 下午 23:14
 */
namespace App\Libs\Avatar;
/**
 * 文件上传工具类
 */
class Avatar{

    /**
     * 上传头像文件
     * @param $file 文件
     * @param string $path 目的路径
     * @param array $allowExt 允许的类型
     * @param int $maxSize 图像最大容量
     * @param bool $imgFlag 检查图片类型
     */
    public static function uploadFile($file,$path="uploads/avatar",$allowExt=array("gif","jpeg","png","jpg","wbmp","bmp"),$maxSize=2097152,$imgFlag=true){
        //目的文件不存在，则自动创建
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //正确的文件
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = self::getExt($file['name']);
            //检测文件的扩展名
            if (!in_array($ext, $allowExt)) {
                return "非法文件类型";
            }
            //校验是否是一个真正的图片类型
            if ($imgFlag) {
                if (!getimagesize($file['tmp_name'])) {
                    return "不是真正的图片类型";
                }
            }
            //上传文件的大小
            if ($file['size'] > $maxSize) {
                return "上传文件过大";
            }
            if (!is_uploaded_file($file['tmp_name'])) {
                return "不是通过HTTP POST方式上传上来的";
            }
            $filename = self::getUniName() . "." . $ext;
            $destination = $path . "/" . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return array($destination,"文件上传成功");
            }
        } //文件上传错误
        else {
            switch ($file['error']) {
                case 1:
                    $mes = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes = "超过了表单设置上传文件的大小";            //UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes = "没有文件被上传";//UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes = "文件不可写";//UPLOAD_ERR_CANT_WRITE;
                    break;
                case 8:
                    $mes = "由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                    break;
            }
            return $mes;
        }

    }

    /**
     * 生成唯一字符串
     * @return string
     */
    public static function getUniName(){
        return md5(uniqid(microtime(true),true));
    }

    /**
     * 得到文件扩展名
     * @param $filename
     * @return string
     */
    public static function getExt($filename){
        $tmp_name=explode(".",$filename);
        return strtolower(end($tmp_name));
    }

    /**
     * 删除指定用户的头像
     * @param $old_path
     */
    public static function deleteFile($old_path){
        if(file_exists($old_path)){
            $split=explode('/',$old_path);
            //如果文件存在且非空，删除之
            //用户初次申请账号头像为空，不会删除空文件
            if($split[count($split)-1]){
                unlink($old_path);
            }
        }
    }

    /**
     * 清空文件夹
     * @param $dirName
     * @return bool
     */
    public static function clearDir($dirName){
        $files = glob($dirName.'*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * 图片添加文字
     * @param $arr
     */
    public static function makeString($arr){
        $i=0;
        foreach ($arr as $o){
            $file="uploads/activity/".$o["picture"];
            $fileInfo=getimagesize($file);
            $mime=$fileInfo['mime'];
            $createFun=str_replace("/", "createfrom", $mime);
            $outFun=str_replace("/", null, $mime);
            $image=$createFun($file);   //从图片中生成图像（画布）
            $black = imagecolorallocate($image, 0, 0, 0);
            $fontfile="static/fonts/msyh.ttc";
            imagettftext($image, 20, 0, 20, 30, $black, $fontfile, $o['name']);
            imagettftext($image, 10, 0, 30, 60, $black, $fontfile, $o['address']);
            imagettftext($image, 10, 0, 30, 80, $black, $fontfile, $o['time']);
            //imagestring($image, 5, 10, 10, "大家一起做运动", $red);
            //$ext = self::getExt($o["picture"]);
            $outFun($image,"uploads/hot/".$i.".jpg");
            $i++;
        }

    }


}