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
        'app_id'=>'2019042464291401',//应用AppID

        'rsaPublicKeyPem'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvPhmE+F6xvCATXNhgDAdkRr35Zj4JUDPc0dx6PbriwCZjdU6DKaLLNhMiFkw1sCFMD1KZa5GluN562Qy/RBUe90wgxzAzYnTyOO51DzIgBERGUBXgc/lrkbBF9oK2k13lM0xGbfIEMio8+xQg72yeb1NK7414OUUy50bL/YTXtonIE5KMWCvDzpf43NzThKYm8jWcDSajo0ShBuIDW1sIsztPiBBsc9OSibYt3yWLZ4z+L5tctuuxreKRJgldQtTBIPCb01164sj/4VXA0tVUflEBUhtukpX+itEIG4Wu+VRQK5BUpyf6tUawYRWv7ga6C4xCaJa2P1xjEcg/H/yjwIDAQAB',//应用公钥

        'rsaPrivateKey'=>'MIIEpAIBAAKCAQEAvPhmE+F6xvCATXNhgDAdkRr35Zj4JUDPc0dx6PbriwCZjdU6DKaLLNhMiFkw1sCFMD1KZa5GluN562Qy/RBUe90wgxzAzYnTyOO51DzIgBERGUBXgc/lrkbBF9oK2k13lM0xGbfIEMio8+xQg72yeb1NK7414OUUy50bL/YTXtonIE5KMWCvDzpf43NzThKYm8jWcDSajo0ShBuIDW1sIsztPiBBsc9OSibYt3yWLZ4z+L5tctuuxreKRJgldQtTBIPCb01164sj/4VXA0tVUflEBUhtukpX+itEIG4Wu+VRQK5BUpyf6tUawYRWv7ga6C4xCaJa2P1xjEcg/H/yjwIDAQABAoIBAQCqFvdiW6j0WdNSY1FWXXivfFO3gHmSpoRTYfJg26flhNOx+0P10Q4ifkpcy9MO6Vi4s+I8JaJ5/CRoQNc4OzOgDda1nPLZzn4nKvq/0zoxM6ttTCG3wVYeCKeS/XqZRfMlp4/Tcz2MBeE1NPa/rcZwl3hXsCy00d1m7HFlORv0WeG56d/Q6cUV/kHGX+yT4schhfqISeg8kxrTyJc6ptr2jCg2D4T90zd9KWKL6lb5JHCpjgS2/ohb/hdwr6VQsC6I+6gpCHZ93MNtsrU6zq2OOfNDnLcbMrgyDIZRSy99JNHRcQNQE5Pv662KEF3LVDHsUdUO1C4iCYi5Rs/NOrkZAoGBAN24M2seamX/FNhbZqMUQQnW6VllgrR392TbTnG86iOpBUh43Lns8rdQD0Ja2jqpGL3DY104wS1+F9FSlzvyaiM5UcsnUC04OF2XbVPiqsbszE/cno4J3qceELww4FGUg29pRB0dokmqNyr9/yP/Lc6sguzdkVKgByNnLL34lTMLAoGBANov9nqjoX1+PcXC5iDxRehOavttqpNFFqIveeA9WRJVxacYgsc7jLx4mP4XG11JRLMrZJenixhVC/oHuDHQaNnTeYP2FPAbRxHAiKkXhc76/MRT2m/xt8qv1+M3JAylabT+L+KX3oOzbYUVh57XHam7TsVKhaxBzKTv8DQi/fENAoGAHDf2a1q6pfKaH5M6c+T/BhaRKmyN/xQJq49x423sys8XOgsP5KXwmj4ZQxO3FKIy4Ov+OH4hr/2NYHnHf7yxn3wLGfUN8kNmgRrlsjh2Dc1Tj5J/p4pACTr9XEZINnnVZJecMKx13DRKwzECiP1QQi6Ylzb36PEvF2VpP2Bk9NMCgYEAiKDGOO/kfWAjMIamcvSDMUCBz6ZRzVzTGoaeTCQ+dbPOTJ+VrUsGCzN9ooc3tIfgBE5k9G6PNJJ1KIHS/yahsd2yV0cuv1hlfaFSMoivWvhidlKIE9eKntrUVs09vsmKUzNlKwCs703ZhCACSB4uzg2j+vl6kW62xoYVpaBP4rUCgYA/1ORN+NhMws+LGapEiXqbuLtlEvATt0lG39kE797sD81fmphfhHA7Tfo4KPOMSRVesen9LPzf+lPUAsTpOXaHLFGIE1VNpXA9AijZvIrDujD7abqclIyL583dFpyLovFEyIjB53l16WE+D5KR5bLEfqkT2x1p2smokVhae+Pexg==',//请填写商户私钥，一行字符串

        'alipayrsaPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgbng5bUmF0eY0fRz2EuhGlvVxjnEtq+nEoBnAU1BXRDxwVRLBFDoOt80pU5NX5y3VWk9qHxVi00PC2oZOvq2NioDH48u1mtkKW9ySxPSLuQ6zn6EdrLygtcib1nO7iR3LUQ3fzjR5MVUn9gf9TP6XgmkDeFolbwnwVdS5Z5W3SwUZ/kNWkDYD52LMGwlX9rd0d3LqU+u0pZwj8C1imTZ9YEPinYSGxnfdRSa9zK75Jtzz0iFsXMvGsuM4i4hC30Az2QwP9MDanNxtCvr5at792/1ziuAFNj717F/XJnzrOqlSwupbxVN+hCBLaDA+57ohP+XgEb+uS7RhJpiQ0TEyQIDAQAB',//请填写支付宝公钥，一行字符串

        'url'=>'https://openapi.alipay.com/gateway.do',
    ],
];
