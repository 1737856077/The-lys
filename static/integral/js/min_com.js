// JavaScript Document
function alert(txt){
	if(!alert.isone){
		alert.isone=true;
		$('body').append('<style>.alert_min_com{position:fixed;background:#000;background:rgba(0,0,0,0.7) !important;width:auto !important;color:#fff;box-shadow:0 0 5px rgba(0,0,0,0.5);border-radius:3px;padding:5px 15px;left:0;top:50% !important;max-width:300px;box-sizing:border-box;line-height:22px;font-size:14px;animation:alert 3s;-webkit-animation:alert 3s;z-index:99999;opacity:0;}@keyframes alert{0%{transform:translateY(-50px);opacity:0;}10%{transform:translateY(0);opacity:1}90%{transform:translateY(0);opacity:1;}100%{transform:translateY(-50px);opacity:0;}}@-webkit-keyframes alert{0%{-webkit-transform:translateY(-50px);opacity:0;}10%{-webkit-transform:translateY(0);opacity:1}90%{-webkit-transform:translateY(0);opacity:1;}100%{-webkit-transform:translateY(-50px);opacity:0;}}</style>');
	}
	var id='j_alert'+new Date().getTime();
	$('body').append('<div id="'+id+'" class="alert alert_min_com">'+txt+'</div>');
	var ss=$('#'+id);
	ss.css({marginTop:-ss.height()/2,marginLeft:-ss.outerWidth()/2,left:'50%'})
	setTimeout(function(){
		ss.remove();
	},3000);
}


 
/*身份证验证*/
function IdentityCodeValid(code) { 
	var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
	var tip = "";
	var pass= true;
	
	if(!code || !/^\d{17}(\d|x|X)$/i.test(code)){
		tip = "身份证号格式错误";
		pass = false;
	}
	
   else if(!city[code.substr(0,2)]){
		tip = "地址编码错误";
		pass = false;
	}
	else{
		//18位身份证需要验证最后一位校验位
		if(code.length == 18){
			code = code.split('');
			//∑(ai×Wi)(mod 11)
			//加权因子
			var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
			//校验位
			var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
			var sum = 0;
			var ai = 0;
			var wi = 0;
			for (var i = 0; i < 17; i++)
			{
				ai = code[i];
				wi = factor[i];
				sum += ai * wi;
			}
			var last = parity[sum % 11];
			if(parity[sum % 11] != code[17]){
				tip = "校验位错误";
				pass =false;
			}
		}
	}
	//if(!pass) alert(tip);
	return pass;
}
/*身份证验证end*/

/*手机号验证*/
function checkMobile(tel){
 var reg = /^0?1[3|4|5|7|8|9][0-9]\d{8}$/;
 if (reg.test(tel)) {
	 return true;
 }else{
	 return false;
 };
}
/*手机号验证end*/

/*数字验证*/
function checkRate(str){
	if($.trim(str)=='')return true;
    var re = /^\d+(\.\d+)?$/;
    if (!re.test(str))
    {
        return false;
     }
	 return true;
}
/*数字验证end*/

/*倒计时*/
function time_sub(str,fun){
	var th=$(str);
	th.click(function(){
		if(th.attr('is')!='false'){
			if(fun()===false)return false;
			th.addClass('on').attr('is','false')
			var i=60;
			th.data('text',th.text());
			th.text(i+'秒后重发');
			var qc=setInterval(function(){
				i--;
				if(i==0){
					clearInterval(qc);
					th.attr('is','true').removeClass('on');
					th.text(th.data('text'));
				}
				else th.text(i+'秒后重发');
			},1000)
		}
	})
}
/*倒计时end*/

/*后退执行事件html5新*/
function back_fun(b_f,id_str){
	window.history.pushState({'isPush':'true'},'',owDef(id_str,''));
	
	back_fun.f[back_fun.i]=b_f;
	back_fun.i++;
	
	window.onpopstate=function(){
		back_fun.i--;
		try{
			back_fun.f[back_fun.i]();
		}catch(e){}
	};
}
back_fun.f=new Array();
back_fun.i=0;
/*后退执行事件html5新end*/

