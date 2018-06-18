    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Clients extends CI_Controller {

        /**
         *
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
            $this->load->library('emailUtility');
            if(!$this->session->userdata('systemAdmin'))
            {
                redirect('admin/login');
            }
        }

        /*
         * index
         * List Clients
         */
        public function index(){
            if($this->input->is_ajax_request()) {

                $start =    $this->input->get('start');
                $length =   $this->input->get('length');
                $orderField =    $this->input->get('order[0][column]');
                $order =    $this->input->get('order[0][dir]');
                $categoryId = (!empty($this->input->get('category_id')))? $this->input->get('category_id') : false;
                $status = $this->input->get("status_id");
                $name = $this->input->get('search[value]');
                switch($orderField) {
                    case 1 :
                        $orderColumn = "client_name";
                        break;
                    case 2 :
                        $orderColumn = "category_name";
                        break;
                    case 4 :
                        $orderColumn = "country_name";
                        break;
                    case 5 :
                        $orderColumn = "status";
                        break;
                    case 7 :
                        $orderColumn = "created_date";
                        break;
                    default:
                        $orderColumn = "created_date";
                }
                $orderBY = $orderColumn." ".$order;
                //$userDetail->id
                $clientList = $this->ClientModel->listClient(false, $categoryId, $status, $name, $orderBY, $start, $length );
                $recordsTotal = $this->ClientModel->count_all(false);
                $recordsFiltered = $this->ClientModel->count_filtered(false, $categoryId,$status, $name, $orderBY);
                $draw = $this->input->get('draw');
                $data = array();
                if($clientList) {
                    $sn = $start +1;
                    foreach($clientList as $client) {
                        $clientName = $client->client_name;
                        $category   = $client->category_name;
                        $address = $client->address1." ".$client->address2;
                        $countryName   = $client->country_name;
                        if (trim ( $countryName ) == "" ){
                            $countryName = "--";
                        }

                        if (trim ( $client->gst_no ) == ""){
                            $gst_no = "--";
                        } else {
                            $gst_no = $client->gst_no;
                        }

                        $status = ($client->status == 1) ? "<a href='javascript:void(0);' id='".$client->client_id."' onClick='updateStatus(".$client->client_id.", 0)'>Enable</a>" :"<a href='javascript:void(0);' id='".$client->client_id."' onClick='updateStatus(".$client->client_id.", 1)'>Disable</a>";


                        if(empty($client->created_date)) {
                            $createdDate = '--';
                        } else {
                            $createdDate = date('d-M-Y', strtotime($client->created_date));
                        }

                        $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=".$client->client_id." title='View'><i class='icon-view1'></i></a>";
                        $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."admin/clients/edit-client/".$client->client_id."' data-target-id=".$client->client_id." title='Edit'><i class='icon-edit'></i></a>";
                        $tempData = array("client_id" => $sn,
                            "client_name" => $clientName,
                            "category_name" => $category,
                            "address" => $address,
                            "country" => $countryName,
                            "gst_no" => $gst_no,
                            "status" => $status,
                            //"created_date" => $createdDate,
                            "action" => $actionLink,
                        );
                        $data[]= $tempData;
                        $sn++;
                    }
                }
                $response = array(
                    'draw' => $draw,
                    'recordsTotal'=> $recordsTotal,
                    "recordsFiltered"=>  $recordsFiltered,
                    "data" => $data
                );
                echo json_encode($response);
                exit;
            }
            //Get Order category
            $where = array('status' => 1,'parent_id' =>0,'is_service_category'=> 0);
            $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id','category_name'), $where,'category_name');
            $data = array('categories' => $categories);

            $data['user_id'] = 0;
            $this->template->set('title', 'Client List');
            $this->template->load('admin', 'contents', 'admin/clients/list', $data);
        }

        /*
        * Add Client
        * URL - Clients/add-client
        * @purpose - To Add client.
        * @Date - 17/01/2018
        * @author - NJ
        */
        public function add_client_not_use()
        {
            $postData = $this->input->post();
            if($postData) {
                $this->form_validation->set_rules('category_id', 'Category', 'required|trim');
                $this->form_validation->set_rules('client_name', 'Client Name', 'required|is_unique[ims_client_master.client_name]');

                /*Agreement Validation Rule*/
               /* $this->form_validation->set_rules('agreement_no', 'agreement_no', 'trim|callback_agreement_check');
                $this->form_validation->set_rules('agreement_date', 'agreement_date', 'trim|callback_agreement_check');
                $this->form_validation->set_rules('agreement_name', 'agreement_name', 'trim|callback_agreement_check');
               */
                /*Salesperson Validation Rule*/
                $this->form_validation->set_rules('sales_person_name', 'Manager Name', 'required|trim');
                $this->form_validation->set_rules('sales_contact_no', 'Contact Number', 'required|trim');
                $this->form_validation->set_rules('sales_person_email', 'Email', 'required|trim|valid_email');

                /*Accountperson Validation Rule*/
               /* $this->form_validation->set_rules('account_contact_no', 'account_contact_no', 'required|trim|numeric');
                $this->form_validation->set_rules('account_person_email', 'account_person_email', 'required|trim|valid_email');
               */
                $this->form_validation->set_rules('address1', 'Address Line1', 'required|trim');
                $this->form_validation->set_rules('country', 'Country', 'required|trim');

                $this->form_validation->set_message('valid_email', 'Invalid Email Address');
                if($postData['country'] == '101'){

                    $this->form_validation->set_rules('city', 'City', 'required|trim');
                    $this->form_validation->set_rules('gst_no', 'GSTIN No.', 'required|trim|min_length[15]|max_length[15]');
                    $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim|min_length[5]|numeric');
                    $this->form_validation->set_rules('state', 'State', 'required|trim');
                }

                if ($this->form_validation->run()) {

                    $insert_data = array(
                        'category_id' => $this->input->post('category_id'),
                        'client_name' => $this->input->post('client_name'),
                        'address1' => $this->input->post('address1'),
                        'address2' => $this->input->post('address2'),
                        'country' => $this->input->post('country'),
                        'created_date' => date('Y-m-d H:i:s', now()),
                    );

                    if($postData['country'] == '101'){
                        $insert_data['state'] = $this->input->post('state');
                        $insert_data['city'] = $this->input->post('city');
                        $insert_data['gst_no'] = $this->input->post('gst_no');
                        $insert_data['place_of_supply'] = $this->input->post('place_of_supply');
                        $insert_data['zip_code'] = $this->input->post('zip_code');
                    }
                    $inserted_client_id = $this->common_model->insert(TBL_CLIENT_MASTER, $insert_data);

                    if($inserted_client_id){

                        $upload_data = $this->do_upload($inserted_client_id);
                        if(!empty($this->input->post('sales_person_name'))) {
                            //Add Sales person
                            $salesperson = array(
                                'sales_person_name' => $this->input->post('sales_person_name'),
                                'sales_contact_no' => $this->input->post('sales_contact_no'),
                                'sales_person_email' => $this->input->post('sales_person_email'),
                                'sales_person_address' => $this->input->post('address1'),
                                'sales_person_address2' => $this->input->post('address2'),
                                'client_id' => $inserted_client_id,
                                'created_date' => date('Y-m-d H:i:s', now())
                            );
                            $this->common_model->insert(TBL_CLIENT_SALESPERSON, $salesperson);
                        }

                        if(!empty($this->input->post('account_person_name'))) {
                            //Add Account person
                            $accountperson = array(

                                'account_person_name' => $this->input->post('account_person_name'),
                                'account_contact_no' => $this->input->post('account_contact_no'),
                                'account_person_email' => $this->input->post('account_person_email'),
                                'account_person_address' => $this->input->post('address1'),
                                'account_person_address2' => $this->input->post('address2'),
                                'client_id' => $inserted_client_id,
                                'created_date' => date('Y-m-d H:i:s', now()),

                            );
                            $this->common_model->insert(TBL_CLIENT_ACCOUNTPERSON, $accountperson);
                        }

                        if ($upload_data != 0) {
                            $agreement = array(
                                'category_id' => $this->input->post('category_id'),
                                'agreement_no' => $this->input->post('agreement_no'),
                                'agreement_date' => date('Y-m-d',strtotime($this->input->post('agreement_date'))),
                                'agreement_name' => $upload_data['file_name'],
                                'upload_date' => $this->input->post('agreement_date'),
                                'client_id' => $inserted_client_id,

                            );

                            $this->common_model->insert(TBL_CLIENT_AGREEMENTS, $agreement);
                        }

                        /*Send Email notification to Admin*/
                        $adminEmails = array();
                        $adminEmails[] = getConfiguration('site_admin_email');
                        $subject = "IMS: New Client Added";
                        $template = 'client-add-edit-notification';
                        $client = (object) $insert_data;
                        $client->salesManager = (isset($salesperson)) ? (object) $salesperson : null;
                        $client->accountManager = (isset($accountperson)) ? (object) $accountperson : null;
                        if ($upload_data != 0) {
                            $originalName = trim(strstr($agreement["agreement_name"], '_'), '_');
                            $path =  '<a href="'.base_url().'uploads/client_agreements/'.$inserted_client_id.'/'.$agreement["agreement_name"].'" title="'.$originalName.'">'.$originalName.'</a>';
                            $agreement['agreement_name'] = $path;
                            $client->agreement = (object) $agreement;
                        }
                        $where = array('status' => 1, 'id' => $insert_data['category_id']);
                        $categoryRecord = $this->common_model->getRecord(TBL_CATEGORY_MASTER, 'category_name', $where);
                        $userDetail = "System Admin";
                        $templateData = array('client' => $client, 'category' => $categoryRecord->category_name, 'user'=> $userDetail );
                        EmailUtility::sendEmail($adminEmails, $subject, $template, $templateData);
                        /*END EMAIL CODE*/

                        $this->session->set_flashdata('success', $this->lang->line('CLIENT_ADD_SUCCESS'));
                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('CLIENT_ADD_ERROR'));
                    }
                    redirect('admin/clients');
                } else {
                    //$this->session->set_flashdata('error', validation_errors());
                }
            }

            $where = array('status' => 1, 'parent_id' => 0, 'is_service_category'=> 0);
            $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, 'id,category_name', $where, 'category_name');
            $data = array('categories' => $categories);

            $clientname = $this->common_model->getRecords(TBL_CLIENT_MASTER, 'client_id,client_name');
            $data['clientname'] = $clientname;


            $country = $this->common_model->getRecords(TBL_COUNTRY_MASTER, 'id,country_name');
            $data['country'] = $country;

            $state = $this->common_model->getRecords(TBL_STATE_MASTER, 'id,state_name');
            $data['state'] = $state;

            $this->template->set('title', 'Add Client');
            $this->template->load('admin', 'contents', 'admin/clients/add_client', $data);
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

    /*
   * agreement_check
   * @purpose - Validation for agreement details .
   * @Date - 17/01/2018
   * @author - NJ
   */
    public function agreement_check()
    {
        $agreementno = $this->input->post('agreement_no');
        $agreementdate = $this->input->post('agreement_date');
        $agreementname = $_FILES['agreement_name']['name'];

        if((isset($agreementno) && !empty($agreementno) && empty($agreementname) && empty($agreementdate))){
            $this->form_validation->set_rules('agreement_name', 'agreement_name', 'required');
            $this->form_validation->set_rules('agreement_date', 'agreement_date', 'required|trim');
        }
        elseif(isset($agreementdate) && !empty($agreementdate) && empty($agreementno) && empty($agreementname))
        {
            $this->form_validation->set_rules('agreement_no', 'agreement_no', 'required|integer|trim');
            $this->form_validation->set_rules('agreement_name', 'agreement_name', 'required');
        }
        elseif(isset($agreementname) && !empty($agreementname) && empty($agreementno) &&  empty($agreementdate))
        {
            $this->form_validation->set_rules('agreement_no', 'agreement_no', 'required');
            $this->form_validation->set_rules('agreement_date', 'agreement_date', 'required');
        }
        elseif((isset($agreementno) && !empty($agreementno) && isset($agreementdate) && !empty($agreementdate)  && empty($agreementname))){

            $this->form_validation->set_rules('agreement_name', 'agreement_name', 'required');
        }
        elseif((isset($agreementdate) && !empty($agreementdate) && isset($agreementname) && !empty($agreementname)  && empty($agreementno))) {

            $this->form_validation->set_rules('agreement_no', 'agreement_no', 'required');
        }
        elseif((isset($agreementno) && !empty($agreementno) && isset($agreementname) && !empty($agreementname)  && empty($agreementdate))){
            $this->form_validation->set_rules('agreement_date', 'agreement_date', 'required');
        }
        else{
            return true;
        }

    }

    /*
    *  Upload Agreement
    * @purpose - To Upload agreement in the system.
    * @Date - 17/01/2018
    * @author - NJ
    */
    private function do_upload($clientId = false){

        if(!isset($_FILES["agreement_name"]['name'])) {
            return 0;
        }
        $new_name = time().'_'.$_FILES["agreement_name"]['name'];

        $uploadDirectory = realpath('uploads').DIRECTORY_SEPARATOR.'client_agreements'.DIRECTORY_SEPARATOR;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            ).DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory.$clientId.DIRECTORY_SEPARATOR;

        if(!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $config = array(
            'upload_path' => $uploadDirectory,
            'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|doc|docx|xls|xlsx|eml|msg",
            'overwrite' => TRUE,
            'max_size' => "0", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            //'max_height' => "768",
           // 'max_width' => "1024",
            'file_name' => $new_name
        );
        try{

            $this->upload->initialize($config);
            if($this->upload->do_upload('agreement_name'))
            {
                $agreement =  $this->upload->data();
                return $agreement;

            }
            else{
                return 0;
            }

        }catch(Exception $e) {
            print_r($e); die;
        }

    }

    /*
    *  Upload MultipleAgreement
    * @purpose - To Upload Multiple agreement in system.
    * @Date -24/01/2018
    * @author - NJ
    */
    private function multifiles_do_upload($clientId = false)
    {
        $where= array('client_id'=> $clientId );
        $agreement_detail = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS,'agreement_id',$where);

        //$uploadDirectory = realpath('uploads').DIRECTORY_SEPARATOR;
        $uploadDirectory = realpath('uploads').DIRECTORY_SEPARATOR.'client_agreements'.DIRECTORY_SEPARATOR;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            ).DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory.$clientId.DIRECTORY_SEPARATOR;

        if(!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();
        if($agreement_detail) { /*For existing File*/
            foreach($agreement_detail as $key => $agreement) {
                if (isset($_FILES['agreement_name']['name'][$agreement->agreement_id]) && !empty($_FILES['agreement_name']['name'][$agreement->agreement_id])) {
                    $fileObjName = 'agreement_name_upload'.$key;
                    $_FILES[$fileObjName]['name'] = $_FILES['agreement_name']['name'][$agreement->agreement_id];
                    $_FILES[$fileObjName]['type'] = $_FILES['agreement_name']['type'][$agreement->agreement_id];
                    $_FILES[$fileObjName]['tmp_name'] = $_FILES['agreement_name']['tmp_name'][$agreement->agreement_id];
                    $_FILES[$fileObjName]['error'] = $_FILES['agreement_name']['error'][$agreement->agreement_id];
                    $_FILES[$fileObjName]['size'] = $_FILES['agreement_name']['size'][$agreement->agreement_id];
                    $new_name = time() .'_'. $_FILES[$fileObjName]['name'];
                    $config = array(
                        'upload_path' => $uploadDirectory,
                        'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|doc|docx|xls|xlsx|eml|msg",
                        'overwrite' => TRUE,
                        'max_size' => "0", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "768",
                        //'max_width' => "1024",
                        'file_name' => $new_name
                    );
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($fileObjName)) {
                        $uploadedFiles['existing'][$agreement->agreement_id] = $this->upload->data();
                    } else {
                        //$uploadedFiles[] = array('error' => $this->upload->display_errors());
                    }
                }
            }

        }

        if(isset($_FILES['add_agreement_name']) && is_array($_FILES['add_agreement_name'])) {
            /*ADD MORE*/
            foreach($_FILES["add_agreement_name"]['name'] as $key => $file) {
                $fileObjName = 'agreement_name'.$key;
                $_FILES[$fileObjName]['name'] = $_FILES['add_agreement_name']['name'][$key];
                $_FILES[$fileObjName]['type'] = $_FILES['add_agreement_name']['type'][$key];
                $_FILES[$fileObjName]['tmp_name'] = $_FILES['add_agreement_name']['tmp_name'][$key];
                $_FILES[$fileObjName]['error'] = $_FILES['add_agreement_name']['error'][$key];
                $_FILES[$fileObjName]['size'] = $_FILES['add_agreement_name']['size'][$key];

                $new_name = time() .'_'. $_FILES[$fileObjName]['name'];
                $config = array(
                    'upload_path' => $uploadDirectory,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|doc|docx|xls|xlsx|eml|msg",
                    'overwrite' => TRUE,
                    'max_size' => "0", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    //'max_height' => "768",
                    //'max_width' => "1024",
                    'file_name' => $new_name
                );
                $this->upload->initialize($config);
                if ($this->upload->do_upload($fileObjName)) {
                    $uploadedFiles['new'][] = $this->upload->data();
                } else {
                    //$uploadedFiles[] = array('error' => $this->upload->display_errors());
                }
            }
        }
        return $uploadedFiles;
    }

    /*
     * edit_client
     * @URL -Clients/edit-client
     * @purpose - To update client's information like address, sales person, account person and agreements etc.
     * @Date - 17/01/2018
     * @author - DT
     */
    public function edit_client($encryptedClientId ='')
    {
        if($encryptedClientId==''){
            $this->session->set_flashdata('success',"Some thing happened wrong");
            redirect('admin/clients');
        }
        $clientId = $encryptedClientId;//base64_decode($encryptedClientId);
        $this->load->library('form_validation');
        $postData = $this->input->post();
        if($postData && ($clientId ==  $this->input->post('edit_client_id'))) {
            //$this->form_validation->set_rules('category_id', 'Category', 'required|trim');
            //$this->form_validation->set_rules('edit_client_id', 'Client Name', 'required|trim');
            $this->form_validation->set_rules('address1', 'Address Line1', 'required|trim');
            $this->form_validation->set_rules('country', 'Country', 'required|trim');
            if($postData['country'] == '101') {
                $this->form_validation->set_rules('state', 'State', 'required|trim');
                $this->form_validation->set_rules('city', 'City', 'required|trim');
                $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim|min_length[5]|numeric');
                $this->form_validation->set_rules('gst_no', 'GSTIN No.', 'required|trim|min_length[15]|max_length[15]');
                $this->form_validation->set_rules('place_of_supply', 'Place of supply', 'required|trim');
            }
            /*Sales Person Validation Rule*/
          // $this->form_validation->set_rules('sales_person_name[]', 'Sales Person Name', 'required|trim');
           //$this->form_validation->set_rules('sales_contact_no[]', 'Sales Person contact number', 'required|trim');
            //$this->form_validation->set_rules('sales_person_email[]', 'Sales Person email', 'required|trim|valid_email');

            /*Account Person Validation Rule*/
            //$this->form_validation->set_rules('account_person_name[]', 'Account Person Name', 'required|trim');
            //$this->form_validation->set_rules('account_contact_no[]', 'Account Person contact number', 'required|trim');
            //$this->form_validation->set_rules('account_person_email[]', 'Account Person email', 'required|trim|valid_email');

            /*Agreement Validation Rule*/
            //$this->form_validation->set_rules('agreement_no[]', 'Agreement Number', 'required|trim');
            //$this->form_validation->set_rules('agreement_date[]', 'Agreement Date', 'required|trim');

            $this->form_validation->set_message('valid_email', 'Invalid Email Address');


            if ($this->form_validation->run()) {
                $upload_data = $this->multifiles_do_upload($clientId);

                $update_data = array(
                    'address1' => $this->input->post('address1'),
                    'address2' => $this->input->post('address2'),
                    'country' => $this->input->post('country')
                );
                if($postData['country'] == '101') {
                    $update_data['state'] = $this->input->post('state');
                    $update_data['city'] = $this->input->post('city');
                    $update_data['gst_no'] = $this->input->post('gst_no');
                    $update_data['place_of_supply'] = $this->input->post('place_of_supply');
                    $update_data['zip_code'] = $this->input->post('zip_code');
                }
                $where = array('client_id' => $clientId);
                $updated_client_id = $this->common_model->update(TBL_CLIENT_MASTER, $update_data, $where);
                $this->session->set_flashdata('success',$this->lang->line('CLIENT_EDIT_SUCCESS'));
                 /*
                * Update manager information.
                */
                 $where= array('client_id'=> $clientId );
                 $sales_detail = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, array('salesperson_id','sales_person_name', 'sales_contact_no', 'sales_person_email'),$where);
                 foreach($sales_detail as $key =>$value){
                     if(isset($postData['sales_person_name'][$value->salesperson_id])){
                         $data = array(
                             'sales_person_name' =>  $postData['sales_person_name'][$value->salesperson_id],
                             'sales_contact_no'  =>  $postData['sales_contact_no'][$value->salesperson_id],
                             'sales_person_email'  =>  $postData['sales_person_email'][$value->salesperson_id],
                             'sales_person_address' => $this->input->post('address1'),
                             'sales_person_address2' => $this->input->post('address2'),

                         );
                         $where=array('salesperson_id' => $value->salesperson_id);
                         $this->common_model->update(TBL_CLIENT_SALESPERSON, $data,$where);
                     }
                 }

                /*
                * Update accountperson information.
                */
                $where= array('client_id'=> $clientId );
                $account_detail = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON,array('account_id', 'account_person_name', 'account_contact_no', 'account_person_email'),$where);

                foreach($account_detail as $key => $value){
                    if(isset($postData['account_person_name'][$value->account_id])) {
                        $data = array(
                            'account_person_name' => $postData['account_person_name'][$value->account_id],
                            'account_contact_no' => $postData['account_contact_no'][$value->account_id],
                            'account_person_email' => $postData['account_person_email'][$value->account_id],
                            'account_person_address' => $this->input->post('address1'),
                            'account_person_address2' => $this->input->post('address2'),
                        );
                        $where = array('account_id' => $value->account_id);
                        $this->common_model->update(TBL_CLIENT_ACCOUNTPERSON, $data, $where);
                    }
                }

                /*
                 * Update agreement information.
                 */
                $where= array('client_id'=> $clientId );
                $agreement_detail = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS,array('agreement_id', 'agreement_no', 'agreement_date', 'agreement_name'),$where);
                foreach($agreement_detail as $key => $value){

                    $data = array(
                        'agreement_no' => $postData['agreement_no'][$value->agreement_id]
                    );

                    if(isset($postData['agreement_date'][$value->agreement_id]) && !empty($postData['agreement_date'][$value->agreement_id])) {
                        $data['agreement_name'] = date('Y-m-d', strtotime($postData['agreement_date'][$value->agreement_id]));
                    }

                    if(isset($upload_data['existing'][$value->agreement_id])){
                        $data['agreement_name'] = $upload_data['existing'][$value->agreement_id]['file_name'];
                    }
                    $where=array('agreement_id' => $value->agreement_id);
                    $this->common_model->update(TBL_CLIENT_AGREEMENTS, $data,$where);
                }

                if(isset($postData['add_account_person_name'])) {
                    /* Insert manager information. */
                    $numFields = count($postData['add_account_person_name']);
                    for ($i = 0; $i < $numFields; $i++) {
                        if(!empty($postData['add_account_person_name'][$i]) && !empty($postData['add_account_person_email'][$i])) {

                            $data = array(
                                'account_person_name' => $postData['add_account_person_name'][$i],
                                'account_contact_no' => $postData['add_account_contact_no'][$i],
                                'account_person_email' => $postData['add_account_person_email'][$i],
                                'account_person_address' => $this->input->post('address1'),
                                'account_person_address2' => $this->input->post('address2'),
                                'client_id' => $clientId
                            );
                            $this->common_model->insert(TBL_CLIENT_ACCOUNTPERSON, $data);
                        }

                    }
                }

                if(isset($postData['add_sales_person_name'])) {
                    /* Insert account information.*/
                    $numFields = count($postData['add_sales_person_name']);
                    for ($i = 0; $i < $numFields; $i++) {
                        if(!empty($postData['add_sales_person_name'][$i]) && !empty($postData['add_sales_person_email'][$i])) {
                            $data = array(
                                'sales_person_name' => $postData['add_sales_person_name'][$i],
                                'sales_contact_no' => $postData['add_sales_contact_no'][$i],
                                'sales_person_email' => $postData['add_sales_person_email'][$i],
                                'sales_person_address' => $this->input->post('address1'),
                                'sales_person_address2' => $this->input->post('address2'),
                                'client_id' => $clientId
                            );
                            $this->common_model->insert(TBL_CLIENT_SALESPERSON, $data);
                        }
                    }
                }

                if(isset($postData['add_agreement_no'])) {
                    /* Insert agreement  information.*/
                    $numFields = count($postData['add_agreement_no']);

                    for ($i = 0; $i < $numFields; $i++) {

                        if (isset($upload_data['new'][$i]['file_name'])) {
                            $data = array(
                                'agreement_no' => $postData['add_agreement_no'][$i],
                                'agreement_date' => date('Y-m-d', strtotime($postData['add_agreement_date'][$i])),
                                'agreement_name' => $upload_data['new'][$i]['file_name'],
                                'client_id' => $clientId,
                                'category_id' => $this->input->post('category_id'),
                            );
                            $this->common_model->insert(TBL_CLIENT_AGREEMENTS, $data);
                        }
                    }
                }

                /*Send Email notification to Admin*/
                $adminEmails = array();
                $adminEmails[] = getConfiguration('site_admin_email');
                $subject = "IMS: Client Edited";
                $template = 'client-add-edit-notification';
                $client = (object) $update_data;
                $clientObj = $this->common_model->getRecord(TBL_CLIENT_MASTER,'client_id,client_name', array('client_id' => $clientId));
                $client->client_name = $clientObj->client_name;
                if(isset($postData['add_sales_person_name'])) {
                    $salesObj = new stdClass();
                    $salesObj->sales_person_name =  $postData['add_sales_person_name'][0];
                    $salesObj->sales_contact_no  =  $postData['add_sales_contact_no'][0];
                    $salesObj->sales_person_email=  $postData['add_sales_person_email'][0];
                } else if(is_array($sales_detail) && isset($sales_detail[0])) {
                    $salesObj = $sales_detail[0];
                }

                if(isset($postData['add_account_person_name'])) {
                    $accountObj = new stdClass();
                    $accountObj->account_person_name =  $postData['add_account_person_name'][0];
                    $accountObj->account_contact_no  =  $postData['add_account_contact_no'][0];
                    $accountObj->account_person_email=  $postData['add_account_person_email'][0];
                }else if(is_array($account_detail) && isset($account_detail[0])) {
                    $accountObj = $account_detail[0];
                }

                if(isset($salesObj)) {
                    $client->salesManager = $salesObj;
                }
                if(isset($accountObj)) {
                    $client->accountManager = $accountObj;
                }

                if(isset($postData['add_agreement_no'])) {
                    $agreementObj = new stdClass();
                    $agreementObj->agreement_no =  $postData['add_agreement_no'][0];
                    $agreementObj->agreement_date  =  $postData['add_agreement_date'][0];
                    $agreementObj->agreement_name=  $upload_data['new'][0]['file_name'];
                    $client->agreement = $agreementObj;
                } else if($agreement_detail) {
                    //To get Right agreement name
                    if(isset($upload_data['existing'][$agreement_detail[0]->agreement_id])){
                        $agreement_detail[0]->agreement_name = $upload_data['existing'][$agreement_detail[0]->agreement_id]['file_name'];
                    }
                    $agreementObj = $agreement_detail[0];
                }

                if($agreementObj) {
                    $originalName = trim(strstr($agreementObj->agreement_name, '_'), '_');
                    $path =  '<a href="'.base_url().'uploads/client_agreements/'.$clientId.'/'.$agreementObj->agreement_name.'" title="'.$originalName.'">'.$originalName.'</a>';
                    $agreementObj->agreement_name = $path;
                    $client->agreement = $agreementObj;
                }


                $where = array('status' => 1, 'id' => $this->input->post('category_id'));
                $categoryRecord = $this->common_model->getRecord(TBL_CATEGORY_MASTER, 'category_name', $where);
                $userDetail = "System Admin";
                $templateData = array('edited'=> 1, 'client' => $client, 'category' => $categoryRecord->category_name, 'user'=> $userDetail );
                EmailUtility::sendEmail($adminEmails, $subject, $template, $templateData);
                /*END EMAIL CODE*/
                redirect('admin/clients');
            } else {
                //$this->session->set_flashdata('error', validation_errors());
            }
        }

        $clientDetail = $this->common_model->getRecord(TBL_CLIENT_MASTER,'client_id,client_name, category_id', array('client_id'=> $clientId ));
        if($clientDetail){
            $where= array('status' => 1,'parent_id' => 0, 'is_service_category'=> 0);
            $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER,'id,category_name',$where, 'category_name');
            $data = array('categories'=>$categories, 'clientId'=> $clientId, 'clientDetail'=> $clientDetail);

            $where = array('status' => 1);
            $clientname = $this->common_model->getRecords(TBL_CLIENT_MASTER,'client_id, client_name', $where, 'client_name');
            $data['clientname']= $clientname;


            $country = $this->common_model->getRecords(TBL_COUNTRY_MASTER,'id,country_name');
            $data['country']= $country;

            $state = $this->common_model->getRecords(TBL_STATE_MASTER,'id,state_name');
            $data['state']= $state;

            $this->template->set('title', 'Edit Client');
            $this->template->load('admin', 'contents' , 'admin/clients/edit_client', $data);
        } else {
            $this->session->set_flashdata('error', 'Client Not Found');
            redirect('admin/clients');
        }


    }


    /*
    *  getClientByCategory
    * @purpose - Returns the client info based on category.
    * @Date - 17/01/2018
    * @author - NJ
    */
    public function getClientByCategory()
    {
        if($this->input->is_ajax_request()) {

            $category_id = $this->input->post('cat_id');
            $where = array('status' => 1, 'category_id' => $category_id);
            $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, 'client_id,client_name', $where, 'client_name');

            $data = array('clientname' => $clients);
            $options = $this->load->view('default/clients/options_creator', $data, TRUE);
            echo $options;
            die;
        }
    }

    /*
     * getInfoByClient
     * @purpose - Return the client info based on client id
     * @Date - 17/01/2018
     * @author - NJ
     */
    public function getInfoByClient()
    {
        if($this->input->is_ajax_request()) {
            $clientID = $this->input->post('clientId');
            if($clientID) {
                $where = array('client_id' => $clientID);
                $clientinfo = $this->common_model->getRecord(TBL_CLIENT_MASTER, array('*'), $where);
                $data = array('clientinfo' => $clientinfo);

                $where = array('client_id' => $clientID);
                $agreements = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, 'agreement_id,agreement_no,agreement_name, DATE_FORMAT(agreement_date, "%d-%b-%Y") as agreement_date', $where);
                $data['agreements'] = $agreements;

                $where = array('client_id' => $clientID);
                $salespersons = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, 'salesperson_id,sales_person_name,sales_contact_no,sales_person_email,sales_person_address', $where);
                $data['salespersons'] = $salespersons;

                $where = array('client_id' => $clientID);
                $accountpersons = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, 'account_id,account_person_name,account_contact_no,account_person_email,account_person_address', $where);
                $data['accountpersons'] = $accountpersons;

                echo json_encode($data);
                die;
            } else {
                echo 0;
                exit;
            }
        } else{
            echo 0;
            exit;
        }
    }

        /*
        * view_client
        * URL - view-client
        * PURPOSE - To view Client
        * @Date - 17/01/2018
        * @author - NJ
        */
        public function view_client($clientId){
            $this->load->model('OrdersModel');
            $where = array('client_id' => $clientId);
            $clientInfo = $this->common_model->getRecord(TBL_CLIENT_MASTER, array('*'), $where);
            $data = array('clientInfo' => $clientInfo);

            $where = array('client_id' => $clientId);
            $salesPersons = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, 'salesperson_id,sales_person_name,sales_contact_no,sales_person_email,sales_person_address', $where);
            //var_dump($getsalesperson);die;
            $data['salesPersons'] = $salesPersons;

            $where = array('client_id' => $clientId);
            $accountPersons = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, 'account_id,account_person_name,account_contact_no,account_person_email,account_person_address', $where);
            $data['accountPersons'] = $accountPersons;

            $where = array('client_id' => $clientId);
            $clientAgreements = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, 'agreement_id,client_id,agreement_no,agreement_name, DATE_FORMAT(agreement_date, "%d-%b-%Y") as agreement_date', $where);
            $data['clientAgreements'] = $clientAgreements;
            $data['clientAgreements'] = $clientAgreements;

            $viewHtml = $this->load->view ('admin/clients/view', $data, true);
            echo $viewHtml;
        }

        public function updateStatus(){

            if($this->input->is_ajax_request()) {
                $clientID = $this->input->post('clientId');
                $status = $this->input->post('status');
                if($clientID && $status !=='') {

                    $where= array('client_id' => $clientID);
                    $data = array('status' => $status);
                    $updated = $this->common_model->update(TBL_CLIENT_MASTER, $data, $where);
                    if($updated) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
                    echo 0;
                }
            }
            die;
        }
    }
