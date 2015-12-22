<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
?>
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
                  <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="img-circle" alt="User Image">
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
              <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="img-circle" alt="User Image">
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
            Studs
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Tablero</a></li>
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
                  <h3 class="box-title">Descripcion de Chaquetilla y Gorra</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Stud</th>
                        <th>Chaquetilla</th>
                        <th>Gorra</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Trident</td>
                        <td>Trident</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                      <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 4.0</td>
                        <td>Internet Explorer 4.0</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Stud</th>
                        <th>Chaquetilla</th>
                        <th>Gorra</th>
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