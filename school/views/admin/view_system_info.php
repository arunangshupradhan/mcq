<?php
$str = '[';
foreach ($currencies as $value) {
    $str .= "{value:" . $value->currency_id . ",text:'" . $value->currency_name . " (" . $value->currency_symbol . ")'},";
}
$str = substr($str, 0, -1);
$str .= "]";
?>

<div id="note">
    <?php 
    if ($message) {
        echo $message;    
    }
    ?>
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
</div>
<div class="block">  
    <div class="navbar block-inner block-header">
        <div class="row"><p class="text-muted">System Info </p></div>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-sm-12">
                <!--BEGIN TABS-->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Basic Info</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Content</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Social Profiles</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Support Info</a></li>
                    <li><a href="#tab_4" data-toggle="tab">PayUmoney Settings</a></li>
                </ul>
                <div class="tab-content info-display">

                    <div class="tab-pane" id="tab_5">
                    <?php //echo "<pre/>"; print_r($sys_content); 
                        foreach ($sys_content as $value) {
                            if ($value->content_type == 'wc_title') {
                                $title_id = $value->content_id;
                                $title = $value->content_data;
                            }
                            if ($value->content_type == 'wc_msg') {
                                $msg_id = $value->content_id;
                                $msg = $value->content_data;
                            }
                            if ($value->content_type == 'about_us') {
                                $about_id = $value->content_id;
                                $about = $value->content_data;
                            }
                            if ($value->content_type == 'price_table_msg') {
                                $price_tbl_id = $value->content_id;
                                $pricing_msg = $value->content_data;
                            }
                        }

                    ?>
                          <dl class="dl-horizontal">
                            <dt>Welcome Message Title: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="welcome_head" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_content'); ?>" data-pk="<?= $title_id ?>" class="data-modify-content no-style"><?= $title ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Welcome Message: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="welcome_message" data-type="textarea" data-rows="4" data-url="<?php echo base_url('index.php/admin/system_control/update_content'); ?>" data-pk="<?= $msg_id ?>" class="data-modify-content no-style"><?= $msg ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Pricing page heading: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="pricing_message" data-type="textarea" data-rows="4" data-url="<?php echo base_url('index.php/admin/system_control/update_content'); ?>" data-pk="<?= $price_tbl_id ?>" class="data-modify-content no-style"><?= $pricing_msg ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>About Us: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="about" data-type="textarea" data-rows="15" data-url="<?php echo base_url('index.php/admin/system_control/update_content'); ?>" data-pk="<?= $about_id ?>" class="data-modify-content no-style"><?= htmlspecialchars($about); ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                        </dl>
                         <hr/>
                        <?php if ($this->session->userdata['user_role_id'] == 1) { ?>
                            <div class="col-xs-10 col-xs-offset-1">
                                <a class="btn btn-info btn-block modify" name="modify-content" href = "#"><i class="glyphicon glyphicon-edit"></i> Modify</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="tab-pane" id="tab_4">
                        <dl class="dl-horizontal">
                            <dt>PayUmony Status: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="pp_sandbox" data-type="select" data-source="[{value:0,text:'Live'},{value:1,text:'Sandbox'}]" data-value="<?= (@$payment_set->sandbox) ? '1' : '0'; ?>" data-url="<?php echo base_url('index.php/admin/system_control/update_paypal_info'); ?>" data-pk="<?=($payment_set->id) ? $payment_set->id : 1; ?>" class="data-modify-pp no-style"><?= (@$payment_set->sandbox) ? 'Sandbox' : 'Live'; ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Currency: <br/><small><em>( INR )</em></small></dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="pp_currency" data-type="select" data-url="<?php echo base_url('index.php/admin/system_control/update_paypal_info'); ?>" data-pk="<?=($payment_set->id) ? $payment_set->id : 1; ?>" data-source="<?= $str; ?>" data-value="<?= @$payment_set->currency_id; ?>" class="data-modify-pp no-style"><?= @$payment_set->currency_name . ' (' . @$payment_set->currency_symbol . ')' ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Auth Header: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="pp_user" data-type="textarea" data-rows="2"  data-url="<?php echo base_url('index.php/admin/system_control/update_paypal_info'); ?>" data-pk="<?=($payment_set->id) ? $payment_set->id : 1; ?>" class="data-modify-pp no-style"><?= @$payment_set->api_username ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Merchant Key: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="pp_pass" data-type="text" data-url="<?php echo base_url('index.php/admin/system_control/update_paypal_info'); ?>" data-pk="<?=($payment_set->id) ? $payment_set->id : 1; ?>" class="data-modify-pp no-style"><?= @$payment_set->api_pass ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Merchant Salt: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="pp_sign" data-type="textarea" data-rows="3"  data-url="<?php echo base_url('index.php/admin/system_control/update_paypal_info'); ?>" data-pk="<?=($payment_set->id) ? $payment_set->id : 1; ?>" class="data-modify-pp no-style"><?= @$payment_set->api_signature ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                        </dl>
                        <hr/>
                        <?php if ($this->session->userdata['user_role_id'] == 1) { ?>
                            <div class="col-xs-10 col-xs-offset-1">
                                <a class="btn btn-info btn-block modify" name="modify-pp" href = "#"><i class="glyphicon glyphicon-edit"></i> Modify</a>
                            </div>
                        <?php } ?> 
                    </div>

                    <div class="tab-pane" id="tab_3">
                        <dl class="dl-horizontal">
                            <dt>Support Email: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="email" data-type="text" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-support no-style"><?= $sys_set->support_email ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Support Phone: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="phone" data-type="text" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-support no-style"><?= $sys_set->support_phone ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                        </dl>
                        <hr/>
                        <?php if ($this->session->userdata['user_role_id'] == 1) { ?>
                            <div class="col-xs-10 col-xs-offset-1">
                                <a class="btn btn-info btn-block modify" name="modify-support" href = "#"><i class="glyphicon glyphicon-edit"></i> Modify</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <dl class="dl-horizontal">
                            <dt>YouTube: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="youtube" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-social no-style"><?= $sys_set->you_tube_url ?></a>
                                        <a href="<?= $sys_set->you_tube_url ?>" target="_blank" class="btn btn-default btn-xs vitis-url"> Visit the link </a>
                                    </p>
                                    <iframe width="250" height="200" src="//www.youtube.com/embed/<?= $this->session->userdata('yt_url') ?>?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
                                </blockquote>
                            </dd>
                            <dt>Facebook: </dt>
                            <dd>
                                <blockquote>                            
                                    <p class="lead">
                                        <a href="#" data-name="facebook" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-social no-style"><?= $sys_set->facbook_url ?></a>
                                        <a href="<?= $sys_set->facbook_url ?>" target="_blank" class="btn btn-default btn-xs vitis-url"> Visit the link </a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Twitter: </dt>
                            <dd>
                                <blockquote>                            
                                    <p class="lead">
                                        <a href="#" data-name="twitter" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-social no-style"><?= $sys_set->twitter_url ?></a>
                                        <a href="<?= $sys_set->twitter_url ?>" target="_blank" class="btn btn-default btn-xs vitis-url"> Visit the link </a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Flickr: </dt>
                            <dd>
                                <blockquote>                            
                                    <p class="lead">
                                        <a href="#" data-name="flickr" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-social no-style"><?= $sys_set->flickr_url ?></a>
                                        <a href="<?= $sys_set->flickr_url ?>" target="_blank" class="btn btn-default btn-xs vitis-url"> Visit the link </a>
                                    </p>
                                </blockquote>
                            </dd>
                        </dl>
                        <hr/>
                        <?php if ($this->session->userdata['user_role_id'] == 1) { ?>
                            <div class="col-xs-10 col-xs-offset-1">
                                <a class="btn btn-info btn-block modify" id="rev-link" name="modify-social" href = "#"><i class="glyphicon glyphicon-edit"></i> Modify</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="tab-pane active" id="tab_1">
                        <dl class="dl-horizontal">
                            <dt>Brand Name: </dt>
                            <dd>
                                <blockquote>
                                    <p class="lead">
                                        <a href="#" data-name="brand_name" data-type="textarea" data-rows="2" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-basic-info no-style"><?= $sys_set->brand_name ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Slogan: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="slogan" data-type="textarea" data-rows="3" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= $sys_set->brand_id ?>" class="data-modify-basic-info no-style"><?= $sys_set->brand_slogan ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Bussiness Type: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="bussiness_type" data-type="select" data-source="[{value:0,text:'Non-commercial'},{value:1,text:'Commercial'}]" data-value="<?= (@$sys_set->commercial) ? '1' : '0'; ?>" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?=@$sys_set->brand_id; ?>" class="data-modify-basic-info no-style"><?= (@$sys_set->commercial) ? 'Commercial' : 'Non-commercial'; ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Display YouTube Video: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="show_video" data-type="select" data-source="[{value:0,text:'No'},{value:1,text:'Yes'}]" data-value="<?= (@$sys_set->show_video_on_home) ? '1' : '0'; ?>" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= @$sys_set->brand_id; ?>" class="data-modify-basic-info no-style"><?= (@$sys_set->show_video_on_home) ? 'Yes' : 'No'; ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                            <dt>Student Can Register: </dt>
                            <dd>
                                <blockquote>
                                    <p>
                                        <a href="#" data-name="can_register" data-type="select" data-source="[{value:0,text:'No'},{value:1,text:'Yes'}]" data-value="<?= (@$sys_set->student_can_register) ? '1' : '0'; ?>" data-url="<?php echo base_url('index.php/admin/system_control/update_system_info'); ?>" data-pk="<?= @$sys_set->brand_id; ?>" class="data-modify-basic-info no-style"><?= (@$sys_set->student_can_register) ? 'Yes' : 'No'; ?></a>
                                    </p>
                                </blockquote>
                            </dd>
                        </dl>
                        <hr/>
                        <?php if ($this->session->userdata['user_role_id'] == 1) { ?>
                            <div class="col-xs-10 col-xs-offset-1">
                                <a class="btn btn-info btn-block modify" name="modify-basic-info" href = "#"><i class="glyphicon glyphicon-edit"></i> Modify</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!--END TABS-->
            </div>
        </div>
    </div>
</div><!--/span-->