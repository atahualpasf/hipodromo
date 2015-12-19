<?php
  function result_construct($action,$data){
    $result = array("action"=>$action,"response"=>array("data"=>$data));
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $result;
  }
  
  sleep(2.5);
  print_r($_POST);
  print_r($_FILES);
  
  if (!empty($_POST['registro'])) {
    if ((!empty($_POST['username'])) and (!empty($_POST['email'])) and (!empty($_POST['password'])) and (!empty($_POST['rol']))) {
      require_once('dbconnection.inc.php');
      $db = new Database;
      $answer = @json_decode($db->registerUser($_POST['username'], $_POST['email'],$_POST['password'],$_POST['rol']));
      echo json_encode($answer);
      die();
    }
    echo result_construct("error", 'No se pudo realizar la operación. Por favor intente en unos minutos.');
    die();
  } elseif (!empty($_POST['logeo'])) {
    $data = array('type' => 'success', 'message' => 'Todo perfecto con LOGEO');
    echo json_encode($data);
  } else {
    header('HTTP/1.1 400 Bad Request');
    echo result_construct("error", 'No se pudo realizar la conexión. Por favor intente en unos minutos.');
    die();
  }
?>