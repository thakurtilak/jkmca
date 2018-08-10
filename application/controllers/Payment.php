<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
{

    /**
     * Payment controller.
     * Purpose - Job Payments manage
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->model('job_model');
        $this->load->model('ClientModel');
        $this->load->library('emailUtility');
        //$this->load->library('phpspreadsheet');
        $this->load->library('Phpspreadsheet');
        debug($this->phpspreadsheet); die;
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /*View Jobs*/
    public function index(){
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        if (!in_array(SUPERADMINROLEID, $rolesIDArray) && !in_array(RECIEPTIONISTROLEID, $rolesIDArray) ) {
            $this->session->set_flashdata('error', "You are not authorize to see payment laser.");
            redirect('/dashboard');
        }
        //print_r($rolesIDArray);
        $isSuperAdmin = false;
        $isRecieptionist = false;
        $isStaff = false;
        if (in_array(SUPERADMINROLEID, $rolesIDArray)) {
            $userID = false;
            $isSuperAdmin = true;
        } else if(in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $isRecieptionist = true;
            $userID = false;
        } else {
            $isStaff = true;
            $userID = $userDetail->id;
        }

        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $work_type = $this->input->get('work_type');
            $work_type = (!empty($work_type)) ? $work_type : false;
            $laserFor = $this->input->get('laserFor');
            $client = $this->input->get('client');
            $client = (!empty($client)) ? $client : false;
            $month  = $this->input->get('month');
            $month = (!empty($month)) ? $month : false;
            $searchKey = $this->input->get('search[value]');
            //$searchKey = (!empty($searchKey)) ? str_replace(' ', '%', trim($searchKey)):'';
            //debug($searchKey);
            switch ($orderField) {
                case 0 :
                    $orderColumn = "job_number";
                    break;
                case 1 :
                    $orderColumn = "work_type";
                    break;
                case 2 :
                    $orderColumn = "client_name";
                    break;
                case 3 :
                    $orderColumn = "created_date";
                    break;
                case 4 :
                    $orderColumn = "created_date";
                    break;
                case 5 :
                    $orderColumn = "remaining_amount";
                    break;
                default:
                    $orderColumn = "created_date";
            }

            $orderBY = $orderColumn . " " . $direction;
            $jobsList = '';
            $recordsTotal = 0;
            $recordsFiltered = 0;
            if(!empty($client)) {
                $jobsList = $this->job_model->listPaymentLaser($laserFor, $client, $work_type, false, $searchKey, $orderBY, $start, $length, false);
                $recordsTotal = $this->job_model->listPaymentLaser($laserFor, $client, $work_type, false, $searchKey, $orderBY, $start, $length, true);
                $recordsFiltered = count($jobsList);
            }

            $draw = $this->input->get('draw');
            $data = array();
            if ($jobsList) {
                $sNo = $start +1;
                foreach ($jobsList as $key => $job) {
                    $jobID = $job->job_number;
                    $created_date = ($job->created_date ? date('d-M-Y', strtotime($job->created_date)) : '');
                    if (trim($job->clientName) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $job->clientName;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $job->client_id . ">" . $clientName . "</a>";
                    }
                    $workName = $job->work;
                    $remaining_amount = $job->remaining_amount;

                    //$actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $job->id . " title='View'><i class='icon-view1'></i></a>";
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."jobs/view-job/".$job->id."' data-target-id=" . $job->id . " title='View Details'><i class='icon-generate_invoice'></i></a>";
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='#paymentModel' data-toggle=\"modal\" data-target-id=" . $job->id . " title='Update Payment'><i class='fa fa-rupee'></i></a>";
                    if ($isSuperAdmin && ($job->status == 'pending' || $job->status == 'rejected')) {
                        $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='" . base_url() . "jobs/edit-job/" . $job->id . "' data-target-id=" . $job->id . " title='Edit'><i class='icon-edit'></i></a>";
                    }

                    $tempData = array("jobID" => $jobID,
                        "workName" => $workName,
                        "clientName" => $clientName,
                        "request_date" => $created_date,
                        "remaining_amount" => $remaining_amount,
                        "action" => $actionLink,
                    );
                    $data[] = $tempData;
                    $sNo++;
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

        //if($selectedMonth) {
        //$data['selectedMonth'] = $selectedMonth;
        //}

        $data['isStaff'] = $isStaff;
        $data['isRecieptionist'] = $isRecieptionist;
        $data['isSuperAdmin'] = $isSuperAdmin;
        $where1 = array('status' => 1);
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE, array('id','work'), $where1, 'work');
        $data['workTypes'] = $workTypes;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Laser List');
        $this->template->load('default', 'contents', 'default/payment/index', $data);
    }

    public function getClientList(){
        if($this->input->is_ajax_request()) {
            $searchKey = $this->input->post('searchKey');
            if($searchKey) {

                $orderBY = "first_name DESC";
                $clientList = $this->ClientModel->listClient(false, false, 1, $searchKey, $orderBY, 0, 10);
                $data = array('clientList' => $clientList);
                $clients = $this->load->view('default/jobs/searchClientList', $data, TRUE);
                echo $clients;
            }
        }
    }

    public function getClientDetails(){
        if($this->input->is_ajax_request()) {
            $clientId = $this->input->post('clientId');
            if($clientId) {
                $where = array('client_id' => $clientId);
                $clientRecord = $this->common_model->getRecord(TBL_CLIENT_MASTER, array('*'), $where);
                $response = array('clientDetail' => $clientRecord);

                $clientDocuments = $this->ClientModel->getJobDocuments($clientId);
                $data = array('clientDocuments' => $clientDocuments);
                $clientDocumentHtml = $this->load->view('default/jobs/clientDocuments', $data, TRUE);
                $response ['clientDocumentHtml'] = $clientDocumentHtml;
                echo json_encode($response);
                die;
            }
        }
    }

    public function get_laser_for(){
        if($this->input->is_ajax_request()) {
            $laserFor = $this->input->post('laserFor');
            if($laserFor == '1') {
                $where = array('status' => '1');
            } else {
                $where = array('status' => '1','is_manager' => '1');
            }
            $managers = $this->common_model->getRecords(TBL_CLIENT_MASTER,array( 'client_id','CONCAT(first_name, " " , IFNULL(middle_name, ""), " ",IFNULL(last_name, "")) as clientName'), $where, 'clientName');
            $data['clientname'] = $managers;
            $data['laserFor'] = $laserFor;
            $flieds = $this->load->view('default/payment/options_creator', $data, TRUE);
            echo $flieds;
        }
    }

    public function payment_form($jobId = false){
        if($this->input->is_ajax_request() && $jobId) {
            $method = $this->input->method(TRUE);
            $jobDetail = $this->job_model->getJob($jobId);
            if($method == 'POST') {
                $postData = $this->input->post(NULL, true);
                if($jobId == $postData['jobId']) {
                    $remaining_amount = $postData['remaining_amount'] - $postData['payment'];
                    $remaining_amount = ($postData['discount'] > 0) ? ($remaining_amount - $postData['discount']) : $remaining_amount;
                    $remaining_amount = ($remaining_amount < 0) ? 0 : $remaining_amount;

                    if($postData['old_discount'] > 0 && $postData['discount'] > 0) {
                        $discount = $postData['old_discount'] + $postData['discount'];
                    } else {
                        $discount = $postData['discount'];
                    }
                    $updateArray = array(
                        'remaining_amount' => $remaining_amount
                    );
                    if($discount > 0) {
                        $updateArray['discount_price'] = $discount;
                    }
                    $where = array('id' => $jobId);
                    $updated = $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);
                    if ($updated) {
                        /*Add in payment history */
                        $payByUserId = ($jobDetail->payment_responsible) ? $jobDetail->payment_responsible : $jobDetail->client_id;
                        $paymentHistory = array(
                            'job_id' => $jobId,
                            'pay_by' => $payByUserId,
                            'amount' => $postData['payment'],
                            'payment_type' => 'OnPaymentLaser',
                            'payment_date' => date('Y-m-d H:i:s'),
                            'update_by' => getCurrentUsersId()
                        );
                        $this->common_model->insert(TBL_JOB_PAYMENT_HISTORY, $paymentHistory);
                        $response = array('success' => true);
                    } else {
                        $response = array('success' => false);
                    }
                } else {
                    $response = array('success' => false);
                }
                echo json_encode($response);
            } else {
                if ($jobDetail) {
                    $data = array();
                    $data['jobDetail'] = $jobDetail;
                    $payment_form = $this->load->view('default/payment/payment_form', $data, TRUE);
                    echo $payment_form;
                } else {
                    echo "Job Not Found";
                }
            }

        }
    }

    public function download_excel(){

        $laserFor = $this->input->get('laserFor', true);
        $clientId = $this->input->get('client', true);
        $work_type= $this->input->get('work_type', true);
        $searchKey= $this->input->get('searchKey', true);
        $orderColumn = "created_date";
        $direction = "ASC";
        $orderBY = $orderColumn . " " . $direction;
        $jobsList = $this->job_model->listPaymentLaser($laserFor, $clientId, $work_type, false, $searchKey, $orderBY, false, false, false);
        $fileName = "Payment-pending-".date('d-M-Y');
        $header = array('JobId', 'Client Name', 'Client Mobile NO.', 'Work Type', 'Job Date', 'Payment Due');
        $dataArray = array();
        $dataArray[] =$header;
        if ($jobsList) {
            foreach ($jobsList as $key => $job) {
                $jobID = $job->job_number;
                $created_date = ($job->created_date ? date('d-M-Y', strtotime($job->created_date)) : '');
                if (trim($job->clientName) == "") {
                    $clientName = "--";
                } else {
                    $clientName = $job->clientName;
                }
                $workName = $job->work;
                $remaining_amount = $job->remaining_amount;
                $clientContact = $job->clientContact;
                $responsibleName = ($job->responsibleName) ? $job->responsibleName :'--';
                $responsibleContact = ($job->responsibleContact) ? $job->responsibleContact :'--';
                $tempData = array(
                    $jobID,
                    $clientName,
                    $clientContact,
                    $workName,
                    $created_date,
                    $remaining_amount,
                    $responsibleName,
                    $responsibleContact
                );
                $dataArray[] =$tempData;
            }
        }
        $this->phpspreadsheet->createXlSX($fileName, $dataArray, "Payment Laser");
        exit();
    }

    public function download_excel_pending_all(){
        $jobsList = $this->job_model->getPaymentPendingJobs(1000);
        $fileName = "Payment-pending-".date('d-M-Y');
        $header = array('JobId', 'Client Name', 'Client Mobile NO.', 'Work Type', 'Job Date', 'Payment Due','Payment Responsible', 'Responsible No.');
        $dataArray = array();
        $dataArray[] =$header;
        if ($jobsList) {
            foreach ($jobsList as $key => $job) {
                $jobID = $job->job_number;
                $created_date = ($job->created_date ? date('d-M-Y', strtotime($job->created_date)) : '');
                if (trim($job->clientName) == "") {
                    $clientName = "--";
                } else {
                    $clientName = $job->clientName;
                }
                $workName = $job->work;
                $remaining_amount = $job->remaining_amount;
                $clientContact = $job->clientContact;
                $responsibleName = ($job->responsibleName) ? $job->responsibleName :'--';
                $responsibleContact = ($job->responsibleContact) ? $job->responsibleContact :'--';
                $tempData = array(
                    $jobID,
                    $clientName,
                    $clientContact,
                    $workName,
                    $created_date,
                    $remaining_amount,
                    $responsibleName,
                    $responsibleContact
                );
                $dataArray[] =$tempData;
            }
        }
        //debug($dataArray); die;
        $this->phpspreadsheet->createXlSX($fileName, $dataArray, "Payment Payments");
        exit();
    }

}