<?php
error_reporting(0);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Exam_control extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('exam_model');
        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->model('membership_model');
    }

    public function index()
    {
        if ($this->input->post('token') == $this->session->userdata('token')) {
            exit('Can\'t re-submit tview_resultshe form');
        }
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $result_id = $this->exam_model->evaluate_result();
        if ($result_id) {
            $this->session->set_userdata('token', $this->input->post('token'));
            $this->view_result_detail($result_id);
        } else {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'An ERROR occurred! Please contact to admin.</div>';
            $this->view_all_mocks($message);
        }
    }

    public function view_all_mocks($subscription_id)
    {
        $data = array();
        $data['share'] = true;
        $data['header'] = $this->load->view('header/head', '', TRUE);
        if($subscription_id){
            $data['mocks'] = $this->exam_model->get_mocks_by_course($subscription_id);
        }else{
            $data['mocks'] = $this->exam_model->get_all_mocks();
        }
        $user_id = $this->session->userdata('user_id');
        $data['user_details'] = $this->user_model->get_user_info($user_id);
        $data['subscription_details'] = $this->membership_model->get_offer_by_id($subscription_id);
        $data['categories'] = $this->exam_model->get_categories();
        $data['mock_count'] = $this->exam_model->mock_count($data['categories']);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['user_role'] = $this->admin_model->get_user_role();
        $data['content'] = $this->load->view('content/view_mock_list', $data, TRUE);
        $data['message'] = '';
        $data['subscription_id'] = $subscription_id;
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function view_mocks_by_category($cat_id)
    {
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['categories'] = $this->exam_model->get_categories();
        if ($data['categories']) {
            foreach ($data['categories'] as $value) {
                if ($value->category_id == $cat_id) {
                    $exist = TRUE;
                    $data['mocks'] = $this->exam_model->get_mocks_by_category($cat_id);
                    $data['category_name'] = $this->db->get_where('categories', array('category_id' => $cat_id))->row()->category_name;
                //    $data['category_name'] = $data['mocks'][0]->category_name;
                    break;
                }
            }
            if (!isset($exist) OR !$exist) {
                $data['message'] = 'Unknown Category!';
            }
        }
        $data['mock_count'] = $this->exam_model->mock_count($data['categories']);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['user_role'] = $this->admin_model->get_user_role();
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $data['content'] = $this->load->view('content/view_mock_list', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function mocks_type()
    {
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['categories'] = $this->exam_model->get_categories();
        $data['mock_count'] = $this->exam_model->mock_count($data['categories']);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['user_role'] = $this->admin_model->get_user_role();
        if($this->session->userdata('user_id')){
            $data['mocks'] = $this->exam_model->get_mocks_by_price_for_loggedin_user();
        }


        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $data['content'] = $this->load->view('content/view_mock_list', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function view_exam_summery($id = '', $message = '')
    {
        if (!is_numeric($id)) show_404();

        $data = array();
        $data['share'] = true;
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['mock'] = $this->exam_model->get_mock_by_id($id);
        if (!$data['mock']) show_404();
        $data['message'] = $message;
        $data['content'] = $this->load->view('content/exam_summery', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function view_exam_instructions($id = '', $message = '')
    {
        if (!is_numeric($id)) {
            show_404();
        }
        if (!$this->session->userdata('log')) {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Please login to start the exam!</div>';
            $this->session->set_flashdata('message', $message);
            redirect(base_url('index.php/login_control'));
        }
        $data = $checck_valid_exam = array();
        $checck_valid_exam = false;
        $data['mock'] = $mock = $this->exam_model->get_mock_by_id($id);
        $price_table_id = $mock->price_table_id;
        $checck_valid_exam = $this->exam_model->check_valid_exam($price_table_id);
        if(empty($checck_valid_exam)){
            redirect(base_url());
        }
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['message'] = $message;

        if (!$data['mock']) {
            show_404();
        }
        $data['content'] = $this->load->view('content/exam_instructions', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function start_exam($id = '', $message = '')
    {
        $this->load->helper('cookie');
        if (($id == '') OR !is_numeric($id)) {
            show_404();
        }
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['message'] = $message;
        $data['mock'] = $this->exam_model->get_mock_by_id($id);
        if (!$data['mock']) {
            show_404();
        }
        if ($data['mock']->exam_price != 0) {
            $user_info = $this->db->get_where('users', array('user_id' => $this->session->userdata('user_id')))->row();
            if (($user_info->subscription_id == 0) OR ($user_info->subscription_end <= now())) {
                $payment_token = $this->exam_model->get_pay_token($id, $this->session->userdata('pay_id'));
                if (!$payment_token) {
                    redirect('exam_control/payment_process/' . $id, 'refresh');
                }
            }
        }

        if($this->input->cookie('ExamTimeDuration')){
            $data['duration'] = $this->input->cookie('ExamTimeDuration', TRUE)-1;
        } else {
            $data['duration'] = $data['mock']->duration;
        }

        $total_questions = $this->exam_model->get_mock_detail($id);
        $counter = count($total_questions);
        $questions = array();
        $i=0;
        do{
            $index = rand(0, $counter-1);
            if (array_key_exists($index, $questions)) {
                continue;
            }
            $questions[$index] = $total_questions[$index];
            $i++ ;
        }while($i < $data['mock']->random_ques_no);

        $data['questions'] = $questions;
        $data['ques_count'] = $counter;
        $data['answers'] = $this->exam_model->get_mock_answers($data['questions']);
        $data['content'] = $this->load->view('content/start_exam', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
        $this->session->unset_userdata('pay_id');
        $this->session->unset_userdata('payment_token');
    }

    public function payment_process($id = '', $message = '')
    {

        if (($id == '') OR !is_numeric($id)) {
            show_404();
        }
        $user_id = $this->session->userdata('user_id');
        $item_info = $this->exam_model->get_item_detail($id);
        if (!$item_info) {
            show_404();
        }
        $payment_settings = $this->admin_model->get_paypal_settings();
        if ($payment_settings->sandbox == 1) {
            $mode = TRUE;
        }else{
            $mode = FALSE;
        }

        $settings = array(
            'username' => $payment_settings->api_username,
            'password' => $payment_settings->api_pass,
            'signature' => $payment_settings->api_signature,
            'test_mode' => $mode
        );
        $params = array(
            'amount' => $item_info->exam_price,
            'currency' => $this->session->userdata('currency_code'),
            'description' => $item_info->title_name,
            'return_url' => base_url('index.php/exam_control/payment_complete/' . $id),
            'cancel_url' => base_url('index.php/exam_control/view_all_mocks')
        );
        $data['params'] = $params;
        $data['settings'] = $settings;
        $data['user_details'] = $this->user_model->get_user_info($user_id);
        $this->load->view('form/PayUMoney_form', $data);

      /*  $this->load->library('merchant');
        $this->merchant->load('paypal_express');
        $this->merchant->initialize($settings);
        $response = $this->merchant->purchase($params);

        if ($response->status() == Merchant_response::FAILED) {
            $message = $response->message();
            echo('Error processing payment: ' . $message);
            exit;
        } else {
            $data = array();
            $data['order_token'] = sha1(rand(0, 999999) . $id);
            $data['exam_id'] = $id;
            $set_token = $this->exam_model->set_order_token($data);
        }*/
    }

    public function payment_complete($id)
    {

        $item_info = $this->exam_model->get_item_detail($id);

       /* $payment_settings = $this->admin_model->get_paypal_settings();
        if ($payment_settings->sandbox == 1) {
            $mode = TRUE;
        }else{
            $mode = FALSE;
        }
        $settings = array(
            'username' => $payment_settings->api_username,
            'password' => $payment_settings->api_pass,
            'signature' => $payment_settings->api_signature,
            'test_mode' => $mode
        );*/
       /* $params = array(
            'amount' => $item_info->exam_price,
            'currency' => $this->session->userdata('currency_code'),
            'cancel_url' => base_url('index.php/exam_control/view_all_mocks'));*/

       // $this->load->library('merchant');
        //$this->merchant->load('paypal_express');
       // $this->merchant->initialize($settings);
        //$response = $this->merchant->purchase_return($params);
        $response = $_POST;
        $user_id = $this->session->userdata('user_id');
       if ( $response['status'] == 'success' ) {
            $message = '<div class="alert alert-sucsess alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Payment Successful!</div>';
            $this->session->set_flashdata('message', $message);
            $data = array();
            $data['PayerID'] = $user_id;
            $data['token'] = $_POST['txnid'];
            $data['exam_title'] = $_POST['productinfo'];
            $data['pay_amount'] = $_POST['amount'];
            $data['currency_code'] = $this->session->userdata('currency_code') . ' ' . $this->session->userdata('currency_symbol');
            $data['method'] = 'PayUmoney';
            $data['gateway_reference'] = $_POST['payuMoneyId'];
            $data['response'] = serialize($_POST);
            $token_id = $this->exam_model->set_payment_detail($data);

            $this->session->set_userdata('payment_token', $data['token']);
            $this->session->set_userdata('pay_id', $token_id);

            redirect(base_url() . 'exam_control/view_exam_instructions/' . $id);
        } else {
            //$message = $response->message();
           $message = '';
            echo('Error processing payment' . $message);
            exit;
        }
    }

    public function view_results($message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $userId = $this->session->userdata('user_id');
        $data = array();
        $data['class'] = 25; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        if ($this->session->userdata('user_role_id') <= 4) {
            $data['results'] = $this->exam_model->get_all_results();
            $data['content'] = $this->load->view('content/view_all_results', $data, TRUE);
        } else {
            $data['results'] = $this->exam_model->get_my_results($userId);
            $data['content'] = $this->load->view('content/view_my_results', $data, TRUE);
        }
        $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
        $this->load->view('dashboard', $data);
    }
    public function my_course($message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $userId = $this->session->userdata('user_id');
        $details = $this->exam_model->get_user_info($userId);
        $data = array();
        $data['course'] = $data['course_details'] = $data['online_class_details'] = array();
        if(($details->subscription_id)&&(time() >= $details->subscription_start) && (time() <= $details->subscription_end) ){
            $data['course'] = $course = $this->exam_model->get_subscription($details->subscription_id);
            $data['course_details'] = $this->exam_model->get_features_by_parent_id($course->price_table_id);
            $data['online_class_details'] = $this->exam_model->get_online_class_by_subscription_id($details->subscription_id);
        }


        $data['class'] = 25; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['content'] = $this->load->view('content/my_course', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
        $this->load->view('dashboard', $data);
    }
    public function live_video_class($message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $userId = $this->session->userdata('user_id');
        $details = $this->exam_model->get_user_info($userId);
        $data = array();
        $data['course'] = $data['course_details'] = $data['online_class_details'] = array();
        if(($details->subscription_id)&&(time() >= $details->subscription_start) && (time() <= $details->subscription_end) ){
            $data['course'] = $course = $this->exam_model->get_subscription($details->subscription_id);
            $data['course_details'] = $this->exam_model->get_features_by_parent_id($course->price_table_id);
            $data['online_class_details'] = $this->exam_model->get_online_class_by_subscription_id($details->subscription_id);
        }


        $data['class'] = 25; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['content'] = $this->load->view('content/live_video_class', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
        $this->load->view('dashboard', $data);
    }

    public function view_result_detail($id = '', $message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        if (!is_numeric($id)) {
            show_404();
        }
        $author = $this->exam_model->view_result_detail($id);
        $exam_set_id = $author->exam_id;
        if (empty($author)) {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Not available!</div>';
            $this->view_results($message);
        } else {
            if (($author->participant_id != $this->session->userdata('user_id')) && ($this->session->userdata('user_id') > 3)) {
                exit('<h2>You are not Authorised person to do this!</h2>');
            } else {
                $data = array();

                /*answer list*/
                $question_list = $this->exam_model->question_list($exam_set_id);

                $q = 0;
                $details_array = array();

                foreach ($question_list as $q_list){
                    $options = array();
                    $options = $this->exam_model->get_answer_options_by_question_id($q_list->ques_id);
                    $details_array[$q] = $q_list;
                    $k = 0;
                    $all_option = array();
                    foreach ($options as $optn){

                        $all_option[$k] = $optn;
                        $all_option[$k]->ans = $this->exam_model->get_user_answer_by_answer_id_and_result_id($id,$optn->ans_id);
                        $k++;
                    }
                    $details_array[$q]->all_options = $all_option;
                    $q++;
                }
                $data['answer_list'] = $details_array;

                /*answer list end*/
                $data['class'] = 25; // class control value left digit for main manu rigt digit for submenu
                $data['header'] = $this->load->view('header/admin_head', '', TRUE);
                $data['top_navi'] = $this->load->view('header/admin_top_navigation', '', TRUE);
                $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
                $data['message'] = $message;
                $data['results'] = $author;
                $data['content'] = $this->load->view('content/result_detail', $data, TRUE);
                $data['footer'] = $this->load->view('footer/admin_footer', '', TRUE);
                $this->load->view('dashboard', $data);
            }
        }
    }

    public function delete_results($id = '')
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $author = $this->exam_model->get_result_by_id($id);
        if (empty($author) OR (($author->user_id != $this->session->userdata('user_id')) && ($this->session->userdata('user_id') > 2))) {
            show_404();
        }
        if ($this->exam_model->delete_result($id)) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Successfully Deleted!'
                    . '</div>';
            $this->view_results($message);
        } else {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'An ERROR occurred! Please try again.</div>';
            $this->view_results($message);
        }
    }
}
