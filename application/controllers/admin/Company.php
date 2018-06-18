<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller
{

    /**
     * Company controller.
     * Purpose - To Add/Edit Category
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->model('admin_model');

        if(!$this->session->userdata('systemAdmin'))
        {
            redirect('admin/login');
        }
    }

    /*
     * index
     * URL - admin/company
     */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $searchKey = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "company_name";
                    break;
                case 2 :
                    $orderColumn = "company_short_code";
                    break;
                case 3 :
                    $orderColumn = "company_address";
                    break;
                case 4 :
                    $orderColumn = "company_contact";
                    break;
                case 5 :
                    $orderColumn = "company_fax";
                    break;
                case 6 :
                    $orderColumn = "is_default";
                    break;
                case 7 :
                    $orderColumn = "is_active";
                    break;
                default:
                    $orderColumn = "company_name";
            }

            $orderBY = $orderColumn . " " . $direction;

            $companyList = $this->admin_model->listCompany($searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->admin_model->count_all_company();
            $recordsFiltered = $this->admin_model->listCompany($searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($companyList) {
                $s_no = $start +1;
                foreach ($companyList as $row) {
                    $actionLink = '<a href="'. site_url("admin/company/edit/".$row->company_id).'" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Edit</a>';
                    $tempData = array(
                        "s_no" => $s_no,
                        "company_name" => $row->company_name,
                        "company_short_code" =>  $row->company_short_code,
                        "company_address" => $row->company_address,
                        "company_contact" => $row->company_contact,
                        'company_fax' => $row->company_fax,
                        'is_default'  =>  ($row->is_default == 'Y')? 'Yes':'No',
                        'is_active'   =>  ($row->is_active == 'Y')? 'Yes':'No',
                        'action'      => $actionLink
                    );
                    $data[] = $tempData;
                    $s_no++;
                }
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            );
            echo json_encode($response);
            exit;
        }

        $data = array();

        $this->template->set('title', 'Company Management');
        $this->template->load('admin', 'contents' , 'admin/company/index',$data);

    }

    /*add Category*/
    public function add(){

        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');
            $this->form_validation->set_rules('company_address', 'Company Address', 'required|trim');
            $this->form_validation->set_rules('company_short_code', 'Company code', 'required|trim');
            $this->form_validation->set_rules('company_contact', 'Company Contact', 'required|trim');
            $this->form_validation->set_rules('is_default', 'Is Default', 'required|trim');
            $this->form_validation->set_rules('include_tax', 'include Tax', 'required|trim');
            $this->form_validation->set_rules('is_active', 'Is Active', 'required|trim');
            if ($this->form_validation->run()) {

                $postData['created_date'] = date('Y-m-d H:i:s');
                unset($postData['Submit']);
                $isInserted = $this->common_model->insert(TBL_COMPANY_MASTER, $postData);
                if($isInserted) {
                    $this->session->set_flashdata('success', 'Company added successfully');
                    redirect('admin/company');
                } else{
                    $this->session->set_flashdata('error', 'There is an error while adding Company. Please try again');
                    redirect('admin/company');
                }
            }
        }
        $data = array();
        $this->template->set('title', 'Add Company');
        $this->template->load('admin', 'contents' , 'admin/company/add',$data);
    }

    /*Edit Company*/
    public function edit($id = false) {
        if($id){
            $where =  array('company_id' => $id);
            $company = $this->common_model->getRecord(TBL_COMPANY_MASTER, array('*'), $where);
            if($company) {
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');
                    $this->form_validation->set_rules('company_address', 'Company Address', 'required|trim');
                    $this->form_validation->set_rules('company_short_code', 'Company code', 'required|trim');
                    $this->form_validation->set_rules('company_contact', 'Company Contact', 'required|trim');
                    $this->form_validation->set_rules('is_default', 'Is Default', 'required|trim');
                    $this->form_validation->set_rules('include_tax', 'include Tax', 'required|trim');
                    $this->form_validation->set_rules('is_active', 'Is Active', 'required|trim');

                    if ($this->form_validation->run()) {
                        unset($postData['Submit']);
                        $postData['modified_date'] = date('Y-m-d H:i:s');
                        $this->common_model->update(TBL_COMPANY_MASTER, $postData, $where);
                        $this->session->set_flashdata('success', 'Company updated successfully');
                        redirect('admin/company');
                    }
                }

                $data = array('company' => $company);
                $this->template->set('title', 'Edit Company');
                $this->template->load('admin', 'contents' , 'admin/company/add',$data);

            } else{
                redirect('admin/company');
            }
        } else {
            redirect('admin/company');
        }
    }
}