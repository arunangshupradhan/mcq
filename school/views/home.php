<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Munna Khan">
        <title><?=($this->session->userdata('brand_name'))?$this->session->userdata('brand_name').' - '.$this->session->userdata('brand_sologan'):'MinorSchool' ?></title>
        <?php 
        if(isset($share)){
        
            if(strpos($_SERVER['REQUEST_URI'], "exam_control") !== false && isset($mock))
            { ?>
                <meta property="og:url"           content="<?=base_url('index.php/exam_control/view_exam_summery/'.$mock->title_id)?>" />
                <meta property="og:type"          content="website" />
                <meta property="og:title"         content="<?=$mock->title_name?>" />
                <meta property="og:description"   content="<?=$mock->syllabus?>" />
                <?php if ($mock->feature_img_name && file_exists("exam-images/$mock->feature_img_name")) { ?>
                    <meta property="og:image"     content="<?=base_url("exam-images/$mock->feature_img_name"); ?>" />
                <?php }else{ ?>
                    <meta property="og:image"     content="<?=base_url("exam-images/placeholder.png"); ?>" />
                <?php }
            }

        } ?>

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
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=564958046919608";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <!--Top Navigation-->
        <?php echo (isset($top_navi)) ? $top_navi : ''; ?>
        <div id="home-page-container">
        <!--Sidebar-->
        <?php echo (isset($sidebar)) ? $sidebar : ''; ?>
        <!--Content-->
        <?php echo (isset($content)) ? $content : ''; ?>
        </div>
        <hr/>
        <!--Footer-->
        <?php echo $footer; ?>
        <!--Page Specific Footer-->
        <?php 
        if (isset($extra_footer)) {
            echo $extra_footer;
        }
        ?>
<!-- End Main Contents  -->
<!-- Contact form Modal -->
 <?php 
      $this->load->view('modals/contact_form');
 ?>
<!-- End Contact form Modal -->
    </body>
</html>