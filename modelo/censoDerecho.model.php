<?php
class CensoDerechoModel
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

			$stm = $this->pdo->prepare("SELECT * FROM censo_derecho");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$alm = new CensoDerecho();

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

	public function Obtener($id_censo_derecho)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM censo_derecho WHERE id_censo_derecho = ?");
			         
			$stm->execute(array($id_censo_derecho));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$alm = new CensoDerecho();

			$alm->__SET('id_censo_derecho', $r->id_censo_derecho);
            $alm->__SET('fecha_registro', $r->fecha_registro);
            $alm->__SET('direccion', $r->direccion);
			

			return $alm;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id_censo_derecho)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM censo_derecho WHERE id_censo_derecho = ?");			          

			$stm->execute(array($id_censo_derecho));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(CensoDerecho $data)
	{
		try 
		{
			$sql = "UPDATE censo_derecho SET 
					        fecha_registro = ? ,
                            direccion = ?
                    WHERE  id_censo_derecho = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('id_censo_derecho'),
                    $data->__GET('fecha_registro'),
                    $data->__GET('direccion')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(CensoDerecho $data)
	{
		try 
		{
		$sql = "INSERT INTO censo_derecho (fecha_registro) 
		        VALUES (?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('fecha_registro')
				)
            );
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}