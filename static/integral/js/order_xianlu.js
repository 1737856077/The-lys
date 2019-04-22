
$(function(){
	$('body').append('<div class="menabanBai j_mengban_bai"></div><div class="menaban_o j_mengban_o"></div><div class="j_con_yh content"></div>');
		
	/*优惠券*/
	$('.j_youhui').click(function() {
	    var th = $(this),con=$('.j_con_yh');
		var back_go=function(){
			back_fun(function(){
				$('.j_main').show();
				$('.j_con_yh').html('');
				mb_fun();
			});
		};
		
		/*if(con.length){
			back_go();
			$('.m-main').hide();
			con.show();
			return true;
		}*/
		
		alert('正在加载...');
	    $.get(th.data('href'),{'hidden_header':1,'coupon_id':$('[name="coupon_id"]').val()},function(s){
			back_go();
			$('.alert').remove();
			$('.j_main').hide();
			$('.j_con_yh').html(s);
			$(document).scrollTop(0);
	    });
		
	});
	
	
	window.mb_fun_dom=$('.j_mengban_o').click(function(){
		$('#j_baoxian,.j_mengban_o,#alert1,.js_toufang_box').hide();
	});
	window.mb_fun=function(){
		mb_fun_dom.trigger('click');
	}
	
	$('.j_con_yh').on('click','.coucon_li',function(){
		var th=$(this);
		var tit=th.find('.c_li_tit').text();
		var man=th.data('man');
		var money=th.data('money');
		var id=th.data('id');
		
		
		$('.menaban_o').show();
		
		$('#alert1 .alert_bt').unbind('click').click(function(){
			var th1=$(this);
			var url=th1.attr('href');
			th1.attr('href','javascript:;');
			id=get_url_name('coupon_id',url);
			
			if(id)
			
			$('.j_youhui_name').html(tit);
			$('[name="coupon_id"]').val(id);
			$('.j_di').html(money);
			if(man)$('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.j_youhui .sm').html('满￥<span class="coupon_price">'+man+'</span>可用');
			else $('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.j_youhui .sm').html('下单即可使用');
			
			$('.menaban_o,#alert1').hide();
			
			var error_type=order_all_money();
			if(error_type!=false)alert(error_type);
			history.go(-1);
		})
	});
	
	$('.J_baoxian').on('click','dl',function() {
		back_fun(function(){
			kehu_list();
			$('.j_main,.headTop').show();
			$('#j_baoxian').hide();
		});
		$('.j_main,.headTop:eq(0)').hide();
		$('#j_baoxian').show();
	});
	

	$('dl').on('click','.checkbox',function(){
		var self = $(this),
			parents = self.parents('dl');
		if(self.hasClass('J_baoxian_one')){
			parents.siblings('dl').find('i').removeClass('on');
			parents.siblings('dl').find('.J_baoxian_one input').attr('checked',false);
		}
	});

	$('dl').on('click','.J_default',function() {
		var self = $(this);
		var t = self.parents('dl').find('.j_baoxian_name').text();
		if(!self.is(':checked')){
			min_com.confirm({title:'',width:'90%',con:t+'可为您的出行提供全面的风险保障，建议您为每位游客购买保险。'});
			if(cart_type_num == 0){
				$('.j_youke_main').addClass('hide');
			}
		}else{
			$('.j_youke_main').removeClass('hide');
		}
		$('.btn_yes').hide();
		$('.btn_not').text('确认');
		// guoqing_yh();
	});

	window.baoxian_check_one=true;
	$('.j_baoxian_check').change(function(){
		var th=$(this);
		var p=th.data('price');
		var d=th.data('daynum');
		var str=$('#j_baoxian_con').html();
		$('.j_baoxian_tit').html(th.data('title'));

		if(!window.baoxian_check_one){
			if(p=='-1'){
				$('.j_baoxian_check').not(this).prop('checked',false);
			}
			else{
				$('.j_baoxian_not').prop('checked',false);
			}
		}
		if($('.j_baoxian_check:not(.j_baoxian_not):checked').length==0){
			$('.j_baoxian_not').prop('checked',true);
		}
		window.baoxian_check_one=false;
		
		var box_yes=$('.j_baoxian_check:checked');
		
		var s='';
		box_yes.each(function(index, element) {
			var self=$(this);
			var p=self.data('price');
			var d=self.data('daynum');

			var title=self.data('title');
			
			console.log(title);
			var id=self.data('id');
			var name1=self.data('name1');
			var name2=self.data('name2');
			var price_c='';
			if(p=='-1'){
				price_c='';
			}
			else if(p=='0'){
				price_c='赠送';
			}
			else{
				if(self.parents('i').hasClass('J_baoxian_one')){
					if(d == ''){
						price_c='<em>￥<b class="j_baoxian_price" data-p="'+p+'">'+p+'</b></em>x'+ '<span class="j_baoxian_num"></span>';
					}else{
						price_c='<em>￥<b class="j_baoxian_price" data-p="'+p*d+'">'+p+'</b></em>x'+ '<span class="j_baoxian_num"></span>' +'x<span class="j_baoxian_day">'+d+'</span>';
					}
					
				}else{
					price_c='<em>￥<b class="j_baoxian_price" data-p="'+p+'">'+p+'</b></em>x'+ '<span class="j_baoxian_num"></span>';
				}
			}
			
			if(!id){
				p=id='remove_input';
				$('body').data('baoxian',0);
			}
			else  $('body').data('baoxian',1);
			s+=str.replace(/\*title\*/g,title).replace(/\*id\*/g,id).replace(/\*name1\*/g,name1).replace(/\*name2\*/g,name2).replace(/\*price\*/g,p).replace(/\*price_c\*/g,price_c);
		});
		$('.J_baoxian').html(s);
		$('[value=remove_input]').remove();
		
		baoxian_num();
		order_all_money();
	});
	
	$('#j_kehu_list').on('click','.j_kehu_open',function(){
		window.scroll_top=$(document).scrollTop();
		var main=$('.j_main,.headTop:eq(0)');
		var win=$('.j_kehu_window');
		var th=$(this);
		back_fun(function(){
			main.show();
			win.hide();
			mb_fun();
			$(document).scrollTop(window.scroll_top);
		});
		main.hide();
		win.show();
		
		if($('.J_baoxian_one input').is(':checked')){
			$('.id_code').css('display','-webkit-box');
		}else{
			$('.id_code').css('display','none');
		}

		if(th.data('full'))win.find('.headTop span').html('修改游客信息');
		else win.find('.headTop span').html('添加游客信息');
		
		$('.js_toufang_box ul').html(th.find('.certificate_type').html());
		$('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.js_toufang_box li.on').trigger('click');//设置证件类型列表
		$('[j_name="insurance_username"]').val(th.find('[name="insurance_username[]"]').val());//设置姓名
		$('[j_name="insurance_idcard_no"]').val(th.find('[name="insurance_idcard_no[]"]').val());//输入您的证件号码
		$('[j_name="idcard_no"]').val(th.find('[name="idcard_no[]"]').val());//身份证号码
		$('[j_name="phone_number"]').val(th.find('[name="phone_number[]"]').val());//手机号
		$('[j_name="certificate_type"]').val(th.find('[name="certificate_type[]"]').val());//证据类型数据
		
		$('.j_txt_btn_bc').unbind('click').click(function(){
			if(!th.hasClass('first_fill'))th=$('.j_kehu_open:not(.first_fill)').eq(0);
			
			th.find('.certificate_type').html($('.js_toufang_box ul').html());//设置证件类型列表
			var insurance_username=$.trim($('[j_name="insurance_username"]').val());
			var insurance_idcard_no=$.trim($('[j_name="insurance_idcard_no"]').val());
			var idcard_no=$.trim($('[j_name="idcard_no"]').val());
			var phone_number=$.trim($('[j_name="phone_number"]').val());
			var certificate_type=$.trim($('[j_name="certificate_type"]').val());
			var certificate_type_span=$('[j_name="certificate_type"]').next('span').text();

			if(insurance_username=='')return alert('中文姓名不能为空');
			if(!min_com.is_user_name(insurance_username))return alert('姓名必须是中文或英文，请重新填写');
			if(insurance_username.length<2)return alert('中文姓名太短，请重新填写');
			
			if(cart_type_num > 0){
				if(insurance_idcard_no=='')return alert('证件号码不能为空');
				if(certificate_type_span=='身份证'&&!IdentityCodeValid(insurance_idcard_no))return alert('证件号码错误，请重新填写');
			}

			if($('.J_baoxian_one').hasClass('on')){
				if(idcard_no=='')return alert('身份证号码不能为空!');
				if(!IdentityCodeValid(idcard_no))return alert('身份证号码错误，请重新填写');
			}

			if(phone_number!=''&&!checkMobile(phone_number))return alert('手机号码错误，请重新填写');
			
			th.find('[name="insurance_username[]"]').val(insurance_username);//设置姓名
			th.find('[name="insurance_idcard_no[]"]').val(insurance_idcard_no);//输入您的证件号码
			th.find('[name="idcard_no[]"]').val(idcard_no);//身份证号码
			th.find('[name="phone_number[]"]').val(phone_number);//手机号
			th.find('[name="certificate_type[]"]').val(certificate_type);//证据类型数据
			th.data('full',1)
			th.find('.corBlue span').text(insurance_username);
			
			th.addClass('first_fill');
			
			alert('保存成功');
			history.go(-1);
		});
	});
	
	$('.j_lq_zheng').click(function(){
		$('.js_toufang_box,.j_mengban_o').show();
	});
	$('.js_toufang_box').on('click','li',function(){
		var th=$(this);
		th.siblings().removeClass('on');th.addClass('on');
		$('.j_lq_zheng .s').text(th.text());
		$('.j_lq_zheng input').val(th.attr('value'));
		mb_fun();
	});
	$('.com_popup_head .close').click(function(){mb_fun();});
	
	
	$('.j_down_more').click(function(){
		var p=$(this).parent('.more_con');
		if(p.hasClass('on'))p.removeClass('on');
		else p.addClass('on');
	});
	min_com.num('.j_num');
	min_com.radio('.checkbox');
	baoxian_num();
	
	
	/*页面金额动态统计，积分统计等*/
	min_com.num.callback('#j_user_point',function(){
		var th=$(this),ds=parseInt(th.val());
		alert('使用'+100*ds+'积分');
		
		kehu_list();
		var error_type=order_all_money()
		if(error_type!==false){
			alert(error_type);
		}
	});
	min_com.num.callback('#j_price_d_num,#j_price_child_d_num',function(){
		kehu_list();
		order_all_money();
		// guoqing_yh();
	});
	
	kehu_list()//初始化游客信息
	order_all_money();//初始化总金额
	
});

