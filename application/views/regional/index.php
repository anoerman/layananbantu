	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Regional
				<small>Data regional</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-marker"></i> &nbsp; Regional</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $message;?>

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Regional
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>
					</div>
				</div>
				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('regional/add') ?>" method="post" autocomplete="off" class="form form-horizontal">
							<div class="form-group">
								<label for="nama" class="control-label col-md-2">* Nama Regional</label>
								<div class="col-md-8 <?php if (form_error('nama')) {echo "has-error";} ?>">
									<input type="text" name="nama" id="nama" class="form-control" value="<?php echo set_value('nama'); ?>" placeholder="Nama Regional" required>
								</div>
							</div>
							<div class="form-group">
							  <label for="cabang_id" class="control-label col-md-2">Cabang</label>
								<div class="col-md-8 <?php if (form_error('cabang_id')) {echo "has-error";} ?>">
									<select class="form-control" name="cabang_id" id="cabang_id">
										<?php foreach ($cabang_list->result() as $dcl): ?>
											<option value="<?php echo $dcl->id ?>" <?php echo set_select('cabang_id', $dcl->id); ?>><?php echo $dcl->nama; ?></option>
										<?php endforeach; ?>
									</select>
									<p class="help-block">Pilih cabang dari regional ini.</p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Simpan data regional ini?')">Simpan</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
								  <p class="help-block">(*) Harus diisi</p>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Daftar regional
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Regional</th>
									<th>Cabang</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($data_list->result())>0): ?>
								<?php foreach ($data_list->result() as $data): ?>
								<tr>
									<td><?php echo $data->nama; ?></td>
									<td><?php echo $data->nama_cabang ?></td>
									<td width="15%">
										<form action="<?php echo base_url('regional/delete/'.$data->id) ?>" method="post" autocomplete="off">
											<div class="btn-group-vertical">
												<a class="btn btn-sm btn-primary" href="<?php echo base_url('regional/edit/'.$data->id) ?>" role="button"><i class="fa fa-pencil"></i> Ubah</a>
												<input type="hidden" name="id" value="<?php echo $data->id; ?>">
												<button type="submit" class="btn btn-sm btn-danger" role="button" onclick="return confirm('Hapus data ini?')"><i class="fa fa-trash"></i> Hapus</button>
											</div>
										</form>
									</td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="3">Tidak ada data regional terdaftar!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<?php echo $pagination; ?>
					<?php //echo $last_query ?>&nbsp;
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
