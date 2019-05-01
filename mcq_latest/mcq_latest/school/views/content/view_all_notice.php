 <div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">
        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <label class="header-label">Browsing</label>
                <h3 class="heade-title">Noticeboard</h3>
        </div>
        </div>


    <div class="blog">
        <?php if(empty($notices)) echo "<h3>No result found!</h3>"; ?>            
        <?php foreach ($notices as $value) { ?>
            <div class="blog-post">
                <a href="<?=base_url('index.php/noticeboard/notice/'.$value->notice_id); ?>">
                <h1 class="text-center"><?php echo $value->notice_title; ?></h1>
                </a>
                <div class="blog-caption"><h4><em><?=$value->notice_start;?></em> <small>TO</small> <em><?=$value->notice_end; ?></em></h4></div>
                <div class="blog-body"><?php echo $value->notice_descr; ?></div>
                <div class="read-more"><a href="<?=base_url('index.php/noticeboard/notice/'.$value->notice_id); ?>" class="btn btn-default btn-sm col-sm-4 col-sm-offset-4"> Read More </a></div>
            </div>
        <?php } ?>
    </div>
    </div>
</div> 