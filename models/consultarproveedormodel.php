<?php
//referencia
include_once 'models/mapas.php';//mapeo y ovjeto material
/**
*CLASE DE PRODUCTO, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado
 */
class ConsultarProveedorModel extends Modelo //nos estnendemos al modelo de libs/model
{
  /*
    =======================================================
     Funcion dconstructor| Pariete::_constructor 
    =======================================================
  */
//consructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
  /*
    =======================================================
     Funcion darProveedor sin parametros | Arreglo Vacios
    =======================================================
  */
  public function darProveedor()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM proveedor WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new ProveedorMap();//objeto
        //valores del array<-$row
        $item->id_proveedor=$row['id_proveedor'];//propiedades
        $item->ruc=$row['ruc'];
        $item->nombre=$row['nombre'];
        $item->telefono=$row['telefono'];
        $item->correo=$row['correo'];
        $item->direccion=$row['direccion'];
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
     Funcion hallarProveedor sin parametros 
    ==========================================
  */
  public function hallarProveedor($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT *
        FROM proveedor
        WHERE estado!='eliminado'
        AND (ruc LIKE '%$buscar%'
        OR nombre LIKE '%$buscar%'
        OR correo LIKE '%$buscar%'
        OR telefono LIKE '%$buscar%'
        OR direccion LIKE '%$buscar%')");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new ProveedorMap();//objeto
        //$item= new ProveedorMap();//objeto

        $item->id_proveedor=$row['id_proveedor'];//propiedades
        //$item->tipo_proveedor=$row['tipo_proveedor'];
        $item->ruc=$row['ruc'];
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
    $item= new ProveedorMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT * FROM proveedor WHERE id_proveedor=:id_proveedor");//consulta
    try {
      $consulta->execute(['id_proveedor'=>$id]);//execucion
      //recorrer resultado
      while ($row=$consulta->fetch()) {
        $item->id_proveedor=$row['id_proveedor'];
        $item->ruc=$row['ruc'];
        $item->nombre=$row['nombre'];
        $item->telefono=$row['telefono'];
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
    =========================================================================================
     Funcion que actualizara  la tabla | hara la busqueda de la cedula | contiene parametros
    =========================================================================================
  */
  //update actualizar
  public function update($item)//parametro del item(contiene los POST nuevos), un array
  {
    //buscamos una ceula igual
    $consulta=$this->db->connect()->prepare("SELECT id_proveedor FROM proveedor WHERE id_proveedor!=:id_proveedor AND ruc=:ruc AND estado=:estado");
    try {
      $consulta->execute(['ruc'=>$item['ruc'],'id_proveedor'=>$item['id_proveedor'],'estado'=>$item['estado']]);
      //ifelse
      if ($row=$consulta->fetch()) {
        // code...
        $id_proveedor=$row['id_proveedor'];//id
        $consulta=$this->db->connect()->prepare("UPDATE proveedor SET nombre=:nombre,correo=:correo,telefono=:telefono,direccion=:direccion,estado=:estado WHERE id_proveedor='$id_proveedor'");//actualizar
        //
        try {
          $consulta->execute(['nombre'=>$item['nombre'],'correo'=>$item['correo'],'telefono'=>$item['telefono'],'direccion'=>$item['direccion'],'estado'=>$item['estado']]);//executamos
          //return en true
          if ($this->delete($item['id_proveedor'])) {
              //return en true
              return true;
          }
        } catch (PDOException $e) {
          //retornamos falso
          return false;
        }
      }else{
      //Consulta
        $consulta=$this->db->connect()->prepare("UPDATE proveedor SET ruc=:ruc,nombre=:nombre,telefono=:telefono,correo=:correo,direccion=:direccion,estado=:estado WHERE id_proveedor=:id_proveedor");//actualizar
        try {
          $consulta->execute(['id_proveedor'=>$item['id_proveedor'],'ruc'=>$item['ruc'],'nombre'=>$item['nombre'],'telefono'=>$item['telefono'],'correo'=>$item['correo'],'direccion'=>$item['direccion'],'estado'=>$item['estado']]);
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
    ==========================================================================================================================
     Funcion deliminar con parametros |ESTA ES UNA TABLA CON REFERENCIA A LA TABLA MATERIAL... ASI QUE NO SE PUEDE ELIMINAR
                                      |REGISTROS, ENTONCES SE DEBE QUEDAR EN OPCIONES COMO INACTIVO, O SUSPENDIDO
    ==========================================================================================================================
  */
  
  public function delete($id)//parametro
  {
    //eliminar
    $consulta=$this->db->connect()->prepare("UPDATE proveedor SET estado='eliminado' WHERE id_proveedor=:id_proveedor");//actualizar
    try {
      $consulta->execute(['id_proveedor'=>$id]);
      return true;//retornamos
    } catch (PDOException $e) {
      return false;//retronamos
    }
  }
  /*
    =========================================================================================
     Funcion darProveedor sin parametros | y muestra el estado del proveedor
    =========================================================================================
  */
  //funcion darProveedor sin parametros
  public function estadoProveedor($estado)
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->prepare("SELECT * FROM proveedor WHERE estado=:estado");//consulta sencilla
    try {
      $consulta->execute(['estado'=>$estado]);

      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new ProveedorMap();//objeto
        //$item= new ProveedorMap();//objeto
        //valores del array<-$row
        //$item->id_material=$row['id_material'];//propiedades
        $item->id_proveedor=$row['id_proveedor'];
        $item->ruc=$row['ruc'];
        $item->nombre=$row['nombre'];
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
