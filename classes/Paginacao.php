<?php
/**
* Esta Classe � respons�vel por realizar pagina��o
* @author Abelardo D. �lvares
* @version 0.8.0
*/
class Paginacao
{
	private $registrosPorPag;	//Quantidade de Registros que devem aparecer por p�gina
	
	private $qtdDePaginas; 	// Quantidade de P�ginas que existem de registros
	
	private $qtdDePaginasExibidas	= 5; // Quantidade de P�ginas a serem Exibidas
	
	private $pagInicio				= 1; //P�gina que se inicia a contagem das p�ginas

	private $camposQuery;
	
	private $paginaAnterior;
	
	private $paginaAtual;
	
	private $paginaPosterior;
	
	private $query; 
	
	private $limiteSql;
	
	private $existePaginacao 		= FALSE; // Variavel Booleana
	
	private $existePaginaAnterior	= FALSE; // Vari�vel que indica se existe p�gina Anterior a Atual
	
	private $existePaginaPosterior	= FALSE; //Vari�vel que indica se existe p�gina Posteior a Atual
	
	/**
	 * @param	integer		$qtdDeRegistros		Quantidade de Registros que deve ter por p�gina
	 */
	function __construct($registrosPorPag)
	{
		$this->registrosPorPag	= $registrosPorPag;
	}
	
	/**
	 * O nome da classe j� diz tudo
	 * @param	String		$query		Consulta SQL que ser� utilizada para contar os registros do Banco de Dados
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
		//Essa n�o � a melhor maneira de contar as consultas do banco de dados. (Isso ainda ser� alterado nas vers�es futuras)
		$quantidadeDeRegistros = $prepareConsulta->rowCount(PDO::FETCH_ASSOC);
		
		
		//Verifica se Precisa de P�gina��o
		if($quantidadeDeRegistros > $this->registrosPorPag)
		{
			$paginaAtual 			= $this->paginaAtual;
			$registrosPorPag		= $this->registrosPorPag;
			$this->existePaginacao	= TRUE;
			
			$this->qtdDePaginas		= ceil($quantidadeDeRegistros/$this->registrosPorPag);
			
			//Se Pagina Atual for maior do que 1, significa que existe uma p�gina antes
			if($paginaAtual > 1)
			{
				$this->paginaAnterior		= $this->paginaAtual - 1;
				$this->existePaginaAnterior	= TRUE;
			}
			
			//Se a p�gina atual for menor que a quantidade de p�ginas, significa que ainda existe uma p�gina posterior
			if ($paginaAtual < $this->qtdDePaginas)
			{
				$this->paginaPosterior			= $this->paginaAtual + 1;
				$this->existePaginaPosterior	= TRUE;
			}
			
			$registrosDe			= ($paginaAtual - 1) * $registrosPorPag;
			
			$this->limiteSql		= "LIMIT {$registrosDe}, {$registrosPorPag}";
		}
	}
	
	//M�todos Sets
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
	 * @param	integer		$paginas	Quantidade de P�ginas que voc� deseja que sejam listadas
	 */
	public function setQtdDePaginasExibidas($paginas)
	{
		$this->qtdDePaginasExibidas = $paginas;
	}
	
	//M�todos GET              
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