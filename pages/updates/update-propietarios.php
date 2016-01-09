<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkpro_id = $fkpro_lug_id = $pro_ci = $pro_primer_nombre = "";
  $pro_segundo_nombre = $pro_primer_apellido = $pro_segundo_apellido = $pro_fecha_nacimiento = $pro_correo = "";
  /*$pktel_id = $fkpro_tel_id = $fktel_ent_id = $fktel_jin_id = $fktel_caba_id = $fktel_inv_id = $fktel_taqu_id = $fktel_vet_id = */$tel_codigo = $tel_numero = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($propietariosList) {
      $GLOBALS['pkpro_id'] = $propietariosList[0]->pkpro_id;
      $GLOBALS['fkpro_lug_id'] = $propietariosList[0]->fkpro_lug_id;
      $GLOBALS['pro_ci'] = $propietariosList[0]->pro_ci;
      $GLOBALS['pro_primer_nombre'] = $propietariosList[0]->pro_primer_nombre;
      $GLOBALS['pro_segundo_nombre'] = $propietariosList[0]->pro_segundo_nombre;
      $GLOBALS['pro_primer_apellido'] = $propietariosList[0]->pro_primer_apellido;
      $GLOBALS['pro_segundo_apellido'] = $propietariosList[0]->pro_segundo_apellido;
      $GLOBALS['pro_fecha_nacimiento'] = $propietariosList[0]->pro_fecha_nacimiento;
      $GLOBALS['pro_correo'] = $propietariosList[0]->pro_correo;
      // $GLOBALS['pktel_id'] = $propietariosList[0]->pktel_id;
      // $GLOBALS['fktel_pro_id'] = $propietariosList[0]->fktel_pro_id;
      // // $GLOBALS['fktel_ent_id'] = $propietariosList[0]->$fktel_ent_id;
      // // $GLOBALS['fktel_jin_id'] = $propietariosList[0]->$fktel_jin_id;
      // // $GLOBALS['fktel_caba_id'] = $propietariosList[0]->$fktel_caba_id;
      // // $GLOBALS['fktel_inv_id'] = $propietariosList[0]->$fktel_inv_id;
      // // $GLOBALS['fktel_taqu_id'] = $propietariosList[0]->$fktel_taqu_id;
      // // $GLOBALS['fktel_vet_id'] = $propietariosList[0]->$fktel_vet_id;
      $GLOBALS['tel_codigo'] = $propietariosList[0]->tel_codigo;
      $GLOBALS['tel_numero'] = $propietariosList[0]->tel_numero;
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
      // $GLOBALS['pktel_id'] = test_input($_POST['pktel_id']);
      // $GLOBALS['fktel_pro_id'] = test_input($_POST['fktel_pro_id']);
      // $GLOBALS['fktel_ent_id'] = test_input($_POST['fktel_ent_id']);
      // $GLOBALS['fktel_jin_id'] = test_input($_POST['fktel_jin_id']);
      // $GLOBALS['fktel_caba_id'] = test_input($_POST['fktel_caba_id']);
      // $GLOBALS['fktel_inv_id'] = test_input($_POST['fktel_inv_id']);
      // $GLOBALS['fktel_taqu_id'] = test_input($_POST['fktel_taqu_id']);
      // $GLOBALS['fktel_vet_id'] = test_input($_POST['fktel_vet_id']);
      $GLOBALS['tel_codigo'] = test_input($_POST['tel_codigo']);
      $GLOBALS['tel_numero'] = test_input($_POST['tel_numero']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
          $propietariosList = json_decode($db->getPropietarioById($_POST['update_id']));
          setValues($propietariosList);
          // $telefonosList = json_decode($db->getTelefonoById($_POST['update_id']));
          // setValues($telefonosList);
      } elseif(!empty($_POST['pkpro_id'])) {
          setValuesWhenSubmitIsClicked();
          $answer = @json_decode($db->updatePropietario($pkpro_id, $fkpro_lug_id, $pro_ci, $pro_primer_nombre, $pro_segundo_nombre, $pro_primer_apellido, $pro_segundo_apellido, $pro_fecha_nacimiento, $pro_correo));
          if ($answer->action != "error") {
            // $answer = @json_decode($db->updateTelefono($pktel_id, $fktel_pro_id, $fktel_ent_id, $fktel_jin_id, $fktel_caba_id, $fktel_inv_id, $fktel_taqu_id, $fktel_vet_id, $tel_codigo, $tel_numero));
            // if ($answer->action != "error") {
              echo '<meta http-equiv="refresh" content="0;url=../propietarios.php">';
              die();
            // }
          }
      }
  } else {
    echo '<meta http-equiv="refresh" content="0;url=../propietarios.php">';
    die();
  }
?>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-info">
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
                        <input name="pro_fecha_nacimiento" id="jinete-date" type="text" class="form-control pull-right" value="<?php echo $pro_fecha_nacimiento; ?>">
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
                    <input name="pro_correo" type="text" class="form-control" placeholder="Correo" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $pro_correo; ?>">
                  </div>
                  <div class="col-xs-1">
                     <label>Cod</label>
                    <input name="tel_cod" type="text" class="form-control" placeholder="Cod" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $tel_codigo; ?>">
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
                    <button name="pkpro_id" value="<?php echo $pkpro_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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