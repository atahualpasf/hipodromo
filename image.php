<?php
  require_once('includes/dbconnection.inc.php');
  $db = new Database;
  
  $usuarioData = json_decode($db->getUserById(19));
  // echo $usuarioData[0]->usu_nombre;
  $image = $usuarioData[0]->usu_imagen;
  // header("Content-type: image/jpeg", true, 200); 
  // print_r (pg_unescape_bytea($image));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <img src="data:image;base64,<?php echo $image ?>" alt="">
  <p><?php echo $usuarioData[0]->usu_nombre; ?></p>
</body>
</html>