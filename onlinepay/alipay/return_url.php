<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>支付结果</title>
	</head>
    <body>
    <?php
    date_default_timezone_set("PRC");
    /* *
     * 功能：支付宝页面跳转同步通知页面
     * 版本：2.0
     * 修改日期：2017-05-01
     * 说明：
     * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

     *************************页面功能说明*************************
     * 该页面可在本机电脑测试
     * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
     */
    require_once("config.php");
    require_once 'pagepay/service/AlipayTradeService.php';


    $arr=$_GET;
    $alipaySevice = new AlipayTradeService($config);
    $result = $alipaySevice->check($arr);

    /* 实际验证过程建议商户添加以下校验。
    1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
    2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
    3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
    4、验证app_id是否为该商户本身。
    */
    if($result) {//验证成功
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //请在这里加上商户的业务逻辑程序代码

        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
        //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

        //商户订单号
        $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

        //支付宝交易号
        $trade_no = htmlspecialchars($_GET['trade_no']);
        //收款支付宝账号对应的支付宝唯一用户号。
        //以2088开头的纯16位数字
        $seller_id = htmlspecialchars($_GET['seller_id']);
        //交易金额
        $total_amount= htmlspecialchars($_GET['total_amount']);

        //处理数据 liuqingyan begin(2019-03-31)
        require("../../Public/Lib/DB/config.php");
        require("../../Public/Lib/DB/DB.php");
        require("../../Public/Lib/functions.php");
        $DB=new DB();
        $gettime=time();

        // 1、验证订单
        $getoneOrder=$DB->query("SELECT * from sy_order where order_no = '$out_trade_no'");
        if (empty($getoneOrder))
        {
            if($getoneOrder['score_real_pay'] != $total_amount){
                echo "付款金额错误，请核对，需付款金额：".$getoneOrder['score_real_pay']."元，当前付款金额：".$total_amount;
                echo "<script type='text/javascript'>location.href='/index.php';</script>";
            }
            // 开启事务
            $DB->query("BEGIN");
            // 2、验证订单(验证金额、验证支付状态)
            if($getoneOrder['score_real_pay'] == $total_amount and $getoneOrder['pay_status']!=1){
                // 3\更新订单支付状态
                $_dataOrder=array('pay_status'=>'1',
                    'pay_time'=>$gettime,
                    'update_time'=>$gettime
                );
                $retrunID=$DB->update('sy_order',$_dataOrder,"order_no='$out_trade_no'");
                if(!$retrunID) {
                    // 回滚事务
                    $DB->query("ROLLBACK");
                }
            }
            // 提交事务
            $DB->query("COMMIT");
        }
        echo "支付成功!请关闭此页面...";
        echo "<script type='text/javascript'>location.href='/index.php';</script>";
        //处理数据 liuqingyan end(2019-03-31)

        // echo "验证成功<br />支付宝交易号：".$trade_no;

        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    else {
        //验证失败
        echo "验证失败";
    }
    ?>
    </body>
</html>