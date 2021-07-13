<?php
  /*
  APLICACION DE LOGIN

  */
  class AppLogin
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
      if (empty($url[0])) {//el url este vacio o por default

        //var, para tener el link del controlador
        $archivocontrolador = 'controllers/iniciar.php';//ruta pordefecto
        require_once $archivocontrolador;
        $controlador = new Iniciar();//objeto Iniciar
        $controlador->cargarModelo($url[0]);
        $controlador->render();//condicional
        return false;
        // code...
      }
      //var, para tener el link del controladorhttp://localhost/coop/
      $archivocontrolador = 'controllers/'.$url[0].'.php';
      //condicional, si es que exites un archivo en esta rita
      if (file_exists($archivocontrolador)) {
        /*preguntamos us la constante es igual ala ruta que se asigno
        */
        if ($archivocontrolador!=constant('RUTA')) {//si son direntes al cosntante...tendra que
          //retornar al index
          header('Location: /coop');
        }
        //caso que no sea asi seguira normal... pero netamente trabajara en la constate RUTA
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
      }else{//caso que no exista
        header("Location: /coop");//objeto
      }
    }
  }


 ?>
