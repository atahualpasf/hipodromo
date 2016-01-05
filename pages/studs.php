<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Studs
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Studs</li>
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
                        <th>creación</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $studsList = @json_decode($db->getStuds());
                        foreach ($studsList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkstu_id</td>";
                            echo "<td>$row->stu_nombre</td>";
                            echo "<td>$row->stu_fecha_creacion</td>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>creación</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Descripcion de uniforme</h3>
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
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
      ?>