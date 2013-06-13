<?php
/**
* Classe Utilizada para Realizar upload
* @author Abelardo D. Álvares <abelardod.com@gmail.com
* @version 1.0.0
*/
class Upload_Component
{

	public $maxSize = 65000000;

	public $to;

	public $size, $file, $type, $tmp, $newName;

	/**
	* @param String $pasta Diretório aonde será feito o upload
	*/
	function __construct($pasta)
	{
		$this->to = $pasta;
	}

	/**
	* Define o prefixo do nome do arquivo
	* @param String $to String que será o prefixo do nome do arquivo
	*/
	public function to($to)
	{
		$this->to .= $to;
	}

	
	/**
	* Prepara a bagaça
	* @param FILE $field Nome do campo do arquivo que está sendo enviado pelo formulário
	*/
	public function prepare($field)
	{
		$this->file		= $_FILES[$field]['name'];
		$this->size		= $_FILES[$field]['size'];
		$this->type		= $_FILES[$field]['type'];
		$this->tmp		= $_FILES[$field]['tmp_name'];
	}




	public function newName($mime)

	{

		$random = rand(0,800);

		$this->newName = substr(md5($this->file.$random),0,5).".".$mime;

	}



	public function copy($type)

	{

		if($this->file)

		{

			$this->newName($type);

			copy($this->tmp, $this->to.$this->newName);

				return true;

		}

	}

	/**
	* Realiza a checagem do mime-type do arquivo
	* @param Array 		$array 	Array com os mime-types permitidos
	* @return boolean		
	*/
	public function isOk($array)
	{
		return in_array($this->type, $array);
	}


	public function doUpload()
	{
		$ext = substr($this->file, -3);
			if($this->size > $this->maxSize)
			{
				return false;
			}
			else
			{
				$this->copy($ext);
			}
	}

	

	public function getName()

	{

		return $this->newName;

	}

}
/*
$upload = new Upload_component("../../imagem-empresa/");
$upload->prepare('imagem');
$upload->to('fotos');

if($upload->isOk(array('image/png', 'image/jpeg', 'image/gif')))
{
	$upload->doUpload();
	
	$imagem = $upload->getName();
}
*/
?>