<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">

        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <label class="header-label">Browsing</label>
                <h3 class="heade-title">Noticeboard</h3>
            </div>
        </div>

        <div class="blog"><!-- /.row Start-->
            <div class="blog-post">
                <h1 class="text-center"><?php echo $notice->notice_title; ?></h1>
                <div class="blog-caption"><h3><em><?=$notice->notice_start;?></em> <small>TO</small> <em><?=$notice->notice_end; ?></em></h3></div>
                <div class="blog-body-single"><?php echo $notice->notice_descr; ?></div>
            </div>
        </div><!-- /.row End-->
    </div>
</div>