//m版时间选择控件
function line_date(t){
	
	var sel_year=t.year,sel_month=t.month,min_time=t.min_time,time_fun=t.fun,time_list_money=t.data_list;
	var new_time=new Date();
	if(min_time)new_time=new Date(min_time.replace(/-/g,'/'));
	
	new_time=new Date(new_time.getFullYear() + "/" + (new_time.getMonth() + 1) + "/" + new_time.getDate());
	var myDate=new Date(sel_year+'/'+sel_month+'/01');
	var week=myDate.getDay();
	var maxDay = new Date(sel_year,sel_month,0);
	var dayCount=maxDay.getDate();


	var str='<table border="0" cellpadding="0" cellspacing="0">'
				+'<tr class="time_top"><td colspan="7">'+sel_year+'年'+sel_month+'月</td></tr>'
				+'<tr class="tn-c-week">'
					+'<th>日</th>'
					+'<th>一</th>'
					+'<th>二</th>'
					+'<th>三</th>'
					+'<th>四</th>'
					+'<th>五</th>'
					+'<th>六</th>'
				+'</tr>'
		+'<tr>'
	for(var i=1;i<=week;i++){
		str+='<td class="disabled">&nbsp;</td>';
	}

	for(var day=1;day<=dayCount;day++){
		var this_time=sel_year+'/'+add_0(sel_month)+'/'+add_0(day);
		var n_t=new Date(this_time);
		var t_css='show';
		if(new_time>n_t)t_css='hide';
		
		var price_d='',price_child_d='',price_d_h='';
		if(time_list_money){
			var this_time_x=sel_year+'-'+add_0(sel_month)+'-'+add_0(day);
			if(time_list_money[this_time_x]){
				price_d=time_list_money[this_time_x].price_d;
				price_child_d=time_list_money[this_time_x].price_child_d;
				price_d_h="<font>￥"+price_d+"</font>";
			}
			else{
				t_css='hide';
			}
		}
		
		var td_html='';
		if(time_fun){
			td_html=time_fun(this_time);
			if(!td_html)t_css='hide';
		}
		
		str+='<td class="'+t_css+'" data-price_d="'+price_d+'" data-price_child_d="'+price_child_d+'" data-time="'+this_time+'"><div class="sc">'+day+price_d_h+td_html+'</div></td>';

		if((day+week)%7==0){
			str+="</tr><tr>"
		}
	}
	str+='</table>';
	return str;
}
function add_0(str){
	if(str<10){
		return '0'+str;
	}
	return str;
}


/*微信分享*/
function wxfenxiang(tj){
	var getNonceStr=function(nonceStr, timestamp){
		var url = window.location.href;
		var str = "";
		$.ajax({
			type: "GET",
			url:  "/weixin/get_sign",
			data: {noncestr:nonceStr, timestamp:timestamp, url:url},
			dataType:'json',
			async:false,
			success: function(redata){
				if (redata.status == 1) {
					str = redata.message;
				}
			}
		});
		
		return str;
	}
	
	$.getScript('https://res.wx.qq.com/open/js/jweixin-1.0.0.js',function(){
        var timestamp   = Date.parse(new Date());
            timestamp   = parseInt(timestamp / 1000);    
        var nonceStr    = '123456789';
        var signature   = getNonceStr(nonceStr, timestamp);
        var title       = tj.title;
        var desc        = tj.desc;
        var link        = tj.link;
        var imgUrl      = tj.img;
        wx.config({
            debug: false,                            
            appId: 'wx043fcc64b9842352',
            timestamp: timestamp,
            nonceStr:  nonceStr,
            signature: signature,
            jsApiList: ["onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo"]
        });


        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: title,
                link: link,
                imgUrl: imgUrl,
                success: function () {},
                cancel: function () {}
            });

            wx.onMenuShareAppMessage({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl,
                type: '', 
                dataUrl: '',
                success: function () {},
                cancel: function () {}
            });
            
            wx.onMenuShareQQ({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl,
                success: function () {},
                cancel: function () {}
            });
            
            wx.onMenuShareWeibo({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl,
                success: function () {},
                cancel: function () {}
            });
        });
	});
}


