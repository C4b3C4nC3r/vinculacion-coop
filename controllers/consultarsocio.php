<?php

/**
*CLASE DE ConsultaSocio, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *
 */
class ConsultarSocio extends Controlador //se extiende al controlador en libs/controller
{
/*
  ===================================================================
    Funcion constructor llama al pariente, render y manda parametros
  ===================================================================
*/
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto sociomap (Class SocioMap)
    $this->vista->sociomap= [];
    //mensaje en vista
    //$this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
  }
  //fun render
/*
  ===============================================
     AJAX Funcion RENDER CON PARAMETROS VACIOS
  ===============================================
*/
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $socios=$this->modelo->darSocio();
    //esta vista->objeto sociomap= var
    $this->vista->sociomap=$socios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('socio/consultarsocio');
  }
  /*
  =========================================================================================
     AJAX Funcion con parametros que usa un POST para buscar el  Socio que va a mostrar
  =========================================================================================
*/
  //para visualizar
  function verSocio($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_socio=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $socio=$this->modelo->darPorId($id_socio);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_socio']=$socio->id_socio;
    //pasamos a vista materia
    $this->vista->socio = $socio;
    //enviamos en vista un mensaje vacio
    $this->vista->$mensaje="";
    //renderizamos
    $this->vista->render('socio/versocio');
    /*
    Mostrar los array
    */
    //var_dump($parametro);
  }
  /*
  =================================================================
   Funcion con parametros que usa un POST para Consultar el Socio 
  =================================================================
*/
  //para visualizar
  function buscarSocio()//conn parametro
  {
    $socios=$this->modelo->hallarSocio(['buscar'=>$_POST['buscado']]);
    //esta vista->objeto sociomap= var
    $this->vista->sociomap=$socios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('socio/consultarsocio');

  }
  /*
  ===================================================================
     AJAX Funcion con parametros  para Actualizar al Socio y su URL
  ===================================================================
*/
  //funcion de actualizar
  function actualizarSocio()
  {
    $url=constant('URL').'consultarsocio';//link
    //iniciamos session
    session_start();
    //cambiamos de variable
    $id_socio=$_SESSION['id_socio'];
    //recojemos
    $cedula=$_POST['cedula'];
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
    $direccion=$_POST['direccion'];
    $estado=$_POST['estado'];
    //destrir sessiones
    unset($_SESSION['id_socio']);
    //funcion, este modelo, conla funcion update(parametros como un array)
    if ($this->modelo->update(['id_socio'=>$id_socio,'cedula'=>$cedula,'nombre'=>$nombre,'apellido'=>$apellido,'telefono'=>$telefono,'correo'=>$correo,'direccion'=>$direccion,'estado'=>$estado])) {
        // actualizar matricula
        $socio=new SocioMap();//objeto
        //retornar correoes a vistya
        $socio->id_socio=$id_socio;
        $socio->fecha_inicio=$fecha_inicio;
        $socio->nombre=$nombre;
        $socio->cedula=$cedula;
        $socio->apellido=$apellido;
        //$socio->celular=$celular;
        $socio->telefono=$telefono;
        $socio->correo=$correo;
        $socio->direccion=$direccion;
        $socio->estado=$estado;
        //empezar a enviar vista para desglozarlo
        $this->vista->socio=$socio;
        //mensaje
        $this->vista->mensaje=
        "<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Actualizado con Exito el Socio
            <a href='$url'> Revisar los Socios</a>
        </div>
        ";
      }else{
        //error
        $this->vista->mensaje=
        "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Actualizado el Socio
            <a href='$url'> Revisar los Socios</a>
        </div>
        ";
        }
    //renderizamos la vista
    $this->vista->render('socio/versocio');
  }
  /*
  ==================================================================
   Funcion con parametros que va a Eliminar al socio usando su ID
  ==================================================================
*/
  //funcion eliminar con parametro
  function eliminarSocio($parametro=null)
  {
    //asignamos el id
    $id_socio=$parametro[0];
    // mapeo
    //condicional
    //funcion, este mdoelo conla fun delete(parametro)
    if ($this->modelo->delete($id_socio)) {//enviamos el id
        //mensaje
        //$this->vista->para mapeo

    }
    //$this->render('Socio/consultarsocio');
    //echo "Se Elimino".$id_socio;
  }
/*
  =========================================================================================
   TRES Funciones con parametros vacios para mostrar el estado del Socio
  =========================================================================================
*/
  //funcion para ver otros estados
  function activoSocio()
  {
    //var = este modelo->su funcion con parametros vacios
    $socios=$this->modelo->estadoSocio('activo');
    //esta vista->objeto sociomap= var
    $this->vista->sociomap=$socios;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('socio/consultarsocio');
  }
  //funcion para ver otros estados
  function inactivoSocio()
  {
    //var = este modelo->su funcion con parametros vacios
    $socios=$this->modelo->estadoSocio('inactivo');
    //esta vista->objeto sociomap= var
    $this->vista->sociomap=$socios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('socio/consultarsocio');
  }
  //funcion para ver otros estados
  function suspendidoSocio()
  {
    //var = este modelo->su funcion con parametros vacios
    $socios=$this->modelo->estadoSocio('suspendido');
    //esta vista->objeto sociomap= var
    $this->vista->sociomap=$socios;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('socio/consultarsocio');
  }
}
 ?>
