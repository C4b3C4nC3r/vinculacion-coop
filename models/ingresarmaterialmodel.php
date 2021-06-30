<?php
include_once 'models/mapas.php';//m
class IngresarMaterialModel extends Modelo//extiende a modelo
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
  public function insertarIngresarMaterial($datos){//funcion para insertar registros en ingresar material

    $consulta=$this->db->connect()->prepare("INSERT INTO ingreso_material (id_proveedor,numero_factura,fecha,subtotal,iva,total)VALUES (:id_proveedor,:numero_factura,:fecha,:subtotal,:iva,:total)");
    try {
      $consulta->execute(['id_proveedor'=>$datos['id_proveedor'],'numero_factura'=>$datos['numero_factura'],'fecha'=>$datos['fecha'],'iva'=>$datos['iva'],'subtotal'=>$datos['subtotal'],'total'=>$datos['total']]);
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
      $consulta=$this->db->connect()->query("SELECT * FROM proveedor WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new ProveedorMap();//objeto
        //valores del array<-$row
        $item->id_proveedor=$row['id_proveedor'];//propiedades
        //$item->ruc=$row['ruc'];
        $item->nombre=$row['nombre'];
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
  //=========================FUNCIONES PARA LA TABLA INGRESO_MATERIAL-SELECT=======================================
  //==============================================================================================================

  public function darId($datos)
  {
    //return su id
    $item = new IngresarMaterialMap();
    $consulta=$this->db->connect()->prepare("SELECT * FROM ingreso_material WHERE id_proveedor=:id_proveedor AND numero_factura=:numero_factura");
    try {
      $consulta->execute(['id_proveedor'=>$datos['id_proveedor'],'numero_factura'=>$datos['numero_factura']]);
      if ($row=$consulta->fetch()) {
        $item->id_ingresar_material=$row['id_ingreso_material'];
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
    $consulta=$this->db->connect()->query("SELECT * FROM temporal WHERE id_usuario='$id_usuario'");//CONUSLTA TABLA TEMPORA
    try {
      while ($row=$consulta->fetch()) {

        $id_material=$row['id_material'];
        $material=$this->buscarMaterial(['id_material'=>$id_material]);//llamamos a la funcion para traer un map de materiales
        $item = new DetalleIngresoMap();
        $item->id_material=$row['id_material'];//mapmateria
        $item->id_temporal=$row['id_temporal'];
        $item->producto=$material['producto'];//mapmateria
        $item->codigo_material=$material['codigo_material'];//mapmateria
        //muktiplicaciones
        $item->total=$row['cantidad']*$row['valor'];
        $item->cantidad=$row['cantidad'];
        $item->valor=$row['valor'];
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
        $item = array('codigo_material' =>$row['codigo_material'] ,'producto' =>$row['producto']);
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
    $consulta=$this->db->connect()->prepare("INSERT INTO temporal (id_material,id_usuario,cantidad,valor)VALUES(:id_material,:id_usuario,:cantidad,:valor)");
    try {
      $consulta->execute(['id_material'=>$items['id_material'],'id_usuario'=>$items['id_usuario'],'cantidad'=>$items['cantidad'],'valor'=>$items['valor']]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }
  //==============================================================================================================
  //==============FUNCION PARA DETALLE_INGRESO INSERT==============================================================
  //==============================================================================================================

  public function insertarDetalleIngreso($items)
  {
    //insert
    $consulta=$this->db->connect()->prepare("INSERT INTO detalle_ingreso (id_material, id_ingreso_material,cantidad,valor)VALUES(:id_material, :id_ingreso_material,:cantidad,:valor)");
    try {
      $consulta->execute(['id_material'=>$items['id_material'],'cantidad'=>$items['cantidad'],'valor'=>$items['valor'],'id_ingreso_material'=>$items['id_ingreso_material']]);
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
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal WHERE id_usuario='$id_usuario'");
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
    $consulta=$this->db->connect()->prepare("DELETE FROM temporal WHERE id_temporal=:id_temporal");
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
        $stock=$items['stock']+$row['stock'];
        //update
        $consulta=$this->db->connect()->prepare("UPDATE material SET stock='$stock' WHERE id_material=:id_material");
        try {
          $consulta->execute(['id_material'=>$items['id_material']]);
          return true;
        } catch (PDOException $e) {
          return false;
        }
      }
    } catch (PDOException $e) {
      return false;
    }
  }

  //==============================================================================================================
  //==============FUNCION PARA DETALLE_INGRESO SELECT-INSERT UPDATE =============================================
  //==============================================================================================================
  public function agregarDetalleIngreso($datos){
    session_start();
    $id_usuario=$_SESSION['id_usuario'];//id_usuario
    $id_ingreso_material=$datos['id_ingreso_material'];//id_ingreso_material
    //buscar tabla temporal
    $consulta=$this->db->connect()->query("SELECT id_material,cantidad,valor FROM temporal WHERE id_usuario='$id_usuario'");
    while ($row=$consulta->fetch()) {
      $item=['id_material'=>$row['id_material'],'stock'=>$row['cantidad']];
      //actualizar material stock
      $contentM=$this->actualizarMaterial($item);
      //insertar en detalle_ingreso (id_material,id_ingreso_material,cantidad,valor)
      $ditem=['id_material'=>$row['id_material'],'cantidad'=>$row['cantidad'],'valor'=>$row['valor'],'id_ingreso_material'=>$id_ingreso_material];
      $contentD=$this->insertarDetalleIngreso($ditem);
    }
    $contentT=$this->eliminarTablaTemporal();
    if ($contentD==true && $contentM==true && $contentT==true ) {
      return true;
    }else{
      return false;
    }
  }

  //


  /*============================================================================
  FUNCION PARA BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  public function buscarDatosFacturaProveedor($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM ingreso_material WHERE numero_factura=:numero_factura AND id_proveedor=:id_proveedor AND estado='activo'");
    try {
      $consulta->execute(['numero_factura'=>$datos['numero_factura'],'id_proveedor'=>$datos['id_proveedor']]);
      if ($row=$consulta->fetch()) {
        // code...
        return true;
      }
    } catch (PDOException $e) {
      return false;
    }
  }

  //
  public function extraerDatosTablaMaterial($datos)
  {
    $x=$datos['codigo_material'];
    $xx=$datos['producto'];
    $items=[];
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM material WHERE estado='activo' AND (codigo_material LIKE '%$x%' OR producto LIKE '%$xx%')");//consulta sencilla
      //$consulta->execute(['codigo_material'=>$datos['codigo_material'],'producto'=>$datos['producto']]);
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new MaterialMap();//objeto
        //valores del array<-$row
        $item->id_material=$row['id_material'];//propiedades
        $item->codigo_material=$row['codigo_material'];
        $item->producto=$row['producto'];
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }
  //FIN
}

 ?>
