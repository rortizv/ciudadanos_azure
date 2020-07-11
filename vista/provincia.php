<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/provincia.controlador.php';
require_once '../modelo/provincia.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new Provincia();
$model = new ProvinciaModel();
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('cod_provincia',     $_REQUEST['cod_provincia']);
			$alm->__SET('nombre_provincia',  $_REQUEST['nombre_provincia']);
		
			$model->Actualizar($alm);
			header('Location:provincia.php');
             
			break;

		case 'registrar':
			$alm->__SET('nombre_provincia',  $_REQUEST['nombre_provincia']);

			$model->Registrar($alm);
			header('Location: provincia.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['cod_provincia']);
			header('Location: provincia.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['cod_provincia']);
			break;
	}
}
?>
</br>
<div class="container">
                <div class="container  mb-2 col-6">
                    <form id="formulario" class="form-inline" action="?action=<?php echo $alm->cod_provincia > 0 ? 'actualizar' : 'registrar'; ?>" method="post" >
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Nombre Provincia </label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="nombre_provincia" type="text" class="form-control" id="Nombre" aria-describedby=" " value="<?php echo $alm->__GET('nombre_provincia'); ?>">
                        </div>     
                           <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
                            <input class="form-control" type="hidden" name="cod_provincia" value="<?php echo $alm->__GET('cod_provincia'); ?>" />
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
                            <th style="text-align:left;">Nombre Provincia</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('cod_provincia'); ?></td>
                            <td><?php echo $r->__GET('nombre_provincia'); ?></td>
                            <td>
                                <a href="?action=editar&cod_provincia=<?php echo $r->cod_provincia; ?>"><button   type="submit" class="btn btn-warning">Editar</button></a>
                            
                                <a href="?action=eliminar&cod_provincia=<?php echo $r->cod_provincia; ?>"><button  type="submit" class="btn btn-danger">Eliminar</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
</div>

<!-- <div class="container">
    <h5>Opciones</h5>
    <select class="form-control">
        <?php //foreach($model->Listar() as $r): ?>
            <option><?php //echo $r->__GET('nombre_provincia'); ?></option>
        <?php //endforeach; ?>
    </select>

</div> -->

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

