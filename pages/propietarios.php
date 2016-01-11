<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkpro_id'])) {
          $answer = json_decode($db->deletePropietario($_POST['pkpro_id']));
      }
  }
  $propietariosList = @json_decode($db->getPropietarios());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Propietarios
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Propietarios</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
             
             <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                 <div class="inner">
                   <h3><?php echo count($propietariosList); ?></h3>
                   <p>Propietarios Registrados</p>
                 </div>
                 <div class="icon">
                   <i class="ion ion-person-add"></i>
                 </div>
                 <?php echo "<a href='creates/create-" . $basefile . ".php' class='small-box-footer'>"; ?>
                   Agregar propietario <i class="fa fa-arrow-circle-right"></i>
                 </a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-6 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo count($propietariosList) ?></h3>
                  <p>Propietarios Registrados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href='../reports/reports.php?report=getPropietarios' class='small-box-footer'>
                  Ver reporte de propietarios <i class="fa fa-arrow-circle-right"></i>
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
                        <th>nombre</th>
                        <th>nacimiento</th>
                        <th>telefono</th>
                        <th>correo</th>
                        <th>dirección</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($propietariosList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkpro_id</td>";
                            echo "<td>$row->pro_ci</td>";
                            echo "<td>$row->pro_primer_nombre $row->pro_segundo_nombre $row->pro_primer_apellido $row->pro_segundo_apellido</td>";
                            echo "<td>$row->pro_fecha_nacimiento</td>";
                            echo "<td>$row->tel_codigo $row->tel_numero</td>";
                            echo "<td>$row->pro_correo</td>";
                            echo "<td>$row->parroquia, $row->estado</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkpro_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='pkpro_id' value='$row->pkpro_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                      </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>cedula</th>
                        <th>nombre</th>
                        <th>nacimiento</th>
                        <th>telefono</th>
                        <th>correo</th>
                        <th>dirección</th>
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