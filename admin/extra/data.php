<?php
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:固定配置参数
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:data.php 2018-04-06 09:34:00 $
 */
return [
    //与C++系统对接，接口起始标识符
    'c_interface'=>['begin_str'=>'######',
                        'end_str'=>'######',
        ],

	//导入文件支持的格式
	'upload_file_ext'=>['excel'=>'xls,xlsx',
						'image'=>'jpg,jpge,png',
	],

    //导入EXCEL的上传目录
    'upload_file'=>['excel'=>'./static/uploads/excel/',
        'savename_rule'=>'date',
        'excel_backup'=>'./runtime/temp/',
    ],
	'alipay' => [
		//该地址表示用户缴费支付完成后开发者系统接受支付结果通知的回调地址。
    	'notify_url' => 'https://yunpai.sindns.com/index.php/alipay/wypaycallback/index',
        //同步跳转
        'return_url' => 'https://yunpai.sindns.com/onlinepay/alipay/return_url.php',
        'app_id'=>'2019031863590154',//应用AppID
        'rsaPublicKeyPem'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxCRT9A33sdzLiroi1YhnuNcIRuJZAdKWiEtZ6uZoRq8oyzCOF79IlqzlXS5FO3x/UqLi83KdrWlQPLHQVTLuFGey3yETamlLmTRwgKS5KSYreemPnyD5u9lqyE8ULTHWAMVikha8NtauPB7CdIyPsuVeMw8kPS4pqUE6y3a29zw3Dawx9JYxuPt7Ejvn8XCwQWRC8l/sFALAGgexN8tyke0Lc4W5yZdfDSSPD4GMvh5Xs9GqsObqhuiM51ZcImcLoZPE19EXWeHfuEJbUEs9xjTFHKGfDIGSDPuhcXUCtI2+mKM0BNCeO7Gkx2A8mSM3l7ZB5ct5Dah1K05PIC7FJQIDAQAB',//应用公钥
        'rsaPrivateKey'=>'MIIEpAIBAAKCAQEAxCRT9A33sdzLiroi1YhnuNcIRuJZAdKWiEtZ6uZoRq8oyzCOF79IlqzlXS5FO3x/UqLi83KdrWlQPLHQVTLuFGey3yETamlLmTRwgKS5KSYreemPnyD5u9lqyE8ULTHWAMVikha8NtauPB7CdIyPsuVeMw8kPS4pqUE6y3a29zw3Dawx9JYxuPt7Ejvn8XCwQWRC8l/sFALAGgexN8tyke0Lc4W5yZdfDSSPD4GMvh5Xs9GqsObqhuiM51ZcImcLoZPE19EXWeHfuEJbUEs9xjTFHKGfDIGSDPuhcXUCtI2+mKM0BNCeO7Gkx2A8mSM3l7ZB5ct5Dah1K05PIC7FJQIDAQABAoIBAGihOGeoS8mFjs6iHJLsAOiJTNEDTZe7TrHGAGFeJ6INLiW18RaZ4479DB144VWqRAFBAu/65EHtO/Akqo3IbVhVOQXuDv1kzf8cCieVt3BL/EU8YnDwlkeu41eXV5wESbR/luV3W0+llaxcfD7P/Jfh4y45lYtNZMv1D/gZi+C2PwIlko2NAHvEhaFmaaeuCJTDrBTqlvKlWgdSRHmcIy0Z8BYwwF3WHL24aIH+YtojgyyVrNPTzthPzsd+gTpbEWw2DZur+xeBx1vYn8CyrB5ZnXD+QfwBLu75ONK+q87rnhTclUmWnlmY0UeU4Syj0e8dl2AKpgYK5U0DB6l0hsECgYEA7BxCoPnxFooc0TFX+4oOXLjDW8K5ZEbW6/X618SJ8qW1rk75Jio380eAy+Y2VIq5fgGTwrl3ksdUCWkM1PvnuexqrbOLGXTqL7QK+RKPkigSPLVWofg173ZAsBtFRpexpQWBYTDJpnjgwt2xGFxI+lqfc8jLYDQ1a2FkVJNd+esCgYEA1Kok3+x4t0vjsPtl5JFjnPldw0WC04I23cXC81+RbZPlmuLul/fIcDI2K3oV4Ag7RwIU8o8J3EmbfdDoGh/YoL0wolFtiwy1YcTy4D1dJMGX1+EOZM9hduLTfWAXJCuvXaSC4H21XVbbWPJtHW5gKpaazLmDvkcbUVEs9h+l6S8CgYAlp8woiDQe+B/obQovH7FysDTX6ZJPn8yfDTfYOYwWmr8C8a1inNEXh4vO+QQpL4atxeqe351mV0vbxFk7joFCcaYB1eSVRsQin4AwgPlMwf9Gl1Udt8xCSIXAkFjYDVFTlDEyIunGFvkhmuGnlPA+nT1Y5ekpiqoKWhn6MxaFyQKBgQCf1WDxi2EPIlJ26fui1kLv79uwr8WsAeoKtF/ZWrKKkOW4i2aXgPt8l8Bu3MskHguvSrlDtI3MquXaofBP8i92X7r1xA14vIx2dvez4Wrn/TiKX/PZgKPYHpKlYFsELHEZCFP1NYXiKS2ipFGuFQ7h819VDvkdQYQekcwhD5g6sQKBgQDlClBmVwsnrOFiiBOGSPlXbCpF80wXQX6WYEEJh4ca5XIWDdzqpjpYVrSE68rg2bW+88fv/tc41bUXbLk5ru90LDKgRKUkW9vnJHNd2Z+Jf5FGsggqxu/A1iMYPK9GB6B+LmX316ZQnoF+NoMkYXY/mZ5DqNru3k2P92AQwV5WrA==',//请填写商户私钥，一行字符串
        'alipayrsaPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5MMK1X0edAy4f/MviUmVfeW7USLF/v1HfjFN1pKRb08o/vXu57XovSdxDm5TD+Jb+jYpgYVeBJCIjwNLwb6keHfiVa6jcDhjiTYNQDFdkONRb1yy4BRqqE1gvhfy1UmG9Lb7Q6Th7A1jd5eSFA4xajhFGeNUVZJFs5b1G9ZSz+8vj2IyNqBYA9wvpjhzJixIfXaqyUfwPvXuWYLV6J8r1UNrPGy4nSlsRJBngPIT6aWONcS8nzb7aTaEu8pjpCLGHmAtX6ESmLhYmDgb1QRh7V9VAEirESPzMon9y35pX2yvJyWQRV/UkSC8OZKzO5brTsfa/0CklPvqL7F8i6KX4wIDAQAB',//请填写支付宝公钥，一行字符串
        'url'=>'https://openapi.alipay.com/gateway.do',
	],

    //二维码配置信息
    'qr_data'=>['query_url'=>'https://zhuisu.sindns.com/index.php/index/product/index',//二维码的查询地址
        'web_host'=>'https://zhuisu.sindns.com/',//二维码的查询-域名地址
    ],

    // 管理员状态
    'admin_status' => [
        '0' => '冻结',
        '1' => '正常'
    ],

    //不需要加入权限的控制器
    'not_in_auth_url'=>['index/index/index',//'系统首页',
        'index/menu/main',//'系统默认显示的主页',
        'index/menu/header',//'系统净头部',
        'index/menu/menu',//'系统左侧菜单',
        'index/homereport/index',//'系统首页-总计结果显示页面',
    ],
    // 订单状态
    'order_status'=>['0'=>'新提交',
        '1'=>'已核实',
        '2'=>'设计中',
        '3'=>'设计结束',
        '4'=>'已完成'
    ],
    //支付状态
    'pay_status'=>['0'=>'未支付',
        '1'=>'已支付'
    ],
    //模版分类
    'template_data_type'=>['0'=>'公共模版',
        '1'=>'定制模版'
    ],
    //条码类型
    'template_code_type'=>['0'=>'二维码',
        '1'=>'条形码'
    ],
    // 纸张厚度单位
    'paper_thickness_unit'=>['mm'=>'毫米（mm）',
        'cm'=>'厘米（cm）',
        'in'=>'英寸（in）'
    ],
    // 打印模式
    'preorder_print_mode'=>['0'=>'单个标签',
        '1'=>'循环标签'
    ],
    // 排序方式
    'preorder_print_sort'=>['0'=>'正序',
        '1'=>'倒序'
    ],
    // 纸张方式
    'preorder_paper_direction'=>['0'=>'横向',
        '1'=>'纵向'
    ],
];
