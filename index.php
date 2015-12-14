<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- Full responsive background video with css -->
    <link rel="stylesheet" href="plugins/videobackground/videobackground.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
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
          <div class="register-box-body">
            <p class="login-box-msg">Registrar un nuevo miembro</p>
            <form action="../../index.html" method="post">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Correo">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Retype password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback" placeholder="Rol">
                <select class="form-control">
                  <option>Rol 1</option>
                  <option>Rol 2</option>
                  <option>Rol 3</option>
                  <option>Rol 4</option>
                  <option>Rol 5</option>
                </select>
                <span class="glyphicons flaticon-business form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-7">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox"> Acepto los <a href="#">terminos</a>.
                    </label>
                  </div>
                </div><!-- /.col -->
                <div class="col-xs-5">
                  <button type="submit" class="btn bg-blue btn-block btn-flat">Registrar</button>
                </div><!-- /.col -->
              </div>
            </form>

            <div class="social-auth-links text-center">
              <p>-</p>
              <!-- <a href="#" class="btn btn-block btn-social bg-navy btn-flat"><i class="fa fa-facebook"></i> Iniciar sesión</a> -->
              <button id="btn-rg-iniciarsesion" class="btn bg-green btn-block btn-flat">Iniciar sesión</button>
              <button id="btn-rg-regresar" class="btn bg-green btn-block btn-flat">Regresar</button>
            </div>
          </div><!-- /.form-box -->
        </div><!-- /.register-box -->
      </div>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Background video -->
    <script src="plugins/videobackground/videobackground.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#bg-video').videoBackground('videos/racehorseslowmotion-hd.mp4');
        
        var box_registrar = $('#box-registrar');
        var box_title = $('#box-title');
        $('#box-registrar').remove();
        $(document).on('click', '#btn-registrar', function(event) {
          event.preventDefault();
          $('#box-title').remove();
          box_registrar.insertAfter('#bg-video');
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });
          $('#box-registrar').css('display','flex').hide().fadeIn(500);
        });
        
        $(document).on('click', '#btn-rg-regresar', function(event) {
          event.preventDefault();
          $('#box-registrar').remove();
          box_title.insertAfter('#bg-video');
          $('#box-title').hide().fadeIn(500);
        });
      });
    </script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
  </body>
</html>
