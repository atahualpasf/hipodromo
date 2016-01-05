<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Entrenadores
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Entrenadores</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>ci</th>
                        <th>nombre</th>
                        <!-- <th>cuadra</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $entrenadoresList = @json_decode($db->getEntrenadores());
                        foreach ($entrenadoresList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkent_id</td>";
                            echo "<td>$row->ent_ci</td>";
                            echo "<td>$row->ent_primer_nombre $row->ent_segundo_nombre $row->ent_primer_apellido $row->ent_segundo_apellido</td>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>ci</th>
                        <th>nombre</th>
                        <!-- <th>cuadra</th> -->
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