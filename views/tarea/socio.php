<!--VIEWS-->
<?php
require 'views/header.php';
$url = constant('URL') . "consultarsalidamaterial/buscarSalidaMaterial"; //ruta para enviarle a la vista de views/info/buscar.php
session_start();
?>
<div  class="card shadow mb-1">
  <div class="card-header py-3">
    <?php require 'views/info/buscar.php'; ?>
    <a data-bs-toggle="tooltip" class="btn btn-outline-primary data-bs-placement-top" title="Revisar Los Registros" href="<?php echo constant('URL') ?>consultartarea">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
        </svg>
      </a>
    <?php require 'views/info/pagination.php'; ?>

    <div class="table-responsive">
      <table class="table table-bordered order-table" id="dataTable" width="100%" cellspacing="0">
        <thead style="text-align: center;">
          <h4>
            N° Pedido <?php echo $_SESSION["id_pedido"]?>
                    
          </h4>
        
          <tr style="text-align: center;">
            <th> Cédula</th>
            <th>Socios</th>
            <th>Tareas</th>
          </tr>
        </thead>
        <tbody id="tbody-material">
          <?php
          //inversa
          foreach ($this->salidamaterialmap as $row) {
            $obj = new TareaMap(); //
            $obj = $row;

          ?>
            <tr class="trow" style="text-align: center;" id="fila-<?php echo $obj->id_tarea ?>">
              <!--REFERENCIA PADRE-->
              <td><?php echo $obj->cedula_socio; ?></td>
              <td><?php echo $obj->id_socio; ?></td>
                <td>
                  <!-- Button trigger modal -->
                  <a class="btn btn-outline-primary" href="<?php echo constant('URL') ?>consultartarea/verTarea/<?php echo $obj->id_tarea ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                      <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                      <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                    </svg>
                  </a>
                </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!--JS PARA LOS BOTONES DE ELIMINAR Marteriales
  -->
  <script src="<?php echo constant('URL') ?>libs/js/buscar/buscarRegistro.js"></script>
  <script src="<?php echo constant('URL') ?>libs/js/pagination.js"></script>

  <?php require 'views/footer.php'; ?>
