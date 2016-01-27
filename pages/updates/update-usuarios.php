<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  if (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }

  $pkusu_id = $fkusu_rol_id = $usu_nombre = $usu_correo = $usu_clave = $usu_imagen = "";

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function setValues($usuariosList) {
      $GLOBALS['pkusu_id'] = $usuariosList[0]->pkusu_id;
      $GLOBALS['fkusu_rol_id'] = $usuariosList[0]->fkusu_rol_id;
      $GLOBALS['usu_nombre'] = $usuariosList[0]->usu_nombre;
      $GLOBALS['usu_correo'] = $usuariosList[0]->usu_correo;
      $GLOBALS['usu_clave'] = $usuariosList[0]->usu_clave;
      $GLOBALS['usu_imagen'] = $usuariosList[0]->usu_imagen;
  }

  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkusu_id'] = test_input($_POST['pkusu_id']);
      $GLOBALS['fkusu_rol_id'] = test_input($_POST['fkusu_rol_id']);
      $GLOBALS['usu_nombre'] = test_input($_POST['usu_nombre']);
      $GLOBALS['usu_correo'] = test_input($_POST['usu_correo']);
      $GLOBALS['usu_clave'] = test_input($_POST['usu_clave']);
      $GLOBALS['usu_imagen'] = test_input($_POST['usu_imagen']);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['update_id'])) {
        $usuariosList = json_decode($db->getUsuarioPorId($_POST['update_id']));
        setValues($usuariosList);
    } elseif(!empty($_POST['pkusu_id'])) {
      setValuesWhenSubmitIsClicked();
      var_dump($_POST['usu_clave']);
      $answer = @json_decode($db->updateUsuario($pkusu_id, $fkusu_rol_id, $usu_nombre, $usu_correo, $usu_clave, $usu_imagen));
      if ($answer->action != "error") {
        echo '<meta http-equiv="refresh" content="0;url=../usuarios.php">';
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
                     <label>Nombre</label>
                    <input name="usu_nombre" type="text" class="form-control" placeholder="Nombre" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $usu_nombre; ?>" required>
                  </div>
                  <div class="col-xs-4">
                     <label>Correo</label>
                    <input name="usu_correo" type="email" class="form-control" placeholder="Correo" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $usu_correo; ?>" required>
                  </div>
                  <div class="col-xs-4">
                     <label>Clave</label>
                    <input name="usu_clave" type="text" class="form-control" placeholder="Clave" onblur="this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();" value="<?php echo $usu_clave; ?>" required>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Roles</label>
                      <select name="fkusu_rol_id" class="form-control select2" style="width: 100%;">
                        <?php
                          $rolesList = json_decode($db->getRoles());
                          foreach ($rolesList as $row) {
                              if ($row->pkrol_id == $fkusu_rol_id) {
                                  echo "<option selected value='$row->pkrol_id'>$row->rol_nombre</option>";
                              } else {
                                  echo "<option value='$row->pkrol_id'>$row->rol_nombre</option>";
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
                  <button name="pkusu_id" value="<?php echo $pkusu_id; ?>" type="submit" class="btn btn-dropbox btn-block btn-flat uppercase">Editar</button>
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