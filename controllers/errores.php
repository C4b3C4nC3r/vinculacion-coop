<?php
/**
*CLASE DE ERRORES, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class Errores extends Controlador //se extiende al controlador en libs/controller
{
  /*
  =========================================================================================
     AJAX Funcion con Pariente y constructor que envia un MENSAJE DINAMICO DE ERROR
  =========================================================================================
*/
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //mensaje dinamico
    $url=constant('URL').'main';//link
    $this->vista->mensaje=
    "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error </strong> No se Ha encontrado la Paina que Busca
        <a href='$url'> Ir</a>
    </div>
    ";

    //hacemos la puesta de parametros desde la clase errores y se extiende a controlador para que view haga la funcion render
    $this->vista->render('errores/index');
  //  echo "<p>Error Cragar Field</p>";
  }
}
 ?>
