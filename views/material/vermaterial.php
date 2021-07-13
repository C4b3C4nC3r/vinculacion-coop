
<?php require 'views/header.php';?>
<!--crud de registro de Material-->
  <div  style="padding: 0px 10px 20px 20px;" class="card shadow mb-1">
    <div class="card-header py-5">
<!--diseño de encabezado!-->
      <h6 class="m-2 font-weight-bold text-primary">
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Ver El Registro" href="<?php echo constant('URL'); ?>/consultarmaterial">
          Ver Material: <?php echo $this->material->producto; ?>
        </a>
      </h6>

    </div>
    <?php
      if (!empty($this->mensaje)){
        echo $this->mensaje ;
      }
    ?>
    <!--Opcion Returnar a Consultar-->
    <form  action="<?php echo constant('URL');?>consultarmaterial/actualizarMaterial" method="post">
      <div class="form-row">
        <!--Codigo_material-->
        <div class="form-group col-md-6">
          <label for="codigo_material">Codigo</label>
          <input name="codigo_material" type="text" class="form-control" id="codigo_material" value="<?php echo $this->material->codigo_material ?>" required>
        </div>
        <!--producto-->
        <div class="form-group col-md-6">
          <label for="producto">Nombre del Material</label>
          <input name="producto" type="text" value="<?php echo $this->material->producto; ?>" class="form-control" id="producto" required>
        </div>
        <!--cantidad-->
        <div class="form-group col-md-6">
          <label for="stock">Cantidad</label>
          <input disabled name="stock" type="text" value="<?php echo $this->material->stock; ?>" class="form-control" id="stock" required>
        </div>
        <!--Medida-->
        <div class="form-group col-md-6">
          <label for="medida">Unidades de Medidas</label>
          <select  name="medida" id="medida" class="form-control" required>
            <option value="<?php echo $this->material->medida; ?>">Antigua Medidad: <?php echo $this->material->medida; ?></option>
            <optgroup label="Por Cantidad">
              <option value="u">Unidades</option>
              <option value="doc">Docenas</option>
            </optgroup>
            <optgroup label="Por Peso">
              <option value="kg">Kilogramos</option>
              <option value="g">gramos</option>
              <option value="lb">libras</option>
              <option value="q">Quintal</option>
            </optgroup>
            <optgroup label="Por Longitud">
              <option value="yd">Yarda</option>
              <option value="m">Metro</option>
              <option value="cm">Centimetros</option>
              <option value="km">Kilometros</option>
            </optgroup>
          </select>
        </div>
        <!--Categoria_Material Corregir-->
        <div class="form-group col-md-6">
          <label for="id_categoria_material">Categoria</label>
          <select name="id_categoria_material" id="id_categoria_material" class="form-control" required>
            <option value="<?php echo $this->material->id_categoria_material; ?>">Elija Una Categoria</option>
            <!--Solo se Hace una funion... que estese en el mapProveedor-->
            <?php
            foreach ($this->categoriamaterial as $row){
              $obj = new CategoriaMaterialMap();
              $obj=$row;
             ?>
             <option value="<?php echo $obj->id_categoria_material ?>"><?php echo $obj->categoria_material; ?></option>
           <?php } ?>
          </select>
        </div>
        <!--Estado-->
        <div class="form-group col-md-6">
          <label for="estado">Estado</label>
          <select name="estado" id="estado" class="form-control" required>
            <option value="<?php echo $this->material->estado; ?>">Antiguo Estado: <?php echo $this->material->estado; ?></option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
            <option value="suspendido">Suspendido</option>
          </select>
        </div>

      <div class="form-group col-12">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
<?php require 'views/footer.php';?>
