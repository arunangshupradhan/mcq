<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">
        <?php if ($message) echo $message; ?>

        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <h3 class="heade-title">FAQs <small> Most asked questions</small></h3>
            </div>
        </div>

        <div class="blog"><!-- /.row Start-->
            <div class="blog-post">
                <div class="panel-group" id="accordion">
                <?php 
                if (isset($faqs) AND !empty($faqs)) { ?>
                     <?php  
                     $i = 1;
                        foreach ($faqs as $faq) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=$i;?>.
                                    <a data-toggle="collapse" data-parent="#accordion" href="#faq<?=$faq->faq_id; ?>">
                                        <?=$faq->faq_ques; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="faq<?=$faq->faq_id; ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?=$faq->faq_ans; ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $i++;
                        } ?>
                <?php
                } else {
                    echo '<div class="panel panel-default"><div class="panel-body">No result found!</div></div>';
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>