$(function(){
	function resizeCard(){
		var winHeight = $(window).outerHeight();
		$('.card-item').height(winHeight-63);
		$('.card-item.padding_10').height(winHeight-83);
		$('.cards').height(winHeight-46);
	}
	function switchNav(){
		$('.mainContent').on('click','.nav-item:not(.current)',function(){
			var dom = $(this),index = dom.index('.nav-item'),parentDom = dom.parent('.nav'),detailDom = parentDom.siblings('.nav-detail');
			parentDom.find('.nav-item').removeClass('current');
			dom.addClass('current');
			switch(index){
				case 0:
					detailDom.find('.nav-detail-txt').html('延津县农产品质量安全监管局');
					detailDom.find('.nav-detail-link').attr('href','javascript:void(0);');
					break;
				case 1:
					detailDom.find('.nav-detail-txt').html('ISO9001认证');
					detailDom.find('.nav-detail-link').attr('href','javascript:void(0);');
					break;
				case 2:
					detailDom.find('.nav-detail-txt').html('淘得技术监督服务有限公司');
					detailDom.find('.nav-detail-link').attr('href','javascript:void(0);');
					break;
				default:break;
			}
			
		});
	}
	function switchRiLi(){
		$('.calendar-head').on('click','.calendar-head-itme:not(.current)',function(){
			var dom = $(this),currented = dom.attr('name'),parentDom = dom.parent('.calendar-head');
			parentDom.find('.calendar-head-itme').removeClass('current');
			dom.addClass('current');
			switch(currented){
				case 'rili':
					$('.shijianxian').hide();
					$('.rili').show();
					break;
				case 'shijianxian':
					$('.rili').hide();
					$('.shijianxian').show();
					break;
				default:break;
			}
			
		});
	}
	function initSwiper(){
		
	    $('.swiper-container-h').each(function(){
		    (function(dom){
		    	new Swiper(dom, {
			        pagination: $(dom).find('.swiper-pagination-h'),
			        paginationClickable: true,
			        preventClicks:false
			    })
		    })(this);
	    });
	    // $('.swiper-container-s').each(function(){
		   //  (function(dom){
		   //  	new Swiper(dom, {
			  //       scrollbar: $(dom).find('.swiper-scrollbar'),
			  //       direction: 'vertical',
			  //       slidesPerView: 'auto',
			  //       mousewheelControl: true,
			  //       freeMode: true
			  //   })
		   //  })(this);
	    // });
	    // var swiperV = new Swiper('.swiper-container-v', {
	    //     pagination: '.swiper-pagination-v',
	    //     paginationClickable: true,
	    //     direction: 'vertical',
	    //     preventClicks:false
	    // });
	    var swiperGroupLoop = new Swiper('.swiper-container-g', {
	        paginationClickable: true,
	        width : 280,
	        slidesPerView: 3,
	        loop : true,
	        //nextButton: '.swiper-button-next',
        	//prevButton: '.swiper-button-prev',
        	spaceBetween: 8
	    });
	}
	//图片放大
	function magnify(){
		$('.magnifyImg').on('click',function(){
			var src = $(this).attr('src');
			var index = src.lastIndexOf('.jpg');
			if(index>=0){
				var resultSrc = src.slice(0,index)+'-big.jpg';
				$('<div class="dialog"><img class="dialogImg" src="'+resultSrc+'"></div><div class="delDialog"></div>').appendTo('body');
				$('#mainContent').hide();
			}
		});
		$('body').on('click','.delDialog',function(){
			$('#mainContent').show();
			$('.dialog,.delDialog').remove();
		});
	}
	function toScore(){
		
		$('#btnToScore:not(".hasScored")').on('click',function(){
			$('#scoreDetail').show();
		});
		$('#scoreDetail').on('click','li',function(){
			var dom = $(this);//,num = +dom.attr('name');
			if(dom.hasClass('selected')){
				//$(this).removeClass('selected');
				$(this).nextAll('li').removeClass('selected');
			}else{
				$(this).addClass('selected');
				$(this).prevAll('li').addClass('selected');
			}
		});
		$('#scoreDetail').on('click','.score-sure .baseBtn',function(){
			$('#scoreDetail').remove();
			$('#btnToScore').removeClass('hasScored').html('感谢评价');
		});
	}
	function getSearch(){
	    var url=location.search,searchResult={},str='',strs=[],i=0;
	    if(url.indexOf('?')>=0){
	        str=url.substr(1);
	        strs=str.split('&');
	        for(;i<strs.length;i++){
	            searchResult[strs[i].split('=')[0]]=unescape(strs[i].split('=')[1]);
	        }
	    }
	    return searchResult;
	}
	function setMarketTime(){
		var dateObj = new Date();
		var tempDateTime = dateObj.getTime();
		dateObj.setTime(tempDateTime-12*24*3600*1000)
		

		$('#marketMon').html(dateObj.getMonth()+1);
		$('#marketDate').html(dateObj.getDate());
	}
	function bindEvents(){
		switchNav();
		initSwiper();
		switchRiLi();
		toScore()
		//magnify();
	}
	function init(){
		bindEvents();
		setMarketTime()
	}
	//resizeCard();
	init();
	var searchCodes=getSearch();
    $('#syCode').html(searchCodes['code']);
	
});