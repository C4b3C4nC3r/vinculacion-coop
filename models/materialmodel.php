<?php
include_once 'models/mapas.php';
class MaterialModel extends Modelo//extiende a modelo
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
    ============================================================================================================
     Funcion para agregar el prodycto que se ingreso para usarlo| Funcion de inserrtar el material con
                                                                | parametros del arrar de datos
    ============================================================================================================
  */

  public function insertarMaterial($datos)
  {
    /*
    ===========================================================================
    INSERT INTO material (id_proveedor,producto,stock,valor,medida,estado)
    VALUES ('1','sss','5','120.22','ki','activo')
    ============================================================================
    */
    $consulta=$this->db->connect()->prepare("INSERT INTO material (id_categoria_material,codigo_material,producto,medida)VALUES (:id_categoria_material,:codigo_material,:producto,:medida)");
    try {
      /*
      ====================================================================================================
      variable para alamcenar el query, cojiendo el nombre de la base de datos y utilizando
      la funcion connect() .... interna no por default, y preparamos el codigo sql
      ejecutamos e indicamos que  con quien va
      ====================================================================================================
      */


      $consulta->execute(['id_categoria_material'=>$datos['id_categoria_material'],'codigo_material'=>$datos['codigo_material'],'producto'=>$datos['producto'],'medida'=>$datos['medida']]);
      //return cuando sea afirmativa, caso que no
      return true;
    } catch (PDOException $e) {
      //mostramos el false
      return false;
    }
  }
  /*
  =======================================================================
   Funcion para retornar un array con datos del proveedor
  =======================================================================
  */
  public function foraneaKey()
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->query("SELECT * FROM categoria_material WHERE estado='activo'");//consulta sencilla
    try {
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new CategoriaMaterialMap();//objeto
        //valores del array<-$row
        $item->id_categoria_material=$row['id_categoria_material'];//propiedades
      //  $item->ruc=$row['ruc'];``
        $item->categoria_material=$row['categoria_material'];
        //$item->telefono=$row['telefono'];
        //$item->correo=$row['correo'];
      //  $item->direccion=$row['direccion'];
        //ingresar en un arreglo un nuevo valor
        array_push($items,$item);//
      }
      return $items;//sifunciona
    } catch (PDOException $e) {//excepciones pero de PDO
      return [];//no funciona
    }
  }

  /*============================================================================
  FUNCION PARA BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  public function buscarMaterial($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM material WHERE codigo_material=:codigo_material AND estado='activo'");
    try {
      $consulta->execute(['codigo_material'=>$datos['codigo_material']]);
      if ($row=$consulta->fetch()) {
        // code...
        return true;
      }
    } catch (PDOException $e) {
      return false;
    }
  }
  //
  /*============================================================================
  FUNCION PARA BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  public function buscarMaterialN($datos)
  {
    $consulta=$this->db->connect()->prepare("SELECT * FROM material WHERE producto=:producto AND estado='activo'");
    try {
      $consulta->execute(['producto'=>$datos['producto']]);
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
