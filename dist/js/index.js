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
  inputs = $(search).find(':input:not(:checkbox,:button,:file)').not('select, input[type="hidden"]').blur(function(event) {
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
  function progress(e) {
    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;
        var Percentage = (current * 100)/max;
        console.log(Percentage);
        if(Percentage >= 100) {
           // process completed
           console.log('Complete YEAAAH!!');
        }
    }
  }
  $(id).find('form').submit(function(event) {
    event.preventDefault();
    $(id).find('.overlay > .fa').show();
    var formData = new FormData(this);
    var usu_nombre = $(inputs)[0];
    var usu_correo = $(inputs)[1];
    var usu_password = $(inputs)[2];
    var usu_passwordv = $(inputs)[3];
    var error_label = $(id).find('.social-auth-links label');
    $(error_label).addClass('invisible');

    $.ajax({
        url: _INCL_ROOT + 'user-connection.inc.php',
        type: 'POST',
        data: formData,
        xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
        },
        success: function (data) {
          $(id).find('.overlay > .fa').fadeOut(300);
          console.log(data);
          var dataResponse = JSON.parse(data);
          if (dataResponse.action.action === 'error') {
            if (dataResponse.action.type === 'usu_nombre') {
              $(usu_nombre).parent().removeClass('has-feedback').addClass('has-error');
              $(usu_correo).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_password).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_passwordv).parent().removeClass('has-error').addClass('has-feedback');
            } else if (dataResponse.action.type === 'usu_correo') {
              $(usu_nombre).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_correo).parent().removeClass('has-feedback').addClass('has-error');
              $(usu_password).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_passwordv).parent().removeClass('has-error').addClass('has-feedback');
            } else if (dataResponse.action.type === 'usu_password') {
              $(usu_nombre).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_correo).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_password).parent().removeClass('has-feedback').addClass('has-error');
              $(usu_passwordv).parent().removeClass('has-error').addClass('has-feedback');
            } else if (dataResponse.action.type === 'usu_passwordv') {
              $(usu_nombre).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_correo).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_password).parent().removeClass('has-error').addClass('has-feedback');
              $(usu_passwordv).parent().removeClass('has-feedback').addClass('has-error');
            }
            $(error_label).text(dataResponse.response.data).removeClass('invisible');
          }
        },
        error: function(data) {
          $(id).find('.overlay > .fa').fadeOut(300);
          // $(id).find('.social-auth-links p').text('-');
          // console.log(data.response);
        },
        cache: false,
        contentType: false,
        processData: false
    });
  });
}

$(document).ready(function() {
  $('#bg-video').videoBackground(_DIST_ROOT + 'videos/racehorseslowmotion-hd.mp4');
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
});