<?php

/**
*CLASE DE MODELO, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class Modelo {

  function __construct()
  {
    // objeto
    $this->db=new BaseDatos();//nueva base de datos
  }


}



 ?>