function get_url_name(name,url) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r; 
	if(url)r=url.match(reg);
	else r = window.location.search.substr(1).match(reg); 
	
	if (r != null) return unescape(r[2]); return null; 
} 

/*保险人数==总人数*/
function baoxian_num(){
	var man_m=parseInt($('#j_price_d_num').val());//成人数量
	var child_m=parseInt($('#j_price_child_d_num').val());//儿童数量
	
	!man_m&&(man_m=0);
	!child_m&&(child_m=0);
	
	var m=man_m+child_m;
	var d=$('.J_baoxian_one input').attr('daynum');
	$('.j_baoxian_day').html(d);//保险天数
	$('.j_baoxian_num').html(m);//保险人数
	return m;
}

/*客户信息列表展示*/
function kehu_list(){
	var str=$('#j_kehu_c').html();
	if(!str)return false;
	
	var li=$('#j_kehu_list');
	var m=baoxian_num();
	var box_l=li.find('dl').length;
	var youke_main=$('.j_youke_main');
	
    if($('.j_baoxian_check:not(.j_baoxian_not):checked').length==0 && cart_type_num == 0){
		li.html('');
		youke_main.hide();
    }else{
        youke_main.show();
        /*if($('body').data('baoxian')==0){
            li.html('');
            youke_main.hide();
        }
        else */
        if(box_l<m){
            var s='';
            for(var i=0;i<(m-box_l);i++){
                s+=str.replace('*i*',' '+[box_l+i+1]);
            }
            li.append(s);
        }
        else if(box_l>m){
            li.find('dl:gt('+(m-1)+')').remove();
        }
    }
}

