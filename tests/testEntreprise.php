<?php
ini_set('display_errors','On');
/*
 * Partie MVC du framework
 */
require_once ("../pedaframework/trunk/MVC/Application.class.php");
require_once ("../pedaframework/trunk/MVC/ControllerFactory.class.php");
require_once ("../pedaframework/trunk/MVC/Controller.class.php");
require_once ("../pedaframework/trunk/MVC/Layout.class.php");

/*
 * Classes ORM du framework
*/
require_once ("../pedaframework/trunk/ORM/Database.class.php");
require_once ("../pedaframework/trunk/ORM/IDAO.class.php");
require_once ("../pedaframework/trunk/ORM/Entity.class.php");

/*
 * Classe Collection
 */
require_once ("../pedaframework/trunk/Collection.class.php");

/*
 * Faire référence au Model de notre application
 */
require_once ("Entreprise.class.php");


//Initialisation de la connexion � la base de donn�es
Database::InitDB("config/config.xml");


echo "<h1>chargement de la base</h1>";
$DAOentreprise=new Entreprise();
$mesentreprises=$DAOentreprise->LoadAll(40,3);

var_dump($mesentreprises);

echo "<h2>enregistrement d'une entreprise</h2>";
$uneEntreprise=new Entreprise();

$uneEntreprise->setId(100);
$uneEntreprise->setNom("Entreprise test");
$uneEntreprise->setAdresse("adresse Entreprise test");
$uneEntreprise->setCodePostal(69000);
$uneEntreprise->setVille("une ville");
$uneEntreprise->setContact("un contact");
$uneEntreprise->setEtudiantAjout("un etudiant");

try{
	$uneEntreprise->Save();
}
catch(Execption $e){
	var_dump($e);
}

echo "<h1>Rechargement de la base apres insertion</h1>";
$mesentreprisesafter=$DAOentreprise->LoadAll(40,5);
var_dump($mesentreprisesafter);


echo "<h2>Modification d'un enregistrement de la base</h2>";
$monentreprise=$DAOentreprise->LoadOne(100);

$monentreprise->setNom("Nouveau nom");
$monentreprise->setCodePostal(75000);

try{
	$monentreprise->Save();
}
catch(Execption $e){
	var_dump($e);
}

echo "<h1>Rechargement de la base apres modification</h1>";
$mesentreprisesafter=$DAOentreprise->LoadAll(40,5);
var_dump($mesentreprisesafter);

//Deconnexion à la base de donn�es
Database::close();

?>