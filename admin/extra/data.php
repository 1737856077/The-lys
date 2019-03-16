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
];
