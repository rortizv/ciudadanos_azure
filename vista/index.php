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

// if(isset($_REQUEST['action']))
// {
// 	switch($_REQUEST['action'])
// 	{
// 		case 'actualizar':
// 			$alm->__SET('cod_provincia',     $_REQUEST['cod_provincia']);
// 			$alm->__SET('nombre_provincia',  $_REQUEST['nombre_provincia']);
		
// 			$model->Actualizar($alm);
			
//             header('Location:provincia.php');
// 			break;

// 		case 'registrar':
// 			$alm->__SET('nombre_provincia',  $_REQUEST['nombre_provincia']);

// 			$model->Registrar($alm);
// 			header('Location: provincia.php');
// 			break;

// 		case 'eliminar':
// 			$model->Eliminar($_REQUEST['cod_provincia']);
// 			header('Location: provincia.php');
// 			break;

// 		case 'editar':
// 			$alm = $model->Obtener($_REQUEST['cod_provincia']);
// 			break;
// 	}
// }
?>
</br>
<div class="container">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" width="640" height="460" src="../img/paisaje.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" width="640" height="460" src="../img/soleado.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" width="640" height="460" src="../img/nieve.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

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