function min_com(){}
/*num加减计算*/
min_com.num=function(str){
	var change=function(){
		var inp=$(this),num=parseInt(inp.val());
		!num&&(num=0)
		if(num<=parseInt(inp.attr('min'))){
			num=parseInt(inp.attr('min'));
			inp.prev('.sub').removeClass('on');
		}
		else inp.prev('.sub').addClass('on');
		
		if(num>=parseInt(inp.attr('max'))){
			num=parseInt(inp.attr('max'));
			inp.next('.add').removeClass('on');
		}
		else inp.next('.add').addClass('on');
		
		inp.val(num);
	}
	
	
	$(str).on('click','.sub',function(){
		var th=$(this);
		var inp=th.next('input'),num=parseInt(inp.val())-1;
		th.addClass('on');
		th.nextAll('.add').addClass('on');
		if(num<=parseInt(inp.attr('min'))){
			num=parseInt(inp.attr('min'));
			th.removeClass('on');
		}
		inp.val(num);
	}).on('click','.add',function(){
		var th=$(this);
		var inp=th.prev('input'),num=parseInt(inp.val())+1;
		th.addClass('on');
		th.prevAll('.sub').addClass('on');
		if(num>=parseInt(inp.attr('max'))){
			num=parseInt(inp.attr('max'));
			th.removeClass('on');
		}
		inp.val(num);
	}).on('blur','input',change).on('blur','input',function(){
		var inp=$(this),num=parseInt(inp.val());
		!num&&(num=0)
		if(num<=parseInt(inp.attr('min'))){
			num=parseInt(inp.attr('min'));
			inp.prev('.sub').removeClass('on');
		}
	}).on('keyup','input',change).find('input');
	$(str+' input').trigger('blur');
}

min_com.num.callback=function(str,fun){
	var th=$(str),inp=th.prev('.add');
	th.blur(fun).keyup(fun);
	th.prev('.sub').click(function(){
		setTimeout(function(){
			th.blur();
		},10);
	});
	th.next('.add').click(function(){
		setTimeout(function(){
			th.blur();
		},10);
	});
}
/*num加减计算end*/

/*自定义选择控件radio、checkbox都可以*/
min_com.radio=function(str){
	$('body').on('change',str+' input',function(){
		$(str+' input').each(function(index, element) {
			var th_i=$(this);
			if(th_i.prop('checked')){
				th_i.parent(str).addClass('on');
			}
			else{
				th_i.parent(str).removeClass('on');
			}
		});
	});
	min_com.radio.c=function(){
		$(str+' input').eq(1).change();
	}
	min_com.radio.c();
}

min_com.is_chinese=function(temp){
	var re=/^[\u4e00-\u9fa5]+$/;
	if (re.test(temp)) return true ;
	return false ;
}
min_com.is_user_name=function(temp){
	var re=/^[A-Za-z\u4e00-\u9fa5]+$/;
	if (re.test(temp)) return true ;
	return false ;
}

min_com.yz=function(){
	window.yz_str=".j_yz_bt,.j_yz_mobile,.j_yz_num,.j_yz_size,.j_yz_yzm,.j_yz_card,.j_yz_maxint";
	/*输入框验证*/
	$('body').on('blur',yz_str,function(){
		var th=$(this);
		var thval=th.val();
		var tsStr=undefined;
		th.attr('error','false').nextAll('.diy_error').remove();
		
		if(th.hasClass('j_yz_size')&&thval.length>th.data('max_size')){
			tsStr='最多只能输入'+(th.data('max_size'))+'位有效位数';
		}
		else if(th.hasClass('j_yz_decimal') && (thval.indexOf(".")!=-1) && thval.substring(thval.indexOf(".")+1,thval.length).length > th.data('decimal_size')){
			tsStr='只能填写'+(th.data('decimal_size'))+'位小数';
		}
		else if(th.hasClass('j_yz_bt')&&$.trim(thval)==''){//必填
			tsStr=th.data('bt');
		}
		else if(th.hasClass('j_yz_mobile')&&$.trim(thval)!=''&&!checkMobile(thval)){//手机号
			tsStr=th.data('mobile');
		}
		else if(th.hasClass('j_yz_num')&&!checkRate(thval)){//请输入数字,money
			tsStr=th.data('num');
		}
		else if(th.hasClass('j_yz_card')&&!IdentityCodeValid($.trim(thval))){//身份证号
			tsStr=th.data('card');
		}
		else if(th.hasClass('j_yz_maxint')&&thval>th.data('maxint_size')){
			tsStr=th.data('maxint');
		}

		if(tsStr!=undefined){
			var tsSpan=th.attr('error','true');
			if(th.nextAll('.ts').length!=0)tsSpan=th.nextAll('.ts');
			tsSpan.after('<span class="diy_error">'+tsStr+'</span>');
		}
	})
	/*输入框验证end*/
}

