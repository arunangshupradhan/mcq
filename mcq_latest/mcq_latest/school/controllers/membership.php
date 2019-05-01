<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Membership extends CI_Controller
{
    public function __construct()
    {
    	 
    	
        parent::__construct();

        $this->load->model('membership_model');
        date_default_timezone_set($this->session->userdata['time_zone']);
        
        if ($this->session->userdata('user_id') != 6) {
            redirect(base_url());
        }
        
        
    }

    public function index($message = '')
    {
    	
    	
    	
    	
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $data = array();
        $data['class'] = 81; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', $data, TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['memberships'] = $this->membership_model->get_all_memberships();
        $data['features'] = $this->membership_model->get_features();
        $data['content'] = $this->load->view('admin/view_memberships', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }


    public function payment_process($id = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control/register'));
        }
        if (($id == '') OR !is_numeric($id)) {
            show_404();
        }
        $membership = $this->membership_model->get_offer_by_id($id);
        if (!$membership) {
            show_404();
        }
        $this->load->model('admin_model');
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
            'amount' => $membership->price_table_cost,
            'currency' => $this->session->userdata('currency_code'),
            'description' => $membership->price_table_title,
            'return_url' => base_url('index.php/membership/payment_complete/' . $id),
            'cancel_url' => base_url());

        $this->load->library('merchant');
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
        }
    }

    public function payment_complete($id)
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/login_control'));
        }
        $this->load->model('exam_model');
        $this->load->model('admin_model');
        $membership = $this->membership_model->get_offer_by_id($id);
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
            'amount' => $membership->price_table_cost,
            'currency' => $this->session->userdata('currency_code'),
            'cancel_url' => base_url('index.php/membership'));

        $this->load->library('merchant');
        $this->merchant->load('paypal_express');
        $this->merchant->initialize($settings);
        $response = $this->merchant->purchase_return($params);

        if ($response->success()) {
            $duration = '+ '. $membership->offer_duration.' '. $membership->offer_type.'';

            $subscription_start = date("Y-m-d");
            $subscription_end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($subscription_start)) . $duration));

            $subscription_info = array();
            $subscription_info['subscription_id'] = $id;
            $subscription_info['subscription_start'] = strtotime($subscription_start);
            $subscription_info['subscription_end'] = strtotime($subscription_end);

            $this->admin_model->set_subscription($subscription_info);

            $message = '<div class="alert alert-sucsess alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'You subscribed successfully!</div>';
            $this->session->set_flashdata('message', $message);
            $data = array();
            $data['PayerID'] = $this->input->get('PayerID');
            $data['token'] = $this->input->get('token');
            $data['exam_title'] = $membership->price_table_title;
            $data['pay_amount'] = $membership->price_table_cost;
            $data['currency_code'] = $this->session->userdata('currency_code') . ' ' . $this->session->userdata('currency_symbol');
            $data['method'] = 'PayPal';
            $data['gateway_reference'] = $response->reference();
            $token_id = $this->exam_model->set_payment_detail($data);

            $this->session->set_userdata('payment_token', $data['token']);
            $this->session->set_userdata('pay_id', $token_id);

            redirect(base_url() . 'login_control/dashboard_control/' . $this->session->userdata('user_id'));
        } else {
            $message = $response->message();
            echo('Error processing payment: ' . $message);
            exit;
        }
    }

    public function add($message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $data = array();
        $data['class'] = 82; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', $data, TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['content'] = $this->load->view('form/create_offer_form', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function save()
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('membership_type', 'Membership Type', 'required');;
        $this->form_validation->set_rules('feature[0]', 'feature 1', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->add_feature();
        } else {
            if ($this->membership_model->save_offer()) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Offer Added Successfully!.'
                        . '</div>';
                $this->index($message);
            } else {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Somthing is wrong!';
                $this->add($message);
            }
        }
    }

    public function edit($id = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        if (($id == '') OR (!is_numeric($id))) show_404();
        $data = array();
        $data['class'] = 81; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', $data, TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        // $data['message'] = $message;
        $data['offer'] = $this->membership_model->get_offer_by_id($id);
        $data['features'] = $this->membership_model->get_features_by_parent_id($id);
        $data['content'] = $this->load->view('form/edit_offer_form', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function update()
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('membership_id', 'Membership Type', 'required');;
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('membership_id'));
        } else {
            if ($this->membership_model->update_offer()) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Offer updated successfully!.'
                        . '</div>';
                $this->index($message);
            } else {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Somthing is wrong!';
                $this->edit($this->input->post('membership_id'));
            }
        }
    }

    public function delete($id = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        if (($id == '') OR (!is_numeric($id))) show_404();

        if ($this->membership_model->delete_offer($id)) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Offer deleted successfully!.'
                    . '</div>';
            $this->index($message);
        } else {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Somthing is wrong!';
            $this->index($message);
        }
    }

    public function set_top_offer(){
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        if ($this->membership_model->set_top_offer()) {
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Updated!.'
                    . '</div>';
            $this->index($message);
        } else {
            $message = '<div class="alert alert-danger alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Somthing is wrong!';
            $this->index($message);
        }
    }

    public function add_feature($message = '')
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $data = array();
        $data['class'] = 83; // class control value left digit for main manu rigt digit for submenu
        $data['header'] = $this->load->view('header/admin_head', $data, TRUE);
        $data['top_navi'] = $this->load->view('header/admin_top_navigation', $data, TRUE);
        $data['sidebar'] = $this->load->view('sidebar/admin_sidebar', $data, TRUE);
        $data['message'] = $message;
        $data['memberships'] = $this->membership_model->get_all_memberships();
        $data['content'] = $this->load->view('form/add_feature_form', $data, TRUE);
        $data['footer'] = $this->load->view('footer/admin_footer', $data, TRUE);
        $this->load->view('dashboard', $data);
    }

    public function save_features()
    {
        if (!$this->session->userdata('log')) {
            redirect(base_url('index.php/admin'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('membership_id', 'Membership Type', 'callback_membership_id_check');;
        $this->form_validation->set_rules('feature[0]', 'feature 1', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->add_feature();
        } else {
            if ($this->membership_model->save_features()) {
                $message = '<div class="alert alert-success alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Feature Added Successfully!.'
                        . '</div>';
                $this->index($message);
            } else {
                $message = '<div class="alert alert-danger alert-dismissable">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                        . 'Somthing is wrong!';
                $this->add_feature($message);
            }
        }
    }

    public function membership_id_check($val)
    {
        //Callback Function for form validation
        if ($val == 0) {
            $this->form_validation->set_message('membership_id_check', 'Select membership type.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}