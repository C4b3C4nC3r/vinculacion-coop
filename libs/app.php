<?php
/*COMO QUE SIEMPRE S EVA A NECESITAR EL CONTROLADOR DE ERRORES,
YA EN APP.PHP, LO REQUIERE PARA PODER HACER DINAMICAS PARA RESOLV
ERRORES
*/
require_once 'controllers/errores.php';

  /**
  *CLASE DE APP, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
   *Par el enrutamiento
   */
  class App
  {

    function __construct()
    {
    //  echo "<p>Nueva App</p>";
      /*RECOJEMOS EL URL DADO en .THACCESS*/
      $url=isset($_GET['url']) ? $_GET['url']: null;
      //Recortar la url que nno necesitamos
      $url=rtrim($url,'/');
      //dividir parametros
      $url = explode('/',$url);
      //validar si esta en null, sin definiciond econtrolador
      if (empty($url[0])) {

        //var, para tener el link del controlador
        $archivocontrolador = 'controllers/main.php';
        require_once $archivocontrolador;
        $controlador = new Main();
        $controlador->cargarModelo($url[0]);
        $controlador->render();//condicional
        return false;
        // code...
      }

      /*
      var_dump($url);
      salida:
      array(4) { [0]=> string(1) "1" [1]=> string(1) "2" [2]=> string(1) "3" [3]=> string(1) "4" }
      [position]
      */

      //var, para tener el link del controlador
      $archivocontrolador = 'controllers/'.$url[0].'.php';
      //condicional, si es que exites un archivo en esta rita
      if (file_exists($archivocontrolador)) {
        if ($archivocontrolador==constant('RUTA')) {//si son direntes al cosntante...tendra que
          //retornar al index
          header('Location: /coop');
        }
        //require_once 'file';
        require_once $archivocontrolador;
        //inicial controlador
        //contructor
        $controlador =new $url[0];
        $controlador->cargarModelo($url[0]);
        //numero de parametros, o eliemntos del link
        $numero_parametro = sizeof($url);

        if ($numero_parametro>1) {
          if ($numero_parametro>2) {
            //array vacio
            $parametro=[];
            //hacer un bule para hacer llenar el array
            for ($i=2; $i <$numero_parametro ; $i++) {
              //rellenar el array parametro
              array_push($parametro,$url[$i]);
            }
            //se estipula el url con su array d eparametros
            $controlador->{$url[1]}($parametro);//ruta con parametro
          }else{
            //normal
            $controlador->{$url[1]}();//ruta
          }
        }else{
          $controlador->render();//render
        }
      }else{
        $controlador = new Errores();//objeto
      }
    }
  }


 ?>
