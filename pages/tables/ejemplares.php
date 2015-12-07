<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HLR | Ejemplares</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">H<b>LR</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">La <b>Rinconada</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce
                      <small>Miembro desde Nov. 2012</small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Navegación Principal</li>
            <li class="active treeview">
              <a href="../../index.php">
                <i class="fa fa-dashboard"></i> <span>Tablero</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Tablas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="apuestas.php"><i class="fa fa-circle-o"></i> Apuestas</a></li>
                <li><a href="ejemplares.php"><i class="fa fa-circle-o"></i> Ejemplares</a></li>
                <li><a href="entrenadores.php"><i class="fa fa-circle-o"></i> Entrenadores</a></li>
                <li><a href="implementos.php"><i class="fa fa-circle-o"></i> Implementos</a></li>
                <li><a href="jinetes.php"><i class="fa fa-circle-o"></i> Jinetes</a></li>
                <li><a href="studs.php"><i class="fa fa-circle-o"></i> Studs</a></li>
                <li><a href="usuarios.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
              </ul>
            </li>
            </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Ejemplares
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Tablero</a></li>
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
                  <h3 class="box-title">Ejemplares clasificados por edad</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Ejemplar</th>
                        <th>Sexo</th>
                        <th>Pelaje</th>
                        <th>Edad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Ejemplar</th>
                        <th>Sexo</th>
                        <th>Pelaje</th>
                        <th>Edad</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2014-2015 Hipodromo La Rinconada.</strong> Todos los derechos reservados.
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
</html>
