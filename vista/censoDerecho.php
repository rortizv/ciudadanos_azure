<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/censoDerecho.controlador.php';
require_once '../modelo/censoDerecho.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new CensoDerecho();
$model = new CensoDerechoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id_censo_derecho',     $_REQUEST['id_censo_derecho']);
            $alm->__SET('fecha_registro',  $_REQUEST['fecha_registro']);
            $alm->__SET('direccion',  $_REQUEST['direccion']);
		
			$model->Actualizar($alm);
			
            header('Location:censoDerecho.php');
			break;

		case 'registrar':
            $alm->__SET('fecha_registro',  $_REQUEST['fecha_registro']);
            $alm->__SET('direccion',  $_REQUEST['direccion']);

			$model->Registrar($alm);
			header('Location: censoDerecho.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id_censo_derecho']);
			header('Location: censoDerecho.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id_censo_derecho']);
			break;
	}
}
?>
</br>
<div class="container">
    <div class="container  mb-2 col-6">
        <form id="formulario" class="form-inline"
            action="?action=<?php echo $alm->id_censo_derecho > 0 ? 'actualizar' : 'registrar'; ?>" method="post">
            <div class="form-group mb-2">
                <label for="staticEmail2">ID Censo Derecho: </label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input name="id_censo_derecho" type="number" class="form-control" id="id_censo_derecho"
                    aria-describedby=" " value="<?php echo $alm->__GET('id_censo_derecho'); ?>">
            </div>

            <div class="form-group mb-2">
                <label for="staticEmail2">Fecha registro: </label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input name="fecha_registro" type="date" class="form-control" id="fecha_registro"
                    aria-describedby=" " value="<?php echo $alm->__GET('fecha_registro'); ?>">
            </div>

            <div class="form-group mb-2">
                <label for="staticEmail2">Direccion: </label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input name="direccion" type="text" class="form-control" id="direccion"
                    aria-describedby=" " value="<?php echo $alm->__GET('direccion'); ?>">
            </div>

            <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
            <input class="form-control" type="hidden" name="cod_provincia"
                value="<?php echo $alm->__GET('id_censo_derecho'); ?>" />
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
                <th style="text-align:left;">Fecha</th>
                <th style="text-align:left;">Direccion</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <?php foreach($model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->__GET('id_censo_derecho'); ?></td>
            <td><?php echo $r->__GET('fecha_registro'); ?></td>
            <td><?php echo $r->__GET('direccion'); ?></td>
            <td>
                <a href="?action=editar&id_censo_derecho=<?php echo $r->id_censo_derecho; ?>"><button type="submit"
                        class="btn btn-warning">Editar</button></a>

                <a href="?action=eliminar&id_censo_derecho=<?php echo $r->id_censo_derecho; ?>"><button type="submit"
                        class="btn btn-danger">Eliminar</button></a>
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