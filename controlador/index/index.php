<?php
$tpl->TITULO = "Titulo Maroto";
$tpl->NOME = "Nome";

if(isset($identificador))
{
	echo "identificador {$identificador}<br>";
} 

$teste = new Teste();
$teste->olaMundo();

?>