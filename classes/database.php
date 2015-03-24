<?php
class Database
{
	private  static $instance = NULL;
	private  static $pdo = NULL;
	
	private function __construct(){}
	
	/**
	 * 执行SQL
	 */
	public function runSQL($sqls)
	{
		$sqls = trim($sqls);
	        if (!empty($sqls)) {
		    	$db = Database::instance()->getPDO();
		        $all_sqls = explode(";\n", $sqls);
				foreach ($all_sqls as $sql) {
					$sql = trim($sql);
					if (!empty($sql)) {
						try {
							$db->exec($sql);
						} catch (Exception $e) {
							echo $e->getMessage();
							echo $e->getTraceAsString();
//							$this->WriteLog($e->__toString());
						}
					}
		    	}
//	       	 	echo 'Run SQL successful.';
	        } else {
//		        echo 'No SQL need to run.';
	        	
	        }
	}
	
	public function exec($sql)
	{
		$sql = trim($sql);
    	$db = Database::instance()->getPDO();
		try {
			return $db->exec($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
			echo $e->getTraceAsString();
		}
	}
	
	public function getlastinsertid()
	{
		$db = Database::instance()->getPDO();
		$lastinsertid = $db->lastInsertId();
		return $lastinsertid;
	}
	/**
	 * 
	 * @return PDO
	 */
	public function getPDO()
	{
		return Database::$pdo;
	}
	
	/**
	 * 获取可用于数据库查询和操作的适配器
	 * 返回值类型是 PDO
	 *
	 * @return Database
	 */
	public static function instance()
	{
		if (Database::$instance === NULL)
		{
			$config = include dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
            $config_db = $config['local'];
			$dsn = "mysql:host={$config_db['dbHost']};port={$config_db['dbPort']};dbname={$config_db['dbName']};";
			$username = $config_db['dbUser'];
			$password = $config_db['dbPwd'];
			$options = $config_db['driverOptions'];
			Database::$pdo = new PDO($dsn, $username, $password,$options);
			Database::$instance = new Database();
		} 
		return Database::$instance;
	}
	
	public function query($sql)
	{
		$sql = trim($sql);
    	$db = Database::instance()->getPDO();
		try {
			return $db->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
			echo $e->getTraceAsString();
		}
	}
	
	public function fetch_row($sql){
		$query = $this->query($sql);
		$rs = $query->fetch(PDO::FETCH_ASSOC);
		return $rs ? $rs : array();
	}
	
	public function fetchAll($sql){
		$query = $this->query($sql);
		$rs = $query->fetchAll(PDO::FETCH_ASSOC);
		return $rs ? $rs : array();
	}
	/**
	 * 入库操作
	 * @param unknown_type $tbl
	 * @param unknown_type $bind
	 */
	public function insert($tbl,$bind=array()){
		$sql = "INSERT INTO ".$tbl." SET ".Helper::format_data($bind);
		return $this->exec($sql);
	}
	
	/**
	 * 自增+1
	 * Enter description here ...
	 */
	public function update_count($tbl,$set_param='',$where=''){
		$update_sql = sprintf("UPDATE %s SET `%s`=`%s`+1 WHERE %s",$tbl,$set_param,$set_param,$where);
		return $this->exec($update_sql);
	}
	
	/**
	 * 减一操作
	 * Enter description here ...
	 */
	public function update_count_s($tbl,$set_param='',$where=''){
		$update_sql = sprintf("UPDATE %s SET `%s`=`%s`-1 WHERE %s",$tbl,$set_param,$set_param,$where);
		return $this->exec($update_sql);
	}
	/**
	 * 更新操作
	 * Enter description here ...
	 */
	public function update($tbl,$data,$where){
		if(empty($data)||empty($where)){
			return false;
		}
		
		$str ='';
		foreach($data as $key=>$var){
			$str .= "`$key`='".$var."',";
		}
		$str = substr($str,0,-1);
		$sql = "update ".$tbl." SET ".$str;
		$str ='';
		foreach($where as $key=>$var){
			$str .= "`$key`='".$var."'and";
		}
		$str = substr($str,0,-3);
		$sql = $sql."where".$str;
		
		//echo $sql;
		return $this->exec($sql);
	}
}
