<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
 exec('ejecutarReportes ' . $_GET['report']);
  
 header("Content-type: application/pdf");
 header("Content-Disposition: inline; filename=" . $_GET['report'] . '.pdf');
 @readfile('pdf\\' . $_GET['report'] . '.pdf');
?>