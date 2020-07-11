<?php
class Municipio
{
	private $cod_municipio;
	private $nombre_municipio;
	//private $cod_provincia;
 	private $nombre_provincia;
 	private $fk_cod_provincia;
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
