  <!-- =========================== CONTENT =========================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo lang('edit_user_heading');?>
        <small><?php echo lang('edit_user_subheading');?></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('index_heading');?></a></li>
        <li class="active"><?php echo lang('edit_user_heading'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
          </h3>

          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <?php echo $message;?>

          <?php echo form_open(uri_string(), array('class' => 'form form-horizontal', 'autocomplete' => 'off', ));?>

            <div class="form-group">
              <?php echo lang('edit_user_fname_label', 'first_name', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($first_name);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_lname_label', 'last_name', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($last_name);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_phone_label', 'phone', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($phone);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_email_label', 'email', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($email);?>
              </div>
            </div>

            <hr>

            <div class="form-group">
              <?php echo lang('edit_user_password_label', 'password', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($password);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_password_confirm_label', 'password_confirm', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($password_confirm);?>
              </div>
            </div>

            <div class="form-group">
              <label for="cabang_id" class="control-label col-md-3">Cabang</label>
              <div class="col-md-7">
              <?php foreach ($cabang_list->result() as $cabang): ?>
                <div class="radio">
                  <label>
                  <?php
                    $checked = null;
                    if ($cabang->id == $current_cabang) {
                      $checked = ' checked="checked"';
                    }
                  ?>
                  <input type="radio" name="cabang_id" value="<?php echo $cabang->id;?>"<?php echo $checked;?> class="check_cabang">
                  <?php echo htmlspecialchars($cabang->nama,ENT_QUOTES,'UTF-8');?>
                  </label>
                </div>
              <?php endforeach; ?>
              </div>
            </div>

            <div class="form-group" id="div_regional">
							<label for="regional" class="control-label col-sm-3">Regional </label>
							<div class="col-sm-9 col-md-5" id="div_regional_select">
              <?php if (count($regional_list->result()) > 0) { ?>
                <select name="regional_id" id="regional_id" class="form-control select2" style="width:100%">
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

            <?php if ($this->ion_auth->is_admin()): ?>
              <hr>
              <h3 class="text-center"><?php echo lang('edit_user_groups_heading');?></h3>
              <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                <?php foreach ($groups as $group):?>
                  <div class="checkbox">
                    <label class="checkbox">
                    <?php
                        $gID=$group['id'];
                        $checked = null;
                        $item = null;
                        foreach($currentGroups as $grp) {
                            if ($gID == $grp->id) {
                                $checked= ' checked="checked"';
                            break;
                            }
                        }
                    ?>
                    <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                    <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                    </label>
                  </div>
                <?php endforeach?>
                </div>
              </div>

            <?php endif ?>

            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>

            <div class="form-group text-center">
              <hr>
              <?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn btn-primary'));?>
              <a href="<?php echo base_url('auth'); ?>" class="btn btn-danger">Batal</a>
            </div>

      <?php echo form_close();?>
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
