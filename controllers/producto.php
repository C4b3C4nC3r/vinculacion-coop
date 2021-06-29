<?php

/**
 *revisado
 */
class Producto extends Controlador
{
  /*
  =================================================================================================================================================
  Funcion Constructor|| Llama al Pariente Constructor || Usa la funcion Render para mandar parametros <<libs/view.php/class/Vista/render($descripcion)
  =================================================================================================================================================
*/

  function __construct()
  {
    parent::__construct();

    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($descripcion)
    $this->vista->categoriaproducto= [];
  }
  /*
  ==================================================================================================
    Funcion Render | var= este modelo ->con parametros Vacios | La vista ->objeto materialmap = var
  =================================================================================================
*/
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $categoriaproducto=$this->modelo->foraneaKey();
    //esta vista->objeto materialmap= var
    $this->vista->categoriaproducto=$categoriaproducto;
    //
    $this->vista->render('producto/index');
    // code...
  }
/*
  ============================================================================================================
     AJAX Funcion que usa un POST para consultar el producto, guarda imagenes del producto y Inserta producto
  ============================================================================================================
*/
  function agregarProducto()
  {
    $url=constant('URL').'consultarproducto';//link

    if (isset($_POST)&&isset($_FILES)) {
      $name=$_FILES['foto']['name'];//name
      $type=$_FILES['foto']['type'];//type
      $size=$_FILES['foto']['size'];//size
      /*Para cambairlo a .bin*/
      //primero vemos si es o no
      $permitidos = array('image/png','image/jpg','image/jpeg' );//array de tipos de doc
      if (in_array($type,$permitidos)==false) {
        die("
        <div class='alert alert-secondary alert-dismissible fade show' role='alert'>
            <strong>Imagen No Permitida</strong>
        </div>
        "
        );
      }
      //abrir
      $foto=fopen($_FILES['foto']['tmp_name'],'r');
      //leer
      $foto=fread($foto,$size);

        if ($this->modelo->insertarProducto(['id_categoria_producto'=>$_POST['id_categoria_producto'],'codigo_producto'=>$_POST['codigo_producto'],'producto'=>$_POST['producto'],'descripcion'=>$_POST['descripcion'],'foto'=>$foto,'precio'=>$_POST['precio']])) {
        //mensaje
      ?><div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Ingresado con Exito el Producto
            <a href='<?php echo $url ?>'> Revisar los Productos</a>
        </div>
      <?php
        }else{
        //mensajes de error
        ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Ingresado el Producto
            <a href='<?php echo $url ?>'> Revisar los Productos</a>
        </div>
        <?php
        }

    } else {
      //MENSAJE DATOS INCOMPLETOS | PARA QUE RELLENE DE NUEVO
      ?>
      <div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Datos Incompletos</strong> Ingrese todos los datos que corresponda
      </div>
      <?php
    }
  }
//c busca por el codigo
  function buscarRegistro()
  {
      if ($this->modelo->buscarProducto(['codigo_producto'=>$_GET['codigo_producto']])) {
        ?>
        <p style="font-size:10px;color:red;">
          Este codigo ya esta registrado, verifiquelo
        </p>
        <?php
      }else{
        $bool=true;
        echo $bool;
      }
  }
  //se busca el nombre
  function buscarRegistroN()
  {
      if ($this->modelo->buscarProductoN(['producto'=>$_GET['producto']])) {
        ?>
        <p style="font-size:10px;color:red;">
          Este producto ya esta registrado, verifiquelo
        </p>
        <?php
      }else{
        $bool=true;
        echo $bool;
      }
  }
  //fin
}
?>
