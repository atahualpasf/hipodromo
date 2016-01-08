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
        <div class="box box-info">
          <!-- form start -->
          <form id="create-stud" action="#">
             <div>
                 <h3>Account</h3>
                 <section>
                     <label for="userName">User name *</label>
                     <input id="userName" name="userName" type="text" class="required">
                     <label for="password">Password *</label>
                     <input id="password" name="password" type="text" class="required">
                     <label for="confirm">Confirm Password *</label>
                     <input id="confirm" name="confirm" type="text" class="required">
                     <p>(*) Mandatory</p>
                 </section>
                 <h3>Profile</h3>
                 <section>
                     <label for="name">First name *</label>
                     <input id="name" name="name" type="text" class="required">
                     <label for="surname">Last name *</label>
                     <input id="surname" name="surname" type="text" class="required">
                     <label for="email">Email *</label>
                     <input id="email" name="email" type="text" class="required email">
                     <label for="address">Address</label>
                     <input id="address" name="address" type="text">
                     <p>(*) Mandatory</p>
                 </section>
                 <h3>Hints</h3>
                 <section>
                     <ul>
                         <li>Foo</li>
                         <li>Bar</li>
                         <li>Foobar</li>
                     </ul>
                 </section>
                 <h3>Finish</h3>
                 <section>
                     <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                 </section>
             </div>
         </form>
       </div><!-- /.box -->

     </div><!--/.col (left) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
  include($_SERVER['DOCUMENT_ROOT'] . 'hipodromo/includes/footer.inc.php');
?>