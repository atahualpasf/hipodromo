<?php
  require_once('dbconnection.inc.php');
  $db = new Database;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hipodromo La Rinconada</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'bootstrap/css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $db->getRootUri() . '/dist/css/AdminLTE.min.css'; ?>">

    <?php if (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) === 'index'): ?>
      <!-- Full responsive background video with css -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/videobackground/videobackground.css'; ?>">
      <!-- Index style -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'css/index.css'; ?>">
      <!-- iCheck -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'plugins/iCheck/square/blue.css'; ?>">
    <?php elseif ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) !== 'index')): ?>
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="<?php echo $db->getRootUri() . 'dist/css/skins/_all-skins.min.css'; ?>">
    <?php endif; ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>