
<?php require 'views/header.php';?>
<!--crud de registro de proveedors-->
  <div style="padding: 0px 10px 20px 20px; "class="card shadow mb-1">
    <div class="card-header py-5">
<!--diseño de encabezado!-->
      <h6 class="m-2 font-weight-bold text-primary">Registro de Proveedor</h6>
    </div>
    <div id="response">

    </div>
    <form id="formulario_proveedor">
      <div class="form-row">
        <!--ruc-->
        <div class="form-group col-md-6">
          <label for="ruc">R.U.C</label>
          <input name="ruc" type="text"  class="form-control" id="ruc" required>
          <div id="alert">

          </div>
        </div>
        <!--nombre-->
        <div class="form-group col-md-6">
          <label for="nombre">Proveedor</label>
          <input name="nombre" type="text"  class="form-control" id="nombre" required>
        </div>

        <!--Telefono-->
        <div class="form-group col-md-6">
          <label for="telefono">Teléfono</label>
          <input name="telefono"  type="text" class="form-control" id="telefono"  required>
        </div>
        <!--Correo-->
        <div class="form-group col-md-6">
          <label for="correo">Correo</label>
          <input name="correo" type="email" class="form-control" id="correo" required>
        </div>
        <!--direccion-->
        <div class="form-group col-12">
          <label for="direccion">Direccion</label>
          <textarea name="direccion" class="form-control" id="direccion" rows="4" cols="80" required></textarea>
        </div>

      <div class="form-group col-12">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </form>
  </div>

<?php require 'views/footer.php';?>
