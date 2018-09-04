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
				$jenis_velg    = $data->nama_jenis_velg;
				$sumber_info   = ($data->sumber_info != "") ? $data->sumber_info : "-";
				$petugas       = ($data->petugas != "") ? $data->petugas : "-";
				$keterangan    = ($data->keterangan != "") ? $data->keterangan : "-";

				// Format hp konsumen
				if ($this->ion_auth->in_group('toko')) {
					if (strlen($hp_konsumen) > 7) {
						$hp_konsumen = substr($hp_konsumen, 0, -4) . "xxxx";
					}
				}
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
										<label for="nama_cs" class="control-label col-sm-3"><i class="glyphicon glyphicon-headphones"></i> &nbsp; Customer Service</label>
										<div class="col-sm-9 col-md-8">
											<p class="form-control-static well well-sm"><?php echo $nama_cs ?></p>
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
									<div class="table-responsive">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>
														Produk & Harga
													</th>
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
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer text-center">
							<a href="<?php echo base_url('order/completed'); ?>" class="btn btn-lg btn-primary">Kembali</a>
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
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
					        <a href="#" id="url_proses_container" class="btn btn-primary">Ya, proses layanan bantu sekarang.</a>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- / Modal konfirmasi -->

				</div>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
