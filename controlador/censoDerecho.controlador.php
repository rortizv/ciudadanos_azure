<?php
class CensoDerecho
{
	private $id_censo_derecho;
    private $fecha_registro;
    private $direccion;
	
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}