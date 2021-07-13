<?php require 'views/header.php'; //unset($_SESSION['nombre']);?>
<!--crud de registro de Material-->
<div style="padding: 0px 10px 20px 20px; " class="card shadow mb-1">
  <div class="card-header py-5">
    <!--diseño de encabezado!-->
    <h6 class="m-2 font-weight-bold text-primary">
      Registro de tarea
      <a data-bs-toggle="tooltip" class="btn btn-outline-primary data-bs-placement-top" title="Revisar Los Registros" href="<?php echo constant('URL') ?>consultartarea">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
        </svg>
      </a>
    </h6>
  </div>
  <style>
  .validar{
    display: none;
  }
  .validarcompletado{
    display: none;
  }
  .validaractiva{
    display: block;
    color:red;
    padding: 0px 0px 2px 2px;
    font-size: 14px;
    text-align: center;
  }
  .validarcompletadoactiva{
    display: block;
    color:green;
    padding: 0px 0px 2px 2px;
    font-size: 14px;
    text-align: center;
  }
  </style>

    <!--FORMULARIOS  tarea/agregartarea-->
<div id="response">

</div>
  <form id="formulario_tarea">
    <div class="form-row">
  <!--id_pedido-->
    <div class="form-group col-md-6"  id="">
        <label for="id_pedido">Pedido</label>
        <select name="id_pedido" title="Agrege el detalle" id="id_pedido"  class="form-control" required>
          <option value="">Elija El Pedido</option>
          <!--Solo se Hace una funion... que estese en el mapCliente-->
          <?php
          foreach ($this->pedidomap as $row){
            $obj = new PedidoMap();
            $obj=$row;
           ?>
           <option value="<?php echo $obj->id_pedido ?>"><?php echo "$obj->id_pedido - $obj->id_cliente"; ?></option>
         <?php } ?>
        </select>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>
      <!--id_soscio-->
      <div class="form-group col-md-6"  id="">
        <label for="id_socio">Socio</label>
        <select name="id_socio" title="Agrege el detalle" id="id_socio"  class="form-control" required>
          <option value="">Elija El Socio</option>
          <!--Solo se Hace una funion... que estese en el mapCliente-->
          <?php
          foreach ($this->sociomap as $row){
            $obj = new SocioMap();
            $obj=$row;
           ?>
           <option value="<?php echo $obj->id_socio ?>"><?php echo "$obj->nombre $obj->apellido"; ?></option>
         <?php } ?>
        </select>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>
      <!--fecha_asignacion-->
      <div class="form-group col-md-6"  id="formulario_fecha">
        <label for="fecha_asignacion">Fecha tarea</label>
        <input name="fecha_asignacion"  title="Agrege el detalle" type="date" class="form-control" id="fecha_asignacion" required>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>
      <!--fecha_entrega-->
      <div class="form-group col-md-6"  id="formulario_fecha">
        <label for="fecha_entrega">Fecha Entrega</label>
        <input name="fecha_entrega"  title="Agrege el detalle" type="date" class="form-control" id="fecha_entrega" required>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>

  </form>
            
  <?php
    require 'detalle_tarea.php';
   ?>

 
 <div class="form-group col-12">
   <button disabled type="submit" id="save" class="btn btn-primary">Guardar</button>

   <button disabled type="reset" id="botonCancelartarea" class="botonCancelar btn btn-secondary" >Cancelar</button>
 </div>
</div>

<script type="text/javascript">
  if (window.history.replaceState) {
    window.history.replaceState(null,null,window.location.href)
  }
</script>
<?php require 'views/footer.php'; ?>
