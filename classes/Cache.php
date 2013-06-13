<?php 
/**
* Classe responsável por criar e verificar páginas de caches
* Esta Classe ainda não está pronta
* @author Abelardo D. Álvares
* @version 0.1.0
*/
class Cache
{
	
	public $nomeArquivo;
	public $conteudo;
	

	/**
	* Cria a página
	* @param	<string>	$nomeArquivo	Nome do arquivo a ser criado
	* @param	<string>	$conteudo		Conteúdo a ser colocado no arquivo
	*/
	public function criarCache($nomeArquivo, $conteudo)
	{
		
		return file_put_contents($nomeArquivo, $conteudo);
	}
	
	/**
	* Verifica a data da Página
	* @param	<string>	$nomeArquivo	Nome do arquivo 
	*/
	public function verificaCache($nomeArquivo)
	{
	
		//Verificar
	}

	/**
	* Exclui página do cache
	* @param	<string>	$nomeArquivo	Nome do arquivo 
	*/
	public function excluirCache()
	{
	
	}
}
?>