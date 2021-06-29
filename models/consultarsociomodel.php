<?php
//referencia
include_once 'models/mapas.php';//mapeo y ovjeto socio
/**
*CLASE DE PRODUCTO, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado 26/05/2021
 */
class ConsultarSocioModel extends Modelo //nos estnendemos al modelo de libs/model
{
   /*
    =======================================================
     Funcion de constructor| Pariete::_constructor 
    =======================================================
  */

  public function __construct()
  {
    // pariente
    parent::__construct();
  }
 /*
    =======================================================
     Funcion darSocio sin parametros | Arreglo Vacios
    =======================================================
  */
  public function darSocio()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT *  FROM socio WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new SocioMap();//objeto
        //valores del array<-$row
        $item->id_socio=$row['id_socio'];//propiedades
        $item->fecha_inicio=$row['fecha_inicio'];
        $item->cedula=$row['cedula'];
        $item->nombre=$row['nombre'];
        $item->apellido=$row['apellido'];
        $item->telefono=$row['telefono'];
        //$item->telefono=$row['telefono'];
        $item->correo=$row['correo'];
        $item->direccion=$row['direccion'];
        $item->estado=$row['estado'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  } 
/*
  ==========================================
   Funcion hallarSocio sin parametros 
  ==========================================
*/
  
  public function hallarSocio($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT *
        FROM socio
        WHERE estado!='eliminado'
        AND (cedula LIKE '%$buscar%'
        OR fecha_inicio LIKE '%$buscar%'
        OR apellido LIKE '%$buscar%'
        OR nombre LIKE '%$buscar%'
        OR correo LIKE '%$buscar%'
        OR telefono LIKE '%$buscar%'
        OR direccion LIKE '%$buscar%')");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new SocioMap();//objeto
        //$item= new SocioMap();//objeto

        $item->id_socio=$row['id_socio'];//propiedades
        $item->fecha_inicio=$row['fecha_inicio'];
        $item->apellido=$row['apellido'];
        $item->cedula=$row['cedula'];
        $item->nombre=$row['nombre'];
        $item->correo=$row['correo'];
        //$item->celular=$row['celular'];
        $item->telefono=$row['telefono'];
        $item->direccion=$row['direccion'];
        $item->estado=$row['estado'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }
  /*
    =================================================================
     Funcion que mostrara el registro con su ID antes de Actualizar 
    =================================================================
  */
  public function darPorId($id)
  {
    $item= new SocioMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT *  FROM socio WHERE id_socio=:id_socio");//consulta
    try {
      $consulta->execute(['id_socio'=>$id]);//execucion
      //recorrer resultado
      while ($row=$consulta->fetch()) {
        $item->id_socio=$row['id_socio'];//propiedades
        $item->fecha_inicio=$row['fecha_inicio'];
        $item->cedula=$row['cedula'];
        $item->nombre=$row['nombre'];
        $item->apellido=$row['apellido'];
        $item->telefono=$row['telefono'];
        //$item->telefono=$row['telefono'];
        $item->correo=$row['correo'];
        $item->direccion=$row['direccion'];
        $item->estado=$row['estado'];

        // regresar objeto
        return $item;
      }
    } catch (PDOException $e) {//caso que nofuncione
      return null;//returnamos null
    }
  }
  /*
    ====================================================================
     Funcion que actualizara  la tabla | hara la busqueda de la cedula 
    ====================================================================
  */
  //update actualizar
  public function update($item)//parametro del item(contiene los POST nuevos), un array
  {
    //buscamos una cedula igual
  $consulta=$this->db->connect()->prepare("SELECT id_socio FROM socio WHERE id_socio!=:id_socio AND cedula=:cedula AND estado=:estado");
  try {
    $consulta->execute(['cedula'=>$item['cedula'],'id_socio'=>$item['id_socio'],'estado'=>$item['estado']]);
    //ifelse
    if ($row=$consulta->fetch()) {
      // code...
      $id_socio=$row['id_socio'];//id
      $consulta=$this->db->connect()->prepare("UPDATE socio SET apellido=:apellido,nombre=:nombre,correo=:correo,telefono=:telefono,direccion=:direccion,estado=:estado WHERE id_socio='$id_socio'");//actualizar
      //
      try {
        $consulta->execute(['nombre'=>$item['nombre'],'correo'=>$item['correo'],'apellido'=>$item['apellido'],'telefono'=>$item['telefono'],'direccion'=>$item['direccion'],'estado'=>$item['estado']]);//executamos
        //return en true
        if ($this->delete($item['id_socio'])) {
            //return en true
            return true;
        }
      } catch (PDOException $e) {
        //retornamos falso
        return false;
      }
    }else{
      //consulta
      $consulta=$this->db->connect()->prepare("UPDATE socio SET cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono,correo=:correo,direccion=:direccion,estado=:estado WHERE id_socio=:id_socio");//actualizar
      try {
        $consulta->execute(['id_socio'=>$item['id_socio'],'cedula'=>$item['cedula'],'nombre'=>$item['nombre'],'apellido'=>$item['apellido'],'telefono'=>$item['telefono'],'correo'=>$item['correo'],'direccion'=>$item['direccion'],'estado'=>$item['estado']]);
        return true;//retornamostrue para que mande una accion
      } catch (PDOException $e) {
        return false;//etornamos false para idnicar errores
      }
    }
  }catch (PDOException $e) {
      return false;
    }
  }
  /*
    =========================================================================================
     Funcion Delete que Eliminara  la tabla por su ID | CONTIENE PARAMETRO (id)
    =========================================================================================
  */
  
  
  public function delete($id)//parametro
  {
    //eliminar
    $consulta=$this->db->connect()->prepare("UPDATE socio SET estado='eliminado' WHERE id_socio=:id_socio");//actualizar
    try {
      $consulta->execute(['id_socio'=>$id]);
      return true;//retornamos
    } catch (PDOException $e) {
      return false;//retronamos
    }
  }
   /*
    =========================================================================================
     Funcion darSocio sin parametros | y muestra el estado del socio
    =========================================================================================
  */
  
  public function estadoSocio($estado)
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->prepare("SELECT * FROM socio WHERE estado=:estado");//consulta sencilla
    try {
      $consulta->execute(['estado'=>$estado]);

      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new SocioMap();//objeto
        //$item= new SocioMap();//objeto

        //valores del array<-$row
        $item->id_socio=$row['id_socio'];//propiedades
        $item->fecha_inicio=$row['fecha_inicio'];
        $item->cedula=$row['cedula'];
        $item->nombre=$row['nombre'];
        $item->apellido=$row['apellido'];
        $item->telefono=$row['telefono'];
        $item->correo=$row['correo'];
        $item->direccion=$row['direccion'];
        $item->estado=$row['estado'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }
}
 ?>
