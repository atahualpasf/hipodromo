      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (!empty($_POST['pkins_id'])) {
              $answer = json_decode($db->deleteInscripcion($_POST['pkins_id']));
          }
        }
        
        $inscripcionesList = @json_decode($db->getInscripciones());
      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Inscripciones
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Tablero</a></li>
            <li><a href="#">Tablas</a></li>
            <li class="active">Inscripción</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo count($inscripcionesList); ?></h3>
                  <p>Inscripciones Registradas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <?php echo "<a href='creates/create-" . $basefile . ".php' class='small-box-footer'>"; ?>
                  Agregar inscripción <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Inscripciones</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tableDefault" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>fecha</th>
                        <th>lote</th>
                        <th>distancia</th>
                        <th>jinete</th>
                        <th>ejemplar(g)</th>
                        <th>PP</th>
                        <th>Fav</th>
                        <th width="10%">editar</th>
                        <th width="10%">eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach ($inscripcionesList as $row) {
                            echo "<tr>";
                            echo "<td>$row->pkins_id</td>";
                            echo "<td>$row->car_fecha-$row->hor_inicio</td>";
                            echo "<td>$row->lote</td>";
                            echo "<td>$row->dis_metros</td>";
                            echo "<td>$row->jinete</td>";
                            echo "<td>$row->eje_nombre($row->ins_gualdrapa)</td>";
                            echo "<td>$row->ins_puesto_partida</td>";
                            echo "<td>$row->ins_favorito</td>";
                            echo "<form id='updateForm' role='form' method='POST' action='updates/update-" . basename($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='update_id' value='$row->pkins_id' type='submit' form='updateForm' class='btn btn-dropbox btn-flat btn-block'><i class='fa fa-edit'></i></button></td>";
                            echo "</form>";
                            echo "<form id='deleteForm' role='form' method='POST' action='" . htmlentities($_SERVER['PHP_SELF']) . "'>";
                            echo "<td><button name='pkins_id' value='$row->pkins_id' type='submit' form='deleteForm' class='btn btn-danger btn-flat btn-block'><i class='fa fa-trash'></i></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>id</th>
                        <th>fecha carrera</th>
                        <th>hora</th>
                        <th>lote</th>
                        <th>carrera</th>
                        <th>distancia</th>
                        <th>jinete</th>
                        <th>ejemplar</th>
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