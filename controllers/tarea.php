<?php

class Tarea extends Controlador //se extiende al controlador en libs/controller
{
  //conructor
  function __construct()
  {
    parent::__construct();
    $this->vista->mensaje="";//variable mensaje
    $this->vista->sociomap= [];//para el proveedor
  //  $this->vista->detalletareamap= [];//para la tabla de detalle_ingreso
    $this->vista->pedidomap= [];//para la tabla de detalle_ingreso

  }
  //FUNCIOND RENDER
  function render()
  {
    $socios=$this->modelo->foraneaKey();//funcion SELECT MAP
    $this->vista->sociomap=$socios;//map
    $pedidos=$this->modelo->foraneaKeyPedido();//funcion SELECT MAP
    $this->vista->pedidomap=$pedidos;//map
    $this->vista->render('tarea/index');//ruta
  }
  function rendertarea()
  {
    //render is hay tablas
    $objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//funcion SELECT MAP
    $jsonstring=json_encode($objTablaTemporal);
    echo $jsonstring;
  }
  function agregarTarea()
  {
    $url=constant('URL').'consultartarea';//ruta
    if (!empty($_POST['id_socio'])&&!empty($_POST['fecha_asignacion'])&&!empty($_POST['fecha_entrega'])&&!empty($_POST['id_pedido'])) {
        if ($this->modelo->insertarTarea(['id_socio'=>$_POST['id_socio'],'fecha_asignacion'=>$_POST['fecha_asignacion'],'fecha_entrega'=>$_POST['fecha_entrega'],'id_pedido'=>$_POST['id_pedido']])) {
          //si return true
          if($tarea=$this->modelo->darId(['id_socio'=>$_POST['id_socio'],'id_pedido'=>$_POST['id_pedido']])){
            //retornamos un obj
            if (!empty($tarea->id_tarea)) {
              $id=$tarea->id_tarea;
            }else{
              die("
              <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Esta Al Limite</strong> Problemas del leght en base de datos
                   <b>Revisar El codigo de Factura</b>
              </div>
              "
              );
            }
            if ($this->detalleTarea(['id_tarea'=>$id])) {
              //mensaje
              ?><div class='alert alert-info alert-dismissible fade show' role='alert'>
                    <strong>Exitoso</strong> Se ha Ingresado con Exito el tarea
                    <a href='<?php echo $url ?>'> Revisar los tareas</a>
                </div>
              <?php
            }else{
              ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error</strong> No Se ha Ingresado con Exito el tarea
                </div>
              <?php
            }
          }else{
            ?><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Error</strong>  No Se ha encontrado el Ingreso del tarea
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
            <strong>Datos vacios</strong>
         </div>
      <?php
    }
  }
  function detalle()
  {
    if (!empty($_POST['id_producto'])&&!empty($_POST['cantidad'])) {
      if ($this->modelo->agregarTablaTemporal(['id_producto'=>$_POST['id_producto'],'cantidad'=>$_POST['cantidad']])) {
        //$this->renderTarea();
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
  function detalleTarea ($id)
  {
    $id_tarea=$id['id_tarea'];//extraer el id
    //$objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//extraer el array
    //se le envia el array para llenar el respectivo detalle_ingreso...
    if ($this->modelo->agregarDetalleTarea(['id_tarea'=>$id_tarea])) {//enviar el detalle
      // true
      return true;
    }else{
      //false
      return false;
    }
  }
}
?>
