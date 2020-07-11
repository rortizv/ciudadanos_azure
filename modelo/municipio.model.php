<?php
 

class MunicipioModel
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

	public function ListarProvincia(){
		$sql=("SELECT * FROM provincia");
		try{
				$resultado=array();
				$consulta=$this->pdo->prepare("SELECT * FROM provincia");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $datosConsulta)
				{
					$almacenado = new Municipio();

					$almacenado->__SET('nombre_provincia', $datosConsulta->nombre_provincia);
					$almacenado->__SET('cod_provincia', $datosConsulta->cod_provincia);

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
			
			$stm = $this->pdo->prepare("SELECT muni.cod_municipio,muni.nombre_municipio,provi.nombre_provincia 
										FROM municipio muni
										INNER JOIN provincia provi 
										ON muni.fk_cod_provincia=provi.cod_provincia");

		 	$stm->execute();
		 	
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new Municipio();

				$alm->__SET('cod_municipio', $r->cod_municipio);
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

	public function Obtener($cod_municipio)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM municipio WHERE cod_municipio = ?");
			         
			$stm->execute(array($cod_municipio));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new Municipio();

			$alm->__SET('cod_municipio', $r->cod_municipio);
			$alm->__SET('nombre_municipio', $r->nombre_municipio);

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($cod_municipio)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM municipio WHERE cod_municipio = ?");			          

			$stm->execute(array($cod_municipio));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Municipio $data)
	{
		try 
		{
			$sql = "UPDATE municipio SET 
						   nombre_municipio = ?
					WHERE  cod_municipio = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre_municipio'),
					$data->__GET('cod_municipio')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




	public function Registrar(Municipio $data)
	{
		try 
		{

		$sql = "INSERT INTO municipio (nombre_municipio,fk_cod_provincia) 
		        VALUES (?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre_municipio'),
				$data->__GET('fk_cod_provincia')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}