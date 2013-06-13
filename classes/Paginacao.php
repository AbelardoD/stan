<?php
/**
* Esta Classe é responsável por realizar paginação
* @author Abelardo D. Álvares
* @version 0.8.0
*/
class Paginacao
{
	private $registrosPorPag;	//Quantidade de Registros que devem aparecer por página
	
	private $qtdDePaginas; 	// Quantidade de Páginas que existem de registros
	
	private $qtdDePaginasExibidas	= 5; // Quantidade de Páginas a serem Exibidas
	
	private $pagInicio				= 1; //Página que se inicia a contagem das páginas

	private $camposQuery;
	
	private $paginaAnterior;
	
	private $paginaAtual;
	
	private $paginaPosterior;
	
	private $query; 
	
	private $limiteSql;
	
	private $existePaginacao 		= FALSE; // Variavel Booleana
	
	private $existePaginaAnterior	= FALSE; // Variável que indica se existe página Anterior a Atual
	
	private $existePaginaPosterior	= FALSE; //Variável que indica se existe página Posteior a Atual
	
	/**
	 * @param	integer		$qtdDeRegistros		Quantidade de Registros que deve ter por página
	 */
	function __construct($registrosPorPag)
	{
		$this->registrosPorPag	= $registrosPorPag;
	}
	
	/**
	 * O nome da classe já diz tudo
	 * @param	String		$query		Consulta SQL que será utilizada para contar os registros do Banco de Dados
	 * @return	void
	 */
	public function fazTudo($query = NULL)
	{
		global $pdo;
		
		$prepareConsulta	= $pdo->prepare($query);
		
		if(isset($this->camposQuery))
		{
			$prepareConsulta->execute($this->camposQuery);
		}
		else
		{
			$prepareConsulta->execute();
		}
		//Essa não é a melhor maneira de contar as consultas do banco de dados. (Isso ainda será alterado nas versões futuras)
		$quantidadeDeRegistros = $prepareConsulta->rowCount(PDO::FETCH_ASSOC);
		
		
		//Verifica se Precisa de Páginação
		if($quantidadeDeRegistros > $this->registrosPorPag)
		{
			$paginaAtual 			= $this->paginaAtual;
			$registrosPorPag		= $this->registrosPorPag;
			$this->existePaginacao	= TRUE;
			
			$this->qtdDePaginas		= ceil($quantidadeDeRegistros/$this->registrosPorPag);
			
			//Se Pagina Atual for maior do que 1, significa que existe uma página antes
			if($paginaAtual > 1)
			{
				$this->paginaAnterior		= $this->paginaAtual - 1;
				$this->existePaginaAnterior	= TRUE;
			}
			
			//Se a página atual for menor que a quantidade de páginas, significa que ainda existe uma página posterior
			if ($paginaAtual < $this->qtdDePaginas)
			{
				$this->paginaPosterior			= $this->paginaAtual + 1;
				$this->existePaginaPosterior	= TRUE;
			}
			
			$registrosDe			= ($paginaAtual - 1) * $registrosPorPag;
			
			$this->limiteSql		= "LIMIT {$registrosDe}, {$registrosPorPag}";
		}
	}
	
	//Métodos Sets
	/***
	 * @param	array	$campos		Campos a serem usados na consulta SQL
	 */
	public function setCampos($campos)
	{
		$this->camposQuery = $campos;
	}
	
	public function setPagAtual($pagina)
	{
		$this->paginaAtual = $pagina;
	}
	
	public function setRegistrosPorPag($registros)
	{
		$this->registrosPorPag = $registros;
	}
	
	/**
	 * @param	integer		$paginas	Quantidade de Páginas que você deseja que sejam listadas
	 */
	public function setQtdDePaginasExibidas($paginas)
	{
		$this->qtdDePaginasExibidas = $paginas;
	}
	
	//Métodos GET              
	public function getPaginaAnterior()
	{
		return $this->paginaAnterior;
	}
	           
	public function getPaginaAtual()
	{
		return $this->paginaAtual;
	}
	                
	public function getPaginaPosterior()
	{
		return $this->paginaPosterior;
	}
	                
	
	public function getLimiteSql()
	{
		return $this->limiteSql;
	}
	
	public function getExistePaginacao()
	{
		return $this->existePaginacao;
	}
	
	public function getExistePaginaAnterior()
	{
		return $this->existePaginaAnterior;
	}
	
	public function getExistePaginaPosterior()
	{
		return $this->existePaginaPosterior;
	}

	public function getPagInicio()
	{
		return $this->pagInicio;
	}
	
	public function getQtdDePaginasExibidas()
	{
		return $this->qtdDePaginasExibidas;
	}
}

/*
* $paginacao	= new Paginacao(2);
* $pagAtual	= $_GET['pagina'];
* $pagAtual	= (empty($pagAtual) || $pagAtual < 1) ? 1 : $pagAtual;
* $paginacao->setPagAtual($pagAtual);
* $paginacao->setRegistrosPorPag(2);
* $paginacao->fazTudo("SELECT * FROM user_loja");
* $limitSQL = $paginacao->getLimiteSql();
* 
* if($paginacao->getExistePaginacao())
* {
* 	if($paginacao->getExistePaginaAnterior())
* 	{
* 		$tpl->paginaAnterior	= $paginacao->getPaginaAnterior();
* 		$tpl->block("BLOCK_PAGINA_ANTERIOR");
* 	}
* 	
* 	if ($paginacao->getExistePaginaPosterior())
* 	{
* 		$tpl->paginaPosterior	= $paginacao->getPaginaPosterior();
* 		$tpl->block("BLOCK_PAGINA_POSTERIOR");
* 	}
* 	
* 	for ($i = $paginacao->getPagInicio(); $i < $paginacao->getQtdDePaginasExibidas(); $i++)
* 	{
* 		$tpl->pagina	= $i;
* 		$tpl->block("BLOCK_PAGINA", TRUE);
* 	}
* 	
* 	$tpl->block("BLOCK_PAGINACAO");
* }
*/
?>