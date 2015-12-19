/* FUNCIONES GENÉRICAS */
function checkIcheckExists() {
  if ($('div.icheckbox_square-blue').length < 1) {
    var icheck = $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    $(icheck).on('ifChanged', function(event){
      this.setCustomValidity('');
    });
  }
}

function checkInputs(input, errorMessage) {
  if (input.value == '' || input.value.trim() == '') {
    input.setCustomValidity('Por favor completa este campo.');
  } else if(input.validity.patternMismatch) {
    input.setCustomValidity(errorMessage);
  }
  else {
    input.setCustomValidity('');
  }
}

function trimInputs(search) {
  var inputs = $(search).find(':input:not(:checkbox,:button)').not('select, input[type="hidden"]').blur(function(event) {
    this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();
  });
}


/* REGISTRO DE USUARIO */
function handleImageFromInput(input) {
  var mimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpeg', 'image/jpg'];
  $(input).change(function(event) {
    event.preventDefault();
    if ($.inArray($(input)[0].files[0].type, mimeTypes) != -1) {
      if (input[0].files && input[0].files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#box-registrar img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input[0].files[0]);
      }
    }
  });
  $(input).prev().click(function(event) {
    event.preventDefault();
    $(input).trigger('click');
  });
}

function executeRegisterFormRequest(id) {
  $(id).find('form').submit(function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
        url: _INCL_ROOT + 'user_connection.inc.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
  });
  // $(id).find('form')[0].submit(function(event) {
  //   event.preventDefault();
  //   alert('Hola');
  // });
}

$(document).ready(function() {
  $('#bg-video').videoBackground('videos/racehorseslowmotion-hd.mp4');
  var box_registrar = $('#box-registrar');
  var box_iniciarsesion = $('#box-iniciarsesion');
  var box_title = $('#box-title');
  $(box_registrar).remove();
  $(box_iniciarsesion).remove();
  
  $(document).on('click', '#btn-registrar', function(event) {
    event.preventDefault();
    $(box_title).remove();
    box_registrar.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs(box_registrar);
    handleImageFromInput($(box_registrar).find('input[type="file"]'));
    executeRegisterFormRequest(box_registrar);
    $(box_registrar).css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-iniciarsesion', function(event) {
    event.preventDefault();
    $(box_title).remove();
    box_iniciarsesion.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs(box_iniciarsesion);
    $(box_iniciarsesion).css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-rg-regresar', function(event) {
    event.preventDefault();
    $(box_registrar).remove();
    box_title.insertAfter('#bg-video');
    $(box_title).hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-is-regresar', function(event) {
    event.preventDefault();
    $(box_iniciarsesion).remove();
    box_title.insertAfter('#bg-video');
    $(box_title).hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-rg-iniciarsesion', function(event) {
    event.preventDefault();
    $(box_registrar).remove();
    box_iniciarsesion.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs(box_iniciarsesion);
    $(box_iniciarsesion).css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-is-registrar', function(event) {
    event.preventDefault();
    $(box_iniciarsesion).remove();
    box_registrar.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs(box_registrar);
    $(box_registrar).css('display','flex').hide().fadeIn(500);
  });
  
  // function executeOnBackground(id) {
  //   var form = $(id).find('form');
  //   var inputFile = $(form).find('input[type="file"]');
  //   var data = new FormData(form[0]);
  //   $.each(inputFile[0].files, function(key, value) {
  //     data.append(file.name, file);
  //   });
  //   console.log(data);
  //   form.submit(function(event) {
  //     event.preventDefault();
  //     console.log(data);
  //     $.ajax({
  //       type: 'POST',
  //       url: _INCL_ROOT + 'user_connection.inc.php',
  //       contentType:'multipart/form-data',
  //       cache: false,
  //       contentType: false,
  //       processData: false,
  //       data: data,
  //       beforeSend: function() {
  //         $(id).find('.overlay > .fa').show();
  //         $(id).find('.social-auth-links p').text('').html('<br>');
  //       },
  //       success: function(data) {
  //         $(id).find('.overlay > .fa').fadeOut(300);
  //         $(id).find('.social-auth-links p').text('-');
  //         console.log(data.action);
  //         if (data.action === "error") {
  //           window.location.href = 'index-error.php'              
  //         } else {
  //           window.location.href = 'index-admin.php'
  //         }
  //       },
  //       error: function(data) {
  //         console.log(data.response);
  //       }
  //      });
  //   });
  // }
});