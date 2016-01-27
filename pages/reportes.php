<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  if (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reportes
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reportes</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#1</h3>
                  <p>Listado de Usuarios con sus roles</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R1ListadoDeUsuarios" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
      ?>
