<?php
namespace app\admin\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:商家管理员类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Manager.php 2018-04-13 11:34:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Manager extends CommonAdmin
{
    /**
     * @描述：信息列表页面
     */
    public function  index()
    {
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? urldecode(trim($param['SearchTitle'])) : '';
        $SearchTel = isset($param['SearchTel']) ? urldecode(trim($param['SearchTel'])) : '';
        $paramUrl = '';
        $paramUrl .= 'SearchTitle=' . $SearchTitle;
        $paramUrl .= '&SearchTel=' . $SearchTel;
        $this->assign("SearchTitle", $SearchTitle);
        $this->assign("SearchTel", $SearchTel);
        $ModelManager = Db::name('admin');

        $_where = "1 AND data_type=2";
        if (!empty($SearchTitle)) {            $_where .= " AND name LIKE '%" . urldecode($SearchTitle) . "%'";        }
        if (!empty($SearchTel)) {            $_where .= " AND tel LIKE '%" . urldecode($SearchTel) . "%'";        }
        if ($_where == '1') {            $_where = '';        }
        $count = $ModelManager->where($_where)->count();

        $resultArr = array();
        $List = $ModelManager->where($_where)
                                    ->order('create_time DESC')
                                    ->paginate(config('paginate.list_rows'), false, ['query' => $this->request->get('', '', 'urlencode')]);
        $show = $List->render();

        foreach ($List as $arr) {
            $resultArr[] = $arr;
        }

        $this->assign("count", $count);
        $this->assign("List", $resultArr);
        $this->assign("page", $show);
        $this->assign('paramUrl', $paramUrl);
        return $this->fetch();
    }

    /**
     * @描述：审核状态-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelManager = Db::name('admin');
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;

        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;

            $ModelManager->where("admin_id='$id'")->setField('data_status',$Status);
        }

        $this->success("操作成功",url("manager/index"),3);
        exit;
    }

}