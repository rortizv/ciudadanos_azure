<?php
class Persona
{
	private $numero_doc;
	private $nombre;
	private $apellidos;
 	private $fecha_nacimiento;
 	private $tipo_doc;
	private $edad;
	private $estatura;
	private $lugar_nacimiento;
 	private $situacion_militar;
 	private $sexo;
 	private $nivel_de_estudios;
 	private $fk_persona_cod_municipio;
 	private $nombre_municipio;
 	private $nombre_provincia;
 	private $cod_municipio;
 	private $fecha;
 	
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
