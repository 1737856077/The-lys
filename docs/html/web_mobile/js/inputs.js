function PublicBannerFocusHide(){
	$('input').focus(function() {
		//alert(11);
       $('#footmune').removeClass('foot_wrap');
       $(".nav").removeClass('nav_fixed');
	   document.getElementById("position_fixed").style.height="20px";

      }).blur(function() { //输入框失焦后还原初始状态
        $('#footmune').addClass('foot_wrap');
        $(".nav").addClass('nav_fixed');
		document.getElementById("position_fixed").style.height="80px";
      });

      $('textarea').focus(function() {
		document.getElementById("position_fixed").style.height="20px";
        $('#footmune').removeClass('foot_wrap');
        $(".nav").removeClass('nav_fixed');

      }).blur(function() { //输入框失焦后还原初始状态
        $('#footmune').addClass('foot_wrap');
        $(".nav").addClass('nav_fixed');
		document.getElementById("position_fixed").style.height="80px";
      });

}

      