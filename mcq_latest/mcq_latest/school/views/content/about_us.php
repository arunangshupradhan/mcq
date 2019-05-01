<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">
        <?php if ($message) echo $message; ?>

        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <h3 class="heade-title">About us</h3>
            </div>
        </div>

        <div class="blog"><!-- /.row Start-->
            <div class="blog-post">
                <?php $msg = $this->db->get_where('content', array('content_type' => 'about_us'))->row()->content_data; ?>
                <?php
                if(!empty($msg)){
                    echo $msg;
                }else{
                    echo "<h4>Not available!</h4>";
                }
                ?>
            </div><!-- /.row End-->
        </div>
    </div>
</div>
