<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/censoHecho.controlador.php';
require_once '../modelo/censoHecho.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new CensoHecho();
$model = new CensoHechoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id_censo_hecho',     $_REQUEST['id_censo_hecho']);
            $alm->__SET('fecha_inicio_residencia',  $_REQUEST['fecha_inicio_residencia']);
            $alm->__SET('direccion',  $_REQUEST['direccion']);
            $alm->__SET('pais_residencia',  $_REQUEST['pais_residencia']);
		
			$model->Actualizar($alm);
			
            header('Location:censoHecho.php');
			break;

		case 'registrar':
            $alm->__SET('id_censo_hecho',  $_REQUEST['id_censo_hecho']);
            $alm->__SET('fecha_inicio_residencia',  $_REQUEST['fecha_inicio_residencia']);
            $alm->__SET('direccion',  $_REQUEST['direccion']);
            $alm->__SET('pais_residencia',  $_REQUEST['pais_residencia']);

			$model->Registrar($alm);
			header('Location: censoHecho.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id_censo_hecho']);
			header('Location: censoHecho.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id_censo_hecho']);
			break;
	}
}
?>
</br>
<div class="container">
    <div class="container  mb-2 col-6">
        <form id="formulario" class="form-inline"
            action="?action=<?php echo $alm->id_censo_hecho > 0 ? 'actualizar' : 'registrar'; ?>" method="post">
            
            <div class="form-group mb-2">
                <label for="staticEmail2">Fecha inicio residencia: </label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input name="fecha_inicio_residencia" type="date" class="form-control" id="fecha_inicio_residencia"
                    aria-describedby=" " value="<?php echo $alm->__GET('fecha_inicio_residencia'); ?>">
            </div>

            <div class="form-group mb-2">
                <label for="staticEmail2">Direccion: </label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input name="direccion" type="text" class="form-control" id="direccion"
                    aria-describedby=" " value="<?php echo $alm->__GET('direccion'); ?>">
            </div>

            <div class="form-group mb-2">
                <label for="staticEmail2">Pais residencia: </label>
            </div>
       
            <div class="form-group mx-sm-3 mb-2">
                <input name="pais_residencia" type="text" class="form-control" id="pais_residencia"
                    aria-describedby=" " value="<?php echo $alm->__GET('pais_residencia'); ?>">
            </div>

            <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
            <input class="form-control" type="hidden" name="id_censo_hecho"
                value="<?php echo $alm->__GET('id_censo_hecho'); ?>" />
        </form>
    </div>
    <div class="container">
        <div class="dropdown-divider"></div>
        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
    </div>
    <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
        <thead>
            <tr>
                <th style="text-align:left;">ID Censo Derecho</th>
                <th style="text-align:left;">Fecha inicio resid</th>
                <th style="text-align:left;">Direccion</th>
                <th style="text-align:left;">País resid</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <?php foreach($model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->__GET('id_censo_hecho'); ?></td>
            <td><?php echo $r->__GET('fecha_inicio_residencia'); ?></td>
            <td><?php echo $r->__GET('direccion'); ?></td>
            <td><?php echo $r->__GET('pais_residencia'); ?></td>
            <td>
                <a href="?action=editar&id_censo_hecho=<?php echo $r->id_censo_hecho; ?>"><button type="submit"
                        class="btn btn-warning">Editar</button></a>

                <a href="?action=eliminar&id_censo_hecho=<?php echo $r->id_censo_hecho; ?>"><button disabled="" type="submit"
                        class="btn btn-danger ">Eliminar</button></a>
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