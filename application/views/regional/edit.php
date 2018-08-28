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

			<!-- Update Category Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah Regional
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('regional/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal">
							<?php foreach ($data_list->result() as $data){
								$curr_name      = $data->nama;
								$curr_cabang_id = $data->cabang_id;
							} ?>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Nama</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="nama" id="nama" class="form-control" value="<?php echo $curr_name ?>" placeholder="Nama Regional" required>
								</div>
							</div>
							<div class="form-group">
							  <label for="cabang_id" class="control-label col-md-2">Cabang</label>
								<div class="col-md-8 <?php if (form_error('cabang_id')) {echo "has-error";} ?>">
									<select class="form-control" name="cabang_id" id="cabang_id">
										<?php foreach ($cabang_list->result() as $dcl): ?>
											<option value="<?php echo $dcl->id ?>" <?php if (set_select('cabang_id', $dcl->id)) { echo set_select('cabang_id', $dcl->id); } else { echo ($dcl->id == $curr_cabang_id) ? "checked" : ""; } ?>><?php echo $dcl->nama; ?></option>
										<?php endforeach; ?>
									</select>
									<p class="help-block">Pilih cabang dari regional ini.</p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Simpan perubahan data ini?')">Simpan</button>
									<a class="btn btn-danger" href="<?php echo base_url('regional'); ?>" role="button">Batal</a>
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

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
