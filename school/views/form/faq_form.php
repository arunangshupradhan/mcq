<?php 
if ($message) { 
    echo $message;
}
?>
<!-- block -->
<div class="block">
    <div class="navbar block-inner block-header">
        <div class="row"><p class="text-muted">Add New FAQs </p></div>
    </div>
    <div class="block-content">
    <form action="<?php echo base_url().'index.php/faq_control/add_faq'?>" method="post" id="ajax-form" role="form" class="form-horizontal">  
    <div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-offset-1 col-xs-10">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label for="cat_name" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Question: </label>
                <div class="col-lg-6 col-sm-8 col-xs-7 col-mb">
                    <?php echo form_input('faq_q', '', 'placeholder="FAQ Question" class="form-control" required="required"') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="cat_name" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile" style="padding-top: 50px;">Answer : </label>
                <div class="col-lg-6 col-sm-8 col-xs-7 col-mb">
                  <?php 
                    $data = array(
                        'name'        => 'faq_ans',
                        'placeholder' => 'FAQ Answer',
                        'value'       => '',
                        'rows'        => '4',
                        'class'       => 'form-control textarea-wysihtml5',
                        'required' => 'required',
                    ); ?>
                    <?php echo form_textarea($data) ?>
                </div>
            </div>
            <br/><hr/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-md-8">
                    <button type="submit" class="btn btn-primary col-xs-5 col-sm-3">Save and done</button>
                    <button type="submit" name="more" value="1" class="btn btn-info col-xs-5 col-sm-3 col-xs-offset-1">Save and continue</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</div>
<?=$this->load->view('plugin_scripts/bootstrap-wysihtml5');?>