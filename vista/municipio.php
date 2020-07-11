<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/municipio.controlador.php';
require_once '../modelo/municipio.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new Municipio();
$model = new MunicipioModel();
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('cod_municipio',     $_REQUEST['cod_municipio']);
			$alm->__SET('nombre_municipio',  $_REQUEST['nombre_municipio']);
		
			$model->Actualizar($alm);
			header('Location:municipio.php');
             
			break;

		case 'registrar':
			$alm->__SET('nombre_municipio',  $_REQUEST['nombre_municipio']);
            $alm->__SET('fk_cod_provincia',  $_REQUEST['fk_cod_provincia']);
			$model->Registrar($alm);
			header('Location:municipio.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['cod_municipio']);
			header('Location: municipio.php');
			break;

		case 'editar':
          
			$alm = $model->Obtener($_REQUEST['cod_municipio']);
			break;
	}
}
?>
</br>
<div class="container">
                <div class="container  mb-2 col-8">
                    <form id="formulario" class="form-inline" action="?action=<?php echo $alm->cod_municipio > 0 ? 'actualizar' : 'registrar'; ?>" method="post" >
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Nombre Municipio </label>
                        </div>
                        <div class="form-group mx-sm-3 mb-1">
                            <input name="nombre_municipio" type="text" class="form-control" id="Nombre" aria-describedby=" " value="<?php echo $alm->__GET('nombre_municipio'); ?>">
                        </div>
                        <div class="form-group mx-sm-2 mb-1">
                            
                            <select name="fk_cod_provincia" class="form-control">
                                <?php 
                                //require_once '../modelo/pronvia.model.php';
                                echo "<option selected>Elegir Provincia</option>";
                                foreach($model->ListarProvincia() as $resultado): ?>
                                    <option value="<?php 
                                    echo $resultado->__GET('cod_provincia');
                                    ?>">
                                    <?php echo $resultado->__GET('nombre_provincia'); ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                           
                           <button type="submit" class="btn btn-primary mb-1" value="Reset">Guardar</button>
                             
                    </form>
                </div>
                <div class="container">
                    <div class="dropdown-divider"></div>
                    <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                </div>
                <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Codigo</th>
                            <th style="text-align:left;">Nombre Municipio</th>
                            <th style="text-align:left;">Nombre Provincia</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('cod_municipio'); ?></td>
                            <td><?php echo $r->__GET('nombre_municipio'); ?></td>
                            <td><?php echo $r->__GET('nombre_provincia'); ?></td>
                            <td>
                                <a href="?action=editar&cod_municipio=<?php echo $r->cod_municipio; ?>"><button   type="submit" class="btn btn-warning">Editar</button></a>
                            <!-- //Este Boton funciona pero no sera mostrado para efectos que no pueden ser eliminados los datos ya que la base de datos no lo permite, contiene llaves foraneas -->
                                <!-- <a href="?action=eliminar&cod_municipio=<?php echo $r->cod_municipio; ?>"><button  type="submit" class="btn btn-danger">Eliminar</button></a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
</div>
<?php
 include "script.php";
?>


 </script>
</html>

