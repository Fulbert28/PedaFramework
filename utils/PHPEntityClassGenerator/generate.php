<?php
//print_r($argv);
/*
 * Classes ORM du framework
 */
require_once ("../../ORM/Database.class.php");
require_once ("../../ORM/IDAO.class.php");
require_once ("../../ORM/Entity.class.php");

require_once ("../../Collection.class.php");

require_once ("classes/EntityFactory.class.php");


$nomscript = $argv[0];

//echo "nombre de parametres : ".count($argv);

if(count($argv)<4){
	echo "\n"."usage : $nomscript tablename [classname] \n";
	echo "\t tablename: correspond au nom de la table \n";
	echo "\t classname: nom de la classe genere \n";
	echo "\t chemin: chemin complet du fichier exemple: C:\wamp\www\myproject\application\models\maclasse.class.php \n";
	
	echo "\n\t Attention: Adapter le fichier config/config.xml pour l'acces a la base de donnees \n";
}
else{

	$nomtable  = $argv[1];
	$nomclasse  = $argv[2];
	$path  = $argv[3];

/*	echo "Nom du script $nomscript \n";
	echo "Nom de la table $nomtable \n";
	echo "Nom de la classe  $nomclasse \n";
	echo "Chemin du fichier  $path \n";
	*/
	
	//Initialisation de la connexion à la base de donn�es
	Database::InitDB("config/config.xml");
	
	$fabrique=new EntityFactory($nomtable,$nomclasse);
	
	$contenu=$fabrique->generateClasse();
	
	//print_r($contenu);
	
	if(isset($path)){
		$f = $path;
	}
	else{
		$f = "classgenerate/$nomclasse.class.php";
	}
	
	
	$text = $contenu;
	$handle = fopen($f,"w");
	
	// regarde si le fichier est accessible en écriture
	if (is_writable($f)) {
		// Ecriture
		if (fwrite($handle, $text) === FALSE) {
			echo "Impossible d ecrire dans le fichier $f";
			exit;
		}
		 
		echo "Generation de la classe $nomclasse à partir de la table $nomtable termine";
		 
		fclose($handle);
		 
	}
	else {
		echo 'Impossible d\'écrire dans le fichier '.$f.'';
	}
	
	
}