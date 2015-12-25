<?php
  include('dbconnection.inc.php');
  function result_construct($action,$type,$data){
    $result = array("action"=>array("action"=>$action,"type"=>$type),"response"=>array("data"=>$data));
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $result;
  }
  
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
  function checkPasswords($password, $passwordv) {
    if (!preg_match("#^[a-zA-Z0-9]{6,13}$#", $password)) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_clave', 'La contraseña tiene que ser alfanumerica y de 6 a 13 caracteres de longitud.');
      die();
    } elseif (!preg_match("#^[a-zA-Z0-9]{6,13}$#", $passwordv)) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_clavev', 'La contraseña de verificación tiene que ser alfanumerica y de 6 a 13 caracteres de longitud.');
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
  
  function checkUserOnDatabase($usuario,$usu_nombre,$usu_clave,$db,$areMany) {
    if (($usuario->usu_nombre === $usu_nombre) || ($usuario->usu_correo === $usu_nombre)) {
      if ($usuario->usu_clave === $usu_clave) {
        // $recordarme = !empty($_POST['recordarme']) ? test_input($_POST['recordarme']) : NULL;
        // $recordarme = $recordarme === 'true' ? true : NULL;
        echo result_construct('success', 'login', $usuario->pkusu_id);
        setSessionVariables($usuario->pkusu_id,$db);
        die();
      }
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_clave', 'La contraseña no coincide, por favor verifique.');
      die();
    }
    if (!$areMany) {
      header('HTTP/1.1 409 Conflict');
      echo result_construct('error', 'usu_nombre', 'Lo sentimos pero no se encuentra en el sistema, por favor registrarse primero.');
      die();
    }
  }
  
  function setSessionVariables($id,$db) {
    session_regenerate_id(true);
    $usuario = @json_decode($db->getUsuarioById($id));
    $_SESSION['app_name'] = 'Hipódromo La Rinconada';
    $_SESSION['shortapp_name'] = 'HLR';
    $_SESSION['usuario']['pkusu_id'] = $usuario[0]->pkusu_id;
    $_SESSION['usuario']['usu_nombre'] = $usuario[0]->usu_nombre;
    $_SESSION['usuario']['usu_imagen'] = $usuario[0]->usu_imagen;
    $_SESSION['rol']['pkrol_id'] = $usuario[0]->pkrol_id;
    $_SESSION['rol']['rol_nombre'] = $usuario[0]->rol_nombre;
    $_SESSION['last_activity'] = time();
  }
  
  $registro = !empty($_POST['registro']) ? test_input($_POST['registro']) : NULL;
  $registro = $registro === 'true' ? true : NULL;
  $login = !empty($_POST['login']) ? test_input($_POST['login']) : NULL;
  $login = $login === 'true' ? true : NULL;
  $logout = !empty($_POST['logout']) ? test_input($_POST['logout']) : NULL;
  $logout = $logout === 'true' ? true : NULL;
  $usu_nombre = !empty($_POST['username']) ? test_input($_POST['username']) : NULL;
  $usu_correo = !empty($_POST['email']) ? test_input($_POST['email']) : NULL;
  $usu_clave = !empty($_POST['password']) ? test_input($_POST['password']) : NULL;
  $usu_clavev = !empty($_POST['passwordv']) ? test_input($_POST['passwordv']) : NULL;
  $usu_rol = !empty($_POST['rol']) ? test_input($_POST['rol']) : NULL;
  
  $db = new Database;
  if ($registro) {
    sleep(1.5);
    if ((!empty($usu_nombre)) and (!empty($usu_correo)) and (!empty($usu_clave)) and (!empty($usu_clavev)) and (!empty($usu_rol))) {
      checkPasswords($usu_clave,$usu_clavev);
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
        $answer = @json_decode($db->registerUsuario($usu_nombre,$usu_correo,$usu_clave,$usu_rol,$data));
        if ($answer->action === 'error') {
          checkErrorOnDatabase($answer);
        } else {
          echo result_construct($answer->action, '', $answer->response->data);
          setSessionVariables($answer->response->data,$db);
        }
        
        // Destroy resources
        imagedestroy($image);
        imagedestroy($new);
      } else {
        $answer = @json_decode($db->registerUsuario($usu_nombre,$usu_correo,$usu_clave,$usu_rol,NULL));
        if ($answer->action === 'error') {
          checkErrorOnDatabase($answer);
        } else {
          echo result_construct($answer->action, '', $answer->response->data);
          setSessionVariables($answer->response->data,$db);
        }
      }   
      die();
    } else {
      header('HTTP/1.1 400 Bad Request');
      echo result_construct("error", '', 'Lo sentimos pero la información suministrada es incorrecta o está incompleta.');
      die();
    }
  } elseif ($login) {
    sleep(1.5);
    if ((!empty($usu_nombre)) and (!empty($usu_clave))) {
      // $data = array('type' => 'success', 'message' => 'Todo perfecto con LOGEO');
      // echo json_encode($logout);
      $answer = @json_decode($db->loginUsuario());
      if ($answer->action !== "error" and !empty($answer->response->data)) {
        $usuarios = $answer->response->data;
        if (count($usuarios) > 1) {
          foreach ($usuarios as $usuario) {
            checkUserOnDatabase($usuario,$usu_nombre,$usu_clave,$db,true);
          }
          header('HTTP/1.1 409 Conflict');
          echo result_construct('error', 'usu_nombre', 'Lo sentimos pero no se encuentra en el sistema, por favor registrarse primero.');
          die();
        } else {
          $usuario = $answer->response->data[0];
          checkUserOnDatabase($usuario,$usu_nombre,$usu_clave,$db,false);
        }
      }
      header('HTTP/1.1 409 Conflict');
      if (!empty($answer->response->data)) {
        echo result_construct('error', 'login', $answer->response->data);
      } else {
        echo result_construct('error', 'empty', 'Lo sentimos pero no se encuentra en el sistema, por favor registrarse primero.');
      }
      die();
    }
    header('HTTP/1.1 400 Bad Request');
    echo result_construct("error", '', 'Lo sentimos pero la información suministrada es incorrecta o está incompleta.');
    die();
  } elseif($logout) {
    if ((!empty($_SESSION['usuario']['pkusu_id'])) and (!empty($_SESSION['usuario']['usu_nombre'])) and (!empty($_SESSION['rol']['pkrol_id'])) and (!empty($_SESSION['rol']['rol_nombre'])) and (!empty($_SESSION['app_name'])) and (!empty($_SESSION['shortapp_name']))) {
      $_SESSION['app_name'] = '';
      $_SESSION['shortapp_name'] = '';
      $_SESSION['usuario']['pkusu_id'] = '';
      $_SESSION['usuario']['usu_nombre'] = '';
      $_SESSION['usuario']['usu_imagen'] = '';
      $_SESSION['rol']['pkrol_id'] = '';
      $_SESSION['rol']['rol_nombre'] = '';
      $_SESSION['last_activity'] = '';
    	session_unset();
    	session_destroy();
    	echo result_construct("success", 'logout', 'La sesión se ha cerrado con éxito.');
      die();
    }
    header('HTTP/1.1 400 Bad Request');
    echo result_construct("error", 'logout', 'Disculpe pero no hay sesión abierta.');
    die();
  }
  header('HTTP/1.1 400 Bad Request');
  echo result_construct("error", '', 'No se pudo realizar la conexión. Por favor intente en unos minutos.');
  die();
?>