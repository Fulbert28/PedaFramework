<?php
abstract class Entity implements IDAO {
	
	protected $_tablename;
	protected $_classename;
	
	 public function Entity(array $params=null){

	 }
	 
	 protected function lierDB($classname, $tablename){
	 	$this->_tablename=$tablename;
	 	$this->_classename=$classname;
	 }
	 	 
	 private function exist($id){
	 	
	 	$obj=$this->LoadOne($id);
	 	
	 	if(is_null($obj)){
	 		return false;
	 	}
	 	else{
	 		return true;
	 	}
	 }
	 
	 private function getColumns($tablename){
	 	
	 	$db=Database::getInstance();
	 	
	 	$req="SELECT COLUMN_NAME 
	 		  FROM INFORMATION_SCHEMA.COLUMNS 
	 		  WHERE TABLE_NAME='".$tablename."'";
	 	
	 	//echo $req;
	 	
	 	$stmt = $db->prepare($req);
	 	$stmt->execute();
	 	
	 	$columns=new Collection();
	 	
	 	while ($jeuenregistrement = $stmt->fetch(PDO::FETCH_ASSOC)) {
	 		
	 		$col=$jeuenregistrement["COLUMN_NAME"];
	 		
	 		$columns->add($col);
	 		
	 	}
	 	return $columns;
	 	
	 }
	 
	 public function Count(){
	 	$db=Database::getInstance();
	 	
	 	$tablename=$this->_tablename;
	 	$classe=$this->_classename;
	 	
	 	$req="SELECT Count(*) as nb FROM ".$tablename;
	 	
	 	//var_dump($req);
	 	
	 	$stmt = $db->prepare($req);
	 	$stmt->execute();
	 	
	 	$jeu=$stmt->fetch(PDO::FETCH_ASSOC);
	 	
	 	return $jeu["nb"];
	 	
	 }
	
	
	public function LoadAll($debutliste=null, $nbenr=null) {
		$db=Database::getInstance();
		
		//var_dump($db);
	
		$tablename=$this->_tablename;
		$classe=$this->_classename;
		
		if(!is_null($debutliste)&&!is_null($nbenr)){
			$req="SELECT * FROM $tablename LIMIT $debutliste,$nbenr";
		}
		else{
			$req="SELECT * FROM ".$tablename;
		}
		
		//var_dump($req);
		
		$stmt = $db->prepare($req);
		$stmt->execute();
		
		$lesobjets=new Collection();
		/*
		 * Pour chaque ligne du jeu d'enregistrement
		 */
		while ($jeuenregistrement = $stmt->fetch(PDO::FETCH_ASSOC)) {

			/*
			 * Creation d'une collection de valeurs de champ
			 */
			$params=new Collection();
			
			/*
			 * Pour chacune des colonnes de la ligne en cours
			 */
			foreach($jeuenregistrement as $champ => $valeur){
				//On stocke la valeur dans la collection
				$params->add($valeur);
			}
			
			$dataligne=$params->getAll();
			
			//var_dump($dataligne);
			/*
			 * On instancie un objet avec toute les valeurs de ces colonnes (dans le tableau de valeur)
			 */
			$monobjet=new $classe($dataligne);
		
			/*
			 * On ajoute l'objet a la collection
			 */
			$lesobjets->add($monobjet);
		}
		/*
		 * Retour de la collection
		 */
		return $lesobjets;
	}
	
	public function LoadByCritere($critere) {
		$db=Database::getInstance();
	
		//var_dump($db);
	
		$tablename=$this->_tablename;
		$classe=$this->_classename;
	
		$req="SELECT * FROM $tablename WHERE $critere" ;
	
		//var_dump($req);
	
		$stmt = $db->prepare($req);
		$stmt->execute();
	
		$lesobjets=new Collection();
		/*
		 * Pour chaque ligne du jeu d'enregistrement
		*/
		while ($jeuenregistrement = $stmt->fetch(PDO::FETCH_ASSOC)) {
	
			/*
			 * Creation d'une collection de valeurs de champ
			*/
			$params=new Collection();
				
			/*
			 * Pour chacune des colonnes de la ligne en cours
			*/
			foreach($jeuenregistrement as $champ => $valeur){
				//On stocke la valeur dans la collection
				$params->add($valeur);
			}
				
			$dataligne=$params->getAll();
				
			//var_dump($dataligne);
			/*
			 * On instancie un objet avec toute les valeurs de ces colonnes (dans le tableau de valeur)
			*/
			$monobjet=new $classe($dataligne);
	
			/*
			 * On ajoute l'objet a la collection
			*/
			$lesobjets->add($monobjet);
		}
		/*
		 * Retour de la collection
		*/
		return $lesobjets;
	}
	
	
	public function LoadOne($id=null){
		
		$critere="id='".$id."'";
		
		$lesobjets=$this->LoadByCritere($critere);
		
		if($lesobjets->Cardinal()==1){
			return $lesobjets->getElementAtIndex(0);
		}
		else{
			return null;
		}

	}
	
	/*
	 * TO DO
	 * 
	 * A finir d'implémenter correctement (gestion de l'update ou du insert)
	 * Pour l'instant seulement l'Insert est implémenté
	 */
	public function Save(){
		
		$reflection = new ReflectionObject($this);
		$lesmethodes=$reflection->getMethods();
		//var_dump($lesmethodes);
		
		$db=Database::getInstance();
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if($this->exist($this->getId())){
			//pour l'update
			$lescolonnes=$this->getColumns($this->_tablename);
						
			$req="UPDATE $this->_tablename SET ";
			
			$colonneid=1;
			foreach($lesmethodes as $reflexionobjet){
				
				$lamethode=$reflexionobjet->getName();
				
				if($reflexionobjet->isPublic() && substr($lamethode, 0,3)=="get" && $lamethode!="getId"){
					$legetteur=$reflexionobjet->getName();
					
					$unecolonne=$lescolonnes->getElementAtIndex($colonneid);
					$req.="$unecolonne='".$this->$legetteur()."', ";
					
					$colonneid++;
				}	
			}
			$req=substr($req,0,-2);
			$req.=" WHERE id=".$this->getId();
			
			//var_dump($req);
			
			try {
				$stmt = $db->prepare($req);
				$stmt->execute();
				//$db->exec($req);
			}
			catch(PDOException $e) {
				throw new Exception("Erreur dans l'enregistrement d'objet $this->_classename dans la table $this->_tablename");
			}
		}
		else{
			//c'est un insert
			
			$req="INSERT INTO $this->_tablename
				  VALUES (" ;
			

			foreach($lesmethodes as $reflexionobjet){
					
				$lamethode=$reflexionobjet->getName();
					
				//var_dump(substr($lamethode, 0,3));
					
				if($reflexionobjet->isPublic() && substr($lamethode, 0,3)=="get"){
					$legetteur=$reflexionobjet->getName();
					//var_dump($legetteur);
			
					$req.="'".$this->$legetteur()."',";
				}
			}
			
			$req=substr($req,0,-1);
			$req.=")";
			
			//var_dump($req);
			
			try {
				$stmt = $db->prepare($req);
				$stmt->execute();
				//$db->exec($req);
			}
			catch(PDOException $e) {
				throw new Exception("Erreur dans l'enregistrement d'objet $this->_classename dans la table $this->_tablename");
			}
		}
		
	}
	
}

?>