<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Guest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('system_model');
        $this->load->model('admin_model');
    }

    public function index($message = '')
    {
        $this->system_model->set_system_info_to_session();
        $this->load->model('exam_model');
        $this->load->model('blog_model');
        $this->load->model('noticeboard_model');
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['message'] = $message;
        if (!$this->session->userdata('log')) {
            $data['user_role'] = $this->admin_model->get_user_role();
            $data['modal'] = $this->load->view('modals/login_n_register', $data, TRUE);
        }
        $data['latest_exams'] = $this->exam_model->get_latest_exams(5);
        $data['latest_blogs'] = $this->blog_model->get_latest_blogs(5);
        $data['notices'] = $this->noticeboard_model->get_active_notice();
        //echo "<pre/>"; print_r($data['notices']); exit();

        $data['content'] = $this->load->view('content/home_page', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function pricing($message = '')
    {
        $this->load->model('membership_model');
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['extra_head'] = $this->load->view('plugin_scripts/price-table', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['message'] = $message;
        if (!$this->session->userdata('log')) {
            $data['user_role'] = $this->admin_model->get_user_role();
            $data['modal'] = $this->load->view('modals/login_n_register', $data, TRUE);
        }
        $data['memberships'] = $this->membership_model->get_all_memberships();
        $data['features'] = $this->membership_model->get_features();
        $data['content'] = $this->load->view('content/pricing', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function about_us($message = '')
    {
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['message'] = $message;
        if (!$this->session->userdata('log')) {
            $data['user_role'] = $this->admin_model->get_user_role();
            $data['modal'] = $this->load->view('modals/login_n_register', $data, TRUE);
        }
        $data['content'] = $this->load->view('content/about_us', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function view_faqs($message = '')
    {
        $data = array();
        $data['header'] = $this->load->view('header/head', '', TRUE);
        $data['top_navi'] = $this->load->view('header/top_navigation', $data, TRUE);
        $data['message'] = $message;
        if (!$this->session->userdata('log')) {
            $data['user_role'] = $this->admin_model->get_user_role();
            $data['modal'] = $this->load->view('modals/login_n_register', $data, TRUE);
        }
        $data['faqs'] = $this->system_model->get_faqs();
        $data['content'] = $this->load->view('content/faqs', $data, TRUE);
        $data['footer'] = $this->load->view('footer/footer', $data, TRUE);
        $this->load->view('home', $data);
    }

    public function contact()
    {
        if ($this->input->post('token') == $this->session->userdata('token'))
            exit('Can\'t re-submit the form');
        $sender = $this->input->post('name', TRUE);
        $sender_email = $this->input->post('email', TRUE);
        if ($this->admin_model->save_message('inbox', $sender, $sender_email)) {
            $this->session->set_userdata('token', $this->input->post('token'));
            $message = '<div class="alert alert-success alert-dismissable">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                    . 'Send successfully.!'
                    . '</div>';
            $this->index($message);
        } else {
            $message = '<div class="alert alert-danger">An ERROR occurred! Please try again.</div>';
            $this->index($message);
        }
    }
}
