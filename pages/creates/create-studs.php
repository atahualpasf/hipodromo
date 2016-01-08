<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  $pkstu_id = $fkstu_lug_id = $stu_nombre = $stu_fecha_creacion = "";
  
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
  function setValues($studsList) {
      $GLOBALS['pkstu_id'] = $studsList[0]->pkstu_id;
      $GLOBALS['fkstu_lug_id'] = $studsList[0]->fkstu_lug_id;
      $GLOBALS['stu_nombre'] = $studsList[0]->stu_nombre;
      $GLOBALS['stu_fecha_creacion'] = $studsList[0]->stu_fecha_creacion;
  }
  
  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkstu_id'] = test_input($_POST['pkstu_id']);
      $GLOBALS['fkstu_lug_id'] = test_input($_POST['fkstu_lug_id']);
      $GLOBALS['stu_nombre'] = test_input($_POST['stu_nombre']);
      $GLOBALS['stu_fecha_creacion'] = test_input($_POST['stu_fecha_creacion']);
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
          $studsList = json_decode($db->getStudById($_POST['update_id']));
          setValues($studsList);
      } elseif(!empty($_POST['pkstu_id'])) {
          setValuesWhenSubmitIsClicked();
          $answer = @json_decode($db->updateStud($pkstu_id, $fkstu_lug_id, $stu_nombre, $stu_fecha_creacion));
          if ($answer->action != "error") {
            echo '<meta http-equiv="refresh" content="0;url=../studs.php">';
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
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label>Dirección</label>
                      <select name="fkstu_lug_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $lugaresList = json_decode($db->getLugares());
                          foreach ($lugaresList as $row) {
                              if ($row->pklug_id == $fkstu_lug_id) {
                                  echo "<option selected value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              } else {
                                  echo "<option value='$row->pklug_id'>$row->estado, $row->municipio, $row->parroquia</option>";
                              }
                          }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-4">
                     <label>Nombre del stud</label>
                    <input name="stu_nombre" type="text" class="form-control" placeholder="Nombre del stud" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $stu_nombre; ?>" required>
                  </div>
                  <div class="col-xs-4">
                     <div class="form-group">
                      <label>Fecha de creación:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input name="stu_fecha_creacion" id="stud-date" type="text" class="form-control pull-right" value="<?php echo $stu_fecha_creacion; ?>">
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
              </div><!-- /.box-body -->

               <div class="box-footer">
                 <div class="col-xs-offset-3 col-xs-3">
                    <button name="pkstu_id" value="<?php echo $pkstu_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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