<?php
/**
* O Stan_Master é uma classe que tem como objetivo gerar outras classes
* assim como páginas de CRUD. Mas nesta versão ele só faz a Classe.
* 
* @version 0.1.0
*/
class Stan_Master
{
	public $geraArquivo;
	public $tabelas;

	/**
	* @param Array $tabelas Tabelas do Banco de Dados que devem ser feita a mágica
	*/
	function __construct($tabelas)
	{
		$geraArquivo 	= new Cache();
		$this->tabelas 	= $tabelas;
	}

	public function trabalhaEFazAPorraToda()
	{
		foreach ($tabelas as $tabela)
		{
			$this->fazClasse($tabela);
		}
	}

	/**
	* Metodo que realiza a construção da classe
	* @param String $tabela Nome da tabela a ser criada a classe
	*/
	public function fazClasse($tabela)
	{
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
		
		
		$this->geraArquivo->criarCache("esqueleto/classes/{$nomeClasse}.php", $conteudoClasse);
	}
}
?>