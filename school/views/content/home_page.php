<!-- /Header Container Start-->
<div class="container">
    <?php if ($message) echo $message; ?>
    <?php $result = $this->db->select('content_type,content_data')
                ->where('content_type','wc_title')
                ->or_where('content_type','wc_msg')
                ->get('content')
                ->result();

        foreach ($result as $value) {
            if ($value->content_type == 'wc_title') {
                $title = $value->content_data;
            }
            if ($value->content_type == 'wc_msg') {
                $msg = $value->content_data;
            }
        }
    ?>
    <div class="jumbotron">
        <div class="row"><!-- /.row Start-->
            <?php if ($this->session->userdata('yt_url') AND $this->session->userdata('show_video')): ?>
            <div class="col-lg-8 col-md-8 col-sm-12">
            <?php else: ?>
            <div class="col-xs-12">
            <?php endif; ?>
                <div class="welcome-container">
                    <h1><?=$title; ?></h1>
                    <p style="text-indent: 20px; text-align: justify; padding-right: 20px; color: #363636;">
                        <i class="fa fa-quote-left"></i>
                         <?=$msg; ?> 
                        <i class="fa fa-quote-right"></i>
                    </p>
                    <?php if (!$this->session->userdata('log')): ?>
                        <?php if ($this->session->userdata('student_can_register')): ?>
                        <p>
                            <a class="btn btn-primary register_open" href="#register">Register</a>
                            <span class="small"> or </span>
                         <a class="btn btn-primary login_open" href="#login">Login</a>
                        </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($this->session->userdata('yt_url') AND $this->session->userdata('show_video')): ?>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="video-container" style="box-shadow: 0 0 5px #222">
                <iframe width="560" height="315" src="//www.youtube.com/embed/<?=$this->session->userdata('yt_url')?>?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <?php endif; ?>
        </div><!-- /.row End-->
    </div>
</div>
<!-- /Header Container End-->
<!-- /.Content Container Start-->
<div class="container">
<div class="col-md-12">
    <div class="col-md-4 col-sm-12">
    <div class="panel panel-info"><!-- /.panel Start-->
    <div class="panel-heading"><a href="<?php echo base_url('index.php/blog'); ?>">Recent Blog Posts</a></div>
        <div class="list-group box-content-scroll">
        <?php
        foreach ($latest_blogs as $key => $value) { ?>
           <a href="<?php echo base_url('index.php/blog/post/'.$value->blog_id); ?>" class="list-group-item">
                <h5 class="list-group-item-heading"><?php echo $value->blog_title;?><small class="pull-right">Posted: <?php echo date("d M, Y", strtotime($value->blog_post_date)); ?></small></h5>
                <div class="list-group-item-text home-page-blog-body" ><?=$value->blog_body?></div>
           </a>
        <?php    }    ?>
        </div>
    </div><!-- /.panel End-->
    </div>
    <div class="col-md-4 col-sm-12">
    <div class="panel panel-success"><!-- /.panel Start-->
    <div class="panel-heading"><a href="<?php echo base_url('index.php/noticeboard/notices'); ?>">Noticeboard</a></div>
        <div class="list-group box-content-scroll">
        <?php
        foreach ($notices as $value) { ?>
           <a href="<?=base_url('index.php/noticeboard/notice/'.$value->notice_id); ?>" class="list-group-item">
                <h5 class="list-group-item-heading"><?php echo $value->notice_title;?><small class="pull-right"><?php echo date("d M, Y", strtotime($value->notice_start)).' - '.date("d M, Y", strtotime($value->notice_end)); ?></small></h5>
                <div class="list-group-item-text home-page-blog-body"><?=$value->notice_descr; ?></div>
           </a>
        <?php } ?>
        </div>
    </div><!-- /.panel End-->
    </div>
    <div class="col-md-4 col-sm-12">
    <div class="panel panel-primary"><!-- /.panel Start-->
    <div class="panel-heading"><a href="<?php echo base_url('index.php/exam_control/view_all_mocks'); ?>">Latest exams</a></div>
        <div class="list-group box-content-scroll">
        <?php
        foreach ($latest_exams as $value) { ?>
           <a href="<?php echo base_url('index.php/exam_control/view_exam_summery/'.$value->title_id); ?>" class="list-group-item">
                <h5 class="list-group-item-heading"><?php echo $value->title_name;?><small class="pull-right">Launched: <?php echo date("d M, Y", strtotime($value->exam_created)); ?></small></h5>
                <p class="list-group-item-text"> <small> Category: <?=$value->category_name?></small></p>
           </a>
        <?php    }    ?>
        </div>
    </div>
    </div><!-- /.panel End-->
    </div>
</div>
</div>
<!-- /.Content Container End-->