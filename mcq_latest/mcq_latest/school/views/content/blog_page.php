<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">
        <div class="row title-row">
            <?php echo ($this->session->flashdata('msg')) ? $this->session->flashdata('msg') : '' ?>        
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
        <?php if(empty($blogs)) echo "<h3>No result found!</h3>"; ?>            
        <?php foreach ($blogs as $value) { ?>
            <div class="blog-post">
                <a href="<?=base_url('index.php/blog/post/'.$value->blog_id); ?>">
                <h1 class="text-center"><?php echo $value->blog_title; ?></h1>
                </a>
                <div class="blog-caption"><em>By <?php echo $value->user_name.', Published: '. $value->blog_post_date; ?></em></div>
                <div class="blog-body"><?php echo $value->blog_body; ?></div>
                <div class="read-more"><a href="<?=base_url('index.php/blog/post/'.$value->blog_id); ?>" class="btn btn-default btn-sm col-sm-4 col-sm-offset-4"> Read More </a></div>
            </div>
        <?php } ?>
    </div><!-- /.row End-->
    
    <div class="text-center">
         <?php echo $this->pagination->create_links(); ?>
    </div>

    </div>
</div>