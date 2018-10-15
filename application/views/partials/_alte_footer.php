	<!-- =========================== FOOTER =========================== -->
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b><?php echo $this->config->item('site_author'); ?></b>
		</div>
		<strong>Copyright &copy; <?php echo date('Y') ?> <a href="#"><?php echo $this->config->item('site_company'); ?></a>.</strong> All rights
		reserved.
	</footer>

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Create the tabs -->
		<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
			<!-- <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li> -->
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<!-- Home tab content -->
			<div class="tab-pane hide" id="control-sidebar-home-tab">
				<h3 class="control-sidebar-heading">Control Sidebar</h3>
				<!-- /.control-sidebar-menu -->
			</div>
			<!-- /.tab-pane -->
		</div>
	</aside>
	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/app.min.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/demo.js'); ?>"></script> -->

<!-- iCheck -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/icheck.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/all.css'); ?>">
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	});
</script>
<!-- / iCheck -->


<!-- Datatables -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datatables/dataTables.bootstrap.css'); ?>">

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> -->
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script> -->
<script type="text/javascript">
	$(document).ready( function () {
		$('#datatables').DataTable();
	} );
</script>
<!-- / Datatables -->


</body>
</html>
<?php //echo $last_query ?>
