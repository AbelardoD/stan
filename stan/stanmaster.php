<?php
/*
 * Responsavel por ler o banco de dados e gerar arquivos
 * 
 * @author	Abelardo D. Álvares <abelardod.com@gmail.com>
 * 
 */

include '../functions.php';
include '../config.php';
include '../conexao.php';
require '../classes/BD.class.php';
require '../Template.class.php';
require '../classes/Cache.php';
require '../classes/Stan_Master.php';

//Gera Classes

$tabelas 		= array("tabela1", "tabela2");
$Stan_Master 	= Stan_Master($tabelas);

$Stan_Master->trabalhaEFazAPorraToda();

/*
foreach ($tabelas as $tabela)
{
	$geraArquivo = new Cache();
	$tplClasse = new Template("templates/classe.html");
	
		$fields 		= array();
		
		echo $tabela;
		
		$nomeClasse = ucfirst($tabela);
		
		$prepare = $pdo->query("SHOW COLUMNS FROM $tabela");
		
		while($exibir = $prepare->fetch(PDO::FETCH_ASSOC))
		{
			$fields[] 		= $exibir['field'];
			
			if($exibir['key'] == "PRI")
			{
				$idField = $exibir['field'];
			}
		}
		
		$tplClasse->idClasse		= $idField;
		$tplClasse->nomeTabela 		= $tabela;
		$tplClasse->nomeClasse 		= $nomeClasse;
		
		foreach ($fields as $campo)
		{
			$tplClasse->campo = $campo;
			$tplClasse->block("BLOCK_CAMPO", true);
		}
		
		foreach ($fields as $campo)
		{
			$tplClasse->campo2 = $campo;
			$tplClasse->block("BLOCK_CAMPO_SET", true);
		}

		foreach ($fields as $campo)
		{
			$tplClasse->campo3 = $campo;
			$tplClasse->value3 = ($campo != $idField) ? $campo : NULL;
			$tplClasse->block("BLOCK_CAMPO_CAMPO", true);
		}
		
	
	$conteudoClasse = $tplClasse->parse();
	
	
	$geraArquivo->criarCache("esqueleto/classes/{$nomeClasse}.php", $conteudoClasse);
	
	echo "- Feita<br>";
}
*/
?>