<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<?php run_event('tail_sub'); ?>
<?php if ($simple_windows == "N") {  // It is not simple_windows ?>
</div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->
<?php } // It is simple_windows ?>
<!-- jQuery -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/jquery/jquery.min.js"></script>
<?php if ($simple_windows == "N") {  // It is not simple_windows ?>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<?php } // It is simple_windows ?>
<!-- Bootstrap 4 -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php if ($simple_windows == "N") {  // It is not simple_windows ?>
<!-- ChartJS -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo G5_THEME_URL; ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/moment/moment.min.js"></script>
<script src="<?php echo G5_THEME_URL; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo G5_THEME_URL; ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo G5_THEME_URL; ?>/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo G5_THEME_URL; ?>/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo G5_THEME_URL; ?>/dist/js/pages/dashboard.js"></script>
<?php } // It is simple_windows ?>
<?php if ($base_filename == "login.php") {  // It's login.php ?>
<!-- AdminLTE App -->
<script src="<?php echo G5_THEME_URL; ?>/dist/js/adminlte.min.js"></script>    
<?php } // It's login.php ?>
</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.
