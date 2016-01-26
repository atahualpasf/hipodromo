<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],1))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],5))->action != "success")) {
      echo '<meta http-equiv="refresh" content="0;url=' . $_SESSION["last_uri"] . '">';
      die();
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['pkstu_id'])) {
          $answer = json_decode($db->deleteStud($_POST['pkstu_id']));
      }
  }
  $studsList = @json_decode($db->getStuds());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Studs
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Studs</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
             
             <div class="col-lg-6 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                 <div class="inner">
                   <h3><?php echo count($studsList); ?></h3>
                   <p>Studs Registrados</p>
                 </div>
                 <div class="icon">
                   <i class="ion ion-plus"></i>
                 </div>
                 <?php echo "<a href='creates/create-" . $basefile . ".php' class='small-box-footer'>"; ?>
                   Agregar stud <i class="fa fa-arrow-circle-right"></i>
                 </a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-6 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo count($studsList) ?></h3>
                  <p>Studs Registrados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href='../reports/reports.php?report=getStuds' class='small-box-footer'>
                  Ver reporte de studs <i class="fa fa-arrow-circle-right"></i>
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
                        <th>nombre</th>
                        <th>creación</th>
                        <th>dirección</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($studsList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkstu_id</td>";
                            echo "<td>$row->stu_nombre</td>";
                            echo "<td>$row->stu_fecha_creacion</td>";
                            echo "<td>$row->parroquia, $row->estado</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkstu_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            if ((json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],15))->action != "success") AND (json_decode($db->getPrivilegiosByRol($_SESSION['rol']['pkrol_id'],18))->action != "success")) {
                               echo "<td><button name='pkstu_id' value='$row->pkstu_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block' disabled><i class='fa fa-trash'></i></button></td>"; 
                            } else {
                               echo "<td><button name='pkstu_id' value='$row->pkstu_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>"; 
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
                        <th>creación</th>
                        <th>dirección</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
           
           <div class="col-lg-12 col-xs-12">
           <!-- small box -->
           <div class="small-box bg-aqua">
               <div class="inner">
                 <h3><?php echo count($studsList) ?></h3>
                 <p>Studs Registrados</p>
               </div>
               <div class="icon">
                 <i class="ion ion-document-text"></i>
               </div>
               <a href='../reports/reports.php?report=getStudsWithUniform' class='small-box-footer'>
                 Ver reporte de studs por uniforme <i class="fa fa-arrow-circle-right"></i>
               </a>
           </div>
          </div><!-- ./col -->
           
           <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Descripción de uniforme</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault-1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>gorra</th>
                        <th>chaqueta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($studsList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkstu_id</td>";
                            echo "<td>$row->stu_nombre</td>";
                            echo "<td>";
                            $gorraList = @json_decode($db->getGorrasDetalladoByStud($row->pkstu_id));
                            $moraThanOne = count($gorraList);
                            foreach ($gorraList as $gor) {
                              echo "$gor->col_nombre: $gor->colgor_pieza";
                              if ($moraThanOne > 1) {
                                echo "<strong> | </strong>";
                                $moraThanOne--;
                              }
                            }
                            echo "</td><td>";
                            $chaquetaList = @json_decode($db->getChaquetasDetalladoByStud($row->pkstu_id));
                            $moraThanOne = count($chaquetaList);
                            foreach ($chaquetaList as $cha) {
                              echo "$cha->col_nombre: $cha->colcha_pieza";
                              if ($moraThanOne > 1) {
                                echo "<strong> | </strong>";
                                $moraThanOne--;
                              }
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>gorra</th>
                        <th>chaqueta</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Descripción de propietarios</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault-2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>propietarios</th>
                        <th>porcentaje</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($studsList as $row) {
                            $propietarioList = @json_decode($db->getPropietariosDetalladoByStud($row->pkstu_id));
                            foreach ($propietarioList as $pro) {
                              echo "<tr>";
                              echo "<td>$row->pkstu_id</td>";
                              echo "<td>$row->stu_nombre</td>";
                              echo "<td>$pro->pro_primer_nombre $pro->pro_segundo_nombre $pro->pro_primer_apellido $pro->pro_segundo_apellido</td>";
                              echo "<td>$pro->stupro_porcentaje%</td>";
                              echo "</tr>";
                            }
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>propietarios</th>
                        <th>porcentaje</th>
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