<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->library('permission');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->view('home');
    }
}
