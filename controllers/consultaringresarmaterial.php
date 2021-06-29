<?php


class ConsultarIngresarMaterial extends Controlador //se extiende al controlador en libs/controller
{
  /*
    ================================================================
      FUNCION CONSTRUCTOR DONDE LLAMA A VISTA ->ingresarmaterialmap
    ================================================================
  */
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto materialmap (Class MaterialMap)
    $this->vista->ingresarmaterialmap= [];
  }
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $ingresarmateriales=$this->modelo->darIngresarMaterial();
    //esta vista->objeto materialmap= var
    $this->vista->ingresarmaterialmap=$ingresarmateriales;
    //renderIzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultaringresarmaterial');

  }
  /*
    =========================================================
      AJAX Funcion que manda un POST Buscar IngresarMaterial 
    =========================================================
  */
  function buscarIngresarMaterial()//conn parametro
  {
    //funciona
    if(!$ingresarmateriales=$this->modelo->hallarIngresarMaterial(['buscar'=> $_POST['buscado']])){
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
    $this->vista->ingresarmaterialmap=$ingresarmateriales;

    $this->vista->render('material/consultaringresarmaterial');

  }
  /*
    =========================================================
      FUNCION CON PARAMETROS PARA VER EL INGRESODEL MATERIAL 
    =========================================================
  */
  //para visualizar
  function verIngreso($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_ingreso_material=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $ingresos=$this->modelo->darPorId($id_ingreso_material);
    $detalles=$this->modelo->buscarDetalleIngreso($id_ingreso_material);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_ingreso_material']=$ingresos->id_ingreso_material;
    //pasamos a vista materia
    $this->vista->ingreso= $ingresos;
    $this->vista->detalle= $detalles;

    //enviamos en vista un mensaje vacio
    //renderizamos
    $this->vista->render('material/veringreso');
  }

}
 ?>
