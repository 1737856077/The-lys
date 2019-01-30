<?php
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:common.php 2018-04-05 13:50:00 $
 */

use app\common\controller\CommonBase;
// 应用公共文件
require_once('common.php');

/**
 * @desc : 节点权限验证
 * @param string $node
 * @return bool
 */
function auth($node)
{
    return CommonBase::auth($node);
}