/*询问窗口*/
min_com.confirm=function(t){
	if(min_com.confirm.isOne!==false){
		$('body').append('<style>.donghua{opacity:0;transition:all 0.2s;-moz-transition:opacity 0.2s,-webkit-transform 0.2s;-webkit-transition:opacity 0.2s,transform 0.2s;}.mengban_tc{background:#000;width:100%;height:110%;position:fixed;top:0;left:0;z-index:999;filter:alpha(opacity =10);display:none;opacity:0;-webkit-transition:opacity 0.2s;transition:opacity 0.2s;}.mengban_tc.xz{opacity:0.5;}.tanchuang{position:fixed;top:50%;left:50%;width:500px;text-align:center;z-index:1000;background:#fff;margin:-100px 0 0 -250px;font-size:14px;display:none;transform:scale(0.8);-moz-transform:scale(0.8);-webkit-transform:scale(0.8);border-radius:4px;overflow:hidden;}.tanchuang.xz{transform:scale(1);-moz-transform:scale(1);-webkit-transform:scale(1);opacity:1;}.tanchuang .bt{background:#f6f6f6;line-height:40px;text-align:left;padding-left:15px;color:#333;}.tanchuangCon{padding:15px;font-size:18px;}.tanchuangBtn{border-top:#ddd solid 1px;text-align:center;display:flex;display:-webkit-flex;}.tanchuangBtn a{display:block;flex:1;-webkit-box-flex:1;width:50%;height:50px;line-height:50px;color:#666;font-size:16px;}.tanchuangBtn .btn_yes{border-left:#ddd solid 1px;color:#f77304;}</style>');
		min_com.confirm.isOne=false;
	}
	
	t.isHtml=owDef(t.isHtml,false);
	t.title=owDef(t.title,'');
	t.con=owDef(t.con,'');
	t.yes=owDef(t.yes,'确定');
	t.not=owDef(t.not,'取消');
	t.width=owDef(t.width,250);
	t.notFun=owDef(t.notFun,function(){
		$('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.tanchuang .esc').click();
	});
	
	var id=t.id;
	id=owDef(id,'tanchuang_'+new Date().getTime());
	var jid='#'+id;
	
	if($(jid).data('isOneTanchuang')==true||($(jid).length!=0&&t.isHtml==false))return tanchuang(jid);
	$(jid).data('isOneTanchuang',true)
	
	if(t.isHtml==false){
		$('body').append('<div class="mengban_tc"></div><div class="tanchuang donghua" style="widht:'+t.width+'px;margin-left:'+(-t.width/2)+'px" id="'+id+'">'
		+'<div class="esc"></div>'
		+'<div class="bt">'+t.title+'</div>'
		+'<div class="tanchuangCon">'+t.con+'</div>'
		+'<div class="tanchuangBtn"><a class="btn_not">'+t.not+'</a><a class="btn_yes">'+t.yes+'</a></div></div>');
	}
	else{
		$('body').append('<div class="mengban_tc"></div>')
	}
	
	if(t.width!=undefined){
		$(jid).css('width',t.width);
	}
	
	
	$(jid+' a.btn_yes').click(function(){ if($(this).hasClass('not'))return false;t.yesFun(id)});
	$(jid+' a.btn_not').click(t.notFun);
	tanchuang(jid);
	
	
	$('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.mengban_tc,.tanchuang .esc').unbind('click').click(function(){
		$('.tanchuang,.mengban_tc').removeClass('xz')
		setTimeout(function(){
			if(t.id==undefined||t.id==null)
				$('.tanchuang,.mengban_tc').remove();
			else
				$('.tanchuang,.mengban_tc').hide();
		},420)
	});
	return id;
}

