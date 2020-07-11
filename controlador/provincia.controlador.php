<?php
class Provincia
{
	private $cod_provincia;
	private $nombre_provincia;
	
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}