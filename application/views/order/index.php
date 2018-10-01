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
				<li class="active">Tambah Baru</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $message;?>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<!-- Default box -->
					<div class="box">
						<form action="<?php echo base_url('order/index') ?>" method="post" id="form" class="form form-horizontal" autocomplete="off">
						<div class="box-header with-border">
							<h3 class="box-title">
								Tambah Data Layanan Bantu
							</h3>

							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<?php $myprofile = $this->ion_auth->user()->row(); ?>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="nama_konsumen" class="control-label col-sm-3">Tanggal</label>
										<div class="col-sm-9 col-md-7">
											<p class="form-control-static"><?php echo date(DATE_RFC1123, now()); ?></p>
										</div>
									</div>
									<div class="form-group">
										<label for="nama_konsumen" class="control-label col-sm-3">* Nama Konsumen</label>
										<div class="col-sm-9 col-md-5">
											<input type="text" name="nama_konsumen" id="nama_konsumen" class="form-control" value="<?php echo set_value('nama_konsumen'); ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="hp_konsumen" class="control-label col-sm-3">* No Handphone</label>
										<div class="col-sm-9 col-md-5">
											<input type="number" name="hp_konsumen" id="hp_konsumen" class="form-control" value="<?php echo set_value('hp_konsumen'); ?>" required data-parsley-type="number">
										</div>
									</div>
									<div class="form-group">
										<label for="alamat_lokasi" class="control-label col-sm-3">* Alamat Lokasi</label>
										<div class="col-sm-9 col-md-7">
											<textarea name="alamat_lokasi" id="alamat_lokasi" class="form-control" style="resize:vertical; max-height:250px; min-height:100px;"><?php echo set_value('alamat_lokasi'); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="sumber_info" class="control-label col-sm-3">Sumber Info</label>
										<div class="col-sm-9 col-md-5">
											<input type="text" name="sumber_info" id="sumber_info" class="form-control" value="<?php echo set_value('sumber_info') ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="metode_pesan" class="control-label col-sm-3">* Metode Pesan</label>
										<div class="col-sm-9 col-md-7">
										<?php foreach ($metode_pesan->result() as $mpid): ?>
											<div class="radio">
												<label>
													<input type="radio" name="metode_pesan" value="<?php echo $mpid->id ?>" <?php echo set_radio('metode_pesan', $mpid->id); ?> required>
													<?php echo $mpid->nama; ?>
												</label>
											</div>
										<?php endforeach; ?>
										</div>
									</div>
									<div class="form-group">
										<label for="cabang" class="control-label col-sm-3">* Cabang</label>
										<div class="col-sm-9 col-md-7">
										<?php foreach ($cabang->result() as $cid): ?>
											<div class="radio">
												<label>
													<input type="radio" name="cabang" value="<?php echo $cid->id ?>" <?php echo set_radio('cabang', $cid->id); ?> class="check_cabang" required>
													<?php echo $cid->nama; ?>
												</label>
											</div>
										<?php endforeach; ?>
										</div>
									</div>
									<div class="form-group" id="div_regional">
										<label for="regional" class="control-label col-sm-3">* Regional</label>
										<div class="col-sm-9 col-md-5" id="div_regional_select">
											<p class="form-control-static text-danger">Harap pilih cabang</p>
										</div>
									</div>
									<div class="form-group" id="div_toko">
										<label for="toko" class="control-label col-sm-3">* Toko</label>
										<div class="col-sm-9 col-md-5" id="div_toko_select">
											<p class="form-control-static text-danger">Harap pilih regional</p>
											<!-- <select name="toko" id="toko" class="form-control select2" style="width:100%">
											<?php foreach ($toko->result() as $tk): ?>
												<option value="<?php echo $tk->username; ?>" <?php echo set_select('toko', $tk->username); ?>><?php echo $tk->first_name . " " . $tk->last_name; ?></option>
											<?php endforeach; ?>
												<option value="">Pesanan Terbuka</option>
											</select> -->
										</div>
										<div class="col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-3">
											<p class="help-block">
												Masukkan nama toko yang diminta untuk melakukan penyelesaian LB. <br>
												<!-- Pesanan terbuka adalah pesanan yang tidak menunjuk toko namun toko di dalam cabang dapat mengambil pesanan tersebut secara manual. -->
											</p>
										</div>
									</div>
									<!-- <hr> -->
									<legend>Info Kendaraan</legend>
									<div class="form-group">
										<label for="motor" class="control-label col-sm-3">Nama Motor</label>
										<div class="col-sm-9 col-md-5">
											<input type="text" name="motor" id="motor" class="form-control" value="<?php echo set_value('motor') ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="nomor_polisi" class="control-label col-sm-3">Nomor Polisi</label>
										<div class="col-sm-9 col-md-3">
											<input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control" value="<?php echo set_value('nomor_polisi') ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="jenis_velg" class="control-label col-sm-3">* Jenis Velg</label>
										<div class="col-sm-9 col-md-7">
										<?php foreach ($jenis_velg->result() as $jv): ?>
											<div class="radio">
												<label>
													<input type="radio" name="jenis_velg" value="<?php echo $jv->id ?>" <?php echo set_radio('jenis_velg', $jv->id); ?> required>
													<?php echo $jv->nama; ?>
												</label>
											</div>
										<?php endforeach; ?>
										</div>
									</div>
									<!-- <hr> -->
									<legend>Detail Pesanan</legend>
									<div class="panel panel-primary">
									  <div class="panel-heading">
									    <h3 class="panel-title">Produk dan Harga</h3>
									  </div>
									  <!-- <div class="panel-body"> -->
											<div class="table-responsive">
												<table class="table table-hover table-striped table-bordered">
													<thead>
														<tr>
															<th>
																<!-- Produk & Harga -->
															</th>
															<!--
															<th class="text-center">
																<button type="button" class="btn btn-primary" name="addNewRow"><span class="glyphicon glyphicon-plus"></span></button>
															</th> -->
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk1" class="form-control produk" value="<?php echo set_value('produk[0]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )" required>
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga1" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[0]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000" required>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk2" class="form-control produk" value="<?php echo set_value('produk[1]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga2" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[1]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk3" class="form-control produk" value="<?php echo set_value('produk[2]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga3" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[2]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk4" class="form-control produk" value="<?php echo set_value('produk[3]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga4" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[3]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk5" class="form-control produk" value="<?php echo set_value('produk[4]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp </span>
																		<input type="number" name="harga[]" id="harga5" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[4]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk6" class="form-control produk" value="<?php echo set_value('produk[5]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp </span>
																		<input type="number" name="harga[]" id="harga6" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[5]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk7" class="form-control produk" value="<?php echo set_value('produk[6]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp </span>
																		<input type="number" name="harga[]" id="harga7" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[6]'); ?>" placeholder="Harga Produk" onkeypress="return input_angka(event)" pattern="\d*" max="2000000">
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
									  <!-- </div> -->
										<div class="panel-footer">
											<div class="row">
												<div class="col-md-6 col-sm-12">
												  <div class="form-group">
														<label for="metode_bayar" class="control-label col-sm-6 col-md-4">* Metode Bayar</label>
														<div class="col-sm-7 col-md-8">
															<div class="radio">
																<label>
																	<input type="radio" name="metode_bayar" value="0" <?php echo set_radio('metode_bayar', '0'); ?> class="radio_metode_bayar" required>
																	Reguler
																</label>
																<label>
																	<input type="radio" name="metode_bayar" value="1" <?php echo set_radio('metode_bayar', '1'); ?> class="radio_metode_bayar" required>
																	Go Pay
																</label>
															</div>
														</div>
												  </div>
												  <div class="form-group" id="nominal_go_pay_div" <?php if(set_value('nominal_go_pay') == 0): ?> style="display:none" <?php endif ?>>
														<style media="screen">
														input,img{ display:inline-block;}
														</style>
														<div class="col-sm-12 col-md-12">
															<div class="input-group">
																<span class="input-group-addon">
																	<img src="<?php echo base_url("assets/images/go-pay.png") ?>" alt="Go Pay" class="img" height="20px">
																</span>
																<input type="number" name="nominal_go_pay" id="nominal_go_pay" class="form-control kurangi-total" value="<?php echo set_value('nominal_go_pay') ?>" min="0" onkeypress="return input_angka(event)">
															</div>
														</div>
												  </div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="well well-sm text-center label-primary">
														<p><strong>Total Bayar Tunai</strong> </p>
														<input type="hidden" name="total_bayar_hidden" id="total_bayar_hidden" value="<?php echo set_value('total_bayar_hidden') ?>">
														<h1 id="total_bayar">
															<?php if (set_value('total_bayar_hidden')>0): echo "Rp ". number_format(set_value('total_bayar_hidden'), 0, ",", "."); ?>
															<?php else: ?>Rp 0
														<?php endif; ?></h1>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer text-center">
							<button type="submit" id="simpan" class="btn btn-success btn-lg" role="button">Simpan Data</button>
							<!-- Footer -->
						</div>
						<!-- /.box-footer-->
					</form>
					</div>
					<!-- /.box -->
				</div>
				<div class="col-md-6 col-sm-12">

				</div>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
