<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],5))->action != "success")) {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkjin_id'])) {
          $answer = json_decode($db->deleteJinete($_POST['pkjin_id']));
      }
  }
  $jinetesList = @json_decode($db->getJinetes());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Jinetes
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Jinetes</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
             
             <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                 <div class="inner">
                   <h3><?php echo count($jinetesList); ?></h3>
                   <p>Jinetes Registrados</p>
                 </div>
                 <div class="icon">
                   <i class="ion ion-person-add"></i>
                 </div>
                 <?php echo "<a href='creates/create-" . $basefile . ".php' class='small-box-footer'>"; ?>
                   Agregar jinete <i class="fa fa-arrow-circle-right"></i>
                 </a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-6 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo count($jinetesList) ?></h3>
                  <p>Jinetes Registrados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href='../reports/reports.php?report=getJinetes' class='small-box-footer'>
                  Ver reporte de jinetes <i class="fa fa-arrow-circle-right"></i>
                </a>
             </div>
           </div><!-- ./col -->
             
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
                        <th>cedula</th>
                        <th>nombre completo</th>
                        <th>altura</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($jinetesList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkjin_id</td>";
                            echo "<td>$row->jin_ci</td>";
                            echo "<td>$row->jin_primer_nombre $row->jin_segundo_nombre $row->jin_primer_apellido $row->jin_segundo_apellido</td>";
                            echo "<td>$row->jin_altura</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkjin_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='pkjin_id' value='$row->pkjin_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                      </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>cedula</th>
                        <th>nombre completo</th>
                        <th>altura</th>
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