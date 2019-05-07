<?php
/**
 * @描述：上传图片方法
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:UploadFile.php 2015-06-12 14:15:00 $
 */
function upface($mulu,$userfile){
	//var $now=date('Ymdhis');
	/**
	 * @描述：上传图片类
	 * @param	string $mulu  	 	上传图片的目录
	 * @param	string $userfile   	文件域名字
	 * @return	string  1:上传时出现错误！原因：文件超过了上传的最大值！
	 				    2:上传时出现错误！原因：档案超过了文件的最大长度值！
						3:上传时出现错误！原因：文件只有部分上传。
						4:上传时出现错误！原因：没有上载的文件。
						5:最大只能上传1M图片！
						6:可疑的文件上传。文件名：
						7:图片格式错误！
						$string:上传成功后的文件名
						
	 * @author	刘庆艳  2010-12-21
	 */
	if($_FILES["$userfile"]['error']>0)
		{
			switch($_FILES["$userfile"]['error'])
			{
				case 1: return 1; break;
				case 2: return 2; break;
				case 3: return 3; break;
				case 4: return 4; break;
			}
			exit;
		}
		//允许上传文件的类型
		//$pt=split('/',$_FILES["$imgzhenda"]['type']);
		//if($_FILES["$userfile"]['size']>1024000){
			//return 5;
			//exit;
		//}
		//echo $_FILES["$userfile"]['type'];exit;
		if($_FILES["$userfile"]['type']=='image/jpeg' or $_FILES["$userfile"]['type']=='image/pjpeg' or $_FILES["$userfile"]['type']=='image/gif' or $_FILES["$userfile"]['type']=='image/x-png' or $_FILES["$userfile"]['type']=='image/png' or $_FILES["$userfile"]['type']=='image/bmp')
		//if($pt[0]!='image')
		{
			//生成随机文件名
			$mytime=date("YmdHis");
			//mt_srand((double)microtime()*1000000);
			for($i=1;$i<3;$i++){
				$randval=$randval.chr(rand(48,57));//ACSII码，0-9是48-57
				$i=$i+1;
			}
			
			//取得文件类型
			switch ($_FILES["$userfile"]['type'])  {     
				   case  "image/pjpeg":     
					 $mytype=".jpg";    
				  	 break;   
				   case  "image/jpeg":     
					 $mytype=".jpg";    
				  	 break;   
				   case "image/gif":     
					   $mytype    =    ".gif";     
					   break;     
				   case "image/x-png":     
					   $mytype    =    ".png";     
					   break; 
				   case "image/png":     
					   $mytype    =    ".png";     
					   break;	   
				   case "image/bmp":     
					   $mytype    =    ".bmp";     
					   break;
				   }
			
			
			//我们想把文件放在的地方
			//$upfile='../upfile/'.$_FILES['userfile']['name'];
			$upfile=$mulu.$mytime.$randval.$mytype;
			
			//if(is_uploaded_file($_FILES["$userfile"]['tmp_name'])){
				if(copy($_FILES["$userfile"]['tmp_name'],$upfile))
				{
					//echo '文件上传成功！';返回文件名
					return $mytime.$randval.$mytype;
				}
				else
				{
					return 6;
					exit;
				}
			//}
		}else{
			return 7;
			exit;
		}
}

function upmusic($mulu,$userfile){
	//var $now=date('Ymdhis');
	/**
	 * @描述：上传图片类
	 * @param	string $mulu  	 	上传图片的目录
	 * @param	string $userfile   	文件域名字
	 * @return	string  1:上传时出现错误！原因：文件超过了上传的最大值！
	 				    2:上传时出现错误！原因：档案超过了文件的最大长度值！
						3:上传时出现错误！原因：文件只有部分上传。
						4:上传时出现错误！原因：没有上载的文件。
						5:最大只能上传1M图片！
						6:可疑的文件上传。文件名：
						7:图片格式错误！
						$string:上传成功后的文件名
						
	 * @author	刘庆艳  2010-12-21
	 */
	if($_FILES["$userfile"]['error']>0)
		{
			switch($_FILES["$userfile"]['error'])
			{
				case 1: return 1; break;
				case 2: return 2; break;
				case 3: return 3; break;
				case 4: return 4; break;
			}
			exit;
		}
		//允许上传文件的类型
		//$pt=split('/',$_FILES["$imgzhenda"]['type']);
		//if($_FILES["$userfile"]['size']>1024000){
			//return 5;
			//exit;
		//}
		//echo $_FILES["$userfile"]['type'];exit;
		if($_FILES["$userfile"]['type']=='audio/mpeg')
		//if($pt[0]!='image')
		{
			//生成随机文件名
			$mytime=date("YmdHis");
			//mt_srand((double)microtime()*1000000);
			for($i=1;$i<3;$i++){
				$randval=$randval.chr(rand(48,57));//ACSII码，0-9是48-57
				$i=$i+1;
			}
			
			//取得文件类型
			switch ($_FILES["$userfile"]['type'])  {     
				   case  "audio/mpeg":     
					 $mytype=".mp3";    
				  	 break;   
				   
				   }
			
			//$mytype    =    ".mp3";     
			
			//我们想把文件放在的地方
			//$upfile='../upfile/'.$_FILES['userfile']['name'];
			$upfile=$mulu.$mytime.$randval.$mytype;
			
			//if(is_uploaded_file($_FILES["$userfile"]['tmp_name'])){
				if(move_uploaded_file($_FILES["$userfile"]['tmp_name'],$upfile))
				{
					//echo '文件上传成功！';返回文件名
					return $mytime.$randval.$mytype;
				}
				else
				{
					return 6;
					exit;
				}
			//}
		}else{
			return 7;
			exit;
		}
}
?>


