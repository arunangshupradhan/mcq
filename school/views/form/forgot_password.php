<div class="container">
     <?php 
     if (isset($message) && $message != '') {
         echo $message;
     }
     ?>
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6 col-xs-12 box">
            <?php echo form_open(base_url('index.php/login_control/forgot_password'), 'role="form" class="form-horizontal"'); ?>
            <div class="row">
                <h3 class="text-center">Password recovery</h3>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="user_email" class="col-sm-2 control-label col-xs-offset-1 col-xs-2">Email:</label>
                    <div class="col-xs-8">
                        <?php echo form_input('email', '', 'pattern="^[a-zA-Z0-9.!#$%&'."'".'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="you@domain.com" placeholder="Put your email address" class="form-control" required="required"') ?>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Recover Password</button>
                </div>
            </div>
            <?php echo form_close() ?>
            <br/>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<br/><br/>