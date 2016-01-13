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
require_once ("Test.class.php");


//Initialisation de la connexion � la base de donn�es
Database::InitDB("config/config.xml");


echo "<h1>chargement de la base</h1>";
$DAO=new Test();
$mesenr=$DAO->LoadAll();

var_dump($mesenr);

echo "<h2>Ajout d' enregistrement</h2>";
$unEnregistrement=new Test();

$unEnregistrement->setId(5);
$unEnregistrement->setChamp1("valeur du champ 1");
$unEnregistrement->setChamp2("valeur du champ 2");


try{
	$unEnregistrement->Save();
}
catch(Execption $e){
	var_dump($e);
}

echo "<h1>Rechargement de la base apres insertion</h1>";
$mesenrafter=$DAO->LoadAll();
var_dump($mesenrafter);


echo "<h2>Modification d'un enregistrement de la base</h2>";
$monenregistrement=$DAO->LoadOne(5);

$monenregistrement->setChamp1("nouvelle valeur champ 1");
$monenregistrement->setChamp2("nouvelle valeur champ 2");

try{
	$monenregistrement->Save();
}
catch(Execption $e){
	var_dump($e);
}

echo "<h1>Rechargement de la base apres modification</h1>";
$mesenrafter=$DAO->LoadAll();
var_dump($mesenrafter);

//Deconnexion à la base de donn�es
Database::close();

?>