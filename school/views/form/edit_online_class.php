
<?=($this->session->flashdata('message')) ? $this->session->flashdata('message') : '';?>   
<!-- block -->
<div class="block">
    <div class="navbar block-inner block-header">
        <div class="row"><p class="text-muted">Edit Online Class </p></div>
    </div>
    <div class="block-content">
    <?=form_open_multipart(base_url('index.php/admin_control/do_online_class'), 'role="form" class="form-horizontal"'); ?>
    <div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-offset-1 col-xs-10">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <?php
            $option = array();
            $option[''] = 'Select Category';
            foreach ($categories as $category) {
                if ($category->active) {
                    $option[$category->category_id] = $category->category_name;
                }
            }
            ?>
            <div class="form-group">
                <label for="category" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Select Category:</label>
                <div class="col-lg-5 col-sm-8 col-xs-7 col-mb">


                    <select required name="category" class="form-control">
                        <?php

                        foreach ($option as $key=>$value){
                            $selected = '';
                            if($key == $online_class_table_data->category_id){
                                $selected = "selected";
                            }
                            echo '<option '.$selected.' value="'.$key.'" >'.$value.'</option>';
                        }
                        ?>
                    </select>


                </div>
            </div>


            <div class="form-group">
                <label for="category" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Select Course:</label>
                <div class="col-lg-5 col-sm-8 col-xs-7 col-mb">
                    <select required name="course[]" multiple="multiple" class="form-control">
                        <?php
                            foreach ($all_course as $membership_value){
                                foreach ($online_class_to_course_data as $bbb){
                                    $selected = '';
                                    if($bbb->course_id == $membership_value->price_table_id){
                                        $selected = 'selected';
                                        break;
                                    }
                                }

                                echo '<option '.$selected.' value="'.$membership_value->price_table_id.'" >'.$membership_value->price_table_title.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="mock_title" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Title:</label>
                <div class="col-lg-5 col-sm-8 col-xs-7 col-mb">
                  <?php 
                    $data = array(
                        'name'        => 'mock_title',
                        'placeholder' => 'Exam Title',
                        'id'          => 'mock_title',
                        'value'       => '',
                        'rows'        => '2',
                        'class'       => 'form-control textarea-wysihtml5',
                        'required' => 'required',
                        'value' => $online_class_table_data->title
                    ); ?>
                    <?php echo form_textarea($data) ?>
                </div>
            </div>


            <div class="form-group">
                <label for="mock_title" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Iframe Link:</label>
                <div class="col-lg-5 col-sm-8 col-xs-7 col-mb">
                    <?php
                    $data = array(
                        'name'        => 'iframe',
                        'placeholder' => 'Video Iframe',
                        'id'          => 'iframe',
                        'value'       => '',
                        'rows'        => '2',
                        'class'       => 'form-control textarea-wysihtml5',
                        'required' => 'required',
                        'value' => $online_class_table_data->iframe
                    ); ?>
                    <?php echo form_textarea($data) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="syllabus" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Description:</label>
                <div class="col-lg-5 col-sm-8 col-xs-7 col-mb">
                    <?php
                    $data = array(
                        'name'        => 'description',
                        'id'          => 'description',
                        'placeholder' => 'description ',
                        'value'       => '',
                        'rows'        => '3',
                        'class'       => 'form-control textarea-wysihtml5',
                        'value' => $online_class_table_data->description
                    ); ?>
                    <?php echo form_textarea($data) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="passing_score" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">Start time:</label>
                <div class="col-sm-3 col-xs-6 col-mb">
                    <div class="input-group">
                        <?php echo form_input('start_time', date('d-m-Y',strtotime( $online_class_table_data->start_time)), 'id="start_time" placeholder="dd-mm-yyyy" class="form-control" required="required"') ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="passing_score" class="col-sm-offset-0 col-lg-2 col-xs-offset-1 col-xs-3 control-label mobile">End time:</label>
                <div class="col-sm-3 col-xs-6 col-mb">
                    <div class="input-group">
                        <?php echo form_input('end_time', date('d-m-Y',strtotime( $online_class_table_data->end_time)), 'id="end_time" placeholder="dd-mm-yyyy" class="form-control" required="required"') ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <label class="col-xs-offset-3 col-sm-8 col-xs-offset-2 col-xs-9">
                  <p class="text-muted"><i class="glyphicon glyphicon-info-sign"> </i> All fields are Required.</p>
              </label>
            </div>
            <br/><hr/>
            <div class="row">
                <div class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-md-8">
                    <button type="submit" class="btn btn-primary col-xs-5 col-sm-3">Save</button>
                </div>
            </div>
            <?=form_close(); ?>
        </div>
    </div>
    </div>
    </div>
</div>

