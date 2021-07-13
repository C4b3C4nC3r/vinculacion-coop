<?php

/**
*CLASE DE ConsultaProveedor, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado
 */
class ConsultarProveedor extends Controlador //se extiende al controlador en libs/controller
{
/*
  ============================================================================================================
     Funcion constructor para llamar al pariente_costruct | la variable cojera al render y mandara parametros
  ============================================================================================================
*/
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto proveedormap (Class ProveedorMap)
    $this->vista->proveedormap= [];
    //mensaje en vista
    //$this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
  }
/*
  ==============================================================================
     Funcion Render con parametros vacios | revisa en models y muestra en views
  ==============================================================================
*/
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $proveedor=$this->modelo->darProveedor();
    //esta vista->objeto proveedormap= var
    $this->vista->proveedormap=$proveedor;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('proveedor/consultarproveedor');
  }
  /*
  ==================================================
    Funcion con parametros para Ver los Proveedores 
  ==================================================
*/
  //para visualizar
  function verProveedor($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_proveedor=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $proveedor=$this->modelo->darPorId($id_proveedor);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_proveedor']=$proveedor->id_proveedor;
    //pasamos a vista materia
    $this->vista->proveedor = $proveedor;
    //enviamos en vista un mensaje vaciio
    $this->vista->$mensaje="";
    //renderizamos
    $this->vista->render('proveedor/verproveedor');
    /*
    Mostrar los array
    var_dump($parametro);
    */
  }
/*
  =========================================================================================
     AJAX Funcion con parametros que usa un POST para buscar el proveedor que va a mostrar
  =========================================================================================
*/
  //para visualizar
  function buscarProveedor()//con parametro
  {
    $proveedores=$this->modelo->hallarProveedor(['buscar'=>$_POST['buscado']]);
    //esta vista->objeto proveedormap= var
    $this->vista->proveedormap=$proveedores;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('proveedor/consultarproveedor');

  }
/*
  ==========================================================================
     AJAX Funcion  que usa un POST para actualizar los datos del proveedor 
  ==========================================================================
*/
  //funcion de actualizar
  function actualizarProveedor()
  {
    $url=constant('URL').'consultarproveedor';//link

    //iniciamos session
    session_start();
    //cambiamos de variable
    $id_proveedor=$_SESSION['id_proveedor'];
    //recojemos
    $ruc=$_POST['ruc'];
    $nombre=$_POST['nombre'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
    $direccion=$_POST['direccion'];
    $estado=$_POST['estado'];
    //destrir sessiones
    unset($_SESSION['id_proveedor']);
    //funcion, este modelo, conla funcion update(parametros como un array)
    if ($this->modelo->update(['id_proveedor'=>$id_proveedor,'ruc'=>$ruc,'nombre'=>$nombre,'telefono'=>$telefono,'correo'=>$correo,'direccion'=>$direccion,'estado'=>$estado])) {
        // actualizar matricula
        $proveedor=new ProveedorMap();//objeto
        //retornar correoes a vistya
        $proveedor->id_proveedor=$id_proveedor;
        $proveedor->ruc=$ruc;
        $proveedor->nombre=$nombre;
        $proveedor->telefono=$telefono;
        $proveedor->correo=$correo;
        $proveedor->direccion=$direccion;
        $proveedor->estado=$estado;
        //empezar a enviar vista para desglozarlo
        $this->vista->proveedor=$proveedor;
        //mensaje
        $this->vista->mensaje=
        "<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Actualizado con Exito el Proveedor
            <a href='$url'> Revisar los Proveedor</a>
        </div>
        ";
      }else{
        //error
        $this->vista->mensaje=
        "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>No Exitoso</strong> No Se ha Actualizado el Proveedor
            <a href='$url'> Revisar los Proveedor</a>
        </div>
        ";
        }
    //renderizamos la vista
    $this->vista->render('proveedor/verproveedor');
  }
/*
  ====================================================
    Funcion con parametros que elimina al proveedor
  ====================================================
*/
  //funcion eliminar con parametro
  function eliminarProveedor($parametro=null)
  {
    //asignamos el id
    $id_proveedor=$parametro[0];
    // mapeo
    //condicional
    //funcion, este modelo con la funcion delete(parametro)
    if ($this->modelo->delete($id_proveedor)) {//enviamos el id
        //mensaje
        //$this->vista->para mapeo

    }
  }
/*
  =====================================================================================
   Funcion con parametros que muestra el estado en el que se encuentra el proveedor
  =====================================================================================
*/
  //funcion para ver otros estados
  function activoProveedor()
  {
    //var = este modelo->su funcion con parametros vacios
    $proveedores=$this->modelo->estadoProveedor('activo');
    //esta vista->objeto proveedormap= var
    $this->vista->proveedormap=$proveedores;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('proveedor/consultarproveedor');
  }
  //funcion para ver otros estados
  function inactivoProveedor()
  {
    //var = este modelo->su funcion con parametros vacios
    $proveedores=$this->modelo->estadoProveedor('inactivo');
    //esta vista->objeto proveedormap= var
    $this->vista->proveedormap=$proveedores;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('proveedor/consultarproveedor');
  }
  //funcion para ver otros estados
  function suspendidoProveedor()
  {
    //var = este modelo->su funcion con parametros vacios
    $proveedores=$this->modelo->estadoProveedor('suspendido');
    //esta vista->objeto proveedormap= var
    $this->vista->proveedormap=$proveedores;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('proveedor/consultarproveedor');
  }
}
 ?>
