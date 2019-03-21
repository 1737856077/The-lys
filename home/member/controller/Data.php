<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/19
 * Time: 10:33
 */

namespace app\member\controller;


use app\common\controller\CommonBase;
use function Composer\Autoload\includeFile;
use think\Cookie;
use think\Db;
use think\Session;

class Data extends CommonBase
{
    //查看数据库
    public function bdb()
    {
        $memberid = Session::get('memberid');
        $data = Db::name('custom_database')->where('member_id', $memberid)->select();
        $this->assign('data', $data);
        return $this->fetch();
    }

    //新建数据库
    public function index()
    {
        $id = Session::get('memberid');
        $param = $this->request->param();
        $title = isset($param['title_value']) ? $param['title_value'] : 0;
        if ($title) {
            $param['template_id'] = isset($param['template_id']) ? htmlspecialchars($param['template_id']) : 0;
            $data['title'] = 'usertable' . $id . '_' . $param['template_id'] . '_' . time();
            $data['title_value'] = isset($param['title_value']) ? htmlspecialchars($param['title_value']) : 0;
            $data['template_id'] = isset($param['template_id']) ? htmlspecialchars($param['template_id']) : 0;
            $data['member_id'] = $id;
            $data['create_time'] = time();
            if (empty($data['title']) or empty($data['template_id']) or empty($data['member_id'])) {
                $this->error('错误');
            }
            $data = Db::name('custom_database')->insert($data);
            if ($data) {
                $this->success('创建成功', '/index.php/member/userconter/index');
            } else {
                $this->error('创建失败请检查', '/index.php/member/userconter/index');
                echo 0;
            }
        } else {
            $data = array(
                'memberid' => Session::get('memberid'),
//               'template_id'=>$param['template_id']
            );
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    //编辑数据库
    public function editi()
    {
        $param = $this->request->param();
        $database_id = isset($param['databaseid']) ? htmlspecialchars($param['databaseid']) : 0;
        if (!$database_id) {
            $this->error('错误');
        }
        $data = Db::name('custom_database')->where('database_id', $database_id)->select();
        $this->assign('data', $data);
        dump($data);
        return $this->fetch();
    }

    //保存编辑数据库
    public function sdata()
    {
        $param = $this->request->param();
        $member_id = isset($param['member_id']) ? htmlspecialchars($param['member_id']) : 0;
        $title = isset($param['title_value']) ? htmlspecialchars($param['title_value']) : 0;
        if (empty($member_id) or empty($title)) {
            $this->error('错误');
        }
        $data = array(
            'title_value' => $title,
            'update_time' => time()
        );
        $data = Db::name('custom_database')->where('database_id', $member_id)->update($data);
        if ($data) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
        }
    }

    //删除数据库
    public function Ddata()
    {
        $param = $this->request->param();
        $dataid = isset($param['databaseid']) ? $param['databaseid'] : 0;
        if ($dataid == 0) {
            $this->error('请求失败');
        }
        $data = Db::name('custom_database')->where('database_id', $dataid)->delete();
        if ($data) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    //查看数据表
    public function table()
    {
        $param = $this->request->param();
        $databaseid = isset($param['databaseid']) ? $param['databaseid'] : 0;
        $data = Db::name('custom_table')->where('database_id', $databaseid)->select();
        $id = $databaseid;
        $this->assign('id', $id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //新建数据表
    public function ntable()
    {
        $id = Session::get('memberid');
        $param = $this->request->param();
        $if = isset($param['title_value']) ? $param['title_value'] : 0;
        if ($if) {
            $database_id = isset($param['database_id']) ? htmlspecialchars($param['database_id']) : 0;
            $title = 'usertable' . $id . '_' . time();
            $title_value = isset($param['title_value']) ? htmlspecialchars($param['title_value']) : 0;
            if (empty($database_id)) {
                $this->error('请求错误1');
            }
            if (empty($title_value)) {
                $this->error('请求错误2');
            }
            $data['database_id'] = $database_id;
            $data['title'] = $title;
            $data['title_value'] = $title_value;
            $data['create_time'] = time();
            dump($data);
            $datas = Db::name('custom_table')->insert($data);
            if ($datas) {
                $this->success('创建成功', "/index.php/member/data/table?databaseid=$database_id");
            } else {
                $this->error('创建失败');
            }
        } else {
            $data['id'] = $param['id'];
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    //编辑数据表
    public function etable()
    {
        $param = $this->request->param();
        $databaseid = isset($param['databaseid']) ? $param['databaseid'] : 0;
        $id = isset($param['tableid']) ? $param['tableid'] : 0;
        $data = Db::name('custom_table')->where('table_id', $id)->select();
        $data['id'] = $databaseid;
        $this->assign('data', $data);
        return $this->fetch();

    }

    //保存数据表
    public function stable()
    {
        $param = $this->request->param();
        $id = isset($param['table_id']) ? $param['table_id'] : 0;
        $database_id = isset($param['database_id']) ? htmlspecialchars($param['database_id']) : 0;
        $title = 'usertable' . $id . '_' . time();
        $title_value = isset($param['title_value']) ? $param['title_value'] : 0;
        if (empty($title) or empty($title_value) or empty($id)) {
            $this->error('请求失败');
        }
        $data = array(
            'title' => $title,
            'title_value' => $title_value,
            'update_time' => time()
        );
        $datas = Db::name('custom_table')->where('table_id', $id)->update($data);
        if ($datas) {
            $this->success('更新成功', "/index.php/member/data/table?databaseid=$database_id");
        } else {
            $this->error('更新失败');
        }
    }

    //删除数据表
    public function dtable()
    {
        $param = $this->request->param();
        $id = isset($param['tableid']) ? htmlspecialchars($param['tableid']) : 0;
        $data = Db::name('custom_table')->where('table_id', $id)->delete();
        if ($data) {
            $this->success('删除成功');

        } else {
            $this->error('删除失败');
        }
    }

    //查看表的字段
//    public function bfield()
//    {
//        $param = $this->request->param();
//        $id = isset($param[$param['tableid']])?$param['tableid']:0;
//        if ($id){
//            $this->error('请求出错');
//        }
//        $data = Db::name('custom_data_cell')->where('table_id',$id)->select();
//        $tableid = $param['tableid'];
//        $databaseid = $param['databaseid'];
//
//        $this->assign(
//            [
//                'data'=>$data,
//                'tableid'=>$tableid,
//                'databaseid'=>$databaseid
//            ]
//        );
//        return $this->fetch();
//    }
    public function bfield()
    {
        $param = $this->request->param();
        $tableid = isset($param['tableid']) ? $param['tableid'] : null;
        $databaseid = isset($param['databaseid']) ? $param['databaseid'] : null;
        $data = array(
            'tableid' => $tableid,
            'databaseid' => $databaseid,
        );
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function bfields()
    {
        $param = $this->request->param();
        $tableid = isset($param['tableid']) ? $param['tableid'] : null;
        $databaseid = isset($param['databaseid']) ? $param['databaseid'] : null;
        $data = array(
            'tableid' => $tableid,
            'databaseid' => $databaseid,
        );
        $this->assign('data', $data);
        return $this->fetch();
    }
    //添加字段
    public function bfield1()
    {
        $param = $this->request->param();

        $tableid = isset($param['tableid']) ? $param['tableid'] : null;
        $databaseid = isset($param['databaseid']) ? $param['databaseid'] : null;
        $title_value = isset($param['title_value']) ? $param['title_value'] : null;
        if (empty($tableid) or empty($databaseid) or empty($title_value)) {
            $this->error('请求出错');
        }
        $title = 'usertable' . '_' . time();
        $cell_type = isset($param['cell_type']) ? $param['cell_type'] : 'varchar';
        $cell_lenght = isset($param['cell_lenght']) ? $param['cell_lenght'] : 50;
        $data = array(
            'table_id' => $tableid,
            'database_id' => $databaseid,
            'title_value' => $title_value,
            'title' => $title,
            'cell_type' => $cell_type,
            'cell_lenght' => $cell_lenght,
            'create_time' => time()

        );
        $data = Db::name('custom_data_cell')->insert($data);
        if ($data) {
            $this->success('插入成功',"/index.php/member/data/bkzd/tableid/$tableid/databaseid/$databaseid");
        } else {
            $this->error('插入失败',"/index.php/member/data/bkzd/tableid/$tableid/databaseid/$databaseid");
        }

    }

    public function bkzd()
    {
        $param = $this->request->param();
        $tableid = isset($param['tableid']) ? $param['tableid'] : null;
        $database = isset($param['databaseid']) ? $param['databaseid'] : null;
        $sj = array(
            'tid'=>$tableid,
            'did'=>$database
        );
        if (empty($tableid)) {
            $this->error('请求出错');
        }
        $modelCustomDataCell=Db::name('custom_data_cell');
        $modelCustomTableData=Db::name('custom_table_data');

        // 查询表的列
        $listCustomDataCell=$modelCustomDataCell->where("table_id=$tableid")->select();
        // 整理列名称
        $arrayCell=[];
        foreach ($listCustomDataCell as $key=>$value){
            $arrayCell[]=$value['title_value'];
        }

        // 查询表的数据
        $listCustomTableData=$modelCustomTableData->where("table_id=$tableid")->select();
        $id = isset($listCustomTableData[0]['id'])?$listCustomTableData[0]['id']:'';
        // 整理数据
        $_listCustomTableData=array();
        foreach ($listCustomTableData as $key=>$value){
            $value['content']=(Array)json_decode($value['content']);
            $_listCustomTableData[]=$value;
        }
        $data = array();
        foreach ($_listCustomTableData as $k=>$v){
            $data[] =array_values($v['content']);
        }
        //print_r($_listCustomTableData);exit;
        $this->assign("id",$id);
        $this->assign("listCustomDataCell",$listCustomDataCell);
        $this->assign("arrayCell",$arrayCell);
        $this->assign("listCustomTableData",$data);
        $this->assign("sj",$sj);
        return $this->fetch();




    }

    //创建字段表
    public function nfield()
    {
        $id = Session::get('memberid');
        $param = $this->request->param();
        $database_id = isset($param['database_id']) ? htmlspecialchars($param['database_id']) : 0;
        $table_id = isset($param['table_id']) ? htmlspecialchars($param['table_id']) : 0;
        $title_value = isset($param['title']) ? htmlspecialchars($param['title']) : 0;
        $title = 'usertable' . $id . '_' . $param['template_id'] . '_' . time();
        $cell_type = isset($param['cell_type']) ? htmlspecialchars($param['cell_type']) : 'varchar';
        $cell_lenght = isset($param['cell_lenght']) ? htmlspecialchars($param['cell_lenght']) : 10;
        $time = time();

        $data = array(
            'database_id' => $database_id,
            'table_id' => $table_id,
            'title' => $title,
            'title_value' => $title_value,
            'cell_type' => $cell_type,
            'cell_lenght' => $cell_lenght,
            'create_time' => $time
        );
        $datas = Db::name('custom_data_cell')->insert($data);
        if ($datas) {
            $this->success('创建成功');
        } else {
            $this->error('创建失败');
        }
    }

    //编辑字段表
    public function efield()
    {
        $param = $this->request->param();
        $id = isset($param['id']) ? $param['id'] : 0;
        if ($id == 0) {
            $this->error('请求失败');
        }
        $data = Db::name('custom_data_cell')->where('data_cell_id', $id)->select();
        $this->assign('data', $data);
        return $this->fetch();
    }

    //保存字段表
    public function sfield()
    {
        $param = $this->request->param();
        $tid = $param['tid'];
        $did = $param['did'];
        $id = $param['id'];
        $title_value = isset($param['title']) ? $param['title'] : 0;
        $title = 'usertable' .'_' . time();
        $cell_type = isset($param['cell_type']) ? $param['cell_type'] : 'varchar';
        $cell_lenght = isset($param['cell_lenght']) ? $param['cell_lenght'] : 10;
        if (empty($tid) or empty($did) or empty($title)) {
            $this->error('更新失败');
        }
        $data = array(
            'database_id' => $did,
            'table_id' => $tid,
            'title' => $title,
            'title_value' => $title_value,
            'cell_type' => $cell_type,
            'cell_lenght' => $cell_lenght,
            'update_time' => time()
        );
        $datas = Db::name('custom_data_cell')->where('data_cell_id', $id)->update($data);
        if ($datas) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');

        }
    }

    //删除字段
    public function dfield()
    {
        $param = $this->request->param();
        $id = isset($param['id']) ? htmlspecialchars($param['id']) : 0;
        $data = Db::name('custom_data_cell')->where('data_cell_id', $id)->delete();
        if ($data) {
            $this->success('删除成功');

        } else {
            $this->error('删除失败');
        }
    }

    /**
     * @创建内容
     */
    public function content()
    {
        $param = $this->request->param();
        $databid = isset($param['database_id']) ? $param['database_id'] : 0;
        $tableid = isset($param['tableid']) ? $param['tableid'] : 0;
        if (empty($databid) or empty($tableid)) {
            $this->error('请求出错');
        }

    }

    //保存data
    public function saveData()
    {
        $param = $this->request->param();
        $databaseid = isset($param['did'])?$param['did']:'';
        $tableid = isset($param['tid'])?$param['tid']:'';
        if (empty($databaseid) or empty($tableid)){
            $this->error('错误');
        }

        $if = isset($param['if'])?1:0;
        $id = isset($param['id'])?$param['id']:'';
        if ($if){
            $content ="{\"cell1\":\"苹41414141A3\",\"cell2\":\"规格03\",\"cell3\":\"型号03\"}";

            $data = [
                'database_id'=>$databaseid,
                'table_id'=>$tableid,
                'content'=>$content,
                'create_time'=>time()
            ];
            $datas = Db::name('custom_table_data')->insert($data);
        }else{$content ="{\"cell1\":\"苹bbbbA3\",\"cell2\":\"规54545454545403\",\"cell3\":\"型号03\"}";

            $data = [
                'database_id'=>$databaseid,
                'table_id'=>$tableid,
                'content'=>$content,
                'create_time'=>time()
            ];
            $datas = Db::name('custom_table_data')->where('id',$id)->update($data);
        }

        if ($datas){
            $this->success('保存成功');
        }else{
            $this->error('保存失败');
        }
    }
}