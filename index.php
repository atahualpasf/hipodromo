<?php
  include('header.php');
?>
  <body class="hold-transition register-page">
    <div id="overlay">
    </div>
    <div id="bg-video"></div>
    
    <div id="box-title" class="jumbotron vertical-center">
      <div class="container text-center">
        <i class="flaticon-horse"></i>
        <h1>Hipódromo La Rinconada</h1>
        <i class="flaticon-horse flip"></i>
        <div class="row">
          <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <button id="btn-iniciarsesion" class="btn bg-green btn-block btn-flat margin">Iniciar sesión</button>
          </div>
          <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <button id="btn-registrar" class="btn bg-green btn-block btn-flat margin">Registrar</button>
          </div>
        </div>
      </div>
      
    </div>
    
      <div id="box-registrar" class="container vertical-center">
        <div class="register-box">
          <div class="overlay">
            <i class="fa fa-circle-o-notch fa-spin"></i>
          </div>
          <div class="register-box-body">
            <p class="login-box-msg">Registrar un nuevo miembro</p>
            <form method="post">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Nombre de usuario" oninvalid="checkInputs(this,'Nombre de usuario inválido.');" oninput="checkInputs(this,'Nombre de usuario inválido.');" title="Nombre de usuario sin caracteres especiales y de 3 a 12 de longitud. e.g example123" pattern="^[a-zA-Z0-9]{3,12}$" name="username" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Correo electrónico" oninvalid="checkInputs(this,'Correo electrónico inválido.');" oninput="checkInputs(this,'Correo electrónico inválido.');" title="Por favor introduce un correo válido. e.g example@hostexample.com" name="email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" oninvalid="checkInputs(this,'Contraseña inválida.');" oninput="checkInputs(this,'Contraseña inválida.');" title="Contraseña de 6 a 13 caracteres de longitud." pattern="^[a-zA-Z0-9]{6,13}$" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Verificar contraseña" oninvalid="checkInputs(this,'Contraseña incorrecta.');" oninput="checkInputs(this,'Contraseña incorrecta.');" title="Contraseña de 6 a 13 caracteres de longitud." pattern="^[a-zA-Z0-9]{6,13}$" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              </div>
              <input type="hidden" name="registro" value="true">
              <div class="form-group has-feedback" placeholder="Rol">
                <?php
                  $answer = @json_decode($db->getRolesUsuario());
                	if ($answer->action != "error") {
                		echo "<select name='rol' class='form-control'>";
              	    foreach ($answer->response->data as $row) {
              	        echo "<option value='$row->pkrol_id'>$row->rol_nombre</option>";
              	    }
              	    echo "</select>";
                	}
                ?>
                <span class="glyphicons flaticon-business form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-7">
                  <div class="image">
                    <img src="dist/img/avatar5.png" width="60px" height="60px" class="img-circle" alt="User Image">
                  </div>
                </div><!-- /.col -->
                <div class="col-xs-5">
                  <button for="files" type="button" class="btn btn-twitter btn-block btn-flat center-button">ELEGIR FOTO</button>
                  <!-- <label for="files"> <span class="btn btn-default btn-block btn-flat center-button">ELEGIR FOTO</span></label>  -->
                  <input type="file" class="form-control" name="picture" accept="image/*">
                </div><!-- /.col -->
              </div>
              <div class="row">
                <div class="col-xs-7 center-button-s">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" oninvalid="setCustomValidity('Por favor chequea si aceptas los términos.');" required> Acepto los <a href="#">terminos</a>.
                    </label>
                  </div>
                </div><!-- /.col -->
                <div class="col-xs-5">
                  <button type="submit" class="btn bg-blue btn-block btn-flat center-button">Registrar</button>
                </div><!-- /.col -->
              </div>
            </form>

            <div class="social-auth-links text-center">
              <p>-</p>
              <button id="btn-rg-iniciarsesion" class="btn bg-green btn-block btn-flat">Iniciar sesión</button>
              <button id="btn-rg-regresar" class="btn bg-green btn-block btn-flat">Regresar</button>
            </div>
          </div><!-- /.form-box -->
        </div><!-- /.register-box -->
      </div>
      
      <div id="box-iniciarsesion" class="container vertical-center">
        <div class="login-box">
          <div class="overlay">
            <i class="fa fa-circle-o-notch fa-spin"></i>
          </div>
          <div class="login-box-body">
            <p class="login-box-msg">Iniciar sesión con tu usuario o correo</p>
            <form action="../../index2.html" method="post">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Nombre de usuario o correo electrónico" name="username" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" name="password" value="" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <input type="hidden" name="logeo" value="true">
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox"> Recordarme.
                    </label>
                  </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" class="btn bg-blue btn-block btn-flat">Iniciar</button>
                </div><!-- /.col -->
              </div>
            </form>
    
            <div class="social-auth-links text-center">
              <p>-</p>
              <button id="btn-is-registrar" class="btn bg-green btn-block btn-flat">Registrar</button>
              <button id="btn-is-regresar" class="btn bg-green btn-block btn-flat">Regresar</button>
            </div><!-- /.social-auth-links -->
    
          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
      </div>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Background video -->
    <script src="plugins/videobackground/videobackground.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- Constantes globales -->
    <script>
      // var _INCL_ROOT = '<?php /*echo $db->getIncludesPath();*/ ?>';
      var _INCL_ROOT = window.location.origin + '/hipodromo/includes/';
    </script>
    <!-- Index script -->
    <script src="js/index.js"></script>
  </body>
</html>
