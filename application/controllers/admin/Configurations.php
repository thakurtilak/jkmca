
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configurations extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('permission');
        $this->load->model('common_model');
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
        // load form_validation library
        $this->load->library('form_validation');
        if(!$this->session->userdata('systemAdmin'))
        {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $allGroups = $this->common_model->getRecords(TBL_CONFIG_GROUPS, array('*'), array(), 'group_order');
        $allConfigurations = $this->common_model->getRecords(TBL_CONFIGURATIONS);
        if($allConfigurations) {
            $allConfigurationsArray = array();
            foreach($allConfigurations as $config) {
                $allConfigurationsArray[$config->group_id][] = $config;
            }
        }
        $postData = $this->input->post();
        if($postData) {
            if(isset($postData['configurations'])) {
                $configurations = $postData['configurations'];
                foreach($configurations as $configId => $configValue) {
                    $updateData = array('config_value' => $configValue);
                    $where = array('config_id' => $configId);
                    $this->common_model->update(TBL_CONFIGURATIONS, $updateData, $where);
                }
                $this->session->set_flashdata('success', 'Configurations updated successfully');
                redirect('admin/configurations');
            }
        }


        $data = array('allGroups'=> $allGroups, 'allConfigurations' => $allConfigurationsArray);

        $this->template->set('title', 'Configurations');
        $this->template->load('admin', 'contents' , 'admin/configurations/index',$data);
    }

    public function add()
    {

    }
}
