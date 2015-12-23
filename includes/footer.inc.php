<?php if (strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages'): ?>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.0
      </div>
      <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
    </footer>
<?php endif; ?>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $db->getRootUri() . 'plugins/jQuery/jQuery-2.1.4.min.js'; ?>"></script>
<?php if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) === 'index')): ?>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $db->getRootUri() . 'bootstrap/js/bootstrap.min.js'; ?>"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo $db->getRootUri() . 'plugins/morris/morris.min.js'; ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo $db->getRootUri() . 'plugins/sparkline/jquery.sparkline.min.js'; ?>"></script>
    <!-- jvectormap -->
    <script src="<?php echo $db->getRootUri() . 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'; ?>"></script>
    <script src="<?php echo $db->getRootUri() . 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js'; ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $db->getRootUri() . 'plugins/knob/jquery.knob.js'; ?>"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo $db->getRootUri() . 'plugins/daterangepicker/daterangepicker.js'; ?>"></script>
    <!-- datepicker -->
    <script src="<?php echo $db->getRootUri() . 'plugins/datepicker/bootstrap-datepicker.js'; ?>"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $db->getRootUri() . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'; ?>"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $db->getRootUri() . 'plugins/slimScroll/jquery.slimscroll.min.js'; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo $db->getRootUri() . 'plugins/fastclick/fastclick.min.js'; ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/app.min.js'; ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/pages/dashboard.js'; ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/demo.js'; ?>"></script>
    <!-- Hipodromo extras functionalities -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/extras.js'; ?>"></script>
<?php endif; ?>
<?php if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'pages') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) !== 'index')): ?>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $db->getRootUri() . 'bootstrap/js/bootstrap.min.js'; ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo $db->getRootUri() . 'plugins/datatables/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo $db->getRootUri() . 'plugins/datatables/dataTables.bootstrap.min.js'; ?>"></script>
    <!-- SlimScroll -->
    <script src="<?php echo $db->getRootUri() . 'plugins/slimScroll/jquery.slimscroll.min.js'; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo $db->getRootUri() . 'plugins/fastclick/fastclick.min.js'; ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/app.min.js'; ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/demo.js'; ?>"></script>
    <!-- Constantes globales -->
    <script>
      var _ROOT = window.location.origin + '/hipodromo/';
      var _INCL_ROOT = _ROOT + 'includes/';
      var _DIST_ROOT = _ROOT + 'dist/';
    </script>
    <!-- Hipodromo extras functionalities -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/extras.js'; ?>"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
<?php endif; ?>
<?php if ((strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME']))) === 'hipodromo') and (strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) === 'index')): ?>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $db->getRootUri() . 'bootstrap/js/bootstrap.min.js'; ?>"></script>
    <!-- Background video -->
    <script src="<?php echo $db->getRootUri() . 'plugins/videobackground/videobackground.js'; ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo $db->getRootUri() . 'plugins/iCheck/icheck.min.js'; ?>"></script>
    <!-- Constantes globales -->
    <script>
      var _ROOT = window.location.origin + '/hipodromo/';
      var _INCL_ROOT = _ROOT + 'includes/';
      var _DIST_ROOT = _ROOT + 'dist/';
      var inputs;
    </script>
    <!-- Index script -->
    <script src="<?php echo $db->getRootUri() . 'dist/js/index.js'; ?>"></script>
<?php endif; ?>
  </body>
</html>
