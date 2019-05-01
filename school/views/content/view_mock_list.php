<div class="my-fluid-container">
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-6 col-sm-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="list-group">
                <a class="list-group-item list-group-item-heading active" href="<?=base_url('index.php/category/all'); ?>">All Categories</a>
                <?php 
                foreach ($categories as $cat) { 
                ?>
                    <a class="list-group-item" href="<?=base_url('index.php/category/' . $cat->category_id); ?>">
                        <span class="badge pull-right <?=($mock_count[$cat->category_id] > 0) ? 'badge-warning' : 'badge-success'; ?>"><?=$mock_count[$cat->category_id]; ?></span>
                        <?=$cat->category_name; ?>
                    </a>
                <?php 
                }
                ?>
            </div>
        </div><!--/span-->

        <div class="col-xs-12 col-sm-9 col-lg-10">
            <p class="pull-left visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">View Category</button>
            </p>
            <?php
            if (isset($message) AND $message != '') {
                echo $message;
            }
            ?>
            <div class="row title-row">

            <div class="col-xs-12 exam-list-heading">
            <label class="header-label">Browsing</label>
            <h3 class="heade-title"><?=isset($category_name)?$category_name:'All Exams'; ?></h3>
            <?php if ($this->session->userdata('commercial')) { ?>
            <div class="header-control btn-group pull-right">
                <a href="<?=base_url('index.php/exam_control/view_all_mocks') ?>" class="btn btn-default">All</a>
                <a href="<?=base_url('index.php/exam_control/mocks_type/paid') ?>" class="btn btn-default">Paid</a>
                <a href="<?=base_url('index.php/exam_control/mocks_type/free') ?>" class="btn btn-default">Free</a>
            </div>
            <?php } ?>

            </div>
            
            </div>
            <div class="row">
            <div class="exam-list">
            <?php 
                if (isset($mocks) AND !empty($mocks)) { 
                $i = 1;
                foreach ($mocks as $mock) {
                    if ($mock->exam_active == 1) {

                        $hr = (int) substr($mock->time_duration, 0, 2); // returns hr 
                        $minutes =substr($mock->time_duration, -5, 5); // returns minutes 
            ?>
                      <div class="col-xs-6 col-lg-3 col-md-4 exam-item">
                        <div class="thumbnail">
                        <a href="<?=base_url('index.php/exam_control/view_exam_summery/'.$mock->title_id); ?>">
                            <?php if ($mock->feature_img_name && file_exists("exam-images/$mock->feature_img_name")) { ?>
                                <img class="exam-thumbnail" src="<?=base_url('exam-images/'.$mock->feature_img_name); ?>" data-src="holder.js/300x300" alt="...">
                            <?php }else{ ?>
                                <img class="exam-thumbnail" src="<?=base_url('exam-images/placeholder.png'); ?>" data-src="holder.js/300x300" alt="...">
                            <?php } ?>
                          <div class="caption">
                          <span class="exam-category text-danger"><?=$mock->category_name;?></span>
                            <p class="exam-title"><?=$mock->title_name;?></p>
                            <p> 
                            <time class="total-question" ><?=$mock->random_ques_no;?> questions</time>
                            <div class="exam-duration" ><?=($hr)?$mock->time_duration.' hours':$minutes.' minutes';?></div>
                            <button class="btn btn-sm btn-primary">Start</button>
    <div class="fb-share-button" 
        data-href="<?=base_url('index.php/exam_control/view_exam_summery/'.$mock->title_id)?>" 
        data-layout="button" >
    </div>
                            
                            </p>
                          </div>
                        </a>
                        </div>   
                      </div>
            <?php
                        $i++;
                    }
                }
            } else {
                echo '<div class="col-xs-12 exam-list-heading"><h3>No exam available!</h3></div>';
            }
            ?>
            </div>            
            </div>            
        </div>
    </div><!--/row-->
</div><!--/.container-->