/*总金额统计*/
function order_all_money(){
	var man_m=parseInt($('#j_price_d_num').val());//成人数量
	var child_m=parseInt($('#j_price_child_d_num').val());//儿童数量
	
	!man_m&&(man_m=0);
	!child_m&&(child_m=0);
	
	var chengren=$('#price_d').text()*man_m;//成人总价
	var child=$('#price_child_d').text()*child_m;//儿童总价
	var baoxian_day=$('#baoxian_day').val();//保险天数
	
	var jf=parseInt($('#j_user_point').val());if(!jf)jf=0;//积分抵用金额
    var coupon_id = $('input[name=coupon_id]').val();
    if (coupon_id) {
	    var yh=parseInt($('.j_di').html());//优惠券抵用金额
    }else{
        var yh = 0;
    }
	// console.log($('.j_di').html(),yh);
	
	var bx=0;//保险单价
	$('.j_baoxian_price').each(function(index, element) {
		bx+=Number($(this).attr('data-p'));
	});
	if(!bx)bx=0;
	var bx_all=bx*(man_m+child_m);//保险总金额
	
	if(yh){
		var man=parseInt($('.coupon_price').text());//优惠券满多少
		if((chengren+child)<man)yh=0;
	}
	else yh=0;
	
	var error_type=false;
	
	var all_money1=Number(chengren)*100+Number(child)*100+Number(bx_all)*100;
	all_money = all_money1/100;
	if(all_money>=jf)all_money-=jf;
	else error_type='积分金额大于等于总金额，无法使用';
	
	if(all_money>=yh){
		all_money= (Number(all_money)*100 - Number(yh)*100)/100;
	}else if(error_type===false){
		error_type='抵用券金额大于等于总金额，无法使用';
	}
	$('.j_all_money').html(all_money);
	guoqing_yh();
	return error_type;
}



$('.m-main').on('click','.js_toufang_box li',function(){
	$('.j_lq_zheng dd span').text($(this).text());
});

$(function(){
	$('.J_baoxian_info').text('选择保险');
	$('http://www.17sucai.com/preview/29861/2018-09-07/form/js/.headTop a.btn').click(function(){
		if($('.j_baoxian_not').parent('i').hasClass('on')){
			$('.J_baoxian_info').text('我不需要保险');
		}
	});
})