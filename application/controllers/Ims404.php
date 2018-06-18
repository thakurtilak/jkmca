<?php

/**
 * Created by PhpStorm.
 * User: Dharmendra.thakur
 * Date: 01/10/18
 * Time: 7:29 PM
 */
class Ims404 extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->output->set_status_header('404');

        // Make sure you actually have some view file named 404.php
       // $this->template->set('title', 'Not Found');
        //$this->template->load('default', 'contents' , 'errors/html/error_404', array());
        //$this->load->view('404');
        $this->load->view('errors/html/error_404');
    }
}