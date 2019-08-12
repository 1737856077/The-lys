 // var baseURL = 'http://quhuan.9xckxls.com';
 var baseURL = 'http://www.youqianhuan.com';
// var baseURL = 'http://192.168.0.188:885';
var num = 0;
window.addEventListener('load', function() {
	$.ajax({type:'post', url: baseURL + '?m=index&c=config_info',  success: function(data) {
		data = JSON.parse(data);
		$(".title").html(data.data.w_name);
		$("title").html(data.data.w_name);
	}})
})
document.addEventListener('plusready', function() {
var webview = plus.webview.currentWebview();
plus.key.addEventListener('backbutton', function() {
webview.canBack(function(e) {
	if(e.canBack) {
		if(/login\.html/.test(window.location.href)) {
			console.log('login!');
			if( num == 0) {
				num++;
				layer.open({
					skin: 'msg',
					content: '再按一次返回键退出',
					time: 1
				})
			} else {
				webview.close();
			}
		}else {
			num = 0;
			webview.back()
		}
} else {
	if(num == 0) {
		num++;
		layer.open({
			skin: 'msg',
			content: '再按一次返回键退出',
			time: 1
		})
	} else {
		webview.close();
	}
}
})
});
});
function isLogin () {
	window.onload = function() {
		if(!localStorage.getItem('h_uid')){
			layer.open({
				skin: 'msg',
				content: '请先登录',
				time: 1
			})
			setTimeout(()=>{
				window.location.href='login.html'
			}, 1000)
		}
	}
}
function loading() {
  layer.open({
    type: 2,
    content: '正在获取信息中'
  })
}
