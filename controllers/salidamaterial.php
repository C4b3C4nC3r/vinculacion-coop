<?php

class SalidaMaterial extends Controlador //se extiende al controlador en libs/controller
{
  //conructor
  function __construct()
  {
    parent::__construct();
    $this->vista->mensaje="";//variable mensaje
    $this->vista->sociomap= [];//para el proveedor
    $this->vista->detallematerialmap= [];//para la tabla de detalle_ingreso
    $this->vista->materialmap= [];//para la tabla de detalle_ingreso
    $this->vista->pedidomap= [];//para la tabla de detalle_ingreso

  }
  //FUNCIOND RENDER
  function render()
  {

    $socios=$this->modelo->foraneaKey();//funcion SELECT MAP
    $this->vista->sociomap=$socios;//map
    $materiales=$this->modelo->foraneaKeyMaterial();//funcion SELECT MAP
    $this->vista->materialmap=$materiales;//map
    $pedidos=$this->modelo->foraneaKeyPedido();//funcion SELECT MAP
    $this->vista->pedidomap=$pedidos;
    $this->vista->render('material/salidamaterial');//ruta
  }

  function renderSalida()
  {
    //render is hay tablas
    $objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();
    $jsonstring=json_encode($objTablaTemporal);
    echo $jsonstring;
  }
  //FUNCION PARA INSERT EN INGRESO_MATERIAKL
  function agregarSalidaMaterial()
  {
    $url=constant('URL').'consultarsalidamaterial';//ruta
    if (!empty($_POST['id_socio'])&&!empty($_POST['id_pedido'])&&!empty($_POST['fecha'])) {//verificacion
      if ($this->modelo->insertarSalidaMaterial(['id_socio'=>$_POST['id_socio'],'id_pedido'=>$_POST['id_pedido'],'fecha'=>$_POST['fecha']])) {
        //FUNCION PARA TRAER EL ID DE LO QUE SE INSERTO
        if ($id_salida_material=$this->modelo->darId(['id_socio'=>$_POST['id_socio'],'id_pedido'=>$_POST['id_pedido']])) {
            if (!empty($id_salida_material->id_salida_material)) {//VALIDAR SI TRAE ALGO
              $id=$id_salida_material->id_salida_material;
            }else{
            ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>No encontrado</strong>
                <a href='<?php echo $url ?>'> Revisar los Materiales</a>
            </div>
            <?php
            }
          if ($this->detalleSalida(['id_salida_material'=>$id])) {//FUNCION INTERNA
            ?><div class='alert alert-info alert-dismissible fade show' role='alert'>
                <strong>Exitoso</strong> Se ha Ingresado con Exito el Materiales
                <a href='<?php echo $url ?>'> Revisar los Materiales</a>
            </div>
            <?php
          }else{
              //error
              ?><div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  <strong>No Exitoso</strong> No Se ha Ingresado el Materiales
                  <a href='$url'> Revisar Los Ingresos de Materiales</a>
              </div>
              <?php
              }
        }else{
            ?><div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>ERROR1</strong> No Se ha Ingresado el Materiales
                <a href='$url'> Revisar Los Ingresos de Materiales</a>
            </div>
          <?php

          }
        }else{
          ?><div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>4ERROR</strong> No Se ha Ingresado el Materiales
              <a href='$url'> Revisar Los Ingresos de Materiales</a>
          </div>
          <?php
        }
    }else{
      ?><div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>ERROR2</strong> No Se ha Ingresado el Materiales
          <a href='$url'> Revisar Los Ingresos de Materiales</a>
      </div>
      <?php
    }
  }
  //CRUD PARA DETALLE_INGRESO
  function detalleSalida ($id)
  {
    $id_salida_material=$id['id_salida_material'];//extraer el id
    //$objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//extraer el array
    //se le envia el array para llenar el respectivo detalle_ingreso...
    if ($this->modelo->agregarDetalleMaterial(['id_salida_material'=>$id_salida_material])) {//enviar el detalle
      // true
      return true;
    }else{
      //false
      return false;
    }
  }

  function detalle()//FUNCION PARA USAR LA TABLA TEMPORAL
  {
      if (!empty($_POST['id_material'])&&!empty($_POST['cantidad'])) {
        session_start();
        $id_usuario=$_SESSION['id_usuario'];
        //INSERTAMOS VALORES PARA LA TABLA TEMPORAL
        if ($this->modelo->llenarDatosTablaTemporal(['id_material'=>$_POST['id_material'],'id_usuario'=>$id_usuario,'cantidad'=>$_POST['cantidad']])) {//para ingresar a la tabal tempral
          $this->renderSalida();
        }else{
          ?>
          <div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <strong>ERROR</strong> Errror en ingresar el detalle
          </div>
          <?php
        }
      }
  }
  //CRUD PARA TEMPORAL
  function eliminado()
  {

    $this->modelo->delete(['id_temporal'=>$_POST['id_temporal']]);
    ?>
    <div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>Eliminado</strong> Se ha eliminado del Registro
    </div>
    <?php
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
  //dasds

}
?>
