<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Pesanan
			<small>Data pesanan selesai</small>
		</h1>
		<ol class="breadcrumb">
			<li><i class="fa fa-folder"></i> &nbsp; Pesanan</li>
			<li class="active">Pesanan Selesai</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php echo $message;?>

		<div class="row">
			<div class="col-md-12 col-sm-12">

				<!-- Data Pesanan status terbuka untuk semua toko -->
				<?php if (count($data_selesai->result()) > 0): ?>
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">
							<span class="glyphicon glyphicon-check"></span> &nbsp; Pesanan Selesai
						</h3>

						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table class="table table-striped table-hover table-bordered">
							<thead>
								<tr>
									<th>Detail Pesanan</th>
									<th width="5%">#</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($data_selesai->result() as $data_sls): ?>
								<tr>
									<td>
										<div class="col-md-4 col-sm-12">
											<div class="row">
												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_sls->kode; ?>
												</div>

												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_sls->tanggal), 'd F Y (H:i:s)'); ?>
												</div>

											<!--
												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_sls->first_name; echo ($data_sls->last_name!="") ? " ".$data_sls->last_name : ""; ?>
												</div>

												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-comment"></span> &nbsp; <?php echo $data_sls->nama_status; ?>
												</div>
												-->
											</div>
										</div>
										<div class="col-md-8 col-sm-12">
											<div class="row">
												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_sls->nama_konsumen; ?>
												</div>

												<div class="col-md-12 col-sm-12">
													<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
													<!-- Alamat Lokasi <br> -->
													<?php echo $data_sls->alamat_lokasi; ?>
												</div>
											</div>
										</div>
										<br>
									</td>
									<td>
										<a href="<?php echo base_url('order/completed_detail/'.$data_sls->kode); ?>" class="btn btn-sm btn-primary">Detail</a>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer text-center">
						<?php echo $pagination ?>
						<!-- Footer -->
					</div>
					<!-- /.box-footer-->
				</div>
				<?php else: ?>
				<div class="box box-info">
					<div class="box-body">
						<h4 class="text-center">Tidak ada data order</h4>
					</div>
				</div>
				<?php endif; ?>
				<!-- /.box -->

			</div>
		</div>


	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- =========================== / CONTENT =========================== -->
