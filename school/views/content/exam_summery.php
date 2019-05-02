<?php 
    $user_info = $this->db->get_where('users', array('user_id' => $this->session->userdata('user_id')))->row();
?>

<div class="container">
    <div id="note">
    <?php 
    if ($message) {
        echo $message;    
    }
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');     
    }
    ?>
    </div>
    <ol class="breadcrumb hidden-print">
        <li><a href="<?= base_url('index.php/dashboard/' . $this->session->userdata('user_id')); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?= base_url('index.php/exam_control/view_all_mocks') ?>"><i class="fa fa-puzzle-piece"></i> Exams</a></li> 
        <li class="active">Exam Summery</li>
    </ol>
</div>
<div class="container">
    <div class="col-md-12">
        <h4><span class="text-muted">Exam Title: </span> <?= $mock->title_name ?></h4>
    </div>
</div>
<div class="container">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">Exam Summery:</div>        
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt class="text-muted">Title:</dt>
                    <dd><strong><?= $mock->title_name ?></strong></dd>
                    <dt class="text-muted">Category: </dt>
                    <dd><strong><?= $mock->category_name ?></strong></dd>
                    <dt class="text-muted">Price: </dt>
                    <dd><strong><?=($mock->exam_price)?$this->session->userdata('currency_code').' '.$this->session->userdata('currency_symbol').$mock->exam_price:'Free' ?></strong></dd>
                </dl>
            </div>        
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">Rules:</div>        
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt class="text-muted">Total Questions: </dt>
                    <dd><strong><?= $mock->random_ques_no ?> </strong> <small class="text-muted"> Multiple choice questions</small></dd>
                    <dt class="text-muted">Passing Score: </dt>
                    <dd><strong><?= $mock->pass_mark ?>%</strong></dd>
                    <dt class="text-muted">Duration: </dt>
                    <dd><strong><?=$mock->time_duration ?> <span class="text-muted"> hours</span></strong></dd>
                </dl>
            </div>        
        </div>
    </div>
</div>
<div class="container">
    <h4 class="text-muted">Syllabus:</h4>
    <div class="well well-sm"><?= $mock->syllabus; ?></div>

    <div class="fb-share-button" 
        data-href="<?=base_url('index.php/exam_control/view_exam_summery/'.$mock->title_id)?>" 
        data-layout="button" >
    </div>
    
</div><br/><br/>
<?php if ($mock->exam_price) {
    if (($user_info->subscription_id != 0) && ($user_info->subscription_end > now())) {
        $payment_info = 'view_exam_instructions';
    }else{
        $payment_info = 'payment_process'; 
    }
}else{
    $payment_info = 'view_exam_instructions';
}
?>
<div class="container">
    <a href="<?=base_url('index.php/exam_control/'.$payment_info.'/'.$mock->title_id) ?>" class="btn btn-success col-xs-5 col-xs-offset-1"> <?php echo ($payment_info == 'payment_process')?'Pay with PayUmoney':'Start Exam' ?></a>
    <a href="<?=base_url('index.php/exam_control/view_all_mocks') ?>" class="btn btn-default col-xs-offset-1">Cancel</a>    
</div><br/><br/>
<div class="container">
    <p class="result-note"><strong>Note: </strong>The value of this exam certificate is only valid under the terms and conditions of <?= $this->session->userdata('brand_name') ?>.</p>
</div>
