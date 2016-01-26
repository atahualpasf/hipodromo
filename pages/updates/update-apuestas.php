<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],11))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],13))->action != "success")) {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }

  $pkfac_id = $pkapu_id = $fkapu_cor_id = $fkapu_jug_id = $fkapu_fac_id = $fkapu_taq_id = $apu_monto = $apu_lugar_llegada = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($facturasByApuestaList) {
      $GLOBALS['pkfac_id'] = $facturasByApuestaList[0]->pkapu_id;
      // $GLOBALS['pkapu_id'] = $apuestasList[0]->pkapu_id;
      // $GLOBALS['fkapu_cor_id'] = $apuestasList[0]->fkapu_cor_id;
      // $GLOBALS['fkapu_jug_id'] = $apuestasList[0]->fkapu_jug_id;
      // $GLOBALS['fkapu_fac_id'] = $apuestasList[0]->fkapu_fac_id;
      // $GLOBALS['fkapu_taq_id'] = $apuestasList[0]->fkapu_taq_id;
      // $GLOBALS['apu_monto'] = $apuestasList[0]->apu_monto;
      // $GLOBALS['apu_lugar_llegada'] = $apuestasList[0]->apu_lugar_llegada;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkfac_id'] = test_input($_POST['pkfac_id']);
      // $GLOBALS['pkapu_id'] = test_input($_POST['pkapu_id']);
      // $GLOBALS['fkapu_cor_id'] = test_input($_POST['fkapu_cor_id']);
      // $GLOBALS['fkapu_jug_id'] = test_input($_POST['fkapu_jug_id']);
      // $GLOBALS['fkapu_fac_id'] = test_input($_POST['fkapu_fac_id']);
      // $GLOBALS['fkapu_taq_id'] = test_input($_POST['fkapu_taq_id']);
      // $GLOBALS['apu_monto'] = test_input($_POST['apu_monto']);
      // $GLOBALS['apu_lugar_llegada'] = test_input($_POST['apu_lugar_llegada']);
  }

  // if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //     if (!empty($_POST['update_id'])) {
  //         $apuestasList = json_decode($db->getApuestaByFactura($_POST['update_id']));
  //         setValues($apuestasList);
  //     } elseif(!empty($_POST['pkapu_id'])) {
  //       setValuesWhenSubmitIsClicked();
  //       $answer = @json_decode($db->updateApuesta($pkapu_id, /*$fkapu_cor_id, */$fkapu_jug_id,/* $fkapu_fac_id, */$fkapu_taq_id, $apu_monto, $apu_lugar_llegada));
  //       if ($answer->action != "error") {
  //         echo '<meta http-equiv="refresh" content="0;url=../apuestas.php">';
  //         die();
  //       }
  //     }
  // } else {
  //   echo '<meta http-equiv="refresh" content="0;url=../apuestas.php">';
  //   die();
  // }
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
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Apuestas</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <table id="tableDefault" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>taquilla</th>
                      <th>jugada</th>
                      <th>ejemplar</th>
                      <th>lugar de llegada</th>
                      <th>monto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $apuestasList = @json_decode($db->getApuestaByFactura($pkfac_id));
                      foreach ($apuestasList as $row) {
                          echo "<tr>";
                          echo "<td>$row->pkapu_id</td>";
                          echo "<td>$row->taq_nombre</td>";
                          echo "<td>$row->jug_nombre</td>";
                          echo "<td>$row->eje_nombre</td>";
                          echo "<td>$row->apu_lugar_llegada</td>";
                          echo "<td>$row->apu_monto</td>";
                          echo "</tr>";
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>id</th>
                      <th>taquilla</th>
                      <th>jugada</th>
                      <th>ejemplar</th>
                      <th>lugar de llegada</th>
                      <th>monto</th>
                    </tr>
                  </tfoot>
                </table>
              </div><!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-xs-3">
                    <a href="<?php echo '../' . $_SESSION['last_page']; ?>" class="btn btn-default btn-block btn-flat uppercase">Cancelar</a>
                 </div>
               </div>
            </div>
          </form>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
?>