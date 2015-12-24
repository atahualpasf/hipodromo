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
});