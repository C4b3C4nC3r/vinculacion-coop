<?php

/**
*CLASE DE ConsultaProducto, SE LA VE COMO UN OBJETO PADRE CON SUS HIJOS O SEA FUNCIONES
 *Revisado
 */
class ConsultarProducto extends Controlador //se extiende al controlador en libs/controller
{
/*
  ========================================================
     Funcion recoge los Render para mandar parametros
  ========================================================
*/
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto productomap (Class ProductoMap)
    $this->vista->productomap= [];
    //mensaje en vista
    //$this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($producto)
  }
  /*
  ========================================================
    Funcion recoge los Render con parametros vacios
  ========================================================
*/
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $producto=$this->modelo->darProducto();
    //esta vista->objeto productomap= var
    $this->vista->productomap=$producto;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('producto/consultarproducto');
  }
  /*
  ========================================================
    AJAX Funcion con parametros visualizar el Producto
  ========================================================
*/
  //para visualizar
  function verProducto($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_producto=$parametro[0];//asiganar id
    //var= este modelo con la funcion dar Por Id(paraemtro);
    $producto=$this->modelo->darPorId($id_producto);
    $categoriaproducto=$this->modelo->foraneaKey();
    //esta vista->objeto materialmap= var
    $this->vista->categoriaproducto=$categoriaproducto;
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_producto']=$producto->id_producto;
    //pasamos a vista materia
    $this->vista->producto = $producto;

    //renderizamos
    $this->vista->render('producto/verproducto');
    /*
    Mostrar los array
    var_dump($parametro);
    */
  }
  /*
  ==========================================================
     Funcion busca el producto a viusualizar con parametros
  ==========================================================
*/
  //para visualizar
  function buscarProducto()//conn parametro
  {
    $productos=$this->modelo->hallarProducto(['buscar'=>$_POST['buscado']]);
    //esta vista->objeto productomap= var
    $this->vista->productomap=$productos;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('producto/consultarproducto');

  }
  /*
  ==========================================================
    AJAX Funcion que ayuda a insertar Imagenes del producto
  ==========================================================
*/
  //funcion de img/.x a .bin
  function imgBin($items)
  {
    if(empty($items)) {
      session_start();
      $f=$_SESSION['foto'];
      return $f;
    }else{
      $permitidos = array('image/png', 'image/jpg', 'image/jpeg'); //array de tipos de doc
      if (in_array($items['type'], $permitidos) == false) {
        $mensaje =
          "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Imagen Denegada</strong> El Tipo de Imagen no es permitida $permitidos
        </div>
        ";
        //llenamos el mensaje
        $this->vista->mensaje = $mensaje;
        //volvemos a renderizar
        $this->vista->render('producto/verproducto');
      }
      $f=fopen($items['tmp_name'],'r');
      $f= fread($f,$items['size']);
      //$arrayfoto = array('foto' => $f);
      return $f;
    }
  }
  /*
  ========================================================
    AJAX Funcion para actualizar el producto usando POST
  ========================================================
*/
  //funcion de actualizar
  function actualizarProducto()
  {
    $url = constant('URL') . 'consultarproducto'; //link
    session_start();
    $id_producto = $_SESSION['id_producto'];
    unset($_SESSION['id_producto']);
    //llamamos a al funcion imgBin
    //desglosar
    $name = $_FILES['foto']['name']; //name
    $type = $_FILES['foto']['type']; //type
    $size = $_FILES['foto']['size']; //size
    $tmp_name=$_FILES['foto']['tmp_name'];
    //si $f esta llene lo mandamos a update, caso contrario, solo mandamos el que este ne cache
    if($f=$this->imgBin(['name'=>$name, 'type' => $type, 'size' => $size, 'tmp_name' => $tmp_name])){
      if ($this->modelo->update(['id_producto' => $id_producto, 'id_categoria_producto' => $_POST['id_categoria_producto'], 'codigo_producto' => $_POST['codigo_producto'], 'producto' => $_POST['producto'], 'descripcion' => $_POST['descripcion'], 'foto' =>$f, 'precio' => $_POST['precio'], 'estado' => $_POST['estado']])) {
        # obj
        $obj=new ProductoMap();
        $obj->id_producto=$id_producto;
        $obj->id_categoria_producto= $_POST['id_categoria_producto'];
        $obj->codigo_producto = $_POST['codigo_producto'];
        $obj->producto = $_POST['producto'];
        $obj->descripcion = $_POST['descripcion'];
        $obj->foto =$f;
        $obj->precio = $_POST['precio'];
        $obj->estado = $_POST['estado'];

        $this->vista->producto=$obj;
        //mensaje
        $this->vista->mensaje =
        "<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Actualizado con Exito el Producto
            <a href='$url'> Revisar los Productos</a>
        </div>
        ";

      } else {
        //error
        $this->vista->mensaje =
          "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Actualizado el Producto
            <a href='$url'> Revisar los Productos</a>
        </div>
        ";
      }
      $this->vista->render('producto/verproducto');
    }
  }
  /*
  ========================================================
     Funcion que usa parametros para ELIMINAR
  ========================================================
*/
  //funcion eliminar con parametro
  function eliminarProducto($parametro=null)
  {
    //asignamos el id
    $id_producto=$parametro[0];
    $this->modelo->delete($id_producto);
  }
/*
  ===============================================================
     Funcion Render que se usa para ver los ESTADOS del Producto
  ===============================================================
*/
  //estados
  //funcion para ver otros estados
  function activoProducto()
  {
    //var = este modelo->su funcion con parametros vacios
    $productos=$this->modelo->estadoProducto('activo');
    //esta vista->objeto productomap= var
    $this->vista->productomap=$productos;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('producto/consultarproducto');
  }
  //funcion para ver otros estados
  function inactivoProducto()
  {
    //var = este modelo->su funcion con parametros vacios
    $productos=$this->modelo->estadoProducto('inactivo');
    //esta vista->objeto productomap= var
    $this->vista->productomap=$productos;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('producto/consultarproducto');
  }
  //funcion para ver otros estados
  function suspendidoProducto()
  {
    //var = este modelo->su funcion con parametros vacios
    $productos=$this->modelo->estadoProducto('suspendido');
    //esta vista->objeto productomap= var
    $this->vista->productomap=$productos;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('producto/consultarproducto');
  }
}
 ?>
