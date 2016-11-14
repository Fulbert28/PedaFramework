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
		$tablename=$this->_tablename;
		
		$txt="<?php \n class $nomclass extends Entity{\n";
		
	 		$txt.="\t".$this->generateConstructeur($nomclass,$tablename)."\n";
	
			$txt.="\t".$this->generateAttributes()."\n";
			$txt.="\t".$this->generateGetteurs()."\n";
			$txt.="\t".$this->generateSetteurs()."\n";
	
			
		$txt.="} ?>";
		
		return $txt;
	}
	
	private function generateConstructeur($classname, $tablename){
		$colonnes=$this->getLesColonnes();
		
		$txt="\n";
		$txt.="\t //Constructeur \n";
		$txt.="\n";
		
		$txt.="\t public function $this->_classename(array \$params=null){\n";
		
		$txt.="\t\t\$this->lierDB(\"$classname\",\"$tablename\");\n";
		
			$txt.="\t\t if(isset(\$params)){\n";
			
			$colonnes=$this->getLesColonnes();
			$i=0;
			foreach ($colonnes->getAll() as $unecolonne){
				
				$txt.="\t\t\t \$this->_$unecolonne=\$params[$i];\n";
				$i++;
			}
			
			$txt.="\t\t}\n";
		
		$txt.="\t}\n\n";
		
		return $txt;
	}
	
	
	private function generateAttributes(){
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
	
	private function generateGetteurs(){
		
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
	
	private function generateSetteurs(){
		
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