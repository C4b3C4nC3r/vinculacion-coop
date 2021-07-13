<?php
include_once 'models/mapas.php';//mapeo y ovjeto material
//include_once 'models/mapmaterial.php';//mapeo y ovjeto material
class ConsultarIngresarMaterialModel extends Modelo //nos estnendemos al modelo de libs/model
{
//consructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
/*
    ==========================================================================
     Funcion darMaterial sin parametros | Consultara el ingreso del material
    ==========================================================================
*/
  
  
  public function darIngresarMaterial()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT i.*,p.`nombre` FROM ingreso_material i,proveedor p WHERE i.`estado`='activo' AND p.`id_proveedor`=i.`id_proveedor` ORDER BY i.`fecha` ASC");//consulta sencilla
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new IngresarMaterialMap();//objeto

        //valores del array<-$row
        $item->id_ingreso_material=$row['id_ingreso_material'];//propiedades
        $item->id_proveedor=$row['nombre'];
        //$item->id_nombre=$row['id_nombre'];
        $item->numero_factura=$row['numero_factura'];
        $item->fecha=$row['fecha'];
        //$item->nombre=$row['nombre'];
        $item->subtotal=$row['subtotal'];
        $item->iva=$row['iva'];
        //$item->valor=$row['valor'];
        $item->total=$row['total'];
        $item->estado=$row['estado'];
        //$contador=$contador+1;
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      //session_start();
      //$_SESSION['limite']=$contador;
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }

/*
    =========================================
     Funcion hallarMaterial con parametros
    =========================================
*/
  public function hallarIngresarMaterial($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT i.*,p.`nombre`
        FROM ingreso_material i,proveedor p
        WHERE i.`estado`!='eliminado'
        AND i.`id_proveedor`=p.`id_proveedor`
        AND (p.`nombre` LIKE '%$buscar%' OR i.`numero_factura` LIKE '%$buscar%' OR
        i.`fecha` LIKE '%$buscar%')ORDER BY i.`fecha` ASC");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new IngresarMaterialMap();//objeto
        //valores del array<-$row
        $item->id_ingreso_material=$row['id_ingreso_material'];//propiedades
        $item->id_proveedor=$row['nombre'];
        //$item->id_nombre=$row['id_nombre'];
        $item->numero_factura=$row['numero_factura'];
        $item->fecha=$row['fecha'];
        //$item->nombre=$row['nombre'];
        $item->subtotal=$row['subtotal'];
        $item->iva=$row['iva'];
        //$item->valor=$row['valor'];
        $item->total=$row['total'];
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
    =========================================================
     Funcion con parametros para da run cliente especifico
    =========================================================
  */
  
  public function darPorId($id)
  {
    $item= new IngresarMaterialMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT i.*,p.`nombre` FROM ingreso_material i,proveedor p WHERE i.`id_ingreso_material`=:id_ingreso_material AND p.`id_proveedor`=i.`id_proveedor`");//consulta
    try {
      $consulta->execute(['id_ingreso_material'=>$id]);//execucion
      //recorrer resultado
      if ($row=$consulta->fetch()) {
        $id_ingreso_material=$row['id_ingreso_material'];
        $item->id_ingresar_material=$row['id_ingreso_material'];//propiedades
        $item->id_proveedor=$row['nombre'];
        $item->numero_factura=$row['numero_factura'];
        $item->fecha=$row['fecha'];
        $item->subtotal=$row['subtotal'];
        $item->iva=$row['iva'];
        $item->total=$row['total'];
        // regresar objeto
        return $item;
      }


    } catch (PDOException $e) {//caso que nofuncione
      return null;//returnamos null
    }
  }

  /*
    =============================================================
     Funcion encargada de hacer la busqueda del DetalleIngreso
    =============================================================
  */
  public function buscarDetalleIngreso($id)
  {
    $items=[];
    $consulta=$this->db->connect()->prepare("SELECT d.*,m.`producto` FROM detalle_ingreso d, material m WHERE id_ingreso_material=:id_ingreso_material AND m.`id_material`=d.`id_material`");
    try {
      $consulta->execute(['id_ingreso_material'=>$id]);
      while ($row=$consulta->fetch()) {
        $item = new DetalleIngresoMap();
        //$item->id_temporal=$row[''];
        //$item->id_material=$row[''];
      //  $item->id_usuario=$row[''];
        $item->producto=$row['producto'];
        //$item->codigo_material=$row['ca'];
        $item->cantidad=$row['cantidad'];
        $item->valor=$row['valor'];
        //$item->total=$row[''];
        array_push($items,$item);
      }
      return $items;
    } catch (PDOException $e) {
      return [];
    }
  }



}
 ?>
