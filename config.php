<?php
$servidorDB = "localhost";
$nomeDB 	= "nome do bd";
$usernameDB = "username";
$passwordDB = "password";

/**
* Classe responsável por incluir os arquivos das classes quando utilizadas
*/
class ClassAutoloader 
{

	public function __construct() 
	{
		spl_autoload_register(array($this, 'loader'));
	}

	private function loader($className) 
	{
		if(file_exists("classes/{$className}.class.php"))
		{
			require_once "classes/{$className}.class.php";
		}
		elseif(file_exists("classes/{$className}.php"))
		{
			require_once "classes/{$className}.php";
		}
		elseif(file_exists("classes/{$className}.Class.php"))
		{
			require_once "classes/{$className}.Class.php";
		}
		elseif (file_exists("modelo/{$className}/classe.php")) 
		{
			require_once "modelo/{$className}/classe.php";
		}
    }
}
?>