<!doctype html>
<html lang="en">
<style>
    #nuevo_registro{
        display: none;
    }
</style>
<?php
//error_reporting(0);
require_once '../controlador/censoDistritalDerecho.controlador.php';
require_once '../modelo/censoDistritalDerecho.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new CensoDistritalDerecho();
$model = new CensoDistritalDerechoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id_censo_derecho_dis',     $_REQUEST['id_censo_derecho_dis']);
            $alm->__SET('id_fecha_registro',  $_REQUEST['id_fecha_registro']);
            
            
		
			$model->Actualizar($alm);
			
            header('Location:censoDistritalDerecho.php');
			break;

		case 'registrar':
            $alm->__SET('id_fecha_registro',  $_REQUEST['id_fecha_registro']);
            $alm->__SET('fk_id_censo_derecho',  $_REQUEST['fk_id_censo_derecho']);

			$model->Registrar($alm);
			header('Location: censoDistritalDerecho.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id_censo_derecho_dis']);
			header('Location: censoDistritalDerecho.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id_censo_derecho_dis']);
			break;
	}
}
?>
</br>
<div class="container">
    <div class="container  mb-2 col-6">
    <div id="guardar">
               <form id="formulario" class="form-inline"
                action="?action=<?php echo $alm->id_censo_derecho_dis > 0 ? 'actualizar' : 'registrar'; ?>" method="post">
            
                <div class="form-group mb-2">
                    <label for="staticEmail2">Fecha registro: </label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input name="id_fecha_registro" type="date" data-date-format="yyyy/mm/dd" class="form-control" id="id_fecha_registro"
                        aria-describedby=" " value="<?php echo $alm->__GET('id_fecha_registro'); ?>">
                </div>

                <!-- <div class="form-group mb-2">
                    <label for="staticEmail2">Id Censo Der: </label>
                </div> 
                <div class="form-group mx-sm-3 mb-2">
                    <input name="id_censo_derecho" type="text" class="form-control" id="id_censo_derecho"
                        aria-describedby=" " value="<?php echo $alm->__GET('id_censo_derecho'); ?>">
                </div> -->

                

                <div class="form-group mx-sm-3 mb-2">
                <select name="fk_id_censo_derecho"class="form-control">
                                <?php 
                                
                                echo "<option selected>Elegir Fecha</option>";
                                foreach($model->ListarCensoDerecho() as $r): ?>
                                    <option value="<?php echo $r->__GET('id_censo_derecho');
                                    ?>">
                                    <?php echo $r->__GET('fecha_registro'); ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
                
                <!-- <button type="reset" class="btn btn-success mb-2" onclick="ocultar();mostrar()">Nuevo registro</button> -->
            </div>
           
             
            <div class="dropdown-divider form-group mx-sm-3 mb-2"></div>
        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                    
                        
                
             
            <input class="form-control" type="hidden" name="id_censo_derecho_dis"
                value="<?php echo $alm->__GET('id_censo_derecho_dis'); ?>" />
        </form>
    </div>
    <div class="container">
        <div class="dropdown-divider"></div>
        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
    </div>
    <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
        <thead>
            <tr>
                <th style="text-align:left;">ID Censo Dist Der</th>
                <th style="text-align:left;">Fecha dis</th>
                <th style="text-align:left;">Direccion</th>
                <th style="text-align:left;">Fecha hecho</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <?php foreach($model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->__GET('id_censo_derecho_dis'); ?></td>
            <td><?php echo $r->__GET('id_fecha_registro'); ?></td>
            <td><?php echo $r->__GET('direccion'); ?></td>
            <td><?php echo $r->__GET('fecha_registro'); ?></td>
            <td>
                     <a href="?action=editar&id_censo_derecho_dis=<?php echo $r->id_censo_derecho_dis; ?>"><button type="submit"
                        class="btn btn-warning">Editar</button></a>

                <a href="?action=eliminar&id_censo_derecho_dis=<?php echo $r->id_censo_derecho_dis; ?>"><button type="submit"
                        class="btn btn-danger">Eliminar</button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
 include "script.php";
?>
<script>
     
    function ocultar(){
        document.getElementById('guardar').style.display="none";
        
    }
    function mostrar(){
        document.getElementById('nuevo_registro').style.display="block";
        
    }
    

</script>

</script>

</html>