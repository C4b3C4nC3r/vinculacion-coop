<?php

/**
*Revisado el 26/05/2021 9:15pm
*CLASE DE MATERIALMODEL, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class UsuarioModel extends Modelo//extiende a modelo
{
 /*
    =======================================================
     Funcion de constructor| Pariete::_constructor
    =======================================================
  */
  public function __construct()
  {

    parent::__construct();
  }
   /*
  ===========================================================================
   Funcion de insertar el material con parametros del array de datos
  ===========================================================================
  */

  public function insertarUsuario($datos){
    /*
    ==============================================================================
    INSERT INTO material (id_proveedor,producto,stock,valor,medida,estado)
    VALUES ('1','sss','5','120.22','ki','activo')
    ===============================================================================
    */
    try {
      /*
      =================================================================================================================
       variable para alamcenar el query, cojiendo el nombre d ela base de datos y utilizacndo la funcion connect()
       interna no por default, y preparamos el codigo sql
      ==================================================================================================================
      */
      $consulta=$this->db->connect()->prepare("INSERT INTO usuario (usuario,nombre_usuario,clave)VALUES (:usuario,:nombre_usuario,:clave)");
      //executamos e indicamosque va con quien
      $consulta->execute(['usuario'=>$datos['usuario'],'nombre_usuario'=>$datos['nombre_usuario'],'clave'=>$datos['clave']]);
      //return cuando sea afirmativa, caso que no
      return true;
    } catch (PDOException $e) {
      //mostramos el false
      return false;
    }
    //echo "$datos";
  }
  /*============================================================================
  FUNCION PARA BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  public function buscarUsuario($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM usuario WHERE usuario=:usuario AND estado='activo'");
    try {
      $consulta->execute(['usuario'=>$datos['usuario']]);
      if ($row=$consulta->fetch()) {
        // code...
        return true;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
}


 ?>
