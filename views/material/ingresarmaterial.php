<?php require 'views/header.php'; //unset($_SESSION['nombre']);?>
<!--crud de registro de Material-->
<div style="padding: 0px 10px 20px 20px; " class="card shadow mb-1">
  <div class="card-header py-5">
    <!--diseño de encabezado!-->
    <h6 class="m-2 font-weight-bold text-primary">
      Registro del Ingreso de Material
      <a data-bs-toggle="tooltip" class="btn btn-outline-primary data-bs-placement-top" title="Revisar Los Registros" href="<?php echo constant('URL') ?>consultaringresarmaterial">
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
    <!--FORMULARIOS-->
    <div id="response">

    </div>
  <form autocomplete="off" id="formulario_ingreso">
    <div class="form-row">
      <!--numero_factura-->
      <div class="form-group col-md-4" id="formulario_numerofactura">
        <label for="numero_factura">N° Factura</label>
        <input  title="Agrege el detalle" name="numero_factura" type="text"   class="form-control" id="numero_factura" required>
        <div id="alert">

        </div>
      </div>
      <!--id_proveedor-->
      <div class="form-group col-md-4"  id="formulario_proveedor">
        <label for="id_proveedor">Proveedor</label>
        <select name="id_proveedor" title="Agrege el detalle" id="id_proveedor"  class="form-control" required>
          <option value="">Elija El Proveedor</option>
          <!--Solo se Hace una funion... que estese en el mapProveedor-->
          <?php
          foreach ($this->proveedormap as $row){
            $obj = new ProveedorMap();
            $obj=$row;
           ?>
           <option value="<?php echo $obj->id_proveedor ?>"><?php echo $obj->nombre; ?></option>
         <?php } ?>
        </select>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>
      <!--fecha-->
      <div class="form-group col-md-4"  id="formulario_fecha">
        <label for="fecha">Fecha Ingreso</label>
        <input name="fecha"  title="Agrege el detalle" type="date" class="form-control" id="fecha" required>
        <p  class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>
      </div>

  </form>
  <div class="col-12">
    <?php
      require 'detalle_ingreso.php';
    ?>
 </div>
 <!--SubTotal-->
 <div class="form-group col-md-3"  id="formulario_subtotal">
   <label for="subtotal">SubTotal </label>
   <input name="subtotal"  type="text" value="0.00" class="form-control" id="subtotal" disabled required>
   <p  class="validar">*Campo Obligatorio...*</p>
   <p class="validarcompletado">*Campo Completado*</p>
 </div>
 <!--IVA-->
 <div class="form-group col-md-2" id="formulario_iva">
   <label for="porcentajeiva">I.V.A</label>
     <select required name="porcentaje" class="form-control" id="porcentajeiva">

       <option value="12">IVA 12%</option>
       <option value="14">IVA 14%</option>
       <option value="0">NO APLICA IVA</option>
     </select>
 </div>
 <!--IMPUESTO-->
 <div class="form-group col-md-2">
   <label for="iva">Impuesto</label>
   <input name="iva" type="text" class="form-control" id="impuesto" disabled required>
   <p class="validar">*Campo Obligatorio...*</p>
   <p class="validarcompletado">*Campo Completado*</p>
 </div>
 <!--Total-->
 <div class="form-group col-md-5">
   <label for="total">Total</label>
   <input name="total" type="text" class="form-control" id="totalIngreso" disabled required>
   <p  class="validar">*Campo Obligatorio...*</p>
   <p class="validarcompletado">*Campo Completado*</p>
 </div>
 <div class="form-group col-3">
   <button disabled type="submit" id="save" class="btn btn-primary">Guardar</button>
 </div>
 <div class="form-group col-1">
   <button  disabled type="reset" id="botonCancelarIngreso" class="botonCancelarIngreso btn btn-secondary ">Cancelar</button>
 </div>
</div>

<!--SCRIPST-->
<script type="text/javascript">
  if (window.history.replaceState) {
    window.history.replaceState(null,null,window.location.href)
  }
</script>
<?php require 'views/footer.php'; ?>
