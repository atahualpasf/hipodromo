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

$(document).ready(function() {
  $('#bg-video').videoBackground('videos/racehorseslowmotion-hd.mp4');
  var box_registrar = $('#box-registrar');
  var box_iniciarsesion = $('#box-iniciarsesion');
  var box_title = $('#box-title');
  $('#box-registrar').remove();
  $('#box-iniciarsesion').remove();
  $(document).on('click', '#btn-registrar', function(event) {
    event.preventDefault();
    $('#box-title').remove();
    box_registrar.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs('registrar');
    $('#box-registrar').css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-iniciarsesion', function(event) {
    event.preventDefault();
    $('#box-title').remove();
    box_iniciarsesion.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs('iniciarsesion');
    $('#box-iniciarsesion').css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-rg-regresar', function(event) {
    event.preventDefault();
    $('#box-registrar').remove();
    box_title.insertAfter('#bg-video');
    $('#box-title').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-is-regresar', function(event) {
    event.preventDefault();
    $('#box-iniciarsesion').remove();
    box_title.insertAfter('#bg-video');
    $('#box-title').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-rg-iniciarsesion', function(event) {
    event.preventDefault();
    $('#box-registrar').remove();
    box_iniciarsesion.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs('iniciarsesion');
    $('#box-iniciarsesion').css('display','flex').hide().fadeIn(500);
  });
  
  $(document).on('click', '#btn-is-registrar', function(event) {
    event.preventDefault();
    $('#box-iniciarsesion').remove();
    box_registrar.insertAfter('#bg-video');
    checkIcheckExists();
    trimInputs('registrar');
    $('#box-registrar').css('display','flex').hide().fadeIn(500);
  });
  
  
  /* REGISTRO DE USUARIO */
    function trimInputs(search) {
      var inputs = $('#box-' + search + ' :input:not(:checkbox,:button)').not('#box-registrar select').blur(function(event) {
        this.value = this.value.trim() == '' ? this.defaultValue : this.value.trim();
      });
    }
});