<?php
/**
* Olá, sou o Stan_Framework, um Framework MVC sem muito compromisso.
* Fui feito apenas para facilitar a organização dos projetos
* desenvolvidos pelo meu Desenvolvedor, mas ele 
* decidiu abrir o meu código para o público.
* Espero ser útil. Minha documentação é escassa, pois
* Abelardo ainda não teve tempo de escreve-la.
* Então se vira, playboy.
*
* @author Abelardo D. Álvares <abelardod.com@gmail.com>
* @version 0.7.0
*/
class Stan_Porra
{
	public $nome;
	public $nome_dissecado;
	public $nome_pasta;
	public $nome_pagina;
	public $identificador = NULL;

	function __construct($nome)
	{
		$this->nome 			= $nome;
		$this->nome_dissecado	= explode(".", $nome);


		$this->nome_pasta		= $this->nome_dissecado['0'];
		
		$conta_nome_dissecado = count($this->nome_dissecado);

		if($conta_nome_dissecado == 3 && is_numeric($this->nome_dissecado['2']))
		{
			$this->nome_pagina   = $this->nome_dissecado['1'];
			$this->identificador = $this->nome_dissecado['2'];
			
		}
		elseif ($conta_nome_dissecado == 3 && !is_numeric($this->nome_dissecado['2'])) 
		{
			$this->nome_pasta += $this->nome_dissecado['1'];
			$this->nome_pagina = $this->nome_dissecado['2'];
		}
		elseif ($conta_nome_dissecado == 1) 
		{
			$this->nome_pagina = "index";
		}
		else
		{
			$this->nome_pagina = $this->nome_dissecado['1'];
		}

	}

	/**
	* Faz a mágica acontecer
	*/
	public function doMagic()
	{
		$this->verificaTemplate();

		$tpl = new Template("templates/{$this->nome_pasta}/{$this->nome_pagina}.html");

			$identificador = (isset($this->identificador)) ? $this->identificador : NULL;

			//Verifica se o Modelo existe e inclui-o
			if(file_exists("modelo/{$this->nome_pasta}/{$this->nome_pagina}.php"))
			{
				include "modelo/{$this->nome_pasta}/{$this->nome_pagina}.php";
			}

			//Verifica se a classe existe e inclui-a
			if(file_exists("controlador/{$this->nome_pasta}/classe.php"))
			{
				include "controlador/{$this->nome_pasta}/classe.php";
			}

			//Verifica se o Controlador existe e inclui-o
			if(file_exists("controlador/{$this->nome_pasta}/{$this->nome_pagina}.php"))
			{
				include "controlador/{$this->nome_pasta}/{$this->nome_pagina}.php";
			}

			

		$tpl->show();

	}

	/**
	* Verifica se o Template existe
	*/
	public function verificaTemplate()
	{

		if(!file_exists("templates/{$this->nome_pasta}/{$this->nome_pagina}.html"))
		{
			header("Location: /404.html");
			exit();
		}
	}

}
?>