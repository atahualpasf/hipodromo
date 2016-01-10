<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkapu_id = $fkapu_cor_id = $fkapu_jug_id = $fkapu_fac_id = $fkapu_taq_id = $apu_monto = $apu_lugar_llegada= "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($apuestasList) {
      $GLOBALS['pkapu_id'] = $apuestasList[0]->pkapu_id;
      // $GLOBALS['fkapu_cor_id'] = $apuestasList[0]->fkapu_cor_id;
      $GLOBALS['fkapu_jug_id'] = $apuestasList[0]->fkapu_jug_id;
      // $GLOBALS['fkapu_fac_id'] = $apuestasList[0]->fkapu_fac_id;
      // $GLOBALS['fkapu_taq_id'] = $apuestasList[0]->fkapu_taq_id;
      $GLOBALS['apu_monto'] = $apuestasList[0]->apu_monto;
      $GLOBALS['apu_lugar_llegada'] = $apuestasList[0]->apu_lugar_llegada;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkapu_id'] = test_input($_POST['pkapu_id']);
      // $GLOBALS['fkapu_cor_id'] = test_input($_POST['fkapu_cor_id']);
      $GLOBALS['fkapu_jug_id'] = test_input($_POST['fkapu_jug_id']);
      // $GLOBALS['fkapu_fac_id'] = test_input($_POST['fkapu_fac_id']);
      // $GLOBALS['fkapu_taq_id'] = test_input($_POST['fkapu_taq_id']);
      $GLOBALS['apu_monto'] = test_input($_POST['apu_monto']);
      $GLOBALS['apu_lugar_llegada'] = test_input($_POST['apu_lugar_llegada']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
          $apuestasList = json_decode($db->getApuestaById($_POST['update_id']));
          setValues($apuestasList);
      } elseif(!empty($_POST['pkapu_id'])) {
        setValuesWhenSubmitIsClicked();
        $answer = @json_decode($db->updateApuesta($pkapu_id, /*$fkapu_cor_id, */$fkapu_jug_id,/* $fkapu_fac_id, $fkapu_taq_id, */$apu_monto, $apu_lugar_llegada));
        if ($answer->action != "error") {
          echo '<meta http-equiv="refresh" content="0;url=../apuestas.php">';
          die();
        }
      }
  } else {
    echo '<meta http-equiv="refresh" content="0;url=../apuestas.php">';
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
                    <div class="form-group">
                      <label>Jugada</label>
                      <select name="fkapu_jug_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $jugadasList = json_decode($db->getJugadas());
                          foreach ($jugadasList as $row) {
                              if ($row->pkjug_id == $fkapu_jug_id) {
                                  echo "<option selected value='$row->pkjug_id'>$row->jug_nombre</option>";
                              } else {
                                  echo "<option value='$row->pkjug_id'>$row->jug_nombre</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-2">
                     <label>Lugar de Llegada</label>
                     <input name="apu_lugar_llegada" type="text" class="form-control" placeholder="Lugar de llegada" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $apu_lugar_llegada; ?>">
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Monto</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          Bs.
                        </div>
                        <input name="apu_monto" id="apuesta-monto" type="text" class="form-control pull-right" value="<?php echo $apu_monto; ?>" required>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
              </div>
              <div class="box-footer">
                 <div class="col-xs-offset-3 col-xs-3">
                    <button name="pkapu_id" value="<?php echo $pkapu_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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