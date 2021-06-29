<?php

/**
*CLASEDE Material, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado el 2021/05/26
 */
class Usuario extends Controlador //se extiende al controlador en libs/controller
{
/*
  ================================================================================================================================
    Funcion constructor| LLAMA a pariente constructor | Mensaje en Vista |Esta variable va a cojer la funcion render para madar
                                                                         |parametros >>libs/view.php/class/Vista/render($nombre)
  ================================================================================================================================
*/
  function __construct()
  {

    parent::__construct();
    //mensaje en vista
    $this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
  }
  //fun render
  function render()
  {
    //renderuzar
    $this->vista->render('usuario/index');
  }
  //funcion agregar
  /*
  ============================================================================================================
     AJAX Funcion que usa un POST consultar a USUARIO y luego gurdar los datos de usuario | Reserva la URL
  ============================================================================================================
*/
  function agregarUsuario()
  {
    $url=constant('URL').'consultarusuario';//link

    /*
    ================================================================================================
      Mapeo | variables, hacer validaciones ect... | subtraer->string->positiones(0-1-2-3...)
    ================================================================================================
    */
    $usuario=$_POST['usuario'];
    $nombre_usuario=$_POST['nombre_usuario'];
    $clave=substr($usuario,0,4)."222";//contrasena default
    $mensaje="";
    //regla, y si lo retrona un true se manda el mensaje
    if ($this->modelo->insertarUsuario(['usuario'=>$usuario,'nombre_usuario'=>$nombre_usuario,'clave'=>$clave])) {
      //mensaje
      ?><div class='alert alert-info alert-dismissible fade show' role='alert'>
          <strong>Exitoso</strong> Se ha Ingresado con Exito el Usuario
          <a href='<?php echo $url ?>'> Revisar los Usuarios</a>
      </div>
      <?php
    }else{
      //error
      ?><div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>No Exitoso</strong> No Se ha Ingresado el Usuario
          <a href='<?php echo $url ?>'> Revisar los Usuarios</a>
      </div>
      <?php
    }
  }
  //FUNCION PARA BUSCAR EL NOMBRE USUARIO
  /*============================================================================
  FUNCION PARA LLAMAR A LA FUNCION BUSCAR Y EVITAR QUE EL USUARIO INGRESE UN REGISTRO
    ============================================================================
  */
  function buscarRegistro()
  {
      if ($this->modelo->buscarUsuario(['usuario'=>$_GET['usuario']])) {
        ?>
        <p style="font-size:10px;color:red;">
          Este Usuario ya esta registrado
        </p>
        <?php
      }else{
        $bool=true;
        echo $bool;
      }
  }

}


 ?>
