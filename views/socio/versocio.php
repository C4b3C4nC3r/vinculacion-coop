
<?php require 'views/header.php';?>
<!--crud de registro de socio-->
  <div style="padding: 0px 20px; "class="card shadow mb-1">
    <div class="card-header py-5">
<!--diseño de encabezado!-->
      <h6 class="m-2 font-weight-bold text-primary">Ver socio: <?php echo $this->socio->nombre; ?> - <?php echo $this->socio->apellido; ?></h6>
    </div>
    <?php
      if (!empty($this->mensaje)){
        echo $this->mensaje ;
      }
    ?>

    <form  action="<?php echo constant('URL');?>consultarsocio/actualizarSocio" method="post">
      <div class="form-row">
        <!--fecha-->
        <div class="form-group col-md-6">
          <label for="fecha_inicio">Fecha de Inicio</label>
          <input disabled name="fecha_inicio" type="date" value="<?php echo $this->socio->fecha_inicio ?>" class="form-control" id="fecha_inicio" required>
        </div>
        <!--Cedula-->
        <div class="form-group col-md-6">
          <label for="cedula">Cédula</label>
          <input name="cedula" type="text" value="<?php echo $this->socio->cedula; ?>" class="form-control" id="producto" required>
        </div>

        <!--Nombre-->
        <div class="form-group col-md-6">
          <label for="nombre">Nombre</label>
          <input name="nombre" type="text" value="<?php echo $this->socio->nombre; ?>" class="form-control" id="producto" required>
        </div>
        <!--Apellido-->
        <div class="form-group col-md-6">
          <label for="apellido">Apellido</label>
          <input name="apellido"  type="text" class="form-control" id="apellido" value="<?php echo $this->socio->apellido; ?>" required>
        </div>
        <!--Telefono-->
        <div class="form-group col-md-6">
          <label for="telefono">Teléfono</label>
          <input name="telefono"  type="text" class="form-control" id="telefono" value="<?php echo $this->socio->telefono; ?>" required>
        </div>
        <!--Stock-->
        <div class="form-group col-md-6">
          <label for="correo">Correo</label>
          <input name="correo" type="email" class="form-control" id="correo" value="<?php echo $this->socio->correo; ?>" required>
        </div>
        <!--Estado-->
        <div class="form-group col-md-6">
          <label for="estado">Estado</label>
          <select name="estado" id="estado" class="form-control" required>
            <option value="<?php echo $this->socio->estado; ?>"><?php echo $this->socio->estado; ?></option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
            <option value="suspendido">Suspendido</option>
          </select>
        </div>
        <div class="form-group col-md-12">
          <label for="direccion">Direccion</label>
          <textarea required name="direccion" id="direccion" class="form-control" rows="4" rows="8" cols="80"><?php echo $this->socio->direccion ?></textarea>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
  </div>
<?php require 'views/footer.php';?>
