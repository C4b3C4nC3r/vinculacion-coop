<?php
include_once 'models/mapas.php';//mapeo y ovjeto material
//include_once 'models/mapmaterial.php';//mapeo y ovjeto material
class ConsultarTareaModel extends Modelo //nos estnendemos al modelo de libs/model
{
//consructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
  /*
    =============================================================
     Funcion darPerdido sin parametros | Utiliza arreglo vacio
    =============================================================
  */
  public function darTarea()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT p.*,c.`nombre` AS 'cliente' FROM pedido p,cliente c WHERE  p.`estado`='activo' AND p.`id_cliente`=c.`id_cliente` ORDER BY p.`id_pedido` DESC");//consulta sencilla
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new PedidoMap();//objeto
        //valores del array<-$row
        //$item->id_salida_material=$row['id_salida_material'];//propiedades
        //$item->id_socio="$row[nombre] $row[apellido] ";
        $item->id_pedido=$row['id_pedido'];
        $item->id_cliente=$row['cliente'];
        $item->fecha_entrada=$row['fecha_entrada'];
        $item->fecha_salida=$row['fecha_salida'];

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
    ==================================================================================================================
     Funcion hallarTarea con arreglos vacios | Realizara una consulta en la DB y ordenara el resultado por su ID ASC
    ==================================================================================================================
  */
  public function hallarTarea($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT t.*,s.`nombre`
        FROM tarea t,socio s
        WHERE t.`estado`!='eliminado'
        AND s.`id_socio`=t.`id_socio`
        AND (s.`nombre` LIKE '%$buscar%' OR t.`fecha_asignacion` LIKE '%$buscar%' OR
        t.`fecha_entrega` LIKE '%$buscar%')ORDER BY t.`id_tarea` ASC");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new TareaMap();//objeto
        $item->id_tarea=$row['id_tarea'];//propiedades
        $item->id_socio=$row['nombre'];
        $item->fecha_asignacion=$row['fecha_asignacion'];
        $item->fecha_entrega=$row['fecha_entrega'];
        $item->id_pedido=$row['id_pedido'];
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
    =========================================================================================
     Funcion con parametros que dara Run por ID a la cosulta del Tarea en Model
    =========================================================================================
  */
  public function darPorId($id)
  {
    $item= new TareaMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT t.*,s.`nombre`,c.`nombre` AS cliente  FROM tarea t,socio s,cliente c, pedido p WHERE t.`id_tarea`=:id_tarea AND s.`id_socio`=t.`id_socio`AND c.`id_cliente`=p.`id_cliente`");//consulta
    try {
      $consulta->execute(['id_tarea'=>$id]);//execucion
      //recorrer resultado
      if ($row=$consulta->fetch()) {
        $item->id_tarea=$row['id_tarea'];//propiedades
        $item->id_socio=$row['nombre'];
        $item->fecha_asignacion=$row['fecha_asignacion'];
        $item->fecha_entrega=$row['fecha_entrega'];
        $item->id_pedido="$row[id_pedido]-$row[cliente]";
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
     Funcion que buscara el detalle del Tarea usando su ID para realizar la consulta
    =========================================================================================
  */
  public function buscarDetalleTarea($id)
  {
    $items=[];
    $consulta=$this->db->connect()->prepare("SELECT d.*,p.`producto` FROM detalle_tarea d, producto p WHERE d.`id_tarea`=:id_tarea AND d.`id_producto`=p.`id_producto`");
    try {
      $consulta->execute(['id_tarea'=>$id]);
      while ($row=$consulta->fetch()) {
        $item = new DetalleTareaMap();
        $item->producto=$row['producto'];
        $item->cantidad=$row['cantidad'];
        array_push($items,$item);
      }
      return $items;
    } catch (PDOException $e) {
      return [];
    }
  }
  //==============================================================
  public function hallarSocioTarea($datos)
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->prepare("SELECT t.*,s.`nombre`,s.`apellido`,s.`cedula` FROM tarea t, socio s WHERE t.`id_pedido`=:id_pedido AND t.`id_socio`=s.`id_socio` ORDER BY t.`fecha_asignacion` DESC");//consulta sencilla

    try {
      $consulta->execute(['id_pedido'=>$datos['id_pedido']]);
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new TareaMap();//objeto
        //valores del array<-$row
        $item->id_tarea=$row['id_tarea'];//propiedades
        $item->id_socio=" $row[apellido] $row[nombre]";
        $item->cedula_socio="$row[cedula]";
        //$item->id_pedido=$row['id_pedido'];
        //$item->id_cliente=$row['cliente'];
        $item->fecha_asignacion=$row['fecha_asignacion'];
        $item->fecha_entrega=$row['fecha_entrega'];
        $item->fecha_entregado=$row['fecha_entregado'];
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
