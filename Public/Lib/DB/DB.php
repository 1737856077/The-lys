<?php
class DB{
	private $conn;
	public $recordcount;
	
	public function __construct(){
		$this->conn=mysqli_connect(DB_HOST,DB_USERNAME,DB_PWD,DB_NAME);
		if(!$this->conn){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
		}
		
	}
	
	public function query($query){
		mysqli_set_charset($this->conn,"utf8");
		$result=mysqli_query($this->conn,$query);
		if(!$result){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		$this->recordcount=mysqli_num_rows($result);
		$tmp=array();
		while($v=mysqli_fetch_array($result)){
			$tmp[]=$v;
		}
		mysqli_free_result($result);
		return $tmp;
	}
	
	public function getone($query){
		mysqli_set_charset($this->conn,"utf8");
		$result=mysqli_query($this->conn,$query);
		if(!$result){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		$tmp=mysqli_fetch_array($result);
		mysqli_free_result($result);
		return $tmp;
	}
	
	public function execut($query){
		mysqli_set_charset($this->conn,"utf8");
		if(!@mysqli_query($this->conn,$query)){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		return true;
	}
	
	public function QuerySql($sql){
		mysqli_set_charset($this->conn,"utf8");
		$rs=@mysqli_query($this->conn,$sql);
		if($rs){
			$sql=trim($sql);
			$sql=strtolower($sql);
			if(substr($sql,0,6)=="insert"){
				$num=mysqli_affected_rows($this->conn);
				if($num>0){
					return $num=mysqli_insert_id($this->conn);
				}else{
					return 0;
				}
			}else{
				$num=mysqli_affected_rows($this->conn);
			}
			return $num;
		}else{
			return 0;
		}
	}
	
		/**
	 *$name 表名
	 *$data 数据数组
	 *
	*/
	public function insert($name,$data){
		$key="";
		$value="";
		
		foreach($data as $k=>$v){
			$key.="$k,";	
			$value.="'$v',";
		}
		$key=substr($key,0,strlen($key)-1);
		$value=substr($value,0,strlen($value)-1);
		$query="INSERT INTO ".DB_NAME.".$name($key) VALUE($value)";
		mysqli_set_charset($this->conn,"utf8");
		if(!@mysqli_query($this->conn,$query)){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		
		return mysqli_insert_id($this->conn);
	}
	
	public function update($name,$data,$where){
		$str="";
		foreach($data as $k=>$v){
			$str.="$k='$v',";	
		}
		$str=substr($str,0,strlen($str)-1);
		$where=$where=="" ? "1" : $where;
		$query="UPDATE ".DB_NAME.".$name SET $str WHERE 1 AND $where";
		mysqli_set_charset($this->conn,"utf8");
		if(!@mysqli_query($this->conn,$query)){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		
		return true;
	}
	
	public function delete($name,$key,$id){
		if($key=="" or !intval($id)){ return false;}
		$query="DELETE FROM ".DB_NAME.".$name WHERE $key='$id'";
		mysqli_set_charset($this->conn,"utf8");
		if(!@mysqli_query($this->conn,$query)){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		return true;
	}
	
	public function del($name,$where){
		$query="DELETE FROM ".DB_NAME.".$name WHERE 1 AND $where";
		if(!@mysqli_query($this->conn,$query)){
			echo mysqli_errno($this->conn).':'.mysqli_error($this->conn);
			exit;
		}
		return true;
	}
	
}
?>