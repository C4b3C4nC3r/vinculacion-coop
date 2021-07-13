<?php
include_once 'models/mapas.php';//mapeo y ovjeto material
class ConsultarMaterialModel extends Modelo //nos estnendemos al modelo de libs/model
{
  /*
    ========================================================================
     Funcion  verifica el parentesco con el constructor
    ========================================================================
  */

//consructor
  public function __construct()
  {
    // pariente
    parent::__construct();
  }
  /*
    =========================================================================================
     Funcion darMaterial sin parametros | cuenta y consulta las filas que contiene el array
    =========================================================================================
  */

  public function darMaterial()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT m.*,c.`categoria_material` FROM material m,categoria_material c WHERE m.`estado`='activo' AND m.`id_categoria_material`=c.`id_categoria_material`");//consulta sencilla
      //$contador=$consulta->rowCount();//cuenta las filas
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        //$contador=$row->rowCount();
        $item= new MaterialMap();//objeto

        //valores del array<-$row
        $item->id_material=$row['id_material'];//propiedades
        //$item->id_proveedor=$row['id_proveedor'];
        $item->id_categoria_material=$row['id_categoria_material'];
        $item->codigo_material=$row['codigo_material'];
        $item->categoria_material=$row['categoria_material'];
        //$item->nombre=$row['nombre'];
        $item->producto=$row['producto'];
        $item->stock=$row['stock'];
        //$item->valor=$row['valor'];
        $item->medida=$row['medida'];
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
    =========================================================================================
     Funcion hallrMaterial con parametros | hace una consulta en la DB para buscar los datos
    =========================================================================================
  */
  //funcion hallarMaterial con parametros
  public function hallarMaterial($datos)
  {
    $buscar=$datos['buscar'];
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query(
        "SELECT m.*,c.`categoria_material`
        FROM material m,categoria_material c
        WHERE m.`estado`!='eliminado'
        AND m.`id_categoria_material`=c.`id_categoria_material`
        AND (m.`codigo_material` LIKE '%$buscar%' OR m.`producto` LIKE '%$buscar%' OR
        c.`categoria_material` LIKE '%$buscar%')");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new MaterialMap();//objeto
        //$item= new MaterialMap();//objeto
        //valores del array<-$row
        $item->id_material=$row['id_material'];//propiedades
        //$item->id_proveedor=$row['id_proveedor'];
        $item->id_categoria_material=$row['id_categoria_material'];
        $item->codigo_material=$row['codigo_material'];
        $item->categoria_material=$row['categoria_material'];
        //$item->nombre=$row['nombre'];
        $item->producto=$row['producto'];
        $item->stock=$row['stock'];
        $item->medida=$row['medida'];
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
    ===========================================================================================
     Funcion que muestra el registro con su   ID .. antes de actualizar | Pasa las propiedades
                                                                        | Regresa el objeto
    ===========================================================================================
  */
  //mostrar el registro con su id, antes de actualizar
  public function darPorId($id)
  {

    $item= new MaterialMap();//objeto
    $consulta=$this->db->connect()->prepare("SELECT m.*,c.`categoria_material` FROM material m, categoria_material c WHERE m.`id_material`=:id_material AND m.`id_categoria_material`=c.`id_categoria_material`");//consulta
    try {
      $consulta->execute(['id_material'=>$id]);//execucion
      //recorrer resultado
      while ($row=$consulta->fetch()) {
        $item->id_material=$row['id_material'];//propiedades se las pasa
        //$item->id_proveedor=$row['id_proveedor'];
        $item->id_categoria_material=$row['id_categoria_material'];
        $item->codigo_material=$row['codigo_material'];
        $item->categoria_material=$row['categoria_material'];
        $item->producto=$row['producto'];
        $item->stock=$row['stock'];
        //$item->valor=$row['valor'];
        $item->medida=$row['medida'];
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
     AJAX Funcion update para actualizar con parametros contiene un POST ... un  array
    =========================================================================================
  */

  public function update($item){
    //consulta si hay un registro con el mismoproducto, medida, proveedor
    $consulta=$this->db->connect()->prepare("SELECT id_material, stock, estado FROM material WHERE id_categoria_material=:id_categoria_material AND codigo_material=:codigo_material AND medida=:medida AND producto=:producto AND id_material!=:id_material AND estado=:estado");
    try {
      //se encierra en un if{}else{}
        //ejecutamos
        $consulta->execute(['id_categoria_material'=>$item['id_categoria_material'],'codigo_material'=>$item['codigo_material'],'id_material'=>$item['id_material'],'medida'=>$item['medida'],'producto'=>$item['producto'],'estado'=>$item['estado']]);
        //se extrae
        if ($row=$consulta->fetch()) {
          //guardar variables solo aqui...
          $id_material=$row['id_material'];//id
          $stock=$row['stock'];//cantiad antes
        //  $valor=$row['valor'];//valor antes
          $estado=$row['estado'];//estado antes
          /*-------------------------------------------*/
          $nuevo_estado=$item['estado'];//estado ahora
          $nuevo_stock=$item['stock'];//estado ahora

          //consulta hara lapreparaciond e la actualizacion
          $consulta=$this->db->connect()->prepare("UPDATE material SET stock='$nuevo_stock',estado='$nuevo_estado' WHERE id_material='$id_material'");//actualizar
          //nuevo try{}catch(){}
          try {
            $consulta->execute();//executamos
            //$eliminarAnterior->execute('id_material'=>$item['id_material']);//executamos
            if ($this->delete($item['id_material'])) {
              //return en true
              return true;
            }
          } catch (PDOException $e) {
            //retornamos falso
            return false;
          }
        }else{//caso que no haya nada en consulta
        //consulta actualizar...
          $consulta=$this->db->connect()->prepare("UPDATE material SET id_categoria_material=:id_categoria_material,codigo_material=:codigo_material,producto=:producto,stock=:stock,medida=:medida,estado=:estado WHERE id_material=:id_material");//actualizar

          try {
            $consulta->execute(['id_material'=>$item['id_material'],'id_categoria_material'=>$item['id_categoria_material'],'codigo_material'=>$item['codigo_material'],'producto'=>$item['producto'],'stock'=>$item['stock'],'medida'=>$item['medida'],'estado'=>$item['estado']]);
            return true;//retornamostrue para que mande una accion
          } catch (PDOException $e) {
            return false;//etornamos false para idnicar errores
          }
        }
    }catch (PDOException $e) {
      return flase;
    }
  }
  /*
    =======================================================================================
     Funcion delete con parametros que eliminar un material por su ID | luego se actualiza
    =======================================================================================
  */

  public function delete($id)//parametro
  {
    //eliminar
    $consulta=$this->db->connect()->prepare("UPDATE material SET estado='eliminado' WHERE id_material=:id_material");//actualizar
    try {
      $consulta->execute(['id_material'=>$id]);
      return true;//retornamos
    } catch (PDOException $e) {
      return false;//retronamos
    }
  }

  /*
    =========================================================================================
     Funcion que muestra el estado del Material usando un arreglo Vacio
    =========================================================================================
  */

  public function estadoMaterial($estado)
  {
    $items=[];//arreglovacio
    //si funciona
    $consulta=$this->db->connect()->prepare("SELECT m.*,c.`categoria_material` FROM material m, categoria_material c WHERE m.`estado`=:estado AND m.`id_categoria_material`=c.`id_categoria_material`");//consulta sencilla
    try {
      $consulta->execute(['estado'=>$estado]);

      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new MaterialMap();//objeto
        //$item= new MaterialMap();//objeto
        //valores del array<-$row
        $item->id_material=$row['id_material'];//propiedades
        $item->id_categoria_material=$row['id_categoria_material'];
        $item->categoria_material=$row['categoria_material'];
        $item->codigo_material=$row['codigo_material'];
        $item->producto=$row['producto'];
        $item->stock=$row['stock'];
        $item->medida=$row['medida'];
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
    ==============================================================
     Funcion que retornara un array con los datos del Proveedor
    ==============================================================
  */
  public function foraneaKey()
  {
    $items=[];//arreglovacio
    //si funciona
    try {
      $consulta=$this->db->connect()->query("SELECT * FROM categoria_material WHERE estado='activo'");//consulta sencilla
      while ($row=$consulta->fetch()) {//while, la fila que contiene al array que tare el fetch al vincularse con la consulta
        $item= new CategoriaMaterialMap();//objeto
        //valores del array<-$row
        $item->id_categoria_material=$row['id_categoria_material'];//propiedades
      //  $item->ruc=$row['ruc'];
        $item->categoria_material=$row['categoria_material'];
        //$item->telefono=$row['telefono'];
        //$item->correo=$row['correo'];
      //  $item->direccion=$row['direccion'];
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
