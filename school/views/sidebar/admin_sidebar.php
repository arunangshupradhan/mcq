<!-- \ css class control -->
<?php
if (isset($class)) {
    $active = floor($class/10); //The numeric value to round
}
?>
<!-- \ Sidebar -->
<ul class="nav sidebar">
	<li>
		<div class="dbd_profile">
			<div class="dbd_candidate_img" style=""></div>
			<div class="dbd_candidate">
				<h4>Candidate Name</h4>
				<a href="#">Edit Profile</a>
			</div>
		</div>
	</li>
    <li>
        <a href="<?=base_url('index.php/dashboard/'.$this->session->userdata('user_id')); ?>">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>
    <?php if ($this->session->userdata['user_role_id'] <= 3) { ?>
    <li><a href="#" class="sub <?=($active==1)?"active":'';?>"><i class="fa fa-user"> </i> User Control</a>
        <ul>
            <?php
            if ($this->session->userdata('user_id') == 6) {?>
            <li><a href="<?=base_url('index.php/user_control');?>" class="<?=($class==11)?"current":'';?>">View Users</a></li>
            <li><a href="<?=base_url('index.php/user_control/user_add_form');?>" class="<?=($class==12)?"current":'';?>">Add New User</a></li>
            <?php } ?>
            <li><a href="<?=base_url('index.php/user_control/view_banned_users');?>" class="<?=($class==13)?"current":'';?>">Banned / Inactive Users</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] <= 4) { ?>
    <li><a href="#" class="sub <?=($active==2)?"active":'';?>"><i class="fa fa-bullseye"></i> Exam Control</a>
        <ul>
            <li><a href="<?=base_url('index.php/mocks');?>" class="<?=($class==21)?"current":'';?>">View Exams</a></li>
            <li><a href="<?=base_url('index.php/create_mock');?>" class="<?=($class==22)?"current":'';?>">Create Exam</a></li>
            <?php if ($this->session->userdata['user_role_id'] <= 3) { ?>
            <li><a href="<?=base_url('index.php/admin_control/view_categories');?>" class="<?=($class==23)?"current":'';?>">View Categories</a></li>
            <?php } ?>
            <li><a href="<?=base_url('index.php/create_category');?>" class="<?=($class==24)?"current":'';?>">Create New Category</a></li>
            <li><a href="<?=base_url('index.php/exam_control/view_results');?>" class="<?=($class==25)?"current":'';?>">View Results</a></li>
        </ul>
    </li>
    <?php } else { ?>
        <li><a href="<?=base_url('index.php/exam_control/view_results');?>" class="<?=($active==2)?"active":'';?>"><i class="fa fa-puzzle-piece"></i> View Results</a></li>
    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] <= 3) { ?>
    <li><a href="#" class="sub <?=($active==50)?"active":'';?>"><i class="fa fa-bullseye"></i> Live class Manage</a>
        <ul>
            <li><a href="<?=base_url('/index.php/admin_control/create_online_class');?>" class="<?=($class==21)?"current":'';?>">Add Class</a></li>
            <li><a href="<?=base_url('/index.php/admin_control/view_live_classes');?>" class="<?=($class==21)?"current":'';?>">View All Class</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] == 5) { ?>
        <li><a href="/index.php/exam_control/my_course" class="<?=($active==50)?"active":'';?>"><i class="fa fa-bullseye"></i>My Courses</a>
        </li>
    <?php } ?>

    <?php if ($this->session->userdata('commercial')) { ?>
    <?php if ($this->session->userdata['user_role_id'] <= 2) { ?>
    <li><a href="#" class="sub <?=($active==8)?"active":'';?>"><i class="fa fa-list"> </i> Membership</a>
        <ul>
            <li><a href="<?=base_url('index.php/membership');?>" class="<?=($class==81)?"current":'';?>">View Membership</a></li>
            <li><a href="<?=base_url('index.php/membership/add');?>" class="<?=($class==82)?"current":'';?>">Create Offer</a></li>
            <li><a href="<?=base_url('index.php/membership/add_feature');?>" class="<?=($class==83)?"current":'';?>">Add New Feature</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php } ?>
    <?php
    if ($this->session->userdata('user_id') == 6) {?>
    <?php if ($this->session->userdata['user_role_id'] <= 4) { ?>
    <li><a href="#" class="sub <?=($active==7)?"active":'';?>"><i class="fa fa-comment"> </i> Blog</a>
        <ul>
            <li><a href="<?=base_url('index.php/blog/view_all');?>" class="<?=($class==71)?"current":'';?>">View Posts</a></li>
            <li><a href="<?=base_url('index.php/blog/add');?>" class="<?=($class==72)?"current":'';?>">Add Post</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] <= 2) { ?>
        <li><a class="<?=($active==6)?"active":'';?>" href="<?=base_url('index.php/noticeboard'); ?>"><i class="fa fa-bookmark"></i> Noticeboard</a></li>
    <?php } ?>    
    <?php if ($this->session->userdata['user_role_id'] <= 3) { ?>
    <li><a href="#" class="sub <?=($active==3)?"active":'';?>"><i class="fa fa-cogs"> </i> Settings</a>
        <ul>
            <li><a href="<?=base_url('index.php/admin_control');?>" class="<?=($class==31)?"current":'';?>">Profile Settings</a></li>
            <?php if ($this->session->userdata['user_role_id'] <= 2) { ?>
            <li><a href="<?=base_url('index.php/admin/system_control/view_settings');?>" class="<?=($class==32)?"current":'';?>">System Settings</a></li>
            <?php }?>
            <li><a href="<?=base_url('index.php/faq_control');?>" class="<?=($class==33)?"current":'';?>">FAQ</a></li>
        </ul>
    </li>
    <?php } else { ?>
        <li><a href="<?=base_url('index.php/admin_control');?>" class="<?=($active==3)?"active":'';?>"><i class="fa fa-cogs"> </i> Profile Settings</a></li>
    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] > 2) { ?>
        <li><a class="<?=($active==4)?"active":'';?>" href="<?=base_url('index.php/message_control/contact_form');?>" class="<?=($class==42)?"current":'';?>"><i class="fa fa-envelope-o"></i> Contact Admin</a></li>
    <?php } else {?>
        <li><a class="<?=($active==4)?"active":'';?>" href="<?=base_url('index.php/message_control'); ?>"><i class="fa fa-envelope-o"></i> Inbox</a></li>
    <?php }?>

    <?php } ?>
    <?php if ($this->session->userdata['user_role_id'] <= 3) { ?>
        <li><a class="<?=($active==5)?"active":'';?>" href="<?=base_url('index.php/admin_control/view_payment_history');?>"><i class="fa fa-money"></i> Payment History</a></li>
    <?php }?>
    <li><a href="<?=base_url('index.php/login_control/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
</ul>
<!-- /End Sidebar -->
