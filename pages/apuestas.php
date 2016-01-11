<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST['fkapu_fac_id'])) {
          $answer = json_decode($db->deleteApuestaByFactura($_POST['fkapu_fac_id']));
      }
  }
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
                        <th>corredor</th>
                        <th>jugada</th>
                        <th>factura</th>
                        <th>taquilla</th>
                        <th>monto</th>
                        <th>lugar de llegada</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $apuestasList = @json_decode($db->getApuestas());
                        foreach ($apuestasList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkapu_id</td>";
                            echo "<td>$row->eje_nombre</td>";
                            echo "<td>$row->jug_nombre</td>";
                            echo "<td>$row->fkapu_fac_id</td>";
                            echo "<td>$row->taq_nombre</td>";
                            echo "<td>$row->apu_monto</td>";
                            echo "<td>$row->apu_lugar_llegada</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->fkapu_fac_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='fkapu_fac_id' value='$row->fkapu_fac_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>corredor</th>
                        <th>jugada</th>
                        <th>factura</th>
                        <th>taquilla</th>
                        <th>monto</th>
                        <th>lugar de llegada</th>
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