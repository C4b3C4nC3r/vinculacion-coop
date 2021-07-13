<?php

/**
 *revisado
 */
class Socio extends Controlador
{
/*
  =======================================================================================================================
    Funcion constructor| LLAMA a pariente constructor |Esta variable va a cojer la funcion render para madar parametros
                                                      | >>libs/view.php/class/Vista/render($_POST['nombre'])
  =======================================================================================================================
*/
  function __construct()
  {
    parent::__construct();

    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($_POST['nombre'])
  }
  function render()
  {
    $this->vista->render('socio/index');
    // code...
  }
/*
  ====================================================================================================
     AJAX Funcion que usa un POST consultar a socio y luego gurdar los datos de Socio | Reserva la URL
  ====================================================================================================
*/
  function agregarSocio()
  {

    $url=constant('URL').'consultarsocio';//link

    if ($this->modelo->insertarSocio(['fecha_inicio'=>$_POST['fecha_inicio'],'cedula'=>$_POST['cedula'],'nombre'=>$_POST['nombre'],'apellido'=>$_POST['apellido'],'telefono'=>$_POST['telefono'],'correo'=>$_POST['correo'],'direccion'=>$_POST['direccion']])) {
      //mensaje
      ?>
      <div class='alert alert-info alert-dismissible fade show' role='alert'>
          <strong>Exitoso</strong> Se ha Actualizado con Exito el Socio
          <a href='<?php echo $url ?>'> Revisar los Socios</a>
      </div>
      <?php
    }else{
      //error
      ?>
      <div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>No Exitoso</strong> No Se ha Actualizado el Socio
          <a href='<?php echo $url ?>'> Revisar los Socios</a>
      </div>
      <?php
    }
  }

  /*============================================================================
  FUNCION PARA LLAMAR A LA FUNCION BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  function buscarRegistro()
  {

      if ($this->modelo->buscarSocio(['cedula'=>$_GET['cedula']])) {
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
