<?php
    require_once('dbconnection.inc.php');
    $db = new Database;
	  echo json_decode($db->getBoxByCaballeriza());
?>