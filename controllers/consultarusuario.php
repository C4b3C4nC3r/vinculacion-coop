<?php

/**revisado
*CLASE DE ConsultaMaterial, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class ConsultarUsuario extends Controlador //se extiende al controlador en libs/controller
{ 
/*
  ===============================================
    Funcion donde llamamos al pariente_construct
  ===============================================
*/
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto usuariomap (Class MaterialMap)
    $this->vista->usuariomap= [];
    //mensaje en vista
    //$this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
  }
  /*
  ================================
   Funcion Render con parametros
  ================================
*/
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $usuarios=$this->modelo->darUsuario();
    //esta vista->objeto usuariomap= var
    $this->vista->usuariomap=$usuarios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('usuario/consultarusuario');
  }
/*
  ========================================================
    Funcion con parametros que CREA UNA SESION O USUARIO
  ========================================================
*/
  //para visualizar
  function verUsuario($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_usuario=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $usuario=$this->modelo->darPorId($id_usuario);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_usuariotb']=$usuario->id_usuario;
    //pasamos a vista materia
    $this->vista->usuario = $usuario;
    //enviamos en vista un mensaje vaciio
    $this->vista->$mensaje="";
    //renderizamos
    $this->vista->render('usuario/verusuario');
    /*
    Mostrar los array
    var_dump($parametro);
    */
  }
/*
  =========================================================================
   Funcion con parametros que MUESTRA EL USUARIO mediante una consulta
  =========================================================================
*/
  //para visualizar
  function buscarUsuario()//conn parametro
  {
    $usuarios=$this->modelo->hallarUsuario(['buscar'=>$_POST['buscado']]);
    //esta vista->objeto usuariomap= var
    $this->vista->usuariomap=$usuarios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('usuario/consultarusuario');

  }
/*
  =========================================================================================
     AJAX Funcion con parametros que usa un POST para actualizar los datos del usuario
  =========================================================================================
*/
  //funcion de actualizar
  function actualizarUsuario()
  {
    $url=constant('URL').'consultarusuario';//link
    //iniciamos session
    session_start();
    //cambiamos de variable
    $id_usuario=$_SESSION['id_usuariotb'];
    //recojemos
    $usuario=$_POST['usuario'];
    $nombre_usuario=$_POST['nombre_usuario'];
    $clave=$_POST['clave'];
    $estado=$_POST['estado'];
    //destrir sessiones
    unset($_SESSION['id_usuariotb']);
    //funcion, este modelo, conla funcion update(parametros como un array)
    if ($this->modelo->update(['id_usuario'=>$id_usuario,'usuario'=>$usuario,'nombre_usuario'=>$nombre_usuario,'clave'=>$clave,'estado'=>$estado])) {
        // actualizar matricula
        $usuarioobj=new UsuarioMap();//objeto
        //retornar valores a vistya
        $usuarioobj->id_usuario=$id_usuario;
        $usuarioobj->usuario=$usuario;
        $usuarioobj->nombre_usuario=$nombre_usuario;
        //$usuarioobj->nombre=$nombre;
        $usuarioobj->clave=$clave;
        $usuarioobj->estado=$estado;
        //empezar a enviar vista para desglozarlo
        $this->vista->usuario=$usuarioobj;
        //mensaje
        session_start();
        if ($_SESSION['id_usuario']==$id_usuario) {
          $_SESSION['nombre_usuario']=$nombre_usuario;
        }
        $this->vista->mensaje=
        "<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Actualizado con Exito el Usuario
            <a href='$url'> Revisar los Usuarios</a>
        </div>
        ";
      }else{
        //error
        $this->vista->mensaje=
        "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Actualizado el Usuario
            <a href='$url'> Revisar los Usuarios</a>
        </div>
        ";
        }
    //renderizamos la vista
    $this->vista->render('usuario/verusuario');
  }
/*
  =============================================================================
    Funcion con parametros que sirve para eliminar a un usuario mediante el ID
  =============================================================================
*/
  //funcion eliminar con parametro
  function eliminarUsuario($parametro=null)
  {

      $id_usuario=$parametro[0];
      if ($this->modelo->delete($id_usuario)) {//enviamos el id

      }
    //asignamos el id
    // mapeo
    //condicional
    //funcion, este mdoelo conla fun delete(parametro)


  }
  /*
  ===================================================================
   Tres Funciones con parametros que muestra los estados del Usuario
  ===================================================================
*/
  function activoUsuario()
  {
    //var = este modelo->su funcion con parametros vacios
    $usuarios=$this->modelo->estadoUsuario('activo');
    //esta vista->objeto usuariomap= var
    $this->vista->usuariomap=$usuarios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('usuario/consultarusuario');
  }
  //funcion para ver otros estados
  function inactivoUsuario()
  {
    //var = este modelo->su funcion con parametros vacios
    $usuarios=$this->modelo->estadoUsuario('inactivo');
    //esta vista->objeto usuariomap= var
    $this->vista->usuariomap=$usuarios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('usuario/consultarusuario');
  }
  //funcion para ver otros estados
  function suspendidoUsuario()
  {
    //var = este modelo->su funcion con parametros vacios
    $usuarios=$this->modelo->estadoUsuario('suspendido');
    //esta vista->objeto usuariomap= var
    $this->vista->usuariomap=$usuarios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('usuario/consultarusuario');
  }
}
 ?>
