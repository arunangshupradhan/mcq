<div id="note">
    <?php
    if ($message) {
        echo $message;
    }
    ?>
<?=($this->session->flashdata('message')) ? $this->session->flashdata('message') : '';?>   
</div>
<?php
$str = '[';
foreach ($categories as $value) {
    $str .= "{value:" . $value->category_id . ",text:'" . $value->category_name . " '},";
}
$str = substr($str, 0, -1);
$str .= "]";
?>

<div class="block">  
    <div class="navbar block-inner block-header">
        <div class="row"><p class="text-muted">Mock List </p></div>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-sm-12">
                <?php if (isset($mocks) AND !empty($mocks)) { ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th>Mock Title</th>
                                <th style="width: 25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($mocks as $mock) {
                            ?>
                                <tr class="<?= ($i & 1) ? 'even' : 'odd'; ?>">
                                    <td>
                                        <p class="lead">
                                        <?= $mock->title_name; ?>
                                        </p>
                                        <?php if ($this->session->userdata('user_role_id') < 4) { ?>
                                        <span class="text-muted">Author: </span>
                                        <?php echo $mock->user_name; ?>
                                        <?php } ?>
                                        <span class="text-muted">Category: </span>
                                        <?= $mock->category_name ?>
                                        <span class="text-muted">Passing Score: </span>
                                            <?= $mock->pass_mark.' %'; ?>
                                        <span class="text-muted">Price: </span>
                                        <?= $mock->exam_price == 0 ? 'Free' : $this->session->userdata('currency_code') . ' ' . $this->session->userdata('currency_symbol') . $mock->exam_price; ?>
                                        <span class="pull-right">
                                            <span class="text-muted">Status: </span>
                                            <?= ($mock->exam_active == 1) ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td style="width: 25%">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-sm" href = "<?= base_url('index.php/mock_detail/' . $mock->title_id); ?>"><i class="glyphicon glyphicon-eye-open"></i><span class="invisible-on-md">  Questions</span></a>
                                            <a class="btn btn-default btn-sm" href = "<?= base_url('index.php/admin_control/update_mock_detail/' . $mock->title_id); ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md"> Modify</span></a>
                                            <a onclick="return delete_confirmation()" href = "<?php echo base_url('index.php/admin_control/delete_exam/' . $mock->title_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Delete</span></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<h3>No result found!</h3>';
                }
                ?>
            </div>
        </div>
    </div>
</div><!--/span-->

