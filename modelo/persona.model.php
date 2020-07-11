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
			print("Error connecting to SQL Server.");
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
			
			$stm = $this->pdo->prepare("SELECT per.numero_doc,per.nombre,per.apellidos,per.edad,muni.nombre_municipio,										provi.nombre_provincia
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
			          ->prepare("SELECT per.numero_doc,per.nombre,per.apellidos,per.edad,per.fecha_nacimiento,							  muni.nombre_municipio,provi.nombre_provincia
 										FROM municipio as muni
 										INNER JOIN persona as per ON muni.cod_municipio=per.fk_persona_cod_municipio
										INNER JOIN provincia as provi ON muni.fk_cod_provincia=provi.cod_provincia WHERE numero_doc = ?");
			         
			$stm->execute(array($numero_doc));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new Persona();

			$alm->__SET('numero_doc', $r->numero_doc);
			$alm->__SET('nombre', $r->nombre);
			$alm->__SET('apellidos', $r->apellidos);
			$alm->__SET('fecha_nacimiento', $r->fecha_nacimiento);
			$alm->__SET('nombre_municipio', $r->nombre_municipio);

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
						   nombre = ?,
						   apellidos=?,
						   fecha_nacimiento=?
						   
					WHERE  numero_doc = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'),
					$data->__GET('apellidos'),
					$data->__GET('numero_doc'),
					$data->__GET('fecha_nacimiento'),
					 
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Distrito $data)
	{
		try 
		{
		$sql = "INSERT INTO distrito (nombre_distrito,cod_distrito,fk_cod_provincia) 
		        VALUES (?,?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre_municipio'),
				$data->__GET('cod_distrito'),
				$data->__GET('fk_cod_provincia')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}