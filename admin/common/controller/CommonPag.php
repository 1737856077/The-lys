<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/9
 * Time: 9:47
 */

namespace app\common\controller;


use think\Controller;
use think\paginator\driver\Bootstrap;
class CommonPag extends Controller
{
    /**
     * @数据分页
     */
    public $url;
    public function page($data, $name, $page, $listRow = '')
    {
        if (!is_array($data) || empty($data) || empty($name) || empty($page)) {
            return false;
        }
        if (empty($listRow)) {
            $listRow = intval(config('paginate')['list_rows']);
        }

        $curPage = input('page') ? input('page') : 1;
        $showData = array_slice($data, ($curPage - 1) * $listRow, $listRow, true);
        $p = Bootstrap::make($showData, $listRow, $curPage, count($data), false, ['var_page' => 'page', 'path' => url($this->url), 'fragment' => '',]);

        $p->appends($_GET);
        $this->assign($name, $p);
        $this->assign($page, $p->render());
    }
}