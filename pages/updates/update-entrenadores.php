<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkent_id = $fkent_lug_id = $ent_ci = $ent_primer_nombre = "";
  $ent_segundo_nombre = $ent_primer_apellido = $ent_segundo_apellido = $ent_fecha_nacimiento = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($entrenadoresList) {
      $GLOBALS['pkent_id'] = $entrenadoresList[0]->pkent_id;
      $GLOBALS['fkent_lug_id'] = $entrenadoresList[0]->fkent_lug_id;
      $GLOBALS['ent_ci'] = $entrenadoresList[0]->ent_ci;
      $GLOBALS['ent_primer_nombre'] = $entrenadoresList[0]->ent_primer_nombre;
      $GLOBALS['ent_segundo_nombre'] = $entrenadoresList[0]->ent_segundo_nombre;
      $GLOBALS['ent_primer_apellido'] = $entrenadoresList[0]->ent_primer_apellido;
      $GLOBALS['ent_segundo_apellido'] = $entrenadoresList[0]->ent_segundo_apellido;
      $GLOBALS['ent_fecha_nacimiento'] = $entrenadoresList[0]->ent_fecha_nacimiento;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkent_id'] = test_input($_POST['pkent_id']);
      $GLOBALS['fkent_lug_id'] = test_input($_POST['fkent_lug_id']);
      $GLOBALS['ent_ci'] = test_input($_POST['ent_ci']);
      $GLOBALS['ent_primer_nombre'] = test_input($_POST['ent_primer_nombre']);
      $GLOBALS['ent_segundo_nombre'] = test_input($_POST['ent_segundo_nombre']);
      $GLOBALS['ent_primer_apellido'] = test_input($_POST['ent_primer_apellido']);
      $GLOBALS['ent_segundo_apellido'] = test_input($_POST['ent_segundo_apellido']);
      $GLOBALS['ent_fecha_nacimiento'] = test_input($_POST['ent_fecha_nacimiento']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
          $entrenadoresList = json_decode($db->getEntrenadorById($_POST['update_id']));
          setValues($entrenadoresList);
      } elseif(!empty($_POST['pkent_id'])) {
          setValuesWhenSubmitIsClicked();
          $answer = @json_decode($db->updateEntrenador($pkent_id, $fkent_lug_id, $ent_ci, $ent_primer_nombre, $ent_segundo_nombre, $ent_primer_apellido, $ent_segundo_apellido, $ent_fecha_nacimiento));
          if ($answer->action != "error") {
            echo '<meta http-equiv="refresh" content="0;url=../entrenadores.php">';
            die();
          }
      }
  } else {
    echo '<meta http-equiv="refresh" content="0;url=../entrenadores.php">';
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
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Dirección</label>
                      <select name="fkent_lug_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $lugaresList = json_decode($db->getLugares());
                          foreach ($lugaresList as $row) {
                              if ($row->pklug_id == $fkent_lug_id) {
                                  echo "<option selected value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              } else {
                                  echo "<option value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                     <label>Cédula</label>
                    <input name="ent_ci" type="text" class="form-control" placeholder="Cédula" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ent_ci; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Fecha de Nacimiento:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input name="ent_fecha_nacimiento" id="entrenador-date" type="text" class="form-control pull-right" value="<?php echo $ent_fecha_nacimiento; ?>">
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                     <label>Primer Nombre</label>
                    <input name="ent_primer_nombre" type="text" class="form-control" placeholder="Primer Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ent_primer_nombre; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Nombre</label>
                    <input name="ent_segundo_nombre" type="text" class="form-control" placeholder="Segundo Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ent_segundo_nombre; ?>">
                  </div>
                  <div class="col-xs-3">
                     <label>Primer Apellido</label>
                    <input name="ent_primer_apellido" type="text" class="form-control" placeholder="Primer Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ent_primer_apellido; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Apellido</label>
                    <input name="ent_segundo_apellido" type="text" class="form-control" placeholder="Segundo Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ent_segundo_apellido; ?>">
                  </div>
                </div>
              </div><!-- /.box-body -->

               <div class="box-footer">
                 <div class="col-xs-offset-3 col-xs-3">
                    <button name="pkent_id" value="<?php echo $pkent_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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