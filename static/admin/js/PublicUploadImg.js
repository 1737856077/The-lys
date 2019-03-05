/**
 * @[练遇_后台管理系统] Shanghai Lianyu Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:PublicUploadImg.css 2018-01-27 17:53:00 $
 */

	/**
     * @描述：图片上传预览    IE是用了滤镜
     * @param   ojbect      $file          --图片文件域名称
     *                                          --索引0：图片的存放完整路径，相对与网站的根目录；
     *                                          --索引1：图片上传后的名字，不含日期文件夹名称；
     *                                          --索引2：
     * @param   string      $divid        --DIV的ID
     * @param   string      $imgid        --图片的ID
     * @param   string      $newdivid        --新DIV的ID	 	 
     */
        function previewImage(file,divid,imgid,newdivid)
        {
            var MAXWIDTH  = 260;
            var MAXHEIGHT = 180;
            var div = document.getElementById(divid);
            if (file.files && file.files[0])
            {
                div.innerHTML ='<img id='+imgid+'>';
                var img = document.getElementById(imgid);
                img.onload = function(){
                    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                    img.width  =  rect.width;
                    img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                    //img.style.marginTop = rect.top+'px';
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
                div.innerHTML = '<img id='+imgid+'>';
                var img = document.getElementById(imgid);
                img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
               //div.innerHTML = "<div id="+newdivid+" style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
				div.innerHTML = "<div id="+newdivid+" style='width:"+rect.width+"px;height:"+rect.height+"px;"+sFilter+src+"\"'></div>";
            }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight )
            {
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;

                if( rateWidth > rateHeight )
                {
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else
                {
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }

            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }