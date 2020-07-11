<!doctype html>
<html lang="en">
<?php
//error_reporting(0);
require_once '../controlador/persona.controlador.php';
require_once '../modelo/persona.model.php';
include "head.php";
include "menu.php";
// Logica
$alm = new Persona();
$model = new PersonaModel();
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('numero_doc',     $_REQUEST['numero_doc']);
			$alm->__SET('nombre',  $_REQUEST['nombre']);
		    $alm->__SET('apellidos',  $_REQUEST['apellidos']);
            $alm->__SET('fecha_nacimiento',  $_REQUEST['fecha_nacimiento']);
            $alm->__SET('fk_persona_cod_municipio',  $_REQUEST['fk_persona_cod_municipio']);
			$model->Actualizar($alm);
			header('Location:persona.php');
             
			break;

		case 'registrar':
			$alm->__SET('nombre',  $_REQUEST['nombre_distrito']);
            $alm->__SET('nombre_distrito',  $_REQUEST['nombre_distrito']);

			$model->Registrar($alm);
			header('Location:persona.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['numero_doc']);
			header('Location: persona.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['numero_doc']);
			break;
	}
}
?>
</br>
<div class="container">
                <div class="container  mb-2 col-9">
                    <form id="formulario" class="form-inline" action="?action=<?php echo $alm->numero_doc > 0 ? 'actualizar' : 'registrar'; ?>" method="post" >
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Nombre</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="nombre" type="text" class="form-control" id="Nombre" aria-describedby=" " value="<?php echo $alm->__GET('nombre'); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Apellidos</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="apellidos" type="text" class="form-control" id="Nombre" aria-describedby=" " value="<?php echo $alm->__GET('apellidos'); ?>">
                        </div>
                        <div>     
                           <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
                            <input class="form-control" type="hidden" name="numero_doc" value="<?php echo $alm->__GET('numero_doc'); ?>" />
                        </div> 
                        <div class="container"> 
                        <div class="dropdown-divider"></div>
                        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                        </div>
      
                        </div>

                        <div class="container">
                             <div class="row">
                                <div class="col ">
                                
                                   <input name="fecha_nacimiento" type="date" class="form-control" data-date-format="yyyy/mm/dd" value="<?php 
                                  
                                    //echo $alm->__GET('fecha_nacimiento');
                                  // echo date_format($recibe,'Y-m-d H:i:s');
                                    
                                   // $cambio=strtotime($recibe);
                                   // $cambio = date('Y-m-d',$cambio);
                                   // echo $cambio;
                                    ?>">
                                </div> 

                                <div class="col order-12">
                                    <select name="fk_persona_cod_municipio" class="form-control">
                                     
                                    
                                        <option selected>
                                        <?php echo $alm->__GET('nombre_municipio');?>
                                        </option>
                                        <?php
                                        foreach($model->ListarMunicipio() as $resultado): ?>
                                            <option value="<?php 
                                            echo $resultado->__GET('cod_municipio');
                                            ?>">
                                            <?php 

                                            echo $resultado->__GET('nombre_municipio'); 

                                            ?>
                                            </option>

                                        <?php endforeach; ?>
                                    </select>                                     
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                <div class="dropdown-divider"></div>
                    <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                </div>
                <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 10px 5px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Documento</th>
                            <th style="text-align:left;">Nombre Completo</th>
                            <th style="text-align:left;">Edad</th>
                            <th style="text-align:left;">Lugar de Nacimiento</th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('numero_doc'); ?></td>
                            <td><?php echo $r->__GET('nombre'); echo " "; echo $r->__GET('apellidos');?></td>
                            <td><?php echo $r->__GET('edad'); ?></td>
                            <td><?php echo $r->__GET('nombre_municipio');echo "-";echo $r->__GET('nombre_provincia');?></td>
                         
                            <td>
                                <a href="?action=editar&numero_doc=<?php echo $r->numero_doc; ?>"><button   type="submit" class="btn btn-warning">Editar</button></a>
                            
                                <!-- <a href="?action=eliminar&numero_doc=<?php echo $r->numero_doc; ?>"><button  disabled="" type="submit" class="btn btn-danger">Eliminar</button></a> -->
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

