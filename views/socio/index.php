
<?php require 'views/header.php';?>
<!--crud de registro de socios-->
  <div style="padding: 0px 10px 20px 20px; "class="card shadow mb-1">
    <div class="card-header py-5">
<!--diseño de encabezado!-->
      <h6 class="m-2 font-weight-bold text-primary">Registro de Socios</h6>
    </div>

    <div id="response">

    </div>

    <form id="formulario_socio">
      <div class="form-row">
        <!--fecha-->
        <div class="form-group col-md-4">
          <label for="fecha_inicio">Fecha de Inicio</label>
          <input name="fecha_inicio" type="date"  class="form-control" id="fecha_inicio" required>
        </div>
        <!--cedula-->
        <div class="form-group col-md-4">
          <label for="cedula">Cedula</label>
          <input name="cedula" type="text"  class="form-control" id="cedula" required>
          <div id="alert">

          </div>
        </div>

        <!--nombre-->
        <div class="form-group col-md-4">
          <label for="nombre">Nombre</label>
          <input name="nombre" type="text"  class="form-control" id="nombre" required>
        </div>
        <!--Apellido-->
        <div class="form-group col-md-4">
          <label for="apellido">Apellido</label>
          <input name="apellido" type="text"  class="form-control" id="apellido" required>
        </div>
        <!--Telefono-->
        <div class="form-group col-md-4">
          <label for="telefono">Teléfono</label>
          <input name="telefono"  type="text" class="form-control" id="telefono"  required>
        </div>
        <!--Correo-->
        <div class="form-group col-md-4">
          <label for="correo">Correo</label>
          <input name="correo" type="email" class="form-control" id="correo" required>
        </div>
        <div class="form-group col-12">
          <label for="direccion">Direccion</label>
          <textarea required name="direccion" id="direccion" class="form-control" rows="4" cols="80"></textarea>
        </div>
        <div class="form-group col-12">
          <button type="submit" id="save" class="btn btn-primary">Guardar</button>
        </div>
    </form>
  </div>

<?php require 'views/footer.php';?>
