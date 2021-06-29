<?php


class ConsultarSalidaMaterial extends Controlador //se extiende al controlador en libs/controller
{
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto materialmap (Class MaterialMap)
    $this->vista->salidamaterialmap= [];
  }
  //fun render
  function render()
  {
    //var = este modelo->su funcion con parametros vacios
    $salidamateriales=$this->modelo->darSalidaMaterial();
    //esta vista->objeto materialmap= var
    $this->vista->salidamaterialmap=$salidamateriales;
    //renderuzar/--->>>>carpeta/hoja
    $this->vista->render('material/consultarsalidamaterial');

  }
  function buscarSalidaMaterial()//conn parametro
  {
    //funciona
    if(!$salidamateriales=$this->modelo->hallarSalidaMaterial(['buscar'=> $_POST['buscado']])){
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
    $this->vista->salidamaterialmap=$salidamateriales;

    $this->vista->render('material/consultarsalidamaterial');

  }
  //para visualizar
  function verSalida($parametro=null)//conn parametro
  {
    //se coje el primer puesto del parametro
    $id_salida_material=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $salidas=$this->modelo->darPorId($id_salida_material);
    $detalles=$this->modelo->buscarDetalleMaterial($id_salida_material);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_salida_material']=$salidas->id_salida_material;
    //pasamos a vista materia
    $this->vista->salidas= $salidas;
    $this->vista->detalle= $detalles;

    //enviamos en vista un mensaje vaciio
    //renderizamos
    $this->vista->render('material/versalida');
  }

  function socio($parametro= null)
  {
    session_start();
    $_SESSION["id_pedido"]=$parametro[0];
    $sociosalidamateriales=$this->modelo->hallarSocioMaterial(['id_pedido'=>$parametro[0]]);
      
    $this->vista->salidamaterialmap=$sociosalidamateriales;

    $this->vista->render('material/socio');
      
  }
}
?>
