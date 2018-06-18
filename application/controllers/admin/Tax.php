<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller
{

    /**
     * Tax controller.
     * Purpose - To Add Tax
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
     * URL - admin/tax
     */
    public function index()
    {
        $currentFinancialYear = getCurrentFinancialYear();
        if ($this->input->is_ajax_request()) {
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $searchKey = $this->input->get('search[value]');
            $financialYear = ($this->input->get('financialYear')) ? $this->input->get('financialYear') : $currentFinancialYear;
            switch ($orderField) {
                case 1 :
                    $orderColumn = "tax_detail";
                    break;
                case 2 :
                    $orderColumn = "tax";
                    break;
                case 3 :
                    $orderColumn = "financial_year";
                    break;
                default:
                    $orderColumn = "tax_detail";
            }

            $orderBY = $orderColumn . " " . $direction;

            $taxesList = $this->admin_model->listTaxes($financialYear, $searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->admin_model->count_all_taxes($financialYear);
            $recordsFiltered = $this->admin_model->listTaxes($financialYear, $searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($taxesList) {
                $s_no = $start +1;
                foreach ($taxesList as $row) {
                    $actionLink = '<a href="'. site_url("admin/tax/edit/".$row->id).'" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Edit</a>';
                    $tempData = array(
                        "s_no" => $s_no,
                        "tax_detail" => $row->tax_detail,
                        "tax" => $row->tax,
                        'financial_year' =>  $row->financial_year,
                        'action' => $actionLink
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

        $startMonth = getConfiguration('financial_year_start_month');
        $startMonth = date('m', strtotime($startMonth));
        // Year to start available options at
        $earliest_year = 2009;
        // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
        $currentYear = current(explode('-', $currentFinancialYear)) ;
        $currenctYearStartMonth = date($currentYear.'-'.$startMonth.'-01');
        $latest_year = date('Y', strtotime($currenctYearStartMonth));
        // Loops over each int[year] from current year, back to the $earliest_year [1950]
        $financialYears = array();
        foreach ( range($latest_year, $earliest_year) as $year ) {
            $financialYears[] = $year ."-". ($year + 1);
        }

        $data = array('financialYears' => $financialYears, 'currentYear' => $currentFinancialYear);

        $this->template->set('title', 'Tax Management');
        $this->template->load('admin', 'contents' , 'admin/tax/index',$data);

    }

    /*add tax*/
    public function add(){

        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('financial_year', 'Financial Year', 'required|trim');
            $this->form_validation->set_rules('tax_detail', 'Tax Name', 'required|trim');
            $this->form_validation->set_rules('tax', 'Tax Value', 'required|trim');
            if ($this->form_validation->run()) {
                $postData['include_servtax'] = 'N';
                if($postData['tax_detail'] == 'IGST'){
                    $postData['is_state'] = 'N';
                } else {
                    $postData['is_state'] = 'Y';
                }
                unset($postData['Submit']);
                $isInserted = $this->common_model->insert(TBL_TAX_MASTER, $postData);
                if($isInserted) {
                    $this->session->set_flashdata('success', 'Tax added successfully');
                    redirect('admin/tax');
                } else{
                    $this->session->set_flashdata('error', 'There is an error while adding Tax. Please try again');
                    redirect('admin/tax');
                }
            }
        }

        $currentFinancialYear =getCurrentFinancialYear();
        $startMonth = getConfiguration('financial_year_start_month');
        $startMonth = date('m', strtotime($startMonth));
        // Year to start available options at
        $earliest_year = current(explode('-', $currentFinancialYear)) ;
        // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
        $currentYear = $earliest_year + 1;
        //$earliest_year = $earliest_year - 1;
        $currenctYearStartMonth = date($currentYear.'-'.$startMonth.'-01');
        $latest_year = date('Y', strtotime($currenctYearStartMonth));
        // Loops over each int[year] from current year, back to the $earliest_year [1950]
        $financialYears = array();
        foreach ( range($latest_year, $earliest_year) as $year ) {
            $financialYears[] = $year ."-". ($year + 1);
        }

        $data = array('financialYears' => $financialYears);

        $this->template->set('title', 'Add Tax');
        $this->template->load('admin', 'contents' , 'admin/tax/add',$data);
    }

    /*Edit Category*/
    public function edit($id = false) {
        if($id){
            $where =  array('id' => $id);
            $tax = $this->common_model->getRecord(TBL_TAX_MASTER, array('*'), $where);
            if($tax) {
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('tax_detail', 'Tax Name', 'required|trim');
                    $this->form_validation->set_rules('tax', 'Tax Value', 'required|trim');
                    if ($this->form_validation->run()) {
                        unset($postData['Submit']);
                        $this->common_model->update(TBL_TAX_MASTER, $postData, $where);
                        $this->session->set_flashdata('success', 'Tax updated successfully');
                        redirect('admin/tax');
                    }
                }
                $currentFinancialYear =getCurrentFinancialYear();
                $startMonth = getConfiguration('financial_year_start_month');
                $startMonth = date('m', strtotime($startMonth));
                // Year to start available options at
                $earliest_year = 2009;
                // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                $currentYear = current(explode('-', $currentFinancialYear)) ;
                $currenctYearStartMonth = date($currentYear.'-'.$startMonth.'-01');
                $latest_year = date('Y', strtotime($currenctYearStartMonth));
                // Loops over each int[year] from current year, back to the $earliest_year [1950]
                $financialYears = array();
                foreach ( range($latest_year, $earliest_year) as $year ) {
                    $financialYears[] = $year ."-". ($year + 1);
                }
                $data = array('tax' => $tax, 'financialYears' => $financialYears);
                $this->template->set('title', 'Edit Tax');
                $this->template->load('admin', 'contents' , 'admin/tax/add',$data);

            } else{
                redirect('admin/tax');
            }
        } else {
            redirect('admin/tax');
        }
    }
}