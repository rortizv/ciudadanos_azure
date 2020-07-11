<?php
class CensoHecho
{
	private $id_censo_hecho;
    private $fecha_inicio_residencia;
    private $direccion;
    private $pais_residencia;
	
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}