<!--VIEWS-->
<?php
require 'views/header.php';
$url = constant('URL') . "socio"; //ruta para enviarle a la vista de views/info/buscar.php

?>

<div class="card shadow mb-1">
  <div class="card-header py-3">
    <table class="table table-bordered order-table">
      <tr style="text-align: center;">
        <td>
          <h2>
            <b>N ° Tarea:</b> <?php echo $this->tarea->id_tarea ?>
           
          </h2>
        </td>
        <h6 class="m-2 font-weight-bold text-primary">Consulta de Registros
          <a href="<?php echo constant('URL') ?>consultartarea/tarea/<?php echo $_SESSION['id_socio']?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
            </svg>
          </a>
        </h6>
        <td>
            <h5>N ° Pedido:</h5>
            <b> <?php echo $this->tarea->id_pedido ?></b>
          </td>
          <td colspan="2">
          <h5>Seleccione la fecha de llegada de entrega</h5>
            <form method="post" action="<?php echo constant("URL")?>consultartarea/fechaTareaEntregada" class="d-flex">
              <div class="input-group mb-3">
                <input required name="fecha_entregado" type="date" class="form-control" aria-describedby="button-addon2">
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                    <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                  </svg>
                </button>
              </div>
            </form>
          </td>
          </tr>
          <tr>
          <td>
            <h5>Socio:</h5>
            <b> <?php echo $this->tarea->id_socio ?></b>
          </td>
          <td>
            <h5>Fecha de Asignacion: </h5>
            <b><?php echo $this->tarea->fecha_asignacion ?></b>
          </td>
          <td>
            <h5>Fecha Tentativa: </h5>
            <b><?php echo $this->tarea->fecha_entrega ?></b>
          </td>
          <td>
            <h5>Fecha Entregada: </h5>
            <b><?php echo $this->tarea->fecha_entregado ?></b>
            
          </td>
      </tr>
    </table>
    <hr>
    <div class="table-responsive">
      <table class="table table-bordered order-table" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr style="text-align: center;">
            <th>Producto</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //inversa
          foreach ($this->detalle as $row) {
            $obj = new DetalleTareaMap(); //
            $obj = $row;
          ?>
            <tr class="trow" style="text-align: center;">
              <!--REFERENCIA PADRE-->
              <td><?php echo $obj->producto; ?></td>
              <td><?php echo $obj->cantidad; ?></td>
              
            </tr>
          <?php } ?>
          
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require 'views/footer.php'; ?>
