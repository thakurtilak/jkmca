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
        $this->load->model('InquiryModel');
        $this->load->library('emailUtility');
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /*View Jobs*/
    public function index(){
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
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
            $status_id = $this->input->get('status_id');
            $status = (!empty($status_id)) ? $status_id : false;
            $month  = (!empty($this->input->get('financial_month'))) ? $this->input->get('financial_month') : false;
            $payment_status = $this->input->get('payment_status');
            $financial_year = (!empty($this->input->get('financial_year'))) ? $this->input->get('financial_year') : false;
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
            $jobsList = $this->job_model->listJobs($userID, $work_type, $status, $month, $payment_status, $searchKey, $orderBY, $start, $length, $financial_year);
            $recordsTotal = $this->job_model->count_all($userID);
            $recordsFiltered = $this->job_model->count_filtered($userID, $work_type, $status, $month, $payment_status, $searchKey, $orderBY, $financial_year);

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
                    $staff_name = $job->staff_name;
                    if($job->status == 'pending') {
                        $status = 'Pending';
                    } else if($job->status == 'approval_pending') {
                        $status = 'Pending For Review';
                    } else if($job->status == 'rejected') {
                        $status = 'Rejected';
                    }else if($job->status == 'completed') {
                        $status = 'Completed';
                    } else {
                        $status = $job->status;
                    }
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $job->id . " title='View'><i class='icon-view1'></i></a>";
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."jobs/view-job/".$job->id."' data-target-id=" . $job->id . " title='View Details'><i class='icon-generate_invoice'></i></a>";
                    if ($isSuperAdmin || (($isRecieptionist) && ($job->status == 'pending' || $job->status == 'rejected'))) {
                        $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='" . base_url() . "jobs/edit-job/" . $job->id . "' data-target-id=" . $job->id . " title='Edit'><i class='icon-edit'></i></a>";
                    }


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

        $data['isStaff'] = $isStaff;
        $data['isRecieptionist'] = $isRecieptionist;
        $data['isSuperAdmin'] = $isSuperAdmin;
        $where1 = array('status' => 1);
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE, array('id','work'), $where1, 'work');
        $data['workTypes'] = $workTypes;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Job List');
        $this->template->load('default', 'contents', 'default/jobs/index', $data);
    }

    public function new_job($refId = false){
        $clientId = false;
        $inquiryDetail = null;
        if($refId) {
            $inquiryDetail = $this->InquiryModel->getInquiry($refId);
            if($inquiryDetail && $inquiryDetail->client_id) {
                $clientId = $inquiryDetail->client_id;
            }
        }
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
            $this->form_validation->set_rules('work_type', 'Work Type', 'required');
            $this->form_validation->set_rules('client_code', 'Client Code', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');
            $this->form_validation->set_rules('staff', 'Staff', 'required');
            $this->form_validation->set_rules('completion_date', 'Completion Date', 'required');
            /*echo "<pre>";
            print_r($postData);
            print_r($_FILES);
            die;*/
            if ($this->form_validation->run()) {
                $work_type = $postData['work_type'];
                $insertArray = array(
                    'client_id' => $postData['client_code'],
                    'work_type' => $work_type,
                    'amount'    => $postData['price'],
                    'discount_price' => $postData['discount_price'],
                    'advanced_amount'  => $postData['advance_price'],
                    'remaining_amount' => $postData['remaining_amount'],
                    'staff_id'  => $postData['staff'],
                    'completion_date' => date('Y-m-d', strtotime($postData['completion_date'])),
                    'remark'  => $postData['remark'],
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by'   => getCurrentUsersId(),
                    'financial_year' => getCurrentFinancialYear()
                );

                if(isset($postData['payment_responsible']) && !empty($postData['payment_responsible'])) {
                    $insertArray['payment_responsible'] = $postData['payment_responsible'];
                }
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

                if($refId) {
                    $insertArray['temp_ref_no'] = $refId;
                }
                /*echo "<pre>";
                print_r($attachment_detail);die;*/
                $inserted_job_id = $this->common_model->insert(TBL_JOB_MASTER, $insertArray);
                //$inserted_job_id = 1;
                if($inserted_job_id) {
                    /*If Any advanced amt then save it to payment history */
                    if($insertArray['advanced_amount'] > 0) {
                        $payByUserId = isset($insertArray['payment_responsible']) ? $insertArray['payment_responsible'] : $insertArray['client_id'];
                        $paymentHistory = array(
                            'job_id' => $inserted_job_id,
                            'pay_by' => $payByUserId,
                            'amount' => $insertArray['advanced_amount'],
                            'payment_type' => 'Advanced',
                            'payment_date' => date('Y-m-d H:i:s'),
                            'update_by' => getCurrentUsersId()
                        );
                        $payment_id = $this->common_model->insert(TBL_JOB_PAYMENT_HISTORY, $paymentHistory);
                    }


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
                                if($data['attach_type'] == 0) {
                                    $data['other_file_name'] = (isset($postData['add_job_other'][$i])) ? $postData['add_job_other'][$i] :null;
                                }
                                $this->common_model->insert(TBL_JOBS_ATTACHMENTS, $data);
                            }
                        }
                    }

                    $jobNumber = getJobNumber($inserted_job_id);
                    $updateArray = array('job_number' => $jobNumber);
                    $updateWhere = array('id' => $inserted_job_id);
                    $this->common_model->update(TBL_JOB_MASTER, $updateArray, $updateWhere);
                    if($refId) {/*Update status in Temp Inquiry record*/
                        $updateArray = array('status' => 'COMPLETED');
                        $updateWhere = array('ref_no' => $refId);
                        $this->common_model->update(TBL_INQUIRY_MASTER, $updateArray, $updateWhere);
                    }
                    /*Email to Admin and Staff about new Job*/
                    $administratorEmails = getAdministratorEmail();
                    $subject = "New Job Created Notification";
                    $template = "new_job_created_notification";
                    $jobDetail = $this->job_model->getJob($inserted_job_id);
                    $templateData = array('jobDetail' => $jobDetail, 'updatedMode' => 'created');
                    if ($jobDetail->staff_id) {
                        $staffDetail = getUserInfo($jobDetail->staff_id);
                        $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
                        $templateData['staffName'] = $staffName;
                    }
                    $isEmailSent = EmailUtility::sendEmail($administratorEmails, $subject, $template, $templateData, null);
                    /*END EMAIL CODE*/

                    $this->session->set_flashdata('success', 'Job has been successfully added.');
                } else {
                    $this->session->set_flashdata('error', "There is an error while creating job.");
                }
                redirect('/jobs');
            } else{
                $this->session->set_flashdata('error', validation_errors());
                redirect('/jobs/new-job');
            }
        }

        $where = array('status' => 1);
        $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data = array('clients' => $clients, 'clientId'=> $clientId, 'inquiryDetail' => $inquiryDetail);

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


        $where = array('status' => '1');
        $documentTypes = $this->common_model->getRecords(TBL_DOCUMENTS_MASTER,array( 'id','name'), $where, 'name');
        $data['documentTypes'] = $documentTypes;

        $where = array('status' => '1','is_manager' => '1');
        $managers = $this->common_model->getRecords(TBL_CLIENT_MASTER,array( 'client_id','CONCAT(first_name, " " , IFNULL(middle_name, ""), " ",IFNULL(last_name, "")) as clientName'), $where, 'clientName');
        $data['managers'] = $managers;

        $data['currentUserId'] = getCurrentUsersId();
        $data['rolesIDArray'] = $rolesIDArray;
        $this->template->set('title', 'Create Job');
        $this->template->load('default', 'contents', 'default/jobs/new_job',$data);
    }

    /**
     * @param bool $jobId
     */
    public function edit_job($jobId = false)
    {
        $basePath = FCPATH;
        if(!$jobId) {
            $this->session->set_flashdata('error', "Unable to find JobId. Please try again");
            redirect('/jobs');
        }
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        $isSuperAdmin = false;
        if(in_array(SUPERADMINROLEID, $rolesIDArray)){
            $isSuperAdmin = true;
        }
        if (!in_array(SUPERADMINROLEID, $rolesIDArray) && !in_array(RECIEPTIONISTROLEID, $rolesIDArray) ) {
            $isSuperAdmin = true;
            $this->session->set_flashdata('error', "You are not authorize to edit Job.");
            redirect('/jobs');
        }
        $jobDetail = $this->job_model->getJob($jobId);
        $postData = $this->input->post(NULL, true);
        if($postData && $jobId == $postData['job_id']) {
            if($isSuperAdmin) {
                $this->form_validation->set_rules('update_work_type', 'Work Type', 'required');
                if (!$this->form_validation->run()) {
                    $this->session->set_flashdata('error', "Please select work type.");
                    redirect('/jobs/edit-job/'.$jobId);
                }
            }
            //debug($_FILES, false);
            //debug($postData);
            $uploadError = false;
            /*If Job Card Update*/
            if(isset($_FILES['job_card']['name']) && !empty($_FILES['job_card']['name']) && !$_FILES['job_card']['error']) {
                /*Upload Job card*/
                $upload_data = $this->do_upload_jobs($jobId);
                if(isset($upload_data['full_path'])) {
                    /*Get OlD Job Card*/
                    $where = array('job_id' => $jobId);
                    $jobFileRecords = $this->common_model->getRecords(TBL_JOBCARDS_FILES, array('id', 'file_path'), $where);
                    /*Add New Entry in table*/
                    $jobCardArray = explode(UPLOAD_ROOT_DIR, $upload_data['full_path']);
                    $filePath = UPLOAD_ROOT_DIR.end($jobCardArray);
                    $insertJob = array(
                        'job_id' => $jobId,
                        'file_path' => $filePath,
                        'file_name' => $upload_data['client_name'],
                        'file_detail'=> json_encode($upload_data)
                    );
                    $inserted_id = $this->common_model->insert(TBL_JOBCARDS_FILES, $insertJob);
                    if($inserted_id) {
                        if($jobFileRecords) {
                            foreach ($jobFileRecords as $card) {
                                $delWhere = array('id' => $card->id);
                                $deleted = $this->common_model->delete(TBL_JOBCARDS_FILES, $delWhere);
                                if ($deleted) {
                                    /*Remove File as well*/
                                    $fileFullPath = $basePath . DIRECTORY_SEPARATOR . $card->file_path;
                                    unlink($fileFullPath);
                                }
                            }
                        }
                    }
                } else {
                    $uploadError = TRUE;
                }
            }

            if($uploadError) {
                $this->session->set_flashdata('error', "There is an error while upload Job card. Please try again");
                redirect('/jobs/edit-job/'.$jobId);
            }
            /*Every thing is fine till now*/

            /*upload Documents*/
            $upload_doc_data = $this->do_upload_documents($jobId);
            if(isset($postData['file-upload-input'])) {
                /* Insert agreement  information.*/
                $numFields = count($postData['file-upload-input']);
                for ($i = 0; $i < $numFields; $i++) {
                    if (isset($upload_doc_data[$i]['full_path'])) {
                        $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $upload_doc_data[$i]['full_path']);
                        $filePath = UPLOAD_ROOT_DIR.end($jobCardDocArray);
                        $data = array(
                            'job_id' => $jobId,
                            'attach_type' => (isset($postData['add_job_doc'][$i])) ? $postData['add_job_doc'][$i]:0,
                            'attach_file_path' => $filePath,
                            'attach_file_name' => $upload_doc_data[$i]['client_name'],
                            'attach_file_detail' => json_encode($upload_doc_data[$i]),
                        );
                        if($data['attach_type'] == 0) {
                            $data['other_file_name'] = (isset($postData['add_job_other'][$i])) ? $postData['add_job_other'][$i] :null;
                        }
                        $this->common_model->insert(TBL_JOBS_ATTACHMENTS, $data);
                    }
                }
            }

            /*upload Work File*/
            if($isSuperAdmin && ($jobDetail->status == 'completed' || $jobDetail->status == 'approval_pending')) {
                $upload_file_data = $this->do_upload_work_file_on_edit($jobId);
                if (isset($postData['work_file-upload-input'])) {
                    /* Insert agreement  information.*/
                    $numFields = count($postData['work_file-upload-input']);
                    for ($i = 0; $i < $numFields; $i++) {
                        if (isset($upload_file_data[$i]['full_path'])) {
                            $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $upload_file_data[$i]['full_path']);
                            $filePath = UPLOAD_ROOT_DIR . end($jobCardDocArray);
                            $data = array(
                                'job_id' => $jobId,
                                'attach_type' => (isset($postData['add_job_file'][$i])) ? $postData['add_job_file'][$i] : 0,
                                'file_path' => $filePath,
                                'file_name' => $upload_file_data[$i]['client_name'],
                                'file_detail' => json_encode($upload_file_data[$i]),
                            );
                            $this->common_model->insert(TBL_JOBCARDS_WORK_FILES, $data);
                        }
                    }
                }
            }
            /*END WORK FILE UPLOAD*/

            /*Finally update the Job Record*/
            $updateArray = array(
                'amount' => $postData['price'],
                'discount_price' => $postData['discount_price'],
                'advanced_amount'  => $postData['advance_price'],
                'remaining_amount' => $postData['remaining_amount'],
                'staff_id'  => $postData['staff'],
                'completion_date' => date('Y-m-d', strtotime($postData['completion_date'])),
                'remark'  => $postData['remark'],
            );
            $updateArray['payment_responsible'] = $postData['payment_responsible'];
            if($isSuperAdmin) {
                $updateArray['work_type'] = $postData['update_work_type'];
            }
            $updateWhere = array('id' => $jobId);
            $this->common_model->update(TBL_JOB_MASTER, $updateArray, $updateWhere);

            /*If Any advanced amt then save it to payment history */
            if($updateArray['advanced_amount'] > 0 && $updateArray['advanced_amount'] > $jobDetail->advanced_amount) {
                $payByUserId = isset($updateArray['payment_responsible']) ? $updateArray['payment_responsible'] : $jobDetail->client_id;
                $paymentHistory = array(
                    'job_id' => $jobId,
                    'pay_by' => $payByUserId,
                    'amount' => $updateArray['advanced_amount'],
                    'payment_type' => 'Advanced',
                    'payment_date' => date('Y-m-d H:i:s'),
                    'update_by' => getCurrentUsersId()
                );
                $payment_id = $this->common_model->insert(TBL_JOB_PAYMENT_HISTORY, $paymentHistory);
            }

            $this->session->set_flashdata('success', 'Job has been updated successfully.');
            redirect('/jobs');
        }

        if(!$jobDetail) {
            $this->session->set_flashdata('error', "Unable to find Job details.");
            redirect('/jobs');
        }
        if((!$isSuperAdmin && $jobDetail->status !='pending' && $jobDetail->status !='rejected')) {
            $this->session->set_flashdata('error', "You can't edit this Job. because it's already completed OR Pending for review");
            redirect('/jobs');
        }
        //echo "<pre>"; print_r($jobDetail); exit;
        $data = array('jobDetail' => $jobDetail);
        $data['userRole'] = explode(',',$userDetail->role_id);
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

        $where = array('job_id' => $jobId);
        $jobWorkFiles = $this->common_model->getRecords(TBL_JOBCARDS_WORK_FILES
            , array(
                'id','file_path','file_name', 'attach_type'), $where);
        $data['jobWorkFiles'] = $jobWorkFiles;

        $jobDocuments = $this->job_model->getJobDocuments($jobId);
        //print_r($jobDocuments);
        $data['jobDocuments'] = $jobDocuments;
        if($jobDetail->client_id) {
            $clientDocuments = $this->ClientModel->getJobDocuments($jobDetail->client_id);
            $data['clientDocuments'] = $clientDocuments;
        }

        /*$data['isStaff'] = $isStaff;
        $data['isRecieptionist'] = $isRecieptionist;
        $data['isSuperAdmin'] = $isSuperAdmin;*/
        $data['isSuperAdmin'] = $isSuperAdmin;
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
        $documentTypes = $this->common_model->getRecords(TBL_DOCUMENTS_MASTER,array( 'id','name'), $where, 'name');
        $data['documentTypes'] = $documentTypes;

        $where = array('status' => '1','is_manager' => '1');
        $managers = $this->common_model->getRecords(TBL_CLIENT_MASTER,array( 'client_id','CONCAT(first_name, " " , IFNULL(middle_name, ""), " ",IFNULL(last_name, "")) as clientName'), $where, 'clientName');
        $data['managers'] = $managers;

        $where = array('status' => '1');
        $workTypes = $this->common_model->getRecords(TBL_WORK_TYPE,array( 'id','work'), $where, 'work');
        $data['workTypes'] = $workTypes;

        $this->template->set('title', 'Edit Job');
        $this->template->load('default', 'contents', 'default/jobs/edit_job', $data);

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

        if (isset($_FILES['add_document_name']) && is_array($_FILES['add_document_name']) && count($_FILES["add_document_name"]['name'])) {
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
            if($jobDetail->client_id) {
                $clientDocuments = $this->ClientModel->getJobDocuments($jobDetail->client_id);
                $data['clientDocuments'] = $clientDocuments;
            }
            $viewHtml = $this->load->view('default/jobs/view', $data, true);
        }
        echo $viewHtml;
    }

    /**
     * @param bool $jobId
     */
    public function view_job($jobId = false){
        //error_reporting(0);

        if(!$jobId) {
            $this->session->set_flashdata('error', "There is an error while getting Job. Please try again");
            redirect('/jobs');
        }
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        $isSuperAdmin = false;
        $isRecieptionist = false;
        $isStaff = false;
        if (in_array(SUPERADMINROLEID, $rolesIDArray)) {
            $isSuperAdmin = true;
        } else if(in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $isRecieptionist = true;
        } else {
            $isStaff = true;
        }
        $postData = $this->input->post(NULL, true);
        if($postData && $jobId == $postData['job_id']) {

            /*Mean Job going to completed*/
            if(isset($postData['submit1'])){
                $uploadedFiles = $this->do_upload_work_file($jobId);
                $uploadError = '';
                if($uploadedFiles && isset($postData['file-upload-input'])) {
                    /* Insert agreement  information.*/
                    $numFields = count($postData['file-upload-input']);
                    for ($i = 0; $i < $numFields; $i++) {
                        if (isset($uploadedFiles[$i]['full_path'])) {
                            $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $uploadedFiles[$i]['full_path']);
                            $filePath = UPLOAD_ROOT_DIR.end($jobCardDocArray);
                            $data = array(
                                'job_id' => $jobId,
                                'attach_type' => (isset($postData['add_job_doc'][$i])) ? $postData['add_job_doc'][$i]:0,
                                'file_path' => $filePath,
                                'file_name' => $uploadedFiles[$i]['client_name'],
                                'file_detail' => json_encode($uploadedFiles[$i]),
                            );
                            $this->common_model->insert(TBL_JOBCARDS_WORK_FILES, $data);
                        } elseif (isset($uploadedFiles[$i]['error'])) {
                            $uploadError .= $postData['add_job_doc'][$i]." : ". $uploadedFiles[$i]['error'];
                            $uploadError .='<br>';
                        }
                    }

                    if(!empty($uploadError)) {
                        $this->session->set_flashdata('error', $uploadError);
                        redirect('/jobs/view-job/'.$jobId);
                    }
                    /*Update Job Master records status*/
                    if($isSuperAdmin){
                        $updateArray = array();
                        $updateArray['status'] ='completed';
                        $updateArray['approval_status'] = 1;
                        $updateArray['approval_user_id'] = getCurrentUsersId();
                        $updateArray['approval_comment'] = $postData['staff_comment'];
                        $updateArray['approval_date'] = date('Y-m-d H:i:s');
                        $updateArray['complete_date'] = date('Y-m-d H:i:s');
                    } else {
                        $updateArray = array(
                            'status' => 'approval_pending',
                            'staff_comment' => $postData['staff_comment'],
                            'complete_date' => date('Y-m-d H:i:s')
                        );
                    }
                    $where = array('id' => $jobId);
                    $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);

                    /*Email to Admin and Staff about new Job*/
                    if(!$isSuperAdmin) {
                        $administratorEmails = getAdministratorEmail();
                        $subject = "New Job Pending For Approval";
                        $template = "approval_pending_job_notification";
                        $jobDetail = $this->job_model->getJob($jobId);
                        $templateData = array('jobDetail' => $jobDetail, 'updatedMode' => 'completed');
                        if ($jobDetail->staff_id) {
                            $staffDetail = getUserInfo($jobDetail->staff_id);
                            $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
                            $templateData['staffName'] = $staffName;
                        }
                        //$isEmailSent = EmailUtility::sendEmail($administratorEmails, $subject, $template, $templateData, null);
                    }
                    /*END EMAIL CODE*/
                    $this->session->set_flashdata('success', 'Job files has been successfully uploaded.');
                    redirect('/jobs');
                } else {
                    $this->session->set_flashdata('error', "There is an error while updating job. Please try again");
                    redirect('/jobs/view-job/'.$jobId);
                }
            } elseif (isset($postData['submit2']) || isset($postData['submit3'])) {
                $updateArray = array();
                if(isset($postData['submit2'])) {
                    $updateArray['status'] ='completed';
                    $updateArray['approval_status'] = 1;
                    $updateArray['approval_user_id'] = getCurrentUsersId();
                    $updateArray['approval_comment'] = $postData['approval_comment'];
                    $updateArray['approval_date'] = date('Y-m-d H:i:s');
                    $flag = 'Approved';
                } elseif (isset($postData['submit3'])){
                    $updateArray['status'] ='rejected';
                    $updateArray['reject_user_id'] = getCurrentUsersId();
                    $updateArray['reject_comment'] = $postData['approval_comment'];
                    $updateArray['reject_date'] = date('Y-m-d H:i:s');
                    $flag = 'Rejected';
                }

                if($updateArray) {
                    $where = array('id' => $jobId);
                    $updated = $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);
                    if ($updated) {
                        $this->session->set_flashdata('success', 'Job has been successfully ');
                    } else {
                        $this->session->set_flashdata('error', "There is an error while updating job record.");
                    }
                } else {
                    $this->session->set_flashdata('error', "Some thing happened wrong. Please try again");
                }
                redirect('/jobs');
            } elseif(isset($postData['submit4'])) {
                $jobRecord = $this->common_model->getRecord(TBL_JOB_MASTER, array('amount','advanced_amount','remaining_amount','client_id','payment_responsible'), array('id' => $jobId));

                if(isset($postData['payment_status']) && $jobRecord) {
                    $remainingAmount = $jobRecord->remaining_amount - $postData['pay_amount'];
                    $remainingAmount = ($remainingAmount > 0 ) ? $remainingAmount : 0;
                    $updateArray = array(
                        'remaining_amount' => $remainingAmount
                    );
                    //echo "<pre>"; print_r($jobRecord); print_r($postData); print_r($updateArray); exit;
                    $where = array('id' => $jobId);
                    $updated = $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);
                    if ($updated) {
                        /*Add in payment history */
                        $payByUserId = ($jobRecord->payment_responsible) ? $jobRecord->payment_responsible : $jobRecord->client_id;
                        $paymentHistory = array(
                            'job_id' => $jobId,
                            'pay_by' => $payByUserId,
                            'amount' => $postData['pay_amount'],
                            'payment_type' => 'onCompleted',
                            'payment_date' => date('Y-m-d H:i:s'),
                            'update_by' => getCurrentUsersId()
                        );
                        $payment_id = $this->common_model->insert(TBL_JOB_PAYMENT_HISTORY, $paymentHistory);

                        $this->session->set_flashdata('success', 'Payment has been updated successfully');
                    } else {
                        $this->session->set_flashdata('error', "There is an error while updating job record.");
                    }
                } else{
                    $this->session->set_flashdata('error', "Please select payment status.");
                }
                redirect('/jobs/view-job/'.$jobId);
            } else {
                $this->session->set_flashdata('error', "Some thing doing wrong.");
                redirect('/jobs');
            }
        }

        $jobDetail = $this->job_model->getJob($jobId);
        if(!$jobDetail) {
            $this->session->set_flashdata('error', "Unable to find Job details.");
            redirect('/jobs');
        }
        /*Addition Security here*/
        if($isStaff && $jobDetail->staff_id != getCurrentUsersId()) {
            $this->session->set_flashdata('error', "Sorry, You are authorize to view this job.");
            redirect('/jobs');
        }
        //echo "<pre>"; print_r($jobDetail); exit;
        $data = array('jobDetail' => $jobDetail);
        $data['userRole'] = explode(',',$userDetail->role_id);
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

        $where = array('job_id' => $jobId);
        $jobWorkFiles = $this->common_model->getRecords(TBL_JOBCARDS_WORK_FILES
            , array(
            'id','file_path','file_name', 'attach_type'), $where);
        $data['jobWorkFiles'] = $jobWorkFiles;

        $jobDocuments = $this->job_model->getJobDocuments($jobId);
        //print_r($jobDocuments);
        $data['jobDocuments'] = $jobDocuments;
        if($jobDetail->client_id) {
            $clientDocuments = $this->ClientModel->getJobDocuments($jobDetail->client_id);
            $data['clientDocuments'] = $clientDocuments;
        }

        $data['isStaff'] = $isStaff;
        $data['isRecieptionist'] = $isRecieptionist;
        $data['isSuperAdmin'] = $isSuperAdmin;
        $this->template->set('title', 'Job Detail');
        $this->template->load('default', 'contents', 'default/jobs/view_job', $data);
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

    public function getIncomeSourceFields(){
        if($this->input->is_ajax_request()) {
            $type = $this->input->post('type');
            $data = array('type' => $type);
            $flieds = $this->load->view('default/jobs/sourceOfIncome', $data, TRUE);
            echo $flieds;
        }
    }

    public function job_file_upload($jobId = false){
        if(!$jobId) {
            $this->session->set_flashdata('error', "There is an error while uploading job file. Please try again");
            redirect('/jobs');
        }
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        $isSuperAdmin = false;
        if (in_array(SUPERADMINROLEID, $rolesIDArray)) {
            $isSuperAdmin = true;
        }
        $postData = $this->input->post();
        if($postData) {
            $uploadResult = $this->do_upload_work_file($jobId);
            //print_r($uploadResult);die;
            if (isset($uploadResult['full_path'])) {
                $jobCardArray = explode(UPLOAD_ROOT_DIR, $uploadResult['full_path']);
                $filePath = UPLOAD_ROOT_DIR . end($jobCardArray);
                $insertJob = array(
                    'job_id' => $jobId,
                    'file_path' => $filePath,
                    'file_name' => $uploadResult['client_name'],
                    'file_detail' => json_encode($uploadResult)
                );
                $inserted_id = $this->common_model->insert(TBL_JOBCARDS_WORK_FILES, $insertJob);
                if ($inserted_id) {
                    /*Update Job Master records status*/
                    if($isSuperAdmin){
                        $updateArray = array();
                        $updateArray['status'] ='completed';
                        $updateArray['approval_status'] = 1;
                        $updateArray['approval_user_id'] = getCurrentUsersId();
                        $updateArray['approval_comment'] = 'Accept';
                        $updateArray['approval_date'] = date('Y-m-d H:i:s');
                        $updateArray['complete_date'] = date('Y-m-d H:i:s');
                    } else {
                        $updateArray = array(
                            'status' => 'approval_pending',
                            'complete_date' => date('Y-m-d H:i:s')
                        );
                    }
                    $where = array('id' => $jobId);
                    $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);

                    /*Email to Admin and Staff about new Job*/
                    if(!$isSuperAdmin) {
                        $administratorEmails = getAdministratorEmail();
                        $subject = "New Job Pending For Approval";
                        $template = "approval_pending_job_notification";
                        $jobDetail = $this->job_model->getJob($jobId);
                        $templateData = array('jobDetail' => $jobDetail, 'updatedMode' => 'completed');
                        if ($jobDetail->staff_id) {
                            $staffDetail = getUserInfo($jobDetail->staff_id);
                            $staffName = $staffDetail->first_name . " " . $staffDetail->last_name;
                            $templateData['staffName'] = $staffName;
                        }
                        $isEmailSent = EmailUtility::sendEmail($administratorEmails, $subject, $template, $templateData, null);
                    }
                    /*END EMAIL CODE*/
                    $this->session->set_flashdata('success', 'Job file has been successfully uploaded.');
                } else {
                    $this->session->set_flashdata('error', "There is an error while updating job record.");
                }

            } else {
                $errorMessage = trim($uploadResult['error']);
                $this->session->set_flashdata('error', $errorMessage);
            }
        }
        redirect('/jobs');
    }

    private function do_upload_work_file($jobId=false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . $jobId;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . 'jobfiles' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();
        if (isset($_FILES['add_document_name']) && is_array($_FILES['add_document_name']) && count($_FILES["add_document_name"]['name'])) {
            foreach ($_FILES["add_document_name"]['name'] as $key => $file) {
                if(!empty($_FILES['add_document_name']['name'][$key])) {
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
        }
        return $uploadedFiles;
    }

    private function do_upload_work_file_on_edit($jobId=false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . $jobId;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . 'jobfiles' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();
        if (isset($_FILES['add_file_name']) && is_array($_FILES['add_file_name']) && count($_FILES["add_document_name"]['name'])) {
            foreach ($_FILES["add_file_name"]['name'] as $key => $file) {
                if(!empty($_FILES['add_file_name']['name'][$key])) {
                    $fileObjName = 'attachment' . $key;
                    $_FILES[$fileObjName]['name'] = $_FILES['add_file_name']['name'][$key];
                    $_FILES[$fileObjName]['type'] = $_FILES['add_file_name']['type'][$key];
                    $_FILES[$fileObjName]['tmp_name'] = $_FILES['add_file_name']['tmp_name'][$key];
                    $_FILES[$fileObjName]['error'] = $_FILES['add_file_name']['error'][$key];
                    $_FILES[$fileObjName]['size'] = $_FILES['add_file_name']['size'][$key];

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
        }
        return $uploadedFiles;
    }

    public function approve_reject_job($jobId = false){
        if(!$jobId) {
            $this->session->set_flashdata('error', "There is an error while updating. Please try again");
            redirect('/jobs');
        }
        $postData = $this->input->post();
        if($postData) {

            $updateArray = array();
            $flag = '';
            if(isset($postData['Approve'])) {
                $updateArray['status'] ='completed';
                $updateArray['approval_status'] = 1;
                $updateArray['approval_user_id'] = getCurrentUsersId();
                $updateArray['approval_comment'] = $postData['comment'];
                $updateArray['approval_date'] = date('Y-m-d H:i:s');
                $flag = 'Approved';
            } elseif (isset($postData['Reject'])){
                $updateArray['status'] ='rejected';
                $updateArray['reject_user_id'] = getCurrentUsersId();
                $updateArray['reject_comment'] = $postData['comment'];
                $updateArray['reject_date'] = date('Y-m-d H:i:s');
                $flag = 'Rejected';
            }
            $where = array('id' => $jobId);
            $updated = $this->common_model->update(TBL_JOB_MASTER, $updateArray, $where);
            if($updated) {
                $this->session->set_flashdata('success', 'Job has been successfully '.$flag);
            } else {
                $this->session->set_flashdata('error', "There is an error while updating job record.");
            }
        } else {
            $this->session->set_flashdata('error', "There is an error while updating job record.");
        }
        redirect('/jobs');
    }

    /**
     * @param int $jobId
     * @param int $workFileId
     * @author DHARMENDRA T
     * @version 1.0
     */
    public function delete_job_file($jobId = 0, $workFileId = 0, $fromEdit = false){
        $basePath = FCPATH;
        if(!$jobId) {
            $this->session->set_flashdata('error', "Unable to find JobId. Please try again");
            redirect('/jobs');
        }
        if($workFileId) {
            $where = array('id' => $workFileId, 'job_id' => $jobId);
            $fileRecord = $this->common_model->getRecord(TBL_JOBCARDS_WORK_FILES, array('id', 'file_path'), $where);
            if($fileRecord){
                $deleted = $this->common_model->delete(TBL_JOBCARDS_WORK_FILES, $where);
                if($deleted) {
                    /*Remove File as well*/
                    $fileFullPath = $basePath.DIRECTORY_SEPARATOR.$fileRecord->file_path;
                    unlink($fileFullPath);
                    $this->session->set_flashdata('success', 'Job file has been deleted successfully ');
                } else {
                    $this->session->set_flashdata('error', "There is an error while deleting job file.");
                }
            } else {
                $this->session->set_flashdata('error', "Unable to find job file. Please try again.");
            }
        } else {
            $this->session->set_flashdata('error', "There is an error while deleting job file.");
        }
        if($fromEdit){
            redirect('/jobs/edit-job/'.$jobId);
        }
        redirect('/jobs/view-job/'.$jobId);
    }


    /**
     * @param int $jobId
     * @param int $documentId
     * @author DHARMENDRA T
     * @version 1.0
     */
    public function delete_job_document($jobId = 0, $documentId = 0){
        $basePath = FCPATH;
        if(!$jobId) {
            $this->session->set_flashdata('error', "Unable to find JobId. Please try again");
            redirect('/jobs');
        }
        if($documentId) {
            $where = array('attach_id' => $documentId, 'job_id' => $jobId);
            $docRecord = $this->common_model->getRecord(TBL_JOBS_ATTACHMENTS, array('attach_id', 'attach_file_path'), $where);
            //debug($docRecord);
            if($docRecord){
                $deleted = $this->common_model->delete(TBL_JOBS_ATTACHMENTS, $where);
                if($deleted) {
                    /*Remove File as well*/
                    $docFullPath = $basePath.DIRECTORY_SEPARATOR.$docRecord->attach_file_path;
                    unlink($docFullPath);
                    $this->session->set_flashdata('success', 'Job document has been deleted successfully ');
                } else {
                    $this->session->set_flashdata('error', "There is an error while deleting job document.");
                }
            } else {
                $this->session->set_flashdata('error', "Unable to find job document. Please try again.");
            }
        } else {
            $this->session->set_flashdata('error', "There is an error while deleting job file.");
        }
        redirect('/jobs/edit-job/'.$jobId);
    }

    /**
     * @param int $jobId
     * @author DHARMENDRA T
     * @version 1.0
     */
    public function delete_job_card($jobId = 0){
        $basePath = FCPATH;
        if(!$jobId) {
            $this->session->set_flashdata('error', "Unable to find JobId. Please try again");
            redirect('/jobs');
        }
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        $isSuperAdmin = false;
        if (in_array(SUPERADMINROLEID, $rolesIDArray)) {
            $isSuperAdmin = true;
        }
        if($isSuperAdmin) {
            $where = array('id' => $jobId);
            $jobRecord = $this->common_model->getRecord(TBL_JOB_MASTER, array('*'), $where);
            if($jobRecord){
                $deleted = $this->common_model->delete(TBL_JOB_MASTER, $where);
                if($deleted) {
                    /*START REMOVE JOB ATTACHMENT*/
                    $where1 = array('job_id' => $jobId);
                    $jobAttachments = $this->common_model->getRecords(TBL_JOBS_ATTACHMENTS, array('attach_id', 'attach_file_path'), $where1);
                    if(count($jobAttachments)) {
                        $allDeleted = $this->common_model->delete(TBL_JOBS_ATTACHMENTS, $where1);
                        foreach ($jobAttachments as $jobAttachment) {
                            /*Remove File as well*/
                            $fileFullPath = $basePath.DIRECTORY_SEPARATOR.$jobAttachment->attach_file_path;
                            unlink($fileFullPath);
                        }
                    }
                    /*END REMOVE JOB ATTACHMENT*/

                    /*START REMOVE JOB CARD*/
                    $where2 = array('job_id' => $jobId);
                    $jobCard = $this->common_model->getRecord(TBL_JOBCARDS_FILES, array('id', 'file_path'), $where2);
                    if($jobCard) {
                        $isDeleted = $this->common_model->delete(TBL_JOBCARDS_FILES, $where2);
                        if($isDeleted){
                            /*Remove Job Card as well*/
                            $fileFullPath = $basePath.DIRECTORY_SEPARATOR.$jobCard->file_path;
                            unlink($fileFullPath);
                        }
                    }
                    /*END REMOVE JOB CARD*/

                    /*START REMOVE JOB Work FILE IF EXIST (in case rejection)*/
                    $where3 = array('job_id' => $jobId);
                    $jobWorkFiles = $this->common_model->getRecords(TBL_JOBCARDS_WORK_FILES, array('id', 'file_path'), $where3);
                    if($jobWorkFiles) {
                        $isDeleted = $this->common_model->delete(TBL_JOBCARDS_WORK_FILES, $where3);
                        if($isDeleted){
                            foreach ($jobWorkFiles as $jobAttachment) {
                                /*Remove File as well*/
                                $fileFullPath = $basePath.DIRECTORY_SEPARATOR.$jobAttachment->file_path;
                                unlink($fileFullPath);
                            }
                        }
                    }
                    /*END REMOVE JOB WORK FILES*/
                    $this->session->set_flashdata('success', 'Job and it\'s related documents has been deleted successfully.');
                    redirect('/jobs');
                } else {
                    $this->session->set_flashdata('error', "There is an error while deleting job.");
                    redirect('/jobs/view-job/'.$jobId);
                }
            } else {
                $this->session->set_flashdata('error', "Unable to find job. Please try again.");
                redirect('/jobs');
            }
        } else {
            $this->session->set_flashdata('error', "You are not authorize to remove Job.");
            redirect('/jobs/view-job/'.$jobId);
        }
    }

    public function document_history($clientId = false, $jobId = false){
        if($this->input->is_ajax_request()) {
            $documents =$this->job_model->getClientsJobDocuments($clientId, $jobId);
            $data = array('documents' => $documents);
            $flieds = $this->load->view('default/jobs/document_history', $data, TRUE);
            echo $flieds;
        }
    }

    public function getAllFinancialYears() {
        if($this->input->is_ajax_request()) {
            $userInfo = getCurrentUser();
            $startMonthTexual = getConfiguration('financial_year_start_month');
            $dateParseArray = date_parse($startMonthTexual);
            $startMonth = ($dateParseArray['month'])? $dateParseArray['month'] : FINANCIAL_YEAR_START_MONTH;
            $selectedMonth = $this->input->post('selMonth');
            $selectedYear = $this->input->post('selYear');
            if(!empty($selectedYear)){
                $selectedFinancialYear = $selectedYear;
            }elseif(!empty($selectedMonth)){
                $selYear = date('Y', strtotime($selectedMonth));
                $selMonth = date('m', strtotime($selectedMonth));
                $initailMonthArray = array('01', '02', '03');
                if(in_array($selMonth, $initailMonthArray)) {
                    $selectedFinancialYear = date('Y', strtotime("-1 year",strtotime($selectedMonth))).'-'.$selYear;
                } else {
                    $selectedFinancialYear = $selYear.'-'. date('Y', strtotime("+1 year",strtotime($selectedMonth)));
                }
            } else{
                $selectedFinancialYear = getCurrentFinancialYear();
            }
            // get current financial year
            $currentFinancialYear = getCurrentFinancialYear();
            //$selectedFinancialYear = '2017-2018';
            $currentMonth = date('Y-m-01');
            

            //$startMonth = date('m', strtotime($startMonthTexual));
            
            // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
            $currentYear = current(explode('-', $currentFinancialYear)) ;
            // Year to start available options at
            $earliest_year = 2018;//date('Y',strtotime($currentYear.' -4 year'));

            $currenctYearStartMonth = date($currentYear.'-'.$startMonth.'-01');
            $latest_year = date('Y', strtotime($currenctYearStartMonth));
            // Loops over each int[year] from current year, back to the $earliest_year [1950]
            $financialYearsNew = array();
            foreach ( range($latest_year, $earliest_year) as $year ) {
                $temp = new stdClass();
                $temp->key = $year ."-". ($year + 1);
                $temp->value = 'FY '.$year ."-". ($year + 1);
                $financialYearsNew[] = $temp;
            }
            $data = array();
            $data['selectedFinancialYear'] = $selectedFinancialYear;
            $data['financialYears'] = $financialYearsNew;
            sendResponse(true, $this->lang->line('SUCCESS'), $data);
        }else{
            sendResponse(false, $this->lang->line('SOMETHING_WENT_WRONG'), array());
        }
    }

    public function getMonthDropDownInJson() {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $financial_year = $this->input->post('year');
            $business_page = (!empty($this->input->post('business_page'))) ? $this->input->post('business_page') : '0' ;
            if ($financial_year) {
                $startYear = current(explode('-', $financial_year));
                $startMonthTexual = getConfiguration('financial_year_start_month');
                $startMonth = date('m', strtotime($startMonthTexual));
                $financialYearStartMonth = date($startYear.'-'.$startMonth.'-01');
                $current_financial_year = getCurrentFinancialYear();
                $current_month = 0;
                if($financial_year == $current_financial_year) {
                    $current_month = date('m');
                }
                if ($business_page == 1) {
                    $current_month = 0;
                }
                $counter = 0;
                $allMonths = array();
                while($counter < 12 ) {
                    $month_number = date('m', strtotime("+$counter month", strtotime($financialYearStartMonth))); 
                    $allMonths[] = date('Y-m-d', strtotime("+$counter month", strtotime($financialYearStartMonth)));
                    $counter++;
                    if ($current_month != 0) {
                        if($month_number == $current_month) {
                            break;
                        }   
                    }
                }
                $data['allMonths'] = $allMonths;
                $data['business_page'] = $business_page;
                $data['current_month'] = $current_month;
                sendResponse(true, $this->lang->line("SUCCESS"), $data);
            }
        }
    }

}