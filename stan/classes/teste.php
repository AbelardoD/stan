<?php
$campos = array("nome" => "Abelardo", "sobrenome" => "D. �lvares");
foreach ($campos as $campo=>$valor)
		{
			${$campo} = $valor;
		}
		
echo $nome;
echo " ";
echo $sobrenome;