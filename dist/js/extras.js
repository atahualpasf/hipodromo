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

function checkInputs(input, errorMessage) {
  if (input.value == '' || input.value.trim() == '') {
    input.setCustomValidity('Por favor completa este campo.');
    return false;
  } else {
    input.setCustomValidity('');
    return true;
  }
}

function resizeJqueryStepsFrame() {
   $('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
}

function trimInputs(numberSteps) {
   for (i = 0; i <= numberSteps; i++) {
       var inputs = $('#steps-uid-'+i+'-p-'+i+' input').blur(function(event) {
         this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();
       });
   } 
}

$(document).ready(function() {
  $('#btn-cerrarsesion').click(function(event) {
    event.preventDefault();
    cerrarSesion(this);
  });
  
  
  if ($('#create-stud').length > 0) {
      var form = $("#create-stud");
      var wizard = form.children("mainstep").steps({
         headerTag: "h3",
         bodyTag: "fieldstep",
         transitionEffect: "slideLeft",
         onInit: function (event, current) {
            trimInputs(form.children("mainstep").steps("numberSteps"));
         },
         onStepChanging: function (event, currentIndex, newIndex)
         {
            //  console.log(currentIndex);
            //  checkInputRequired(currentIndex);
             return true;
         },
         onFinishing: function (event, currentIndex)
         {
             return true;
         },
         onFinished: function (event, currentIndex)
         {
             alert("Submitted!");
         }
      });
  }
  
  //Initialize Select2 Elements
  if ($('.select2').length > 0) {
     $(".select2").select2();
  }
  
  if ($('#stud-date').length > 0) {
     $('#stud-date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minDate: "1980-01-01",
        endDate: "2015-12-31",
        language: 'es'
     });
  }
  
});