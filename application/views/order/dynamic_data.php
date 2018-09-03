
<!-- Info jika tidak ada data -->
<?php if ($total_semua_data==0): ?>
<div class="box box-info">
	<div class="box-body">
		<h4 class="text-center">Tidak ada data order aktif</h4>
	</div>
</div>
<?php endif; ?>

<!-- Data Pesanan baru dengan toko yang telah ditunjuk -->
<?php if (count($data_order_baru->result()) > 0): ?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">
			<span class="glyphicon glyphicon-asterisk"></span> &nbsp; Pesanan Baru
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
			<?php foreach ($data_order_baru->result() as $data_1):
				$danger = "";
				if (now() - strtotime($data_1->tanggal) > 300) {
					$danger = ' class="danger pulsing"';
					$sound_path = base_url('assets/sounds/youve-been-informed');
					echo '<audio autoplay="autoplay"><source src="' .$sound_path. '.mp3" type="audio/mpeg" /><source src="' .$sound_path. '.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="' .$sound_path. '.mp3" /></audio>';
				}
				?>
				<tr <?php echo $danger ?>>
					<td>
						<div class="col-md-4 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_1->tanggal), 'd F Y (H:i:s)'); ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_1->first_name; echo ($data_1->last_name!="") ? " ".$data_1->last_name : ""; ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_1->nama_regional ?>, <?php echo $data_1->nama_cabang ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_1->cs_fn; echo ($data_1->cs_ln!="") ? " ".$data_1->cs_ln : ""; ?>
								</div>

								<?php if ($data_1->motor!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_1->motor; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_1->nama_konsumen; ?>
								</div>

								<?php if ($data_1->nomor_polisi!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_1->nomor_polisi; ?>
								</div>
								<?php endif; ?>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
									<!-- Alamat Lokasi <br> -->
									<?php echo $data_1->alamat_lokasi; ?>
								</div>
							</div>
						</div>
						<br>
					</td>
					<td>
						<div class="btn-group-vertical btn-group-sm">
							<a href="<?php echo base_url('order/detail/'.$data_1->kode); ?>" class="btn btn-primary">Detail</a>
							<a href="<?php echo base_url('order/edit/'.$data_1->kode); ?>" class="btn btn-info">Ubah</a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
		<!-- Footer -->
	</div>
	<!-- /.box-footer-->
</div>
<?php endif; ?>
<!-- /.box -->

<!-- Data Pesanan status terbuka untuk semua toko -->
<?php if (count($data_order_buka->result()) > 0): ?>
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">
			<span class="glyphicon glyphicon-folder-open"></span> &nbsp; Pesanan Terbuka
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
			<?php foreach ($data_order_buka->result() as $data_2): ?>
				<tr>
					<td>
						<div class="col-md-4 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_2->tanggal), 'd F Y (H:i:s)'); ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_2->first_name; echo ($data_2->last_name!="") ? " ".$data_2->last_name : ""; ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_2->nama_regional ?>, <?php echo $data_2->nama_cabang ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_2->cs_fn; echo ($data_2->cs_ln!="") ? " ".$data_2->cs_ln : ""; ?>
								</div>

								<?php if ($data_2->motor!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_2->motor; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_2->nama_konsumen; ?>
								</div>

								<?php if ($data_2->nomor_polisi!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_2->nomor_polisi; ?>
								</div>
								<?php endif; ?>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
									<!-- Alamat Lokasi <br> -->
									<?php echo $data_2->alamat_lokasi; ?>
								</div>
							</div>
						</div>
						<br>
					</td>
					<td>
						<a href="<?php echo base_url('order/detail/'.$data_2->kode); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
		<!-- Footer -->
	</div>
	<!-- /.box-footer-->
</div>
<?php endif; ?>
<!-- /.box -->

<!-- Data Mekanik dalam perjalanan -->
<?php if (count($data_order_jalan->result()) > 0): ?>
<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">
			<span class="glyphicon glyphicon-refresh"></span> &nbsp; Mekanik dalam perjalanan
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
			<?php foreach ($data_order_jalan->result() as $data_3): ?>
				<tr>
					<td>
						<div class="col-md-4 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_3->tanggal), 'd F Y (H:i:s)'); ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_3->first_name; echo ($data_3->last_name!="") ? " ".$data_3->last_name : ""; ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_3->nama_regional ?>, <?php echo $data_3->nama_cabang ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_3->cs_fn; echo ($data_3->cs_ln!="") ? " ".$data_3->cs_ln : ""; ?>
								</div>

								<?php if ($data_3->motor!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_3->motor; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_3->nama_konsumen; ?>
								</div>

								<?php if ($data_3->nomor_polisi!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_3->nomor_polisi; ?>
								</div>
								<?php endif; ?>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
									<!-- Alamat Lokasi <br> -->
									<?php echo $data_3->alamat_lokasi; ?>
								</div>
							</div>
						</div>
						<br>
					</td>
					<td>
						<a href="<?php echo base_url('order/detail/'.$data_3->kode); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
		<!-- Footer -->
	</div>
	<!-- /.box-footer-->
</div>
<?php endif; ?>
<!-- /.box -->

<!-- Data Mekanik sampai di lokasi -->
<?php if (count($data_order_sampai->result()) > 0): ?>
<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">
			<span class="fa fa-bullseye"></span> &nbsp; Mekanik sampai lokasi
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
			<?php foreach ($data_order_sampai->result() as $data_4): ?>
				<tr>
					<td>
						<div class="col-md-4 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_4->tanggal), 'd F Y (H:i:s)'); ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_4->first_name; echo ($data_4->last_name!="") ? " ".$data_4->last_name : ""; ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_4->nama_regional ?>, <?php echo $data_4->nama_cabang ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_4->cs_fn; echo ($data_4->cs_ln!="") ? " ".$data_4->cs_ln : ""; ?>
								</div>

								<?php if ($data_4->motor!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_4->motor; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_4->nama_konsumen; ?>
								</div>

								<?php if ($data_4->nomor_polisi!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_4->nomor_polisi; ?>
								</div>
								<?php endif; ?>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
									<!-- Alamat Lokasi <br> -->
									<?php echo $data_4->alamat_lokasi; ?>
								</div>
							</div>
						</div>
						<br>
					</td>
					<td>
						<a href="<?php echo base_url('order/detail/'.$data_4->kode); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
		<!-- Footer -->
	</div>
	<!-- /.box-footer-->
</div>
<?php endif; ?>
<!-- /.box -->

<!-- Data Mekanik konfirmasi pemasangan -->
<?php if (count($data_order_konfirmasi->result()) > 0): ?>
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">
			<span class="glyphicon glyphicon-eye-open"></span> &nbsp; Mekanik konfirmasi layanan
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
			<?php foreach ($data_order_konfirmasi->result() as $data_5): ?>
				<tr>
					<td>
						<div class="col-md-4 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo date_format(date_create($data_5->tanggal), 'd F Y (H:i:s)'); ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-home"></span> &nbsp; <?php echo $data_5->first_name; echo ($data_5->last_name!="") ? " ".$data_5->last_name : ""; ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_5->nama_regional ?>, <?php echo $data_5->nama_cabang ?>
								</div>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_5->cs_fn; echo ($data_5->cs_ln!="") ? " ".$data_5->cs_ln : ""; ?>
								</div>

								<?php if ($data_5->motor!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_5->motor; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $data_5->nama_konsumen; ?>
								</div>

								<?php if ($data_5->nomor_polisi!=""): ?>
								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-qrcode"></span> &nbsp; <?php echo $data_5->nomor_polisi; ?>
								</div>
								<?php endif ?>

								<div class="col-md-12 col-sm-12">
									<span class="glyphicon glyphicon-map-marker"></span> &nbsp;
									<!-- Alamat Lokasi <br> -->
									<?php echo $data_5->alamat_lokasi; ?>
								</div>
							</div>
						</div>
						<br>
					</td>
					<td>
						<a href="<?php echo base_url('order/detail/'.$data_5->kode); ?>" class="btn btn-sm btn-primary">Detail</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer text-center">
		<!-- Footer -->
	</div>
	<!-- /.box-footer-->
</div>
<?php endif; ?>
<!-- /.box -->
