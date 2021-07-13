<?php

  /**
  *CLASE DE MAIN, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
   *
   */
  class Main extends Controlador//se extiende al controlador en libs/controller
  {
/*
  ==============================================================================================================
     AJAX Funcion constructor que usa un Render y envia Parametros >> libs/view.php/class/vista/render($nombre)
  ==============================================================================================================
*/
    function __construct()
    {
      // llamamos al pariente __construct
      parent::__construct();
      //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
      //echo "<p>Nuevo Control Main</p>";
    }
    /*
  =========================================================================================
    Funcion render | utiliza $this vista ->render como una funcion con parametro 
  =========================================================================================
*/
    function render()
    {
      $this->vista->render('main/index');//RUTA
      // code...
    }

    /*funcion saludo ej
    function saludo()
    {
      echo "Hola Mundo";
    }
    */
  }



 ?>
