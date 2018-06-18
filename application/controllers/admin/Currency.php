<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller
{

    /**
     * Currency controller.
     * Purpose - To Add Currency
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
     * URL - admin/currency
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
                    $orderColumn = "currency_name";
                    break;
                case 2 :
                    $orderColumn = "currency_symbol";
                    break;
                case 3 :
                    $orderColumn = "currency_status";
                    break;
                default:
                    $orderColumn = "currency_name";
            }

            $orderBY = $orderColumn . " " . $direction;

            $currencyList = $this->admin_model->listCurrency($searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->admin_model->count_all_currency();
            $recordsFiltered = $this->admin_model->listCurrency($searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($currencyList) {
                $s_no = $start +1;
                foreach ($currencyList as $row) {
                    $actionLink = '<a href="'. site_url("admin/currency/edit/".$row->currency_id).'" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Edit</a>';
                    $tempData = array(
                        "s_no" => $s_no,
                        "currency_name" => $row->currency_name,
                        "currency_symbol" => $row->currency_symbol,
                        'currency_status' =>  ($row->currency_status)? 'Yes':'No',
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

        $data = array();

        $this->template->set('title', 'Currency Management');
        $this->template->load('admin', 'contents' , 'admin/currency/index',$data);

    }

    /*add currency*/
    public function add(){

        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('currency_name', 'Currency Name', 'required|trim');
            $this->form_validation->set_rules('currency_symbol', 'currency_symbol', 'required|trim');
            $this->form_validation->set_rules('currency_status', 'Currency Status', 'required|trim');
            if ($this->form_validation->run()) {
                $postData['created_date'] = date('Y-m-d H:i:s');
                unset($postData['Submit']);
                $isInserted = $this->common_model->insert(TBL_CURRENCY_MASTER, $postData);
                if($isInserted) {
                    $this->session->set_flashdata('success', 'Currency added successfully');
                    redirect('admin/currency');
                } else{
                    $this->session->set_flashdata('error', 'There is an error while adding currency. Please try again');
                    redirect('admin/currency');
                }
            }
        }

        $data = array();

        $this->template->set('title', 'Add Currency');
        $this->template->load('admin', 'contents' , 'admin/currency/add',$data);
    }

    /*Edit Conversions record*/
    public function edit($id = false) {
        if($id){
            $where =  array('currency_id'=> $id);
            $currency = $this->common_model->getRecord(TBL_CURRENCY_MASTER, array('*'),$where);
            if($currency) {
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('currency_name', 'Currency Name', 'required|trim');
                    $this->form_validation->set_rules('currency_symbol', 'currency_symbol', 'required|trim');
                    $this->form_validation->set_rules('currency_status', 'Currency Status', 'required|trim');
                    if ($this->form_validation->run()) {
                        $postData['modified_date'] = date('Y-m-d H:i:s');
                        unset($postData['Submit']);
                        $this->common_model->update(TBL_CURRENCY_MASTER, $postData, $where);
                        $this->session->set_flashdata('success', 'Currency updated successfully');
                        redirect('admin/currency');
                    }
                }
                $data = array('currency' => $currency);
                $this->template->set('title', 'Edit Currency');
                $this->template->load('admin', 'contents' , 'admin/currency/add',$data);

            } else{
                redirect('admin/currency');
            }
        } else {
            redirect('admin/currency');
        }
    }
}