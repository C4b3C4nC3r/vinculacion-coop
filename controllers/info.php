<?php

/**
*CLASEDE Material, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado el 2021/05/26
 */
class Info extends Controlador //se extiende al controlador en libs/controller
{
  /*
  ===========================================================
      Funcion que usamos para llamar un pariente _construct 
  ===========================================================
*/
  //constructor
  function __construct()
  {
    // code...
    // llamamos al pariente __construct
    parent::__construct();
    //mensaje en vista
    $this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
  }
  //fun render
  function render()
  {
    //renderuzar
    $this->vista->render('info/index');
  }
  /*
  =========================================================================================
     AJAX Funcion con parametros que usa un POST para cambiar la clave de los LOGIN
  =========================================================================================
*/
  function cambiarClave()
  {
    //mandamos al model para realizar el cambio
    if ($this->modelo->nuevaClave(['clave'=>$_POST['clave'],'id_usuario'=>$_SESSION['id_usuario']])) {

      session_start();
      //cambiamos los valores en session
      $_SESSION['clave']=$_POST['clave'];
      if (isset($_SESSION['clave'])) {
        // code...
      ?>
      <hr>
      <div id="alert" class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Nueva Clave Ingresada</strong> Su Clave de Usuario Se Ha Actualizado Correctamente
      </div>
      <?php
      }
    }
  }
}


 ?>
