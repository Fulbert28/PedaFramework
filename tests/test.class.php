<?php
class Test extends Entity{
	
	/*
	 * attributs, champ obligatoire _id
	 */
	private $_id;
	private $_champ1;
	private $_champ2;

	
	public function Test(array $params=null) {
		
		$this->lierDB("Test","test");
		
		//var_dump($params);
		
		if(isset($params)){
			$this->_id=$params[0];
			$this->_champ1=$params[1];
			$this->_champ2=$params[2];
		}
	}
	
	/*
	 * Les getteurs en premier (Pour l'ORM)
	 */
	
	public function getId(){
		return $this->_id;
	}
	
	public function getChamp1(){
		return $this->_champ1;
	}
	
	public function getChamp2(){
		return $this->_champ2;
	}
	
	/*
	 * Suivi des setteurs
	 */
	
	public function setId($unid){
		$this->_id=$unid;
	}
	
	public function setChamp1($uneval){
		$this->_champ1=$uneval;
	}
	
	public function setChamp2($uneval){
		$this->_champ2=$uneval;
	}
	

}