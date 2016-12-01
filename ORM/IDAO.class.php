<?php
namespace Fulbert\PedaFramework\ORM;

interface IDAO {
	
	public function LoadAll();
	
	public function LoadOne();
	
	public function Save();
	
}

?>