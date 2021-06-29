<?php


class ConsultarPedido extends Controlador //se extiende al controlador en libs/controller
{
  /*
    ==========================================================
     FUNCION CONSTRUCTOR LLAMA AL PARIENTE Y VISTA DEL PEDIDO 
    ==========================================================
  */
  //constructor
  function __construct()
  {
    // llamamos al pariente __construct
    parent::__construct();
    //array en vista con el objeto materialmap (Class MaterialMap)
    $this->vista->pedidomap= [];
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
    $pedidos=$this->modelo->darPedido();
    //esta vista->objeto materialmap= var
    $this->vista->pedidomap=$pedidos;
    //renderizar/--->>>>carpeta/hoja
    $this->vista->render('pedido/consultarpedido');

  }
  /*
    =========================================================================
     AJAX Serie de Funcion Busca PEDIDO con parametros usando el metodo POST
    =========================================================================
  */
  function buscarPedido()//con parametro
  {
    //funciona
    if(!$pedidos=$this->modelo->hallarPedido(['buscar'=> $_POST['buscado']])){
      $this->vista->mensaje="
      <tr id='alerts'>
      <td colspan='10'>
      <div class='alert alert-warning' role='alert' >
      No se Ha podido Encontrar ese Regitro, Intente Escribiendo Correctamente!
      </div>
      </td>
      </tr>
      ";//muestra mensaje de error si escribio mal el pedido a buscar
    }
    $this->vista->pedidomap=$pedidos;
    $this->vista->render('pedido/consultarpedido'); //si el pedido exise lo muestra..

  }
  /*
    ===============================================
     Funcion VISUALIZAR PEDIDOS USANDO PARAMETRROS
    ===============================================
  */
  //para visualizar
  function verPedido($parametro=null)//con parametro
  {
    //se coje el primer puesto del parametro
    $id_pedido=$parametro[0];//asiganar id
    //var= estae modelo con la funcion darPorId(paraemtro);
    $pedidos=$this->modelo->darPorId($id_pedido);
    $detalles=$this->modelo->buscarDetallePedido($id_pedido);
    //sessiones
    session_start();
    //creamos una session, con el contenido del map parametro
    $_SESSION['id_pedido']=$pedidos->id_pedido;
    //pasamos a vista materia
    $this->vista->pedido= $pedidos;
    $this->vista->detalle= $detalles;

    //Enviamos en vista un mensaje vacio
    //renderizamos
    $this->vista->render('pedido/verpedido');

  }

}
 ?>
