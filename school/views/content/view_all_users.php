<div id="note">
    <?php 
    if ($message) {
        echo $message;    
    }
    ?>
</div>
<?php
$str = '[';
foreach ($user_role as $value) {
    if ($value->user_role_id != 1) {
        $str .= "{value:".$value->user_role_id.",text:'".$value->user_role_name." '},";
    }
}
$str = substr($str, 0, -1);
$str .= "]";
?>

<div class="block">  
    <div class="navbar block-inner block-header">
        <div class="row">
            <ul class="nav nav-pills">
              <!--  <li><p class="text-muted">User List </p></li>
                <li class=" pull-right"><a href="#student" data-toggle="pill">Student</a></li>
                <li class=" pull-right"><a href="#teacher" data-toggle="pill">Teacher</a></li>
                <?php /*if ($this->session->userdata['user_role_id'] < 3) { */?>
                    <li class=" pull-right"><a href="#moderator" data-toggle="pill">Moderator</a></li>
                <?php /*}*/?>
                <?php /*if ($this->session->userdata['user_role_id'] < 2) { */?>
                    <li class=" pull-right"><a href="#admin" data-toggle="pill">Admin</a></li>
                --><?php /*}*/?>
                <li class="active pull-right"><a href="#all" data-toggle="pill"> All </a></li>
            </ul>
        </div>
    </div>
    <div class="block-content">
    <div class="row">
    <div class="col-sm-12">
        <div class="tab-content">
        <?php if (isset($users) != NULL) { ?>
        <div class="tab-pane fade" id="teacher">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="example">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xxs">Phone Number</th>
                    <th class="hidden-xxs">Email</th>
                    <th class="hidden-xxs">Role</th>
                    <th style="width: 30%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i = 1;
            foreach ($users as $user) { 
               if (($user->active == 1) && ($user->banned == 0) && ($user->user_role_id == 4)) { ?>
                <tr class="<?=($i & 1) ? 'even' : 'odd'; ?>">
                    <td>
                        <a href="#" data-name="user_name" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_name; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_phone" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_phone; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_email" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_email; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_role" data-type="select" data-source="<?=$str;?>" data-value="<?=$user->user_role_id; ?>" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_role_name; ?></a>
                    </td>
                    <td style="width: 30%">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm modify" name="modify-<?=$user->user_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                        <a onclick="return ban_confirmation('<?=$user->user_name?>')"  class="btn btn-default btn-sm" href = "<?=base_url('index.php/user_control/ban_user_account/' . $user->user_id); ?>"><i class="glyphicon glyphicon-ban-circle"></i><span class="invisible-on-md">  Ban</span></a>
                        <a onclick="return deactivate_confirmation('<?=$user->user_name?>')" href = "<?php echo base_url('index.php/user_control/deactivate_user_account/' . $user->user_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Deactivate</span></a>
                    </div>
                    </td>
                </tr>
                <?php $i++;
                }
            }?>
            </tbody>
        </table>
        </div>
        <?php if ($this->session->userdata['user_role_id'] < 2) { ?>
        <div class="tab-pane fade" id="admin">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="example">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xxs">Phone Number</th>
                    <th class="hidden-xxs">Email</th>
                    <th class="hidden-xxs">Role</th>
                    <th style="width: 30%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i = 1;
            foreach ($users as $user) { 
               if (($user->active == 1) && ($user->banned == 0) && ($user->user_role_id == 2)) { ?>
                <tr class="<?=($i & 1) ? 'even' : 'odd'; ?>">
                    <td>
                        <a href="#" data-name="user_name" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_name; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_phone" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_phone; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_email" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_email; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_role" data-type="select" data-source="<?=$str;?>" data-value="<?=$user->user_role_id; ?>" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-source="" data-value="<?=$user->user_role_id; ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_role_name; ?></a>
                    </td>
                    <td style="width: 30%">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm modify" name="modify-<?=$user->user_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                        <a onclick="return ban_confirmation('<?=$user->user_name?>')"  class="btn btn-default btn-sm" href = "<?=base_url('index.php/user_control/ban_user_account/' . $user->user_id); ?>"><i class="glyphicon glyphicon-ban-circle"></i><span class="invisible-on-md">  Ban</span></a>
                        <a onclick="return deactivate_confirmation('<?=$user->user_name?>')" href = "<?php echo base_url('index.php/user_control/deactivate_user_account/' . $user->user_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Deactivate</span></a>
                    </div>
                    </td>
                </tr>
                <?php 
                $i++;
                }
            }?>
            </tbody>
        </table>
        </div>
        <?php } ?>
        <div class="tab-pane fade" id="student">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="example">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xxs">Phone Number</th>
                    <th class="hidden-xxs">Email</th>
                    <th class="hidden-xxs">Role</th>
                    <th style="width: 30%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i = 1;
            foreach ($users as $user) { 
               if (($user->active == 1) && ($user->banned == 0) && ($user->user_role_id == 5)) { ?>
                <tr class="<?=($i & 1) ? 'even' : 'odd'; ?>">
                    <td>
                        <a href="#" data-name="user_name" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_name; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_phone" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_phone; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_email" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_email; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_role" data-type="select" data-source="<?=$str;?>" data-value="<?=$user->user_role_id; ?>" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-source="" data-value="<?=$user->user_role_id; ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_role_name; ?></a>
                    </td>
                    <td style="width: 30%">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm modify" name="modify-<?=$user->user_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                        <a onclick="return ban_confirmation('<?=$user->user_name?>')"  class="btn btn-default btn-sm" href = "<?=base_url('index.php/user_control/ban_user_account/' . $user->user_id); ?>"><i class="glyphicon glyphicon-ban-circle"></i><span class="invisible-on-md">  Ban</span></a>
                        <a onclick="return deactivate_confirmation('<?=$user->user_name?>')" href = "<?php echo base_url('index.php/user_control/deactivate_user_account/' . $user->user_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Deactivate</span></a>
                    </div>
                    </td>
                </tr>
                <?php 
                $i++;
                }
            }
            ?>
            </tbody>
        </table>
        </div>
        <?php 
        if ($this->session->userdata['user_role_id'] < 3) { 
        ?>
        <div class="tab-pane fade" id="moderator">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="example">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xxs">Phone Number</th>
                    <th class="hidden-xxs">Email</th>
                    <th class="hidden-xxs">Role</th>
                    <th style="width: 30%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i = 1;
            foreach ($users as $user) { 
               if (($user->active == 1) && ($user->banned == 0) && ($user->user_role_id == 3)) { ?>
                <tr class="<?=($i & 1) ? 'even' : 'odd'; ?>">
                    <td>
                        <a href="#" data-name="user_name" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_name; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_phone" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_phone; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_email" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_email; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_role" data-type="select" data-source="<?=$str;?>" data-value="<?=$user->user_role_id; ?>" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-source="" data-value="<?=$user->user_role_id; ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_role_name; ?></a>
                    </td>
                    <td style="width: 30%">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm modify" name="modify-<?=$user->user_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                        <a onclick="return ban_confirmation('<?=$user->user_name?>')"  class="btn btn-default btn-sm" href = "<?=base_url('index.php/user_control/ban_user_account/' . $user->user_id); ?>"><i class="glyphicon glyphicon-ban-circle"></i><span class="invisible-on-md">  Ban</span></a>
                        <a onclick="return deactivate_confirmation('<?=$user->user_name?>')" href = "<?php echo base_url('index.php/user_control/deactivate_user_account/' . $user->user_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Deactivate</span></a>
                    </div>
                    </td>
                </tr>
                <?php 
                $i++;
                }
            }
            ?>
            </tbody>
        </table>
        </div>
        <?php } ?>
        <div class="tab-pane active fade in" id="all">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="example">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xxs">Phone Number</th>
                    <th class="hidden-xxs">Email</th>
                    <th class="hidden-xxs">Role</th>
                    <th style="width: 30%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i = 1;
            foreach ($users as $user) { 
               if (($user->active == 1) && ($user->banned == 0) && ($user->user_role_id > $this->session->userdata['user_role_id'])) { 
            ?>
                <tr class="<?=($i & 1) ? 'even' : 'odd'; ?>">
                    <td>
                        <a href="#" data-name="user_name" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_name; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_phone" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_phone; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_email" data-type="text" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_email; ?></a>
                    </td>
                    <td class="hidden-xxs">
                        <a href="#" data-name="user_role" data-type="select" data-source="<?=$str;?>" data-value="<?=$user->user_role_id; ?>" data-url="<?php echo base_url('index.php/user_control/update_user_data'); ?>" data-source="" data-value="<?=$user->user_role_id; ?>" data-pk="<?=$user->user_id; ?>" class="data-modify-<?=$user->user_id; ?> no-style"><?=$user->user_role_name; ?></a>
                    </td>
                    <td style="width: 30%">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm modify" name="modify-<?=$user->user_id; ?>" href = "#"><i class="glyphicon glyphicon-edit"></i><span class="invisible-on-md">  Modify</span></a>
                        <a onclick="return ban_confirmation('<?=$user->user_name?>')"  class="btn btn-default btn-sm" href = "<?=base_url('index.php/user_control/ban_user_account/' . $user->user_id); ?>"><i class="glyphicon glyphicon-ban-circle"></i><span class="invisible-on-md">  Ban</span></a>
                        <a onclick="return deactivate_confirmation('<?=$user->user_name?>')" href = "<?php echo base_url('index.php/user_control/deactivate_user_account/' . $user->user_id); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-trash"></i><span class="invisible-on-md">  Deactivate</span></a>
                    </div>
                    </td>
                </tr>
                <?php 
                $i++;
                }
            }
            ?>
            </tbody>
        </table>
        </div>
        <?php
        } else {
            echo 'You have no mocks!';
        }
        ?>
        </div>
    </div>
    </div>
    </div>
</div><!--/span-->
<?php $this->load->view('plugin_scripts/user_ban_confirmation'); ?>
 