<?php
/*CONFIGURACION DE LA BASE DE DATOS*/

  /**
  *CLASE DE BaseDatos, SE LA VE COMO UN OBJETO PADRE CONSUS HIJOS O SEA FUNCIONES
   *
   */
  class BaseDatos
  {
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
      // se asigana con las constante
      $this->host=constant('HOST');
      $this->db=constant('DB');
      $this->user=constant('USER');
      $this->password=constant('PASSWORD');
      $this->charset=constant('CHARSET');

    }
    //se debe de llamar con this->db->connect()->prepare();
    function connect(){

       try{

           $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
           $options = [
               PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_EMULATE_PREPARES   => false,
           ];
           $pdo = new PDO($connection, $this->user, $this->password, $options);

           return $pdo;

       }catch(PDOException $e){
           print_r('Error connection: ' . $e->getMessage());
       }
   }
  }

?>
