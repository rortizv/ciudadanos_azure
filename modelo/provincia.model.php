<?php
class ProvinciaModel
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

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM provincia");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new Provincia();

				$alm->__SET('cod_provincia', $r->cod_provincia);
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

	public function Obtener($cod_provincia)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM provincia WHERE cod_provincia = ?");
			         
			$stm->execute(array($cod_provincia));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new Provincia();

			$alm->__SET('cod_provincia', $r->cod_provincia);
			$alm->__SET('nombre_provincia', $r->nombre_provincia);
			

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($cod_provincia)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM provincia WHERE cod_provincia = ?");			          

			$stm->execute(array($cod_provincia));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Provincia $data)
	{
		try 
		{
			$sql = "UPDATE provincia SET 
						   nombre_provincia = ?
					WHERE  cod_provincia = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre_provincia'),
					$data->__GET('cod_provincia')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Provincia $data)
	{
		try 
		{
		$sql = "INSERT INTO provincia (nombre_provincia) 
		        VALUES (?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre_provincia')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}