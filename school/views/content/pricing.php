<div class="container">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xs-offset-0">
        <?php if ($message) echo $message; ?>

        <div class="row title-row">
            <div class="col-xs-12 exam-list-heading">
                <h4 class="">Subscribe to <?=$this->session->userdata('brand_name');?></h4>
            </div>
            <div>
                <?php $msg = $this->db->get_where('content', array('content_type' => 'price_table_msg'))->row()->content_data; ?>
                <p class="lead"><?=$msg; ?></p>
            </div>
        </div>

        <div class="row"><!-- /.row Start-->
            <div id="pricing-table" class="clear">
            <?php foreach ($memberships as $offer) { ?>
                <div class="plan col-sm-3" id="<?=($offer->price_table_top)?'most-popular':''; ?>">
                    <h3><?=$offer->price_table_title; ?><span><?=$this->session->userdata('currency_symbol').$offer->price_table_cost; ?></span></h3>
                    <ul>
                    <?php foreach ($features as $feature) { 
                        if ($feature->parent_id == $offer->price_table_id) {
                            echo '<li>'.$feature->feature_item.'</li>';
                        }
                     } ?>
                    </ul> 
                    <br/>
                    <!--<a class="btn btn-lg btn-block btn-warning" href="<?/*=base_url('index.php/membership/payment_process/'.$offer->price_table_id);*/?>">Subscribe</a>-->
                    <a class="btn btn-lg btn-block btn-warning" href="<?=base_url('/index.php/exam_control/view_all_mocks/'.$offer->price_table_id);?>">Details</a>
                </div>
            <?php } ?>
            </div>
        </div><!-- /.row End-->

    </div>
</div>
