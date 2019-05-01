<div class="container">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 col-xs-12 box">
            <?php echo form_open(base_url('index.php/login_control/reset_password'), 'role="form" class="form-horizontal"'); ?>
            <?=form_hidden('key', $key);?>
            <?=form_hidden('mail', $mail);?>
            <div class="row">
                <h3 class="text-center">Reset Password</h3>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                  <label for="user_pass" class="col-sm-3 control-label col-xs-offset-1 col-xs-2">New Password: </label>
                  <div class="col-xs-7">
                      <?php echo form_password('user_pass', '', 'placeholder="New Password (Minimum 6 character)" class="form-control" required="required"') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="user_passcf" class="col-sm-3 control-label col-xs-offset-1 col-xs-2">Confirm New Pass.: </label>
                  <div class="col-xs-7">
                      <?php echo form_password('user_passcf', '', 'placeholder="Confirm New Password" class="form-control" required="required"') ?>
                  </div>
                </div>
            </div><br/><hr/>
            <div class="row">
                <div class="col-xs-offset-1 col-sm-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary btn-lg col-xs-8">Reset</button>&nbsp;
                </div>
            </div>
            <?php echo form_close() ?>
            <br/>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<br/><br/>