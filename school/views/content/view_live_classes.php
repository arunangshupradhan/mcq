<div id="note">
    <?php
    if ($message) {
        echo $message;
    }
    ?>


<div class="block">  
    <div class="navbar block-inner block-header">
        <div class="row"><p class="text-muted">Live Classes </p></div>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-sm-12">
                <?php if (isset($live_classes) AND !empty($live_classes)) { ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($live_classes as $live_classes_values) {
                            ?>
                                <tr class="<?= ($i & 1) ? 'even' : 'odd'; ?>">
                                    <td><?= $live_classes_values->title; ?></td>
                                    <td><?= $live_classes_values->description; ?></td>
                                    <td><?= $live_classes_values->start_time; ?></td>
                                    <td><?= $live_classes_values->end_time; ?></td>
                                    <td style="width: 25%">
                                        <div class="btn-group">

                                            <a class="btn btn-default btn-sm" href = "<?= base_url('index.php/admin_control/edit_online_class/' . $live_classes_values->id); ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md"> Modify</span></a>
                                            <a onclick="return delete_confirmation()" href = "<?php echo base_url('index.php/admin_control/delete_online_course/' . $live_classes_values->id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Delete</span></a>
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

