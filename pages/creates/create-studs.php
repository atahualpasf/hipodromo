<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/header.inc.php');
  
  $pkstu_id = $fkstu_lug_id = $stu_nombre = $stu_fecha_creacion = "";
  
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
  function setValuesWhenSubmitIsClicked() {
      $GLOBALS['pkstu_id'] = test_input($_POST['pkstu_id']);
      $GLOBALS['fkstu_lug_id'] = test_input($_POST['fkstu_lug_id']);
      $GLOBALS['stu_nombre'] = test_input($_POST['stu_nombre']);
      $GLOBALS['stu_fecha_creacion'] = test_input($_POST['stu_fecha_creacion']);
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
       setValuesWhenSubmitIsClicked();
       $answer = @json_decode($db->addStud($pkstu_id, $fkstu_lug_id, $stu_nombre, $stu_fecha_creacion));
       if ($answer->action != "error") {
         echo '<meta http-equiv="refresh" content="0;url=../studs.php">';
         die();
       }
  }
?>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-success">
          <!-- form start -->
          <form id="create-stud" role="form" method="post" action="#">
             <mainstep>
                 <h3>stud</h3>
                 <fieldstep>
                    <div class="row">
                       <div class="col-md-6">
                           <label>Dirección</label>
                           <input name="fkstu_lug_id" placeholder="Dirección del stud" type="text" class="required" required>
                       </div>
                       <div class="col-md-3">
                           <label>Nombre</label>
                           <input name="stu_nombre" placeholder="Nombre de stud" type="text" class="required" required>
                       </div>
                       <div class="col-md-3">
                           <div class="form-group">
                            <label>Fecha de creación:</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="stu_fecha_creacion" placeholder="2000-01-01" id="stud-date" type="text" class="form-control pull-right date" value="2000-01-01" readonly>
                            </div><!-- /.input group -->
                           </div><!-- /.form group -->
                       </div>
                    </div>
                 </fieldstep>
                 <h3>uniforme</h3>
                 <fieldstep>
                    <div class="row">
                       <div class="col-md-6">
                           <label for="userName">User name *</label>
                           <input id="userName" name="userName" type="text" class="required">
                       </div>
                       <div class="col-md-3">
                           <label for="password">Password *</label>
                           <input id="password" name="password" type="text" class="required">
                       </div>
                       <div class="col-md-3">
                           <label for="confirm">Confirm Password *</label>
                           <input id="confirm" name="confirm" type="text" class="required">
                       </div>
                       <div class="col-md-6">
                           <label for="userName">User name *</label>
                           <input id="userName" name="userName" type="text" class="required">
                       </div>
                       <div class="col-md-3">
                           <label for="password">Password *</label>
                           <input id="password" name="password" type="text" class="required">
                       </div>
                       <div class="col-md-3">
                           <label for="confirm">Confirm Password *</label>
                           <input id="confirm" name="confirm" type="text" class="required">
                       </div>
                    </div>
                 </fieldstep>
                 <h3>propietarios</h3>
                 <fieldstep>
                     <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                 </fieldstep>
             </mainstep>
         </form>
       </div><!-- /.box -->

     </div><!--/.col (left) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
?>