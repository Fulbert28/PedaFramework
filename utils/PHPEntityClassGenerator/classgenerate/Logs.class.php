<?php 
 class Logs extends Entity{
	
	 //Constructeur 

	 public function Logs(array $params=null){
		$this->lierDB("Logs","logs");
		 if(isset($params)){
			 $this->_id=$params[0];
			 $this->_student=$params[1];
			 $this->_lastconnect=$params[2];
		}
	}


	
	 //Attributs 

	 private $_student;
	 private $_lastconnect;

	
	 //Getteurs 

	 public function getStudent(){
		 return $this->_student;
	}

	 public function getLastconnect(){
		 return $this->_lastconnect;
	}


	
	 //Setteurs 

	 public function setStudent($unStudent){
		 $this->_student=$unStudent;
	}

	 public function setLastconnect($unLastconnect){
		 $this->_lastconnect=$unLastconnect;
	}


} ?>