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
			print("Error connecting to SQL Server.");
			die(print_r($e));
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();
			
			$stm = $this->pdo->prepare("SELECT 	distri.cod_distrito,distri.nombre_distrito,muni.nombre_municipio,
									provi.nombre_provincia
									FROM municipio muni
									INNER JOIN provincia provi 
									ON muni.fk_cod_provincia=muni.fk_cod_provincia
									INNER JOIN distrito distri 
									ON distri.fk_cod_municipio=muni.cod_municipio");

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