	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('index_heading');?>
				<small><?php echo lang('index_subheading');?></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-users"></i> <?php echo lang('index_heading');?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-primary" href="<?php echo base_url('auth/create_user') ?>" role="button"><?php echo lang('index_create_user_link') ?></a>
							<a class="btn btn-default" href="<?php echo base_url('auth/create_group') ?>" role="button"><?php echo lang('index_create_group_link') ?></a>
						</div>
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<!-- <div class="table-responsive"> -->
						<table class="table table-bordered table-striped" id="datatables">
							<thead>
								<tr>
									<th>Name</th>
									<th><?php echo lang('index_groups_th');?></th>
									<th><?php echo lang('index_status_th');?> & <?php echo lang('index_action_th');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user):?>
								<tr>
			            <td>
										<div class="col-md-4 col-sm-12">
											<?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?> <?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?>
										</div>
										<div class="col-md-4 col-sm-12">
											<?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?>
										</div>
										<div class="col-md-4 col-sm-12">
											Cabang : <?php echo htmlspecialchars($cabang_model->get_cabang($user->cabang_id)->row()->nama,ENT_QUOTES,'UTF-8');?>
											<br>
											Regional : <?php echo htmlspecialchars($regional_model->get_regional($user->regional_id)->row()->nama,ENT_QUOTES,'UTF-8');?>
										</div>
									</td>
									<td>
										<div class="btn-group-vertical btn-group-sm">
										<?php foreach ($user->groups as $group):?>
											<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'), array('class' => 'btn btn-success')) ;?>
		                <?php endforeach?>
										</div>
									</td>
									<td>
										<div class="btn-group-vertical btn-group-sm">
											<?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), array('class' => 'btn btn-sm btn-danger')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'), array('class' => 'btn btn-sm btn-success'));?>
											<?php echo anchor("auth/edit_user/".$user->id, 'Edit', array('class' => 'btn btn-sm btn-primary')) ;?>
										</div>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<!-- </div> -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
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
