<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">

        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <label class="header-label">Browsing</label>
                <h3 class="heade-title"><?=($this->session->userdata('brand_name'))?$this->session->userdata('brand_name')."'s":'';?> blog</h3>
                <div class="header-control btn-group pull-right">
                    <?=form_open(base_url('index.php/blog/find'), 'method="GET" role="form" class="form-horizontal"'); ?>
                        <div class="right-inner-addon ">
                            <i class="glyphicon glyphicon-search"></i>
                            <input name="keyword" type="search" class="form-control" placeholder="Search..." />
                        </div>
                    <?=form_close(); ?>
                </div>
                </div>
        </div>

        <div class="blog"><!-- /.row Start-->
            <div class="blog-post">
                <h1 class="text-center"><?php echo $post->blog_title; ?></h1>
                <div class="blog-caption"><em>By <?php echo $post->user_name.', Published: '. $post->blog_post_date; ?></em></div>
                <div class="blog-body-single"><?php echo $post->blog_body; ?></div>
            </div>
            <div class="blog-comments">
                <h5><?=count($post_comments)?> Comments</h5>
                <?php echo form_open('blog/comment');?>
                    <input type="hidden" name="blog_id" value="<?=$post->blog_id;?>">
                    <div class="col-xm-12">
                        <textarea name="blog_comment" class="form-control" placeholder="Leave your comment here..." rows="2"></textarea>                            
                        <div class="text-right"><button type="submit" class="btn btn-sm btn-warning">Submit</button></div>
                    </div>
                <?php echo form_close(); ?>
                <div class="row comment-section">
                <?php foreach ($post_comments as $value) { ?>
                    <div class="old-comments col-xs-12">
                        <div class="avatar col-xs-1"><img src="<?=base_url('index.php/user-avatar/avatar-placeholder.jpg')?>"></div>
                        <div class="comment-body-section col-xs-11">
                            <h5><?=$value->user_name;?> <small class="pull-right"><em> Posted: <?=date('D, d M Y', strtotime($value->comment_date));?> </em></small></h5>
                            <?=$value->comment_body;?>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>

        </div><!-- /.row End-->
    </div>
</div>