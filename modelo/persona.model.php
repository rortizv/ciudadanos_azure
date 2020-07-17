<?php

class PersonaModel
{
	private $pdo;
 
	public function __CONSTRUCT()
	{
		try {
			$this->pdo = new PDO("sqlsrv:server = tcp:conteo.database.windows.net,1433; Database = conteo_ciudadano_bd", "administrador", "{Conteo_ciudadano_bd}");
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
			print("Error connecting to Azure SQL.");
			die(print_r($e));
		}
	}
 // en la function siguiente mostramos todos los Municipio para que sean tomados por el usuario

		public function ListarMunicipio(){
		$sql=("SELECT * FROM municipio");
		try{
				$resultado=array();
				$consulta=$this->pdo->prepare("SELECT * FROM municipio");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $datosConsulta)
				{
					$almacenado = new Persona();

					$almacenado->__SET('cod_municipio', $datosConsulta->cod_municipio);
					$almacenado->__SET('nombre_municipio', $datosConsulta->nombre_municipio);

					$resultado[] = $almacenado;
				}
			return $resultado;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
			
	}



	public function Listar()
	{
		try
		{
			$result = array();
			
			$stm = $this->pdo->prepare("SELECT per.tipo_doc,per.numero_doc,per.nombre,per.apellidos,per.edad,
										muni.nombre_municipio,provi.nombre_provincia,per.situacion_militar,
										muni.cod_municipio
 										FROM municipio as muni
 										INNER JOIN persona as per ON muni.cod_municipio=per.fk_persona_cod_municipio
										INNER JOIN provincia as provi ON muni.fk_cod_provincia=provi.cod_provincia");

		 	$stm->execute();
		 	
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new Persona();

				$alm->__SET('numero_doc', $r->numero_doc);
				$alm->__SET('nombre', $r->nombre);
				$alm->__SET('apellidos', $r->apellidos);
				$alm->__SET('edad', $r->edad);
				$alm->__SET('nombre_municipio', $r->nombre_municipio);
				$alm->__SET('nombre_provincia', $r->nombre_provincia);	 
				$alm->__SET('situacion_militar',$r->situacion_militar);
				$alm->__SET('cod_municipio', 	$r->cod_municipio);
				$alm->__SET('tipo_doc', 		$r->tipo_doc);
				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($numero_doc)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT per.fk_persona_cod_municipio,per.estatura,per.sexo,per.nivel_de_estudios,per.tipo_doc,per.numero_doc,per.nombre,per.apellidos,per.edad,convert(varchar, per.fecha_nacimiento, 103) as fecha_nacimiento,muni.nombre_municipio,provi.nombre_provincia,					per.situacion_militar,muni.cod_municipio
 								FROM municipio as muni
 								INNER JOIN persona as per ON muni.cod_municipio=per.fk_persona_cod_municipio
								INNER JOIN provincia as provi ON muni.fk_cod_provincia=provi.cod_provincia 
								WHERE numero_doc = ?");
			         
			$stm->execute(array($numero_doc));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new Persona();

			$alm->__SET('numero_doc', 			$r->numero_doc);
			$alm->__SET('nombre', 				$r->nombre);
			$alm->__SET('apellidos', 			$r->apellidos);
			$alm->__SET('edad', 				$r->edad);
			$alm->__SET('sexo', 				$r->sexo);
			$alm->__SET('estatura', 			$r->estatura);
			$alm->__SET('nivel_de_estudios',	$r->nivel_de_estudios);
			$alm->__SET('fecha_nacimiento', 	$r->fecha_nacimiento);
			$alm->__SET('nombre_municipio', 	$r->nombre_municipio);
			$alm->__SET('situacion_militar', 	$r->situacion_militar);
			$alm->__SET('cod_municipio', 		$r->cod_municipio);
			$alm->__SET('tipo_doc', 			$r->tipo_doc);

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($numero_doc)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM distrito WHERE cod_distrito = ?");			          

			$stm->execute(array($cod_distrito));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Persona $data)
	{
		try 
		{	

			 
			$sql = "UPDATE persona SET
						    
						   nombre 					=?,
						   apellidos				=?,
						   fecha_nacimiento			=?,
						   tipo_doc					=?,
						   edad 					=?,
						   estatura					=?,
						   situacion_militar		=?,
						   sexo 					=?,
						   nivel_de_estudios		=?,
						   fk_persona_cod_municipio	=?
						   
					WHERE  numero_doc = ?";

			 
			$this->pdo->prepare($sql)
			     ->execute(
				array(

						$data->__GET('nombre'),
					 	$data->__GET('apellidos'),
					 	$data->__GET('fecha_nacimiento'),
					 	$data->__GET('tipo_doc'),
					 	$data->__GET('edad'),
					 	$data->__GET('estatura'),
					 	$data->__GET('situacion_militar'),
					 	$data->__GET('sexo'),
					 	$data->__GET('nivel_de_estudios'),
					 	$data->__GET('fk_persona_cod_municipio'),
					 	$data->__GET('numero_doc')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Persona $data)
	{
		try 
		{
		$sql = "INSERT INTO persona 
		        VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('numero_documento'),
			 	$data->__GET('nombre'),
			 	$data->__GET('apellidos'),
			 	$data->__GET('fecha_nacimiento'),
			 	$data->__GET('tipo_doc'),
			 	$data->__GET('edad'),
			 	$data->__GET('estatura'),
			 	$data->__GET('situacion_militar'),
			 	$data->__GET('sexo'),
			 	$data->__GET('nivel_de_estudios'),
			 	$data->__GET('fk_persona_cod_municipio')			 
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}