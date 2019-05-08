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

        'rsaPublicKeyPem'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwOCbUG7UCAl3r0lDDE3zqNoVndHKendL1UK92IlQ09KXvO60T3rQ3SDRE4iqLVepZQlFUB1qt8ZWIMefpfaPuiD0HxOuCYQTgxkem7igwbg/EzMTK5FkRyVN9e6FnvCpx1EHWSzBFJFEz43u543WlOTqkvyvJbWOOJdV23LOry6R17eSQJ3cDk/nL53HsESNxhbD+u0Cd6+ZtT+iFFaPNKIrxDvOjOuPSXCQWbzNZIHkqNQEAnlMFQ0jK1YSb8EFeChDRpx67vTPi14qvrEIGOfjz01MPKIAklBKnfcTBzKKRWmTJCjfLWkZZZuCMY064v+9CHJWXoHrr4S0FGhvpwIDAQAB',//应用公钥

        'rsaPrivateKey'=>'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCGMXvXVBhtZ87SzOQ9L0mELC0/nOwljUXb8TvCbrbf0KT7uoXD4IzkyT4Puc4bEczqGfjH9+fyF9KqH+3cVP/LDLyESwOZapEbP+iumYJ0fOzVhBn4KTo16JW9wAxWVJtadqNzDWaIPzyFDwOwMJtkYRI7+RyYdT5ghwheDV/mPUPC9/O1cCwcyY10iTL3/NaStczq32XXBJNe9uhOObbG++EKm0rU7bg05NDI69jWk3sJYpwZwrdzAY3cOafTVln1llYUbcPE7LpLPCa8aUZzo5ZpO6XhC2QN4+6Ry4rVGKGWJfSL8PSsrIqsDEASr60YdIcW4O88RTIW3or4IjtHAgMBAAECggEAbmXvWCrbHca1JD9j1eI9PPuLDjZvIEWlH1jKrR6gXGkuEdpVidwGjYHyCMX3hdWTG1TaksikjUqECWnTKdzTw5xqyvtbrq85SY2+Q0YPSP4taUsQglSIiykZZ83DWJKqbDYGKfTwUU6U33KGukCC1oX1lllO6S4rbwYoIBgouSSjPUp4/wqoUI0d0ix2dw6o9HgLPMaP3Bi06PM5aslLYHru34in2XS0TCL47Lj2BpnXKephrhgP+Pe+C+id+rczSGSvj6bhJoBUj21fe3BUY9Hw0Rl9lUn4Q3XLE4uMbnpd/fWB8LrFe0hCb/zqTZomqvyOSavfpOB9CMAUs7MUQQKBgQDNIHD6lJi3+h5zmv1QMGjvySwIDP5EhmIzlQbTGNFZ3PCHDpl0ThSgON+zd2cav4hJTF5JX9NO44N8tQvhiSjc0TcMULgqUpcJ/3Zq1EfeYMnmKDYOMx44h+EK02px45KmHIuEwM7wtmUU1R7oh5BJTYOepbi7xXF2IChsqwpdCQKBgQCneXUSRGWxDFONoajdijoCihkzqkSqtpB6fALMWASkWwnuHT8NxBPFr5j8Mms4+T7AJTPTSMnekzdhrtRjCb/fo59GLF2QuPX4i20VCOS57j2fwQoUu1s0icMU7YtRYSrCUzPqZgNtUpzJFSFyT5kS0oD1yH5JrozrzMomCDo5zwKBgFYlMK1bqINjLFS6m3WIzxkcsDw1ULdwhF9LT9Fpk8ocinr9u55niCv9lpzlIUzPcSnvQ42nC7QOwlKmKfYuxxVtW6P1ZlKH2tydB5s3yXLvzPq2mnT+LMvq7KzCOurXeuf+Bu3al03qG6tTEabv/715KzR+PoXFFrBYMwHoFvMZAoGBAKJgWqgJdOeCYghycz3JZZFMwD6dmdJDDDYVwsjJlkacljYuWRJJyDnllVkAsYEd+D9oUqVKb5/D8PBfCEG2FDkLdcQeA+Hr02DWHj9Ezi+P1GPuUI3lUfrQjzrdTjTrFwAul6lum2gFr0ovmKwyjOH5A1xKtldOTAfcGSti0sF1AoGAMsHT9dKm9EGuoYONqP9ch7LykVqO64PQE2EZ5Y6oUDqIqNGSgi4HI70oqgk5oMqTcGdqm5Wrt4/rVMPKn3zE7vZwF+lLdkwMinsCYPQ8yrQaGTonX8u+yiX40V7c+C9u4HfgeQ34sB4JdleR78nFm7FSCI5RGwXSvLsjfPnm2rw=',//请填写商户私钥，一行字符串

        'alipayrsaPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgbng5bUmF0eY0fRz2EuhGlvVxjnEtq+nEoBnAU1BXRDxwVRLBFDoOt80pU5NX5y3VWk9qHxVi00PC2oZOvq2NioDH48u1mtkKW9ySxPSLuQ6zn6EdrLygtcib1nO7iR3LUQ3fzjR5MVUn9gf9TP6XgmkDeFolbwnwVdS5Z5W3SwUZ/kNWkDYD52LMGwlX9rd0d3LqU+u0pZwj8C1imTZ9YEPinYSGxnfdRSa9zK75Jtzz0iFsXMvGsuM4i4hC30Az2QwP9MDanNxtCvr5at792/1ziuAFNj717F/XJnzrOqlSwupbxVN+hCBLaDA+57ohP+XgEb+uS7RhJpiQ0TEyQIDAQAB',//请填写支付宝公钥，一行字符串

        'url'=>'https://openapi.alipay.com/gateway.do',
    ],
];
