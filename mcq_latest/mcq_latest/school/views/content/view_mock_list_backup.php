<div class="my-fluid-container">
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-6 col-sm-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="list-group">
                <a class="list-group-item list-group-item-heading active" href="<?php echo base_url('index.php/category/all'); ?>">All Categories</a>
                <?php 
                foreach ($categories as $cat) { 
                ?>
                    <a class="list-group-item" href="<?php echo base_url('index.php/category/' . $cat->category_id); ?>">
                        <span class="badge pull-right <?php echo ($mock_count[$cat->category_id] > 0) ? 'badge-warning' : 'badge-success'; ?>"><?php echo $mock_count[$cat->category_id]; ?></span>
                        <?php echo $cat->category_name; ?>
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
            if (isset($message) && $message != '') {
                echo $message;
            }
            ?>
            <div class="block">  
                <div class="navbar block-inner block-header">
                    <div class="row"><p class="text-muted">Latest Exams </p></div>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php 
                            if (isset($mocks) != NULL) { 
                            ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Exam Detail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($mocks as $mock) {
                                            if ($mock->exam_active == 1) {
                                        ?>
                                                <tr class="<?php echo ($i & 1) ? 'even' : 'odd'; ?>">
                                                    <td>
                                                        <p class="lead"><?= $mock->title_name; ?> </p>
                                                        <span class="text-muted">Passing Score: </span>
                                                        <?= $mock->pass_mark; ?> %
                                                        &nbsp;
                                                        <span class="text-muted">Category: </span>
                                                        <?= $mock->category_name; ?>
                                                        &nbsp;
                                                        <span class="text-muted">Price: </span>
                                                            <?= ($mock->exam_price == 0) ? '<span class="label label-primary"> Free</span>' : '<span class="label label-inverse"> ' . $this->session->userdata('currency_code') . ' ' . $this->session->userdata('currency_symbol') . $mock->exam_price . '</span>' ?>
                                                        <span class="pull-right">
                                                            <span class="text-muted">Author: </span>
                                                            <?= $mock->user_name; ?>
                                                        </span>
                                                    </td>  
                                                    <td style="width: 15%">
                                                        <a class="btn btn-info btn-sm" href="<?= base_url('index.php/exam_control/view_exam_summery/' . $mock->title_id) ?>">
                                                            Take this mock
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                echo 'No mocks!';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><!--/span-->
        </div>
    </div><!--/row-->
</div><!--/.container-->
