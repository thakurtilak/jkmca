<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    // set defaults
    var $permissions = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->model('job_model');
        //  load libs
        $this->load->library('permission');
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->template->set('title', 'Dashboard');
        $this->template->load('default', 'contents' , 'default/dashboard/index', array());
        //$administratorEmails = getAdministratorEmail();
        //print_r($administratorEmails); die;
    }

    /*Users change password functionality*/
    public function change_password(){
        $postData = $this->input->post();
        if($postData){
            //echo "<pre>"; print_r($postData); exit;
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
            if ($this->form_validation->run()) {
                $current_password = $postData['current_password'];
                $new_password = $postData['new_password'];
                $confirm_password = $postData['confirm_password'];
                if ($new_password == $confirm_password) {
                    $where = array(
                        'password' => md5($current_password)
                    );
                    $userRecord = $this->common_model->getRecord(TBL_USER, 'id', $where);
                    if($userRecord) {
                        if ($new_password == $current_password) {
                            $this->session->set_flashdata('error', "New password should not be same as current password.");
                            redirect('/dashboard/change-password');
                        }

                        $updateArray = array(
                            'password' => md5($new_password)
                        );
                        $where = array('id' => $userRecord->id);
                        $this->common_model->update(TBL_USER, $updateArray, $where);
                        $this->session->set_flashdata('success', 'Password has been change successfully');
                    } else {
                        $this->session->set_flashdata('error', "Your current password does not match.");
                    }
                } else {
                    $this->session->set_flashdata('error', "New password and confirm password not matched.");
                }
                redirect('/dashboard/change-password');
            }
        }
        $this->template->set('title', 'Change Password');
        $this->template->load('default', 'contents' , 'default/dashboard/change_password', array());
    }

}
