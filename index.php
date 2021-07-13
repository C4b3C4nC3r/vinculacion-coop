<?php
//base de datps
require_once 'libs/basedatos.php';
//controlador basico
require_once 'libs/controller.php';
//vista basico
require_once 'libs/view.php';
//model basico
require_once 'libs/model.php';
//app
require_once 'libs/app.php';
//lib sin app, sino login
require_once 'libs/applogin.php';
//configuraciones
require_once 'config/config.php';
/*PREGUNTAMOS SI HAY UN CUENTA INICIADA
*/
session_start();
if (isset($_SESSION['id_usuario'])) {
  //echo $_SESSION['id_usuario'];
  //objeto app AxAxAx...
  $app = new App();//es lapagina d einicio....
}else{
  // Sirve Netamente para que el usuario pueda inciar session
  $app = new AppLogin();//onjeto nuevo
}
?>
