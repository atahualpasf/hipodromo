<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],5))->action != "success")) {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkcab_id'])) {
          $answer = json_decode($db->deleteCaballeriza($_POST['pkcab_id']));
      }
  }
  $caballerizasList = @json_decode($db->getCaballerizas());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Caballerizas
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Caballerizas</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">             
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Descripción General</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>caballerizo</th>
                        <th>veterinario</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($caballerizasList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkcab_id</td>";
                            echo "<td>$row->cab_descripcion</td>";
                            echo "<td>$row->caballerizo</td>";
                            echo "<td>$row->veterinario</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkcab_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],15))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],18))->action != "success")) {
                               echo "<td><button name='pkcab_id' value='$row->pkcab_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block' disabled><i class='fa fa-trash'></i></button></td>";
                            } else {
                               echo "<td><button name='pkcab_id' value='$row->pkcab_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>"; 
                            }
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>caballerizo</th>
                        <th>veterinario</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>           

          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
      ?>