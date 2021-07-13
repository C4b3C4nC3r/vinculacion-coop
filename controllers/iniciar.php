<?php

  /**
  *CLASE DE MAIN, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
   *rebidaosdaskdsak
   */
  class Iniciar extends Controlador//se extiende al controlador en libs/controller
  {

    function __construct()
    {
      // llamamos al pariente __construct
      parent::__construct();
      //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
      //echo "<p>Nuevo Control Iniciar</p>";
    }
    //funcion renderizar
    function render()
    {
      //esta vista con su funcion  renderconel parametro
      $this->vista->render('info/login');//RUTA
      // code...
    }
    /*
    ========================================================================
    AJAX Funcion que llama al Modal y verifica el parentesco usando un POST
    ========================================================================
  */
    function cuenta()
    {
      // POST DE FORMULARIOS DE LAS VISTAS...

      //post delformulario de views/info/login.php
      //post delformulario de views/info/login.php
      if (empty($_POST['usuario'])&&empty($_POST['clave'])) {header("Location: /coop");}
      if ($this->modelo->iniciarCuenta(['usuario'=>$_POST['usuario'],'clave'=>$_POST['clave']])) {
        //si retorna true hacernos
        session_start();
        if (isset($_SESSION['id_usuario'])) {
          //return en AJAX
          ?>
          <meta http-equiv="refresh" content="2;URL=<?php echo constant('URL') ?>"  >
          <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Cuenta Iniciada</strong> <br>Espere unos Momentos segundo para entrar
          </div>
          <?php
          /**/
        }else{
      //return en AJAX
          ?>
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>Datos Incorrecto</strong> Su Clave o Nombre de Usuario son Incorrectas
          </div>
          <?php
        }
      }
    }
    /*
    ====================================================
      Funcion QUE CIERRA LA SESION DE LA CUENTA! 
    ====================================================
  */
    //cerrar cuenta
    function cerrarCuenta()
    {
      //cerrar todas las cessiones
      session_start();
      $id=$_SESSION['id_usuario'];
      if ($this->modelo->salirCuenta($id)) {
          //session_start();
          //unset($_SESSION['id_usuario']);
          session_unset();//sacamos los set de los $_SESSION['']
          session_destroy();//destruimos todas las sessiones
          header("Location: /coop");//retornamos al index
      }
    }
  }



 ?>
