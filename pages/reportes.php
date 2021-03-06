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
                  <p>Listado de usuarios con sus roles.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R1ListadoDeUsuarios" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#2</h3>
                  <p>Listado de studs con la descripción de su camisa y gorra.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R2ListadoDeStudsConLaDescripcion" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#3</h3>
                  <p>Listado de studs con sus propietarios y porcentajes.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R3ListadoDeStudsConSusPropietarios" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#4</h3>
                  <p>Listado de studs con sus ejemplares y propietarios.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R4ListadoDeStudsConSusEjemplares" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#5</h3>
                  <p>Listado de ejemplares, con sexo y tipo de pelaje; clasificados por edad.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R5ListadoDeEjemplaresConSexoTipoDePelaje" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#6</h3>
                  <p>Listado de ejemplares ganadores de clásicos.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R6ListadoDeEjemplaresGanadoresDeClasicos" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#7</h3>
                  <p>Listado de ejemplares ganadores de las últimas 15 carreras del programa, agrupadas por tipo de carrera.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R7ListadoDeEjemplaresGanadoresDeLasUltimas15" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#8</h3>
                  <p>Listado de implementos.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R8ListadoDeImplementos" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#9</h3>
                  <p>Listado de entrenadores indicando su cuadra.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R9ListadoDeEntrenadoresIndicandoSuCuadra" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#10</h3>
                  <p>Listado de jinetes.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R10ListadoDeJinetes" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#11</h3>
                  <p>Historial de jinete, con que ejemplar a ganado y cual carrera.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R11HistorialDeJineteConQueEjemplarGanadoCualCarrera" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#12</h3>
                  <p>Estadística de Jinete basado en la cantidad de carreras corridas.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R12EstadisticasJineteCarrerasCorridas" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#13</h3>
                  <p>Estadísticas de Ejemplar en la cantidad de carreras corridas.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R13EstadisticasEjemplarCarrerasCorridas" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#14</h3>
                  <p>Estadísticas de Ejemplar combinado Jinete y Entrenador.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R14EstadisticasEjemplarCombinadoJineteEntrenador" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#15</h3>
                  <p>Programa oficial de carrera.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R15ProgramaOficialDeCarrera" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#16</h3>
                  <p>Resultados de Carreras con las especificaciones indicadas.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R16ResultadosDeCarrerasCumpliendoConLasEspecificacionesIndicadas" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#17</h3>
                  <p>Construcción de la gaceta hípica indicando los favoritos en cada carrera según su historial, además de las estadísticas de combinación ejemplar-jinete-entrenador.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R17ProgramaOficialDeCarrera" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#18</h3>
                  <p>Restaurantes del hipódromo.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R18RestaurantesDelHipodromo" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->            
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#19</h3>
                  <p>Total de apuestas por taquilla.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R19TotalDeApuestasPorTaquilla" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#20</h3>
                  <p>Total de apuestas por taquilla por tipo de apuestas.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R20TotalDeApuestasPorTaquillaPorTipoDeApuestas" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            
            
            <!--
            REPORTES 21
            -->
            
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#22</h3>
                  <p>Total de ventas en entradas al recinto.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R22TotalDeVentasEnEntradasAlRecinto" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#23</h3>
                  <p>Promedio de uso de los implementos en las ultimas 25 carreras.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R23PromedioDeUsoDeLosImplementos25Carreras" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#24</h3>
                  <p>Indicar cuales son los implementos más utilizados en las carreras de mayor a menos según su porcentaje de uso.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R24ImplementosMasUtilizadosEnCarrerasDeMayorMenoSegunPorcentaje" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#25</h3>
                  <p>Indicar cuales son las carreras mas frecuentes según su tipo.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R25IndicarCualesSonLasCarrerasMasFrecuenteSegunSuTipo" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#26</h3>
                  <p>Indicar el peso promedio de los jinetes para las 25 últimas carreras.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R26IndicarElPesoPromedioDeLosJinetesParaLasUltimas25" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#27</h3>
                  <p>El promedio de los ejemplares que corrieron en las ultimas 50 carreras según su pelaje.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R27ElPromedioDeEjemplaresQueCorrieronEnLasUltimas50" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#28</h3>
                  <p>El promedio de los ejemplares que corrieron en las ultimas 50 carreras según su sexo.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R28ElPromedioDeEjemplaresQueCorrieronEnLasUltimas50SegunSuSexo" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#29</h3>
                  <p>Se quiere conocer cuales son los mejores ejemplares rematadores de todas las carreras según su desempeño en los ultimos 400 mts. de cada carrera.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R29SeQuiereConocerCualesSonLosMejoresEjemplaresRematadoresDeTodas" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>#30</h3>
                  <p>Se quiere conocer cuales son las mejores hembras y machos en base a la cantidad de hijos ganadores.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document-text"></i>
                </div>
                <a href="../reports/reports.php?report=R30MejoresHembrasMachosEnBaseCantidadDeHijosGanadores" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
      ?>
