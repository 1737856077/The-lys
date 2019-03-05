<?php
namespace app\product\controller;

/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:生成码测试
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Createcode.php 2018-11-29 14:11:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBase;
class Createcode extends CommonBase
{
    public function index(){
        set_time_limit(0);
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");

        $ModelTest=Db::name('test');
        //$ModelTest->insertAll();
        //$file_name='./static/uploads/download/txt/codetxt20181129.txt';
        $fileContent='';
        $dataAll=array();
        for ($i=1; $i<=500000; $i++){
            $str='http://kedousuyuan.com/procdecode='.$i;
            array_push($dataAll,array('title'=>$str));
            if($i % 1000 == 0){
                $ModelTest->insertAll($dataAll);
                $dataAll=array();
            }
            $fileContent.=$str."\r\n";
        }
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $filename = "中文文件名.txt";
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {
            header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');
        } elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: attachment; filename*="utf8' .  $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' .  $filename . '"');
        }
        echo "$fileContent";
    }
}