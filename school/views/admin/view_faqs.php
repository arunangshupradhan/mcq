<div id="note">
    <?php 
    if ($message) {
        echo $message; 
    }
    ?>
</div>

<div class="block">  
    <div class="navbar block-inner block-header">
        <div class="row">
            <p class="text-muted">FAQs 
                <?php if ($this->session->userdata['user_role_id'] < 3) { ?>
                    <a class="btn custom_navbar-btn btn-primary pull-right col-sm-3" href="<?php echo base_url('index.php/faq_control/faq_form'); ?>"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp; Add More FAQ </a>
                <?php } ?>
            </p>
        </div>
    </div>

    <div class="block-content">
        <div class="row">
            <div class="col-sm-12">

                <?php if (isset($faqs) != NULL) { ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th class="col-sm-1 mobile">Update</th>
                                <th class="col-sm-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($faqs as $faq) {
                                ?>
                                <tr class="<?= ($i & 1) ? 'even' : 'odd'; ?>">
                                    <td class="">
                                        <a href="#" data-name="faq_title" data-type="text" data-url="<?php echo base_url('index.php/faq_control/update_faq'); ?>" data-pk="<?= $faq->faq_id; ?>" class="data-modify-<?= $faq->faq_id; ?> no-style"><?= $faq->faq_ques; ?></a>
                                        <div class="collapse" id="collapse_<?= $faq->faq_id; ?>">
                                            <p class="faq-css"><span class="text-muted">Answer: </span> 
                                                <a href="#" data-name="faq_ans" data-type="textarea" data-url="<?php echo base_url('index.php/faq_control/update_faq'); ?>" data-pk="<?= $faq->faq_id; ?>" class="data-modify-<?= $faq->faq_id; ?> no-style"><?= $faq->faq_ans; ?></a>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="col-xs-1 mobile"><?= $faq->faq_last_update; ?></td>
                                    <td class="col-xs-3 text-center">
                                        <div class="btn-group">
                                            <a href="#collapse_<?= $faq->faq_id; ?>"  data-toggle="collapse" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-resize-small"></i><span class="invisible-on-sm"> View</span></a>
                                            <a class="btn btn-default btn-sm modify open-faq" name="modify-<?= $faq->faq_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                                            <?php if ($this->session->userdata['user_role_id'] <= 2) { ?>
                                                <a onclick="return delete_confirmation()" href = "<?php echo base_url('index.php/faq_control/delete_faq/' . $faq->faq_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Delete</span></a>
                                                    <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo 'No FAQ!';
                }
                ?>
            </div>
        </div>
    </div>
</div><!--/span-->
