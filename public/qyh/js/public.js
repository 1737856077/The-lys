//判断页面主体高度
$(document).ready(function(){
    //获取主体高度
	//window.screen.availHeight获取屏幕工作区域的高度和宽度（去掉状态栏）
	//document.body.clientHeight网页可见区域的高度和宽度（不加边线）
	//document.body.offsetHeight网页可见区域的高度和宽度（加边线）
	//document.body.scrollHeight网页全文的高度和宽度
	//console.log($('div.jui_footer').length);
	//console.log($('div.jui_top_bar').length);
	if($('.jui_footer').length>0){
	   if($('.jui_top_bar').length>0){
	      /*头部底部都存在*/
		  var zt_height=document.body.clientHeight-$(".jui_footer").outerHeight()-$(".jui_top_bar").outerHeight();
	   }else{
		   /*底部存在，头部不存在*/
		   var zt_height=document.body.clientHeight-$(".jui_footer").outerHeight();
		   }
	}else{
	  if($('div.jui_top_bar').length>0){
	      /*头部存在底部不存在*/
		  var zt_height=document.body.clientHeight-$(".jui_top_bar").outerHeight();
	   }else{
		   /*头部底部都不存在*/
		   var zt_height=document.body.clientHeight;
		   }	  
	}
	$(".jui_main").css("min-height",zt_height);
	$(".jui_main").css("height",zt_height);
	
		
});




/*提示类弹出框 1.5S后自动消失*/
function box_timer(text) {
	var oDiv = document.createElement('div');
	oDiv.className = 'jui_box_point_bg';
	oDiv.innerHTML += "<div class='jui_box_point_bar'>"+text+"</div>";
	document.body.appendChild(oDiv);
	setTimeout(function(){
		oDiv.remove();
		},1500)
	}
	

