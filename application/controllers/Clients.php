<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

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
        $this->load->model('job_model');
        $this->load->library('emailUtility');
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
                    $orderColumn = "father_first_name";
                    break;
                case 3 :
                    $orderColumn = "pan_no";
                    break;
                case 4 :
                    $orderColumn = "aadhar_number";
                    break;
                case 5 :
                    $orderColumn = "mobile";
                    break;
                default:
                    $orderColumn = "first_name";
            }
            $orderBY = $orderColumn . " " . $order;

            $clientList = $this->ClientModel->listClient($userDetail->id, $categoryId, $status, $name, $orderBY, $start, $length);
            $recordsTotal = $this->ClientModel->count_all($userDetail->id);
            $recordsFiltered = $this->ClientModel->count_filtered($userDetail->id, $categoryId, $status, $name, $orderBY);

            $draw = $this->input->get('draw');
            $data = array();
            if ($clientList) {
                $sn = $start + 1;
                foreach ($clientList as $client) {
                    $clientName = $client->first_name . ' ' . $client->last_name;
                    $father_name = $client->father_first_name . " " . $client->father_last_name;

                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $client->client_id . " title='View'><i class='icon-view1'></i></a>";
                    if ($isSuperAdmin || $isRecieptionist) {
                        $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='" . base_url() . "clients/edit-client/" . $client->client_id . "' data-target-id=" . $client->client_id . " title='Edit'><i class='icon-edit'></i></a>";
                    }
                    $tempData = array("client_id" => $client->client_id,
                        "client_name" => $clientName,
                        "firm_name"   => ($client->firm_name) ? $client->firm_name : '--',
                        "father_name" => $father_name,
                        "pan_no" => $client->pan_no,
                        "aadhar_no" => $client->aadhar_number,
                        "mobile" => $client->mobile,
                        "action" => $actionLink,
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
        $this->template->set('title', 'Client List');
        $this->template->load('default', 'contents', 'default/clients/list', $data);
    }

    /*
    * Add Client
    * URL - Clients/add-client
    * @purpose - To Add client.
    * @Date - 17/01/2018
    * @author - NJ
    */
    public function add_client()
    {
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        if (!in_array(SUPERADMINROLEID, $rolesIDArray) && !in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $this->session->set_flashdata('error', "You don't have permission to create client.");
            redirect('/dashboard');
        }

        $postData = $this->input->post(NULL, true);
        if ($postData) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            //$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            //$this->form_validation->set_rules('father_first_name', 'First Mame', 'required|trim');
            //$this->form_validation->set_rules('father_last_name', 'Last Name', 'required|trim');

            /*Salesperson Validation Rule*/
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|trim');
            //$this->form_validation->set_rules('pan_no', 'PAN NO.', 'required|trim');
            //$this->form_validation->set_rules('aadhar_no', 'Aadhar Number', 'required|trim');
            //$this->form_validation->set_rules('dob', 'DOB', 'required|trim');

            $this->form_validation->set_rules('address1', 'Address Line1', 'required|trim');

            $this->form_validation->set_message('valid_email', 'Invalid Email Address');

            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim|min_length[5]|numeric');
            $this->form_validation->set_rules('state', 'State', 'required|trim');

            if ($this->form_validation->run()) {
                //echo "<pre>"; print_r($postData); exit;
                $insert_data = array(
                    'first_name' => $postData['first_name'],
                    'middle_name' => $postData['middle_name'],
                    'last_name' => $postData['last_name'],
                    'father_first_name' => $postData['father_first_name'],
                    'father_middle_name' => $postData['father_middle_name'],
                    'father_last_name' => $postData['father_last_name'],
                    'firm_name'  => $postData['firm_name'],
                    'is_manager'  => $postData['is_manager'],
                    'mobile' => $postData['mobile_number'],
                    'email' => $postData['email'],
                    'pan_no' => $postData['pan_no'],
                    'aadhar_number' => $postData['aadhar_no'],
                    'gst_no' => $postData['gst_no'],
                    'dob' => ($postData['dob']) ? date('Y-m-d', strtotime($postData['dob'])) : null,
                    'address1' => $this->input->post('address1'),
                    'address2' => $this->input->post('address2'),
                    'country' => 101,
                    'created_by' => getCurrentUsersId(),
                    'created_date' => date('Y-m-d H:i:s', now()),
                );
                $insert_data['state'] = $this->input->post('state');
                $insert_data['city'] = $this->input->post('city');
                $insert_data['zip_code'] = $this->input->post('zip_code');
                //print_r($insert_data); die;
                $inserted_client_id = $this->common_model->insert(TBL_CLIENT_MASTER, $insert_data);

                if ($inserted_client_id) {

                    /*START upload Documents*/
                    $upload_doc_data = $this->do_upload_documents($inserted_client_id);
                    if (isset($postData['file-upload-input']) && !empty($postData['file-upload-input']) && count($upload_doc_data)) {
                        /* Insert agreement  information.*/
                        $numFields = count($postData['file-upload-input']);
                        for ($i = 0; $i < $numFields; $i++) {
                            if (isset($upload_doc_data[$i]['full_path'])) {
                                $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $upload_doc_data[$i]['full_path']);
                                $filePath = UPLOAD_ROOT_DIR . end($jobCardDocArray);
                                $data = array(
                                    'client_id' => $inserted_client_id,
                                    'attach_type' => (isset($postData['add_job_doc'][$i])) ? $postData['add_job_doc'][$i] : 0,
                                    'attach_file_path' => $filePath,
                                    'attach_file_name' => $upload_doc_data[$i]['client_name'],
                                    'attach_file_detail' => json_encode($upload_doc_data[$i]),
                                );
                                if ($data['attach_type'] == 0) {
                                    $data['other_file_name'] = (isset($postData['add_job_other'][$i])) ? $postData['add_job_other'][$i] : null;
                                }
                                $this->common_model->insert(TBL_CLIENTS_ATTACHMENTS, $data);
                            }
                        }
                    }
                    /*END DOCUMENT UPLOAD*/

                    /*Send Email notification to Admin*/
                    /*$adminEmails = array();
                    $adminEmails[] = getConfiguration('site_admin_email');
                    $subject = "IMS: New Client Added";
                    $template = 'client-add-edit-notification';
                    $client = (object) $insert_data;
                    $user = getCurrentUser();
                    $userDetail = ucwords($user->first_name.' '.$user->last_name);
                    $templateData = array('client' => $client, 'user'=> $userDetail );
                    EmailUtility::sendEmail($adminEmails, $subject, $template, $templateData);
                    *//*END EMAIL CODE*/
                    $this->session->set_flashdata('success', $this->lang->line('CLIENT_ADD_SUCCESS'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('CLIENT_ADD_ERROR'));
                }
                redirect('clients');
            } else {
                //$this->session->set_flashdata('error', validation_errors());
                //print_r(validation_errors()); die;
            }
        }
        $state = $this->common_model->getRecords(TBL_STATE_MASTER, 'id,state_name');
        $data['state'] = $state;

        $where = array('status' => '1');
        $documentTypes = $this->common_model->getRecords(TBL_DOCUMENTS_MASTER, array('id', 'name'), $where, 'name');
        $data['documentTypes'] = $documentTypes;

        $this->template->set('title', 'Add Client');
        $this->template->load('default', 'contents', 'default/clients/add_client', $data);
    }

    /*
     * edit_client
     * @URL -Clients/edit-client
     * @purpose - To update client's information like address, sales person, account person and agreements etc.
     * @Date - 17/01/2018
     * @author - DT
     */
    public function edit_client($encryptedClientId = '')
    {
        $userDetail = getCurrentUser();
        $usersRoles = $userDetail->role_id;
        $rolesIDArray = explode(',', $usersRoles);
        if (!in_array(SUPERADMINROLEID, $rolesIDArray) && !in_array(RECIEPTIONISTROLEID, $rolesIDArray)) {
            $this->session->set_flashdata('error', "You don't have permission to edit client.");
            redirect('/dashboard');
        }
        if ($encryptedClientId == '') {
            $this->session->set_flashdata('success', "Some thing happened wrong");
            redirect('clients');
        }
        $clientId = $encryptedClientId;//base64_decode($encryptedClientId);
        $postData = $this->input->post(NULL, true);
        if ($postData && ($clientId == $this->input->post('client_id'))) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            //$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            //$this->form_validation->set_rules('father_first_name', 'First Mame', 'required|trim');
            //$this->form_validation->set_rules('father_last_name', 'Last Name', 'required|trim');

            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|trim');
            //$this->form_validation->set_rules('pan_no', 'PAN NO.', 'required|trim');
            //$this->form_validation->set_rules('aadhar_no', 'Aadhar Number', 'required|trim');
            //$this->form_validation->set_rules('dob', 'DOB', 'required|trim');

            $this->form_validation->set_rules('address1', 'Address Line1', 'required|trim');

            $this->form_validation->set_message('valid_email', 'Invalid Email Address');

            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim|min_length[5]|numeric');
            $this->form_validation->set_rules('state', 'State', 'required|trim');

            if ($this->form_validation->run()) {
                //$upload_data = $this->multifiles_do_upload($clientId);
                $update_data = array(
                    'first_name' => $postData['first_name'],
                    'middle_name' => $postData['middle_name'],
                    'last_name' => $postData['last_name'],
                    'father_first_name' => $postData['father_first_name'],
                    'father_middle_name' => $postData['father_middle_name'],
                    'father_last_name' => $postData['father_last_name'],
                    'firm_name'  => $postData['firm_name'],
                    'is_manager'  => $postData['is_manager'],
                    'mobile' => $postData['mobile_number'],
                    'email' => $postData['email'],
                    'pan_no' => $postData['pan_no'],
                    'aadhar_number' => $postData['aadhar_no'],
                    'gst_no' => $postData['gst_no'],
                    'dob' => ($postData['dob']) ? date('Y-m-d', strtotime($postData['dob'])) : null,
                    'address1' => $this->input->post('address1'),
                    'address2' => $this->input->post('address2'),
                    'last_modify_by' => getCurrentUsersId(),
                    'modified_date' => date('Y-m-d H:i:s', now()),
                );
                $update_data['state'] = $this->input->post('state');
                $update_data['city'] = $this->input->post('city');
                $update_data['zip_code'] = $this->input->post('zip_code');
                $where = array('client_id' => $clientId);
                $updated_client_id = $this->common_model->update(TBL_CLIENT_MASTER, $update_data, $where);
                if ($updated_client_id) {

                    /*START upload Documents*/
                    $upload_doc_data = $this->do_upload_documents($clientId);
                    if (isset($postData['file-upload-input']) && !empty($postData['file-upload-input']) && count($upload_doc_data)) {
                        /* Insert agreement  information.*/
                        $numFields = count($postData['file-upload-input']);
                        for ($i = 0; $i < $numFields; $i++) {
                            if (isset($upload_doc_data[$i]['full_path'])) {
                                $jobCardDocArray = explode(UPLOAD_ROOT_DIR, $upload_doc_data[$i]['full_path']);
                                $filePath = UPLOAD_ROOT_DIR . end($jobCardDocArray);
                                $data = array(
                                    'client_id' => $clientId,
                                    'attach_type' => (isset($postData['add_job_doc'][$i])) ? $postData['add_job_doc'][$i] : 0,
                                    'attach_file_path' => $filePath,
                                    'attach_file_name' => $upload_doc_data[$i]['client_name'],
                                    'attach_file_detail' => json_encode($upload_doc_data[$i]),
                                );
                                if ($data['attach_type'] == 0) {
                                    $data['other_file_name'] = (isset($postData['add_job_other'][$i])) ? $postData['add_job_other'][$i] : null;
                                }
                                $this->common_model->insert(TBL_CLIENTS_ATTACHMENTS, $data);
                            }
                        }
                    }
                    /*END DOCUMENT UPLOAD*/

                    $this->session->set_flashdata('success', $this->lang->line('CLIENT_EDIT_SUCCESS'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('CLIENT_ADD_ERROR'));
                }
                redirect('clients');
            } else {
                //$this->session->set_flashdata('error', validation_errors());
            }
        }

        $clientDetail = $this->common_model->getRecord(TBL_CLIENT_MASTER, '*', array('client_id' => $clientId));
        if ($clientDetail) {
            $state = $this->common_model->getRecords(TBL_STATE_MASTER, 'id,state_name');
            $data['state'] = $state;
            $data['clientDetail'] = $clientDetail;

            $where = array('status' => '1');
            $documentTypes = $this->common_model->getRecords(TBL_DOCUMENTS_MASTER, array('id', 'name'), $where, 'name');
            $data['documentTypes'] = $documentTypes;

            $clientDocuments = $this->ClientModel->getJobDocuments($clientId);
            //print_r($jobDocuments);
            $data['clientDocuments'] = $clientDocuments;

            $this->template->set('title', 'Edit Client');
            $this->template->load('default', 'contents', 'default/clients/add_client', $data);
        } else {
            $this->session->set_flashdata('error', 'Client Not Found');
            redirect('clients');
        }
    }

    /*
    * view_client
    * URL - view-client
    * PURPOSE - To view Client
    * @Date - 17/01/2018
    * @author - NJ
    */
    public function view_client($clientId)
    {

        $where = array('client_id' => $clientId);
        $clientInfo = $this->common_model->getRecord(TBL_CLIENT_MASTER, array('*'), $where);
        $clientDocuments = $this->ClientModel->getJobDocuments($clientId);
        //print_r($jobDocuments);
        $data = array('clientInfo' => $clientInfo);
        $data['clientDocuments'] = $clientDocuments;
        $jobDocuments =$this->job_model->getClientsJobDocuments($clientId);
        $data['jobDocuments'] = $jobDocuments;
        $viewHtml = $this->load->view('default/clients/view', $data, true);
        echo $viewHtml;
    }

    /*
   * clientExists
   * @purpose - To check client exists in table .
   * @Date - 16/03/2018
   * @author - NJ
   */
    public function clientExists()
    {
        //selecting records from database .
        $where = array('client_name' => $this->input->post('client_name'));
        $query = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id', 'client_name'), $where);
        if (count($query) > 0) {
            echo 'false';
            die;

        } else {
            echo 'true';
            die;
        }

    }

    /**
     * @param bool $inserted_job_id
     * @return array
     */
    private function do_upload_documents($inserted_job_id = false)
    {
        $folderName = 'client-documents';
        $uploadDirectory = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $inserted_job_id;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . DIRECTORY_SEPARATOR;
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

    public function check_pan()
    {
        if ($this->input->is_ajax_request()) {
            $pan_no = $this->input->get('pan_no', true);
            $clientId = $this->input->get('clientId', true);
            $where = array('pan_no' => $pan_no);
            if(!empty($clientId)) {
                $where['client_id !='] = $clientId;
            }

            $query = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id'), $where);
            if (count($query) > 0) {
                echo 'false';
                die;
            } else {
                echo 'true';
                die;
            }
        }
    }

    public function check_aadhar()
    {
        if ($this->input->is_ajax_request()) {
            $aadhar_no = $this->input->get('aadhar_no', true);
            $clientId = $this->input->get('clientId', true);
            $where = array('aadhar_number' => $aadhar_no);
            if(!empty($clientId)) {
                $where['client_id !='] = $clientId;
            }
            $query = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id'), $where);
            if (count($query) > 0) {
                echo 'false';
                die;
            } else {
                echo 'true';
                die;
            }
        }
    }

    /**
     * @param int $clientId
     * @param int $fileId
     * @author DHARMENDRA T
     * @version 1.0
     */
    public function delete_file($clientId = 0, $fileId = 0){
        $basePath = FCPATH;
        if(!$clientId) {
            $this->session->set_flashdata('error', "Unable to find client. Please try again");
            redirect('/clients');
        }
        if($fileId) {
            $where = array('attach_id' => $fileId, 'client_id' => $clientId);
            $fileRecord = $this->common_model->getRecord(TBL_CLIENTS_ATTACHMENTS, array('attach_id', 'attach_file_path'), $where);
            if($fileRecord){
                $deleted = $this->common_model->delete(TBL_CLIENTS_ATTACHMENTS, $where);
                if($deleted) {
                    /*Remove File as well*/
                    $fileFullPath = $basePath.DIRECTORY_SEPARATOR.$fileRecord->attach_file_path;
                    unlink($fileFullPath);
                    $this->session->set_flashdata('success', 'Document has been deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', "There is an error while deleting document.");
                }
            } else {
                $this->session->set_flashdata('error', "Unable to find document. Please try again.");
            }
        } else {
            $this->session->set_flashdata('error', "There is an error while deleting document.");
        }
        redirect('/clients/edit-client/'.$clientId);
    }

    /*To Download All Client List*/
    public function download_all_client(){
        $this->load->library('Phpspreadsheet');
        $searchKey= $this->input->get('searchKey', true);
        $orderColumn = "first_name";
        $direction = "ASC";
        $orderBY = $orderColumn . " " . $direction;
        $start = 0;
        $length = 10000;
        $clientList = $this->ClientModel->listClient(false, false, false, $searchKey, $orderBY, $start, $length);
        $fileName = "Client-list-".date('d-M-Y');
        $header = array('Client Code', 'Client Name','Father Name', 'Firm Name',
            'Mobile NO.','PAN', 'Aadhar NO.','GST', 'DOB', 'Email', 'Address 1',
            'Address 2','Is Responsible');
        $dataArray = array();
        $dataArray[] =$header;
        if ($clientList) {
            foreach ($clientList as $client) {
                $clientName = $client->first_name . ' ' . $client->last_name;
                $father_name = $client->father_first_name . " " . $client->father_last_name;

                $tempData = array(
                    $client->client_id,
                    $clientName,
                    $father_name,
                    ($client->firm_name) ? $client->firm_name : '--',
                    $client->mobile,
                    $client->pan_no,
                    $client->aadhar_number,
                    $client->gst_no,
                    $client->dob,
                    $client->email,
                    $client->address1,
                    $client->address2,
                    ($client->is_manager)?'YES':'NO'
                );
                $dataArray[] = $tempData;
            }
        }
        $this->phpspreadsheet->createXlSX($fileName, $dataArray, "Client List");
        exit();
    }
}
