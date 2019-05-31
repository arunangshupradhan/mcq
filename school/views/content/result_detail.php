<div id="note">
    <?php 
    if ($message) {
        echo $message;    
    }
    ?>
</div>
<ol class="breadcrumb hidden-print">
    <li><a href="<?=base_url('index.php/dashboard/'.$this->session->userdata('user_id')); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
    <li><a href="<?=base_url('index.php/exam_control/view_results')?>"><i class="fa fa-puzzle-piece"></i> Results</a></li> 
    <li class="active">Result Detail</li>
</ol>
<div class="container hidden-print">
    <p class="col-sm-1 col-sm-offset-9">    
        <a href="javascript:window.print()" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i>&nbsp; Print </a>
    </p>
</div>
<div class="container visible-print">
    <div class="result-head text-center ">
        <h3><?=$this->session->userdata('brand_name')?></h3>
        <h4>Certificate</h4>
    </div>
</div>
<div class="result-info">
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body result-info-exam">
                    <h4>Exam Detail:</h4>
                    <dl class="dl-horizontal">
                        <dt>Title: </dt>
                        <dd><?=$results->title_name?></dd>
                        <dt>Total Question: </dt>
                        <dd><?=$results->question_answered?></dd>
                        <dt>Passing Score: </dt>
                        <dd><?=$results->pass_mark?>%</dd>
                        <dt>Mark Obtained: </dt>
                        <dd>
                            <?php
                            if($results->mark_obtain_sign == '-'){
                                echo '-'.$results->result_percent.'%';
                            }else{
                                echo $results->result_percent.'%';
                            }
                            ?>
                        </dd>
                        <dt>Result: </dt>
                        <dd>
                            <?php
                            if(($results->pass_mark < $results->result_percent) ||($results->pass_mark == $results->result_percent)){
                                echo 'Pass';
                            }else{
                                echo 'Fail';
                            }
                            ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body result-info-user">
                    <h4>Student Detail:</h4>
                    <dl class="dl-horizontal">
                        <dt>Name: </dt>
                        <dd><?=$results->user_name?></dd>
                        <dt>Email: </dt>
                        <dd><?=$results->user_email?></dd>
                        <dt>Phone: </dt>
                        <dd><?=$results->user_phone?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
<h3>Result details</h3>
    <div class="row">
        <div class="col-xs-12">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>SL No.</td>
                    <td>Question</td>
                    <td>Options</td>
                    <td>My Answer</td>
                    <td>My Marks</td>
                    <td>Right Answer</td>
                    <td>Mark Obtain</td>

                </tr>
                </thead>
                <tbody>
                <?php
                $answer[] = array();
                $i = 1;
                foreach($answer_list as $answer_list_value){?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $answer_list_value->question; ?></td>
                    <td>
                        <?php $user_answer = $right_answer = ''; $s = 1;
                        foreach($answer_list_value->all_options as $val){ ?>
                            <?php
                                echo $s.') '.$val->answer;
                                if(!empty($val->ans)){
                                    $user_answer .=  $s.') '.$val->answer.'<br>';
                                    $mark_obtain = '';
                                    foreach ($val->ans as $mark){
                                        if($mark->operator == '-'){
                                            $mark_obtain = '-'.$mark->mark;
                                            break;
                                        }else{
                                            $mark_obtain = $mark->mark;
                                        }
                                    }
                                }
                                if($val->right_ans == 1){
                                    $right_answer .=  $s.') '.$val->answer.'<br>';
                                }

                            ?><br>
                        <?php $s++; } ?>
                    </td>
                    <td>
                        <?php echo $user_answer; ?>
                    </td>
                    <td><?php echo $mark_obtain; ?></td>
                    <td>
                        <?php echo $right_answer; ?>
                    </td>
                    <td><?php echo $results->positive_mark; ?></td>
                </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container sign-panel visible-print">
        <div class="col-xs-offset-1 col-xs-5">
            <h4 class="text-center">Signature <?=$this->session->userdata('brand_name')?></h4>
        </div>
        <div class="col-xs-push-1 col-xs-5">
            <h4 class="text-center">Signature Student</h4>
        </div>
    </div>
</div>
<div class="container">
    <p class="result-note"><strong>Note: </strong>This certificate is only valid under the terms and conditions of <?=$this->session->userdata('brand_name')?>.</p>
</div>
<link href="<?php echo base_url('assets/css/print-result.css') ?>" rel="stylesheet" media="print">
