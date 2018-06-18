<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('permission');
        $this->load->model('common_model');
        $this->load->model('admin_model');
        $this->load->model('InvoiceModel');
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
        if ($this->input->is_ajax_request()) {
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $searchKey = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "generatedBy";
                    break;
                case 2 :
                    $orderColumn = "category_name";
                    break;
                case 3 :
                    $orderColumn = "invoice_no";
                    break;
                case 4 :
                    $orderColumn = "po_no";
                    break;
                case 5 :
                    $orderColumn = "invoice_net_amount";
                    break;
                default:
                    $orderColumn = "invoice_generate_date";
            }

            $orderBY = $orderColumn . " " . $direction;

            $listAdminInvoices = $this->admin_model->listAdminInvoices($searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->admin_model->count_all_listAdminInvoices();
            $recordsFiltered = $this->admin_model->listAdminInvoices($searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($listAdminInvoices) {
                foreach ($listAdminInvoices as $row) {
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ViewModal\" data-toggle=\"modal\" data-target-id=" . $row->invoice_req_id . " title='View'><i class='icon-view1'></i></a>";
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#cancelModal\" data-toggle=\"modal\" data-target-id=" . $row->invoice_req_id . " title='Cancel'><i class='icon-cancel'></i></a>";
                    $tempData = array(
                        "generate_date" => date('d-M-Y', strtotime($row->invoice_generate_date)),
                        "generate_by" => $row->generatedBy,
                        "category" => $row->category_name,
                        'invoice_no' =>  $row->invoice_no,
                        "po_no" => ($row->po_no)? $row->po_no:'--',
                        "amount" => formatAmount($row->invoice_net_amount),
                        'action' => $actionLink
                    );
                    $data[] = $tempData;
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

        $this->template->set('title', 'Invoice Management');
        $this->template->load('admin', 'contents' , 'admin/invoices/index',array());
    }

    /*
     * cancel_invoice
     * To cancel invoice
     */
    public function cancel_invoice($invoiceId){
        $where = array('invoice_req_id' => $invoiceId, 'invoice_acceptance_flag' => 'Y');
        if ($invoiceId) {
            $invoiceDetail = $this->admin_model->getRecord(TBL_INVOICE_MASTER, array('invoice_req_id', 'gen_approval_status'), $where);
            if ($invoiceDetail) {
                if ($invoiceDetail->gen_approval_status != 'Accept') {
                    $dataToupdate = array('invoice_acceptance_status' => 'Pending', 'invoice_acceptance_flag' => 'N',
                        'generator_user_id'=> NULL,
                        'invoice_date' => NULL,
                        'invoice_generate_date' => NULL,
                        'invoice_generator_comments' => NULL,
                        'invoice_no' => NULL);
                    $isCanceled = $this->admin_model->update(TBL_INVOICE_MASTER, $dataToupdate, $where);
                    if ($isCanceled) {
                        $this->session->set_flashdata('success', "Invoice has been cancelled.");
                    } else {
                        $this->session->set_flashdata('error', "Error while cancel your order. Please try again");
                    }
                } else {
                    $this->session->set_flashdata('error', "This Invoice already Approved by Finance Head.");
                }
            } else {
                $this->session->set_flashdata('error', "Invoice doesn't exist.");
            }
        }
        redirect('admin/invoices');
    }

    /*
    *  invoice_detail.
    * @purpose -To pass data to view.
    * @Date -23/02/2018
    * @author - NJ
    */
    public function invoice_detail($invoiceId)
    {
        $type = $this->input->get('type');
        $invoiceDetail = $this->InvoiceModel->getInvoice($invoiceId);
        $data = array('invoiceDetail' => $invoiceDetail);
        //$userInfo = getCurrentUser();
        $data['userRole'] = explode(',', 0);
        $data['requestUser'] = getUserInfo($invoiceDetail->originator_user_id);


        if (hasApprover($invoiceDetail->originator_user_id)) {
            $approverDetail = getApprover($invoiceDetail->originator_user_id);
            $approverName = $approverDetail->first_name . " " . $approverDetail->last_name;
            $data['approverName'] = $approverName;
        }

        if($invoiceDetail->generator_user_id) {
            $generatorDetail = getUserInfo($invoiceDetail->generator_user_id);
            $generatorName = $generatorDetail->first_name . " " . $generatorDetail->last_name;
            $data['generatorName'] = $generatorName;
        }

        $where = array('invoice_req_id' => $invoiceId,'role_name'=>'Originator');
        $invoiceAttachments = $this->common_model->getRecords(TBL_INVOICE_ATTACHMENTS, array('invoice_req_id', 'attach_file_name','attach_file_path', 'attach_type'), $where);
        $data['invoiceAttachments'] = $invoiceAttachments;

        $where = array('client_id' => $invoiceDetail->client_id);
        $clientAgreements = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, array('agreement_name', 'client_id'), $where);
        $data['clientAgreements'] = $clientAgreements;

        $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id ,'role_name'=>'Generator');
        $invoiceAttach = $this->common_model->getRecords(TBL_INVOICE_ATTACHMENTS, array('invoice_req_id', 'attach_file_name','attach_file_path'), $where);
        $data['invoiceAttach'] = $invoiceAttach;

        $wdsalesperson= $this->common_model->getRecords(TBL_USER, array('id','CONCAT(first_name,\' \', last_name) as name'));
        $data['wdsalesperson'] = $wdsalesperson;

        $where = array('salesperson_id' => $invoiceDetail->sales_id);
        $salesPerson = $this->common_model->getRecord(TBL_CLIENT_SALESPERSON, array('sales_person_name', 'sales_contact_no', 'sales_person_email'), $where);
        $data['salesPerson'] = $salesPerson;

        $where = array('account_id' => $invoiceDetail->account_id);
        $accountPerson = $this->common_model->getRecord(TBL_CLIENT_ACCOUNTPERSON, array('account_person_name', 'account_contact_no', 'account_person_email'), $where);
        $data['accountPerson'] = $accountPerson;

        $paymentterm= $this->common_model->getRecords(TBL_PAYMENT_TERMS_MASTER, array('id','name'));
        $data['paymentterm'] = $paymentterm;

        if($type == 'pendingInvoice') {
            $viewHtml = $this->load->view('admin/invoices/pending_invoices_view',$data,true);
        }
        else if($type == 'generateInvoice') {

            if($invoiceDetail->category_id==ADSALESCAT ||$invoiceDetail->category_id==ADSALESINCCAT)
            {
                $impressionunit= $invoiceDetail->impression_unit;
                $where = array('id' => $impressionunit);
                $unit = $this->common_model->getRecord(TBL_IMPRESSION_UNITS_MASTER, array('unit_name'), $where);
                $data['unit'] = $unit;
            }

            $where = array('id' => $invoiceDetail->country);
            $country = $this->common_model->getRecord(TBL_COUNTRY_MASTER, array('country_name'), $where);
            $data['country'] = $country;

            $where = array('id' => $invoiceDetail->state);
            $state = $this->common_model->getRecord(TBL_STATE_MASTER, array('state_name'), $where);
            $data['state'] = $state;

            $where = array('is_service_category' => 1 );
            $servicesubcategories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id','category_name'), $where);
            $data['servicesubcategories'] = $servicesubcategories;

            $where = array('is_active'=>'Y');
            $companylist = $this->common_model->getRecords(TBL_COMPANY_MASTER, array('*'), $where);
            $data['companylist'] = $companylist;

            $where = array('company_id=' => 1);
            $companyBankDetails = $this->common_model->getRecords(TBL_COMPANY_BANK_DETAILS_MASTER, array('id','currency'), $where);
            $data['companyBankDetails'] = $companyBankDetails;

            $viewHtml = $this->load->view('admin/invoices/generateinvoice_view',$data,true);
        }

        else if($type == 'collection') {

            $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id);
            $pymtdtl= $this->common_model->getRecords(TBL_INVOICE_MASTER, array('invoice_req_id','collector_user_id','payment_type','payment_recieved','invoice_collection_amount','payment_mode',"transaction_no",'payment_recieved_date','payment_recieved_remarks','payment_recieved_flag','invoice_close_date','invoice_closure_flag'), $where);
            $data['pymtdtl'] = $pymtdtl;

            $viewHtml = $this->load->view('admin/collections/collection_view',$data,true);
        }

        else if($type == 'paymentDetail') {

            $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id);
            $pymtdtl= $this->common_model->getRecord(TBL_INVOICE_MASTER, array('invoice_req_id','collector_user_id','payment_type','payment_recieved','invoice_collection_amount','payment_mode',"transaction_no",'payment_recieved_date','payment_recieved_remarks','payment_recieved_flag','invoice_close_date','invoice_closure_flag'), $where);

            $data['pymtdtl'] = $pymtdtl;

            $viewHtml = $this->load->view('admin/collections/payment_info',$data,true);
        }

        else{
            $viewHtml = $this->load->view('admin/invoices/view', $data, true);
        }

        echo $viewHtml;
    }

}
