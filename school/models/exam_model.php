<?php

class Exam_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_mocks()
    {
        $result = $this->db->select('*')
                ->select("exam_title.active AS exam_active")
                ->from('exam_title')
                ->join('categories', 'categories.category_id = exam_title.category_id')
                ->join('users', 'users.user_id = exam_title.user_id')
                ->get()
                ->result();
        return $result;
    }

    public function get_categories()
    {
        $this->db->order_by('category_name', 'asc');
        $result = $this->db->get('categories')->result();
        return $result;
    }

    public function get_categories_with_author()
    {
        $this->db->select('*');
        $this->db->select("users.active AS user_active");
        $this->db->select("categories.active AS category_active");
        $this->db->from('categories');
        $this->db->join('users', 'users.user_id = categories.created_by');
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_mocks_by_category($cat_id)
    {
        $result = $this->db->select('*')
                        ->select("exam_title.active AS exam_active")
                        ->from('exam_title')
                        ->where('exam_title.category_id', $cat_id)
                        ->join('categories', 'categories.category_id = exam_title.category_id')
                        ->join('users', 'users.user_id = exam_title.user_id')
                        ->get()->result();
        return $result;
    }

    public function get_latest_exams($count){
        $result = $this->db->select('*')
                        ->select("exam_title.active AS exam_active")
                        ->order_by('exam_title.title_id', 'desc')
                        ->from('exam_title')
                        ->limit($count)
                        ->join('categories', 'categories.category_id = exam_title.category_id')
                        ->join('users', 'users.user_id = exam_title.user_id')
                        ->get()->result();
        return $result;
    }

    public function get_mocks_by_price($type)
    {
        if($type === 'free'){
            $result = $this->db->select('*')
                            ->select("exam_title.active AS exam_active")
                            ->from('exam_title')
                            ->where('exam_title.exam_price', 0)
                            ->join('categories', 'categories.category_id = exam_title.category_id')
                            ->join('users', 'users.user_id = exam_title.user_id')
                            ->get()->result();
        }else if($type === 'paid'){
            $result = $this->db->select('*')
                            ->select("exam_title.active AS exam_active")
                            ->from('exam_title')
                            ->where('exam_title.exam_price >', 0)
                            ->join('categories', 'categories.category_id = exam_title.category_id')
                            ->join('users', 'users.user_id = exam_title.user_id')
                            ->get()->result();
        }else{
            redirect(base_url('exam_control/view_all_mocks'));
        }
        return $result;
    }

    public function get_mock_title($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $this->db->select('*');
        $this->db->where('title_id', $id);
        $this->db->from('exam_title');
        $result = $this->db->get()->row();
        return $result;
    }

    public function get_mock_detail($id)
    {
        if (!is_numeric($id)) {
            return FALSE;
        }
        $this->db->where('exam_id', $id);
        $result = $this->db->get('questions')->result();
        return $result;
    }

    public function get_mock_answers($info)
    {
        $data = array();
        foreach ($info as $value) {
            $data[$value->ques_id][] = $this->db->where('ques_id', $value->ques_id)
                    ->from('answers')
                    ->get()
                    ->result();
        }
        return $data;
    }

    public function mock_count($info)
    {
        $data = array();
        foreach ($info as $value) {
            $data[$value->category_id] = $this->db->where('category_id', $value->category_id)
                    ->where("active", 1)
                    ->from('exam_title')
                    ->count_all_results();
        }
        return $data;
    }

    public function question_count_by_id($id)
    {
        $total = $this->db->where('exam_id', $id)
                ->from('questions')
                ->count_all_results();
        return $total;
    }

    public function get_item_detail($id)
    {
        $result = $this->db->select('title_name,exam_price')
                ->where('title_id', $id)
                ->from('exam_title')
                ->get()
                ->row();
        return $result;
    }

    /**
     * 
     * @param type $id
     * @return object
     */
    public function get_mock_by_id($id)
    {
        $result = $this->db->select('*')
                ->select("TIME_TO_SEC(exam_title.time_duration) AS duration")
                ->from('exam_title')
                ->where('exam_title.title_id', $id)
                ->join('categories', 'categories.category_id = exam_title.category_id', 'left')
                ->get()
                ->row();
        return $result;
    }

    public function get_question_by_id($id)
    {
        $result = $this->db->select('*')
                ->from('questions')
                ->where('questions.ques_id', $id)
                ->join('exam_title', 'exam_title.title_id = questions.exam_id', 'left')
                ->get()
                ->row();
        return $result;
    }

    public function get_answer_by_id($id)
    {
        $result = $this->db->select('*')
                ->from('answers')
                ->where('answers.ans_id', $id)
                ->join('questions', 'questions.ques_id = answers.ques_id', 'left')
                ->join('exam_title', 'exam_title.title_id = questions.exam_id', 'left')
                ->get()
                ->row();
        return $result;
    }

    public function get_all_results()
    {
        $result = $this->db->select('*')
                ->select("users.user_id AS user_id")
                ->select("result.user_id AS result_user_id")
                ->select("exam_title.user_id AS exam_title_user_id")
                ->from('result')
                ->order_by("result.exam_taken_date", "desc")
                ->join('users', 'users.user_id = result.user_id', 'left')
                ->join('exam_title', 'exam_title.title_id = result.exam_id', 'left')
                ->get()
                ->result();
        return $result;
    }

    public function get_my_results($id)
    {
        $result = $this->db->select('*')
                ->from('result')
                ->where('result.user_id', $id)
                ->order_by("result.exam_taken_date", "desc")
                ->join('users', 'users.user_id = result.user_id', 'left')
                ->join('exam_title', 'exam_title.title_id = result.exam_id', 'left')
                ->get()
                ->result();
        return $result;
    }

    public function view_result_detail($id)
    {
        $result = $this->db->select('*')
                ->select('result.user_id AS participant_id')
                ->from('result')
                ->where('result.result_id', $id)
                ->join('users', 'users.user_id = result.user_id', 'left')
                ->join('exam_title', 'exam_title.title_id = result.exam_id', 'left')
                ->get()
                ->row();
        return $result;
    }

    public function get_result_by_id($id)
    {
        $result = $this->db->select('*')
                ->from('result')
                ->where('result_id', $id)
                ->get()
                ->row();
        return $result;
    }

    public function evaluate_result()
    {
        $num_of_ans = $this->input->post('num_of_ans');
        $answers = $this->input->post('ans');
        $total_ques = $this->input->post('total_ques');
        $exam_id = $this->input->post('exam_id');
        $right_ans_count = 0;

        if (!$answers)
            return FALSE;

        foreach ($answers as $key => $answer) {
            if (is_array($answer)) {
                if (count($answer) != $num_of_ans[$key]) {
                    continue;
                } else {
                    foreach ($answer as $val) {
                        if ($val != 1) {
                            continue 2;
                        }
                    }
                    $right_ans_count++;
                }
            } else {
                if ($answer == 1) {
                    $right_ans_count++;
                }
            }
        }

        date_default_timezone_set($this->session->userdata['time_zone']);
        $result = round(($right_ans_count / $total_ques) * 100, 2);
        $data = array();
        $data['exam_id'] = $exam_id;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['result_percent'] = $result;
        $data['question_answered'] = $total_ques;
        $data['exam_taken_date'] = date('Y-m-d H:i:s');
        $this->db->insert('result', $data);
        if ($this->db->affected_rows() == 1) {
            // $this->sendEmailToAdmin();
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function sendEmailToAdmin()
    {
        $from = $this->session->userdata['support_email'];
        $to = 'f.piquion@wiboo.fr';
        $suject = 'A new exam has been taken.';
        $message_body = 'This is a automated notification to let you know that a new exam has been finished.';
        $config = Array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($suject);
        $this->email->message($message_body);
        $this->email->send();


        return TRUE;
    }

    public function delete_result($id)
    {
        $this->db->where('result_id', $id)
                ->delete('result');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function set_payment_detail($info)
    {
        $data = array();
        $data['payer_id'] = $info['PayerID'];
        $data['token'] = $info['token'];
        $data['pay_amount'] = $info['pay_amount'];
        $data['currency_code'] = $info['currency_code'];
        $data['user_id_ref'] = $this->session->userdata('user_id');
        $data['payment_reference'] = $info['exam_title'];
        $data['pay_date'] = date('Y-m-d');
        $data['pay_method'] = $info['method'];
        $data['gateway_reference'] = $info['gateway_reference'];
        $data['response'] = $info['response'];
        $this->db->insert('payment_history', $data);
        if ($this->db->affected_rows() == 1) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function get_pay_token($exam_id, $token_id)
    {
        $result = $this->db->select('*')
                ->where('pay_id', $token_id)
                ->where('token', $this->session->userdata('payment_token'))
                ->where('user_id_ref', $this->session->userdata('user_id'))
                ->from('payment_history')
                ->get()
                ->row();
        return $result;
    }
}
