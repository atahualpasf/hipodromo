<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkpro_id = $fkpro_lug_id = $pro_ci = $pro_primer_nombre = $pro_segundo_nombre = $pro_primer_apellido = "";
  $pro_segundo_apellido = $pro_fecha_nacimiento = $pro_correo = $tel_codigo = $tel_numero = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkpro_id'] = test_input($_POST['pkpro_id']);
      $GLOBALS['fkpro_lug_id'] = test_input($_POST['fkpro_lug_id']);
      $GLOBALS['pro_ci'] = test_input($_POST['pro_ci']);
      $GLOBALS['pro_primer_nombre'] = test_input($_POST['pro_primer_nombre']);
      $GLOBALS['pro_segundo_nombre'] = test_input($_POST['pro_segundo_nombre']);
      $GLOBALS['pro_primer_apellido'] = test_input($_POST['pro_primer_apellido']);
      $GLOBALS['pro_segundo_apellido'] = test_input($_POST['pro_segundo_apellido']);
      $GLOBALS['pro_fecha_nacimiento'] = test_input($_POST['pro_fecha_nacimiento']);
      $GLOBALS['pro_correo'] = test_input($_POST['pro_correo']);
      $GLOBALS['tel_codigo'] = test_input($_POST['tel_codigo']);
      $GLOBALS['tel_numero'] = test_input($_POST['tel_numero']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
        setValuesWhenSubmitIsClicked();
        $answer = @json_decode($db->createPropietario($fkpro_lug_id, $pro_ci, $pro_primer_nombre, $pro_segundo_nombre, $pro_primer_apellido, $pro_segundo_apellido, $pro_fecha_nacimiento, $pro_correo));
        if ($answer->action != "error") {
           if (!empty($tel_codigo) && !empty($tel_numero)) {
             $answer = @json_decode($db->updateTelefono($pkpro_id, $tel_codigo, $tel_numero));
             if ($answer->action != "error") {
               echo '<meta http-equiv="refresh" content="0;url=../propietarios.php">';
               die();
             }
          } else {
             echo '<meta http-equiv="refresh" content="0;url=../propietarios.php">';
             die();
          }
        }
  }
?>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-success">
          <!-- form start -->
          <form role="form" method="post">
             <?php
                 if (@$answer->action == "error") {
                    echo "<div class='alert alert-danger alert-dismissable' role='alert'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
                    echo "<h4><i class='icon fa fa-ban'></i> Error en la " . strtolower($menuFileName) . "</h4>";
                    echo $answer->response->data;
                    echo "</div>";
                 }
             ?>
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-3">
                     <label>Cédula</label>
                    <input name="pro_ci" type="text" class="form-control" placeholder="Cédula" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_ci; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Fecha de Nacimiento:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="pro_fecha_nacimiento" name="pro_fecha_nacimiento" id="jinete-date" type="text" class="form-control pull-right" value="<?php $pro_fecha_nacimiento = !empty($pro_fecha_nacimiento) ? $pro_fecha_nacimiento : "1990-01-01"; echo $pro_fecha_nacimiento; ?>" readonly>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                     <label>Primer Nombre</label>
                    <input name="pro_primer_nombre" type="text" class="form-control" placeholder="Primer Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_primer_nombre; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Nombre</label>
                    <input name="pro_segundo_nombre" type="text" class="form-control" placeholder="Segundo Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_segundo_nombre; ?>">
                  </div>
                  <div class="col-xs-3">
                     <label>Primer Apellido</label>
                    <input name="pro_primer_apellido" type="text" class="form-control" placeholder="Primer Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_primer_apellido; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Apellido</label>
                    <input name="pro_segundo_apellido" type="text" class="form-control" placeholder="Segundo Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_segundo_apellido; ?>">
                  </div>
                  <div class="col-xs-3">
                     <label>Correo</label>
                    <input name="pro_correo" type="email" class="form-control" placeholder="Correo" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_correo; ?>" required>
                  </div>
                  <div class="col-xs-1">
                     <label>Cod</label>
                    <input name="tel_codigo" type="text" class="form-control" placeholder="Cod" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $tel_codigo; ?>">
                  </div>
                  <div class="col-xs-2">
                     <label>Telefono</label>
                    <input name="tel_numero" type="text" class="form-control" placeholder="Numero" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $tel_numero; ?>">
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Dirección</label>
                      <select name="fkpro_lug_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $lugaresList = json_decode($db->getLugares());
                          foreach ($lugaresList as $row) {
                              if ($row->pklug_id == $fkpro_lug_id) {
                                  echo "<option selected value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              } else {
                                  echo "<option value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
               <div class="col-xs-offset-3 col-xs-3">
                  <button name="pkpro_id" value="<?php echo $pkpro_id; ?>" type="submit" class="btn btn-update btn-block btn-flat uppercase">Crear</button>
               </div>
               <div class="col-xs-3">
                  <a href="<?php echo '../' . $_SESSION['last_page']; ?>" class="btn btn-default btn-block btn-flat uppercase">Cancelar</a>
               </div>
             </div>
            </div><!-- /.box-body -->
          </form>
       </div><!-- /.box -->

     </div><!--/.col (left) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
?>