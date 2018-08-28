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
				$toko          = ($data->last_name != "") ?
													$data->first_name." ".$data->last_name : $data->first_name;
				$tanggal       = $data->tanggal;
				$nama_konsumen = $data->nama_konsumen;
				$hp_konsumen   = $data->hp_konsumen;
				$alamat_lokasi = $data->alamat_lokasi;
				$status_id     = $data->status;
				$status        = $data->nama_status;
				$motor         = $data->motor;
				$nomor_polisi  = $data->nomor_polisi;
				$foto          = $data->foto;
				$jenis_velg_id = $data->jenis_velg;
				$jenis_velg    = $data->nama_jenis_velg;
				$sumber_info   = $data->sumber_info;
				$cabang        = $data->cabang;
			}
			?>

			<div class="row">
				<div class="col-md-12 col-sm-12">

					<form class="form" action="<?php echo base_url('order/edit/'.$kode); ?>" method="post" enctype="multipart/form-data">

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
												<p class="form-control-static"><?php echo date_format(date_create($tanggal), 'd F Y (H:i:s)'); ?></p>
											</div>
										</div>
										<div class="form-group">
											<label for="nama_konsumen" class="control-label col-sm-3"><i class="fa fa-user"></i> &nbsp; Nama Konsumen</label>
											<div class="col-sm-9 col-md-5">
												<input type="text" name="nama_konsumen" class="form-control" value="<?php if (!set_value('nama_konsumen')) { echo $nama_konsumen; } else { echo set_value('nama_konsumen'); } ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="hp_konsumen" class="control-label col-sm-3"><i class="fa fa-phone"></i> &nbsp; No Handphone</label>
											<div class="col-sm-9 col-md-5">
												<input type="text" name="hp_konsumen" class="form-control" value="<?php if (!set_value('hp_konsumen')) { echo $hp_konsumen; } else { echo set_value('hp_konsumen'); } ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="alamat_lokasi" class="control-label col-sm-3"><i class="fa fa-map-marker"></i> &nbsp; Alamat Lokasi</label>
											<div class="col-sm-9 col-md-7">
												<textarea name="alamat_lokasi" class="form-control" style="resize:vertical; max-height:250px; min-height:100px;"><?php if (!set_value('alamat_lokasi')) { echo $alamat_lokasi; } else { echo set_value('alamat_lokasi'); } ?></textarea>
												<!-- <p class="form-control-static well well-sm"><?php echo $alamat_lokasi ?></p> -->
											</div>
										</div>
										<div class="form-group">
											<label for="sumber_info" class="control-label col-sm-3"><i class="fa fa-question"></i> &nbsp; Sumber Info</label>
											<div class="col-sm-9 col-md-5">
												<input type="text" name="sumber_info" id="sumber_info" class="form-control" value="<?php if (!set_value('sumber_info')) { echo $sumber_info; } else { echo set_value('sumber_info'); } ?>">
												<!-- <p class="form-control-static well well-sm"><?php echo $sumber_info ?></p> -->
											</div>
										</div>
										<div class="form-group">
											<label for="cabang" class="control-label col-sm-3">* Cabang</label>
											<div class="col-sm-9 col-md-7">
											<?php foreach ($cabang_list->result() as $cid): ?>
												<div class="radio">
													<label>
														<input type="radio" name="cabang" value="<?php echo $cid->id ?>" <?php if (!set_radio('cabang', $cid->id)) { echo ($cid->id == $cabang) ? "checked" : ""; } else {echo set_radio('cabang', $cid->id);} ?> class="check_cabang" required>
														<?php echo $cid->nama; ?>
													</label>
												</div>
											<?php endforeach; ?>
											</div>
										</div>
										<div class="form-group" id="div_regional">
											<label for="regional" class="control-label col-sm-3">Regional </label>
											<div class="col-sm-9 col-md-5" id="div_regional_select">
				              <?php if (count($regional_list->result()) > 0) { ?>
				                <select name="regional_id" id="regional_id" class="form-control select2" style="width:100%" onchange="tampilkan_toko_regional(this.value)">
				                  <option value="">- Pilih Regional -</option>
				                  <?php foreach ($regional_list->result() as $regional){ ?>
				                    <option value="<?php echo $regional->id ?>" <?php echo ($regional->id == $current_regional) ? "selected" : ""; ?>><?php echo $regional->nama ?></option>
				                  <?php } ?>
				                </select>
				              <?php } else { ?>
				                <p class="form-control-static text-danger">Tidak ada regional dalam cabang ini!</p>
				                <input type="hidden" name="regional_id" id="regional_id" value="" >
				              <?php } ?>
											</div>
										</div>
										<div class="form-group" id="div_toko">
											<label for="toko" class="control-label col-sm-3">* Toko</label>
											<div class="col-sm-9 col-md-5" id="div_toko_select">
												<select name="toko" id="toko" class="form-control select2" style="width:100%">
													<option value="<?php echo $current_toko; ?>" selected><?php echo $toko; ?></option>
												<?php foreach ($toko_list->result() as $tk): ?>
													<option value="<?php echo $tk->username; ?>" <?php echo set_select('toko', $tk->username); ?>><?php echo $tk->first_name . " " . $tk->last_name; ?></option>
												<?php endforeach; ?>
													<option value="">Pesanan Terbuka</option>
												</select>
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
											<label for="motor" class="control-label col-sm-3"><i class="fa fa-motorcycle"></i> &nbsp; Nama Motor</label>
											<div class="col-sm-9 col-md-5">
												<input type="text" name="motor" id="motor" class="form-control" value="<?php if (!set_value('motor')) { echo $motor; } else { echo set_value('motor'); } ?>">
												<!-- <p class="form-control-static well well-sm"><?php echo $motor ?></p> -->
											</div>
										</div>
										<div class="form-group">
											<label for="nomor_polisi" class="control-label col-sm-3"><i class="fa fa-barcode"></i> &nbsp; Nomor Polisi</label>
											<div class="col-sm-9 col-md-3">
												<input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control" value="<?php if (!set_value('nomor_polisi')) { echo $nomor_polisi; } else { echo set_value('nomor_polisi'); } ?>">
												<!-- <p class="form-control-static well well-sm"><?php echo $nomor_polisi ?></p> -->
											</div>
										</div>
										<div class="form-group">
											<label for="jenis_velg" class="control-label col-sm-3"><i class="fa fa-circle-o"></i> &nbsp; Jenis Velg</label>
											<div class="col-sm-9 col-md-7">
												<?php foreach ($jenis_velg_list->result() as $jv): ?>
													<div class="radio">
														<label>
															<input type="radio" name="jenis_velg" value="<?php echo $jv->id ?>" <?php if (!set_radio('jenis_velg', $jv->id)) { echo ($jv->id == $jenis_velg_id) ? "checked" : ""; } else { echo set_radio('jenis_velg', $jv->id); } ?> required>
															<?php echo $jv->nama; ?>
														</label>
													</div>
												<?php endforeach; ?>
												<!-- <p class="form-control-static well well-sm"><?php echo $jenis_velg ?></p> -->
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
										<!-- <hr> -->
										<legend>Detail Pesanan</legend>
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
																	<input type="number" name="harga[]" id="harga<?php echo $idx; ?>" class="form-control" min="0" max="2500000" value="<?php echo $detail->harga; ?>" placeholder="Harga Produk">
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
												<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer text-center">
							<?php if (!$this->ion_auth->in_group('toko')): ?>
								<?php if ($status_id < 6): ?>
									<!-- Tampilkan modal -->
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Simpan Perubahan</button>
									<a href="<?php echo base_url('order/data_list'); ?>" class="btn btn-primary">Kembali</a>
								<?php else: ?>
									<a href="<?php echo base_url('order/data_list'); ?>" class="btn btn-primary">Kembali</a>
								<?php endif; ?>
							<?php endif; ?>
								<!-- Footer -->
							</div>
							<!-- /.box-footer-->
						</div>
						<!-- /.box -->

						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Ubah Data?</h4>
						      </div>
						      <div class="modal-body">
										<p>Harap diisikan alasan perubahan data order layanan bantu ini untuk melanjutkan proses.</p>
										<textarea name="keterangan_ubah" rows="4" class="form-control" style="resize:vertical; min-height: 50px; max-height: 150px;" required></textarea>
										<hr>
										<p>Pastikan semua data terisi dengan benar!</p>
						      </div>
						      <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
										<button type="submit" class="btn btn-primary">Simpan perubahan</button>
						      </div>
						    </div>
						  </div>
						</div>
						<!-- / Modal -->

					</form>

				</div>
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
