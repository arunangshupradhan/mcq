<!-- Popup Login-->
<div id="login" class="well my-popup" style="max-width:44em;">
    <h4>Login</h4>
        <?php echo form_open(base_url('index.php/login_control') ,'role="form" class="form-horizontal"'); ?>
          <div class="popup-form">
            <div class="col-xs-12">
                <?php echo form_input('user_email', '', 'placeholder="Email address" class="form-control input" required="required"') ?>
            </div>
            <div class="col-xs-12">
                <?php echo form_password('user_pass', '', 'placeholder="Password" class="form-control input" required="required"') ?>
            </div>
          </div>
          <div class=" col-xs-12">
            <?php echo form_submit('submit', 'Login', 'class="btn btn-warning btn-block"') ?>  
          </div>
          <div class=" col-xs-12 popup-bottom">
            <button type="reset" class=" btn btn-sm btn-default">Reset</button>
            <button class="login_close btn btn-sm btn-default pull-right">Close</button>
          </div>
        <?php echo form_close() ?>
</div>

<!-- Popup Register-->
<div id="register" class="well my-popup" style="max-width:44em;">
    <h4>Register</h4>
        <?php echo form_open(base_url('index.php/login_control/register') ,'role="form" class="form-horizontal"'); ?>
          <?=form_hidden('token', time()); ?>
          <div class="popup-form">
            <div class="col-xs-12">
                <?php echo form_input('user_name', '', 'placeholder="User Name *" class="form-control" required="required"') ?>
            </div>
            <div class="col-xs-12">
                <?php echo form_input('user_email', '', 'pattern="^[a-zA-Z0-9.!#$%&'."'".'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="you@domain.com" placeholder="Email address *" class="form-control" required="required"') ?>
            </div>
            <div class="col-xs-12">
                <?php echo form_input('user_phone', '', 'pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" title="Enter Valid Phone Number" min="8" max="15" placeholder="Phone Number" class="form-control"') ?>
            </div>
            <div class="col-xs-12">
                <?php echo form_password('user_pass', '', 'placeholder="Password (Minimum 6 character) *" class="form-control" required="required"') ?>
            </div>
            <div class="col-xs-12">
                <?php echo form_password('user_passcf', '', 'placeholder="Confirm Password *" class="form-control" required="required"') ?>
            </div>
            <div class="col-xs-12">
                <p class="text-muted">* Required fields.</p>
            </div>
          </div>
          <div class=" col-xs-12">
            <?php echo form_submit('submit', 'Register', 'class="btn btn-warning btn-block"') ?>  
          </div>
          <div class=" col-xs-12 popup-bottom">
            <button type="reset" class=" btn btn-sm btn-default">Reset</button>
            <button class="register_close btn btn-sm btn-default pull-right">Close</button>
          </div>
        <?php echo form_close() ?>
</div>