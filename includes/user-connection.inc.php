<?php
  function result_construct($action,$data){
    $result = array("action"=>$action,"response"=>array("data"=>$data));
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $result;
  }
  include('dbconnection.inc.php');
  sleep(2.5);
  print_r($_POST);
  print_r($_FILES);
  
  if (!empty($_POST['registro'])) {
    if ((!empty($_POST['username'])) and (!empty($_POST['email'])) and (!empty($_POST['password'])) and (!empty($_POST['rol']))) {
      $db = new Database;
      if ((!empty($_FILES['picture']['name'])) and (is_uploaded_file($_FILES['picture']['tmp_name']) || $_FILES['picture']['error'] === UPLOAD_ERR_OK)) {
        $uploadOk = true;
    		$imageFileType = pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
        $target_file = $_FILES['picture']['name'];
        
        // Check file size
    		if ($_FILES["picture"]["size"] > 6000000) {
          echo result_construct("error", 'Lo siento, el archivo recibido es demasiado grande.');
    			// $uploadOk = false;
          die();
    		}
        
        // Check if image file is a actual image or fake image
  			$check = getimagesize($_FILES['picture']['tmp_name']);
  			if($check === false) {
          echo result_construct("error", 'El archivo recibido no es una imagen - ' . $check["mime"] . '.');
  				// $uploadOk = false;
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
              echo result_construct("error", 'Subiste un archivo con un formato ' . $imageFileType . ' que no está soportado por la aplicación.');
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
              echo result_construct("error", 'Error creando la imagen formato ' . $imageFileType . ' modificada.');
              die();
        }
        $final_image = ob_get_contents();
        ob_end_clean();
        
        // Escape the binary data
        $data = pg_escape_bytea($final_image);
        $answer = json_decode($db->registerUser($_POST['username'],$_POST['email'],$_POST['password'],$_POST['rol'],$data));
        echo json_encode($answer);
        
        // Destroy resources
        imagedestroy($image);
        imagedestroy($new);
      } else {
        $answer = @json_decode($db->registerUser($_POST['username'], $_POST['email'],$_POST['password'],$_POST['rol']),NULL);
        echo json_encode($answer);
      }   
      die();
    } else {
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