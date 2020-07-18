<?php
class Distrito
{
	private $cod_distrito;
	private $nombre_distrito;
	private $cod_municipio;
 	private $id_censo_derecho;
	private $id_censo_hecho;
	private $nombre_municipio;
	private $fk_cod_provincia;
 	
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
