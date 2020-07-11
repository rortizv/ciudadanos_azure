<?php
class CensoDistritalDerecho
{   
	private $id_censo_derecho_dis;
    private $id_fecha_registro;
    private $fecha_registro;
    private $id_censo_derecho;
    private $fk_id_censo_derecho;
    private $direccion;
    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
