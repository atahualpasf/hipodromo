<?php
  require_once('dbconnection.inc.php');
  $db = new Database;
  if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'hipodromo') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) === 'index')) {
    if ((!empty($_SESSION['usuario']['pkusu_id'])) and (!empty($_SESSION['usuario']['usu_nombre'])) and (!empty($_SESSION['rol']['pkrol_id'])) and (!empty($_SESSION['rol']['rol_nombre'])) and (!empty($_SESSION['app_name'])) and (!empty($_SESSION['shortapp_name'])) and (!empty($_SESSION['last_activity']))) {
      if (time() - $_SESSION['last_activity'] <= 1800) {
        $_SESSION['last_activity'] = time();
        header('Location:http://'. $_SERVER[HTTP_HOST] . '/hipodromo/pages/');
      } else {
        session_unset();
        session_destroy();
      }
    }
  } else {
    if (((empty($_SESSION['usuario']['pkusu_id'])) and (empty($_SESSION['usuario']['usu_nombre'])) and (empty($_SESSION['rol']['pkrol_id'])) and (empty($_SESSION['rol']['rol_nombre'])) and (empty($_SESSION['app_name'])) and (empty($_SESSION['shortapp_name'])) and (empty($_SESSION['last_activity']))) || (time() - $_SESSION['last_activity'] > 1800)) {
      header('Location:http://' . $_SERVER[HTTP_HOST] . '/hipodromo/');
    } else {
      $_SESSION['last_activity'] = time();
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo !empty($_SESSION['app_name']) ? $_SESSION['app_name'] : 'Hipódromo La Rinconada'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php if (strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages'): ?>
    <!-- Peace -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/pace/pace-loading.css'; ?>">
    <script data-pace-options='{ "ajax": false }' src="<?php echo $db->getRootUri() . 'plugins/pace/pace.js'; ?>"></script>
    <?php endif; ?>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'bootstrap/css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/font-awesome-4.5.0/css/font-awesome.min.css'; ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/ionicons-2.0.1/css/ionicons.min.css'; ?>">
    <?php if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) !== 'index')): ?>
      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/datatables/dataTables.bootstrap.css'; ?>">
    <?php endif; ?>
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/AdminLTE.min.css'; ?>">

    <?php if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'hipodromo') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) === 'index')): ?>
      <!-- Full responsive background video with css -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/videobackground/videobackground.css'; ?>">
      <!-- Index style -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/index.css'; ?>">
      <!-- iCheck -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/iCheck/square/blue.css'; ?>">
    <?php elseif ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) !== 'index')): ?>
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/skins/_all-skins.min.css'; ?>">
      <!-- Table Perzonalizado -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/table.css'; ?>">
    <?php else: ?>
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/skins/_all-skins.min.css'; ?>">
      <!-- iCheck -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/iCheck/flat/blue.css'; ?>">
      <!-- Morris chart -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/morris/morris.css'; ?>">
      <!-- jvectormap -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/jvectormap/jquery-jvectormap-1.2.2.css'; ?>">
      <!-- Date Picker -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/datepicker/datepicker3.css'; ?>">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/daterangepicker/daterangepicker-bs3.css'; ?>">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'; ?>">
    <?php endif; ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php if (strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages'): ?>
    <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">

        <header class="main-header">
          <!-- Logo -->
          <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?php echo $_SESSION['shortapp_name'][0]; ?><b><?php echo substr($_SESSION['shortapp_name'],1,2); ?></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?php echo substr($_SESSION['app_name'],11,2); ?> <b><?php echo substr($_SESSION['app_name'],14,9); ?></b></span>
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
                    <?php if (empty($_SESSION['usuario']['usu_imagen'])): ?>
                      <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="user-image" alt="User Image">
                    <?php else: ?>
                      <img src="data:image;base64,<?php echo $_SESSION['usuario']['usu_imagen']; ?>" class="user-image" alt="User Image">
                    <?php endif;  ?>
                    <span class="hidden-xs"><?php echo $_SESSION['usuario']['usu_nombre']; ?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <?php if (empty($_SESSION['usuario']['usu_imagen'])): ?>
                        <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="img-circle" alt="User Image">
                      <?php else: ?>
                        <img src="data:image;base64,<?php echo $_SESSION['usuario']['usu_imagen']; ?>" class="img-circle" alt="User Image">
                      <?php endif;  ?>
                      <p>
                        <?php echo $_SESSION['usuario']['usu_nombre']; ?>
                        <small><?php echo $_SESSION['rol']['rol_nombre']?></small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-right">
                        <button id="btn-cerrarsesion" value="true" class="btn btn-default btn-flat">Cerrar Sesión</button>
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
                <?php if (empty($_SESSION['usuario']['usu_imagen'])): ?>
                  <img src="<?php echo $db->getRootUri() . 'dist/img/user2-160x160.jpg'; ?>" class="img-circle" alt="User Image">
                <?php else: ?>
                  <img src="data:image;base64,<?php echo $_SESSION['usuario']['usu_imagen']; ?>" class="img-circle" alt="User Image">
                <?php endif; ?>
              </div>
              <div class="pull-left info">
                <p><?php echo $_SESSION['usuario']['usu_nombre']; ?></p>
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
                <a href="index.php">
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
    <?php endif; ?>