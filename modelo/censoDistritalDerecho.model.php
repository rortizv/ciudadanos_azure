<?php
class CensoDistritalDerechoModel
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
			
			$stm = $this->pdo->prepare("
				SELECT cdder.id_censo_derecho_dis,ceder.direccion,cdder.id_fecha_registro,ceder.fecha_registro 
				FROM censo_distrital_derecho cdder
				INNER JOIN censo_derecho ceder ON cdder.fk_id_censo_derecho=ceder.id_censo_derecho");
		 	$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoDistritalDerecho();

				$alm->__SET('id_censo_derecho_dis', $r->id_censo_derecho_dis);
				$alm->__SET('direccion', $r->direccion);
				$alm->__SET('id_fecha_registro', $r->id_fecha_registro);
				$alm->__SET('fecha_registro', $r->fecha_registro);
								 
				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function ListarCensoDerecho()
	{
		try
		{
			$result = array();
			
			$stm = $this->pdo->prepare("SELECT * FROM censo_derecho");
		 	$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoDistritalDerecho();

				$alm->__SET('id_censo_derecho', $r->id_censo_derecho);
				$alm->__SET('fecha_registro', $r->fecha_registro);
				$alm->__SET('direccion', $r->direccion);
								 
				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}




	public function Obtener($id_censo_derecho_dis)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM censo_distrital_derecho WHERE id_censo_derecho_dis = ?");
			         
			$stm->execute(array($id_censo_derecho_dis));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new CensoDistritalDerecho();

			$alm->__SET('id_censo_derecho_dis', $r->id_censo_derecho_dis);
            $alm->__SET('id_fecha_registro', $r->id_fecha_registro);
            

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	/*public function Eliminar($id_censo_derecho_dis)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM censo_istrital_derecho WHERE id_censo_derecho_dis = ?");			          

			$stm->execute(array($id_censo_derecho_dis));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}*/

	public function Actualizar(CensoDistritalDerecho $data)
	{
		try 
		{
			$sql = "UPDATE censo_distrital_derecho SET 
						   id_fecha_registro = ?
					WHERE  id_censo_derecho_dis = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('id_fecha_registro'),
					$data->__GET('id_censo_derecho_dis')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(CensoDistritalDerecho $data)
	{
		try 
		{
		$sql = "INSERT INTO censo_distrital_derecho (id_fecha_registro,fk_id_censo_derecho) 
		        VALUES (?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('id_fecha_registro'),
				$data->__GET('fk_id_censo_derecho')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}