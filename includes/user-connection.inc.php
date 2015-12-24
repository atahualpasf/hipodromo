<?php
  include('dbconnection.inc.php');
  function result_construct($action,$type,$data){
    $result = array("action"=>array("action"=>$action,"type"=>$type),"response"=>array("data"=>$data));
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $result;
  }
  sleep(2.5);
  
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
  function checkPasswords($password, $passwordv) {
    if (!preg_match("#^[a-zA-Z0-9]{6,13}$#", $password)) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_password', 'La contraseña tiene que ser alfanumerica y de 6 a 13 caracteres de longitud.');
      die();
    } elseif (!preg_match("#^[a-zA-Z0-9]{6,13}$#", $passwordv)) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_passwordv', 'La contraseña de verificación tiene que ser alfanumerica y de 6 a 13 caracteres de longitud.');
      die();
    } elseif ($password !== $passwordv) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'both_password', 'La contraseña dada y la contraseña de verificación no coinciden por favor verifique.');
      die();
    }
  }
  
  function checkErrorOnDatabase($answer) {
    if (strpos($answer->response->data,'(usu_nombre)') !== false) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct($answer->action, 'usu_nombre', 'El nombre de usuario ya se encuentra registrado, por favor verifique.');
      die();
    } elseif (strpos($answer->response->data,'(usu_correo)') !== false) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct($answer->action, 'usu_correo', 'El correo electrónico ya se encuentra registrado, por favor verifique.');
      die();
    }
    header('HTTP/1.1 409 Conflict');
    echo result_construct($answer->action, 'undefined', 'El correo electrónico ya se encuentra registrado, por favor verifique.');
    die();
  }
  
  function setSessionVariables($usu_nombre,$usu_rol,$db) {
    session_regenerate_id(true);
    $_SESSION['app_name'] = 'Hipódromo La Rinconada';
    $_SESSION['shortapp_name'] = 'HLR';
    $_SESSION['usu_nombre'] = $usu_nombre;
    $_SESSION['usu_rol'] = $usu_rol;
    $usu_imagen = json_decode($db->getUserById($usu_nombre))[0]->usu_imagen;
    $_SESSION['usu_imagen'] = $usu_imagen;
  }
  
  $registro = !empty($_POST['registro']) ? test_input($_POST['registro']) : NULL;
  $registro = $registro === 'true' ? true : NULL;
  $login = !empty($_POST['login']) ? test_input($_POST['login']) : NULL;
  $login = $login === 'true' ? true : NULL;
  $logout = !empty($_POST['logout']) ? test_input($_POST['logout']) : NULL;
  $logout = $logout === 'true' ? true : NULL;
  $usu_nombre = !empty($_POST['username']) ? test_input($_POST['username']) : NULL;
  $usu_correo = !empty($_POST['email']) ? test_input($_POST['email']) : NULL;
  $usu_password = !empty($_POST['password']) ? test_input($_POST['password']) : NULL;
  $usu_passwordv = !empty($_POST['passwordv']) ? test_input($_POST['passwordv']) : NULL;
  $usu_rol = !empty($_POST['rol']) ? test_input($_POST['rol']) : NULL;
  
  $db = new Database;
  if ($registro) {
    if ((!empty($usu_nombre)) and (!empty($usu_correo)) and (!empty($usu_password)) and (!empty($usu_passwordv)) and (!empty($usu_rol))) {
      checkPasswords($usu_password,$usu_passwordv);
      if ((!empty(test_input($_FILES['picture']['name']))) and (is_uploaded_file($_FILES['picture']['tmp_name']) || $_FILES['picture']['error'] === UPLOAD_ERR_OK)) {
    		$imageFileType = pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
        $target_file = $_FILES['picture']['name'];
        
        // Check file size
    		if ($_FILES["picture"]["size"] > 6000000) {
          header('HTTP/1.1 409 Conflict');
          echo result_construct('error', 'imagen', 'Lo siento, el archivo recibido es demasiado grande.');
          die();
    		}
        
        // Check if image file is a actual image or fake image
  			$check = getimagesize($_FILES['picture']['tmp_name']);
  			if($check === false) {
          header('HTTP/1.1 409 Conflict');
          echo result_construct('error', 'imagen', 'El archivo recibido no es una imagen - ' . $check["mime"] . '.');
          die();
  			}
        
        // Create image from file
        switch(strtolower($_FILES['picture']['type'])) {
            case 'image/jpg':
            case 'image/jpeg':
              $image = imagecreatefromjpeg($_FILES['picture']['tmp_name']);
              break;
            case 'image/png':
              $image = imagecreatefrompng($_FILES['picture']['tmp_name']);
              break;
            case 'image/gif':
              $image = imagecreatefromgif($_FILES['picture']['tmp_name']);
              break;
            default:
              header('HTTP/1.1 415 Unsupported Media Type');
              echo result_construct("error", 'imagen', 'Subiste un archivo con un formato ' . $imageFileType . ' que no está soportado por la aplicación.');
              die();
        }
        
        // Target dimensions
        $max_width = 215;
        $max_height = 215;

        // Get current dimensions
        $current_width  = imagesx($image);
        $current_height = imagesy($image);

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale = min($max_width/$current_width, $max_height/$current_height);

        // Get the new dimensions
        $new_width  = ceil($scale*$current_width);
        $new_height = ceil($scale*$current_height);
        
        // Create new empty image
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $current_width, $current_height);
        
        // Catch the imagedata
        ob_start();
        switch(strtolower($_FILES['picture']['type'])) {
            case 'image/jpg':
            case 'image/jpeg':
              imagejpeg($new);
              break;
            case 'image/png':
              imagepng($new, NULL, (100*0.09));
              break;
            case 'image/gif':
              imagegif($new, NULL, 0);
              break;
            default:
              imagedestroy($image);
              imagedestroy($new);
              header('HTTP/1.1 409 Conflict');
              echo result_construct('error', 'imagen', 'Error creando la imagen formato ' . $imageFileType . ' modificada.');
              die();
        }
        $final_image = ob_get_contents();
        ob_end_clean();
        
        // Escape the binary data
        $data = pg_escape_bytea($final_image);
        $answer = @json_decode($db->registerUser($usu_nombre,$usu_correo,$usu_password,$usu_rol,$data));
        if ($answer->action === 'error') {
          checkErrorOnDatabase($answer);
        } else {
          echo result_construct($answer->action, '', $answer->response->data);
          setSessionVariables($usu_nombre,$usu_rol,$db);
        }
        
        // Destroy resources
        imagedestroy($image);
        imagedestroy($new);
      } else {
        $answer = @json_decode($db->registerUser($usu_nombre,$usu_correo,$usu_password,$usu_rol,NULL));
        if ($answer->action === 'error') {
          checkErrorOnDatabase($answer);
        } else {
          echo result_construct($answer->action, '', $answer->response->data);
          setSessionVariables($usu_nombre,$usu_rol,$db);
        }
      }   
      die();
    } else {
      header('HTTP/1.1 400 Bad Request');
      echo result_construct("error", '', 'Lo sentimos pero la información suministrada es incorrecta o está incompleta.');
      die();
    }
  } elseif ($login) {
    $data = array('type' => 'success', 'message' => 'Todo perfecto con LOGEO');
    echo json_encode($logout);
  } elseif($logout) {
    if ((!empty($_SESSION['usu_nombre'])) and (!empty($_SESSION['usu_rol'])) and (!empty($_SESSION['app_name'])) and (!empty($_SESSION['shortapp_name']))) {
      $_SESSION['app_name'] = '';
      $_SESSION['shortapp_name'] = '';
      $_SESSION['usu_nombre'] = '';
      $_SESSION['usu_rol'] = '';
      $_SESSION['image'] = '';
    	session_unset();
    	session_destroy();
    	echo result_construct("success", 'logout', 'La sesión se ha cerrado con éxito.');
      die();
    }
    header('HTTP/1.1 400 Bad Request');
    echo result_construct("error", 'logout', 'Disculpe pero no hay sesión abierta.');
    die();
  } else {
    header('HTTP/1.1 400 Bad Request');
    echo result_construct("error", '', 'No se pudo realizar la conexión. Por favor intente en unos minutos.');
    die();
  }
?>