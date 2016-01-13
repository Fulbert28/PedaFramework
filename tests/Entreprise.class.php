<?php
class Entreprise extends Entity{
	
	protected $_id;
	private $_entreprise;
	private $_adresse;
	private $_cp;
	private $_ville;
	private $_contact;
	private $_ajoute_par;
	
	public function Entreprise(array $params=null) {
		
		$this->lierDB("Entreprise","entreprises");
		
		//var_dump($params);
		
		if(isset($params)){
			$this->_id=$params[0];
			$this->_entreprise=$params[1];
			$this->_adresse=$params[2];
			$this->_cp=$params[3];
			$this->_ville=$params[4];
			$this->_contact=$params[5];
			$this->_ajoute_par=$params[6];
		}
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function getNom(){
		return $this->_entreprise;
	}
	
	public function getAdresse(){
		return $this->_adresse;
	}
	
	public function getCodePostal(){
		return $this->_cp;
	}
	
	public function getVille(){
		return $this->_ville;
	}
	
	public function getContact(){
		return $this->_contact;
	}
	
	public function getAddBy(){
		return $this->_ajoute_par;
	}
	
	public function setId($unid){
		$this->_id=$unid;
	}
	
	public function setNom($unnom){
		$this->_entreprise=$unnom;
	}
	
	public function setAdresse($uneadresse){
		$this->_adresse=$uneadresse;
	}
	
	public function setCodePostal($uncp){
		$this->_cp=$uncp;
	}
	
	public function setVille($uneville){
		$this->_ville=$uneville;
	}
	
	public function setContact($uncontact){
		$this->_contact=$uncontact;
	}
	
	public function setEtudiantAjout($unuser){
		$this->_ajoute_par=$unuser;
	}
}