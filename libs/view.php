<?php

/**
*CLASE DE VISTA, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class Vista {
  //contructor
  function __construct()
  {
    //echo "<p>Vista Base</p>";
  }
  //funcion render que va a renderizar la vista que se necesite en el Index.php
  //por eso debemos de repartir desde la carptea vista con su diciconario de variables

  function render($nombre)//aqui le llegan los parameros de todas las hojas que necesiten renderizar
  {
    //ruta de la vista elejida
    require 'views/' . $nombre . '.php';
    /*por lo general seria el nombre de la carpeta
    ej: carpeta/hoja que quiere ver...
    views/folder/hoja.php... se lo ve, solo hay que poner folder/hoja
    esta funcion ya concatena las cosas que neesita
    */
  }
}



 ?>
