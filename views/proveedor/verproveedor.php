
<?php require 'views/header.php';?>
<!--crud de registro de cliente-->
  <div style="padding: 0px 20px; "class="card shadow mb-1">
    <div class="card-header py-5">
<!--diseño de encabezado!-->
      <h6 class="m-2 font-weight-bold text-primary">Ver Proveedores: <?php echo $this->proveedor->nombre; ?></h6>
    </div>
    <?php
      if (!empty($this->mensaje)){
        echo $this->mensaje ;
      }
    ?>

    <form  action="<?php echo constant('URL');?>consultarproveedor/actualizarProveedor" method="post">
      <div class="form-row">
        <!--ruc-->
        <div class="form-group col-md-6">
          <label for="ruc">R.U.C</label>
          <input name="ruc" type="text" value="<?php echo $this->proveedor->ruc; ?>"  class="form-control" id="ruc" required>
        </div>
        <!--nombre-->
        <div class="form-group col-md-6">
          <label for="nombre">Nombre del Proveedor</label>
          <input name="nombre" type="text" value="<?php echo $this->proveedor->nombre; ?>" class="form-control" id="producto" required>
        </div>
        <!--Telefono-->
        <div class="form-group col-md-6">
          <label for="telefono">Teléfono</label>
          <input name="telefono"  type="text" class="form-control" id="telefono" value="<?php echo $this->proveedor->telefono; ?>" required>
        </div>
        <!--Correo-->
        <div class="form-group col-md-6">
          <label for="correo">Correo</label>
          <input name="correo" type="email" class="form-control" id="correo" value="<?php echo $this->proveedor->correo; ?>" required>
        </div>
        <!--direccion-->
        <div class="form-group col-12">
          <label for="direccion">Direccion</label>
          <textarea name="direccion" class="form-control" id="direccion" rows="4" cols="80" required><?php echo $this->proveedor->direccion; ?></textarea>
        </div>
        <!--Estado-->
        <div class="form-group col-md-6">
          <label for="estado">Estado</label>
          <select name="estado" id="estado" class="form-control" required>
            <option value="<?php echo $this->proveedor->estado; ?>">Elija Un Nuevo Estado (Anterior: <?php echo $this->proveedor->estado; ?>)</option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
            <option value="suspendido">Suspendido</option>
          </select>
        </div>
        <!--
        <div class="form-group col-md-2">
          <label for="inputZip">Zip</label>
          <input name="" type="text" class="form-control" id="inputZip" required>
        </div>
      </div>

      <div class="form-group">
        <div class="form-check">
          <input name="" class="form-check-input" type="checkbox" id="gridCheck" required>
          <label class="form-check-label" for="gridCheck">
            Check me out
          </label>
        </div>
      </div>
        -->
    <div class="form-group col-12">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </form>
  </div>
<?php require 'views/footer.php';?>
