<?php
/**
 * Created by PhpStorm.
 * User: Edianzu
 * Date: 2019/3/20
 * Time: 11:59
 */

namespace app\member\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
class Test extends CommonBaseHome
{
    public function index(){
        // 查询用户自定义表及数据
        /*$data=array('cell1'=>'苹果A1',
            'cell2'=>'规格01',
            'cell3'=>'型号01');
        echo json_encode($data);*/

        $modelCustomDataCell=Db::name('custom_data_cell');
        $modelCustomTableData=Db::name('custom_table_data');

        // 查询表的列
        $listCustomDataCell=$modelCustomDataCell->where("table_id=1")->select();
        // 整理列名称
        $arrayCell=[];
        foreach ($listCustomDataCell as $key=>$value){
            $arrayCell[]=$value['title_value'];
        }

        // 查询表的数据
        $listCustomTableData=$modelCustomTableData->where("table_id=1")->select();
        // 整理数据
        $_listCustomTableData=array();
        foreach ($listCustomTableData as $key=>$value){
            $value['content']=(Array)json_decode($value['content']);
            $_listCustomTableData[]=$value;
        }
        //print_r($_listCustomTableData);exit;
        $this->assign("listCustomDataCell",$listCustomDataCell);
        $this->assign("arrayCell",$arrayCell);
        $this->assign("listCustomTableData",$_listCustomTableData);
        return $this->fetch();
    }
}