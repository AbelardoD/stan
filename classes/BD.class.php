<?php
/**
 * Classe responsсvel por facilitar a comunicaчуo com o banco de dados
 * @author Abelardo D. Сlvares <abelardod.com@gmail.com
 * @version 0.9.0
 * @var  string 	$nomeDoBanco		Nome do Banco de Dados
 * @var  array 		$camposDoBanco		Campos a serem alterados ou adicionados (EX: "nome"=>"bel", "sobrenome"=>"dan")
 * @var  string 	$where				Condiчуo de alteraчуo
 * @var  array 		$camposWhere		Campos que estarуo no Where
 * 
 */
class BD
{
	private		$nomeDoBanco;		//Nome do Banco de Dados
	public		$camposDoBanco;		//Campos a serem alterados
	public		$where				= NULL;		//Condiчуo de alteraчуo
	public		$camposWhere		= NULL;		//Campos que estarуo no Where
	public		$query;
	
	/**
	 * Mщtodo responsсvel por realizar ediчуo no banco de dados
	 * 
	 * @return boolean	$editar Retorna TRUE em caso de sucesso da operaчуo e FALSE caso contrсrio
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
	
	public function excluir()
	{
		global $pdo;
		if(!is_null($this->where))
		{
			$prepareDelete = $pdo->prepare("DELETE FROM {$this->nomeDoBanco} WHERE {$this->where}");
			$prepareDelete->execute($this->camposWhere);
			$linhasAfetadas = $prepareDelete->rowCount();
			
			if($linhasAfetadas > 0)
			{
				return true;
			}
			else
			{
				//return $prepareDelete->errorInfo();
				return false;
			}
		}
	}
	
	public function adicionar()
	{
		global $pdo;
		if(is_array($this->camposDoBanco))
		{
			$keys			= implode(", ", array_keys($this->camposDoBanco));
			$campos			= array_values($this->camposDoBanco);
			$interrogacoes	= NULL;
			
			foreach ($campos as $value)
			{
				$interrogacoes[] = "?";
			}
			
			$interrogacoes	= implode(", ", $interrogacoes);
			
			$prepareInsert = $pdo->prepare("INSERT INTO {$this->nomeDoBanco} ($keys) VALUES ($interrogacoes)");
			$prepareInsert->execute($campos);
			
			$linhasAfetadas = $prepareInsert->rowCount();
			
			if($linhasAfetadas > 0)
			{
				return true;
			}
			else
			{
				//return $prepareDelete->errorInfo();
				return false;
			}
		}
			
	}
	
	public function verSeExiste()
	{
		global $pdo;
		if($this->camposWhere != NULL)
		{
			$prepareSelect = $pdo->prepare("SELECT * FROM {$this->nomeDoBanco} WHERE {$this->where}");
			$prepareSelect->execute($this->camposWhere);
			
			$registros	= $prepareSelect->rowCount();
			
			if($registros > 0)
			{
				return TRUE;
			}
		}
		return FALSE;
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
?>