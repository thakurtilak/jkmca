<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');

        if(!$this->session->userdata('systemAdmin'))
        {
            redirect('admin/login');
        }

    }
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->template->set('title', 'Dashboard');
        $this->template->load('admin', 'contents' , 'admin/dashboard/index', array());
    }
}
