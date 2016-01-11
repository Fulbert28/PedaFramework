<?php
class Database {
	
	private static $_maconnexion;
	//private static $_maconfigxml;
	
	private static function createInstance($sgbd="mysql", $server="127.0.0.1", $dbname=null, $user='root', $password=null){
		
		$db = new PDO("$sgbd:host=$server;dbname=$dbname", "$user", "$password");
		
		$db->exec("SET CHARACTER SET utf8");
		
		Database::$_maconnexion=$db;
	}
	

	public static function InitDB($_fichier_XML){
		
		if (file_exists($_fichier_XML)){
			//Database::$_maconfigxml=$_fichier_XML;
			$config = simplexml_load_file($_fichier_XML);
		}
		else{
			$data='<application>
						<database sgbd="mysql" host="127.0.0.1" dbname="lafleur" user="root" password="" /> 
				   </application>';
			
			$config = simplexml_load_string($data);
		}
		
		$db_element=$config->children()->database;
		
		self::createInstance($db_element->attributes()->sgbd, 
							 $db_element->attributes()->host, 
							 $db_element->attributes()->dbname,
							 $db_element->attributes()->user,
							 $db_element->attributes()->password);
	}
	
	public static function getInstance(){
		return Database::$_maconnexion;
	}
	
	public static function close(){
		Database::$_maconnexion=null;
	}
}

?>