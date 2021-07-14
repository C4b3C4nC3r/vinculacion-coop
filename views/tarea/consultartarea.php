<!--VIEWS-->
<?php
require 'views/header.php';
$url = constant('URL') . "consultartarea/buscarTarea"; //ruta para enviarle a la vista de views/info/buscar.php

?>
<div  class="card shadow mb-1">
  <div class="card-header py-3">
    <?php require 'views/info/buscar.php';
    require 'views/info/pagination.php'; ?>

    <div class="table-responsive">
      <table class="table table-bordered order-table" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr style="text-align: center;">
            <th>Fecha Limite</th>
            <th>N° Pedido</th>
            <th>Cliente</th>
            <th>Socios</th>
          </tr>
        </thead>
        <tbody id="tbody-tarea">
          <?php

          //inversa
          foreach ($this->tareamap as $row) {
            $obj = new PedidoMap(); //
            $obj = $row;
          ?>
          
            <tr class="trow " style="text-align: center;" id="fila-<?php echo $obj->id_pedido ?>">
              <!--REFERENCIA PADRE-->
              <td><?php echo $obj->fecha_salida; ?></td>
              <td><?php echo $obj->id_pedido; ?></td>
              <td><?php echo $obj->id_cliente; ?></td>
                <td>

                  <!-- Button trigger modal -->
                  <a class="btn <?php if($obj->estado=='listo') { echo 'btn-outline-success'; }else{ echo 'btn-outline-danger';} ?>" href="<?php echo constant('URL') ?>consultartarea/socio/<?php echo $obj->id_pedido ?>">
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
  <script src="<?php echo constant('URL'); ?>libs/js/boton/eliminartarea.js"></script>
  <script src="<?php echo constant('URL') ?>libs/js/buscar/buscarRegistro.js"></script>
  <script src="<?php echo constant('URL') ?>libs/js/pagination.js"></script>

  <?php require 'views/footer.php'; ?>
