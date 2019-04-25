<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"C:\phpStudy\PHPTutorial\WWW\sy/business/qrcode\view\productcode.index.html";i:1555919872;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>积分码列表</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/images/style.css"/>
    <link type="text/css" rel="stylesheet" href="/static/admin/css/page.css"/>
	<script type="text/javascript" src="/static/admin/js/myString.js"></script>
    <script type="text/javascript" src="/static/admin/js/function.js"></script>
    <script type="text/javascript" src="/static/admin/js/PublicUser.js"></script>
</head>

<body>
    <div class="cont_title">　你当前的位置：商家管理 -积分码列表</div>
    
    <div class="con">
    
    	<div class="conlist">
        <form name="form1" method="get" action="/business.php/qrcode/productcode/index">
     	<table class="listtable">
                    <tr class="tr1">
                        <td  colspan="8" class="tdlist">查询：
                            产品名称 <input type="text" name="SearchTitle" id="SearchTitle" value="<?php echo $SearchTitle; ?>" />　
                            <input type="submit" name="ordersearchsubmit" class="buttomgray"  value="查询" />
                        </td>
                        <td  class="tdlist">
                            <?php if(auth('qrcode/createqrcode/add')): ?>
                            <a href="<?php echo url('createqrcode/add'); ?>"><input type="button" name="" class="buttomorger"  value="生成二维码" /></a>
                            <?php endif; ?>
                        </td>
                        <td  class="tdlist">
                            <a href="/business.php/index/index/index"><input type="button" name="" class="buttomorger"  value="首页" /></a>
                        </td>
                    </tr>
				</table>
                 </form> 
        <form  method="post" action="/business.php/qrcode/productcode/editinfo/action/save?<?php echo $paramUrl; ?>">        
				<table class="listtable">
                    <tr class="tr1">
                        <td colspan="9" class="tit">列表　<a href="/business.php/qrcode/productcode/index">显示全部</a>　</td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdtit">ID</td>
                        <td class="tdtit">产品名称</td>
                        <td class="tdtit">标题</td>
                        <td class="tdtit">批次名称</td>
                        <td class="tdtit">上市时间</td>
                        <td class="tdtit">码开始数值</td>
                        <td class="tdtit">码结束数值</td>
                        <td class="tdtit">产品码数量</td>
                        <td class="tdtit">所属用户</td>
                        <td class="tdtit">操作</td>
                    </tr>
                   <?php foreach($List as $value): ?>
                	<tr class="tr1">
                    	<td class="tdlist"><?php echo $value['id']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['product_title']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['title']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['production_batch']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo date('Y-m-d',$value['market_time']); ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['product_code_begin']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['product_code_end']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['product_code_num']; ?>&nbsp;</td>
                        <td class="tdlist"><?php echo $value['admin_name']; ?>&nbsp;</td>
                        <td class="tdlist">
                            <?php if($value['data_type'] != 2): if(auth('qrcode/productcodeinfo/index')): ?>
                                [<a href="<?php echo url('productcodeinfo/index'); ?>?product_code_id=<?php echo $value['product_code_id']; ?>">积分码详细列表</a>]　
                                <?php endif; endif; if($value['data_type'] != 2): if(auth('qrcode/productcode/openqrcode')): if($value['is_batch_open'] == 0): ?>
                                    <a href="/business.php/qrcode/productcode/openqrcode?product_code_id=<?php echo $value['product_code_id']; ?>" ><font color="#ff0000">[批量开启]</font></a>
                                    <?php else: ?>
                                    <font color="#006600">[已开启]</font>
                                    <?php endif; else: if($value['is_batch_open'] == 0): ?>
                                    <font color="#ff0000">[批量开启]</font>
                                    <?php else: ?>
                                    <font color="#006600">[已开启]</font>
                                    <?php endif; endif; endif; if($value['data_type'] != 2): if(auth('qrcode/productcode/edit')): if($value['is_batch_open'] == 0): ?>
                                    <!--<a href="/business.php/qrcode/productcode/edit?product_code_id=<?php echo $value['product_code_id']; ?>" ><font color="#ff0000">[编辑]</font></a>-->
                                    <?php else: ?>
                                    <!--<font color="#006600">[编辑]</font>-->
                                    <?php endif; endif; endif; ?>
                        </td>
                    </tr>
				    <?php endforeach; if($count == 0): ?>
                    <tr class="tr1">
                    	<td colspan="9" class="tdlist">暂无相关记录！ </td>
                    </tr>
                <?php endif; ?>
                
            </table>
            <div style="text-align:right; padding-right:40px;">
            <?php echo $page; ?>
           </div>
           </form> 
            
        </div>
    
    </div>
    
 
</div>
</body>
</html>