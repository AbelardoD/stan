<?php
/**
* Classe Utulizada para auxilia na recupera��o de senhas.
* @author Abelardo D. �lvares <abelardod.com@gmail.com
* @version 1.0.0
*/
class RecuperarSenha
{
	private $token;
	public $criterio = NULL;
	private $bancoDeDados;
	private $dataAtual;
	
	function __construct($banco)
	{
		$this->bancoDeDados = $banco;
		$dateTime			= new DateTime();
		$this->dataAtual	= $dateTime->format("Y-m-d");
	}
	
	/**
	 * Adiciona o Pedido de Recupera��o de senha no sistema
	 * 
	 * @param	integer		$idBanco	Campo referente ao id do Usu�rio que est� tentando recuperar a senha.
	 * 
	 * @return	md5			$token		Token gerado pelo sistema
	 */
	public function adicionarRecuperarSenha($idBanco)
	{
		global $pdo;
		$random		= rand(100, 99999999);
		$token		= md5("{$random}{$idBanco}{$this->criterio}{$this->dataAtual}");
		$preparar	= $pdo->prepare("INSERT INTO {$this->bancoDeDados} (`idrecuperar`, `idprimario`, `token`, `data`) VALUES (NULL, ?, ?, ?)");
		//apontar
		$campos		= array($idBanco, $token, $this->dataAtual);
		//Fogo
		$preparar->execute($campos);
		return $token;
	}
	
	/**
	 * Verifica se o Token ainda � v�lido
	 * 
	 * @param	md5			$token		Token do Sistema
	 * 
	 * @return	boolean					Retorna True se o token ainda for v�lido e False Caso contr�rio.
	 */
	public function verificaToken($token)
	{
		global $pdo;
		
		$preparar	= $pdo->prepare("SELECT * FROM {$this->bancoDeDados} WHERE token = ? AND data = ?");
		$campos		= array($token, $this->dataAtual);
		$preparar->execute($campos);
		
		$registros	= (int) $preparar->rowCount(PDO::FETCH_ASSOC);
		
		if($registros == 1)
		{
			return TRUE;
		}
		
		return FALSE;
	}
}
?>