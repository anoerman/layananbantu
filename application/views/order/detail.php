	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Pesanan
				<small>Detail pesanan #<?php echo $kode ?></small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-folder"></i> &nbsp; Pesanan</li>
				<li class="active">Detail</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php // Show message and ini val data
			echo $message;
			foreach ($data_header->result() as $data) {
				$nama_cs       = ($data->cs_ln != "") ?
													$data->cs_fn." ".$data->cs_ln : $data->cs_fn;
				$toko          = ($data->last_name != "") ?
													$data->first_name." ".$data->last_name : $data->first_name;
				$tanggal       = $data->tanggal;
				$nama_konsumen = $data->nama_konsumen;
				$hp_konsumen   = $data->hp_konsumen;
				$alamat_lokasi = $data->alamat_lokasi;
				$status_id     = $data->status;
				$status        = $data->nama_status;
				$motor         = ($data->motor != "") ? $data->motor : "-";
				$nomor_polisi  = ($data->nomor_polisi != "") ? $data->nomor_polisi : "-";
				$foto          = $data->foto;
				$metode_pesan  = $data->nama_metode_pesan;
				$jenis_velg    = $data->nama_jenis_velg;
				$nama_cabang   = $data->nama_cabang;
				$nama_regional = $data->nama_regional;
				$sumber_info   = ($data->sumber_info != "") ? $data->sumber_info : "-";
				$petugas       = ($data->petugas != "") ? $data->petugas : "-";
				$keterangan    = ($data->keterangan != "") ? $data->keterangan : "-";
				$metode_bayar  = ($data->metode_bayar == 1) ? "Go Pay" : "Reguler";
				$go_pay_bayar  = ($data->metode_bayar == 1) ? $data->go_pay_bayar : 0;
				$total_bayar   = $data->total_bayar;
			}
			?>

			<div class="row">
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
									<div class="form-group">
										<label for="nama_cs" class="control-label col-sm-3"><i class="glyphicon glyphicon-headphones"></i> &nbsp; Customer Service</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $nama_cs ?></p>
										</div>
									</div>
									<div class="form-group">
										<label for="nama_cabang" class="control-label col-sm-3"><i class="glyphicon glyphicon-globe"></i> &nbsp; Cabang & Regional</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $nama_cabang ?>, <?php echo $nama_regional ?></p>
										</div>
									</div>
									<!-- <hr> -->
									<legend>Info Kendaraan</legend>
									<div class="form-group">
										<label for="motor" class="control-label col-sm-3"><i class="fa fa-motorcycle"></i> &nbsp; Nama Motor</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $motor ?></p>
										</div>
									</div>
									<div class="form-group">
										<label for="nomor_polisi" class="control-label col-sm-3"><i class="fa fa-barcode"></i> &nbsp; Nomor Polisi</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $nomor_polisi ?></p>
										</div>
									</div>
									<div class="form-group">
										<label for="jenis_velg" class="control-label col-sm-3"><i class="fa fa-circle-o"></i> &nbsp; Jenis Velg</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $jenis_velg ?></p>
										</div>
									</div>
									<?php if ($foto!=""): ?>
									<div class="form-group">
										<label for="foto" class="control-label col-sm-3"><i class="fa fa-photo"></i> &nbsp; Foto</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm">
												<img src="<?php echo base_url("assets/uploads/images/konfirmasi/".$foto); ?>" alt="Foto">
											</p>
										</div>
									</div>
									<?php endif; ?>
									<legend>Info Layanan</legend>
									<div class="form-group">
										<label for="petugas" class="control-label col-sm-3"><i class="fa fa-user"></i> &nbsp; Petugas Layanan</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm">
												<?php echo $petugas ?>
											</p>
										</div>
									</div>
									<?php if ($keterangan!=""): ?>
									<div class="form-group">
										<label for="keterangan" class="control-label col-sm-3"><i class="fa fa-list-alt"></i> &nbsp; Keterangan</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm">
												<?php echo $keterangan ?>
											</p>
										</div>
									</div>
									<?php endif; ?>
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
															<!-- Produk & Harga -->
														</th>
														<!-- <th class="text-center">
															<button type="button" class="btn btn-primary" name="addNewRow"><span class="glyphicon glyphicon-plus"></span></button>
														</th> -->
													</tr>
												</thead>
												<tbody>
													<?php $idx           = 0;
													$total_bayar_organik = 0;
													foreach ($data_detail->result() as $detail): $idx++;
														$total_bayar_organik = $total_bayar_organik + $detail->harga;
													?>
													<tr>
														<td>
															<div class="col-md-6 col-sm-12">
																<div class="input-group">
																	<span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
																	<input type="text" name="produk[]" id="produk<?php echo $idx; ?>" class="form-control produk" value="<?php echo $detail->produk; ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )" readonly>
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="input-group">
																	<span class="input-group-addon">Rp. </span>
																	<input type="number" name="harga[]" id="harga<?php echo $idx; ?>" class="form-control" min="0" max="2500000" value="<?php echo number_format($detail->harga, '0', ',' , '.'); ?>" placeholder="Harga Produk" readonly>
																</div>
															</div>
														</td>
													</tr>
												<?php endforeach; ?>
												<?php /*for ($i=$idx; $i < 7; $i++) { ?>
													<tr>
													<td>
													<div class="col-md-6 col-sm-12">
													<div class="input-group">
													<span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp;</span>
													<input type="text" name="produk[]" id="produk<?php echo $i; ?>" class="form-control produk" value="<?php echo set_value('produk[$i]'); ?>" placeholder="Nama Produk ( Cth : Tambal ban / Planeto Silica )">
													</div>
													</div>
													<div class="col-md-6 col-sm-12">
													<div class="input-group">
													<span class="input-group-addon">Rp. </span>
													<input type="number" name="harga[]" id="harga<?php echo $i; ?>" class="form-control" min="0" max="2500000" value="<?php echo set_value('harga[$i]'); ?>" placeholder="Harga Produk">
													</div>
													</div>
													</td>
													</tr>
													<?php }*/ ?>
												</tbody>
											</table>
										</div>

										<div class="panel-footer">
											<!-- Info Total Bayar dan potongan Go Pay -->
											<div class="row">
												<div class="col-md-6 col-sm-12">
												  <!-- <div class="form-group">
														<label for="metode_bayar" class="control-label col-sm-6 col-md-4">Metode Bayar</label>
														<div class="col-sm-7 col-md-8">
															<p class="form-control-static"><?php echo $metode_bayar ?></p>
														</div>
												  </div> -->
													<?php if ($go_pay_bayar!=0) : ?>
												  <div class="form-group">
														<style media="screen">
														input,img{ display:inline-block;}
														</style>
														<div class="col-sm-12 text-center">
															<h4>Metode Pembayaran : Go Pay.</h4>
															<p>Silahkan tagihkan ke konsumen jumlah total tagihan sebagai berikut.<br>Total tagihan sudah dikurangi oleh jumlah nominal Go Pay dibawah ini.</p>
															<div class="input-group">
																<span class="input-group-addon">
																	<img src="<?php echo base_url("assets/images/go-pay.png") ?>" alt="Go Pay" class="img" height="20px">
																</span>
																<input type="number" name="nominal_go_pay" class="form-control" value="<?php echo number_format($go_pay_bayar, '0', ',' , '.') ?>" min="0" readonly>
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
														<p><strong>Total Tagih Tunai</strong> </p>
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
						<?php if ($this->ion_auth->in_group('toko')): ?>
							<?php if ($status_id==1): ?>
								<button type="button" class="btn btn-success btn-lg" value="Berangkat ke lokasi" onclick="modal_ubah_status(this.value)">Berangkat ke lokasi</button>
								<input type="hidden" id="url_proses" value="<?php echo base_url('order/proses/'.$kode); ?>">
								<input type="hidden" id="info_proses" value="Status akan diubah menjadi 'Berangkat ke lokasi'">
							<?php elseif ($status_id==3): ?>
								<button type="button" class="btn btn-success btn-lg" value="Sampai di lokasi" onclick="modal_ubah_status(this.value)">Sampai di lokasi</button>
								<input type="hidden" id="url_proses" value="<?php echo base_url('order/proses/'.$kode); ?>">
								<input type="hidden" id="info_proses" value="Status akan diubah menjadi 'Sampai di lokasi'">
							<?php elseif ($status_id==4): ?>
								<a href="<?php echo base_url('order/konfirmasi/'.$kode); ?>" class="btn btn-lg btn-success">Konfirmasi Selesai</a>
							<?php endif; ?>
						<?php else: ?>
							<?php if ($status_id>=6): ?>
								<!-- <a href="<?php echo base_url('order/history'); ?>" class="btn btn-lg btn-primary">Kembali</a> -->
							<?php elseif ($status_id < 6): ?>
								<input type="hidden" id="url_proses" value="<?php echo base_url('order/batal/'.$kode); ?>">
								<div class="btn-group">
									<button type="button" class="btn btn-danger" value="<?php echo $kode; ?>" onclick="modal_proses_batal(this.value)">Batalkan Layanan Bantu</button>
									<a href="<?php echo base_url('order/data_list'); ?>" class="btn btn-primary">Kembali</a>
								</div>
							<?php else: ?>
								<a href="<?php echo base_url('order/data_list'); ?>" class="btn btn-primary">Kembali</a>
							<?php endif; ?>
						<?php endif; ?>
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
									<p id="info_proses_container"></p>
									<!-- <p>Status order akan berubah dan jam perubahan status akan dicatat oleh sistem.</p> -->
									<p>Proses layanan bantu ini?</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
					        <a href="#" id="url_proses_container" class="btn btn-primary">Ya, proses layanan bantu sekarang.</a>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- / Modal konfirmasi -->

					<!-- Modal pembatalan order -->
					<div class="modal fade" id="modal_proses_batal" tabindex="-1" role="dialog" aria-labelledby="modal_proses_batal" aria-hidden="true">
					  <div class="modal-dialog">
							<form class="form" action="<?php echo base_url('order/batal/'.$kode); ?>" method="post">
								<div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="">Batalkan layanan bantu?</h4>
						      </div>
						      <div class="modal-body">
										<p>Harap diisikan alasan pembatalan untuk melanjutkan proses.</p>
										<textarea name="keterangan_batal" rows="4" class="form-control" style="resize:vertical; min-height: 50px; max-height: 150px;" required></textarea>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
						        <button type="submit" class="btn btn-primary">Batalkan order</button>
						      </div>
						    </div>
							</form>
					  </div>
					</div>
					<!-- / Modal pembatalan order -->

				</div>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
