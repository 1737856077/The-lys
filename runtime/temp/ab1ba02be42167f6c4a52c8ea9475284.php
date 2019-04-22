<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\Users\Administrator\Desktop\suyuan\sy/admin/qrcode\view\createqrcode.add.html";i:1555559600;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>二维码管理-二维码列表-生成二维码</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/images/style.css"/>
    <link type="text/css" rel="stylesheet" href="/static/admin/css/index.css"/>
    <link type="text/css" rel="stylesheet" href="/static/admin/css/public.css"/>
    <script type="text/javascript" src="/static/admin/js/jquery.js"></script>
    <script type="text/javascript" src="/static/admin/js/myString.js"></script>
    <script type="text/javascript" src="/static/admin/js/function.js"></script>
    <script type="text/javascript" src="/static/admin/js/PublicUser.js"></script>
    <script language="javascript" type="text/javascript"
            src="/static/admin/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/admin/js/PublicUploadImg.js"></script>
    <script type="text/javascript" src="/static/admin/js/createqrcode_add.js"></script>
</head>
<style type="text/css">
    .btn_public_orgin {
        height: 30px;
        line-height: 30px;
        text-align: center;
        background-color: #aa5500;
        color: #ffffff;
        padding: 0px 10px;
    }
</style>
<body>
<div class="container">

    <div class="cont_title">　你当前的位置：二维码管理 - <a href="/admin.php/qrcode/createqrcode/index">二维码列表</a> - 生成二维码</div>

    <div class="con">

        <div class="conlist">
            <form action="/admin.php/qrcode/createqrcode/insert" method="post" enctype="multipart/form-data" name="form1" id="form1"
                  onSubmit="javascript:return subfun();">
                <input type="hidden" name="actionType" id="actionType" value="0"/>
                <table class="listtable">
                    <tr class="tr1">
                        <td colspan="2" class="tit">生成二维码</td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">产品:<span style="color:#f00;">*</span></td>
                        <td class="tdr" style="padding-top:5px;">
                            <select name="product_id">
                                <?php foreach($listProduct as $value): ?>
                                <option value="<?php echo $value['product_id']; ?>"><?php echo $value['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="span_product_id" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">标题:<span style="color:#f00;">*</span></td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="title" id="title" size="60" maxlength="32"
                                   onKeyPress="return noStrs(event);" onBlur="onBlur_title()"/>
                            <span id="span_title" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">生产批次:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="production_batch" id="production_batch" size="60" maxlength="32"
                                   onKeyPress="return noStrs(event);"  />
                            <span id="span_production_batch" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">生产日期：</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="manufacture_date" id="manufacture_date" size="20" maxlength="10"
                                   value="<?php echo date('Y-m-d'); ?>" class="Wdate"
                                   onClick="WdatePicker()"/>
                        </td>
                    </tr>
                    <tr class="tr1" style="display: none;">
                        <td class="tdl">纠错级别:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <select name="level">
                                <option value="L" selected>L - smallest</option>
                                <option value="M">M</option>
                                <option value="Q">Q</option>
                                <option value="H">H - best</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">尺寸:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <select name="size">
                                <?php $__FOR_START_17141__=1;$__FOR_END_17141__=10;for($i=$__FOR_START_17141__;$i < $__FOR_END_17141__;$i+=1){ ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> (<?php echo $i*29; ?>px X <?php echo $i*29; ?>px)</option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">二维码数量：</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="product_code_num" id="product_code_num" size="8"
                                   maxlength="12" onkeypress="return noNumbers(event);"
                                   value="1" onblur="onBlur_product_code_num()" />
                            说明：当数量小于等0时， 自动处理为1
                        </td>

                    </tr>
                    <tr class="tr1">
                        <td class="tdl">上市时间：</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="market_time" id="market_time" size="20" maxlength="10"
                                   value="<?php echo date('Y-m-d'); ?>" class="Wdate"
                                   onClick="WdatePicker()"/>
                            说明：当上市时间为空，默认为生成二维码的日期
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="td1">上市区域：</td>
                        <td class="tdr"  style="padding-top:5px;">
                            <select id="sheng" name="sheng">
                                <option value="">请选择省份</option>
                                <?php if(is_array($region) || $region instanceof \think\Collection || $region instanceof \think\Paginator): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value='<?php echo $vo['area_code']; ?>'><?php echo $vo['area_name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <select id="city"  name="city">
                                <option value="">请选择城市</option>
                            </select>
                            <select id="qu"  name="qu">
                                <option value="">请选择区</option>
                            </select>
                            <select id="jie"  name="jie" style="display: none;">
                                <option value="">请选择街道</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">经营企业:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="business_enterprise" id="business_enterprise" size="60" maxlength="128"
                                   onKeyPress="return noStrs(event);" />
                            <span id="span_business_enterprise" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">联系人:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="contacts" id="contacts" size="60" maxlength="32"
                                   onKeyPress="return noStrs(event);" />
                            <span id="span_contacts" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">联系电话:</td>
                        <td class="tdr" style="padding-top:5px;">
                            <input type="text" name="tel" id="tel" size="60" maxlength="32"
                                   onKeyPress="return noStrs(event);" />
                            <span id="span_tel" style="color:#f00;"></span>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">描述：</td>
                        <td class="tdr" style="padding-top:5px;">
                            <textarea name="data_desc" rows="5" id="data_desc" onKeyPress="return noStrs(event);"
                                      cols="60"></textarea>
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl">备注：</td>
                        <td class="tdr" style="padding-top:5px;">
                            A、提交：普通生成方式，二维码需要手动开启，方有效；<br/>
                            B、生成并下载(TXT)：快速生成方式，二维码可批量开启状态；
                        </td>
                    </tr>
                    <tr class="tr1">
                        <td class="tdl"></td>
                        <td class="tdr" style="padding-top:5px; position:relative;">
                            <input type="submit" name="Submit" value="提交" class="btn_public_orgin"
                                   onclick="document.getElementById('form1').target='';document.getElementById('actionType').value ='0';"/>　
                            <input type="submit" name="Submit" value="明码生成并下载(TXT)" class="btn_public_orgin"
                                   onclick="document.getElementById('form1').target='_blank';document.getElementById('actionType').value ='1';"/>　
                            <input type="submit" name="Submit" value="暗码生成并下载(TXT)" class="btn_public_orgin"
                                   onclick="document.getElementById('form1').target='_blank';document.getElementById('actionType').value ='2';"/>　
                            <input type="button" name="button" value="返回" class="buttomgray"
                                   onClick="javascript:history.go(-1);"/>

                        </td>
                    </tr>
                </table>

            </form>
        </div>

    </div>


</div>
<script>

    $("#sheng").change(function () {
        var sheng = $('#sheng').val();
        $.ajax({
            type: 'post',
            url: '/admin.php/qrcode/createqrcode/shi',
            data: 'shi=' + $('#sheng').val(),
            dataType: "json",
            success: function (data) {
                var option = "", shi = '';
                document.getElementById("city").options.length = 0;
                document.getElementById("city").add(new Option("请选择城市",""));
                document.getElementById("qu").options.length = 0;
                document.getElementById("qu").add(new Option("请选择区",""));
                document.getElementById("jie").options.length = 0;
                document.getElementById("jie").add(new Option("请选择街道",""));
                for (var i = 0; i < data.length; i++) {
                    if (shi == '') shi = data[i];

                    option += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                }
                $("#city").append(option);
                set_qu(sheng, shi);
            }
        })
        $("#city").change(function () {
            var sheng = $('#sheng').val();
            var shi = this.value;
            set_qu(sheng, shi);

        })

        function set_qu(sheng, shi) {

            $.ajax({
                type: 'post',
                url: '/admin.php/qrcode/createqrcode/shi',
                data: {'shi': sheng, 'shi': shi},
                dataType: "json",
                success: function (data) {
                    document.getElementById("qu").options.length = 0;
                    document.getElementById("qu").add(new Option("请选择区",""));
                    document.getElementById("jie").options.length = 0;
                    document.getElementById("jie").add(new Option("请选择街道",""));
                    var html = "";
                    for (i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                    }
                    $('#qu').append(html);
                }
            })
        }

        $("#qu").change(function () {
            var shi = $('#qu').val();
            var shi = this.value;
            set_qu1(shi);

        })

        function set_qu1(shi) {

            $.ajax({
                type: 'post',
                url: '/admin.php/qrcode/createqrcode/shi',
                data: {'shi': shi},
                dataType: "json",
                success: function (data) {
                    var html = "";
                    document.getElementById("jie").options.length = 0;
                    document.getElementById("jie").add(new Option("请选择街道",""));
                    for (i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                    }
                    $('#jie').append(html);
                }
            })
        }
    })</script>

</body>
</html>