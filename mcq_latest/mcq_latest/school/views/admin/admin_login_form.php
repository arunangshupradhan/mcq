<div class="container">
    <div class="row">
        <div class="col-sm-4 col-xs-8 col-sm-offset-4 col-xs-offset-2 box">
            <?php echo form_open(base_url('index.php/admin'), 'role="form" class="form-horizontal"'); ?>
            <div class="row text-center" style="margin-bottom:10px;">
                <h4>Admin Login</h4>
            </div>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    <?php  if (isset($message) && $message != '')  echo $message;  ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                <?php
                $option = array();
                $option[0] = 'Select User Role';
                foreach ($user_role as $value) {
                    if ($value->user_role_id == 1) {
                        $option[$value->user_role_id] = $value->user_role_name;
                    }
                }
                ?>
                    <?php echo form_dropdown('user_role', $option, '', 'class="form-control"') ?>
                </div><br/><br/><br/>
                <div class="col-xs-offset-1 col-xs-10">
                        <?php echo form_input('user_email', '', 'id="user_email" type="email" pattern="^[a-zA-Z0-9.!#$%&'."'".'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="you@domain.com" placeholder="Email address" class="form-control" required="required"') ?>
                </div>
                <div class="col-xs-offset-1 col-xs-10">
                        <?php echo form_password('user_pass', '', 'id="user_pass" placeholder="Password" class="form-control" required="required"') ?>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <i class="glyphicon glyphicon-question-sign"> </i> <a href="<?php echo base_url('index.php/login_control/password_recovery_form'); ?>"> Forgot Password.</a>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Login</button>
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