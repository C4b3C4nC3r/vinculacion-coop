<?php

class Pedido extends Controlador //se extiende al controlador en libs/controller
{
  //conructor
  function __construct()
  {
    parent::__construct();
    $this->vista->mensaje="";//variable mensaje
    $this->vista->clientemap= [];//para el proveedor
  //  $this->vista->detallepedidomap= [];//para la tabla de detalle_ingreso
    $this->vista->productomap= [];//para la tabla de detalle_ingreso

  }
  //FUNCIOND RENDER
  function render()
  {
    $clientes=$this->modelo->foraneaKey();//funcion SELECT MAP
    $this->vista->clientemap=$clientes;//map
    $productos=$this->modelo->foraneaKeyProducto();//funcion SELECT MAP
    $this->vista->productomap=$productos;//map
    $this->vista->render('pedido/index');//ruta
  }
  function renderPedido()
  {
    //render is hay tablas
    $objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//funcion SELECT MAP
    $jsonstring=json_encode($objTablaTemporal);
    echo $jsonstring;
  }
  function agregarPedido()
  {
    $url=constant('URL').'consultarpedido';//ruta
    if (!empty($_POST['id_cliente'])&&!empty($_POST['fecha_entrada'])&&!empty($_POST['fecha_salida'])&&!empty($_POST['comentario'])) {

      if (!empty($_POST['total_pedido'])) {
        $total=$_POST['total_pedido'];
        if ($this->modelo->insertarPedido(['id_cliente'=>$_POST['id_cliente'],'fecha_entrada'=>$_POST['fecha_entrada'],'fecha_salida'=>$_POST['fecha_salida'],'comentario'=>$_POST['comentario'],'total'=>$total])) {
          //si return true
          if($pedido=$this->modelo->darId(['id_cliente'=>$_POST['id_cliente'],'comentario'=>$_POST['comentario']])){
            //retornamos un obj
            if (!empty($pedido->id_pedido)) {
              $id=$pedido->id_pedido;
            }else{
              die("
              <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Esta Al Limite</strong> Problemas del leght en base de datos
                   <b>Revisar El codigo de Factura</b>
              </div>
              "
              );
            }
            if ($this->detallePedido(['id_pedido'=>$id])) {
              //mensaje
              ?><div class='alert alert-info alert-dismissible fade show' role='alert'>
                    <strong>Exitoso</strong> Se ha Ingresado con Exito el Pedido
                    <a href='<?php echo $url ?>'> Revisar los Pedidos</a>
                </div>
              <?php
            }else{
              ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error</strong> No Se ha Ingresado con Exito el Pedido
                </div>
              <?php
            }
          }else{
            ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Error</strong>  No Se ha encontrado el Ingreso del Pedido
              </div>
            <?php
          }
        }else{
          ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Datos Vacios</strong>
            </div>
          <?php

        }
     }else{
       ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
             <strong>TOTAL VACIO</strong>
          </div>
       <?php
     }
    }else{
      ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Datos vacios</strong>
         </div>
      <?php
    }
  }
  function detalle()
  {
    if (!empty($_POST['id_producto'])&&!empty($_POST['cantidad'])) {

      if ($this->modelo->agregarTablaTemporal(['id_producto'=>$_POST['id_producto'],'cantidad'=>$_POST['cantidad']])) {
        $this->renderPedido();
      }else{
        //mensaje
        ?>
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>No hay Objetos</strong>
        </div>
      <?php
      }
    }
  }
  //CRUD PARA TEMPORAL
  function cancelado()
  {
    $this->modelo->eliminarTablaTemporal();
    ?>
    <div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>Cancelado</strong> El Ingreso Del Material Se ha Cancelado
    </div>
    <?php
  }
  function eliminado()
  {
    $this->modelo->delete(['id_temporal'=>$_POST['id_temporal']]);
    ?>
    <div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>Eliminado</strong> Se ha eliminado del Registro
    </div>
    <?php
  }
  //CRUD PARA DETALLE_INGRESO
  function detallePedido ($id)
  {
    $id_pedido=$id['id_pedido'];//extraer el id
    //$objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//extraer el array
    //se le envia el array para llenar el respectivo detalle_ingreso...
    if ($this->modelo->agregarDetallePedido(['id_pedido'=>$id_pedido])) {//enviar el detalle
      // true
      return true;
    }else{
      //false
      return false;
    }
  }
}
?>
