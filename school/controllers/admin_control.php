<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_control extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('exam_model');
        $this->load->model('admin_model');
        $this->load->model('membership_model');
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
    }

    public function index($message = '')
    {
        $data = array();
        $data['class'] = 31; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['profile_info'] = $this->admin_model->get_my_profile_info();
        $data['content'] = $this->load->view('admin/view_profile_info', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
        $this->load->view('dashboard', $data);
    }

    public function view_my_mocks($message = '')
    {
        $userId = $this->session->userdata('user_id');
        $data = array();
        $data['class'] = 21; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['categories'] = $this->exam_model->get_categories();
        if ($this->session->userdata('user_role_id') <= 3) {
            $data['mocks'] = $this->exam_model->get_all_mocks();
            $data['content'] = $this->load->view('content/view_all_mocks', $data, TRUE);
        } else {
            $data['mocks'] = $this->admin_model->get_user_mocks($userId);
            $data['content'] = $this->load->view('content/view_user_mocks', $data, TRUE);
        }
        $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
        $this->load->view('dashboard', $data);
    }

    public function view_my_mock_detail($id, $message = '')
    {
        if (!is_numeric($id)) {
            show_404();
        }
        $data = array();
        $data['class'] = 21;   // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['mock_title'] = $this->exam_model->get_mock_by_id($id);
        if (!(empty($data['mock_title'])) && (($this->session->userdata('user_role_id') <= 3) OR ($data['mock_title']->user_id == $this->session->userdata('user_id')))) {
            $data['mocks'] = $this->exam_model->get_mock_detail($id);
            $data['mock_ans'] = $this->exam_model->get_mock_answers($data['mocks']);
            $data['content'] = $this->load->view('content/mock_detail', $data, TRUE);
            $data['modal'] = $this->load->view('modals/update_question', $data, TRUE);
            $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
            $this->load->view('dashboard', $data);
        } else {
            show_404();
        }
    }

    public function view_categories($message = '')
    {
        if ($this->session->userdata('user_role_id') > 3) {
            redirect(base_url("login_control/dashboard_control"));
        }
        $data = array();
        $data['class'] = 23; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['categories'] = $this->exam_model->get_categories_with_author();
        $data['mock_count'] = $this->exam_model->mock_count($data['categories']);
        $data['content'] = $this->load->view('content/view_all_categories', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function category_form($message = '')
    {
        $data = array();
        $data['class'] = 24; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $data['content'] = $this->load->view('form/category_form', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function view_payment_history($message = '')
    {
        if ($this->session->userdata('user_role_id') > 2) {
            redirect(base_url("login_control/dashboard_control"));
        }
        $data = array();
        $data['class'] = 51; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['payments'] = $this->admin_model->get_payment_history();
        $data['content'] = $this->load->view('content/view_payment_history', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }
    
    public function mock_form($message = '', $cat_id = '')
    {     
      //  echo "<pre/>"; print_r($this->session->all_userdata()); exit();
        $userId = $this->session->userdata('user_id');
        $data = array();
        $data['class'] = 22; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['cat_id'] = $cat_id;
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $data['categories'] = $this->exam_model->get_categories();
        $data['membership'] = $this->membership_model->get_all_memberships();
        $data['content'] = $this->load->view('form/mock_form', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function question_form($message = '', $title_id = 0, $mock_title = 'Create Question', $question_no = 1)
    {
        $data = array();
        $data['class'] = 22; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['question_no'] = $question_no;
        $data['mock_title'] = $mock_title;
        $data['title_id'] = $title_id;
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $data['categories'] = $this->exam_model->get_categories();
        $data['content'] = $this->load->view('form/question_form', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function create_category()
    {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cat_name', 'Category', 'required|max_length[20]');
        if ($this->form_validation->run() == FALSE) {
            $this->category_form();
        } else {
            if ($this->session->userdata['user_role_id'] <= 4) {
                $category_name = $this->input->post('cat_name');
                $cat_id = $this->admin_model->create_category($category_name);
                if ($cat_id) {
                    $message = '<div class="alert alert-success alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'Category added successfully! Create Exam in the category.'
                            . '</div>';
                    $this->mock_form($message, $cat_id);
                } else {
                    $message = '<div class="alert alert-danger">' . $category_name . ' already exist.</div>';
                    $this->category_form($message);
                }
            } else {
                show_404();
            }
        }
    }

    public function update_mock_detail($id, $message = '')
    {        
        if (!is_numeric($id)) show_404();

        if ($this->input->post()) {
            // echo "<pre/>"; print_r($this->input->post()); exit();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mock_title', 'Mock Title', 'required|min_length[3]');
            $this->form_validation->set_rules('mock_syllabus', 'Syllabus', 'required');
            $this->form_validation->set_rules('passing_score', 'Passing Score', 'required|integer|less_than[100]');
            $this->form_validation->set_rules('random_ques', 'Random Quesen', 'required|integer');
            if ($this->form_validation->run() !== FALSE) {
                $form_info = array();
                if ($_FILES['feature_image']['name']) {
                    $config['upload_path'] = './exam-images/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = uniqid();
                    $config['overwrite'] = TRUE;
                    $config['max_size'] = '150';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('feature_image')) {
                        $error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
                        $this->session->set_flashdata('message',$error['error']);
                        redirect(base_url('index.php/admin_control/mock_form'));
                    } else {
                        $upload_data = $this->upload->data();
                        $title_id = $this->admin_model->update_mock_title($id, $upload_data['file_name']);
                    }
                }else{
                    $title_id = $this->admin_model->update_mock_title($id);
                }

                if ($title_id) {
                    $message = '<div class="alert alert-success alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'Exam updated successfully.'
                            . '</div>';
                    $this->session->set_flashdata('message', $message);
                    redirect('index.php/mocks');
                } else {
                    $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                    $this->session->set_flashdata('message', $message);
                    redirect('index.php/admin_control/update_mock_detail/'.$id);
                }
            }            
        }

        $data = array();
        $data['class'] = 21; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['mock'] = $this->admin_model->get_mock_detail($id);
        $data['ques_count'] = $this->exam_model->question_count_by_id($id);
        $data['membership'] = $this->membership_model->get_all_memberships();
        $data['content'] = $this->load->view('form/edit_mock_detail', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function create_mock($message = '')
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category', 'Category', 'required|integer');
        $this->form_validation->set_rules('mock_title', 'Mock Title', 'required|min_length[3]');
        $this->form_validation->set_rules('mock_syllabus', 'Syllabus', 'required');
        $this->form_validation->set_rules('price_table_id', 'Course name', 'required');
        $this->form_validation->set_rules('passing_score', 'Passing Score', 'required|integer|less_than[100]');
        if ($this->form_validation->run() == FALSE) {
            $this->mock_form();
        } else {
            $form_info = array();
            if ($_FILES['feature_image']['name']) {
                $config['upload_path'] = './exam-images/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = uniqid();
                $config['overwrite'] = TRUE;
                $config['max_size'] = '150';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('feature_image')) {
                    $error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
                    $this->session->set_flashdata('message',$error['error']);
                    redirect(base_url('index.php/admin_control/mock_form'));
                } else {
                    $upload_data = $this->upload->data();
                    $title_id = $this->admin_model->add_mock_title($upload_data['file_name']);
                }
            }else{
                $title_id = $this->admin_model->add_mock_title();
            }

            if ($title_id) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Exam created successfully! Now creat questions.'
                        . '</div>';
                $mock_title = $this->input->post('mock_title');
                $this->question_form($message, $title_id, $mock_title);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->mock_form($message);
            }
        }
    }

    public function create_question($message = '')
    {

     // echo "<pre>";                print_r($this->input->post());               // exit();
      // echo "<pre>";                print_r($_FILES);                exit();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('right_ans', 'At Least One Correct Answer', 'required');
        $this->form_validation->set_rules('ans_type', 'Answer Type', 'required');
        // $this->form_validation->set_rules('options[1]', 'Option 1', 'required');
        // $this->form_validation->set_rules('options[2]', 'Option 2', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->question_form('', $this->input->post('ques_id'));
        } else{
            $file_name = ''; $file_type = '';
            if ($_FILES['media']['name']) {
                $config['upload_path'] = './question-media/'.$this->input->post('media_type').'/';

                if ($this->input->post('media_type') == 'image') {
                    $config['allowed_types'] = 'gif|jpg|png';
                }elseif ($this->input->post('media_type') == 'video') {
                    $config['allowed_types'] = 'mp4|ogg|webm';
                }elseif ($this->input->post('media_type') == 'audio') {
                    $config['allowed_types'] = 'application/ogg|mp3|wav';
                }

                $config['file_name'] = uniqid();
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('media')) {
                    $error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
                    $this->session->set_flashdata('message',$error['error']);
                    redirect(base_url('index.php/admin_control/add_more_question/'.$this->input->post('ques_id')));
                } else {
                    $upload_data = $this->upload->data();
                    $file_name = $this->input->post('media_type').'/'.$upload_data['file_name'];
                    $file_type = $this->input->post('media_type');
                }
            }else if($this->input->post('media', TRUE)){
                $file_name = $this->input->post('media');
                $file_type = $this->input->post('media_type');
            }


//                 // $path_parts = pathinfo($_FILES["media"]["name"]);
//                 // $extension = $path_parts['extension'];

//                 $directory = $this->input->post('ques_id');
//                 if (!is_dir('answer-media/'.$directory)) {
//                     mkdir('./answer-media/' . $directory, 0777, TRUE);
//                 }
//                 $configa['upload_path'] = './answer-media/'.$directory.'/';
//                 $configa['allowed_types'] =  'gif|jpg|png';
//                 // $configa['file_name'] = $directory.'_'.$this->input->post('ans_id').'.'.$extension;
//                 $configa['overwrite'] = TRUE;
//                 $this->load->library('upload', $configa);


// $files = $_FILES;
//     $cpt = count($_FILES['answer_image']['name']);
//     for($i=0; $i<$cpt; $i++)
//     {

//         $_FILES['answer_image']['name']= $files['answer_image']['name'][$i];
//         $_FILES['answer_image']['type']= $files['answer_image']['type'][$i];
//         $_FILES['answer_image']['tmp_name']= $files['answer_image']['tmp_name'][$i];
//         $_FILES['answer_image']['error']= $files['answer_image']['error'][$i];
//         $_FILES['answer_image']['size']= $files['answer_image']['size'][$i];
// //$this->upload->initialize($config);
// //$this->upload->do_upload();
// if ( ! $this->upload->do_upload())
// {
// $this->data['error'] = array('error' => $this->upload->display_errors());
// //$this->data['subview'] = 'admin/upload/upload_view';
// //      $this->load->view('admin/_layout_main', $this->data);
// //
// }
// else
// {

// //This code for uploaded files name insert to databse
//     $this->data['file_name'] = $this->upload->data();
// //     $data =  $this->upload->data();
//                             $image[]=$this->data['file_name']['file_name'];
//    $data1= array( 'favicon'=> $image['0'],'file_name'=> $image['1']);
  
//         }}  
                        
            
            // -----------------------------------------------------------------
            
           

  // --------------------------------------------------------------------------------------
    //         $ans_file_name = ''; 
    //         if ($_FILES['answer_image']['name']) {
    //             $configa['upload_path'] = './answer-media/';
    //             $configa['allowed_types'] = 'gif|jpg|png';
    //             $configa['overwrite'] = TRUE;

    //             $this->load->library('upload', $configa);
    //             $files = $_FILES;
    // $cpt = count($_FILES['userfile']['name']);
    // for($i=0; $i<$cpt; $i++)
    // {

    //     $_FILES['answer_image']['name']= $files['answer_image']['name'][$i];
    //     $_FILES['answer_image']['type']= $files['answer_image']['type'][$i];
    //     $_FILES['answer_image']['tmp_name']= $files['answer_image']['tmp_name'][$i];
    //     $_FILES['answer_image']['error']= $files['answer_image']['error'][$i];
    //     $_FILES['answer_image']['size']= $files['answer_image']['size'][$i];
    //             if (!$this->upload->do_upload('answer_image')) {
    //                 $error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
    //                 $this->session->set_flashdata('message',$error['error']);
    //                 redirect(base_url('index.php/admin_control/add_more_question/'.$this->input->post('ques_id')));
    //             } else {
    //                 $upload_data = $this->upload->data();
    //                 $ans_file_name[] = $upload_data['file_name'];
                    
    //             }}
    //         }

            // --------------------------------------------------------------------------
            if ($this->admin_model->add_question($file_name, $file_type)){
                if ($this->input->post('done')) {
                    $exam_id = $this->input->post('ques_id', TRUE);
                    $exam_title = $this->input->post('mock_title', TRUE);
                    $message = '<div class="alert alert-success alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'Success! Set the time allowed to take ' . $exam_title . ' exam and the number of questions havae to answer.'
                            . '</div>';
                    $this->set_time_n_random_ques_no($exam_id, $exam_title, $message);
                } else {
                    $message = '<div class="alert alert-success alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'Successfully Added!'
                            . '</div>';
                    $mock_title = $this->input->post('mock_title');
                    $title_id = $this->input->post('ques_id');
                    $question_no = $this->input->post('ques_no') + 1;
                    $this->question_form($message, $title_id, $mock_title, $question_no);
                }
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->question_form($message);
            }

            $yourUniqueId=$this->input->post('ans_id');
            if($this->upload_answer_image('answer_image'))
  {
    //upload dsuccess
  }else{
     //error
  }


        }
    }

    function upload_answer_image($answer_image,$yourUniqueId)
            {


            // /$path_parts = pathinfo($_FILES["media"]["name"]);
            //                 $extension = $path_parts['extension'];

            //                 $directory = $this->input->post('ques_id');
            //                 if (!is_dir('answer-media/'.$directory)) {
            //                     mkdir('./answer-media/' . $directory, 0777, TRUE);
            //                 }
            //                 $configa['upload_path'] = './answer-media/'.$directory.'/';
            //                 $configa['allowed_types'] =  'gif|jpg|png';
            //                 // $configa['file_name'] = $directory.'_'.$this->input->post('ans_id').'.'.$extension;
            //                 $configa['overwrite'] = TRUE;
            //                 $this->load->library('upload', $configa);
// -------------------------------------
        //                     $data['title'] = 'Multiple Upload form';
        // $sub_data = array(
        //     'error' => '',
        //     'result' => ''
        // );
        // if($this->input->post('go_upload')) {
        //     $config['upload_path'] = './answer-media/';
        //     $config['allowed_types'] = 'gif|jpg|png';
        //     // $config['file_name'] = uniqid();
        //         $config['overwrite'] = TRUE;
        //     // $config['max_size'] = '500';
        //     // $config['max_width']  = '1024';
        //     // $config['max_height']  = '768';

        //     $this->load->library('upload', $config);
        // }
         //    $sub_data['result'] = '';
         //    $result_array = array();
         //    $cpt = count($_FILES['answer_image']['name']);
         //    for ($i = 1; $i <=$cpt; $i++){
         //       if (!empty($_FILES['answer_image'.$i]['name'])) {
         //            if (!$this->upload->do_upload('answer_image'.$i))
         //                $sub_data['error'] = $this->upload->display_errors();
         //            else
         //                array_push($result_array,$this->upload->data());
         //        }
         //    }
         //    $sub_data['result'] = $result_array;
         // }
// ----------------------------------------


                $this->load->library('upload'); 
$yourUniqueId=$this->input->post('ans_id');
 for($i=0; $i<count($_FILES); $i++)
 {

   $_FILES['answer_image']['name']    = $_FILES['answer_image']['name'][$i];
   $_FILES['answer_image']['type']    = $_FILES['answer_image']['type'][$i];
   $_FILES['answer_image']['tmp_name'] = $_FILES['answer_image']['tmp_name'][$i];
   $_FILES['answer_image']['error']       = $_FILES['answer_image']['error'][$i];
   $_FILES['answer_image']['size']    = $_FILES['answer_image']['size'][$i];

   $config['file_name']     = $yourUniqueId.'/test_'.$i;
   $config['upload_path']   = './answer-media/';
   $config['allowed_types'] = 'jpg|jpeg|gif|png';
   
   $config['overwrite']     = TRUE;

  $this->upload->initialize($config);

  if($this->upload->do_upload($answer_image))
  {
    $error += 0;
  }else{
    $error += 1;
  }
 }

// if(isset($_FILES['answer_image']['name'])) {
// $fileArray = $_FILES['answer_image']['name'];


// $i=0;
// foreach ($fileArray as $key) {
// move_uploaded_file($key,"answer-media/" );
// $i++;
// }
// }

            // $files = $_FILES;
            //     $cpt = count($_FILES['answer_image']['name']);
            //     for($i=0; $i<$cpt; $i++)
            //     {

            //         $_FILES['answer_image']['name']= $files['answer_image']['name'][$i];
            //         $_FILES['answer_image']['type']= $files['answer_image']['type'][$i];
            //         $_FILES['answer_image']['tmp_name']= $files['answer_image']['tmp_name'][$i];
            //         $_FILES['answer_image']['error']= $files['answer_image']['error'][$i];
            //         $_FILES['answer_image']['size']= $files['answer_image']['size'][$i];


            // $config= array('upload_path'=>'./answer-media/',
            //                            'allowed_types'=>'gif|jpg|png',
                                       
            //                         );

            // $this->load->library('upload', $config);



            //     if ( ! $this->upload->do_upload($answer_image))
            //     {
            //     return false;
            //     }
            //     else
            //     {
            //        return true;
            //     }
            // }
                
                }

    public function add_more_question($id = '', $message = '')
    {
        if (!is_numeric($id)) {
            show_404();
        }
        $mocks = $this->exam_model->get_mock_title($id);
        if ((empty($mocks)) OR ($mocks->user_id != $this->session->userdata('user_id'))) {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Only the author can add questions.'
                    . '</div>';
            $this->view_my_mocks($message);
        } else {
            $mock_title = $mocks->title_name;
            $title_id = $mocks->title_id;
            $question_no = $this->exam_model->question_count_by_id($id) + 1;
            $this->question_form($message, $title_id, $mock_title, $question_no);
        }
    }

    public function set_time_n_random_ques_no($id, $exam_title = '', $message = '')
    {
        $data = array();
        $data['class'] = 22; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['ques_count'] = $this->exam_model->question_count_by_id($id);
        $data['message'] = $message;
        $data['exam_title'] = $exam_title;
        $data['exam_id'] = $id;
        $data['content'] = $this->load->view('form/set_time_n_random_ques_no', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function update_time_n_random_ques_no()
    {
        $ques_count = $this->input->post('ques_count', TRUE)+1;
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('duration', 'Time Duration', 'required|min_length[5]|max_length[8]');
        $this->form_validation->set_rules('random_ques', 'Total Random Question', 'required|integer|less_than['.$ques_count.']');
        if ($this->form_validation->run() == FALSE) {
            $this->set_time_n_random_ques_no($this->input->post('exam_id', TRUE),$this->input->post('exam_title', TRUE));
        } else {
            if ($this->admin_model->set_time_n_random_ques_no()) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Successfully done!'
                        . '</div>';
                $this->view_my_mocks($message);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->set_time_n_random_ques_no($this->input->post('exam_id', TRUE),$this->input->post('exam_title', TRUE),$message);
            }
        }
    }

    public function activate_category($id)
    {
        if ($this->admin_model->activate_category($id)) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Updated successfully!'
                    . '</div>';
            $this->view_categories($message);
        } else {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'An ERROR occurred! Please try again.</div>';
            $this->view_categories($message);
        }
    }

    public function update_category_name()
    {
        echo ($this->admin_model->update_category_name()) ? 'TRUE' : 'FALSE';
    }

    public function update_mock_title()
    {
        echo ($this->admin_model->update_mock_title()) ? 'TRUE' : 'FALSE';
    }

    public function update_question()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('question', 'Question', 'required|min_length[8]|max_length[100]');
        $exam_id = $this->input->post('exam_id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'An ERROR occurred! ' . validation_errors()
                    . '</div>';
            $this->view_my_mock_detail($exam_id, $message);
        } elseif ($this->admin_model->update_question()) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Updated successfully!'
                    . '</div>';
            $this->view_my_mock_detail($exam_id, $message);
        } else {
            $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
            $this->view_my_mock_detail($exam_id, $message);
        }
    }

    public function update_answer($ques_id)
    {
        echo ($this->admin_model->update_answer($ques_id)) ? 'TRUE' : 'FALSE';
    }

    public function change_password()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old-pass', 'Current Password', 'required|min_length[6]');
        $this->form_validation->set_rules('new-pass', 'New Password', 'required|min_length[6]|matches[re-new-pass]');
        $this->form_validation->set_rules('re-new-pass', 'Re-type New Password', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $this->load->model('user_model');
            $data = $this->user_model->get_user_info();
            
            if ($data->user_id != $this->session->userdata('user_id')) {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Your can\'t change other user\'s password!</div>';
                $this->index($message);
            } elseif (($data->user_pass != md5($this->input->post('old-pass')))) {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Your old password doesn\'t match! Please try again.</div>';
                $this->index($message);
            } elseif (($data->user_pass == md5($this->input->post('new-pass')))) {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'You entered your old password! Please try different one.</div>';
                $this->index($message);
            } else {
                $info = array();
                $info['user_pass'] = md5($this->input->post('new-pass'));
                if ($this->admin_model->update_password($info)) {
                    $message = '<div class="alert alert-success alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'Password Changed successfully!'
                            . '</div>';
                    $this->index($message);
                } else {
                    $message = '<div class="alert alert-danger alert-dismissable">'
                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                            . 'An ERROR occurred! Please try again.</div>';
                    $this->index($message);
                }
            }
        }
    }

    public function update_profile_info()
    {
        echo ($this->admin_model->update_profile_info()) ? 'TRUE' : 'FALSE';
    }

    public function mute_category($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $user_role_id = $this->session->userdata('user_role_id');
        if ($user_role_id <= 3) {
            if ($this->admin_model->mute_category($id)) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'This category has muted successfully! No one can create new exam in this category.'
                        . '</div>';
                $this->view_categories($message);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->view_categories($message);
            }
        } else {
            exit('<h2>You are not Authorised person to do this!</h2>');
        }
    }

    public function delete_category($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $user_role_id = $this->session->userdata('user_role_id');
        if ($user_role_id <= 3) {
            $key = $this->admin_model->delete_category_name($id);
            if ($key == 'deleted') {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'The category has Deleted successfully!'
                        . '</div>';
                $this->view_categories($message);
            } elseif ($key == 'muted') {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'This category have exams, so can\'t be deleted but muted successfully! No one can create new exam in this category.'
                        . '</div>';
                $this->view_categories($message);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->view_categories($message);
            }
        } else {
            exit('<h2>You are not Authorised person to do this!</h2>');
        }
    }

    public function delete_exam($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $user_id = $this->session->userdata('user_id');
        $user_role_id = $this->session->userdata('user_role_id');
        if ($user_role_id <= 2) {
            if ($this->admin_model->delete_exam_with_all_questions($id)) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'The Exam has Deleted successfully with all related questions and answers!'
                        . '</div>';
                $this->view_my_mocks($message);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->view_my_mocks($message);
            }
        } else {
            $author = $this->exam_model->get_mock_by_id($id);
            if (empty($author) OR (($user_role_id != 3) && ($author->user_id != $user_id))) {
                exit('<h2>You are not Authorised person to do this!</h2>');
            }
            if ($this->admin_model->mute_exam($id)) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'The Exam is muted successfully! Admin will review the request.'
                        . '</div>';
                $this->view_my_mocks($message);
            } else {
                $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
                $this->view_my_mocks($message);
            }
        }
    }

    public function delete_question($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $author = $this->exam_model->get_question_by_id($id);
        if (empty($author) OR ($author->user_id != $this->session->userdata('user_id'))) {
            exit('<h2>You are not Authorised person to do this!</h2>');
        }
        $ques_id = $author->exam_id;
        if ($this->admin_model->delete_question_with_answers($id)) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Successfully Deleted!'
                    . '</div>';
            $this->view_my_mock_detail($ques_id, $message);
        } else {
            $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
            $this->view_my_mock_detail($ques_id, $message);
        }
    }

    public function delete_answer($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $author = $this->exam_model->get_answer_by_id($id);
        if (empty($author) OR ($author->user_id != $this->session->userdata('user_id'))) {
            exit('<h2>You are not Authorised person to do this!</h2>');
        }
        $ques_id = $author->exam_id;
        if ($this->admin_model->delete_answer($id)) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Successfully Deleted!'
                    . '</div>';
            $this->view_my_mock_detail($ques_id, $message);
        } else {
            $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
            $this->view_my_mock_detail($ques_id, $message);
        }
    }

}
