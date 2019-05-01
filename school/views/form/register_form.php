<div class="container">
    <?php 
    if (isset($message) && $message != '') {
        echo $message;
    }
    ?>
    <div class="row">
        <div class="col-sm-4 col-xs-8 col-sm-offset-4 col-xs-offset-2 box">
            <?php echo form_open(base_url('index.php/login_control/register'), 'role="form" class="form-horizontal"'); ?>
            <?=form_hidden('token', time()); ?>
            <div class="row text-center" style="margin-bottom:20px;">
                <h4>Register</h4>
            </div>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                      <?php echo form_input('user_name', '', 'id="user_name" placeholder="User Name *" class="form-control" required="required"') ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                      <?php echo form_input('user_email', '', 'id="user_email" type="email" pattern="^[a-zA-Z0-9.!#$%&'."'".'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="you@domain.com" placeholder="Email address *" class="form-control" required="required"') ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                      <?php echo form_input('user_phone', '', 'id="user_phone" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" title="Enter Valid Phone Number" min="8" max="15" placeholder="Phone Number" class="form-control"') ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                      <?php echo form_password('user_pass', '', 'id="user_pass" placeholder="Password (Minimum 6 character) *" class="form-control" required="required"') ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                      <?php echo form_password('user_passcf', '', 'id="user_passcf" placeholder="Confirm Password *" class="form-control" required="required"') ?>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                      <p class="text-muted">* Required fields.</p>
                      <i class="glyphicon glyphicon-bell"> </i> Have an account? <a href="<?php echo base_url('index.php/login_control'); ?>"> Login</a>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Register</button>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <button type="reset" class="btn btn-default btn-sm btn-lg pull-right">Reset</button>
                </div>
            </div>
            <?php echo form_close() ?>
            <br/>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<br/><br/>