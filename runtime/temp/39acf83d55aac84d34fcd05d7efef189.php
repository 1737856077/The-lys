<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\Users\Administrator\Desktop\suyuan\sy/admin/qrcode\view\qrreport.index.html";i:1555559600;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>二维码管理-二维码统计</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/images/style.css"/>
    <link type="text/css" rel="stylesheet" href="/static/admin/css/page.css"/>
	<script type="text/javascript" src="/static/admin/js/myString.js"></script>
    <script type="text/javascript" src="/static/admin/js/function.js"></script>
    <script type="text/javascript" src="/static/admin/js/PublicUser.js"></script>
</head>

<body>
    <div class="cont_title">　你当前的位置：二维码管理 -二维码统计</div>
    
    <div class="con">
    
    	<div class="conlist">
        <form name="form1" method="get" action="/admin.php/qrcode/qrreport/index">
     	<table class="listtable">
                    <tr class="tr1">
                        <td  colspan="8" class="tdlist">查询：
                            商家名称 <input type="text" name="SearchTitle" id="SearchTitle" value="<?php echo $SearchTitle; ?>" />　
                            <input type="submit" name="ordersearchsubmit" class="buttomgray"  value="查询" />
                        </td>
                        <td  class="tdlist">

                        </td>
                    </tr>
				</table>
                 </form>
				<table class="listtable">
                    <tr class="tr1">
                        <td colspan="7" class="tit">列表　<a href="/admin.php/qrcode/qrreport/index">显示全部</a>　</td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdtit">序号</td>
                        <td class="tdtit">商家名称</td>
                        <td class="tdtit">总二维码</td>
                        <td class="tdtit">已激活二维码</td>
                        <td class="tdtit">未激活二维码</td>
                        <td class="tdtit">备注</td>
                        <td class="tdtit">操作</td>
                    </tr>
                   <?php foreach($list as $value): ?>
                	<tr class="tr1">
                    	<td class="tdlist"><?php echo $value['admin_id']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['name']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['countQrTotal']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['countQrTotalYJH']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['countQrTotalWJH']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['data_desc']; ?>&nbsp;</td>
                        <td class="tdlist">
                            <?php if(auth('qrcode/qrreport/productlist')): ?>
                                [<a href="<?php echo url('qrreport/productlist'); ?>?admin_id=<?php echo $value['admin_id']; ?>">查看详细</a>]
                            <?php endif; ?>
                        </td>
                    </tr>
				    <?php endforeach; if($count == 0): ?>
                    <tr class="tr1">
                    	<td colspan="7" class="tdlist">暂无相关记录！ </td>
                    </tr>
                <?php endif; ?>
                
            </table>
            <div style="text-align:right; padding-right:40px;">
            <?php echo $page; ?>
           </div>
            
        </div>
    
    </div>
    
 
</div>
</body>
</html>