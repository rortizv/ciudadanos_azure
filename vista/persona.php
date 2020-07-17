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

			$alm->__SET('numero_doc',                $_REQUEST['numero_doc']);
			$alm->__SET('nombre',                    $_REQUEST['nombre']);
		    $alm->__SET('apellidos',                 $_REQUEST['apellidos']);
            $alm->__SET('fecha_nacimiento',          $_REQUEST['fecha_nacimiento']);
            $alm->__SET('tipo_doc',                  $_REQUEST['tipo_doc']);
            $alm->__SET('edad',                      $_REQUEST['edad']);
            $alm->__SET('estatura',                  $_REQUEST['estatura']);
            $alm->__SET('sexo',                      $_REQUEST['sexo']);
            $alm->__SET('nivel_de_estudios',         $_REQUEST['nivel_de_estudios']);
            $alm->__SET('situacion_militar',         $_REQUEST['situacion_militar']);
            $alm->__SET('fk_persona_cod_municipio',  $_REQUEST['fk_persona_cod_municipio']);

               
                      

			$model->Actualizar($alm);
			header('Location:persona.php');
             
			break;

		case 'registrar':
			$alm->__SET('numero_documento',             $_REQUEST['numero_documento']);
            $alm->__SET('nombre',                       $_REQUEST['nombre']);
            $alm->__SET('apellidos',                    $_REQUEST['apellidos']);
            $alm->__SET('fecha_nacimiento',             $_REQUEST['fecha_nacimiento']);
            $alm->__SET('tipo_doc',                     $_REQUEST['tipo_doc']);
            $alm->__SET('edad',                         $_REQUEST['edad']);
            $alm->__SET('estatura',                     $_REQUEST['estatura']);
            $alm->__SET('situacion_militar',            $_REQUEST['situacion_militar']);
            $alm->__SET('sexo',                         $_REQUEST['sexo']);
            $alm->__SET('nivel_de_estudios',            $_REQUEST['nivel_de_estudios']);
            $alm->__SET('fk_persona_cod_municipio',     $_REQUEST['fk_persona_cod_municipio']);


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
                <div class="container  mb-6 col-12l">
                    <form id="formulario" class="form-inline" action="?action=<?php echo $alm->numero_doc > 0 ? 'actualizar' : 'registrar'; ?>" method="post" >
                        <div class="form-row mb-2">
                            <label for="staticEmail2"  >Documento</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="numero_documento" type="text" class="form-control" value="<?php echo $alm->__GET('numero_doc'); ?>">
                        </div>
                        <div class="form-row mb-2">
                            <label for="staticEmail2"  >Nombre</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="nombre" type="text" class="form-control" value="<?php echo $alm->__GET('nombre'); ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="staticEmail2"  >Apellidos</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="apellidos" type="text" class="form-control" value="<?php echo $alm->__GET('apellidos'); ?>">
                        </div>
                  
                        <div class="container"> 
                            <div class="dropdown-divider"></div>
                        <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                        </div>
      
                </div> 

                        <div class="container">
                            <div class="row">
                                <div class="col ">
                                    <label>Situación Militar</label>                                   
                                </div> 
                                <div class="col  ">
                                      <label>Lugar de Nacimiento</label>                        
                                </div>
                                <div class="col ">
                                      <label>Tipo de Documento</label>                        
                                </div>
                            </div>
                             <div class="row">
                                <div class="col ">
                                  <select  name="situacion_militar" class="form-control">
                                      <option value="<?php echo $alm->__GET('situacion_militar');?>">
                                        <?php echo $alm->__GET('situacion_militar');?>
                                      </option>
                                      <option>DEFINIDA</option>
                                      <option>SIN DEFINIR</option>
                                      <option>NO APLICA</option>
                                  </select>
                                </div> 
                                <div class="col">
                                    <select name="fk_persona_cod_municipio" class="form-control">
                                        <option value=" <?php echo $alm->__GET('cod_municipio');?>" selected>
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
                                <div class="col ">
                                  <select  name="tipo_doc" class="form-control">
                                      <option value="<?php echo $alm->__GET('tipo_doc');?>">
                                        <?php echo $alm->__GET('tipo_doc');?>
                                      </option>
                                      <option>Cedula</option>
                                      <option>Cedula de Extanjeria</option>
                                      <option>NO APLICA</option>
                                  </select>
                                </div>
                            </div>
                        </div>

                           <div class="container">
                            <div class="row">
                                <div class="col ">
                                    <label>Edad</label>                                   
                                </div> 
                                <div class="col  ">
                                      <label>Estatura</label>                        
                                </div>
                                <div class="col ">
                                      <label>Sexo</label>                        
                                </div>
                            </div>
                             <div class="row">
                                <div class="col ">
                                    <input min="0" max="120" class="form-control" type="text" value="<?php echo $alm->__GET('edad');?>" name="edad">
                                 </div> 
                                <div class="col">
                                    <input class="form-control" type="text" value="<?php echo $alm->__GET('estatura');?>" name="estatura"> 
                                </div>
                                <div class="col ">
                                    <select   name="sexo" class="form-control">
                                      <option value="<?php echo $alm->__GET('sexo');?>">
                                        <?php echo $alm->__GET('sexo');?>
                                      </option>
                                      <option>HOM</option>
                                      <option>MUJ</option>
                                      <option>ND</option>
                                  </select>      
                                </div>
                            </div>
                        </div>
                    </br>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label>Fecha de Nacimiento</label>
                            </div>
                              <div class="col">
                                <label>Nivel de Estudios</label>
                            </div>
                         </div>
                          <div class="row">
                            <div class="col">
                                <input placeholder="DD/MM/AAAA" type="text" pattern="(?:((?:0[1-9]|1[0-9]|2[0-9])\/(?:0[1-9]|1[0-2])|(?:30)\/(?!02)(?:0[1-9]|1[0-2])|31\/(?:0[13578]|1[02]))\/(?:19|20)[0-9]{2})" required
                                name="fecha_nacimiento" value="<?php echo $alm->__GET('fecha_nacimiento');?>" class="form-control">
                         </div>
                              <div class="col">
                                <select  name="nivel_de_estudios" class="form-control">
                                      <option value="<?php echo $alm->__GET('nivel_de_estudios');?>">
                                        <?php echo $alm->__GET('nivel_de_estudios');?>
                                      </option>
                                      <option>Primaria</option>
                                      <option>Secundaria</option>
                                      <option>Superior</option>
                                      <option>Universitario</option>
                                  </select>                                
                            </div>
                         </div>

                    </div>
                </br>
                        <div class="container"> 
                             <div class="col-12">
                            
                          
                               <button type="submit" class="btn btn-primary mb-2" value="Reset">Guardar</button>
                                <input class="form-control" type="hidden" name="numero_doc" value="<?php echo $alm->__GET('numero_doc'); ?>" />
                             </div> 
                        </div> 
                    </form>
                </div>
                <div class="container">
                <div class="dropdown-divider"></div>
                    <!-- En este DIV Colocamos una linea divisora para dar una presentacion a los datos -->
                </div>
            </br>
                <table style="margin: auto; width: 800px; border-collapse: separate; border-spacing: 5px 5px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Documento</th>
                            <th style="text-align:left;">Nombre Completo</th>
                            <th style="text-align:left;">Edad</th>
                            <th style="text-align:left;">Lugar de Nacimiento</th>
                            <th style="text-align:left;">Situación Militar</th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('numero_doc'); ?></td>
                            <td><?php echo $r->__GET('nombre'); echo " "; echo $r->__GET('apellidos');?></td>
                            <td><?php echo $r->__GET('edad'); ?></td>
                            <td><?php echo $r->__GET('nombre_municipio');echo "-";echo $r->__GET('nombre_provincia');?></td>
                            <td><?php echo $r->__GET('situacion_militar'); ?></td>
                            <td>
                                <a href="?action=editar&numero_doc=<?php echo $r->numero_doc; ?>"><button   type="submit" class="btn btn-warning">Editar</button></a>
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
