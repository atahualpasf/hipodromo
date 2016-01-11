function cerrarSesion(btn) {
  var data = 'logout='+$(btn).val();
  $.ajax({
      url: _INCL_ROOT + 'user-connection.inc.php',
      type: 'POST',
      data: data,
      success: function (data) {
        var dataResponse = JSON.parse(data);
        console.log(dataResponse.response.data);
        if (dataResponse.action.action === 'success') {
          window.location.replace(_ROOT);
        }
      },
      error: function(data) {
        console.log(data);
        var dataResponse = JSON.parse(data.responseText);
        console.log(dataResponse);
      },
      cache: false,
  });
}

$(document).ready(function() {
  $('#btn-cerrarsesion').click(function(event) {
    event.preventDefault();
    cerrarSesion(this);
  });
  
  //Initialize Select2 Elements
  if ($('.select2').length > 0) {
    $(".select2").select2();
  }
  
  //Initialize datepicker
  if ($('#stu_fecha_creacion').length > 0) {
     $('#stu_fecha_creacion').datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       minDate: "1980-01-01",
       endDate: "2015-12-31",
       language: 'es'
     });
  }
  if ($('#pro_fecha_nacimiento').length > 0) {
     $('#pro_fecha_nacimiento').datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       minDate: "1940-01-01",
       endDate: "1997-12-31",
       language: 'es'
     });
  }
  if ($('#ent_fecha_nacimiento').length > 0) {
     $('#ent_fecha_nacimiento').datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       minDate: "1960-01-01",
       endDate: "1995-12-31",
       language: 'es'
     });
  }
  if ($('#jin_fecha_nacimiento').length > 0) {
     $('#jin_fecha_nacimiento').datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       minDate: "1975-01-01",
       endDate: "1997-12-31",
       language: 'es'
     });
  }
  if ($('#eje_fecha_nacimiento').length > 0) {
     $('#eje_fecha_nacimiento').datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       minDate: "1950-01-01",
       endDate: "2015-12-31",
       language: 'es'
     });   
  }
  
  // Script para cargar el combo box de boxes según caballeriza
  //$("select#empleado").attr("disabled","disabled");
  $("select#inputBox").attr("disabled","disabled");
  //$("button#btn_next").attr("disabled","disabled");
  
  $("select#inputCaballeriza").change(function(){
      $("select#inputBox").attr("disabled","disabled");
      //$("button#btn_next").attr("disabled","disabled");
      $("select#inputBox").html("<option>Seleccione un boxe</option>");
      var id = $("select#inputCaballeriza option:selected").attr('value');
      $.post("../../includes/select_boxeByCaballeriza.inc.php", {id:id}, function(data){
          $("select#inputBox").removeAttr("disabled");
          //$("button#btn_next").removeAttr("disabled");
          $("select#inputBox").html(data);
      });
  });
  
  // Script para cargar el combo box de boxes una vez que buscan
  // var pkbox_id = <?php if(!empty($_POST['pkbox_id'])) echo $_POST['pkbox_id']; else echo ""; ?>;
  //   if (pkbox_id != "") {
  //       $("select#inputBox").html("<option>Seleccione un boxe</option>");
  //       var id = $("select#inputCaballeriza option:selected").attr('value');
  //       $.post("../../include/select_boxeByCaballeriza.inc.php", {id:id,pkbox_id:pkbox_id}, function(data){
  //           $("select#inputBox").removeAttr("disabled");
            //$("button#btn_next").removeAttr("disabled");
    //         $("select#inputBox").html(data);
    //     });
    // }
});