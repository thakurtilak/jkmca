<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->library('permission');
        if($this->session->userdata('user'))
        {
            redirect('dashboard');
        }
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->view('login');

    }

    public function authenticate()
    {
        $post = $this->input->post();
        if($post) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password' , 'trim|required');
            if ($this->form_validation->run()) {

                $userName = $this->input->post('username');
                $password = $this->input->post('password');
                if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
                    $email = $userName;
                } else {
                    $email = $userName;
                }
                $where = array(
                    'email' => $email,
                    'password' => md5($password),
                    'status' => 'A'
                );
                $userRecord = $this->common_model->getRecord(TBL_USER, '*', $where);
                if($userRecord){
                    //declaring session
                    $userPermission = $this->permission->get_user_permissions($userRecord->id);
                    $this->session->set_userdata(array('user' => $userRecord));
                    $this->session->set_userdata(array('userId' => $userRecord->id));
                    $this->session->set_userdata(array('userPermission' => $userPermission));
                    redirect('/dashboard');
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('INVALID_LOGIN_CREDENTIALS'));
                    redirect('login');
                }

            } else{
                $this->session->set_flashdata('error',validation_errors());
                //echo "YES"; die;
                redirect('login');
            }
        } else {
            echo "Error"; exit;
        }
    }

    public function email_test(){
        $this->load->library('emailUtility');
        $to = "tilakthakur.10july@gmail.com";
        $subject = "TEST IMSV2 EMAIL";
        $template = 'test';
        $attachment = false;
        $res = EmailUtility::sendEmail($to, $subject, $template, array(), $attachment);
        var_dump($res);
        die;
    }

    public function email(){
        $to = "dthakur29@gmail.com";
        $subject = "JKMCA EMAIL TESTING";
        $txt = "Hello world!";
        $headers = "From: info@jkmca.in" . "\r\n";
        $res = mail($to,$subject,$txt,$headers);
        var_dump($res);
        die;
    }
}
