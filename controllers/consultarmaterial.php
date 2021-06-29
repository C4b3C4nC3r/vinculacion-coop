<?php
class ConsultarMaterial extends Controlador //se extiende al controlador en libs/controller
{
  /*
  ========================================================
   FUNCION CONSTRUCTOR  PARA LLAMAR AL pariente_construct
  ========================================================
  */
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto materialmap (Class MaterialMap)
    $this->vista->materialmap= [];
  }
  //fun render
  function render()
  {

    //var = este modelo->su funcion con parametros vacios
    $materiales=$this->modelo->darMaterial();
    //esta vista->objeto materialmap= var
    $this->vista->materialmap=$materiales;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarmaterial');

  }
  /*
    ====================================================
      AJAX Funcion VerMaterial
    ====================================================
  */
  //para visualizar
  function verMaterial($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_material=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $material=$this->modelo->darPorId($id_material);
    $categoriamaterial=$this->modelo->foraneaKey();
    //esta vista->objeto materialmap= var
    $this->vista->categoriamaterial=$categoriamaterial;
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_material']=$material->id_material;
    //pasamos a vista materia
    $this->vista->material = $material;
    //enviamos en vista un mensaje vaciio
  $this->vista->render('material/vermaterial');
  }
  /*
    ============================================================
     Funcion visualizar la tabla buscarMaterial con parametros
    ============================================================
  */
  //para visualizar
  function buscarMaterial()//conn parametro
  {
    //funciona
    if(!$materiales=$this->modelo->hallarMaterial(['buscar'=> $_POST['buscado']])){
      $this->vista->mensaje="
      <tr id='alerts'>
      <td colspan='10'>
      <div class='alert alert-warning' role='alert' >
      No se Ha podido Encontrar ese Regitro, Intente Escribiendo Correctamente!
      </div>
      </td>
      </tr>
      ";
    }
    $this->vista->materialmap=$materiales;

    //esta vista->objeto materialmap= var
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarmaterial');

  }
  /*
    ====================================================
      AJAX Funcion que manda un POST Actualizar Material
    ====================================================
  */
  //funcion de actualizar
  function actualizarMaterial()
  {
    $url=constant('URL').'consultarmaterial';//link
    //iniciamos session
    session_start();
    //cambiamos de variable
    $id_material=$_SESSION['id_material'];
    //destrir sessiones
    unset($_SESSION['id_material']);
    //funcion, este modelo, conla funcion update(parametros como un array)['id_material'=>$id_material,
    if ($this->modelo->update(['id_material'=>$id_material,'id_categoria_material'=>$_POST['id_categoria_material'],'codigo_material'=>$_POST['codigo_material'],'producto'=>$_POST['producto'],'stock'=>$_POST['stock'],'medida'=>$_POST['medida'],'estado'=>$_POST['estado']])) {
        // actualizar matricula
        $material=new MaterialMap();//objeto
        //retornar valores a vistya
        $material->id_material=$id_material;
        $material->id_categoria_material=$_POST['id_categoria_material'];
        $material->codigo_material=$_POST['codigo_material'];
        $material->producto=$_POST['producto'];
        $material->stock=$_POST['stock'];
        $material->medida=$_POST['medida'];
        $material->estado=$_POST['estado'];
        //empezar a enviar vista para desglozarlo
        $this->vista->material=$material;
        //mensaje
        $this->vista->mensaje=
        "<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Exitoso</strong> Se ha Actualizado con Exito el Material
            <a href='$url'> Revisar los Materiales</a>
        </div>
        ";
    }else{
      //error
      $this->vista->mensaje=
      "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Sin Exito</strong> No Se ha Actualizado el Material
          <a href='$url'> Revisar los Materiales</a>
      </div>
      ";
    }
    //renderizamos la vista
    $this->vista->render('material/vermaterial');
  }
  /*
    =================================
     Funcion que elimina parametros
    =================================
  */
  //funcion eliminar con parametro
  function eliminarMaterial($parametro=null)
  {
    //asignamos el id
    $id_material=$parametro[0];
    // mapeo
    //condicional
    //funcion, este mdoelo conla fun delete(parametro)
    $this->modelo->delete($id_material);
  }

  /*
    =============================================
      Serie de Funcion que VISUALIZA los estados
    =============================================
  */
  //funcion para ver otros estados
  function activoMaterial()
  {
    //var = este modelo->su funcion con parametros vacios
    $materiales=$this->modelo->estadoMaterial('activo');
    //esta vista->objeto materialmap= var
    $this->vista->materialmap=$materiales;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarmaterial');
  }
  //funcion para ver otros estados
  function inactivoMaterial()
  {
    //var = este modelo->su funcion con parametros vacios
    $materiales=$this->modelo->estadoMaterial('inactivo');
    //esta vista->objeto materialmap= var
    $this->vista->materialmap=$materiales;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarmaterial');
  }
  //funcion para ver otros estados
  function suspendidoMaterial()
  {
    //var = este modelo->su funcion con parametros vacios
    $materiales=$this->modelo->estadoMaterial('suspendido');
    //esta vista->objeto materialmap= var
    $this->vista->materialmap=$materiales;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarmaterial');
  }
}
 ?>
