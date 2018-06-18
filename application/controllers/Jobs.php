<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller
{

    /**
     * Jobs controller.
     * Purpose - To create Jobs and manage them
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
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /*View Jobs*/
    public function index(){
        $userDetail = getCurrentUser();
        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $work_type = (!empty($this->input->get('work_type'))) ? $this->input->get('work_type') : false;
            $status = (!empty($this->input->get('status_id'))) ? $this->input->get('status_id') : false;
            $month = (!empty($this->input->get('month'))) ? $this->input->get('month') : false;

            $searchKey = $this->input->get('search[value]');
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
                    $orderColumn = "staff_name";
                    break;
                case 4 :
                    $orderColumn = "created_date";
                    break;
                case 5 :
                    $orderColumn = "status";
                    break;
                default:
                    $orderColumn = "created_date";
            }

            $orderBY = $orderColumn . " " . $direction;
            $jobsList = $this->job_model->listJobs(false, $work_type, $status, $month, $searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->job_model->count_all(false);
            $recordsFiltered = $this->job_model->count_filtered(false, $work_type, $status, $month, $searchKey, $orderBY);

            $draw = $this->input->get('draw');
            $data = array();
            if ($jobsList) {
                $sNo = $start +1;
                foreach ($jobsList as $key => $job) {
                    $jobID = $job->job_number;
                    $created_date = ($job->created_date ? date('d-M-Y', strtotime($job->created_date)) : '');
                    if (trim($job->client_name) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $job->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $job->client_id . ">" . $clientName . "</a>";
                    }
                    $workName = $job->work;
                    $staff_name = $job->staff_name;
                    $status = $job->status;
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $job->id . " title='View'><i class='icon-view1'></i></a>";
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn button-print\" href=\"javascript:void(0)\" data-target-id=" . $job->id . " title='Print'><i class=\"fa fa-print\" aria-hidden=\"true\"></i></a>";

                    $tempData = array("jobID" => $jobID,
                        "workName" => $workName,
                        "clientName" => $clientName,
                        "staff_name" => $staff_name,
                        "request_date" => $created_date,
                        "status" => $status,
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

        $where1 = array('status' => 1);
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE, array('id','work'), $where1, 'work');
        $data['workTypes'] = $workTypes;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Job List');
        $this->template->load('default', 'contents', 'default/jobs/index', $data);
    }

    public function new_job(){
        $postData = $this->input->post();
        $currentUser = getCurrentUser();
        if ($postData) {

            $this->form_validation->set_rules('work_type', 'Work Type', 'required');
            $this->form_validation->set_rules('client', 'Client', 'required');
            $this->form_validation->set_rules('client_code', 'Client Code', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');
            $this->form_validation->set_rules('staff', 'Staff', 'required');
            $this->form_validation->set_rules('completion_date', 'Completion Date', 'required');
            if ($postData['work_type'] == 1) {
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('dob', 'DOB', 'required');
                $this->form_validation->set_rules('mobile_number', 'Mobile', 'required');
                $this->form_validation->set_rules('aadhar_no', 'Aadhar Card No.', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');

            } elseif($postData['work_type'] == 2) {
                $this->form_validation->set_rules('assessment_year', 'Assessment Year', 'required');
                //$this->form_validation->set_rules('po_detail', 'PO/RO Details', 'required');
            }elseif($postData['work_type'] == 3) {

            }elseif($postData['work_type'] == 4) {

            }elseif($postData['work_type'] == 5) {

            }elseif($postData['work_type'] == 6) {

            }elseif($postData['work_type'] == 7) {

            }elseif($postData['work_type'] == 8) {

            }elseif($postData['work_type'] == 9) {

            }elseif($postData['work_type'] == 10) {

            }elseif($postData['work_type'] == 11) {

            }elseif($postData['work_type'] == 12) {

            }

            /*echo "<pre>";
            print_r($postData);
            print_r($_FILES);
            die;*/
            if ($this->form_validation->run()) {
                $work_type = $postData['work_type'];
                $insertArray = array(
                    'client_id' => $postData['client'],
                    'work_type' => $work_type,
                    'amount'    => $postData['price'],
                    'advanced_amount'  => $postData['advance_price'],
                    'remaining_amount' => $postData['remaining_amount'],
                    'staff_id'  => $postData['staff'],
                    'completion_date' => date('Y-m-d', strtotime($postData['completion_date'])),
                    'remark'  => $postData['remark'],
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by'   => getCurrentUsersId()
                );
                if($work_type == 1) {
                    $insertArray['first_name'] =  $postData['first_name'];
                    $insertArray['middle_name'] =  $postData['middle_name'];
                    $insertArray['last_name'] =  $postData['last_name'];
                    //$insertArray['fathers_first_name'] =  $postData['father_first_name'];
                    //$insertArray['fathers_middle_name'] =  $postData['father_middle_name'];
                    //$insertArray['fathers_last_name'] =  $postData['father_last_name'];
                    $insertArray['mobile_number'] =  $postData['mobile_number'];
                    $insertArray['dob'] =  date('Y-m-d', strtotime($postData['dob']));
                    $insertArray['aadhar_no'] =  $postData['aadhar_no'];
                    $insertArray['address'] =  $postData['address'];
                }
                if($work_type == 2) {
                    $insertArray['first_name'] =  $postData['first_name'];
                    $insertArray['middle_name'] =  $postData['middle_name'];
                    $insertArray['last_name'] =  $postData['last_name'];
                    $insertArray['fathers_first_name'] =  $postData['father_first_name'];
                    $insertArray['fathers_middle_name'] =  $postData['father_middle_name'];
                    $insertArray['fathers_last_name'] =  $postData['father_last_name'];
                    $insertArray['mobile_number'] =  $postData['mobile_number'];
                    $insertArray['pan_no'] =  $postData['pan_no'];
                    $insertArray['dob'] =  date('Y-m-d', strtotime($postData['dob']));
                    $insertArray['aadhar_no'] =  $postData['aadhar_no'];
                    $insertArray['address'] =  $postData['address'];
                    $insertArray['assessment_year'] = $postData['assessment_year'];
                }
                /*echo "<pre>";
                print_r($attachment_detail);die;*/
                $inserted_job_id = $this->common_model->insert(TBL_JOB_MASTER, $insertArray);
                //$inserted_job_id = 1;
                if($inserted_job_id) {
                    $uploadError = false;
                    /*Upload Job card*/
                    $upload_data = $this->do_upload_jobs($inserted_job_id);
                    if(isset($upload_data['full_path'])) {
                        $jobCardArray = explode(UPLOAD_ROOT_DIR, $upload_data['full_path']);
                        $filePath = UPLOAD_ROOT_DIR.end($jobCardArray);
                        $insertJob = array(
                            'job_id' => $inserted_job_id,
                            'file_path' => $filePath,
                            'file_name' => $upload_data['client_name'],
                            'file_detail'=> json_encode($upload_data)
                        );
                        $inserted_id = $this->common_model->insert(TBL_JOBCARDS_FILES, $insertJob);
                        //echo $inserted_id;
                    } else {
                        $uploadError = TRUE;
                    }

                    /*upload Documents*/
                    $upload_doc_data = $this->do_upload_documents($inserted_job_id);

                    if(isset($postData['file-upload-input'])) {
                        /* Insert agreement  information.*/
                        $numFields = count($postData['file-upload-input']);
                        for ($i = 0; $i < $numFields; $i++) {
                            if (isset($upload_doc_data[$i]['full_path'])) {
                                $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $upload_doc_data[$i]['full_path']);
                                $filePath = UPLOAD_ROOT_DIR.end($jobCardDocArray);
                                $data = array(
                                    'job_id' => $inserted_job_id,
                                    'attach_type' => (isset($postData['add_job_doc'][$i])) ? $postData['add_job_doc'][$i]:0,
                                    'attach_file_path' => $filePath,
                                    'attach_file_name' => $upload_doc_data[$i]['client_name'],
                                    'attach_file_detail' => json_encode($upload_doc_data[$i]),
                                );
                                $this->common_model->insert(TBL_JOBS_ATTACHMENTS, $data);
                            }
                        }
                    }

                    $jobNumber = getJobNumber($inserted_job_id);
                    $updateArray = array('job_number' => $jobNumber);
                    $updateWhere = array('id' => $inserted_job_id);
                    $this->common_model->update(TBL_JOB_MASTER, $updateArray, $updateWhere);
                    /*Email to Admin and Staff about new Job*/
                    //EmailUtility::sendEmail($generatorEmail, $subject1, $template, $templateData, null, $requestEmail);
                    /*END EMAIL CODE*/
                    $this->session->set_flashdata('success', 'Job has been successfully added.');
                } else {
                    $this->session->set_flashdata('error', "There is an error while creating job.");
                }
                redirect('/jobs');
            } else{
                //echo "Validation Failed"; die;
            }
        }

        $where = array('status' => 1);
        $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data = array('clients' => $clients);

        $where = array('role_id' => 2,'status' => 'A');
        $staff = $this->common_model->getRecords(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data['staff'] = $staff;

        $where = array('status' => '1');
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE,array( 'id','work'), $where, 'work');
        $data['workTypes'] = $workTypes;


        $where = array('status' => '1');
        $documentTypes = $this->common_model->getRecords(TBL_DOCUMENTS_MASTER,array( 'id','name'), $where, 'name');
        $data['documentTypes'] = $documentTypes;

        $data['currentUserId'] = getCurrentUsersId();

        $this->template->set('title', 'Create Job');
        $this->template->load('default', 'contents', 'default/jobs/new_job',$data);
    }

    private function do_upload_documents($inserted_job_id=false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . $inserted_job_id;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . 'documents' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();


        if (isset($_FILES['add_document_name']) && is_array($_FILES['add_document_name'])) {
            /*ADD MORE*/
            //$filesCount = count($_FILES["add_agreement_name"]['name']);
            foreach ($_FILES["add_document_name"]['name'] as $key => $file) {
                $fileObjName = 'attachment' . $key;
                $_FILES[$fileObjName]['name'] = $_FILES['add_document_name']['name'][$key];
                $_FILES[$fileObjName]['type'] = $_FILES['add_document_name']['type'][$key];
                $_FILES[$fileObjName]['tmp_name'] = $_FILES['add_document_name']['tmp_name'][$key];
                $_FILES[$fileObjName]['error'] = $_FILES['add_document_name']['error'][$key];
                $_FILES[$fileObjName]['size'] = $_FILES['add_document_name']['size'][$key];

                $new_name = time() . '_' . $_FILES[$fileObjName]['name'];
                $config = array(
                    'upload_path' => $uploadDirectory,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg",
                    'overwrite' => TRUE,
                    'max_size' => "0", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    //'max_height' => "768",
                    //'max_width' => "1024",
                    'file_name' => $new_name
                );
                $this->upload->initialize($config);
                if ($this->upload->do_upload($fileObjName)) {
                    $uploadedFiles[$key] = $this->upload->data();
                } else {
                    $uploadedFiles[$key] = array('error' => $this->upload->display_errors());
                }
            }
        }
        return $uploadedFiles;
    }

    private function do_upload_jobs($inserted_job_id=false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . $inserted_job_id;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . 'jobcards' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();
        if (isset($_FILES['job_card']) && is_array($_FILES['job_card'])) {
            $new_name = time() . '_' . $_FILES['job_card']['name'];
            $config = array(
                'upload_path' => $uploadDirectory,
                'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg",
                'overwrite' => TRUE,
                'max_size' => "0", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                //'max_height' => "768",
                //'max_width' => "1024",
                'file_name' => $new_name
            );
            $this->upload->initialize($config);
            if ($this->upload->do_upload("job_card")) {
                $uploadedFiles = $this->upload->data();
            } else {
                $uploadedFiles = array('error' => $this->upload->display_errors());
            }
        }
        return $uploadedFiles;
    }

    public function getDetailByWorkType(){
        if($this->input->is_ajax_request()) {
            $workType = $this->input->post('work_type');
            if($workType) {


                $clientId = $this->input->post('clientId');
                $clientRecord = new stdClass();
                if($clientId) {
                    $where = array('client_id' => $clientId);
                    $clientRecord = $this->common_model->getRecord(TBL_CLIENT_MASTER, array('*'), $where);
                }

                $data = array('type' => $workType, 'clientRecord' => $clientRecord);
                $flieds = $this->load->view('default/jobs/workTypeForm', $data, TRUE);

                $where = array('id' => $workType);
                $workTypeRecord = $this->common_model->getRecord(TBL_WORK_TYPE, array('price'), $where);

                $response = array('formFields'=> $flieds, 'price' => $workTypeRecord->price);
                echo  json_encode($response);
            }
        }
    }

    public function job_details($jobId){
        $type = $this->input->get('type');
        $jobDetail = $this->job_model->getJob($jobId);
        $data = array('jobDetail' => $jobDetail);
        $userInfo = getCurrentUser();
        $data['userRole'] = explode(',',$userInfo->role_id);
        //$data['requestUser'] = getUserInfo($jobDetail->created_by);

        if($jobDetail->staff_id) {
            $staffDetail = getUserInfo($jobDetail->staff_id);
            $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
            $data['staffName'] = $staffName;
        }

        $where = array('job_id' => $jobId);
        $jobCard = $this->common_model->getRecord(TBL_JOBCARDS_FILES, array(
            'file_path','file_name', 'file_detail'), $where);
        $data['jobCard'] = $jobCard;

        $jobDocuments = $this->job_model->getJobDocuments($jobId);
        //print_r($jobDocuments);
        $data['jobDocuments'] = $jobDocuments;
        if($type == 'print') {
            $viewHtml = $this->load->view('default/jobs/print', $data, true);
        } else {
            $viewHtml = $this->load->view('default/jobs/view', $data, true);
        }
        echo $viewHtml;
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
                echo json_encode($clientRecord);
                die;
            }
        }
    }

    public function getIncomeSourceFields(){
        if($this->input->is_ajax_request()) {
            $type = $this->input->post('type');
            $data = array('type' => $type);
            $flieds = $this->load->view('default/jobs/sourceOfIncome', $data, TRUE);
            echo $flieds;
        }
    }
}