<?php
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
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

    // 支付宝配置
    'alipay' => [
        //该地址表示用户缴费支付完成后开发者系统接受支付结果通知的回调地址。
        'notify_url' => 'http://tzs.sindns.com/onlinepay/alipay/notify_url.php',
        //同步跳转
        'return_url' => 'http://tzs.sindns.com/onlinepay/alipay/return_url.php',
        'app_id'=>'2019f03180154',//应用AppID
        'rsaPublicKeyPem'=>'MIIBIjANPIC7FJQIDAQAB',//应用公钥
        'rsaPrivateKey'=>'MIIEpOF79IlswV5WrA==',//请填写商户私钥，一行字符串
        'alipayrsaPublicKey' => 'MIIBIjANBgKX4wIDAQAB',//请填写支付宝公钥，一行字符串
        'url'=>'https://openapi.alipay.com/gateway.do',
    ],
];
