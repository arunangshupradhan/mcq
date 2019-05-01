<div class="container">
    <?php 
    if (isset($message) && $message != '') {
        echo $message;
    }
    ?>
    <div class="row">
        <div class="col-sm-4 col-xs-8 col-sm-offset-4 col-xs-offset-2 box">
            <?php echo form_open(base_url('index.php/login_control'), 'role="form" class="form-horizontal"'); ?>
            <div class="row text-center" style="margin-bottom:20px;">
                <h4>Login</h4>
            </div>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>
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
                        <?php if ($this->session->userdata('student_can_register')){  ?>
                     New user? <a href="<?php echo base_url('index.php/login_control/register'); ?>"> Register</a> from here.
                     <?php } ?>
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
<br/><br/>