<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],4))->action != "success")) {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkfac_id'])) {
          $answer = json_decode($db->deleteApuestaByFactura($_POST['pkfac_id']));
      }
  }
  $facturasByApuestaList = @json_decode($db->getFacturasByApuesta());
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
            <li class="active">Apuestas</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
             
             <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo count($facturasByApuestaList); ?></h3>
                  <p>Apuestas registradas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <?php echo "<a href='creates/create-" . $basefile . ".php' class='small-box-footer'>"; ?>
                  Agregar apuesta <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-6 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo count($facturasByApuestaList) ?></h3>
                  <p>Apuestas Registradas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href='../reports/reports.php?report=getApuestas' class='small-box-footer'>
                  Ver reporte de apuestas <i class="fa fa-arrow-circle-right"></i>
                </a>
             </div>
           </div><!-- ./col -->
             
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Apuestas</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>monto</th>
                        <th>fecha</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($facturasByApuestaList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkfac_id</td>";
                            echo "<td>$row->fac_monto</td>";
                            echo "<td>$row->fac_fecha</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkfac_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='pkfac_id' value='$row->pkfac_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>monto</th>
                        <th>fecha</th>
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