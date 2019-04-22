<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19
 * Time: 13:42
 */

namespace app\member\controller;

use app\common\controller\CommonIntegra;
use think\Db;
use think\Session;

class Index extends CommonIntegra
{
    public function index()
    {
        $admin = $this->request->param('adminid');
        $admin = 4;//用户登录存session

        return $this->fetch();
    }

    /**
     * 渲染用户添加发货地址界面
     */
    public function site()
    {
        $memberid = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $memberid)->find();
        $this->assign('member_data', $member_data);
        $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
        $this->assign('region', $region);
        return $this->fetch();
    }

    /**
     * 查询地区
     */
    public function shi()
    {
        $param = $this->request->post();
        $shi = Db::name('region')
            ->where('area_parent_id', isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
            ->field('area_name,area_code')
            ->select();
        return json($shi);

    }

    /**
     * 保存发货地址
     */
    public function sitesave()
    {
        $param = $this->request->param();
        $uid = htmlspecialchars(isset($param['uid'])?$param['uid']:'');
        $admin_id = htmlspecialchars(isset($param['admin_id'])?$param['admin_id']:'');
        $name = htmlspecialchars(isset($param['name'])?$param['name']:'');
        $tel = htmlspecialchars(isset($param['tel'])?$param['tel']:'');
        $sheng = htmlspecialchars(isset($param['sheng'])?$param['sheng']:'');
        $shi = htmlspecialchars(isset($param['city'])?$param['city']:'');
        $qu = htmlspecialchars(isset($param['qu'])?$param['qu']:'');
        $jie = htmlspecialchars(isset($param['jie'])?$param['jie']:'');
        $address = htmlspecialchars(isset($param['address'])?$param['address']:'');
        $code = htmlspecialchars(isset($param['code'])?$param['code']:'');
        $data_type = htmlspecialchars(isset($param['data_type'])?$param['data_type']:'');
        $data_status = htmlspecialchars(isset($param['data_status'])?$param['data_status']:'');
        //接收到的地区为默认添加地区
        if (!empty($qu) and !empty($uid) and !empty($name)){
            $data = array(
                'rceiving_address_id'=>my_returnUUID(),
                'uid'=>$uid,
                'admin_id'=>$admin_id,
                'name'=>$name,
                'tel'=>$tel,
                'area_country_id'=>1,
                'province_id'=>$sheng,
                'city_id'=>$shi,
                'county_id'=>$qu,
                'address'=>$address,
                'code'=>$code,
                'user_type'=>0,
                'data_type'=>$data_type,
                'data_status'=>$data_status,
                'create_time'=>time()
            );
            $res = Db::name('rceiving_address')->insertGetId($data);
            //保存默认
            $data = Db::name('rceiving_address')->where('uid',$uid)->update(['data_type'=>0]);
            $datas = Db::name('rceiving_address')->where('id',$res)->update(['data_type'=>1]);
            if ($res){
                    return json(1);
            }else{
                return json(0);
            }
        }else{
            return json(-1);
        }
    }
}