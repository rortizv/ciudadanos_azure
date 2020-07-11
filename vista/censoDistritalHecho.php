<!doctype html>
<html lang="en">
<style>
    #nuevo_registro{
        display: none;
    }
</style>
<?php
//error_reporting(0);
require_once '../controlador/censoDistritalHecho.controlador.php';
require_once '../modelo/censoDistritalHecho.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new CensoDistritalHecho();
$model = new CensoDistritalHechoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id_censo_hecho_dis',     $_REQUEST['id_censo_hecho_dis']);
            $alm->__SET('id_fecha_registro_hecho',  $_REQUEST['id_fecha_registro_hecho']);
            $alm->__SET('fk_id_censo_hecho',  $_REQUEST['fk_id_censo_hecho']);
            
		
			$model->Actualizar($alm);
			
            header('Location:censoDistritalHecho.php');
			break;

		case 'registrar':
            $alm->__SET('id_censo_hecho_dis',     $_REQUEST['id_censo_hecho_dis']);
            $alm->__SET('id_fecha_registro_hecho',  $_REQUEST['id_fecha_registro_hecho']);
            $alm->__SET('fk_id_censo_hecho',  $_REQUEST['fk_id_censo_hecho']);

			$model->Registrar($alm);
			header('Location: censoDistritalHecho.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id_censo_hecho_dis']);
			header('Location: censoDistritalHecho.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id_censo_hecho_dis']);
			break;
	}
}
?>
</br>
<div class="container">
    <div class="container  mb-2 col-6">
    <div id="guardar">
               <form id="formulario" class="form-inline"
                action="?action=<?php echo $alm->id_censo_hecho_dis > 0 ? 'actualizar' : 'registrar'; ?>" method="post">
            
                <div class="form-group mb-2">
                    <label for="staticEmail2">Fecha registro: </label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input name="id_fecha_registro_hecho" type="date" data-date-format="yy/mm/dd" class="form-control" id="id_fecha_registro_hecho"
                        aria-describedby=" " value="<?php echo $alm->__GET('id_fecha_registro_hecho'); ?>">
                </div>

                

                <div class="form-group mx-sm-3 mb-2">
                    <select name="fk_id_censo_hecho"class="form-control">
                                <?php 
                                
                                echo "<option selected>Elegir Fecha</option>";
                                foreach($model->ListarCensoHecho() as $r): ?>
                                    <option value="<?php echo $r->__GET('id_censo_hecho');
                                    ?>">
                                    <?php echo $r->__GET('fecha_inicio_residencia'); ?>
                                    </option>

                                <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>

                
                
                <!-- <button type="reset" class="btn btn-success mb-2" onclick="ocultar();mostrar()">Nuevo registro</button> -->
            </div>
           
             
            <div class="dropdown-divider form-group mx-sm-3 mb-2"></div>
        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                    
                        
                
             
            <input class="form-control" type="hidden" name="id_censo_hecho_dis"
                value="<?php echo $alm->__GET('id_censo_hecho_dis'); ?>" />
        </form>
    </div>
    <div class="container">
        <div class="dropdown-divider"></div>
        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
    </div>
    <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
        <thead>
            <tr>
                <th style="text-align:left;">Fecha Hecho</th>
                <th style="text-align:left;">Fecha Inic Resid</th>
                <th style="text-align:left;">Direccion</th>
                <th style="text-align:left;">País resid</th>
            </tr>
        </thead>
        <?php foreach($model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->__GET('id_fecha_registro_hecho'); ?></td>
            <td><?php echo $r->__GET('fecha_inicio_residencia'); ?></td>
            <td><?php echo $r->__GET('direccion'); ?></td>
            <td><?php echo $r->__GET('pais_residencia'); ?></td>
            <td>
                     <a href="?action=editar&id_censo_hecho_dis=<?php echo $r->id_censo_hecho_dis; ?>"><button type="submit"
                        class="btn btn-warning">Editar</button></a>
            
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