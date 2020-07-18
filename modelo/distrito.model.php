<?php
class DistritoModel
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

	public function ListMunicipio(){
		$sql=("SELECT * FROM municipio");
		try{
				$resultado=array();
				$consulta=$this->pdo->prepare("SELECT * FROM municipio");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $datosConsulta)
				{
					$almacenado = new Distrito();

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
	public function ListarProvincia(){
		$sql=("SELECT * FROM censo_derecho");
		try{
				$resultado=array();
				$consulta=$this->pdo->prepare("SELECT * FROM censo_derecho");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $datosConsulta)
				{
					$almacenado = new Distrito();

					$almacenado->__SET('id_censo_derecho', $datosConsulta->id_censo_derecho);
					//$almacenado->__SET('cod_provincia', $datosConsulta->cod_provincia);

					$resultado[] = $almacenado;
				}
			return $resultado;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
			
	}


	public function ListarDerecho(){
		$sql=("SELECT * FROM censo_hecho");
		try{
				$resultado=array();
				$consulta=$this->pdo->prepare("SELECT * FROM censo_hecho");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $datosConsulta)
				{
					$alm_municipio = new Distrito();

					$alm_municipio->__SET('id_censo_hecho', $datosConsulta->id_censo_hecho);
					//$alm_municipio->__SET('cod_municipio', $datosConsulta->cod_municipio);

					$resultado[] = $alm_municipio;
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
			
			$stm = $this->pdo->prepare("SELECT distri.cod_distrito,distri.nombre_distrito,provi.nombre_provincia,
										muni.nombre_municipio 
										FROM 	municipio as muni
										inner join provincia as provi 
										ON muni.fk_cod_provincia=provi.cod_provincia
										inner join distrito  as distri 
										ON muni.cod_municipio=distri.fk_cod_municipio");

		 	$stm->execute();
		 	
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new Distrito();

				$alm->__SET('cod_distrito', $r->cod_distrito);
				$alm->__SET('nombre_distrito', $r->nombre_distrito);
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

	public function Obtener($cod_distrito)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM distrito WHERE cod_distrito = ?");
			         
			$stm->execute(array($cod_distrito));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new Distrito();

			$alm->__SET('cod_distrito', $r->cod_distrito);
			$alm->__SET('nombre_distrito', $r->nombre_distrito);

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($cod_distrito)
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

	public function Actualizar(Distrito $data)
	{
		try 
		{
			$sql = "UPDATE distrito SET 
						   nombre_distrito = ?
					WHERE  cod_distrito = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre_distrito'),
					$data->__GET('cod_distrito')
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
		$sql = "INSERT INTO distrito (nombre_distrito,fk_cod_municipio,fk_id_censo_hecho,fk_id_censo_derecho) 
		        VALUES (?,?,?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre_distrito'),
				$data->__GET('fk_cod_municipio'),
				$data->__GET('fk_id_censo_hecho'),
				$data->__GET('fk_id_censo_derecho')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}