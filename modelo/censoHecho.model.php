<?php
class CensoHechoModel
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

			$stm = $this->pdo->prepare("SELECT * FROM censo_hecho");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoHecho();

				$alm->__SET('id_censo_hecho', $r->id_censo_hecho);
                $alm->__SET('fecha_inicio_residencia', $r->fecha_inicio_residencia);
                $alm->__SET('direccion', $r->direccion);
                $alm->__SET('pais_residencia', $r->pais_residencia);
				 

				$result[] = $alm;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id_censo_hecho)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM censo_hecho WHERE id_censo_hecho = ?");
			         
			$stm->execute(array($id_censo_hecho));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new CensoHecho();

			$alm->__SET('id_censo_hecho', $r->id_censo_hecho);
            $alm->__SET('fecha_inicio_residencia', $r->fecha_inicio_residencia);
            $alm->__SET('direccion', $r->direccion);
            $alm->__SET('pais_residencia', $r->pais_residencia);
			

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id_censo_hecho)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM censo_hecho WHERE id_censo_hecho = ?");			          

			$stm->execute(array($id_censo_hecho));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(CensoHecho $data)
	{
		try 
		{
			$sql = "UPDATE censo_hecho SET 
					        fecha_inicio_residencia = ?,
                            direccion = ?,
                            pais_residencia = ?
                    WHERE  id_censo_hecho = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
                    $data->__GET('fecha_inicio_residencia'),
                    $data->__GET('direccion'),
					$data->__GET('pais_residencia'),
					$data->__GET('id_censo_hecho')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(CensoHecho $data)
	{
		try 
		{
		$sql = "INSERT INTO censo_hecho (fecha_inicio_residencia,direccion,pais_residencia)
		        VALUES (?,?,?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('fecha_inicio_residencia'),
                $data->__GET('direccion'),
                $data->__GET('pais_residencia')
				)
            );
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}