function tanchuang(id){//弹窗
	$('.mengban_tc:eq(0),'+id).css('display','block')
	var tc=$(id);
	tc.css({'margin-top':-tc.outerHeight()/2,'margin-left':-tc.outerWidth()/2})
	setTimeout(function(){
		$('.mengban_tc:eq(0),'+id).addClass('xz')
	},50)
}

function owDef(a,b){
	if(a==undefined||a==null){
		return b;
	}
	return a;
}

min_com.mb=function(t){
	if(!min_com.mb.isone){
		$('body').append('<style>@-webkit-keyframes mengban_f{from{opacity:0;}to{opacity:1;}}@keyframes mengban_f{from{opacity:0;}to{opacity:1;}}.mengban_f{position:fixed;width:100%;height:110%;background:rgba(0,0,0,0.5);top:0;left:0;transition:opacity 0.2s;-webkit-transition:opacity 0.2s;animation:mengban_f 0.2s;-webkit-animation:mengban_f 0.2s;opacity:0;}.mengban_f.on{opacity:1;}</style>');
		min_com.mb.isone=true;
	}
	var id=owDef(t.id,'mengban_'+new Date().getTime());
	var index=owDef(t.index,'99');
	$('body').append('<div class="mengban_f on" id="'+id+'" style="z-index:'+index+'"></div>');
	document.getElementById(id).addEventListener('touchmove',function(e){
		e.preventDefault();
	});
	
	var black_f=owDef(t.fun,function(){});
	var s=$(t.str);
	
	s.click(function(){
		if(!s.hasClass('on'))$('#'+id).trigger('click');
	});
	
	$('#'+id).click(function(){
		black_f(id);
		var ith=$(this).removeClass('on');
		s.removeClass('on');
		setTimeout(function(){
			if(t.hideType==='hide')s.hide();
			else if(t.hideType==='remove')s.remove();
			ith.remove();
		},200)
	});
}
/*询问窗口*/

/*加载滚动图标*/
min_com.load=function(dom){
	if(!min_com.load.isone){
		$('body').append('<style>.min_com_load{display:inline-block;vertical-align:top;background:url(https://m.cncnimg.cn/img/icon_min_com_load.png) no-repeat center;width:20px;height:20px;background-size:100% 100%;animation:min_com_load 0.5s infinite;animation-timing-function:steps(12,end);-webkit-animation:min_com_load 0.5s infinite;-webkit-animation-timing-function:steps(12,end);}@keyframes min_com_load{0%{transform:rotate(0)}0%{transform:rotate(-360deg)}}@-webkit-keyframes min_com_load{0%{-webkit-transform:rotate(0)}0%{-webkit-transform:rotate(360deg)}}</style>');
		min_com.load.isone=true;
	}
	var d=$(dom);
	d.html('<span class="min_com_load"></span>');
}
min_com.load_remove=function(dom){
	$(dom).html('');
}
min_com.scroll_more=function(fun){
	$(window).scroll(function(){
		if(min_com.scroll_more.is===false)return false;
		var w_h = $(window).scrollTop();
		var allHei=$('body').height()-$(window).height();
		
		if(w_h>=allHei){
			fun();
		}
	});
}

/*加载滚动图标end*/

