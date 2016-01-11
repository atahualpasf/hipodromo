<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkeje_id = $fkeje_har_id = $fkeje_pel_id = $fkeje_raz_id = $fkeje_mad_id = $fkeje_pad_id = $eje_fecha_nacimiento = $eje_nombre = $eje_precio = $eje_sexo = $eje_tatuaje = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkeje_id'] = test_input($_POST['pkeje_id']);
      $GLOBALS['fkeje_har_id'] = test_input($_POST['fkeje_har_id']);
      $GLOBALS['fkeje_pel_id'] = test_input($_POST['fkeje_pel_id']);
      $GLOBALS['fkeje_raz_id'] = test_input($_POST['fkeje_raz_id']);
      $GLOBALS['fkeje_mad_id'] = test_input($_POST['fkeje_mad_id']);
      $GLOBALS['fkeje_pad_id'] = test_input($_POST['fkeje_pad_id']);
      $GLOBALS['eje_fecha_nacimiento'] = test_input($_POST['eje_fecha_nacimiento']);
      $GLOBALS['eje_nombre'] = test_input($_POST['eje_nombre']);
      $GLOBALS['eje_precio'] = test_input($_POST['eje_precio']);
      $GLOBALS['eje_sexo'] = test_input($_POST['eje_sexo']);
      $GLOBALS['eje_tatuaje'] = test_input($_POST['eje_tatuaje']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setValuesWhenSubmitIsClicked();
    $answer = @json_decode($db->createEjemplar($fkeje_har_id, $fkeje_pel_id, $fkeje_raz_id, $fkeje_mad_id, $fkeje_pad_id, $eje_fecha_nacimiento, $eje_nombre, $eje_precio, $eje_sexo, $eje_tatuaje));
    if ($answer->action != "error") {
      echo '<meta http-equiv="refresh" content="0;url=../ejemplares.php">';
      die();
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
                    <div class="form-group">
                      <label>Hara</label>
                      <select name="fkeje_har_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $harasList = json_decode($db->getHaras());
                          foreach ($harasList as $row) {
                              if ($row->pkhar_id == $fkeje_har_id) {
                                  echo "<option selected value='$row->pkhar_id'>$row->har_nombre</option>";
                              } else {
                                  echo "<option value='$row->pkhar_id'>$row->har_nombre</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Pelaje</label>
                      <select name="fkeje_pel_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $pelajesList = json_decode($db->getPelajes());
                          foreach ($pelajesList as $row) {
                              if ($row->pkpel_id == $fkeje_pel_id) {
                                  echo "<option selected value='$row->pkpel_id'>$row->pel_nombre</option>";
                              } else {
                                  echo "<option value='$row->pkpel_id'>$row->pel_nombre</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Raza</label>
                      <select name="fkeje_raz_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $razasList = json_decode($db->getRazas());
                          foreach ($razasList as $row) {
                            if ($row->pkraz_id == $fkeje_raz_id) {
                                echo "<option selected value='$row->pkraz_id'>$row->raz_nombre</option>";
                            } else {
                                echo "<option value='$row->pkraz_id'>$row->raz_nombre</option>";
                            }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Madre</label>
                      <select name="fkeje_mad_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $madresList = json_decode($db->getEjemplaresMadres());
                          if (empty($fkeje_mad_id)){
                            echo "<option selected value='$row->pkmadre'>Seleccione una madre</option>";
                          }
                          foreach ($madresList as $row) {
                            if ($row->pkmadre == $fkeje_mad_id) {
                                echo "<option selected value='$row->pkmadre'>$row->madre</option>";
                            } else {
                                echo "<option value='$row->pkmadre'>$row->madre</option>";
                            }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Padre</label>
                      <select name="fkeje_pad_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $padresList = json_decode($db->getEjemplaresPadres());
                          if (empty($fkeje_pad_id)){
                            echo "<option selected value='$row->pkpadre'>Seleccione un padre</option>";
                          }
                          foreach ($padresList as $row) {
                            if ($row->pkpadre == $fkeje_pad_id) {
                                echo "<option selected value='$row->pkpadre'>$row->padre</option>";
                            } else {
                                echo "<option value='$row->pkpadre'>$row->padre</option>";
                            }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Fecha de Nacimiento</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="eje_fecha_nacimiento" name="eje_fecha_nacimiento" id="jinete-date" type="text" class="form-control pull-right" value="<?php $eje_fecha_nacimiento = !empty($eje_fecha_nacimiento) ? $eje_fecha_nacimiento : "1990-01-01"; echo $eje_fecha_nacimiento; ?>" readonly>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-1">
                    <div class="form-group">
                      <label>Sexo</label>
                      <select name="eje_sexo" class="form-control select2" style="width: 100%;">
                        <?php
                            $sexosList = array("Y", "C");
                            foreach ($sexosList as $row) {
                                if ($eje_sexo == $row) {
                                    echo "<option selected value='$row'>$row</option>";
                                } else {
                                    echo "<option value='$row'>$row</option>";
                                }
                            }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                     <label>Nombre del Ejemplar</label>
                    <input name="eje_nombre" type="text" class="form-control" placeholder="Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $eje_nombre; ?>" required>
                  </div>
                  <div class="col-xs-2">
                     <label>Tatuaje Labial</label>
                    <input name="eje_tatuaje" type="text" class="form-control" placeholder="Tatuaje" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $eje_tatuaje; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Precio</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          Bs.
                        </div>
                        <input name="eje_precio" id="ejemplar-precio" type="text" class="form-control pull-right" value="<?php echo $eje_precio; ?>" required>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
              </div>
              <div class="box-footer">
                 <div class="col-xs-offset-3 col-xs-3">
                    <button name="pkeje_id" value="<?php echo $pkeje_id; ?>" type="submit" class="btn btn-update btn-block btn-flat uppercase">Crear</button>
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