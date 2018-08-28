	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Cabang
				<small>Data cabang</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-globe"></i> &nbsp; Cabang</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Category Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah Cabang
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('cabang/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal">
							<?php foreach ($data_list->result() as $data){
								$curr_name = $data->nama;
							} ?>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Nama</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="nama" id="nama" class="form-control" value="<?php echo $curr_name ?>" placeholder="Nama Cabang" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Simpan perubahan data ini?')">Simpan</button>
									<a class="btn btn-danger" href="<?php echo base_url('cabang'); ?>" role="button">Batal</a>
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