min_com.select=function(dom,t){
	if(!t)t={};
	if(min_com.select.style!==true){
		$('body').append('<style>.min_com_select{margin:-15px;text-align:left}.min_com_select li{border-top:#ddd solid 1px;line-height:36px;height:36px;padding:0 15px;font-size:14px;color:#666;}.min_com_select li:active{background:#F1F1F1;}.min_com_select li:first-child{border-top:0;}.min_com_select li.on{color:#00bf49;position:relative;}.min_com_select li.on:before,.min_com_select li.on:after{content:" ";position:absolute;background:#00bf49;width:2px;height:8px;border-radius:1px;right:20px;top:9px;transform:rotate(-45deg);-webkit-transform:rotate(-45deg);}.min_com_select li.on:before{top:15px;right:27px;}.min_com_select li.on:after{transform:rotate(45deg);-webkit-transform:rotate(45deg);height:15px;}</style>');
		min_com.select.style=true;
	}
	$(dom).each(function(index, element) {
		var th=$(this),sel=th.find('select');
		th.append('<span>'+sel.find('option:selected').text()+'</span><i class="icon_up"></i>');
	}).click(function(){
		var th=$(this),sel=th.find('select'),s_html='';
		sel.find('option').removeClass('on');
		sel.find('option:selected').addClass('on');
		s_html=sel.html();
		s_html=s_html.replace(/\<option/g,'<li').replace(/\/option\>/g,'/li>');
		var id=min_com.confirm({
			con:'<ul class="min_com_select">'+s_html+'</ul>',
			width:260,
			yes:t.yes,
			not:t.not,
			yesFun:t.yesFun?t.yesFun:function(id){
				var xz=$('#'+id+' li.on');
				sel.val(xz.attr('value'));
				th.find('span').html(sel.find('option:selected').text())
				$('.mengban_tc').trigger('click');
			}
		});
		$('#'+id+' .min_com_select li').click(function(){
			var th_x=$(this);
			th_x.siblings('.on').removeClass('on');
			th_x.addClass('on');
		});
	});
}


/*搜索历史记录*/
min_com.add_search=function(key_name,key_str,art_url){
	key_str=$.trim(key_str);
	if(key_str==''){
		return false;
	}
	
	var self = $(this);
	var art_title = key_str;
	var history;
	var json = "[";
	//json1是第一次注入cookie以后的第一个json，"此时还不是数组" 以点带面的处理
	var json1;
	var canAdd = true;
	//var json1=eval("({sitename:'dreamdu',sitedate:new Date(1980, 12, 17, 12, 0, 0)})");
	if (!localStorage[key_name]) {
		//第一次的时候需要初始化
		localStorage[key_name] =JSON.stringify([{title:art_title,url:art_url}]);
	} else {
		//已经存在
		var qz_j=JSON.parse(localStorage[key_name]);
		$(qz_j).each(function() {
			if (this.title == art_title) {
				if(this.url!=art_url){
					this.url=art_url;
					localStorage[key_name]=JSON.stringify(qz_j);
				}
				canAdd = false;
				return false;
			}
		})
		if(canAdd){
			qz_j[qz_j.length]={title:art_title,url:art_url};
			localStorage[key_name]=JSON.stringify(qz_j);
		}
	}
	return true;
}

min_com.add_search.del=function(key_name,key){
	localStorage[key_name]='';
}
min_com.add_search.del_one=function(key_name,i){
	var qz_j=JSON.parse(localStorage[key_name]);
	var dj=parseInt(i);
	qz_j.splice(dj,1);
	localStorage[key_name]=JSON.stringify(qz_j);
}
/*搜索历史记录end*/


/*图片比例固定居中显示，绝对不变形（恶心的图片变形，握草），传外框的宽跟高，还有图片要延时加载*/
min_com.img_center=function(dom,width,height){
	var gl=height/width;
	$(dom).load(function(){
		var th=$(this),
		bl=th.height()/th.width(),
		h=0,
		w=0;
		
		if(bl<gl){
			h=height;
			w=h/bl;
			th.css({'margin':'0 '+(width-w)/2+'px'});
		}
		else{
			w=width;
			h=width*bl;
			th.css({'margin':(height-h)/2+'px 0'});
		}
		th.css({'opacity':1,width:w,height:h});
	});
	return true;
}
/*图片比例固定end*/