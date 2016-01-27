<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  if (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkusu_id'])) {
          $answer = json_decode($db->deleteUsuario($_POST['pkusu_id']));
      }
  }
  
  $usuariosList = @json_decode($db->getUsuarios());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Apuestas
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Usuarios</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
             
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Usuarios</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>idea</th>
                        <th>nombre</th>
                        <th>correo</th>
                        <th>rol</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($usuariosList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkusu_id</td>";
                            echo "<td>$row->usu_nombre</td>";
                            echo "<td>$row->usu_correo</td>";
                            echo "<td>$row->rol_nombre</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkusu_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            if (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") {
                               echo "<td><button name='pkfac_id' value='$row->pkusu_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block' disabled><i class='fa fa-trash'></i></button></td>";
                            } else {
                               echo "<td><button name='pkusu_id' value='$row->pkusu_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            }
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>idea</th>
                        <th>nombre</th>
                        <th>correo</th>
                        <th>rol</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
      ?>