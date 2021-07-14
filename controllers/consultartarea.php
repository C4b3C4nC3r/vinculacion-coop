<?php



class ConsultarTarea extends Controlador//se extiende al controlador en libs/controller
{
  /*
    ==========================================================
     FUNCION CONSTRUCTOR LLAMA AL PARIENTE Y VISTA DEL tarea 
    ==========================================================
  */
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto materialmap (Class MaterialMap)
    $this->vista->tareamap= [];
  }
  /*
    ================================================================================
     FUNCION RENDER CON PARAMETROS VACIOS BUSCA EN MODELO PARA MOSTRARLOS POR VISTA
    ================================================================================
  */
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $tareas=$this->modelo->darTarea();
    //esta vista->objeto materialmap= var
    $this->vista->tareamap=$tareas;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('tarea/consultartarea');

  }
  /*
    =========================================================================
     AJAX Serie de Funcion Busca tarea con parametros usando el metodo POST
    =========================================================================
  */
  function buscarTarea()//con parametro
  {
    //funciona
    if(!$tareas=$this->modelo->hallarTarea(['buscar'=> $_POST['buscado']])){
      $this->vista->mensaje="
      <tr id='alerts'>
      <td colspan='10'>
      <div class='alert alert-warning' role='alert' >
      No se Ha podido Encontrar ese Regitro, Intente Escribiendo Correctamente!
      </div>
      </td>
      </tr>
      ";//muestra mensaje de error si escribio mal el tarea a buscar
    }
    $this->vista->tareamap=$tareas;
    $this->vista->render('tarea/consultartarea'); //si el tarea exise lo muestra..

  }
  /*
    ===============================================
     Funcion VISUALIZAR tareaS USANDO PARAMETRROS
    ===============================================
  */
  //para visualizar
  function verTarea($parametro=null)//con parametro
  {
    //se coje el primer puesto del parametro
    $id_tarea=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $tareas=$this->modelo->darPorId($id_tarea);
    $detalles=$this->modelo->buscarDetalleTarea($id_tarea);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_tarea']=$tareas->id_tarea;
    //pasamos a vista materia
    $this->vista->tarea= $tareas;
    $this->vista->detalle= $detalles;

    //Enviamos en vista un mensaje vacio
    //renderizamos
    $this->vista->render('tarea/vertarea');

  }
  function socio($parametro= null)
  {
    session_start();
    $_SESSION["id_pedido"]=$parametro[0];
    $sociotarea=$this->modelo->hallarSocioTarea(['id_pedido'=>$parametro[0]]);
      
    $this->vista->tareamap=$sociotarea;

    $this->vista->render('tarea/socio');
      
  }
  
  function tarea($parametro= null)
  {
    session_start();
    // $id_pedido=$_SESSION["id_pedido"];
    $_SESSION["id_socio"]=$parametro[0];
    $tarea=$this->modelo->tareaEspecifica(['id_socio'=>$parametro[0],'id_pedido'=>$_SESSION['id_pedido']]);
    $this->vista->tareamap=$tarea;
    //$_SESSION["id_tarea"]=$tarea->id_tarea;
    $this->vista->render('tarea/tarea');
      
  }
  //anadir la respectiva fecha_entregada
  function fechaTareaEntregada()
  {
    session_start();
    if ($this->modelo->insertarFechaEntrega(['fecha_entregado'=>$_POST['fecha_entregado'], 'id_tarea'=>$_SESSION['id_tarea']])) {
      $this->verTarea(['0'=>$_SESSION['id_tarea']]);
    }else{
      ?>
      <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>HUbo un Problema</strong> a la hora de actualizar este registro.
        </div>
      <?php
    }
  }
}
 ?>
