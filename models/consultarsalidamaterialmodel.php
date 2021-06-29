<?php
include_once 'models/mapas.php';//mapeo y ovjeto material
//include_once 'models/mapmaterial.php';//mapeo y ovjeto material
class ConsultarSalidaMaterialModel extends Modelo //nos estnendemos al modelo de libs/model
{
//consructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
  //funcion darMaterial sin parametros
  public function darSalidaMaterial()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT p.*,c.`nombre` AS 'cliente' FROM pedido p,cliente c WHERE  p.`estado`='activo' AND p.`id_cliente`=c.`id_cliente` ORDER BY p.`id_pedido` DESC");//consulta sencilla
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new SalidaMaterialMap();//objeto
        //valores del array<-$row
        //$item->id_salida_material=$row['id_salida_material'];//propiedades
        //$item->id_socio="$row[nombre] $row[apellido] ";
        $item->id_pedido=$row['id_pedido'];
        $item->id_cliente=$row['cliente'];
        $item->fecha=$row['fecha_entrada'];
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
  //funcion hallarMaterial con parametros
  public function hallarSalidaMaterial($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT m.*,s.`nombre`,s.`apellido`
        FROM salida_material m,socio s
        WHERE m.`estado`!='eliminado'
        AND m.`id_socio`=s.`id_socio`
        AND (s.`nombre` LIKE '%$buscar%' OR s.`apellido` LIKE '%$buscar%' OR
        m.`fecha` LIKE '%$buscar%')ORDER BY m.`fecha` ASC");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new SalidaMaterialMap();//objeto
        //valores del array<-$row
        $item->id_ingreso_material=$row['id_ingreso_material'];//propiedades
        $item->id_socio="$row[nombre] $row[apellido] ";
        $item->id_pedido=$row['id_pedido'];
        $item->fecha=$row['fecha'];
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//nofunciona
    }
  }

  //funcion pcon parametros para da run cliente especifico
  public function darPorId($id)
  {
    $item= new SalidaMaterialMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT m.*,s.`nombre`,s.`apellido` FROM salida_material m,socio s WHERE m.`id_salida_material`=:id_salida_material AND s.`id_socio`=m.`id_socio`");//consulta
    try {
      $consulta->execute(['id_salida_material'=>$id]);//execucion
      //recorrer resultado
      if ($row=$consulta->fetch()) {
        //$id_salida_material=$row['id_salida_material'];
        $item->id_salida_material=$row['id_salida_material'];//propiedades
        $item->id_socio="$row[nombre] $row[apellido] ";
        $item->id_pedido=$row['id_pedido'];
        $item->fecha=$row['fecha'];
        // regresar objeto
        return $item;
      }
    } catch (PDOException $e) {//caso que nofuncione
      return null;//returnamos null
    }
  }
  public function buscarDetalleMaterial($id)
  {
    $items=[];
    $consulta=$this->db->connect()->prepare("SELECT d.*,m.`producto` FROM detalle_material d, material m WHERE d.`id_salida_material`=:id_salida_material AND m.`id_material`=d.`id_material`");
    try {
      $consulta->execute(['id_salida_material'=>$id]);
      while ($row=$consulta->fetch()) {
        $item = new DetalleMaterialMap();
        $item->producto=$row['producto'];
        $item->cantidad=$row['cantidad'];
        $item->id_salida_material=$row['id_salida_material'];
        //$item->total=$row[''];
        array_push($items,$item);
      }
      return $items;
    } catch (PDOException $e) {
      return [];
    }
  }
  //----------------------------------------------------------------------------
  public function hallarSocioMaterial($datos)
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->prepare("SELECT m.*,s.`nombre`,s.`apellido`,s.`cedula` FROM salida_material m, socio s WHERE m.`id_pedido`=:id_pedido AND m.`id_socio`=s.`id_socio` AND m.`estado`='activo' ORDER BY m.`fecha` DESC");//consulta sencilla

    try {
      $consulta->execute(['id_pedido'=>$datos['id_pedido']]);
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new SalidaMaterialMap();//objeto
        //valores del array<-$row
        $item->id_salida_material=$row['id_salida_material'];//propiedades
        $item->id_socio="$row[cedula] $row[apellido] $row[nombre]";
        //$item->id_pedido=$row['id_pedido'];
        //$item->id_cliente=$row['cliente'];
        $item->fecha=$row['fecha'];
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
}
 ?>
