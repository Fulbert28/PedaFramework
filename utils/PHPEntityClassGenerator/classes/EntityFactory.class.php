<?php
class EntityFactory extends Entity{
	
	public function EntityFactory($tablename,$classname) {
		$this->lierDB($classname,$tablename);
	}
	
	public function getLesColonnes(){
		return $this->Columns();
	}
	
	public function generateClasse(){
		
		$nomclass=$this->_classename;
		
		$txt="<?php \n class $nomclass extends Entity{\n";
		
			$txt.="\t".$this->generateAttributes()."\n";
			$txt.="\t".$this->generateGetteurs()."\n";
			$txt.="\t".$this->generateSetteurs()."\n";
			
		$txt.="} ?>";
		
		return $txt;
	}
	
	public function generateAttributes(){
		$colonnes=$this->getLesColonnes();
		
		$txt="\n";
		$txt.="\t //Attributs \n";
		$txt.="\n";
		
		foreach ($colonnes->getAll() as $unecolonne){
			if($unecolonne!="id"){
				$txt.="\t private \$_$unecolonne;\n";
			}
		}
		
		return $txt;
	}
	
	public function generateGetteurs(){
		
		$colonnes=$this->getLesColonnes();
				
		$txt="\n";
		$txt.="\t //Getteurs \n";
		$txt.="\n";
		
		
		foreach ($colonnes->getAll() as $unecolonne){
			
			$unecolonneMaj = ucfirst($unecolonne);
			
			if($unecolonne!="id"){
				$txt.="\t public function get$unecolonneMaj(){\n";
				$txt.="\t\t return \$this->_$unecolonne;\n";
				$txt.="\t}\n\n";
			}
		}
		
		return $txt;
	}
	
	public function generateSetteurs(){
		
		$colonnes=$this->getLesColonnes();
		
		$txt="\n";
		$txt.="\t //Setteurs \n";
		$txt.="\n";
		
		foreach ($colonnes->getAll() as $unecolonne){
				
			$unecolonneMaj = ucfirst($unecolonne);
				
			if($unecolonne!="id"){
				$txt.="\t public function set$unecolonneMaj(\$un$unecolonneMaj){\n";
				$txt.="\t\t \$this->_$unecolonne=\$un$unecolonneMaj;\n";
				$txt.="\t}\n\n";
			}
		}
		
		return $txt;
	
	}
}