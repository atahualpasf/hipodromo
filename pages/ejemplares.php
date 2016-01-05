<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Ejemplares
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Ejemplares</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ejemplares</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>Ejemplar</th>
                        <th>Sexo</th>
                        <th>edad</th>
                        <th>afinidad</th>
                        <th>raza</th>
                        <th>Pelaje</th>
                        <th>hara</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $ejemplaresList = @json_decode($db->getEjemplares());
                        foreach ($ejemplaresList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkeje_id</td>";
                            echo "<td>$row->eje_nombre</td>";
                            echo "<td>$row->eje_sexo</td>";
                            echo "<td>$row->edad</td>";
                            echo "<td>$row->afinidad</td>";
                            echo "<td>$row->raz_nombre</td>";
                            echo "<td>$row->pel_nombre</td>";
                            echo "<td>$row->har_nombre</td>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>Ejemplar</th>
                        <th>Sexo</th>
                        <th>edad</th>
                        <th>afinidad</th>
                        <th>raza</th>
                        <th>Pelaje</th>
                        <th>hara</th>
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