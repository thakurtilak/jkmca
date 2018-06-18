<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * Class Constructor
	 * Functionality : 
	 *      Load session library for managing session variables.	 
	 * 		Load url_helper helper for using some URL functions.
	 * @author Webdunia
	 * TimeStamp : 15.May.2017(2.36 PM)
	 */
	public function __construct()
	{
	   	parent::__construct();
	   	$this->load->library('session'); 
	   	$this->load->helper('url_helper'); 	   	
	   	$this->load->model('common_model');
	}

	public function index($id='')
	{
		$array_items = array('user', 'userId', 'userPermission', 'initialSubmit', 'projections');
		$this->session->unset_userdata($array_items);
		$this->session->unset_userdata($array_items);
		//$this->session->sess_destroy();
		$this->session->set_flashdata('success',  $this->lang->line('LOGOUT_SUCCESS'));
		redirect('/login');
	}
}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */