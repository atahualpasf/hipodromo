$(function () {
  $("#tableDefault").DataTable();
  $("#tableDefault-1").DataTable();
  $("#tableDefault-2").DataTable();
  $("#tableDefault-3").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
});