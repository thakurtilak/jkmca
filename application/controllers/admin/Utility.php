<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

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
        echo "<h2>Welcome the Admin Utility.</h2>";
        $class_methods = get_class_methods($this);

        array_shift($class_methods);
        array_pop($class_methods);
        if($class_methods) {
            echo "<h3>You Can perform here following task.</h3>";

            foreach($class_methods as $action) {
                echo "<p>".$action."</p>";
            }
        }
        $currentURL = $this->uri->uri_string();
        //echo "<pre>";
       // print_r($class_methods);
        die;
    }

    public function update_permissions(){

        $allMenus = get_All_menu();
        if($allMenus) {
            foreach($allMenus as $menu) {

                if($menu->submenuList) {
                    foreach($menu->submenuList as $submenu) {
                        $key = $submenu->redirect_url;
                        $isExist = $this->common_model->getRecord(TBL_PERMISSIONS, array('permissionID'), array('key' => $key));
                        if(!$isExist) {
                            $record = array();
                            $record['permission'] = $submenu->display_name;
                            $record['key'] = $key;
                            $record['category'] = $menu->display_name;
                            $inserId = $this->common_model->insert(TBL_PERMISSIONS, $record);
                            echo "Inserted Record ID : ".$inserId;
                            echo "<br>";
                        }
                    }
                }
            }
        }
        //echo "<pre>";
        //print_r($allMenus);
        die;
    }
}
