<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  $pkjin_id = $fkjin_lug_id = $jin_ci = $jin_primer_nombre = "";
  $jin_segundo_nombre = $jin_primer_apellido = $jin_segundo_apellido = $jin_fecha_nacimiento = "";
  $jin_altura = $jin_experiencia = $tel_codigo = $tel_numero = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($jinetesList) {
      $GLOBALS['pkjin_id'] = $jinetesList[0]->pkjin_id;
      $GLOBALS['fkjin_lug_id'] = $jinetesList[0]->fkjin_lug_id;
      $GLOBALS['jin_ci'] = $jinetesList[0]->jin_ci;
      $GLOBALS['jin_primer_nombre'] = $jinetesList[0]->jin_primer_nombre;
      $GLOBALS['jin_segundo_nombre'] = $jinetesList[0]->jin_segundo_nombre;
      $GLOBALS['jin_primer_apellido'] = $jinetesList[0]->jin_primer_apellido;
      $GLOBALS['jin_segundo_apellido'] = $jinetesList[0]->jin_segundo_apellido;
      $GLOBALS['jin_fecha_nacimiento'] = $jinetesList[0]->jin_fecha_nacimiento;
      $GLOBALS['jin_altura'] = $jinetesList[0]->jin_altura;
      $GLOBALS['jin_experiencia'] = $jinetesList[0]->jin_experiencia;
      $GLOBALS['tel_codigo'] = $jinetesList[0]->tel_codigo;
      $GLOBALS['tel_numero'] = $jinetesList[0]->tel_numero;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkjin_id'] = test_input($_POST['pkjin_id']);
      $GLOBALS['fkjin_lug_id'] = test_input($_POST['fkjin_lug_id']);
      $GLOBALS['jin_ci'] = test_input($_POST['jin_ci']);
      $GLOBALS['jin_primer_nombre'] = test_input($_POST['jin_primer_nombre']);
      $GLOBALS['jin_segundo_nombre'] = test_input($_POST['jin_segundo_nombre']);
      $GLOBALS['jin_primer_apellido'] = test_input($_POST['jin_primer_apellido']);
      $GLOBALS['jin_segundo_apellido'] = test_input($_POST['jin_segundo_apellido']);
      $GLOBALS['jin_fecha_nacimiento'] = test_input($_POST['jin_fecha_nacimiento']);
      $GLOBALS['jin_altura'] = test_input($_POST['jin_altura']);
      $GLOBALS['jin_experiencia'] = test_input($_POST['jin_experiencia']);
      $GLOBALS['tel_codigo'] = test_input($_POST['tel_codigo']);
      $GLOBALS['tel_numero'] = test_input($_POST['tel_numero']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['update_id'])) {
          $jinetesList = json_decode($db->getJineteById($_POST['update_id']));
          setValues($jinetesList);
      } elseif(!empty($_POST['pkjin_id'])) {
        setValuesWhenSubmitIsClicked();
        $answer = @json_decode($db->updateJinete($pkjin_id, $fkjin_lug_id, $jin_ci, $jin_primer_nombre, $jin_segundo_nombre, $jin_primer_apellido, $jin_segundo_apellido, $jin_fecha_nacimiento, $jin_altura, $jin_experiencia));
        if ($answer->action != "error") {
          $answer = @json_decode($db->updateTelefono($pkjin_id, $tel_codigo, $tel_numero));
          if ($answer->action != "error") {
            echo '<meta http-equiv="refresh" content="0;url=../jinetes.php">';
            die();
          }
        }
      }
  } else {
    echo '<meta http-equiv="refresh" content="0;url=../jinetes.php">';
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
                    <input name="jin_ci" type="text" class="form-control" placeholder="Cédula" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_ci; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <div class="form-group">
                      <label>Fecha de Nacimiento:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="jin_fecha_nacimiento" name="jin_fecha_nacimiento" type="text" class="form-control pull-right" value="<?php echo $jin_fecha_nacimiento; ?>" readonly>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                     <label>Primer Nombre</label>
                    <input name="jin_primer_nombre" type="text" class="form-control" placeholder="Primer Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_primer_nombre; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Nombre</label>
                    <input name="jin_segundo_nombre" type="text" class="form-control" placeholder="Segundo Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_segundo_nombre; ?>">
                  </div>
                  <div class="col-xs-3">
                     <label>Primer Apellido</label>
                    <input name="jin_primer_apellido" type="text" class="form-control" placeholder="Primer Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_primer_apellido; ?>" required>
                  </div>
                  <div class="col-xs-3">
                     <label>Segundo Apellido</label>
                    <input name="jin_segundo_apellido" type="text" class="form-control" placeholder="Segundo Apellido" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_segundo_apellido; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-1">
                     <label>Cod</label>
                    <input name="tel_codigo" type="text" class="form-control" placeholder="Cod" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $tel_codigo; ?>">
                  </div>
                  <div class="col-xs-2">
                     <label>Telefono</label>
                    <input name="tel_numero" type="text" class="form-control" placeholder="Numero" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $tel_numero; ?>">
                  </div>
                  <div class="col-xs-1">
                     <label>Altura</label>
                    <input name="jin_altura" type="text" class="form-control" placeholder="Altura" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $jin_altura; ?>" required>
                  </div>
                  <div class="col-xs-2">
                    <div class="form-group">
                      <label>Experiencia</label>
                      <select name="jin_experiencia" class="form-control select2" style="width: 100%;">
                        <?php
                            $experienciaList = array("A", "P");
                            foreach ($experienciaList as $row) {
                                if ($jin_experiencia == $row) {
                                    echo "<option selected value='$row'>$row</option>";
                                } else {
                                    echo "<option value='$row'>$row</option>";
                                }
                            }
                        ?>
                      </select>
                    </div><!-- /.form-group -->
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Dirección</label>
                      <select name="fkjin_lug_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $lugaresList = json_decode($db->getLugares());
                          foreach ($lugaresList as $row) {
                              if ($row->pklug_id == $fkjin_lug_id) {
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
                    <button name="pkjin_id" value="<?php echo $pkjin_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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