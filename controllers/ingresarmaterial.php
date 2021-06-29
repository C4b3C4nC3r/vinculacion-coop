<?php

class IngresarMaterial extends Controlador //se extiende al controlador en libs/controller
{
  //conructor
  function __construct()
  {
    parent::__construct();
    $this->vista->mensaje="";//variable mensaje
    $this->vista->ingresarmaterialmap= [];//para el proveedor
  //  $this->vista->detalleingresomap= [];//para la tabla de detalle_ingreso
    $this->vista->materialmap= [];//para la tabla de detalle_ingreso

  }
  //FUNCIOND RENDER
  function render()
  {

    $ingresarmateriales=$this->modelo->foraneaKey();//funcion SELECT MAP
    $this->vista->ingresarmaterialmap=$ingresarmateriales;//map
    $materiales=$this->modelo->foraneaKeyMaterial();//funcion SELECT MAP
    $this->vista->materialmap=$materiales;//map
    $this->vista->render('material/ingresarmaterial');//ruta
  }
  //FUNCION PARA INSERT EN INGRESO_MATERIAKL
  function agregarIngresarMaterial()
  {
    $url=constant('URL').'consultaringresarmaterial';//ruta
    if (!empty($_POST['id_proveedor'])&&!empty($_POST['numero_factura'])&&!empty($_POST['fecha'])
    &&!empty($_POST['porcentaje'])) {//Ver como validar el porcentaje para evitar el error que no la reconosca
      //en iva del 0 prociento
    //session_start();
      if (!empty($_POST['subtotal_material'])) {//subtotal
        $iva=$_POST['subtotal_material']*$_POST['porcentaje']/100;///iva
        $total=$_POST['subtotal_material']+$iva;//total
      //FUNCION PARA INSERTAR EL INGRESO_MATERIAKL
      if ($this->modelo->insertarIngresarMaterial(['id_proveedor'=>$_POST['id_proveedor'],'numero_factura'=>$_POST['numero_factura'],'fecha'=>$_POST['fecha'],'subtotal'=>$_POST['subtotal_material'],'iva'=>$iva,'total'=>$total])) {
        //FUNCION PARA TRAER EL ID DE LO QUE SE INSERTO
        if ($id_ingreso_material=$this->modelo->darId(['id_proveedor'=>$_POST['id_proveedor'],'numero_factura'=>$_POST['numero_factura']])) {
            if (!empty($id_ingreso_material->id_ingresar_material)) {//VALIDAR SI TRAE ALGO
              $id=$id_ingreso_material->id_ingresar_material;
            }else{
              die("
              <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Esta Al Limite</strong> El Numero o Codigo de Factura que ha ingresao esta al limite
                   <b>Revisar El codigo de Factura</b>
              </div>
              "
              );
            }
            //ERROR 10/4->se supone que es dobl click
          if ($this->detalleIngreso(['id_ingreso_material'=>$id])) {//FUNCION INTERNA
            //mensaje
            ?>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Exitoso</strong> Se ha Ingresado con Exito el Materiales
                <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
            </div>
          <?php
          }else{
            ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Se Ha Detallado</strong> Has mandado doble click :V
                <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
            </div>
            <?php
            }
          }else{
            ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>No Se Ha Encontrado</strong> Error en la Busqueda
                <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
            </div>
            <?php
          }
        }else{
          ?>
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>No Se Ha Ingresado</strong> No se Puede Ingresar este formualrio
              <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
          </div>
          <?php

        }
      }else{
        //error
        ?>
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Ingrese Un detalle </strong> Sin detalle No se puede Ingresar
            <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
        </div>
        <?php

      }
    }else{
      ?>
      <div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Datos </strong> Los Datos Ingresados No fueron Recibidos
          <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
      </div>
      <?php
    }
  }
  //CRUD PARA DETALLE_INGRESO
  function detalleIngreso ($id)
  {
    $id_ingreso_material=$id['id_ingreso_material'];//extraer el id
    //$objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();//extraer el array
    //se le envia el array para llenar el respectivo detalle_ingreso...
    if ($this->modelo->agregarDetalleIngreso(['id_ingreso_material'=>$id_ingreso_material])) {//enviar el detalle
      // true
      return true;
    }else{
      //false
      return false;
    }
  }

  function detalle()//FUNCION PARA USAR LA TABLA TEMPORAL
  {
      if (!empty($_POST['id_material'])&&!empty($_POST['valor'])&&!empty($_POST['cantidad'])) {
        session_start();
        $id_usuario=$_SESSION['id_usuario'];
        //INSERTAMOS VALORES PARA LA TABLA TEMPORAL
        if ($this->modelo->llenarDatosTablaTemporal(['id_material'=>$_POST['id_material'],'id_usuario'=>$id_usuario,'cantidad'=>$_POST['cantidad'],'valor'=>$_POST['valor']])) {//para ingresar a la tabal tempral
          $this->renderDetalle();
        }else{
          ?>
          <div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <strong>ERROR EN DETALLE</strong>errores en logica
              <a href='<?php echo $url ?>'> Revisar los Ingresos de los Materiales</a>
          </div>
          <?php

        }
      }
  }
  function renderDetalle()
  {
    $objTablaTemporal=$this->modelo->extraerDatosTablaTemporal();
    $jsonstring=json_encode($objTablaTemporal);
    echo $jsonstring;

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
  /*============================================================================
  FUNCION PARA LLAMAR A LA FUNCION BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  function buscarRegistro()
  {

      if ($this->modelo->buscarDatosFacturaProveedor(['numero_factura'=>$_GET['numero_factura'],'id_proveedor'=>$_GET['id_proveedor']])) {
        ?>
        <p style="font-size:10px;color:red;">
          Este numero de factura ya esta registrado con el proveedor que elejiste
        </p>
        <?php
      }else{
        $bool=true;
        echo $bool;
      }
  }
  /*
  FUNCION PARA HACER UN INPUT DINAMICO
  BUSCAR EL PRODUCTO DE MATERIAL
  */
  function buscarMaterialInput()
  {
    $objMaterial=$this->modelo->extraerDatosTablaMaterial(['codigo_material'=>$_GET['codigo_material'],'producto'=>$_GET['producto']]);
    $jsonstring=json_encode($objMaterial);
    echo $jsonstring;
  }
}
?>
