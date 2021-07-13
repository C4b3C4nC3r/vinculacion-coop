<?php

/**
 *Probar con EL sinonimo suministrador
 *revisado 215as1sdas
 */
class Proveedor extends Controlador
{
/*
  =================================================================================================================
   Funcion constructor | Llama al pariente:_constructor| Funcion Render para mandar parametros
                                                       |>>libs/view.php/class/Vista/render($_POST['nombre'] )0
  ==================================================================================================================
*/
  function __construct()
  {
    parent::__construct();

    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($_POST['nombre'])
  }
  /*
  =========================================================================================
   Funcion render ...CODIGO que llama al ('proveedor/index')
  =========================================================================================
*/
  function render()
  {
    $this->vista->render('proveedor/index');
  }
  /*
  ==============================================================================
     AJAX Funcion que usa un POST para Consultar el proveedor que va a Agregar
  ==============================================================================
*/
  function agregarProveedor()
  {
    $url=constant('URL').'consultarproveedor';

      //regla, y si lo retrona un true se manda el mensaje
      if ($this->modelo->insertarProveedor(['ruc'=>$_POST['ruc'],'nombre'=>$_POST['nombre'],'telefono'=>$_POST['telefono'],'correo'=>$_POST['correo'],'direccion'=>$_POST['direccion']])) {
        //mensaje
        ?>
        <div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Ingresado con Exito el Proveedor
            <a href='<?php echo $url ?>'> Revisar los Proveedores</a>
        </div>
        <?php
        }else{
        //error
        ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Ingresado el Proveedor
            <a href='<?php echo $url ?>'> Revisar los Proveedores</a>
        </div>
        <?php
        }
    }
    //funciones de estado
    /*============================================================================
    FUNCION PARA LLAMAR A LA FUNCION BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
      ============================================================================
    */
    function buscarRegistro()
    {

        if ($this->modelo->buscarProveedor(['ruc'=>$_GET['ruc']])) {
          ?>
          <p style="font-size:10px;color:red;">
            Este numero de Cedula o RUC ya esta registrado
          </p>
          <?php
        }else{
          $bool=true;
          echo $bool;
        }
    }

  }
?>
