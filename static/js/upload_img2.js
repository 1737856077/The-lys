/*上传图片*/
//图片上传预览    IE是用了滤镜。
function previewImage(file)
{
		 var MAXWIDTH  = 1.8666 +'rem';
		 var MAXHEIGHT = 1.8666 +'rem';
  var div = document.getElementById('preview');
  if (file.files && file.files[0])
  {
	  div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
	  var img = document.getElementById('imghead');
	  img.onload = function(){
		var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
		img.width  =  rect.width;
		img.height =  rect.height;
	  }
	  var reader = new FileReader();
	  reader.onload = function(evt){img.src = evt.target.result;}
	  reader.readAsDataURL(file.files[0]);
  }
  else //兼容IE
  {
	var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
	file.select();
	var src = document.selection.createRange().text;
	div.innerHTML = '<img id=imghead>';
	var img = document.getElementById('imghead');
	img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
	var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
	status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
	div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
  }
}
function clacImgZoomParam( maxWidth, maxHeight, width, height ){
	var param = {top:0, left:0, width:width, height:height};
	if( width>maxWidth || height>maxHeight ){
		rateWidth = width / maxWidth;
		rateHeight = height / maxHeight;
		
		if( rateWidth > rateHeight ){
			param.width =  maxWidth;
			param.height = Math.round(height / rateWidth);
		}else{
			param.width = Math.round(width / rateHeight);
			param.height = maxHeight;
		}
	}
	param.left = Math.round((maxWidth - param.width) / 2);
	param.top = Math.round((maxHeight - param.height) / 2);
	return param;
}


function previewImage2(file)
{
		 var MAXWIDTH  = 1.8666 +'rem';
		 var MAXHEIGHT = 1.8666 +'rem';
  var div = document.getElementById('preview2');
  if (file.files && file.files[0])
  {
	  div.innerHTML ='<img id=imghead2 onclick=$("#previewImg2").click()>';
	  var img = document.getElementById('imghead2');
	  img.onload = function(){
		var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
		img.width  =  rect.width;
		img.height =  rect.height;
	  }
	  var reader = new FileReader();
	  reader.onload = function(evt){img.src = evt.target.result;}
	  reader.readAsDataURL(file.files[0]);
  }
  else //兼容IE
  {
	var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
	file.select();
	var src = document.selection.createRange().text;
	div.innerHTML = '<img id=imghead2>';
	var img = document.getElementById('imghead2');
	img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
	var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
	status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
	div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
  }
}



function previewImage3(file)
{
		 var MAXWIDTH  = 2.6666+'rem';
		 var MAXHEIGHT = 1.68+'rem';
  var div = document.getElementById('preview3');
  if (file.files && file.files[0])
  {
	  div.innerHTML ='<img id=imghead3 onclick=$("#previewImg3").click()>';
	  var img = document.getElementById('imghead3');
	  img.onload = function(){
		var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
		img.width  =  rect.width;
		img.height =  rect.height;
	  }
	  var reader = new FileReader();
	  reader.onload = function(evt){img.src = evt.target.result;}
	  reader.readAsDataURL(file.files[0]);
  }
  else //兼容IE
  {
	var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
	file.select();
	var src = document.selection.createRange().text;
	div.innerHTML = '<img id=imghead3>';
	var img = document.getElementById('imghead3');
	img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
	var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
	status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
	div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
  }
}


function previewImage4(file)
{
		 var MAXWIDTH  = 2.6666+'rem';
		 var MAXHEIGHT = 1.68+'rem';
  var div = document.getElementById('preview4');
  if (file.files && file.files[0])
  {
	  div.innerHTML ='<img id=imghead4 onclick=$("#previewImg4").click()>';
	  var img = document.getElementById('imghead4');
	  img.onload = function(){
		var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
		img.width  =  rect.width;
		img.height =  rect.height;
	  }
	  var reader = new FileReader();
	  reader.onload = function(evt){img.src = evt.target.result;}
	  reader.readAsDataURL(file.files[0]);
  }
  else //兼容IE
  {
	var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
	file.select();
	var src = document.selection.createRange().text;
	div.innerHTML = '<img id=imghead4>';
	var img = document.getElementById('imghead4');
	img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
	var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
	status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
	div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
  }
}
