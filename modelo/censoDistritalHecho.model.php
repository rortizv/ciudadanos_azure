<?php
class CensoDistritalHechoModel
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
			
			$stm = $this->pdo->prepare("
				select cendishec.id_fecha_registro_hecho,cenhec.fecha_inicio_residencia,cenhec.direccion,cenhec.pais_residencia,cendishec.id_censo_hecho_dis
				from censo_hecho as cenhec
				inner join censo_distrital_hecho cendishec on cenhec.id_censo_hecho=cendishec.fk_id_censo_hecho");
		 	$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoDistritalHecho();
				$alm->__SET('id_fecha_registro_hecho', $r->id_fecha_registro_hecho);
				$alm->__SET('fecha_inicio_residencia', $r->fecha_inicio_residencia);
				$alm->__SET('direccion', $r->direccion);
				$alm->__SET('pais_residencia', $r->pais_residencia);
				$alm->__SET('id_censo_hecho_dis', $r->id_censo_hecho_dis);
								 
				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function ListarCensoHecho()
	{
		try
		{
			$result = array();
			
			$stm = $this->pdo->prepare("SELECT * FROM censo_hecho");
		 	$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoDistritalHecho();

				$alm->__SET('id_censo_hecho', $r->id_censo_hecho);
				$alm->__SET('id_fecha_registro', $r->id_fecha_registro);
				$alm->__SET('fecha_inicio_residencia', $r->fecha_inicio_residencia);
								 
				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}




	public function Obtener($id_censo_hecho_dis)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM censo_distrital_hecho WHERE id_censo_hecho_dis = ?");
			         
			$stm->execute(array($id_censo_hecho_dis));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new CensoDistritalHecho();

			$alm->__SET('id_censo_hecho_dis', $r->id_censo_hecho_dis);
			$alm->__SET('id_fecha_registro_hecho', $r->id_fecha_registro_hecho);
			$alm->__SET('fk_id_censo_hecho', $r->fk_id_censo_hecho);
            

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	/*public function Eliminar($id_censo_hecho_dis)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM censo_distrital_hecho WHERE id_censo_hecho_dis = ?");			          

			$stm->execute(array($id_censo_hecho_dis));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}*/

	public function Actualizar(CensoDistritalHecho $data)
	{
		try 
		{
			$sql = "UPDATE censo_distrital_hecho SET 
						   id_fecha_registro_hecho = ?,
						   fk_id_censo_hecho = ?
					WHERE  id_censo_hecho_dis = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('id_fecha_registro_hecho'),
					$data->__GET('fk_id_censo_hecho')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(CensoDistritalHecho $data)
	{
		try 
		{
		$sql = "INSERT INTO censo_distrital_hecho (id_fecha_registro_hecho,fk_id_censo_hecho) 
		        VALUES (?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('id_fecha_registro_hecho'),
				$data->__GET('fk_id_censo_hecho')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}