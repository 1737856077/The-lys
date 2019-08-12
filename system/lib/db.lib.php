<?php

class lib_db {
	private $db;
	public function __construct() {
		$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';port='.DB_PORT;
		for ($i=0;$i<3;$i++) {
			try{
				$this->db = new PDO($dsn, DB_USER, DB_PASS, array(
					PDO::ATTR_PERSISTENT => false,
					PDO::ATTR_CASE => PDO::CASE_NATURAL,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_AUTOCOMMIT => true,
					PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				));
				break;
			} catch (Exception $e) {
				if ($i >= 2) core::error('连接数据库失败，请重试');
			}
		}
	}
	
	public function insert($table, $data) {
		$fields = '';
		$values = '';
		foreach ($data as $k => $v) {
			$fields .= '`'.$k.'`,';
          	$v		 =str_replace("'","\'",$v);
			$values .= "'$v',";
		}
		$sql = 'INSERT INTO `'.$table.'` ('.substr($fields, 0, -1).') VALUES ('.substr($values, 0, -1).')';
		return $this->query($sql, 1);
	}
	
	public function update($table, $data, $condtion) {
		$fields = '';
		$wheres = '';
		foreach ($data as $k => $v) {
			$fields .= "`".$k."`='".$v."',";
		}
		foreach ($condtion as $k => $v) {
			$wheres .= "`".$k."`='".$v."' and ";
		}
		$sql = 'UPDATE `'.$table.'` SET '.substr($fields, 0, -1).' where '.$wheres.'1';
		return $this->query($sql, 0);
	}
	
	public function query($sql, $return) {
		try {
		    $action = $return === 2 ? 'fetch' : 'fetchAll';
			switch ($return) {
				case 0:
					$result = $this->db->exec($sql); //影响的行数
					break;
				case 1:
					$this->db->exec($sql);
					$result = $this->db->lastInsertId();
					break;
				case 2:
					$query = $this->db->query($sql);
					$result = call_user_func_array(array($query, $action), array(PDO::FETCH_ASSOC));
					$query->closeCursor();
				case 3:
					$query = $this->db->query($sql);
					$result = call_user_func_array(array($query, $action), array(PDO::FETCH_ASSOC));
					$query->closeCursor();
				break;
				default: throw new Exception('_UNKNOW_RETURN_: '.$return);
			}
			return $result;
		} catch (Exception $e) {
			$data = array(
				'TYPE' => 'MYSQL',
				'SQL'  => $sql,
			);
			core::logger($data);
			
		}
	}
	public function __destruct() {
		$this->db = null;
	}

}