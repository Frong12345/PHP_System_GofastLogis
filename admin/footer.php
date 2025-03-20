<footer class="main-footer">
    <strong>Copyright &copy; 2025 
      <a href="https://devbanban.com/"> edited by devbanban.com </a>.
    </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0 
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assetsBackend/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assetsBackend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Summernote -->
<script src="../assetsBackend/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

  })
</script>

<!-- AdminLTE App -->
<script src="../assetsBackend/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../assetsBackend/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assetsBackend/dist/js/pages/dashboard.js"></script>


<!-- DataTables  & ../assetsBackend/plugins -->
<script src="../assetsBackend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assetsBackend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assetsBackend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assetsBackend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assetsBackend/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assetsBackend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assetsBackend/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assetsBackend/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assetsBackend/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "aaSorting": [[ 0, "asc" ]], //"desc" มาก->น้อย   "asc" น้อย->มาก
      //"buttons": ["excel", "print"] //["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>
