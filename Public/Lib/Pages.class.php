<?php
/**
 * @描述：分页类
 * @author:liuqingyan
 * $Id:Pages.class.php 2015-04-28 11:49:00 $
 */
class Pages{
	
	/**
	 * @描述：分页方法
	 * @param	int		$count			--总记录数
	 * @param	int		$page			--当前页
	 * @param	int		$url			--跳转URL
	 * @param	int		$display_num	--每页记录数
	 * return	string		$str		--分页后THML字符串
	 */
	public function fenye($count,$page,$url,$display_num=5){
		
	    $str="";

		$step=6;//步长为10页
		$leftstep=ceil($step/2);
		
		$total_page	= ceil($count/$display_num);//总页数
		
		if($page<1 || $page == ""){
			$page = 1;
		}elseif($page>$total_page){
			$page = $total_page;
		}
		
		
		//上一页
		if($page==1){
			$str.=" <a class=\"fy_01\" title=\"上一页\">上一页</a> ";
		}else{
			$lastpage=$page-1;
			$str.=" <a class=\"fy_01\" href=\"".$url."/page/".$lastpage."\" title=\"上一页\">上一页</a> ";
		}
		//当总页数小于步长
		if($total_page<=$step){
			for($i=1; $i<=$total_page; $i++){
					if($i==$page){
						$str.=" <a >$i</a> ";
					}else{
						$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
					}
			}
		}else{
			//第一页
			if($page>($leftstep+1)){
				$str.=" <a class=\"fy_o\" href=\"".$url."/page/1\">1</a> <a  style=\"text-decoration:none;color:#ccc;\">...</a> ";
			}
		
			if($page<=$leftstep){//
				for($i=1; $i<$page; $i++){
					$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
				}
				for($i=$page; $i<=($page+$leftstep); $i++){
					if($i==$page){
						$str.=" <a >$i</a> ";
					}else{
						$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
					}
				}
			}else if($page>=($total_page-$leftstep)){
				for($i=($page-$leftstep); $i<$page; $i++){
					$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
				}
				for($i=$page; $i<=$total_page; $i++){
					if($i==$page){
						$str.=" <a >$i</a> ";
					}else{
						$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
					}
				}
			}else{
				for($i=($page-$leftstep); $i<$page; $i++){
					$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
				}
				for($i=$page; $i<=($page+$leftstep); $i++){
					if($i==$page){
						$str.=" <a >$i</a> ";
					}else{
						$str.=" <a class=\"fy_o\" href=\"".$url."/page/".$i."\">$i</a> ";
					}
				}
			}
		}
		
		//最后页
		if($page<($total_page-5)){
			//$str.="...<a class=\"fy_o\" href=\"".$url."page/$total_page\">$total_page</a>";
		}
		
		//下一页
		if($page==$total_page){
			$str.=" <a class=\"fy_01\" title=\"下一页\">下一页</a> ";
		}else{
			$nextpage=$page+1;
			$str.=" <a class=\"fy_01\" href=\"".$url."/page/".$nextpage."\" title=\"下一页\">下一页</a> ";
		}
		

		
	   return $str;

	}
	
	
}

?>