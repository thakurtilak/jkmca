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

}
