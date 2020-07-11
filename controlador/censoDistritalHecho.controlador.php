<?php
class CensoDistritalHecho
{   
	private $id_censo_hecho_dis;
    private $id_fecha_registro_hecho;
    private $fk_id_censo_hecho;
    private $pais_residencia;
    private $direccion;
    private $fecha_registro;
    private $fecha_registro_hecho;
    private $id_fecha_registro;
    private $id_censo_hecho;
    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
