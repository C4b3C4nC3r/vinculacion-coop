<?php

class ProveedorModel extends Modelo
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
  ==================================================
  Funcion que busca un Objeto igual al que se esta registrado
  ==================================================
  */
  public function objetoPorHallar($datos)
  {
    /*
    =============================================================
      Si el producto y la medida son iguales se actualiza...
    =============================================================
    */

    $consulta=$this->db->connect()->prepare("SELECT id_proveedor FROM proveedor WHERE ruc=:ruc AND estado='activo'");
    try {
      //executamos
      $consulta->execute(['ruc'=>$datos['ruc']]);
      //while para estraer la informacion
      if ($row=$consulta->fetch()) {
        //guardar variables solo aqui...
        $id_proveedor=$row['id_proveedor'];//id
        //consulta hara lapreparaciond e la actualizacion
        $consulta=$this->db->connect()->prepare("UPDATE proveedor SET nombre=:nombre,correo=:correo,telefono=:telefono,direccion=:direccion WHERE id_proveedor='$id_proveedor'");//actualizar
        //nuevo
        try {
          $consulta->execute(['nombre'=>$datos['nombre'],'correo'=>$datos['correo'],'telefono'=>$datos['telefono'],'direccion'=>$datos['direccion']]);//executamos
          //return en true
          return true;
        } catch (PDOException $e) {
          //retornamos falso
          return false;
        }
      }
    } catch (PDOException $e) {
      return false;
    }
    /*
    =================================================
     Caso que no, se tendria crear un nuevo registro
    =================================================
    */
  }
  /*
    ======================================================
     Funcion que sirve para Insertar datos del Proveedor
    ======================================================
    */
  public function insertarProveedor($datos){
    /*
    =============================================================================================
      INSERT INTO Proveedor (id_proveedor_proveedor,producto,stock,valor,medida,estado)
      VALUES ('1','sss','5','120.22','ki','activo')
    =============================================================================================
    */
    try {
      /*
      ==================================================================================================================
      Variable para alamcenar el query, cojiendo el nombre d ela base de datos y utilizacndo la funcion connect()
      //interna no por default, y preparamos el codigo sql
      ===================================================================================================================
      */
      $consulta=$this->db->connect()->prepare("INSERT INTO proveedor (ruc,nombre,telefono,correo,direccion)VALUES (:ruc,:nombre,:telefono,:correo,:direccion)");
      //executamos e indicamosque va con quien
      $consulta->execute(['ruc'=>$datos['ruc'],'nombre'=>$datos['nombre'],'telefono'=>$datos['telefono'],'correo'=>$datos['correo'],'direccion'=>$datos['direccion']]);
      //return cuando sea afirmativa, caso que no
      return true;
    } catch (PDOException $e) {
      //mostramos el false
      return false;
    }
  }
  /*============================================================================
  FUNCION PARA BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  public function buscarProveedor($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM proveedor WHERE ruc=:ruc AND estado='activo'");
    try {
      $consulta->execute(['ruc'=>$datos['ruc']]);
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
