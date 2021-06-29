<?php
class SocioModel extends Modelo
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
    =======================================================
     Funcion donde vamos a insertar datos del Socio
    =======================================================
  */

  public function insertarSocio($datos)
  {
    /*
    =================================================================================
     INSERT INTO Socio (id_socio_proveedor,producto,stock,valor,medida,estado)
     VALUES ('1','sss','5','120.22','ki','activo')
    =================================================================================
    */

     $consulta=$this->db->connect()->prepare("INSERT INTO socio (fecha_inicio,cedula,nombre,apellido,telefono,correo,direccion)VALUES (:fecha_inicio,:cedula,:nombre,:apellido,:telefono,:correo,:direccion)");
    try {
      //variable para alamcenar el query, cojiendo el nombre d ela base de datos y utilizacndo la funcion connect()
      //interna no por default, y preparamos el codigo sql
      //executamos e indicamosque va con quien
      $consulta->execute(['fecha_inicio'=>$datos['fecha_inicio'],'cedula'=>$datos['cedula'],'nombre'=>$datos['nombre'],'apellido'=>$datos['apellido'] ,'telefono'=>$datos['telefono'] ,'correo'=>$datos['correo'],'direccion'=>$datos['direccion']]);
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
  public function buscarSocio($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM socio WHERE cedula=:cedula AND estado='activo'");
    try {
      $consulta->execute(['cedula'=>$datos['cedula']]);
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
