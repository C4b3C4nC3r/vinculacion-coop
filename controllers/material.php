<?php

/**
*CLASEDE Material, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
 *revisado
 */
class Material extends Controlador //se extiende al controlador en libs/controller
{
/*
  =========================================================================================
  Funcion de COD. constructor | LLAMAMOS AL PARIENTE CONSTRUCTOR y mandamos mensaje
  =========================================================================================
*/
  //conructor
  function __construct()
  {
    parent::__construct();
    //mensaje en vista
    $this->vista->mensaje="";
    //esta var, va a cojer la funcion render para madar parametros >>libs/view.php/class/Vista/render($nombre)
    $this->vista->categoriamaterial = [];
  }
  /*
  =========================================================================================
   Funcion render que sirve para Iniciar la pestaña Material
  =========================================================================================
*/
  function render()
  {
    $categoriamateriales=$this->modelo->foraneaKey();
    //esta vista->objeto materialmap= var
    $this->vista->categoriamaterial=$categoriamateriales;
    //renderuzar
    $this->vista->render('material/index');
  }
  /*
  =========================================================================================
    AJAX FUNCION que agrega un material mediante una consulta con la URL
  =========================================================================================
*/
  function agregarMaterial()
  {
      $url=constant('URL').'consultarmaterial';
      if ($this->modelo->objetoPorHallar(['id_categoria_material'=>$_POST['id_categoria_material'],'codigo_material'=>$_POST['codigo_material'],'producto'=>$_POST['producto'],'medida'=>$_POST['medida']])) {
        ?>
        <div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Se encontro</strong> El material Ingresado ya tiene un registro asi que se actualizara
            <a href='<?php echo $url ?>'> Revisar los Materiales</a>
        </div>
        <?php

      }else{

        if ($this->modelo->insertarMaterial(['id_categoria_material'=>$_POST['id_categoria_material'],'codigo_material'=>$_POST['codigo_material'],'producto'=>$_POST['producto'],'medida'=>$_POST['medida']])) {
          //mensaje
          ?>
          <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Exitoso</strong> Se ha Ingresado con Exito el Materiales
              <a href='<?php echo $url ?>'> Revisar los Materiales</a>
          </div>
          <?php
        }else{
          ?>
          <div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <strong>No Exitoso</strong> No Se ha Ingresado el Materiales
              <a href='<?php echo $url ?>'> Revisar los Materiales</a>
          </div>
          <?php
        }
      }
    }
    //============
    //c busca por el codigo
      function buscarRegistro()
      {
          if ($this->modelo->buscarMaterial(['codigo_material'=>$_GET['codigo_material']])) {
            ?>
            <p style="font-size:10px;color:red;">
              Este codigo ya esta registrado, verifiquelo
            </p>
            <?php
          }else{
            $bool=true;
            echo $bool;
          }
      }
      //se busca el nombre
      function buscarRegistroN()
      {
          if ($this->modelo->buscarMaterialN(['producto'=>$_GET['producto']])) {
            ?>
            <p style="font-size:10px;color:red;">
              Este material ya esta registrado, verifiquelo
            </p>
            <?php
          }else{
            $bool=true;
            echo $bool;
          }
      }
      //fin
}
?>
