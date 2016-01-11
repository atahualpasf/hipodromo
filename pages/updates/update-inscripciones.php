<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkins_id = $fkins_car_id = $fkins_cor_id = $ins_valor = $ins_gualdrapa = $ins_puesto_partida = $ins_favorito = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($inscripcionesList) {
      $GLOBALS['pkins_id'] = $inscripcionesList[0]->pkins_id;
      $GLOBALS['fkins_car_id'] = $inscripcionesList[0]->fkins_car_id;
      $GLOBALS['fkins_cor_id'] = $inscripcionesList[0]->fkins_cor_id;
      $GLOBALS['ins_valor'] = $inscripcionesList[0]->ins_valor;
      $GLOBALS['ins_gualdrapa'] = $inscripcionesList[0]->ins_gualdrapa;
      $GLOBALS['ins_puesto_partida'] = $inscripcionesList[0]->ins_puesto_partida;
      $GLOBALS['ins_favorito'] = $inscripcionesList[0]->ins_favorito;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkins_id'] = test_input($_POST['pkins_id']);
      $GLOBALS['fkins_car_id'] = test_input($_POST['fkins_car_id']);
      $GLOBALS['fkins_cor_id'] = test_input($_POST['fkins_cor_id']);
      $GLOBALS['ins_valor'] = test_input($_POST['ins_valor']);
      $GLOBALS['ins_gualdrapa'] = test_input($_POST['ins_gualdrapa']);
      $GLOBALS['ins_puesto_partida'] = test_input($_POST['ins_puesto_partida']);
      $GLOBALS['ins_favorito'] = test_input($_POST['ins_favorito']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
        $inscripcionesList = json_decode($db->getInscripcionById($_POST['update_id']));
        setValues($inscripcionesList);
      } elseif(!empty($_POST['pkins_id'])) {
        setValuesWhenSubmitIsClicked();
        $answer = @json_decode($db->updateInscripcion($pkins_id, $fkins_car_id, $fkins_cor_id, $ins_valor, $ins_gualdrapa, $ins_puesto_partida, $ins_favorito));
        if ($answer->action != "error") {
          echo '<meta http-equiv="refresh" content="0;url=../inscripciones.php">';
          die();
        }
      }
  } else {
    echo '<meta http-equiv="refresh" content="0;url=../inscripciones.php">';
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
                      <label>Carreras</label>
                      <select name="fkins_car_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $carrerasList = json_decode($db->getCarreras());
                          foreach ($carrerasList as $row) {
                              if ($row->pkcar_id == $fkins_car_id) {
                                  echo "<option selected value='$row->pkcar_id'>$row->car_fecha - $row->hor_inicio ($row->car_orden)</option>";
                              } else {
                                  echo "<option value='$row->pkcar_id'>$row->car_fecha - $row->hor_inicio ($row->car_orden)</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Corredores</label>
                      <select name="fkins_cor_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $corredoresList = json_decode($db->getCorredores());
                          foreach ($corredoresList as $row) {
                              if ($row->pkcor_id == $fkins_cor_id) {
                                  echo "<option selected value='$row->pkcor_id'>$row->eje_nombre ($row->jinete)</option>";
                              } else {
                                  echo "<option value='$row->pkcor_id'>$row->eje_nombre ($row->jinete)</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-2">
                     <div class="form-group">
                      <label>Valor</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          Bs.
                        </div>
                        <input name="ins_valor" id="inscripcion-precio" type="text" class="form-control pull-right" value="<?php echo $ins_valor; ?>" required>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                  <div class="col-xs-2">
                     <label>Gualdrapa</label>
                    <input name="ins_gualdrapa" type="text" class="form-control" placeholder="Gualdrapa" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ins_gualdrapa; ?>">
                  </div>
                  <div class="col-xs-2">
                     <label>Puesto de Partida</label>
                    <input name="ins_puesto_partida" type="text" class="form-control" placeholder="PP" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $ins_puesto_partida; ?>">
                  </div>
                  <div class="col-xs-2">
                    <div class="form-group">
                      <label>Favorito</label>
                      <select name="ins_favorito" class="form-control select2" style="width: 100%;">
                        <?php
                            $favoritosList = array(1,2,3);
                            if (empty($ins_favorito)){
                              echo "<option selected value='$row->ins_favorito'>Seleccione favorito</option>";
                            }
                            foreach ($favoritosList as $row) {
                                if ($ins_favorito == $row) {
                                    echo "<option selected value='$row'>$row</option>";
                                } else {
                                    echo "<option value='$row'>$row</option>";
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
                  <button name="pkins_id" value="<?php echo $pkins_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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