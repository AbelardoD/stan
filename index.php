<?php
//Veja o Arquivo Stan_Porra.php
require("Template.class.php");
require("config.php");
require("conexao.php");
require("Stan_Porra.php");

$codigoPagina 	= $_GET['cod'];
$pag_explode 	= explode('/', $codigoPagina);
$cod_Stan_URL 	= implode(".", $pag_explode);

if(!isset($codigoPagina))
{
	$cod_Stan_URL = "index.index";
}

$autoloader = new ClassAutoloader();

$stan_Porra = new Stan_Porra($cod_Stan_URL);

$stan_Porra->doMagic();
?>