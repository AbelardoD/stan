<?php
class {nomeClasse}
{
	<!-- BEGIN BLOCK_CAMPO -->
	public ${campo};
	<!-- END BLOCK_CAMPO -->
	
	public function cadastrar{nomeClasse}({camposChifre})
	{
		global $pdo;
		$query = $pdo->prepare("INSERT INTO `{nomeTabela}` ({campos}) VALUES (NULL, {interrogacoes})");
		$campos = array({camposChifre});
		$query->execute($campos); 
	}
	
	public function exibir{nomeClasse}s($where = NULL)
	{
		global $pdo;
		if($where != NULL)
		{
			$prepare = $pdo->prepare("SELECT * FROM {nomeTabela} WHERE ?");
			$campos = array($where);
			$prepare->execute($campos);
		}
		else
		{
			$prepare = $pdo->query("SELECT * FROM {nomeTabela}");
		}
		return $exibir = $prepare->fetch(PDO::FETCH_ASSOC);
	}
	
	public function exibir{nomeClasse}(${idClasse})
	{
		global $pdo;
		
		$prepare = $pdo->prepare("SELECT * FROM {nomeTabela} WHERE {idClasse} = ?");
		$campos = array({idClasse});
		$prepare->execute($campos);
		
		return $exibir = $prepare->fetch(PDO::FETCH_ASSOC);
	}

	public function excluir{nomeClasse}(${idClasse})
	{
		global $pdo;
		$prepare_excluir = $pdo->prepare("DELETE FROM `{nomeTabela}` WHERE `{idClasse}` = ?");
		$campos_excluir = array(${idClasse});
		$prepare_excluir->execute($campos_excluir);
		
		return true;
	}
	
	public function editar{nomeClasse}({camposChifre}, ${idClasse})
	{
		$prepare_editar = $pdo->prepare("UPDATE `{nomeTabela}` SET {camposEditar} = ? WHERE `{idClasse}` = ?");
		$campos_editar = array({camposChifre}, ${idClasse});
		$prepare_editar->execute($campos_editar);
	}
}
?>
<?php

/*
 * Protótipo a ser usado na construção do Stan
 * @author	Abelardo D. Álvares
 * @version	1.1.0
 */
class Prototipo extends BD
{
	<!-- BEGIN BLOCK_CAMPO -->
	public ${campo};
	<!-- END BLOCK_CAMPO -->
	
	function __construct({idClasse} = NULL)
	{
		if({idClasse} != NULL)
		{
			//Constroi a classe banco de dados
			$BD->setNomeDoBanco("{nomeTabela}");
			$BD->setWhere("{idClasse} = ?");
			$BD->setCamposWhere(array($this->{idClasse}));
		}
	}
	
	public function setInfos()
	{
		global $pdo;
		
		
		$select->execute($campo);
		
		$contar	= $select->rowCount(PDO::FETCH_ASSOC);
		
		if(!($contar == 0))
		{
			$exibir	= $select->fetch(PDO::FETCH_ASSOC);
			
			
			$this->idLoja		=  $exibir['idloja'];
			
			
			return TRUE;
		}
		return FALSE;
	}

}
?>