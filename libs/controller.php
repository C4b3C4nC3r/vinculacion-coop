<?php
/*
*CLASE DE CONTROLADOR, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
*/

class Controlador {
  //contructor
  function __construct()
  {
  //echo "<p> Controlador Basico</p>";
  //esta vista va a tener una nueva vista
    $this->vista = new Vista();

  }
  //aqui se puede poner funiones adicionales de algunos controladores controllers/x.php
  //funcion para modelos
  function cargarModelo($modelo)
  {
    //direccion
    $url = 'models/'.$modelo.'model.php';
    //si hay una direccion
    if (file_exists($url)) {
      //lamamos a la direccion
      require $url;
      //buscamos el nombre del modelo
      $nombreModelo = $modelo.'Model';
      //nuevo modelo
      $this->modelo=new $nombreModelo();//nos sirve para cargar losmodelos y as funciones del modelo
    }
  }
}



 ?>
