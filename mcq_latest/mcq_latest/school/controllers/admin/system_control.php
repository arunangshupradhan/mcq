<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_control extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('system_model');
        $this->load->model('admin_model');
    }

    public function index($code = '', $message = '')
    {
        redirect(base_url('index.php/admin'));
        // if (($code == '') && ($_GET['code'] != sha1('GALUA'))) {
        //     show_404 ();
        // } elseif (($code != '') && ($code != sha1('GALUA'))) {
        //     show_404 ();
        // } else {
        //     $data=array();
        //     $data['message']   = $message;
        //     $data['time_zone'] = $this->system_model->get_timezone();
        //     $data['currencies']= $this->system_model->get_currencies();
        //     $this->load->view('admin/system_settings',$data);
        // }
    }

    public function view_settings($message = '')
    {

        if (!$this->session->userdata('log')) {
            show_404 ();
        }
        $userId=$this->session->userdata('user_id');
        $data=array();
        $data['class']      = 32;   // class control value left digit for main manu rigt digit for submenu
        $data['header']     = $this->load->view('header/admin_head','',TRUE);
        $data['top_navi']   = $this->load->view('header/admin_top_navigation',$data,TRUE);
        $data['sidebar']    = $this->load->view('sidebar/admin_sidebar',$data,TRUE);
        $data['message']    = $message;
        $data['sys_set']    = $this->system_model->get_system_info();
        $data['sys_content']= $this->system_model->get_system_content();
        $data['payment_set']= $this->system_model->get_payment_settings();
        $data['currencies']= $this->system_model->get_currencies();
        $data['content']    = $this->load->view('admin/view_system_info',$data,TRUE);
        $data['footer']     = $this->load->view('footer/admin_footer',$data,TRUE);
        $this->load->view('dashboard',$data);
    }
    
    public function update_system_info()
    {
        if (!$this->session->userdata('log')) {
            show_404 ();
        }
        echo ($this->system_model->update_system_info())?'TRUE':'FALSE';
        $this->system_model->set_system_info_to_session();
    }

    public function update_content()
    {
        if (!$this->session->userdata('log')) {
            show_404 ();
        }
        echo ($this->system_model->update_content())?'TRUE':'FALSE';
    }
    
    public function update_paypal_info()
    {
        if (!$this->session->userdata('log')) {
            show_404 ();
        }
        echo ($this->system_model->update_paypal_info())?'TRUE':'FALSE';
    }
    
    public function set_system_config()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'Full Name', 'required');
        $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('user_pass','Password','required|min_length[4]');
        $this->form_validation->set_rules('user_passcf','Confirm Password','required|min_length[4]|matches[user_pass]');
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'required');
        $this->form_validation->set_rules('time_zone','Time Zone','callback_time_zone_check');
        $this->form_validation->set_rules('about', 'About Us', 'required');
        $this->form_validation->set_rules('wc_message', 'Welcome Message', 'required');
        $this->form_validation->set_rules('support_email', 'Support Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->index(sha1('GALUA'));
        } else {
            date_default_timezone_set($this->input->post('time_zone'));
            $this->load->model('login_model');
            $info = array();
            $info['user_id'] = 1;
            $info['user_name'] = $this->input->post('user_name',TRUE);
            $info['user_email'] = $this->input->post('user_email',TRUE);
            $info['user_phone'] = $this->input->post('user_phone',TRUE);
            $info['user_role_id'] = 1;
            $info['user_pass'] = md5($this->input->post('user_pass'));
            $info['user_from'] = date('Y-m-d H:i:s');
            $info['active'] = 1;
            if ($this->db->insert('users',$info)) {
                $data = array();
                $data['brand_id'] = 1;
                $data['brand_name'] = $this->input->post('brand_name',TRUE);
                $data['brand_slogan'] = $this->input->post('brand_slogan',TRUE);
                $data['commercial'] = $this->input->post('business_type',TRUE);
                $data['local_time_zone'] = $this->input->post('time_zone',TRUE);
                $data['student_can_register'] = $this->input->post('student_can_register',TRUE);
                $data['show_video_on_home'] = $this->input->post('show-video',TRUE);
                $data['support_email'] = $this->input->post('support_email',TRUE);
                $data['support_phone'] = $this->input->post('support_phone',TRUE);
                $data['facbook_url'] = $this->input->post('fb',TRUE);
                $data['googleplus_url'] = $this->input->post('googleplus',TRUE);
                $data['you_tube_url'] = $this->input->post('youtube',TRUE);
                $data['flickr_url'] = $this->input->post('flickr',TRUE);
                $data['twitter_url'] = $this->input->post('twitter',TRUE);
                $data['pinterest_url'] = $this->input->post('pinterest',TRUE);
                $data['last_update'] = date('Y-m-d');
                if ($this->system_model->set_system_info($data)) {

                    $counter = array();
                    $counter['wc_title'] = $this->input->post('wc_msg_head',TRUE);
                    $counter['wc_msg'] = $this->input->post('wc_message',TRUE);
                    $counter['about_us'] = $this->input->post('about',TRUE);
                    foreach ($counter as $key => $value) {
                        $content = array();
                        $content['content_type'] = $key;
                        $content['content_data'] = $value;
                        $this->db->insert('content', $content);
                    }

                    $paypal_info = array();
                    $paypal_info['id'] = 1;
                    $paypal_info['currency_id'] = $this->input->post('currency',TRUE);
                    $paypal_info['api_username'] = $this->input->post('pp_username',TRUE);
                    $paypal_info['api_pass'] = $this->input->post('pp_pass',TRUE);
                    $paypal_info['api_signature'] = $this->input->post('pp_sign',TRUE);
                    $paypal_info['sandbox'] = $this->input->post('pp_status',TRUE);
                    if ($this->system_model->set_payment_info($paypal_info)) {
                        if (count($_POST) > 0) {
                            $_POST = array();
                        }
                        $message =   '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                                 . 'Welcome to '.$data['brand_name'].'!. Please login with your email address and password.'
                                 . '</div>';
                        $this->session->set_flashdata('message',$message);
                        redirect(base_url('index.php/admin'));
                    } else {
                        $this->db->where('user_id',1)->delete('users');
                        $this->db->where('brand_id',1)->delete('settings');
                        $message =   '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                                 . 'ERROR !!! Please check your PayPal settings and try again !</div>';
                        $this->index(sha1('GALUA'), $message);
                    }
                } else {
                    $this->db->where('user_id',1)->delete('users');
                    $message =   '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                             . 'ERROR !!! Please try again !</div>';
                    $this->index(sha1('GALUA'), $message);
                }
            } else {
                $message =   '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="TRUE">&times;</button>'
                             . 'ERROR !!! Please try again !</div>';
                $this->index(sha1('GALUA'), $message);
            }
        }
    }
    
    public function time_zone_check($val) 
    {     /* Callback Function for form validation  */
        if ($val == 'none') {
            $this->form_validation->set_message('time_zone_check', 'Select Time Zone.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
