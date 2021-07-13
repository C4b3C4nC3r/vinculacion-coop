<?php require 'views/header.php'; //unset($_SESSION['nombre']);?>
<!--crud de registro de Material-->
<div style="padding: 0px 10px 20px 20px; " class="card shadow mb-1">
  <div class="card-header py-5">
    <!--diseño de encabezado!-->
    <h6 class="m-2 font-weight-bold text-primary">
      Registro de Materiales
      <a data-bs-toggle="tooltip" class="btn btn-outline-primary data-bs-placement-top" title="Revisar Los Registros" href="<?php echo constant('URL') ?>consultarmaterial">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
        </svg>
      </a>
    </h6>
  </div>
  <div id="response">

  </div>
  <style>
    .validar {
      display: none;
    }

    .validarcompletado {
      display: none;
    }

    .validaractiva {
      display: block;
      color: red;
      padding: 0px 0px 2px 2px;
      font-size: 14px;
      text-align: center;
    }

    .validarcompletadoactiva {
      display: block;
      color: green;
      padding: 0px 0px 2px 2px;
      font-size: 14px;
      text-align: center;
    }
  </style>
  <form id="formulario_material" >
    <div class="form-row">
      <!--Codigo_material-->
      <div class="form-group col-md-6" id="formulario_codigo">
        <label for="codigo_material">Codigo</label>
        <input name="codigo_material" type="text" class="form-control" id="codigo_material" required>
        <div id="alert">

        </div>
      </div>

      <!--producto-->
      <div class="form-group col-md-6" id="formulario_producto">
        <label for="producto">Material</label>
        <input name="producto" type="text" class="form-control" id="producto" required>
        <div id="alert2">

        </div>
      </div>
      <!--Medida-->
      <div class="form-group col-md-6" id="formulario_medida">
        <label for="medida">Medidas</label>
        <select name="medida" id="medida" class="form-control" required>
          <option value="">Elija la Medida</option>
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
        <p class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>

      </div>
      <!--Categoria_Material Corregir-->
      <div class="form-group col-md-6" id="formulario_categoria">
        <label for="id_categoria_material">Categoria</label>
        <select name="id_categoria_material" id="id_categoria_material" class="form-control" required>
          <option value="">Elija Una Categoria</option>
          <!--Solo se Hace una funion... que estese en el mapProveedor-->
          <?php
          foreach ($this->categoriamaterial as $row) {
            $obj = new CategoriaMaterialMap();
            $obj = $row;
          ?>
            <option value="<?php echo $obj->id_categoria_material; ?>"><?php echo $obj->categoria_material; ?></option>
          <?php } ?>
        </select>
        <p class="validar">*Campo Obligatorio...*</p>
        <p class="validarcompletado">*Campo Completado*</p>

      </div>
      <div class="form-group col-12">
        <button type="submit" id="save" class="btn btn-primary">Guardar</button>
      </div>
  </form>
</div>

<?php require 'views/footer.php'; ?>
