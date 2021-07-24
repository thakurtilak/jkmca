<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('common_model');
        $this->load->model('ClientModel');
        $this->load->model('InquiryModel');
        $this->load->model('job_model');
        $this->load->library('emailUtility');
        $this->load->library('Phpspreadsheet');
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /*
     * index
     * List Clients
     */
    public function index()
    {
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        //print_r($rolesIDArray);
        $isSuperAdmin = false;
        $isRecieptionist = false;
        $isStaff = false;
        if (in_array(SUPERADMINROLEID, $rolesIDArray)) {
            $isSuperAdmin = true;
        } else if (in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $isRecieptionist = true;
        } else {
            $isStaff = true;
        }
        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $order = $this->input->get('order[0][dir]');
            $categoryId = $this->input->get('category_id');
            $categoryId = (!empty($categoryId)) ? $categoryId : false;
            $status = $this->input->get("status_id");
            //$assigned = (!empty($this->input->get('type_id')))? $this->input->get('type_id') : false;
            $name = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "first_name";
                    break;
                case 2 :
                    $orderColumn = "fathers_first_name";
                    break;
                case 6 :
                    $orderColumn = "status";
                    break;
                case 7 :
                    $orderColumn = "created_at";
                    break;
                default:
                    $orderColumn = "created_at";
            }
            $orderBY = $orderColumn . " " . $order;

            $inquiryList = $this->InquiryModel->listInquiries($userDetail->id, $categoryId, $status, $name, $orderBY, $start, $length);
            $recordsTotal = $this->InquiryModel->count_all($userDetail->id);
            $recordsFiltered = $this->InquiryModel->count_filtered($userDetail->id, $categoryId, $status, $name, $orderBY);

            $draw = $this->input->get('draw');
            $data = array();
            if ($inquiryList) {
                $sn = $start + 1;
                foreach ($inquiryList as $client) {
                    $clientName = $client->first_name . ' ' . $client->last_name;
                    $father_name = $client->fathers_first_name . " " . $client->fathers_last_name;
                    $created_date = ($client->created_at ? date('d-M-Y', strtotime($client->created_at)) : '');
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $client->ref_no . " title='View'><i class='icon-view1'></i></a>";
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect button-print action-btn\" href=\"javascript:void(0)\" data-toggle=\"modal\" data-target-id=" . $client->ref_no . " title='Print'><i class='fa fa-print' aria-hidden='true'></i></a>";
                    if (($isSuperAdmin || $isRecieptionist)) {
                        $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#deleteInquiryModel\" data-toggle=\"modal\" data-target-id=" . $client->ref_no . " title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></a>"; 
                        if($client->status !='CANCELLED') {
                            $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#cancelInquiryModel\" data-toggle=\"modal\" data-target-id=" . $client->ref_no . " title='Cancel'><i class='fa fa-ban' aria-hidden='true'></i></a>";
                            $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='" . base_url() . "jobs/new-job/" . $client->ref_no . "' data-target-id=" . $client->ref_no . " title='Create Job'><i class='fa fa-plus-square'></i></a>";
                        }   
                    }
                    $tempData = array("ref_no" => $client->ref_no,
                        "client_name" => $clientName,
                        "father_name" => $father_name,
                        "pan_no" => $client->pan_no,
                        "aadhar_no" => $client->aadhar_no,
                        "mobile" => $client->mobile,
                        "status" => $client->status,
                        "inquiry_date" => $created_date,
                        "action" => $actionLink
                    );
                    $data[] = $tempData;
                    $sn++;
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
        $data['isStaff'] = $isStaff;
        $data['isRecieptionist'] = $isRecieptionist;
        $data['isSuperAdmin'] = $isSuperAdmin;
        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Inquiry List');
        $this->template->load('default', 'contents', 'default/inquiry/list', $data);
    }


    public function new()
    {
        $postData = $this->input->post(NULL, true);
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        if (!in_array(SUPERADMINROLEID, $rolesIDArray) && !in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $this->session->set_flashdata('error', "You don't have permission to create Job card.");
            redirect('/dashboard');
        }
        if ($postData) {
            //echo "<pre>"; print_r($postData); exit;
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('work_type', 'Work Type', 'required');
            $this->form_validation->set_rules('staff', 'Staff', 'required');
            $this->form_validation->set_rules('mobile_number', 'Mobile', 'required');
            // echo "<pre>";
            // print_r($postData);
            // die;
            if ($this->form_validation->run()) {
                $work_type = $postData['work_type'];
                $insertArray = array(
                    'work_type' => $work_type,
                    'staff_id'  => $postData['staff'],
                    'created_at'=> date('Y-m-d H:i:s'),
                    'created_by'=> getCurrentUsersId(),
                    'status'    => "PENDING"
                );

                if(isset($postData['client_id']) && !empty($postData['client_id'])) {
                    $insertArray['client_id'] = $postData['client_id'];
                    $updateArray = array(
                        'first_name' => $postData['first_name'],
                        'last_name' => $postData['last_name'],
                        'father_first_name' => $postData['father_first_name'],
                        'father_last_name' => $postData['father_last_name'],
                        'mobile' => $postData['mobile_number'],
                        'pan_no' => $postData['pan_no'],
                        'aadhar_number' => $postData['aadhar_no'],
                    );
                    $updateWhere = array('client_id' => $postData['client_id']);
                    $this->common_model->update(TBL_CLIENT_MASTER, $updateArray, $updateWhere);
                } else {/*Automatically create client*/
                    $insert_data = array(
                        'first_name' => $postData['first_name'],
                        'last_name' => $postData['last_name'],
                        'father_first_name' => $postData['father_first_name'],
                        'father_last_name' => $postData['father_last_name'],
                        'mobile' => $postData['mobile_number'],
                        'pan_no' => $postData['pan_no'],
                        'aadhar_number' => $postData['aadhar_no'],
                        'country' => 101,
                        'created_by' => getCurrentUsersId(),
                        'created_date' => date('Y-m-d H:i:s', now()),
                    );
                    $inserted_client_id = $this->common_model->insert(TBL_CLIENT_MASTER, $insert_data);
                    $insertArray['client_id'] = $inserted_client_id;
                }
                $insertArray['first_name'] =  $postData['first_name'];
                $insertArray['last_name'] =  $postData['last_name'];
                $insertArray['fathers_first_name'] =  $postData['father_first_name'];
                $insertArray['fathers_last_name'] =  $postData['father_last_name'];
                $insertArray['mobile'] =  $postData['mobile_number'];
                $insertArray['aadhar_no'] =  $postData['aadhar_no'];
                $insertArray['pan_no'] =  $postData['pan_no'];
                /*echo "<pre>";
                print_r($attachment_detail);die;*/
                $inserted_job_id = $this->common_model->insert(TBL_INQUIRY_MASTER, $insertArray);
                if($inserted_job_id) {
                    $this->session->set_flashdata('success', 'New Job Inquiry has been successfully added.');
                } else {
                    $this->session->set_flashdata('error', "There is an error while creating job.");
                }
                redirect('/inquiry');
            } else{
                $this->session->set_flashdata('error', validation_errors());
                redirect('/inquiry/new');
            }
        }

        $data = array();

        //$where = array('role_id' => 2,'status' => 'A');
        $where = array('status' => 'A', 'id >' => 1);/*Allow all user as assign*/
        $staff = $this->common_model->getRecords(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name','role_id'), $where, 'name');
        if($staff) {
            foreach ($staff as $k => $user) {
                $appendText = '';
                if($user->role_id == 1) {
                    $appendText = ' - Receptionist';
                } elseif ($user->role_id == 2){
                    $appendText = ' - Staff';
                }elseif ($user->role_id == 5){
                    $appendText = ' - Administrator';
                }
                $user->name .= $appendText;
            }
        }
        $data['staff'] = $staff;

        $where = array('status' => '1');
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE,array( 'id','work'), $where, 'work');
        $data['workTypes'] = $workTypes;
        $data['currentUserId'] = getCurrentUsersId();
        $data['rolesIDArray'] = $rolesIDArray;

        $this->template->set('title', 'New Inquiry');
        $this->template->load('default', 'contents', 'default/inquiry/add', $data);
    }

    public function view($refId)
    {
        $type = $this->input->get('type');
        $inquiryDetail = $this->InquiryModel->getInquiry($refId);
        if($type == 'print') {
            $data = array('jobDetail' => $inquiryDetail, 'staffName' => '', 'workType' =>'');
            if($inquiryDetail->staff_id) {
                $staffDetail = getUserInfo($inquiryDetail->staff_id);
                $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
                $data['staffName'] = $staffName;
            }
            if($inquiryDetail->work_type) {
                $where = array('id' => $inquiryDetail->work_type);
                $workDetail = $this->common_model->getRecord(TBL_WORK_TYPE, array(
                    'work'), $where);
                $data['workType'] = $workDetail->work;
            }
            $viewHtml = $this->load->view('default/inquiry/print', $data, true);
        } else {
            if($inquiryDetail){
                $data = array('inquiryDetail' => $inquiryDetail);
                if($inquiryDetail->staff_id) {
                    $staffDetail = getUserInfo($inquiryDetail->staff_id);
                    $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
                    $data['staffName'] = $staffName;
                }
                if($inquiryDetail->work_type) {
                    $where = array('id' => $inquiryDetail->work_type);
                    $workDetail = $this->common_model->getRecord(TBL_WORK_TYPE, array(
                        'work'), $where);
                    $data['workType'] = $workDetail->work;
                }
                $viewHtml = $this->load->view('default/inquiry/view', $data, true);
            }
        }
        echo $viewHtml;
    }

    public function getClientDetails(){
        if($this->input->is_ajax_request()) {
            $searchKey = $this->input->post('searchKey');
            if($searchKey) {
                $clientRecord = $this->ClientModel->findClient($searchKey);
                if($clientRecord) {
                    $response = array('clientDetail' => $clientRecord);
                    echo json_encode($response);
                    die;
                } else {
                    echo 'false'; die;
                }
                
            }
        }
    }

    public function cancel_form($refId){
        if($this->input->is_ajax_request() && $refId) {
            $method = $this->input->method(TRUE);
            $inquiryDetail = $this->InquiryModel->getInquiry($refId);
            if($method == 'POST') {
                $postData = $this->input->post(NULL, true);
                if($refId == $postData['refId']) {
                    $updateArray = array(
                        "status" => "CANCELLED",
                        "cancel_reason" => $postData['reason']
                    );;
                    $where = array('ref_no' => $refId);
                    $updated = $this->common_model->update(TBL_INQUIRY_MASTER, $updateArray, $where);
                    if ($updated) {
                        $response = array('success' => true);
                    } else {
                        $response = array('success' => false);
                    }
                } else {
                    $response = array('success' => false);
                }
                echo json_encode($response);
                //POST 
            }else {
                if ($inquiryDetail) {
                    $data = array();
                    $data['inquiryDetail'] = $inquiryDetail;
                    $payment_form = $this->load->view('default/inquiry/cancel_form', $data, TRUE);
                    echo $payment_form;
                } else {
                    echo "Inquiry Not Found";
                }
            }
        }
    }
    
    public function delete($refId) {
        if($this->input->is_ajax_request() && $refId) {
            $method = $this->input->method(TRUE);
            $inquiryDetail = $this->InquiryModel->getInquiry($refId);
            if($method == 'POST') {
                $where = array('ref_no' => $refId);
                $deleted = $this->common_model->delete(TBL_INQUIRY_MASTER, $where);
                if ($deleted) {
                    $response = array('success' => true);
                } else {
                    $response = array('success' => false);
                }
                echo json_encode($response);
                //POST 
            }
        }
    }

    /*
    For download all INquiry
    CreATED on - 24-jULY-2021
    */
    public function download_all() {
        $searchKey= $this->input->get('searchKey', true);
        $orderColumn = "created_date";
        $direction = "ASC";
        $orderBY = $orderColumn . " " . $direction;
        $inquiryList = $this->InquiryModel->downloadAll($searchKey);
        $fileName = "Inquiry-List-".date('d-M-Y');
        $header = array('RefId', 'Client Name', 'Client Mobile NO.', 'Aadhar NO.', 'PAN NO.', 'Work Type','Staff Name', 'Status','Inquiry Date');
        $dataArray = array();
        $dataArray[] =$header;
        if ($inquiryList) {
            foreach ($inquiryList as $key => $job) {
                $refID = $job->ref_no;
                $created_date = ($job->created_at ? date('d-M-Y', strtotime($job->created_at)) : '');
                if (trim($job->client_name) == "") {
                    $clientName = "--";
                } else {
                    $clientName = $job->client_name;
                }
                $workName = $job->work;
                $aadharNO = $job->aadhar_no;
                $panNO = $job->pan_no;
                $clientContact = $job->mobile;
                $staffName = $job->staff_name;
                $status = $job->status;
                $tempData = array(
                    $refID,
                    $clientName,
                    $clientContact,
                    $aadharNO,
                    $panNO,
                    $workName,
                    $staffName,
                    $status,
                    $created_date
                );
                $dataArray[] =$tempData;
            }
        }
        try{
            $this->phpspreadsheet->createXlSX($fileName, $dataArray, "All Inquiry");
        } catch (Exception $e) {
            //debug($e); die;
        }
        exit();
    }
}
