<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Munna Khan">
        <title><?=$this->session->userdata('brand_name')?></title>
        <!--Header-->
        <?php echo $header; ?>
        <!--Page Specific Header-->
        <?php
        if (isset($extra_head)) {
            echo $extra_head;
        }
        ?>
    </head>
    <body>
        <div id="wrapper">
            <!-- Sidebar -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?=$this->session->userdata('brand_name')?></a>
                </div>
                <!-- This content will toggle -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>" style="margin-top: 7px;">Visit Site</a>

                    <!--Sidebar-->
                    <?php echo (isset($sidebar)) ? $sidebar : ''; ?>

                    <!--Top Navigation-->
                    <?php echo (isset($top_navi)) ? $top_navi : ''; ?>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <!--Content-->
                <?php echo (isset($content)) ? $content : ''; ?>
            </div><!-- /#page-wrapper -->
            <hr/>
            
            <!-- Modal Start -->
            <?php
            if (isset($modal)) {
                echo $modal;
            }
            ?>

            <!--Footer-->
            <?php echo $footer; ?>
       </div><!-- /#wrapper -->
       
        <!--Page Specific Footer-->
       <?php
       if (isset($extra_footer)) {
           echo $extra_footer;
       }
       ?>
    </body>
</html>