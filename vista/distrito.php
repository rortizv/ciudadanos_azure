<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/distrito.controlador.php';
require_once '../modelo/distrito.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new Distrito();
$model = new DistritoModel();
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('cod_distrito',     $_REQUEST['cod_distrito']);
			$alm->__SET('nombre_distrito',  $_REQUEST['nombre_distrito']);
		
			$model->Actualizar($alm);
			header('Location:distrito.php');
             
			break;

		case 'registrar':
			$alm->__SET('nombre_distrito',  $_REQUEST['nombre_distrito']);
            $alm->__SET('fk_cod_municipio',  $_REQUEST['fk_cod_municipio']);
            $alm->__SET('fk_id_censo_hecho',  $_REQUEST['fk_id_censo_hecho']);
            $alm->__SET('fk_id_censo_derecho',  $_REQUEST['fk_id_censo_derecho']);
			$model->Registrar($alm);
			header('Location:distrito.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['cod_distrito']);
			header('Location: distrito.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['cod_distrito']);
			break;
	}
}
?>
</br>
<div class="container">
                <div class="container  mb-2 col-12">
                    <form id="formulario" class="form-inline" action="?action=<?php echo $alm->cod_distrito > 0 ? 'actualizar' : 'registrar'; ?>" method="post" >
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Nombre Distrito </label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="nombre_distrito" type="text" class="form-control" id="Nombre" aria-describedby=" " value="<?php echo $alm->__GET('nombre_distrito'); ?>">
                        </div>    
                        <div class="form-group mx-sm-2 mb-1">
                            
                            <select name="fk_id_censo_derecho" class="form-control" required>
                                <?php 
                                
                                echo "<option selected>Elegir Id Censo Derecho</option>";
                                foreach($model->ListarProvincia() as $resultado): ?>
                                    <option value="<?php 
                                    echo $resultado->__GET('id_censo_derecho');
                                    ?>">
                                    <?php echo $resultado->__GET('id_censo_derecho'); ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group mx-sm-2 mb-1">
                            
                            <select name="fk_id_censo_hecho" class="form-control">
                                <?php 
                                
                                echo "<option selected>Elegir Id Censo Hecho</option>";
                                foreach($model->ListarDerecho() as $resultado): ?>
                                    <option value="<?php 
                                    echo $resultado->__GET('id_censo_hecho');
                                    ?>">
                                    <?php echo $resultado->__GET('id_censo_hecho'); ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group mx-sm-2 mb-1">
                            
                            <select name="fk_cod_municipio" class="form-control">
                                <?php 
                                
                                echo "<option selected>Elegir Municipio</option>";
                                foreach($model->ListMunicipio() as $resultado): ?>
                                    <option value="<?php 
                                    echo $resultado->__GET('cod_municipio');
                                    ?>">
                                    <?php echo $resultado->__GET('nombre_municipio'); ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div> 
                           <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
                            <input class="form-control" type="hidden" name="cod_distrito" value="<?php echo $alm->__GET('cod_distrito'); ?>" />
                    </form>
                </div>
                <div class="container">
                    <div class="dropdown-divider"></div>
                    <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                </div>
                <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre Distrito</th>
                            <th style="text-align:left;">Nombre Municipio</th>
                            <th style="text-align:left;">Nombre Provincia</th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('nombre_distrito'); ?></td>
                            <td><?php echo $r->__GET('nombre_municipio'); ?></td>
                            <td><?php echo $r->__GET('nombre_provincia'); ?></td>
                            
                            
                             
                            <td>
                                <a href="?action=editar&cod_distrito=<?php echo $r->cod_distrito; ?>"><button   type="submit" class="btn btn-warning">Editar</button></a>
                            
                                <!-- <a href="?action=eliminar&cod_distrito=<?php echo $r->cod_distrito; ?>"><button  disabled="" type="submit" class="btn btn-danger">Eliminar</button></a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
</div>
<?php
 include "script.php";
?>
<!--  <script>
     
    function recargar(){
        document.getElementById("formulario").reset();
    } 
</script> -->

 </script>
</html>