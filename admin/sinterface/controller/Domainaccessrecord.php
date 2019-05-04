<?php
namespace app\sinterface\controller;
/**
 * @[溯源系统] kedousuyuan Information Technology Co., Ltd.
 * @desc:网站前台-取得用户的域名信息
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Domainaccessrecord.php 2019-05-02 18:35:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use app\common\controller\CommonBaseHome;
class Domainaccessrecord extends CommonBaseHome
{
    public function index(){
        $param = $this->request->param();
        $_getServerHost=isset($param['webName']) ? htmlentities(trim($param['webName'])) : '';
        $_getRemoteIP=isset($param['ip']) ? htmlentities(trim($param['ip'])) : '';
        $gettime=time();

        $result=['code'=>'0',
            'msg'=>'success'
        ];
        if(empty($_getServerHost)){
            $result['code']='40001';
            $result['msg']='Necessary items should not be blank';
            echo $this->returnJson($result);
            exit;
        }

        $modelDomainAccessRecord=Db::name('domain_access_record');
        // 查看是否存在
        $getone=$modelDomainAccessRecord->where("domain_name='$_getServerHost'")->find();
        if(empty($getone)){
            // 新增
            $data=array(
                'domain_name'=>$_getServerHost,
                'ip'=>$_getRemoteIP,
                'data_status'=>1,
                'create_time'=>$gettime,
                'update_time'=>$gettime,
            );
            $modelDomainAccessRecord->insertGetId($data);
        }else{
            // 查看是否为非法域名
            if($getone['data_status']!=1){
                $result['code']='60002';
                $result['msg']='非法域名！';
                echo $this->returnJson($result);
                exit;
            }
        }

        echo $this->returnJson($result);
        exit;
    }
}