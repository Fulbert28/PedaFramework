<?php
class Collection{

	private $colObjet;
	private $compteur;

	public function Collection(){
		$this->colObjet=array();
		$this->compteur=0;
	}

	public function add($unobj){
		$this->colObjet[$this->compteur]=$unobj;
		$this->compteur++;
	}

	public function getAll(){
		return $this->colObjet;
	}

	public function Cardinal(){
		return $this->compteur;
	}

	public function Remove($uno){
		$indice=$this->ChercheObjet($uno);
		if($indice>-1){
		//	echo "<br/>suppression";

			$tab=$this->getAll();

		//	echo $tab[$indice]->ToString();

			unset($tab[$indice]);

		//	echo "<br/>nouveau tableau:<br/>";
		//	print_r($tab);

			$this->colObjet=$tab;
			$this->compteur--;
		}
	}
	
	public function getElementAtIndex($index){
		return $this->colObjet[$index];
	}


	/*
	 * Implémentation cohérente avec un veritable tableau gérant un offset et non une clé.
	 */
	/*private function ChercheObjet($UnObjet){
		$i=0;
	//	echo "a trouver: ".$UnObjet->ToString();
		while($i<$this->Cardinal() && $this->colObjet[$i]!=$UnObjet){
	//		echo "<br/>";
	//		echo "element: ".$this->colObjet[$i]->ToString();
			$i=$i+1;
		}
		if($this->colObjet[$i]==$UnObjet){
	//		echo "<br/>indice retourne: $i";
			return $i;
		}
		else{
			return -1;
		}
	  }
		*/
	
		private function ChercheObjet($UnObjet){
			$key = array_search($UnObjet, $this->colObjet);
			return $key;
		}
}
?>