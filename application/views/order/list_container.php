	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Pesanan
				<small>Data pesanan layanan bantu</small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-folder"></i> &nbsp; Pesanan</li>
				<li class="active">Daftar Pesanan</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $message;?>

			<div class="row">
				<div class="col-md-12">
					<div class="box box-default">
						<!-- <div class="box-header with-border">
							<h3 class="box-title">
								<span class="glyphicon glyphicon-globe"></span> &nbsp; Pilih Cabang
							</h3>

							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div> -->

						<div class="box-body">
							<div class="row">
							  <div class="col-md-6 col-sm-12">
									<div class="form-group">
										<div class="input-group">
										  <span class="input-group-addon">Cabang</span>
										  <select class="form-control" name="cbg" id="data_list_cabang">
									  	<?php foreach ($cabang_list->result() as $cl): ?>
									  		<option value="<?php echo $cl->id ?>" <?php echo ($curr_cabang == $cl->id) ? "selected" : ""; ?>><?php echo $cl->nama ?></option>
									  	<?php endforeach; ?>
										  </select>
											<span class="input-group-btn">
								        <a href="<?php echo base_url('order/data_list'); echo ($curr_cabang != "") ? "/".$curr_cabang : ""; ?>" class="btn btn-primary" id="link_list">Lihat Data</a>
								      </span>
										</div>
									</div>
							  </div>
							  <div class="col-md-6 col-sm-12">

							  </div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12" id="container_data">

				</div>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
