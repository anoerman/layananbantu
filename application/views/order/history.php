<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Pesanan
			<small>Riwayat pesanan</small>
		</h1>
		<ol class="breadcrumb">
			<li><i class="fa fa-folder"></i> &nbsp; Pesanan</li>
			<li class="active">Riwayat</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php echo $message;?>

		<div class="row">
			<div class="col-md-12 col-sm-12">

				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">
							<span class="glyphicon glyphicon-list"></span> &nbsp; Generate Riwayat Pesanan
						</h3>

						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>

					<div class="box-body">
						<div class="row">
						  <!-- <div class="col-md-12 col-sm-12">
								<p>Pilih tanggal awal dan tanggal akhir untuk melihat data order selesai.</p>
							</div> -->
						  <div class="col-sm-12">
								<form id="form_laporan" class="form form-horizontal" action="<?php echo base_url('order/history_data'); ?>" enctype="multipart/form-data" method="post">

									<div class="form-group">
										<label for="tanggal_range" class="control-label col-md-2">Tanggal</label>
										<div class="col-md-8 col-sm-12">
											<div class="input-group input-daterange">
												<input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control" placeholder="Tanggal Awal" value="<?php echo (isset($tanggal_awal)) ? $tanggal_awal : "" ?>" required>
												<div class="input-group-addon">s/d</div>
												<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control" placeholder="Tanggal Akhir" value="<?php echo (isset($tanggal_akhir)) ? $tanggal_akhir : "" ?>" required>
												<span class="input-group-btn">
												</span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="cabang" class="control-label col-sm-2">Cabang</label>
										<div class="col-sm-9 col-md-8">
											<div class="radio">
												<label>
													<input type="radio" name="cabang" value="0" <?php echo set_radio('cabang', 0); ?> class="check_cabang_history" required>
													Semua Cabang
												</label>
											</div>
											<?php foreach ($daftar_cabang->result() as $cid): ?>
												<div class="radio">
													<label>
														<input type="radio" name="cabang" value="<?php echo $cid->id ?>" <?php echo set_radio('cabang', $cid->id); ?> class="check_cabang_history" required>
														<?php echo $cid->nama; ?>
													</label>
												</div>
											<?php endforeach; ?>
											<?php //echo (isset($cabang)) ? $cabang : ""; ?>
										</div>
									</div>

									<div class="form-group" id="div_regional">
										<label for="regional" class="control-label col-sm-2">Regional</label>
										<div class="col-sm-10 col-md-5" id="div_regional_select">
											<?php
											if (isset($daftar_regional)) {
												$result = "";

												// Jika data lebih besar dari 3, maka buat menjadi 2 kolom
												if (count($daftar_regional->result())>3) {
													$batas = ceil(count($daftar_regional->result())/2);
													$xs    = 0;
													$result .= "<div class='row'>";
													foreach ($daftar_regional->result() as $dls){
														// Flagging untuk menentukan jumlah data
														$xs++;
														// Jika 1, col 1.
														if ($xs==1) {
															$result .= "<div class='col-md-6'>";
															// Select all
															$result .= '<div class="radio">
															<label for="regional_id_all">
															<input type="checkbox" id="regional_id_all" class="regional_cb pilih_semua" value=""> Pilih Semua
															</label>
															</div>';
														}
														// Jika sudah batas, col 2
														elseif($xs==$batas+1) {
															$result .= "</div>";
															$result .= "<div class='col-md-6'>";
														}
														$result .= '<div class="radio">
														<label for="regional_id_'.$dls->id.'">
														<input type="checkbox" name="regional_id[]" id="regional_id_'.$dls->id.'" class="regional_cb" value="'.$dls->id.'" '.set_checkbox('regional_id[]', $dls->id).'> '.$dls->nama.'
														</label>
														</div>';
													}
													$result .= "</div> <!-- End col-6 -->";
													$result .= "</div> <!-- End row -->";
												}
												// Jika data masih 3 kebawah
												elseif (count($daftar_regional->result())>0 && count($daftar_regional->result())<=3) {
													$xs = 0;
													// Select all
													$result .= '<div class="radio">
													<label for="regional_id_all">
													<input type="checkbox" id="regional_id_all" class="regional_cb pilih_semua" value=""> Pilih Semua
													</label>
													</div>';
													foreach ($daftar_regional->result() as $dls){
														$xs++;
														$result .= '<div class="radio">
														<label for="regional_id_'.$dls->id.'">
														<input type="checkbox" name="regional_id[]" id="regional_id_'.$dls->id.'" class="regional_cb" value="'.$dls->id.'" '.set_checkbox("regional_id[]", $dls->id).'> '.$dls->nama.'
														</label>
														</div>';
													}
												}
												// Tampilkan Info
												else {
													if ($cabang == 0) {
														$result .= '<div class="radio">
															<label for="regional_id_all">
																<input type="checkbox" name="regional_id[]" id="regional_id_all" class="regional_cb" value="0" '.set_checkbox("regional_id[]", 0).'> Semua Regional
															</label>
														</div>';
													}
													else {
														$result .= '<p class="form-control-static text-danger">Harap pilih cabang</p>';
													}
												}
												echo $result;
											}
											?>
											<?php //(isset($regional_id)) ? print_r($regional_id) : ""; ?>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 col-md-12 text-center">
											<hr>
											<div class="btn-group btn-group-md">

												<button class="btn btn-lg btn-primary" type="button" id="view_data">Lihat Data</button>
												<button class="btn btn-lg btn-success" type="button" id="download_excel">Download Excel</button>
											</div>
											<button type="submit" name="proses_riwayat" id="proses_riwayat" class="hidden">Proses</button>
										</div>
									</div>

								</form>


						  </div>
						</div>
					</div>
				</div>
			<?php
			// Info jika tidak ada data
			if ($data_order_selesai==""): ?>
			<?php elseif (is_array($data_order_selesai->result())): ?>
				<?php //echo $last_query ?>
				<!-- Data Pesanan baru dengan toko yang telah ditunjuk -->
				<?php if (count($data_order_selesai->result()) > 0): ?>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">
								<span class="glyphicon glyphicon-check"></span> &nbsp; Order Selesai
							</h3>

							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<p>
								Periode : <?php echo date('d F Y', strtotime($tanggal_awal)); ?> - <?php echo date('d F Y', strtotime($tanggal_akhir)); ?>
							</p>
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>Detail Pesanan</th>
										<th width="5%">#</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data_order_selesai->result() as $data_1): ?>
										<tr>
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
															<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_1->nama_cabang ?>, <?php echo $data_1->nama_regional; ?>
														</div>

														<div class="col-md-12 col-sm-12">
															<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_1->cs_fn; echo ($data_1->cs_ln!="") ? " ".$data_1->cs_ln : ""; ?>
														</div>

														<div class="col-md-12 col-sm-12">
															<span class="glyphicon glyphicon-heart"></span> &nbsp; Status : <?php echo $data_1->nama_status; ?>
														</div>
													</div>
												</div>
												<div class="col-md-8 col-sm-12">
													<div class="row">
														<?php if ($data_1->motor!=""): ?>
															<div class="col-md-12 col-sm-12">
																<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_1->motor; ?>
															</div>
														<?php endif; ?>

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
												<a href="<?php echo base_url('order/detail/'.$data_1->kode); ?>" class="btn btn-sm btn-primary" target="_blank">Detail</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
						<div class="box-footer text-center">
							<?php //echo $pagination; ?>
							<!-- <br> -->
							<!-- <a href="<?php echo base_url('order/history') ?>" class="btn btn-lg btn-primary">Kembali</a> -->
							<!-- Footer -->
							<?php //echo $last_query ?>
						</div>
						<!-- /.box-footer-->
					</div>
				<?php else: ?>
					<?php //echo $last_query ?>
				<?php endif; ?>
				<!-- /.box -->
			<?php endif; ?>

			<?php if (isset($data_order_batal) && is_array($data_order_batal->result())): ?>
				<?php //echo $last_query ?>
				<?php if (count($data_order_batal->result()) > 0): ?>
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">
								<span class="glyphicon glyphicon-check"></span> &nbsp; Order Batal
							</h3>

							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<p>
								Periode : <?php echo date('d F Y', strtotime($tanggal_awal)); ?> - <?php echo date('d F Y', strtotime($tanggal_akhir)); ?>
							</p>
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>Detail Pesanan</th>
										<th width="5%">#</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data_order_batal->result() as $data_2): ?>
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
															<span class="glyphicon glyphicon-globe"></span> &nbsp; <?php echo $data_2->nama_cabang ?>, <?php echo $data_2->nama_regional; ?>
														</div>

														<div class="col-md-12 col-sm-12">
															<span class="glyphicon glyphicon-headphones"></span> &nbsp; <?php echo $data_2->cs_fn; echo ($data_2->cs_ln!="") ? " ".$data_2->cs_ln : ""; ?>
														</div>

														<div class="col-md-12 col-sm-12">
															<span class="glyphicon glyphicon-heart"></span> &nbsp; Status : <?php echo $data_2->nama_status; ?>
														</div>
													</div>
												</div>
												<div class="col-md-8 col-sm-12">
													<div class="row">
														<?php if ($data_2->motor!=""): ?>
															<div class="col-md-12 col-sm-12">
																<span class="fa fa-motorcycle"></span> &nbsp; <?php echo $data_2->motor; ?>
															</div>
														<?php endif; ?>

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
												<a href="<?php echo base_url('order/detail/'.$data_2->kode); ?>" class="btn btn-sm btn-primary" target="_blank">Detail</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
						<div class="box-footer text-center">
							<?php //echo $pagination; ?>
							<!-- <br> -->
							<!-- <a href="<?php echo base_url('order/history') ?>" class="btn btn-lg btn-primary">Kembali</a> -->
							<!-- Footer -->
							<?php //echo $last_query ?>
						</div>
						<!-- /.box-footer-->
					</div>
				<?php else: ?>
					<?php //echo $last_query ?>
				<?php endif; ?>
				<!-- /.box -->
			<?php endif; ?>
			</div>
		</div>


	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- =========================== / CONTENT =========================== -->
