<?php
include_once 'models/mapas.php';//m
class TareaModel extends Modelo//extiende a modelo
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
      $consulta=$this->db->connect()->query("SELECT p.`id_pedido`,c.`nombre` FROM pedido p, cliente c WHERE p.`id_cliente`=c.`id_cliente` AND p.`estado`='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new PedidoMap();//objeto
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
  //==============================================================================================================
  //==============================================================================================================
  public function foraneaKeyProducto()//foranea key para el detalle_ingreso->
  {
    $items=[];
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM producto WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new ProductoMap();//objeto
        //valores del array<-$row
        $item->id_producto=$row['id_producto'];//propiedades
        //$item->ruc=$row['ruc'];
        $item->producto=$row['producto'];
        $item->precio=$row['precio'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }

  public function extraerDatosTablaTemporal(){//SELECT DE LA TABLA TEMPORAL
    session_start();
    $id_usuario=$_SESSION['id_usuario'];//id_usuario
    $items=[];
    $consulta=$this->db->connect()->query("SELECT * FROM temporal_tarea WHERE id_usuario='$id_usuario'");//CONUSLTA TABLA TEMPORA
    try {
      while ($row=$consulta->fetch()) {
        $id_producto=$row['id_producto'];
        $producto=$this->buscarProducto(['id_producto'=>$id_producto]);//llamamos a la funcion para traer un map de produes
        $item = new DetalleTareaMap();
        $item->id_temporal=$row['id_temporal'];
        $item->id_producto=$row['id_producto'];//mapmateria
        $item->id_usuario=$row['id_usuario'];
        $item->producto=$producto['producto'];//mapmateria
        $item->codigo_producto=$producto['codigo_producto'];//mapmateria
        $item->cantidad=$row['cantidad'];
        array_push($items,$item);
      }
      return $items;
    } catch (PDOException $e) {
      return [];
    }
  }

  public function buscarProducto($id)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM producto WHERE id_producto=:id_producto");
    try {
      $consulta->execute(['id_producto'=>$id['id_producto']]);
      if($row=$consulta->fetch()) {
        $item=['producto'=>$row['producto'],'codigo_producto'=>$row['codigo_producto']];
        return $item;
      }
    } catch (PDOException $e) {
      return [];
    }
  }
  public function agregarTablaTemporal($datos)
  {
    session_start();
    $id_usuario=$_SESSION['id_usuario'];
    $consulta=$this->db->connect()->prepare("INSERT INTO temporal_tarea (id_producto,id_usuario,cantidad)VALUES(:id_producto,'$id_usuario',:cantidad)");
    try {
      $consulta->execute(['id_producto'=>$datos['id_producto'],'cantidad'=>$datos['cantidad']]);
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
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal_tarea WHERE id_usuario='$id_usuario'");
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
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal_tarea WHERE id_temporal=:id_temporal");
    try {
      $consulta->execute(['id_temporal'=>$id['id_temporal']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
//insertar tarea
  public function insertarTarea($datos)
  {
    $consulta=$this->db->connect()->prepare("INSERT INTO tarea (id_socio,id_pedido,fecha_asignacion,fecha_entrega)VALUES (:id_socio,:id_pedido,:fecha_asignacion,:fecha_entrega)");
    try {
      $consulta->execute(['id_socio'=>$datos['id_socio'],'id_pedido'=>$datos['id_pedido'],'fecha_asignacion'=>$datos['fecha_asignacion'],'fecha_entrega'=>$datos['fecha_entrega']]);
      $consulta=$this->db->connect()->query("SELECT id_tarea FROM tarea ORDER BY id_tarea DESC LIMIT 1 ");    
      if ($row=$consulta->fetch()) {
        $obj=['id_tarea'=>$row['id_tarea']];
        return $obj;
      }
    } catch (PDOException $e) {
      return [];
    }

  }
  
  public function insertarDetalleTarea($items)
  {
    //insert
    $consulta=$this->db->connect()->prepare("INSERT INTO detalle_tarea (id_tarea,id_producto,cantidad)VALUES(:id_tarea,:id_producto,:cantidad)");
    try {
      $consulta->execute(['id_tarea'=>$items['id_tarea'],'cantidad'=>$items['cantidad'],'id_producto'=>$items['id_producto']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //detalle tarea
  public function agregarDetalleTarea($id)
  {
    session_start();
    $id_usuario=$_SESSION['id_usuario'];//id_usuario
    $id_tarea=$id['id_tarea'];//id_ingreso_material
    //buscar tabla temporal
    $consulta=$this->db->connect()->query("SELECT * FROM temporal_tarea WHERE id_usuario='$id_usuario'");
    while ($row=$consulta->fetch()) {
      
      //insertar en detalle_ingreso (id_material,id_ingreso_material,cantidad,valor)
      $ditem=['id_producto'=>$row['id_producto'],'cantidad'=>$row['cantidad'],'id_tarea'=>$id_tarea];
      $contentD=$this->insertarDetalleTarea($ditem);
    }
    $contentT=$this->eliminarTablaTemporal();
    if ($contentD==true && $contentT==true ) {
      return true;
    }else{
      return false;
    }
  }
}

 ?>
