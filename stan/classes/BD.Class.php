<?php
/*
 * Prot�tipo a ser usado na constru��o do Stan
 * @author	Abelardo D. �lvares
 * @version	1.1.0
 */
/*
 * @param  string 	$nomeDoBanco		Nome do Banco de Dados
 * @param  array 	$camposDoBanco		Campos a serem alterados (EX: "nome"=>"bel", "sobrenome"=>"dan")
 * @param  array 	$where				Condi��o de altera��o
 * @param  array 	$camposWhere		Campos que estar�o no Where
 */
class BD
{
	private $nomeDoBanco;		//Nome do Banco de Dados
	private $camposDoBanco;		//Campos a serem alterados
	private $where				= NULL;		//Condi��o de altera��o
	private $camposWhere		= NULL;		//Campos que estar�o no Where
	public  $query;
	
	/*
	 * M�todo respons�vel por realizar edi��o no banco de dados
	 */
	public function editar()
	{
		global $pdo;
		if(is_array($this->camposDoBanco))
		{
			foreach($this->camposDoBanco as $key=>$value)
			{
				$ncampos[] 			= "{$key} = ?";
				$campos_edit[]		= $value;
			}
			
			if(!is_null($this->where))
			{ 
				$where 	= "WHERE {$this->where}"; 
				if(is_array($this->camposWhere))
				{
					foreach ($this->camposWhere as $value)
					{
						$campos_edit[] = $value;
					}
				}
			}
			
			$set 		= implode(", ", $ncampos);
			$query 		= "UPDATE {$this->nomeDoBanco} SET {$set} {$where}";
			$this->query = $query;
			
			$prepara_edit	= $pdo->prepare($query);
			$prepara_edit->execute($campos_edit);
			$linhasAfetadas = $prepara_edit->rowCount();
			
			if($linhasAfetadas > 0)
			{
				return true;
			}
			else
			{
				return $prepara_edit->errorInfo();
				//return false;
			}
		}
	}
	
	public function setNomeDoBanco($var)
	{
		$this->nomeDoBanco = $var;
	}	
	
	public function setCamposDoBanco($var)
	{
		$this->camposDoBanco = $var;
	}
		
	public function setWhere($var)
	{
		$this->where = $var;
	}		
		
	public function setCamposWhere($var)
	{
		$this->camposWhere = $var;
	}
}