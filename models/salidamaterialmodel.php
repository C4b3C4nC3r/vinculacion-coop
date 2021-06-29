<?php
include_once 'models/mapas.php';//m
class SalidaMaterialModel extends Modelo//extiende a modelo
{
  //contructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
//==============================================================================================================
//==============================================================================================================
//==============================================================================================================
  public function insertarSalidaMaterial($datos){//funcion para insertar registros en ingresar material

    $consulta=$this->db->connect()->prepare("INSERT INTO salida_material (id_socio,id_pedido,fecha)VALUES (:id_socio,:id_pedido,:fecha)");
    try {
      $consulta->execute(['id_socio'=>$datos['id_socio'],'id_pedido'=>$datos['id_pedido'],'fecha'=>$datos['fecha']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //==============================================================================================================
  //==============================================================================================================
  //==============================================================================================================
  public function foraneaKey()
  {//funcion para buscar la foranea key d eproveedor
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM socio WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new SocioMap();//objeto
        //valores del array<-$row
        $item->id_socio=$row['id_socio'];//propiedades
        //$item->ruc=$row['ruc'];
        $item->nombre=$row['nombre'];
        $item->apellido=$row['apellido'];
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }
  //==============================================================================================================
  //==============================================================================================================
  //==============================================================================================================
  public function foraneaKeyMaterial()//foranea key para el detalle_ingreso->
  {
    $items=[];
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM material WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new MaterialMap();//objeto
        //valores del array<-$row
        $item->id_material=$row['id_material'];//propiedades
        //$item->ruc=$row['ruc'];
        $item->producto=$row['producto'];
        $item->codigo_material=$row['codigo_material'];
        //$item->telefono=$row['telefono'];
        //$item->correo=$row['correo'];
        //$item->direccion=$row['direccion'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }

  //==============================================================================================================
  //==============================================================================================================
  //==============================================================================================================
  public function foraneaKeyPedido()//foranea key para el detalle_ingreso->
  {
    $items=[];
    try {
      $consulta=$this->db->connect()->query("SELECT p.*,c.`nombre` FROM pedido p,cliente c WHERE p.`id_cliente`=c.`id_cliente` AND p.`estado`='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new PedidoMap();//objeto
        //valores del array<-$row
        $item->id_pedido=$row['id_pedido'];//propiedades
        $item->id_cliente=$row['nombre'];
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }


  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA INGRESO_MATERIAL-SELECT=======================================
  //==============================================================================================================

  public function darId($datos)
  {
    //return su id
    $item = new SalidaMaterialMap();
    $consulta=$this->db->connect()->prepare("SELECT * FROM salida_material WHERE id_socio=:id_socio AND id_pedido=:id_pedido");
    try {
      $consulta->execute(['id_socio'=>$datos['id_socio'],'id_pedido'=>$datos['id_pedido']]);
      if ($row=$consulta->fetch()) {
        $item->id_salida_material=$row['id_salida_material'];
      }
      return $item;
    } catch (PDOException $e) {
      return [];
    }
  }
  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA TEMPORAL-SELECT=======================================
  //==============================================================================================================
  public function extraerDatosTablaTemporal(){//SELECT DE LA TABLA TEMPORAL
    session_start();
    $id_usuario=$_SESSION['id_usuario'];//id_usuario
    $items=[];
    $consulta=$this->db->connect()->query("SELECT * FROM temporal_salida WHERE id_usuario='$id_usuario'");//CONUSLTA TABLA TEMPORA
    try {
      while ($row=$consulta->fetch()) {

        $id_material=$row['id_material'];
        $material=$this->buscarMaterial(['id_material'=>$id_material]);//llamamos a la funcion para traer un map de materiales
        $item = new DetalleMaterialMap();
        $item->id_material=$row['id_material'];//mapmateria
        $item->id_temporal=$row['id_temporal'];
        $item->producto=$material['producto'];//mapmateria
        $item->codigo_material=$material['codigo_material'];//mapmateria
        $item->cantidad=$row['cantidad'];
        $item->existente=$material['stock'];
        $item->id_usuario=$row['id_usuario'];
        array_push($items,$item);
      }
      return $items;
    } catch (PDOException $e) {
      return [];
    }
  }
  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA MATERIAL-SELECT=======================================
  //==============================================================================================================
  public function buscarMaterial($id)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM material WHERE id_material=:id_material");
    try {
      $consulta->execute(['id_material'=>$id['id_material']]);
      while ($row=$consulta->fetch()) {
        $item = array('codigo_material' =>$row['codigo_material'] ,'producto' =>$row['producto'],'stock' =>$row['stock']);
      }
      return $item;
    } catch (PDOException $e) {
      return [];
    }
  }

  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA TEMPORAL-INSERT==============================================
  //==============================================================================================================

  public function llenarDatosTablaTemporal($items){
    $consulta=$this->db->connect()->prepare("INSERT INTO temporal_salida (id_material,id_usuario,cantidad)VALUES(:id_material,:id_usuario,:cantidad)");
    try {
      $consulta->execute(['id_material'=>$items['id_material'],'id_usuario'=>$items['id_usuario'],'cantidad'=>$items['cantidad']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //==============================================================================================================
  //==============FUNCION PARA DETALLE_INGRESO INSERT==============================================================
  //==============================================================================================================

  public function insertarDetalleMaterial($items)
  {
    //insert
    $consulta=$this->db->connect()->prepare("INSERT INTO detalle_material (id_material, id_salida_material,cantidad)VALUES(:id_material, :id_salida_material,:cantidad)");
    try {
      $consulta->execute(['id_material'=>$items['id_material'],'cantidad'=>$items['cantidad'],'id_salida_material'=>$items['id_salida_material']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA TEMPORAL-DELETE *============================================
  //==============================================================================================================
  public function eliminarTablaTemporal()
  {
    session_start();
    $id_usuario=$_SESSION['id_usuario'];
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal_salida WHERE id_usuario='$id_usuario'");
    try {
      $consulta->execute();
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA TEMPORAL-DELETE x==============================================
  //==============================================================================================================
  public function delete($id)
  {
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal_salida WHERE id_temporal=:id_temporal");
    try {
      $consulta->execute(['id_temporal'=>$id['id_temporal']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  //==============================================================================================================
  //=========================FUNCIONES PARA LA TABLA MATERIAL-UPDATE=============================================
  //==============================================================================================================
  public function actualizarMaterial($items)
  {
    //select
    $consulta=$this->db->connect()->prepare("SELECT stock FROM material WHERE id_material=:id_material");
    try {
      $consulta->execute(['id_material'=>$items['id_material']]);
      if($row=$consulta->fetch()) {
        //validar si se puede o no
        $limite=constant('LIMITESALIDA');
        if ($row['stock']<$limite) {
          return false;
        }else{
          if ($row['stock']>$items['stock']) {
            // code...
            $stock=$row['stock']-$items['stock'];
            //update
            $consulta=$this->db->connect()->prepare("UPDATE material SET stock='$stock' WHERE id_material=:id_material");
            try {
              $consulta->execute(['id_material'=>$items['id_material']]);
              return true;
            } catch (PDOException $e) {
              return false;
            }
          }else{
            return false;
          }
        }
      }
    } catch (PDOException $e) {
      return false;
    }
  }

  //==============================================================================================================
  //==============FUNCION PARA DETALLE_INGRESO SELECT-INSERT UPDATE =============================================
  //==============================================================================================================
  public function agregarDetalleMaterial($datos){
    session_start();
    $id_usuario=$_SESSION['id_usuario'];//id_usuario
    $id_salida_material=$datos['id_salida_material'];//id_salida_material
    //buscar tabla temporal
    $consulta=$this->db->connect()->query("SELECT * FROM temporal_salida WHERE id_usuario='$id_usuario'");
    while ($row=$consulta->fetch()) {
      $item=['id_material'=>$row['id_material'],'stock'=>$row['cantidad']];
      //actualizar material stock
      $contentM=$this->actualizarMaterial($item);
      //insertar en detalle_ingreso (id_material,id_salida_material,cantidad,valor)
      $ditem=['id_material'=>$row['id_material'],'cantidad'=>$row['cantidad'],'id_salida_material'=>$id_salida_material];
      $contentD=$this->insertarDetalleMaterial($ditem);
    }
    $contentT=$this->eliminarTablaTemporal();
    if ($contentD==true && $contentM==true && $contentT==true ) {
      return true;
    }else{
      return false;
    }
  }
}

 ?>
