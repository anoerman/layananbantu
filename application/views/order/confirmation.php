	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Konfirmasi Penyelesaian Layanan Bantu
				<small>Detail pesanan #<?php echo $kode ?></small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-folder"></i> &nbsp; Pesanan</li>
				<li class="active">Konfirmasi</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php // Show message and ini val data
			echo $message;
			foreach ($data_header->result() as $data) {
				$toko            = ($data->last_name != "") ?
													$data->first_name." ".$data->last_name : $data->first_name;
				$tanggal         = $data->tanggal;
				$nama_konsumen   = $data->nama_konsumen;
				$hp_konsumen     = $data->hp_konsumen;
				$alamat_lokasi   = $data->alamat_lokasi;
				$status_id       = $data->status;
				$status          = $data->nama_status;
				$metode_pesan_id = $data->metode_pesan;
				$metode_pesan    = $data->nama_metode_pesan;
				$motor           = ($data->motor != "") ? $data->motor : "-";
				$nomor_polisi    = ($data->nomor_polisi != "") ? $data->nomor_polisi : "-";
				$jenis_velg_id   = $data->jenis_velg;
				$nama_jenis_velg = $data->nama_jenis_velg;
				$sumber_info     = ($data->sumber_info != "") ? $data->sumber_info : "-";
				$metode_bayar    = ($data->metode_bayar == 1) ? "Go Pay" : "Reguler";
				$go_pay_bayar    = ($data->metode_bayar == 1) ? $data->go_pay_bayar : 0;
				$total_bayar     = $data->total_bayar;
			}
			?>

			<div class="row">
				<form class="form" action="<?php echo base_url('order/konfirmasi/'.$kode); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
					<div class="col-md-12 col-sm-12">
						<!-- Default box -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">
									<strong>Toko : </strong><?php echo $toko; ?> &nbsp; [<?php echo $status ?>]
								</h3>

								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-horizontal">
										<div class="form-group">
											<label for="nama_konsumen" class="control-label col-sm-3"><i class="fa fa-calendar"></i> &nbsp; Tanggal & Jam</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo date_format(date_create($tanggal), 'd F Y (H:i:s)'); ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="nama_konsumen" class="control-label col-sm-3"><i class="fa fa-user"></i> &nbsp; Nama Konsumen</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $nama_konsumen ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="hp_konsumen" class="control-label col-sm-3"><i class="fa fa-phone"></i> &nbsp; No Handphone</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $hp_konsumen ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="alamat_lokasi" class="control-label col-sm-3"><i class="fa fa-map-marker"></i> &nbsp; Alamat Lokasi</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $alamat_lokasi ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="sumber_info" class="control-label col-sm-3"><i class="fa fa-question"></i> &nbsp; Sumber Info</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $sumber_info ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="metode_pesan" class="control-label col-sm-3"><i class="fa fa-bookmark"></i> &nbsp; Metode Pesan</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $metode_pesan ?></p>
											</div>
										</div>
										<!-- <hr> -->
										<legend>Info Kendaraan</legend>
										<div class="form-group">
											<label for="motor" class="control-label col-sm-3"><i class="fa fa-motorcycle"></i> &nbsp; Nama Motor</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $motor ?></p>
												<?php /* ?>
												<input type="text" name="motor" id="motor" class="form-control" value="<?php echo set_value('motor', $motor) ?>">
												<?php */ ?>
											</div>
										</div>
										<div class="form-group">
											<label for="nomor_polisi" class="control-label col-sm-3"><i class="fa fa-qrcode"></i> &nbsp; Nomor Polisi</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $nomor_polisi ?></p>
												<?php /* ?>
												<input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control" value="<?php echo set_value('nomor_polisi', $nomor_polisi) ?>">
												<?php */ ?>
											</div>
										</div>
										<div class="form-group">
											<label for="jenis_velg" class="control-label col-sm-3"><i class="fa fa-circle-o"></i> &nbsp; Jenis Velg</label>
											<div class="col-sm-9 col-md-8">
												<p class="form-control-static well well-sm"><?php echo $nama_jenis_velg ?></p>
											<?php /* foreach ($jenis_velg->result() as $jv): ?>
												<div class="radio">
													<label>
														<input type="radio" name="jenis_velg" value="<?php echo $jv->id ?>"
														<?php $checked = ($jv->id == $jenis_velg_id) ? TRUE : FALSE; echo set_radio('jenis_velg', $jv->id, $checked); ?> required>
														<?php echo $jv->nama; ?>
													</label>
												</div>
											<?php endforeach; */?>
											</div>
										</div>
										<!-- <div class="form-group">
											<label for="foto" class="control-label col-sm-3">Foto (tidak wajib)</label>
											<div class="col-sm-9 col-md-8">
												<input type="file" name="foto" id="foto" class="form-control" value="">
											</div>
										</div> -->
										<!-- <hr> -->
										<legend>Detail Pesanan</legend>
										<div class="panel panel-primary">
										  <div class="panel-heading">
										    <h3 class="panel-title">Produk dan Harga</h3>
										  </div>

											<div class="table-responsive">
												<table class="table table-hover table-striped table-bordered">
													<thead>
														<tr>
															<th>
																Produk & Harga
															</th>
															<!-- <th class="text-center">
																<button type="button" class="btn btn-primary" name="addNewRow"><span class="glyphicon glyphicon-plus"></span></button>
															</th> -->
														</tr>
													</thead>
													<tbody>
													<?php $idx = 0;
													foreach ($data_detail->result() as $detail): $idx++; ?>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																		<span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																		<input type="text" name="produk[]" id="produk<?php echo $idx; ?>" class="form-control produk" value="<?php echo $detail->produk; ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																		<span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga<?php echo $idx; ?>" class="form-control hitung-total" min="0" max="2500000" value="<?php echo $detail->harga; ?>" placeholder="Harga Produk">
																	</div>
																</div>
															</td>
														</tr>
													<?php endforeach; ?>
													<?php for ($i=$idx; $i < 7; $i++) { ?>
														<tr>
															<td>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	  <input type="text" name="produk[]" id="produk<?php echo $i; ?>" class="form-control produk" value="<?php echo set_value('produk[$i]'); ?>" placeholder="Tulis produk jika ada tambahan">
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="input-group">
																	  <span class="input-group-addon">Rp. </span>
																		<input type="number" name="harga[]" id="harga<?php echo $i; ?>" class="form-control hitung-total" min="0" max="2500000" value="<?php echo set_value('harga[$i]'); ?>" placeholder="Harga Produk">
																	</div>
																</div>
															</td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>

											<div class="panel-footer">
												<!-- Info Total Bayar dan potongan Go Pay -->
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<?php if ($go_pay_bayar!=0) : ?>
													  <div class="form-group">
															<style media="screen">
															input,img{ display:inline-block;}
															</style>
															<div class="col-sm-12 text-center">
																<h4>Metode Pembayaran : Go Pay.</h4>
																<p>Silahkan tagihkan ke konsumen jumlah total bayar berikut.<br>Total bayar sudah dikurangi oleh jumlah nominal Go Pay dibawah ini.</p>
																<div class="input-group">
																	<span class="input-group-addon">
																		<img src="<?php echo base_url("assets/images/go-pay.png") ?>" alt="Go Pay" class="img" height="20px">
																	</span>
																	<input type="number" name="nominal_go_pay2" class="form-control" value="<?php echo number_format($go_pay_bayar, '0', ',' , '.') ?>" min="0" readonly>
																	<input type="hidden" name="nominal_go_pay" id="nominal_go_pay" class="form-control kurangi-total" value="<?php echo $go_pay_bayar ?>" min="0" onkeypress="return input_angka(event)">
																</div>
															</div>
													  </div>
													<?php else: ?>
														<div class="form-group">
															<div class="col-md-12 text-center">
																<h4>Metode Pembayaran : Reguler.</h4>
																<p>Silahkan tagihkan ke konsumen jumlah total bayar berikut.</p>
															</div>
														</div>
													<?php endif; ?>
													</div>
													<div class="col-md-6 col-sm-12">
														<div class="well well-sm text-center label-primary">
															<p><strong>Total Bayar Tunai</strong> </p>
															<input type="hidden" name="total_bayar_hidden" id="total_bayar_hidden" value="<?php echo $total_bayar ?>">
															<h1 id="total_bayar">Rp <?php echo number_format(($total_bayar!="") ? $total_bayar : $total_bayar_organik, '0', ',' , '.'); ?></h1>
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
								<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal_proses_ubah_status">Layanan Bantu Selesai</button>
								<button type="submit" name="simpan" id="simpan" class="btn btn-lg btn-success hidden">Layanan Bantu Selesai</button>
								<!-- Footer -->
							</div>
							<!-- /.box-footer-->
						</div>
						<!-- /.box -->

						<!-- Modal konfirmasi -->
						<div class="modal fade" id="modal_proses_ubah_status" tabindex="-1" role="dialog" aria-labelledby="modal_proses_ubah_status" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="modal_proses_ubah_status_title">Konfirmasi</h4>
						      </div>
						      <div class="modal-body">
										<div class="form-group" id="petugas_fg">
										  <label for="petugas">* Nama Petugas</label>
										  <input type="text" class="form-control" name="petugas" id="petugas" placeholder="Nama petugas layanan bantu" required>
											<p class="help-block" id="petugas_hb"></p>
										</div>

										<div class="form-group">
											<label for="keterangan" class="control-label">Keterangan</label>
											<textarea name="keterangan" id="keterangan" rows="4" class="form-control" style="resize:vertical; min-height: 50px; max-height: 150px;" placeholder="Contoh : Nama motor yang sebenarnya adalah Motor XYZ."></textarea>
											<p class="help-block">Jika ada perbedaan data antara input CS dan aktual kendaraan, silahkan masukkan keterangan tambahan yang perlu diketahui.</p>
										</div>
										<hr>
										<p class="text-center">
											Status pesanan akan diubah menjadi 'Selesai'. <br>
											Pastikan semua input sudah sesuai dengan data aktual layanan bantu. <br>
											Proses layanan bantu ini?
										</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-danger" id="batal_btn" data-dismiss="modal">Batal</button>
						        <button type="button" class="btn btn-success" id="simpan_btn" onclick="proses_konfirmasi()">Ya, proses layanan bantu</a>
						      </div>
						    </div>
						  </div>
						</div>
						<!-- / Modal konfirmasi -->

					</div>
				</form>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
