<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    /**
     * Invoice controller.
     * Purpose - To create invoice and view and cancel etc.
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
        $this->load->model('InvoiceModel');
        $this->load->library('emailUtility');
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /*
    *  Upload MultipleAgreement
    * @purpose - To Upload Multiple agreement in system.
    * @Date -24/01/2018
    * @author - NJ
    */

    private function multifiles_do_upload($inserted_invoice_id=false)
    {

        $where= array('order_id'=> $this->input->post('order_id') );
        $suborderId = $this->input->post('suborder_id');
        if(isset($suborderId) && !empty($suborderId)) {
            $where = array('order_id' => $suborderId);
        }
        $attachment_detail = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER,'attach_id',$where);

        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath('uploads').DIRECTORY_SEPARATOR.$financialYear. DIRECTORY_SEPARATOR .$inserted_invoice_id;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            ).DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory .'invoice_po'. DIRECTORY_SEPARATOR;
        if(!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();


        if($attachment_detail) { /*For existing File*/
            foreach($attachment_detail as $key => $attachment) {
                if (isset($_FILES['attachment']['name'][$attachment->attach_id]) && !empty($_FILES['attachment']['name'][$attachment->attach_id])) {
                    $fileObjName = 'attachment_upload'.$key;
                    $_FILES[$fileObjName]['name'] = $_FILES['attachment']['name'][$attachment->attach_id];
                    $_FILES[$fileObjName]['type'] = $_FILES['attachment']['type'][$attachment->attach_id];
                    $_FILES[$fileObjName]['tmp_name'] = $_FILES['attachment']['tmp_name'][$attachment->attach_id];
                    $_FILES[$fileObjName]['error'] = $_FILES['attachment']['error'][$attachment->attach_id];
                    $_FILES[$fileObjName]['size'] = $_FILES['attachment']['size'][$attachment->attach_id];
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
                        $uploadedFiles['existing'][$attachment->attach_id] = $this->upload->data();
                    } else {
                        //$uploadedFiles[] = array('error' => $this->upload->display_errors());
                    }
                }
            }

        }

        if(isset($_FILES['add_agreement_name']) && is_array($_FILES['add_agreement_name'])) {
            /*ADD MORE*/
            foreach($_FILES["add_agreement_name"]['name'] as $key => $file) {
                $fileObjName = 'attachmeent'.$key;
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


    private function multifiles_do_upload_invoice($inserted_invoice_id=false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath('uploads') . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . $inserted_invoice_id;
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . 'invoice_folder' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();


        if (isset($_FILES['attachment']) && is_array($_FILES['attachment'])) {
            /*ADD MORE*/

            //$filesCount = count($_FILES["add_agreement_name"]['name']);
            foreach ($_FILES["attachment"]['name'] as $key => $file) {
                $fileObjName = 'attachment' . $key;
                $_FILES[$fileObjName]['name'] = $_FILES['attachment']['name'][$key];
                $_FILES[$fileObjName]['type'] = $_FILES['attachment']['type'][$key];
                $_FILES[$fileObjName]['tmp_name'] = $_FILES['attachment']['tmp_name'][$key];
                $_FILES[$fileObjName]['error'] = $_FILES['attachment']['error'][$key];
                $_FILES[$fileObjName]['size'] = $_FILES['attachment']['size'][$key];

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
                    $uploadedFiles['new'][] = $this->upload->data();
                } else {
                    $uploadedFiles['new'][] = array('error' => $this->upload->display_errors());
                }
            }
        }
        return $uploadedFiles;
    }

    /*
     * create_invoice
     * URL - Invoice/create-invoice
     * Purpose - To create invoice by Originator
     * @Date -23/02/2018
     * @author - NJ
    */
    public function create_invoice()
    {
        $postData = $this->input->post();
        $currentUser = getCurrentUser();

        if ($postData) {
            $this->form_validation->set_rules('category_id', 'Category', 'required');
            if ($postData['category_id'] == TECHNOLOGYCAT || $postData['category_id'] == TECHNOLOGYINCCAT) {
                $this->form_validation->set_rules('order_id', 'Project Name', 'required');
                $this->form_validation->set_rules('po_detail', 'Invoice Description', 'required');
            } else {
                $this->form_validation->set_rules('comp_name', 'Project Name', 'required');
                $this->form_validation->set_rules('po_detail', 'PO/RO Details', 'required');
            }
            if ($postData['category_id'] == WIRELESSCAT || $postData['category_id'] == WIRELESSINCCAT) {
                $this->form_validation->set_rules('subcategory_id', 'Invoice Subcategory', 'required');
            }
            /*NO NEED To MAKE IT REQUIRED - DATE- 03-MAY-18 DHARMENDRA*/
            /*if ($postData['category_id'] == ADSALESCAT || $postData['category_id'] == ADSALESINCCAT) {
                $this->form_validation->set_rules('delivery_required', 'Delivery', 'required');
                $this->form_validation->set_rules('actual_delivered', 'Actual Delivered', 'required');
                $this->form_validation->set_rules('units', 'Unit', 'required');
            }*/
            $this->form_validation->set_rules('sales_person', 'WD Sales Person Name', 'required|trim');
            $this->form_validation->set_rules('manager_person', 'WD Manager Name', 'required|trim');
           if ($postData['category_id'] != TECHNOLOGYCAT && $postData['category_id'] != TECHNOLOGYINCCAT){

                $this->form_validation->set_rules('client_name', 'Client Name', 'required|trim');
                $this->form_validation->set_rules('postal_address', 'Postal Address ', 'required|trim');
                $this->form_validation->set_rules('manager_name', 'Manager Name', 'required|trim');
                $this->form_validation->set_rules('contact_number', 'Contact No.', 'required|trim');
                $this->form_validation->set_rules('email_id', 'EmailId ', 'required|trim');
                $this->form_validation->set_rules('pay_term', 'Payment Term', 'required|trim');
            }

            //$this->form_validation->set_rules('acc_person', 'Account Person  name', 'required|trim');
           // $this->form_validation->set_rules('contact_number1', 'Contact No', 'required|trim');
           // $this->form_validation->set_rules('email_id1', 'EmailId', 'required|trim');
            $this->form_validation->set_rules('inv_amount', 'Invoice Amount', 'required|trim');
            $this->form_validation->set_rules('currency', 'Currency', 'required|trim');
            //$this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');
            $this->form_validation->set_rules('po_detail', 'PO Details', 'required|trim');
            if (!isset($_POST['no_po']) && !empty($_POST['no_po'])) {

                $this->form_validation->set_rules('po_ro_number', 'PO/RO NO', 'required|trim');
                $this->form_validation->set_rules('po_ro_date', 'PO Date', 'required|trim');

            }

            if ($this->form_validation->run()) {

                $insert_data = array(
                    'category_id' => $this->input->post('category_id'),
                    'wd_sales_person_id' => $this->input->post('sales_person'),
                    'wd_manager_id' => $this->input->post('manager_person'),
                    'po_dtl' => $this->input->post('po_detail'),
                   // 'po_date' =>($this->input->post('po_ro_date') ? date('Y-m-d', strtotime($this->input->post('po_ro_date'))): NULL),
                   // 'payment_term' => $this->input->post('payment'),
                    'invoice_net_amount' => $this->input->post('inv_amount'),
                    'invoice_currency' => $this->input->post('currency'),
                    'attach_count' => count($this->input->post('client_agreement')),
                    'order_id' =>$this->input->post('order_id'),
                    'originator_user_id' => getCurrentUsersId(),
                    'invoice_originator_remarks' => $this->input->post('remarks'),
                    'invoice_originate_date' => date('Y-m-d'),
                    'invoice_originate_flag' => 'Y',
                    'invoice_acceptance_status' => 'Pending',
                    'invoice_description' => $this->input->post('po_detail')
              );


                if ($postData['category_id'] == TECHNOLOGYCAT || $postData['category_id'] == TECHNOLOGYINCCAT) {

                    $insert_data['payment_term'] = $this->input->post('payment');
                }
                else{
                    $insert_data['payment_term'] = $this->input->post('pay_term');
                   }


                if ($postData['category_id'] == TECHNOLOGYCAT || $postData['category_id'] == TECHNOLOGYINCCAT) {

                    //$insert_data['po_no'] =  $this->input->post('po_number');
                    $insert_data['po_no'] =  $this->input->post('po_ro_number');

                    if ($this->input->post('po_ro_number') == "") {
                        $insert_data['po_no'] = 'None';
                    }
                }
                else{
                    $insert_data['po_no'] =  $this->input->post('po_ro_number');

                    if ($this->input->post('po_ro_number') == "") {
                        $insert_data['po_no'] = 'None';
                    }
                }


                if ($postData['category_id'] == TECHNOLOGYCAT || $postData['category_id'] == TECHNOLOGYINCCAT) {

                    //$insert_data['po_date'] = date('Y-m-d', strtotime( $this->input->post('po_date')));
                    $insert_data['po_date'] =  date('Y-m-d', strtotime($this->input->post('po_ro_date')));

                    if ($this->input->post('po_ro_date') == "") {
                        $insert_data['po_date'] = NULL;
                    }
                }
                else{
                    $insert_data['po_date'] =  date('Y-m-d', strtotime($this->input->post('po_ro_date')));

                    if ($this->input->post('po_ro_date') == "") {
                        $insert_data['po_date'] = NULL;
                    }
                }


                if ($postData['category_id'] == TECHNOLOGYCAT || $postData['category_id'] == TECHNOLOGYINCCAT) {

                    $client_id = $this->input->post('client');
                    //$sales_id = $this->input->post('manager');
                    //$account_id = $this->input->post('account_person');
                    /*NOW Allowing user to changes manager and account person as they want- Pankaj Sir feedback- 08-May-2018 */
                    $sales_id = $this->input->post('manager_name');
                    $account_id = $this->input->post('acc_person');
                }
                else{

                    $client_id = $this->input->post('client_name');
                    $sales_id = $this->input->post('manager_name');
                    $account_id = $this->input->post('acc_person');
                }

                $insert_data['client_id'] = $client_id;
                $insert_data['sales_id'] = $sales_id;
                $insert_data['account_id'] = $account_id;


                    if($currentUser->is_approver) {
                    $insert_data['approval_user_id'] = $currentUser->approver_user_id;
                }
                if ($this->input->post('category_id') == ADSALESCAT ||$this->input->post('category_id') == ADSALESINCCAT) {
                    $insert_data['delivered_required'] =$this->input->post('delivery_required');
                    $insert_data['actual_delivered'] = $this->input->post('actual_delivered');
                    $insert_data['impression_unit'] = $this->input->post('units');
                }

                if ($this->input->post('category_id') == WIRELESSCAT ||$this->input->post('category_id') == WIRELESSINCCAT) {
                    $insert_data['sub_category_id'] =$this->input->post('subcategory_id');
                    if($this->input->post('wpc_status')=='YES')
                    {
                        $insert_data['wpc_status'] ='Y';
                    }
                    else{
                        $insert_data['wpc_status'] ="N";
                    }
                }
                else{
                    $insert_data['sub_category_id']='0';
                }
                if ($this->input->post('category_id') == TECHNOLOGYCAT ||$this->input->post('category_id') == TECHNOLOGYINCCAT)
                {
                    $where = array('order_id' => $this->input->post('order_id'));
                    $projectname = $this->common_model->getRecord(TBL_ORDER_MASTER, 'project_name', $where);
                    $insert_data['project_name'] = $projectname->project_name;

                }
                else{
                    $insert_data['project_name'] = $this->input->post('comp_name');
                }
                if (count($this->input->post('client_agreement')) != 0) {

                    $insert_data['attach_status'] = "Y";

                } else {
                    $insert_data['attach_status'] = "";
                }



                if ($this->input->post('invoice') == "checked"){
                    $insert_data['invoice_already_generated']  = 'Y';
                } else {
                    $insert_data['invoice_already_generated'] = 'N';
                }

                if (!$currentUser->is_approver) { /*Check if Your don't have any approver then it will default approved*/
                    $insert_data['approval_user_id'] = getCurrentUsersId();
                    $insert_data['approval_status'] = 'accept';
                    $insert_data['approval_date'] = date('Y-m-d H:i:s', now());
                }
                /*echo "<pre>";
                print_r($attachment_detail);die;*/
                $inserted_invoice_id = $this->common_model->insert(TBL_INVOICE_MASTER, $insert_data);
                $insert_data['invoice_req_id'] = $inserted_invoice_id;
                if($inserted_invoice_id) {
                    //Update schedule ID
                    $schedule_ids = $this->input->post("invoice_schedule_id");
                    if(count($schedule_ids)){
                        $updateData = array(
                            'schedule_id' => json_encode($schedule_ids),
                        );
                        $where = array('invoice_req_id' => $inserted_invoice_id);
                        $this->common_model->update(TBL_INVOICE_MASTER, $updateData, $where);
                        //Update schedule status
                        foreach($schedule_ids as $schId) {
                            $schUpdate = array('invoice_status' => 'I');
                            $where = array('schedule_id' => $schId);
                            $this->common_model->update(TBL_ORDER_INVOICE_SCHEDULE_MASTER, $schUpdate, $where);
                        }
                    }

                    $upload_data = $this->multifiles_do_upload($inserted_invoice_id);

                    /*Condition for inserting invoice attachments [technology/technlogyINC]*/

                 if($postData['category_id']==TECHNOLOGYCAT || $postData['category_id']==TECHNOLOGYINCCAT) {
                     $where = array('order_id' => $postData['order_id']);

                     if(isset($postData['suborder_id']) && !empty($postData['suborder_id'])) {
                         $where = array('order_id' => $postData['suborder_id']);
                     }
                     $attachment_detail = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('attach_id', 'attach_file_path', 'attach_file_name', 'attach_type'), $where);

                     if ($attachment_detail) {
                        $financialYear = getCurrentFinancialYear();
                         foreach ($attachment_detail as $key => $value) {

                             if (isset($upload_data['existing'][$value->attach_id])) {

                                 $insert_data = array(
                                     'invoice_req_id' => $inserted_invoice_id,
                                     'attach_file_path' => $upload_data['existing'][$value->attach_id]['file_path'],
                                     'attach_file_name' => $upload_data['existing'][$value->attach_id]['file_name'],
                                     'attach_type' => $postData['invoice_doc'][$value->attach_id],
                                     'role_name' => "Originator",
                                 );
                                 $this->common_model->insert(TBL_INVOICE_ATTACHMENTS, $insert_data);
                             } else {
                                 /*Only insert those record that come in post*/
                                 if(isset($postData['invoice_doc']) && array_key_exists($value->attach_id, $postData['invoice_doc'])) {
                                     $attach_file_path = rtrim($value->attach_file_path, '/');
                                     $source = $attach_file_path.DIRECTORY_SEPARATOR. $value->attach_file_name;
                                     $destination = str_replace('\\', '/',realpath('uploads') . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR .$inserted_invoice_id . DIRECTORY_SEPARATOR . 'invoice_po' . DIRECTORY_SEPARATOR);

                                     if (!is_dir($destination)) {
                                         if (!mkdir($destination, 0755, true)) {
                                             die('Failed to create upload directory...');
                                         }
                                     }
                                     $fullFilePath = $destination . $value->attach_file_name;
                                     copy($source, $fullFilePath);
                                     /*echo "inserted_invoice_id : ".$inserted_invoice_id."<br>";
                                     echo "source :".$source."<br>";
                                     echo "fullFilePath :".$fullFilePath."<br>";
                                     die;*/
                                     $insert_data = array(
                                         'invoice_req_id' => $inserted_invoice_id,
                                         'attach_file_path' => $destination,
                                         'attach_file_name' => $value->attach_file_name,
                                         'attach_type' => $postData['invoice_doc'][$value->attach_id],
                                         'role_name' => "Originator",
                                     );
                                     $this->common_model->insert(TBL_INVOICE_ATTACHMENTS, $insert_data);
                                 }
                             }
                         }
                     }
                 }

                    /*Condition for inserting invoice attachments [Other categories]*/
                    if(isset($postData['file-upload-input'])) {
                        /* Insert agreement  information.*/
                        $numFields = count($postData['file-upload-input']);

                        for ($i = 0; $i < $numFields; $i++) {

                            if (isset($upload_data['new'][$i]['file_name'])) {
                                $data = array(
                                    'invoice_req_id' => $inserted_invoice_id,
                                    'attach_type' => $postData['add_invoice_doc'][$i],
                                    'attach_file_path' => $upload_data['new'][$i]['file_path'],
                                    'attach_file_name' => $upload_data['new'][$i]['file_name'],
                                    'role_name' => "Originator",
                                );
                                $this->common_model->insert(TBL_INVOICE_ATTACHMENTS, $data);
                            }
                        }
                    }


                    /*Send Email notification to Admin*/
                    $subject = "IMS: New Invoice Request Pending For Approval";
                    $template = 'invoice-create-notification';
                    $invoice = (object)$insert_data;
                    $invoiceid = $invoice->invoice_req_id;
                    $invoiceDetails = $this->InvoiceModel->getInvoice($invoiceid);

                    $where = array('currency_id' => $postData['currency']);
                    $currency = $this->common_model->getRecord(TBL_CURRENCY_MASTER,array( 'currency_id','currency_name','currency_symbol'),$where);
                    $formattedAmount = $currency->currency_symbol . ' ' . formatAmount($postData['inv_amount']);

                    $salespersonDetails = getClientSalesPersonInfo($sales_id);
                    $accountPersonId = $account_id;
                    if(!empty($accountPersionId)) {
                        $accountpersonDetails = getClientAccountPersonInfo($accountPersonId);
                    } else {
                        $accountpersonDetails = null;
                    }
                    $clientDetails = getClientInfo($client_id);

                    $categoryId = $this->input->post('category_id');
                    $categoryRecord = getCategoryInfo($categoryId);

                    $userDetail = ucwords($currentUser->first_name . ' ' . $currentUser->last_name);

                    $requestBy = $currentUser->first_name . " " . $currentUser->last_name;
                    $requestEmail = $currentUser->email;

                    $to = null;
                    /*If user has Approver then will send an email to Approver*/
                    if ($currentUser->is_approver) {

                        $approverDetail = getApprover($currentUser->id);
                        $approverName = $approverDetail->first_name . " " . $approverDetail->last_name;

                        $templateData = array('edited' => 1, 'invoice' => $invoiceDetails,'formattedAmount' =>$formattedAmount, 'salespersonDetails' => $salespersonDetails, 'accountpersonDetails' => $accountpersonDetails, 'clientDetails' => $clientDetails, 'categoryRecord' => $categoryRecord, 'user' => $userDetail, 'requestBy' => $requestBy, 'requestEmail' => $requestEmail, 'approverName' => $approverName);

                          $to = $approverDetail->email;
                        EmailUtility::sendEmail($to, $subject, $template, $templateData, null, $requestEmail);
                        /*END EMAIL CODE*/
                        $this->session->set_flashdata('success', $this->lang->line('INVOICE_SUCCESS_APPROVER'));
                    }
                    else {
                        /* $where = array('category_id' => $this->input->post('category_id'));
                        $generatorId = $this->common_model->getRecord(TBL_INVOICE_CATEGORY_GEN_MAPPER, array('generator_user_id'), $where);
                        $generatorUserId = $generatorId->generator_user_id;
                        $where = array('id' =>$generatorUserId);
                        $generatorEmails = $this->common_model->getRecord(TBL_USER, array('email'), $where);
                       */
                        $subject1 = "IMS: New Invoice Request";
                        $approverName = 'Finance Team';
                        $templateData = array('edited' => 1, 'invoice' => $invoiceDetails,'formattedAmount' =>$formattedAmount, 'salespersonDetails' => $salespersonDetails, 'accountpersonDetails' => $accountpersonDetails, 'clientDetails' => $clientDetails, 'categoryRecord' => $categoryRecord, 'user' => $userDetail, 'requestBy' => $requestBy, 'requestEmail' => $requestEmail, 'approverName' => $approverName);
                        $generatorEmail = getGeneratorsEmailByCategory($this->input->post('category_id'));
                        if($generatorEmail) {
                            EmailUtility::sendEmail($generatorEmail, $subject1, $template, $templateData, null, $requestEmail);
                            /*END EMAIL CODE*/
                            $this->session->set_flashdata('success', $this->lang->line('INVOICE_SUCCESS_GENERATOR'));
                        } else {
                            $this->session->set_flashdata('error', "No generators is assign to category you choose");
                        }
                        redirect('invoice/raised-invoices');
                    }
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('INVOICE_ERROR'));
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $where = array('status' => 1,'parent_id' =>0,'is_service_category'=>0);
        $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id','category_name'), $where, 'category_name');
        $data = array('categories' => $categories);

        $where = array('status' => 1,'parent_id' => WIRELESSINCCAT );
        $subcategories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id','category_name'), $where, 'category_name');
        $data['subcategories'] = $subcategories;

        $impressionunits = $this->common_model->getRecords(TBL_IMPRESSION_UNITS_MASTER, array('id','unit_name'), array(), 'unit_name');
        $data['impressionunits'] = $impressionunits;

        $where = array('is_manager' => 1,'status' => 'A');
        $wdmanager = $this->common_model->getRecords(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data['wdmanager'] = $wdmanager;

        $where = array('is_sales_person' => 1,'status' => 'A');
        $wdsalesperson= $this->common_model->getRecords(TBL_USER, array('id','CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data['wdsalesperson'] = $wdsalesperson;

        $paymentterm= $this->common_model->getRecords(TBL_PAYMENT_TERMS_MASTER, array('id','name'));
        $data['paymentterm'] = $paymentterm;

        $currencyname = $this->common_model->getRecords(TBL_CURRENCY_MASTER,array( 'currency_id','currency_name'));
        $data['currencyname'] = $currencyname;

        $data['currentUserId'] = getCurrentUsersId();

        $this->template->set('title', 'Create Invoice');
        $this->template->load('default', 'contents', 'default/invoices/create_invoice',$data);
    }

     /*
     * To Get Manager Details
     * @purpose - To get ManagerInfo By ManagerId.
     * @Date -23/02/2018
     * @author - NJ
     */
    public function getManagerInfoByManagerName()
    {
        if($this->input->is_ajax_request()) {
            $salesId = $this->input->post('salesId');
            if($salesId) {

                $where = array('salesperson_id' => $salesId);
                $salespersonsdetails = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, array('salesperson_id','sales_person_name','sales_contact_no','sales_person_email','sales_person_address'), $where, 'sales_person_name');
                $data['salespersonsdetails'] = $salespersonsdetails;
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
     *  To Get Account Details
     * @purpose -To get AccountInfo By AccountId.
     * @Date -23/02/2018
     * @author - NJ
     */
    public function getAccountInfoByAccountName()
    {
        if($this->input->is_ajax_request()) {
            $accountId = $this->input->post('accountId');
            if($accountId) {
                $where = array('account_id' => $accountId);
                $accountpersonsdetails = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, array('account_id','account_person_name','account_contact_no','account_person_email'), $where, 'account_person_name');
                $data['accountpersonsdetails'] = $accountpersonsdetails;

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
   *  To Get Details By Category
   * @purpose - To Get Details By CategoryID.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function getInfoByCategory()
    {
        if($this->input->is_ajax_request()) {
            $categoryId = $this->input->post('categoryId');
            if($categoryId) {
                $where = array('is_main_order' =>'Y', 'order_category_id' => $categoryId);
                $project = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id','project_name'), $where, 'project_name');
                $data = array('projectname' => $project);
                $options = $this->load->view('default/orders/options_creator_projectname', $data, TRUE);
                $data['projectoptions'] = $options;

                $where = array('status' => 1, 'category_id' => $categoryId);
                $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER,array( 'client_id','client_name'), $where, 'client_name');
                $data['clientname'] = $clients;
                $options = $this->load->view('default/clients/options_creator', $data, TRUE);
                $data['clientnameoptions'] = $options;

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
   * To Get Details By Client
   * @purpose -To get Details By ClientId.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function getInfoByClient()
    {
        if($this->input->is_ajax_request()) {
            $client = $this->input->post('client');
            if($client) {

                $where = array('client_id' => $client);
                $agreementname = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, array('agreement_id','agreement_name'), $where);
                $data = array('agreementname' => $agreementname);
                $options = $this->load->view('default/orders/options_creator_agreementname', $data, TRUE);
                $data['agreementoptions'] = $options;


                $where = array('client_id' => $client);
                $clientaddress = $this->common_model->getRecords(TBL_CLIENT_MASTER,array('client_id','CONCAT(address1," ", IFNULL(address2, "") ) as address'), $where);
                $data['clientaddress'] = $clientaddress;

                $where = array('client_id' => $client);
                $clients = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON,array( 'salesperson_id','sales_person_name'), $where, 'sales_person_name');
                $data['managername'] = $clients;
                $options = $this->load->view('default/orders/options_creator_manager', $data, TRUE);
                $data['manageroptions'] = $options;

                $where = array('client_id' => $client);
                $clients = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON,array( 'account_id','account_person_name'), $where, 'account_person_name');
                $data['accountpersonname'] = $clients;
                $options = $this->load->view('default/orders/options_creator_account', $data, TRUE);
                $data['accountpersonoptions'] = $options;

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
   *  To Get Details By ProjectId
   * @purpose -To get Details By ProjectId.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function getDetailsByProjectName()
    {
        if($this->input->is_ajax_request()) {
            $projectDetails= $this->input->post('projectDetails');
            if($projectDetails) {
                $where = array('order_id' => $projectDetails);
                $projectinfo = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id','client_id','account_id','sales_id','project_type','po_no','DATE_FORMAT(po_date, "%d-%b-%Y") as po_date','po_dtl','wd_sales_person_id', 'wd_tech_head_id','project_description','invoice_originator_remarks','payment_term','initial_hours','efforts_unit','hourly_rate','hour_rate_currency', 'order_currency'), $where);
                $data = array('projectinfo' => $projectinfo);

                $where = array('client_id' => $projectinfo[0]->client_id);
                $clientinfo = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','client_name','CONCAT(address1,\', \', IFNULL(address2, "")) as address'), $where);
                $data['clientinfo'] = $clientinfo;

                $where = array('account_id' => $projectinfo[0]->account_id);
                $accountinfo = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, array('account_id','account_person_name','account_contact_no','account_person_email'), $where);
                $data['accountinfo'] = $accountinfo;

                $where = array('salesperson_id' => $projectinfo[0]->sales_id);
                $managerinfo = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, array('salesperson_id','sales_person_name','sales_contact_no',"sales_person_email"), $where);
                $data['managerinfo'] = $managerinfo;

                $where = array('order_id' => $projectDetails);
                $attachmentinfo = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('attach_id', 'attach_file_path','attach_file_name','attach_type'), $where);
                $data['attachmentinfo'] = $attachmentinfo;

                $where = array('order_id' => $projectDetails);
                $invoicescheduleinfo = $this->common_model->getRecords(TBL_ORDER_INVOICE_SCHEDULE_MASTER, array('DATE_FORMAT(invoice_date, "%d-%b-%Y") as invoice_date','invoice_amount','invoice_comment','schedule_id','status'), $where);
                $data['invoicescheduleinfo'] = $invoicescheduleinfo;


                $where = array('is_main_order' =>"N",'main_order_id' =>$projectDetails);
                $suborderinfo = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id','project_name'), $where, 'project_name');
                if(count($suborderinfo)>0) {
                    $data['suborderinfo'] = $suborderinfo;
                    $options = $this->load->view('default/invoices/options_creator_suborder', $data, TRUE);
                    $data['suborderoptions'] = $options;
                }
                else{
                    $data['suborderoptions'] = 0;
                }


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
    *  To Get Details By suborderId
    * @purpose -To get Details By suborderId.
    * @Date -23/02/2018
    * @author - NJ
    */
    public function getDetailsBySuborder()
    {
        if($this->input->is_ajax_request()) {
            $suborderDetails= $this->input->post('suborderDetails');
            if($suborderDetails) {

                $where = array('is_main_order' =>"N",'order_id' =>$suborderDetails);
                $suborderdetailedinfo = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id','project_type','po_no','DATE_FORMAT(po_date, "%d-%b-%Y") as po_date','po_dtl','wd_sales_person_id', 'wd_tech_head_id','project_description','invoice_originator_remarks','payment_term','initial_hours','efforts_unit','hourly_rate','hour_rate_currency', 'order_currency'), $where);
                $data = array('suborderdetailedinfo' => $suborderdetailedinfo);

                $where = array('order_id' => $suborderDetails);
                $attachmentinfo = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('attach_id', 'attach_file_path' ,'attach_file_name','attach_type'), $where);
                $data['attachmentinfo'] = $attachmentinfo;

                $where = array('order_id' => $suborderDetails);
                $invoicescheduleinfo = $this->common_model->getRecords(TBL_ORDER_INVOICE_SCHEDULE_MASTER, array('DATE_FORMAT(invoice_date, "%d-%b-%Y") as invoice_date','invoice_amount','invoice_comment','schedule_id'), $where);
                $data['invoicescheduleinfo'] = $invoicescheduleinfo;

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
    * raised_invoices.
    * URL - Invoice/raised-invoices
    * @purpose -To list All Raised Invoices in the system.
    * @Date -23/02/2018
    * @author - NJ
    */
    public function raised_invoices($selectedMonth = '')
    {
        $userDetail = getCurrentUser();
        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $invoice = $this->input->get('order[0][dir]');
            $clientId = (!empty($this->input->get('client_id'))) ? $this->input->get('client_id') : false;
            $status = (!empty($this->input->get('status_id'))) ? $this->input->get('status_id') : false;
            $month = (!empty($this->input->get('month'))) ? $this->input->get('month') : false;

            $name = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "client_name";
                    break;
                case 2 :
                    $orderColumn = "project_name";
                    break;
                case 3 :
                    $orderColumn = "po_no";
                    break;
                case 4 :
                    $orderColumn = "invoice_date";
                    break;
                case 5 :
                    $orderColumn = "invoice_originate_date";
                    break;
                case 6 :
                    $orderColumn = "name";
                    break;
                case 7 :
                    $orderColumn = "invoice_net_amount";
                    break;
                case 8:
                    $orderColumn = "invoice_acceptance_status";
                    break;
                default:
                    $orderColumn = "invoice_date";
            }

            $orderBY = $orderColumn . " " . $invoice;
            $invoiceList = $this->InvoiceModel->listInvoices($userDetail->id, $clientId, $status, $month, $name, $orderBY, $start, $length);
            $recordsTotal = $this->InvoiceModel->count_all($userDetail->id);
            $recordsFiltered = $this->InvoiceModel->count_filtered($userDetail->id, $clientId, $status, $month, $name, $orderBY);

            $draw = $this->input->get('draw');
            $data = array();
            if ($invoiceList) {
                $sNo = $start +1;
                foreach ($invoiceList as $key => $invoice) {

                    if (trim($invoice->invoice_date) == "") {
                        $invoiceDate = "--";
                    } else {
                        $invoiceDate = ($invoice->invoice_date ? date('d-M-Y', strtotime($invoice->invoice_date)) : '');
                    }

                    if (trim($invoice->invoice_originate_date)=="") {
                        $requestDate = "--";
                    } else {
                        $requestDate = ($invoice->invoice_originate_date ? date('d-M-Y', strtotime($invoice->invoice_originate_date)) : '');
                    }

                    if ($invoice->invoice_no == "") {
                        $invoiceno = '--';
                    } else {
                        $invoiceno = $invoice->invoice_no;
                    }
                    if ($invoice->invoice_req_id== "") {
                        $invoiceId= '--';
                    } else {
                        $invoiceId = $sNo;
                    }

                    if (trim($invoice->client_id) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $invoice->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $invoice->client_id . ">" . $clientName . "</a>";
                    }

                    if (trim($invoice->invoice_net_amount) == "") {
                        $invoiceAmount = "0.00";
                    } else {
                        $invoiceAmount = $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount);
                    }

                    $projectName = $invoice->project_name;
                    $pono = $invoice->po_no;

                    if ($invoice->invoice_acceptance_status == 'Pending' && $invoice->approval_status !='reject') {
                        $invoice_status = "Pending";
                    }else if ($invoice->invoice_acceptance_status == 'Accept') {
                        $invoice_status = "Invoiced";
                    } else {
                        $invoice_status = "Rejected";
                    }
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $invoice->invoice_req_id . " title='View'><i class='icon-view1'></i></a>";


                    $name = $invoice->name;

                    $tempData = array("invoice_req_id" => $sNo,
                        "client_name" => $clientName,
                        "project_name" => $projectName,
                        "po_no" => $pono,
                        "invoice_date" => $invoiceDate,
                        "request_date" => $requestDate,
                        "requestor_name" => $name,
                        "invoice_no" => $invoiceno,
                        "invoice_amount" => $invoiceAmount,
                        "invoice_status" => $invoice_status,
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

        if($selectedMonth) {
            $data['selectedMonth'] = $selectedMonth;
        }

        $where1 = array('status' => 1);
        $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','client_name'), $where1, 'client_name');
        $data['clients'] = $clients;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Invoice List');
        $this->template->load('default', 'contents', 'default/invoices/list', $data);
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
        $userInfo = getCurrentUser();
        $data['userRole'] = explode(',',$userInfo->role_id);
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
            $viewHtml = $this->load->view('default/invoices/pending_invoices_view',$data,true);
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

            $viewHtml = $this->load->view('default/invoices/generateinvoice_view',$data,true);
        }

       else if($type == 'collection') {

           $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id);
           $pymtdtl= $this->common_model->getRecords(TBL_INVOICE_MASTER, array('invoice_req_id','collector_user_id','payment_type','payment_recieved','invoice_collection_amount','payment_mode',"transaction_no",'payment_recieved_date','payment_recieved_remarks','payment_recieved_flag','invoice_close_date','invoice_closure_flag'), $where);
           $data['pymtdtl'] = $pymtdtl;

            $viewHtml = $this->load->view('default/collections/collection_view',$data,true);
        }

       else if($type == 'paymentDetail') {

           $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id);
           $pymtdtl= $this->common_model->getRecord(TBL_INVOICE_MASTER, array('invoice_req_id','collector_user_id','payment_type','payment_recieved','invoice_collection_amount','payment_mode',"transaction_no",'payment_recieved_date','payment_recieved_remarks','payment_recieved_flag','invoice_close_date','invoice_closure_flag'), $where);

           $data['pymtdtl'] = $pymtdtl;

           $viewHtml = $this->load->view('default/collections/payment_info',$data,true);
       }

        else{
            $viewHtml = $this->load->view('default/invoices/view', $data, true);
        }

        echo $viewHtml;
    }

    /* pending_invoices
     * URL /invoice/pending-invoices
     * Purpose - To get all pending invoice for user those are pending in account department
     * @Date -23/02/2018
     * @author - NJ
     * */
    public function pending_invoices()
    {
        $userDetail = getCurrentUser();
        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $searchKey = $this->input->get('search[value]');
            $status_id = $this->input->get('status_id');
            $client_id = $this->input->get('client_id');
            $month = $this->input->get('month');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "invoice_originate_date";
                    break;
                case 2 :
                    $orderColumn = "client_name";
                    break;
                case 3 :
                    $orderColumn = "project_name";
                    break;
                case 4 :
                    $orderColumn = "invoice_net_amount";
                    break;
                case 5 :
                    $orderColumn = "po_no";
                    break;

                default:
                    $orderColumn = "invoice_originate_date";
            }

            $orderBY = $orderColumn . " " . $direction;
            $groupBy='invoice_currency';
            /*Get Pending invoices only for Originator and Manager*/
            $invoiceList = $this->InvoiceModel->latestPendingInvoices($userDetail->id, $client_id, $status_id, $month,  $searchKey,$orderBY, $start, $length);
            $recordsTotal = $this->InvoiceModel->count_all($userDetail->id, 'pendingInvoice');
            $recordsFiltered = $this->InvoiceModel->latestPendingInvoices($userDetail->id, $client_id, $status_id, $month,  $searchKey,$orderBY, $start, $length, true);
            $suminvoiceList = $this->InvoiceModel->sumlatestPendingInvoices($userDetail->id,$groupBy, $start, $length);

            $draw = $this->input->get('draw');
            $data = array();
            $totalAmount='';
            if ($invoiceList) {
                foreach ($invoiceList as $invoice) {

                    if (trim($invoice->invoice_originate_date)=="") {
                        $requestDate = "--";
                    } else {
                        $requestDate = ($invoice->invoice_originate_date ? date('d-M-Y', strtotime($invoice->invoice_originate_date)) : '');
                    }

                    if (trim($invoice->client_id) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $invoice->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $invoice->client_id . ">" . $clientName . "</a>";
                    }

                    if (trim($invoice->invoice_net_amount) == "") {
                        $invoiceAmount = "0.00";
                    } else {
                        $invoiceAmount = $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount);
                    }

                    $projectName = $invoice->project_name;
                    $pono = $invoice->po_no;
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ViewModal\" data-toggle=\"modal\" data-target-id=" . $invoice->invoice_req_id . " title='View'><i class='icon-view1'></i></a>";

                    $tempData = array(
                        "request_date" => $requestDate,
                        "client_name" => $clientName,
                        "project_name" => $projectName,
                        "invoice_amount" => $invoiceAmount,
                        "po_no" => $pono,
                        "invoice_status" => $actionLink,
                    );
                    $data[] = $tempData;
                }
                //$toEnd = count($suminvoiceList);

                foreach($suminvoiceList as $invoice)
                {
                $totalAmount.=  $invoice->currency_symbol . ' ' . formatAmount($invoice->sum).'&nbsp;';
                    $totalAmount .= "+";

                }

            }
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data,
                "totalAmt"=>  rtrim($totalAmount,'+')
            );
            echo json_encode($response);
            exit;
        }
        $data = array();
        $where = array('status' => 1);
        $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','client_name'), $where, 'client_name');
        $data['clients'] = $clients;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Invoice List');
        $this->template->load('default', 'contents', 'default/invoices/pending_invoices_list', $data);

    }

    /*
     * invoiceAcceptance
     * Purpose - To Accept OR Reject Invoice by approver.
     * @Date -23/02/2018
     * @author - NJ
     */
    public function invoiceAcceptance()
    {
        if ($this->input->is_ajax_request()) {
            $status = $this->input->post('status');
            $comment = $this->input->post('comment');
            $id = $this->input->post('Id');
            $invoiceDetails = $this->InvoiceModel->getInvoice($id);
            if ($id && $comment != '' && $invoiceDetails) {
                if ($status == 'accept') {
                    $acceptancestatus = array(
                        'approval_user_id' => getCurrentUsersId(),
                        'approval_status' => $status,
                        'approval_date' => date('Y-m-d H:i:s', now()),
                        'approval_comment' => $comment,
                        'invoice_approver_date' => date('Y-m-d H:i:s', now()),
                        'invoice_approver_flag' => 'Y'
                    );
                    $message = "The Invoice Request Approved by you has been forwarded to the Accounts Department";
                } else {
                    $acceptancestatus = array(
                        'approval_user_id' => getCurrentUsersId(),
                        'approval_status' => $status,
                        'approval_date' => date('Y-m-d H:i:s', now()),
                        'approval_comment' => $comment,
                        'invoice_approver_date' => date('Y-m-d H:i:s', now()),
                        'invoice_approver_flag' => 'N'
                    );
                    $message = "The Invoice Request Rejected by you has intimated to " . $invoiceDetails->requestorname;
                }

                $where = array('invoice_req_id' => $id);
                $this->common_model->update(TBL_INVOICE_MASTER, $acceptancestatus, $where);
                //Send Email to respective User about approvar action
                if ($status == "reject") { /*Send Email to Originator*/

                    $subject = "IMS: Invoice Rejected";
                    $template = 'invoice-rejected-notification';
                    $originator = getUserInfo($invoiceDetails->originator_user_id);
                    $approver = getCurrentUser();
                    $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                    if (is_object($originator)) {
                        $toEmail = $originator->email;
                        //$toEmail = 'dharmendra.thakur@webdunia.net';
                        $templateData = array('invoice' => $invoiceDetails,
                            'user' => $originator->first_name . ' ' . $originator->last_name,
                            'rejectedBy' => $approver->first_name . ' ' . $approver->last_name,
                            'comment' => $comment
                        );
                        EmailUtility::sendEmail($toEmail, $subject, $template, $templateData);
                    }
                } else {

                    $subject1 = "IMS: New Invoice Request";
                    $template = 'invoice-create-notification';
                    $salespersonDetails = getClientSalesPersonInfo($invoiceDetails->sales_id);
                    $accountpersonDetails = getClientAccountPersonInfo($invoiceDetails->account_id);
                    $clientDetails = getClientInfo($invoiceDetails->client_id);
                    $categoryRecord = getCategoryInfo($invoiceDetails->category_id);
                    $originator = getUserInfo($invoiceDetails->originator_user_id);
                    $userDetail = ucwords($originator->first_name . ' ' . $originator->last_name) . '( ' . $originator->email . ' )';
                    $requestBy = $originator->first_name . " " . $originator->last_name;
                    $requestEmail = $originator->email;
                    $formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                    $approverName = 'Finance Team';

                    $templateData = array('invoice' => $invoiceDetails,
                        'formattedAmount' => $formattedAmount,
                        'salespersonDetails' => $salespersonDetails,
                        'accountpersonDetails' => $accountpersonDetails,
                        'clientDetails' => $clientDetails,
                        'categoryRecord' => $categoryRecord,
                        'user' => $userDetail,
                        'requestBy' => $requestBy,
                        'requestEmail' => $requestEmail,
                        'approverName' => $approverName
                    );
                    $generatorEmail = getGeneratorsEmailByCategory($invoiceDetails->category_id);
                    if ($generatorEmail) {
                        EmailUtility::sendEmail($generatorEmail, $subject1, $template, $templateData, null, $requestEmail);
                    }
                }
                $response = array('isSuccess' => 1, 'message' => $message); // msg would be change based on action
            } else {
                $response = array('isError' => 1, 'message' => 'Error while updating invoice status. Please try again');
            }
            echo json_encode($response);
            die;
        }
    }

    /*
   * generate_invoice.
   * @purpose -To Get Generate Invoices List.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function generates()
    {

        $userDetail = getCurrentUser();
        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $invoice = $this->input->get('order[0][dir]');

            $name = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "invoice_originate_date";
                    break;
               case 2 :
                    $orderColumn = "originator_user_id";
                    break;
                case 3 :
                    $orderColumn = "category_id";
                    break;
                case 4 :
                    $orderColumn = "client_id";
                    break;
                case 5 :
                    $orderColumn = "po_no";
                    break;
                default:
                    $orderColumn = "invoice_originate_date";
            }
            $where = array('approver_user_id' =>$userDetail->id);
            $id = $this->common_model->getRecords(TBL_USER, array('id'), $where);

            $orderBY = $orderColumn . " " . $invoice;
            $invoiceList = $this->InvoiceModel->listInvoices_generateInvoice($userDetail->id, $name,$id, $orderBY, $start, $length);
            $recordsTotal = $this->InvoiceModel->count_all_generateInvoice($userDetail->id);
            $recordsFiltered = $this->InvoiceModel->count_filtered_generateInvoice($userDetail->id,$name, $orderBY);

            $draw = $this->input->get('draw');
            $data = array();
            if ($invoiceList) {
                foreach ($invoiceList as $invoice) {
                    if (trim($invoice->invoice_originate_date)=="") {
                        $requestDate = "--";
                    } else {
                        $requestDate = ($invoice->invoice_originate_date ? date('d-M-Y', strtotime($invoice->invoice_originate_date)) : '');
                    }
                    if ($invoice->originator_user_id == "") {
                        $requestedBy= '--';
                    } else {
                        $requestedBy = $invoice->name;
                    }

                    if ($invoice->category_id == "") {
                        $category = '--';
                    } else {
                        $category = $invoice->category_name;
                    }
                    if (trim($invoice->client_id) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $invoice->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $invoice->client_id . ">" . $clientName . "</a>";
                    }
                    $pono = $invoice->po_no;
                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#ViewModal\" data-toggle=\"modal\" data-target-id=" . $invoice->invoice_req_id . " title='View'><i class='icon-view1'></i></a>";
                    //$encryptId = $this->encrypt->encode($invoice->invoice_req_id);
                    $encryptId = $invoice->invoice_req_id;//base64_encode($invoice->invoice_req_id);
                    $actionLink .= "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."invoice/generate-invoice/".$encryptId."' title='Generate Invoice'><i class='icon-generate_invoice'></i></a>";

                    $tempData = array(
                        "request_date" => $requestDate,
                        "requested_by" => "$requestedBy",
                        "category" => $category,
                        "Client_name" => $clientName,
                        "po_no" => $pono,
                        "action" => $actionLink,
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

        /*Checking whether current month Conversion added or not*/
        $currentMonth = date('Y-m-01');
        $currentMonthConversion = getCurrentCurrencyRates();
        $data['currentMonth'] = $currentMonth;
        $data['currentMonthConversion'] = $currentMonthConversion;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Invoice List');
        $this->template->load('default', 'contents', 'default/invoices/generateinvoice_list', $data);
    }

    /*
    * generate
    * URL - invoice/generate_invoice
    * Date - 02-02-2018
    */
    public function generate_invoice($encrptInvoiceId = '')
    {
        $userInfo = getCurrentUser();
        $currentMonth = date('Y-m-01');
        $currentMonthConversion = getCurrentCurrencyRates();
        if(count($currentMonthConversion) < 1) {
            $warning = "Please add Currency Conversion for <strong>".date('M-Y', strtotime($currentMonth))."</strong> before generate invoice.";
            $this->session->set_flashdata('error', $warning);
            redirect('currency');
        }
        if ($encrptInvoiceId == '') {
            $this->session->set_flashdata('error', "Missing invoice ID");
            redirect('dashboard');
        }

        $data = array(
            'invoiceEncrptid' => $encrptInvoiceId
        );
        $userDetail = getCurrentUser();
        $invoiceId = $encrptInvoiceId;// base64_decode($encrptInvoiceId);
        if ($invoiceId) {
            $invoiceDetail = $this->InvoiceModel->getInvoice($invoiceId);
            //var_dump($invoiceDetail);die;
            if ($invoiceDetail) {
                $postData = $this->input->post();
                $currentUser = getCurrentUser();
                $approver_user = getApprovalID($currentUser->id);
                $id = $this->input->post('Id');
                $invoiceDetails = $this->InvoiceModel->getInvoice($id);
                if ($postData) {
                    $cmp_id = explode("^##^", $this->input->post('cmp')) [0];
                    if ($cmp_id == 1) {
                        $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim');
                        $this->form_validation->set_rules('invoice_cat_abr', 'Invoice Category', 'required|trim');
                        $this->form_validation->set_rules('invoice_year', 'Invoice Year', 'required|trim');
                    }
                    else {
                        $this->form_validation->set_rules('invoice_no1', 'Invoice Number', 'required|trim');
                        $this->form_validation->set_rules('invoice_cat_abr1', 'Invoice Category', 'required|trim');
                        $this->form_validation->set_rules('invoice_year1', 'Invoice Year', 'required|trim');
                    }

                    $this->form_validation->set_rules('service_category', 'Service Category', 'required|trim');
                    $this->form_validation->set_rules('invoice_gen_comments', 'Generator Comments', 'required|trim');
                    $this->form_validation->set_rules('project_title', 'Project Title', 'required|trim');
                    $this->form_validation->set_rules('payment_due_date', 'Payment Due Date', 'required|trim');
                    $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
                    if ($this->form_validation->run()) {

                        $tax_count = $this->input->post('taxcount');
                        $invoice_date =($this->input->post('invoice_date') ? date('Y-m-d', strtotime($this->input->post('invoice_date'))) : '');
                        $service_category = ($this->input->post('service_category')?$this->input->post('service_category'):'');
                        $gst_no = ($this->input->post('gst_no')?$this->input->post('gst_no'):'');
                        $state = ($this->input->post('state')?$this->input->post('state'):'');
                        $city =  ($this->input->post('city')?$this->input->post('city'):'');
                        $client_name = ($this->input->post('client_name')?$this->input->post('client_name'):'');
                        $client_address = ($this->input->post('client_addr')?$this->input->post('client_addr'):'');
                        $salesperson_id = ($this->input->post('wd_sales_id')?$this->input->post('wd_sales_id'):'');
                        $project_title = ($this->input->post('project_title')?$this->input->post('project_title'):'');
                        $po_no = ($this->input->post('po_no')?$this->input->post('po_no'):'');
                        $po_date =(($this->input->post('po_date') && $this->input->post('po_date') != '--') ? date('Y-m-d', strtotime($this->input->post('po_date'))) : '');
                        $category_id = ($this->input->post('category_id')?$this->input->post('category_id'):'');
                        $paymentterm = ($this->input->post('payment_term')?$this->input->post('payment_term'):'');
                        $po_curr = ($this->input->post('po_curr')?$this->input->post('po_curr'):'');
                        $grossamt = ($this->input->post('grossamt')?$this->input->post('grossamt'):'');
                        $invoice_gen_comments = ($this->input->post('invoice_gen_comments')?$this->input->post('invoice_gen_comments'):'');
                        $net_amt = ($this->input->post('net_amt')?$this->input->post('net_amt'):'');
                        $bankDetails = ($this->input->post('bank_details')?$this->input->post('bank_details'):'');
                        $total_tax = ($this->input->post('total_tax')?$this->input->post('total_tax'):'');
                        $total_taxamt = ($this->input->post('total_taxamt')?$this->input->post('total_taxamt'):'');
                        $invoice_id = ($this->input->post('invoice_id')?$this->input->post('invoice_id'):'');
                        $payment_due_date = ($this->input->post('payment_due_date') ? date('Y-m-d', strtotime($this->input->post('payment_due_date'))) : '');
                        $conversion_rate = ($this->input->post('conversion_rate')?$this->input->post('conversion_rate'):'');
                        $bank_details = ($this->input->post('bank_details')?$this->input->post('bank_details'):'');
                        $currncytype = ($this->input->post('currency')?$this->input->post('currency'):'');
                        $country_id = ($this->input->post('country_id')?$this->input->post('country_id'):'');

                        $where = array(
                            'invoice_req_id' => $invoiceId
                        );

                        if ($cmp_id == 1) {
                            $invoiceno = $this->input->post('invoice_no') . '/' . $this->input->post('invoice_cat_abr') . '/' . $this->input->post('invoice_year');
                            $display_date = explode ( "-", $invoice_date );
                            $invoiceDisplayDate = date ( "d-M-Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                        }
                        else {
                            $invoiceno = $this->input->post('invoice_year1') . '/' . $this->input->post('invoice_cat_abr1') . '/' . $this->input->post('invoice_cat_abr2') . '/' . $this->input->post('invoice_no1');
                            $display_date = explode ( "-", $invoice_date );
                            $invoiceDisplayDate = date ( "m/d/Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                        }
                        $po_date1 = '';
                        if ($category_id == WIRELESSCAT || $category_id == TECHNOLOGYCAT) {
                            $po_date1 = $po_date;
                        } else {
                            $podate = explode ( "-", $po_date );
                            $po_date1 = $podate [2] . "-" . $podate [1] . "-" . $podate [0];
                            if ($podate [2] == "" && $podate [1] == "")
                                $po_date1 = $podate [0];
                        }

                        if($po_date1) {
                            $poDisplayDate = date ( 'd-M-Y', strtotime ($po_date1));
                        } else {
                            $poDisplayDate = '--';
                        }

                        $approver = 'N';
                        if(isApprover($userInfo->id)) {
                            $approver = 'Y';
                        }

                        $companyId = $this->input->post('cmp');
                        $company = explode("^", $companyId);
                        $update_data = array(
                            'gen_approval_userid' => $approver_user->approver_user_id,
                            'generator_user_id' => $currentUser->id,
                            'project_name' => $project_title ,
                            'billing_date' => $po_date ,
                            'invoice_no' => $invoiceno,
                            'invoice_date' => $invoice_date ,
                            'invoice_generate_date' => date('Y-m-d H:i:s', now()) ,
                            'invoice_generator_comments' => $invoice_gen_comments ,
                            'payment_due_date' => $payment_due_date ,
                            'conversion_rate' => $conversion_rate ,
                            'company_id' => $cmp_id,
                            'service_category' => $service_category ,
                            'bank_detail' => $bank_details ,
                            'taxation' => $total_tax ,
                            'currncytype' => $currncytype ,
                            'invoice_acceptance_flag' => 'Y',
                            'invoice_acceptance_status' => 'Accept',
                            'invoice_gross_amount' => $grossamt ,
                        );

                        if($approver == 'Y'){
                            $update_data['gen_approval_status'] = 'Accept';
                            $update_data['gen_approval_comment'] = $invoice_gen_comments;
                        }
                        $this->common_model->update(TBL_INVOICE_MASTER, $update_data, $where);
                        /*below arrays are for pdf and html generation*/
                        $taxdtl = array();
                        $tax = array();
                        $taxamt = array();
                        $includestatus = array();
                        for ($i = 1; $i <= ($tax_count - 1); $i++) {
                            if($cmp_id == 1){
                            $taxdtl[] = $this->input->post('taxdtl' . $i);
                            $tax[] = $this->input->post('tax' . $i);
                            $taxamt[] = $this->input->post('taxamt' . $i);
                            $includestatus[] = $this->input->post('includestatus' . $i);
                            }

                            $insert_data = array(
                                'invoice_req_id' => $invoiceId,
                                'tax_label' => $this->input->post('taxdtl' . $i) ,
                                'tax' => ($this->input->post('tax' . $i) ? $this->input->post('tax' . $i) : 0) ,
                                'tax_amount' => ($this->input->post('taxamt' . $i) ? $this->input->post('taxamt' . $i) : 0) ,
                                'includestatus' => ($this->input->post('includestatus' . $i))?$this->input->post('includestatus' . $i):'N'
                            );
                            $this->common_model->insert(TBL_INVOICE_REQTAX_MASTER, $insert_data);
                        }

                        $insert_data = array(
                            'invoice_req_id' => $invoiceId,
                            'tax_label' => 'Total Tax (%)',
                            'tax' => ($this->input->post('total_tax') ? $this->input->post('total_tax') : 0) ,
                            'tax_amount' => ($this->input->post('total_taxamt') ? $this->input->post('total_taxamt') : 0) ,
                        );
                        $this->common_model->insert(TBL_INVOICE_REQTAX_MASTER, $insert_data);


                        $upload_data = $this->multifiles_do_upload_invoice($invoiceId);
                        if (isset($postData['file-upload-input'])) {
                            /*Insert agreement  information. */
                            $numFields = count($postData['file-upload-input']);
                            for ($i = 0; $i < $numFields; $i++) {

                                if (isset($upload_data['new']) && isset($upload_data['new'][$i]) && isset($upload_data['new'][$i]['file_name']) && !empty($upload_data['new'][$i]['file_name'])) {
                                    $invoiceattachments = array(
                                        'invoice_req_id' => $invoiceId,
                                        'attach_file_name' => $upload_data['new'][$i]['file_name'],
                                        'attach_file_path' => $upload_data['new'][$i]['file_path'],
                                        //'attach_type' => $this->input->post('invoice_doc[]')[$i],
                                        'role_name' => 'Generator'
                                    );
                                    $this->common_model->insert(TBL_INVOICE_ATTACHMENTS, $invoiceattachments);
                                }

                            }
                        }

                        $where = array('company_id' => $cmp_id);

                        $cmp_details = $this->common_model->getRecord(TBL_COMPANY_MASTER,array('company_name','company_address','company_contact','company_fax','company_short_code','invoice_footer_text','gst_no','sac_code','pan_no'),$where);

                        /*get service details*/

                        $where = array('id'=>$service_category,
                                       'is_service_category'=>1);
                        $service_category = $this->common_model->getRecord(TBL_CATEGORY_MASTER,array('category_name'),$where);

                        /*get salespersondetails*/

                        $where = array('id'=>$salesperson_id,
                                        'is_sales_person'=>1);
                        $salesPerson = $this->common_model->getRecord(TBL_USER,array('CONCAT(first_name,\' \', last_name) as name'),$where);

                        /*get payment term*/
                        $where =  array('id'=>$paymentterm);
                        $paymentTermDuration = $this->common_model->getRecord(TBL_PAYMENT_TERMS_MASTER,array('name'),$where);

                        $cheque_amt = convert_to_word($grossamt,$po_curr);

                        $data_inv = array('cmp_details'=>$cmp_details,
                                       'display_date' => $invoiceDisplayDate,
                                       'invoice_no' => $invoiceno,
                                       'company_id' => $cmp_id,
                                       'service_category' => $service_category->category_name,
                                       'gst_no' => $gst_no,
                                       'state' => $state,
                                       'city' =>$city,
                                       'client_name'=>$client_name,
                                       'client_address'=>$client_address,
                                       'sales_person'=>$salesPerson->name,
                                       'project_title'=>$project_title,
                                       'po_date'=>$poDisplayDate,
                                       'paymentTermDuration'=>$paymentTermDuration->name,
                                       'po_curr'=>$po_curr,
                                       'grossamt'=>$grossamt,
                                       'invoice_gen_comments'=>$invoice_gen_comments,
                                       'net_amt'=>$net_amt,
                                       'taxamt'=>$taxamt,
                                       'taxdtl'=>$taxdtl,
                                       'includestatus'=>$includestatus,
                                       'total_tax'=>$total_tax,
                                       'total_taxamt'=>$total_taxamt,
                                       'tax_count'=>$tax_count,
                                       'tax'=>$tax,
                                       'po_no'=>$po_no,
                                       'bank_details'=>$bank_details,
                                       'cheque_amt'=>$cheque_amt,
                                       'country_id'=>$country_id,
                                       'approver'=> $approver
                                       );

                        $html = $this->load->view('default/dashboard/invoice', $data_inv, true);
                        $addedPath = create_invoice_folder_html($html,$invoice_id,$cmp_details->company_short_code,$invoiceno,true);

                        $where = array(
                            'invoice_req_id' => $invoiceId
                        );
                        $updateData = array('invoice_path'=>$addedPath);
                        $this->common_model->update(TBL_INVOICE_MASTER, $updateData, $where);


                        $subject = "IMS : Invoice Accepted & Generated";
                        $template = 'invoice-acceptedByGenerator-notification';
                        $originator = getUserInfo($invoiceDetails->originator_user_id);
                        $generatorDetail = getUserInfo($currentUser->id);
                        $generatorName = $generatorDetail->first_name . " " . $generatorDetail->last_name;
                        $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                        if (is_object($originator)) {

                            $toEmail = $originator->email;

                            //$toEmail = 'nishi.jain@webdunia.net';
                            $templateData = array(
                                'invoice' => $invoiceDetails,
                                'user' => $originator->first_name . ' ' . $originator->last_name,
                                'acceptedBy' => $generatorName,
                            );
                            $cc = null;
                            if (hasApprover($invoiceDetails->originator_user_id)) {
                                $approverDetail = getApprover($invoiceDetails->originator_user_id);
                                $cc = $approverDetail->email;
                            }

                            EmailUtility::sendEmail($toEmail, $subject, $template, $templateData, null, $cc);
                        }
                        if($approver == 'Y') {
                            $this->session->set_flashdata('success', "Invoice is successfully generated.");
                        } else {
                            $this->session->set_flashdata('success', "Invoice is successfully Accepted and Forwarded to Account Manager for Approval.");
                        }

                        redirect('/invoice/generates');
                    }
                    else {
                        $this->session->set_flashdata('error', validation_errors());
                    }
                } /*end if postdata*/
                $data['invoiceDetail'] = $invoiceDetail;
                if (hasApprover($invoiceDetail->originator_user_id)) {
                    $approverDetail = getApprover($invoiceDetail->originator_user_id);
                    $approverName = $approverDetail->first_name . " " . $approverDetail->last_name;
                    $data['approverName'] = $approverName;
                }

                if ($invoiceDetail->generator_user_id) {
                    $generatorDetail = getUserInfo($invoiceDetail->generator_user_id);
                    $generatorName = $generatorDetail->first_name . " " . $generatorDetail->last_name;
                    $data['generatorName'] = $generatorName;
                }

                $where = array(
                    'invoice_req_id' => $invoiceId
                );
                $invoiceAttachments = $this->common_model->getRecords(TBL_INVOICE_ATTACHMENTS, array(
                    'invoice_req_id',
                    'attach_file_name',
                    'attach_file_path',
                    'attach_type'
                ) , $where);
                $data['invoiceAttachments'] = $invoiceAttachments;
                $where = array(
                    'is_sales_person' => 1
                );
                $wdsalesperson = $this->common_model->getRecords(TBL_USER, array(
                    'id',
                    'CONCAT(first_name,\' \', last_name) as name'
                ) , $where, 'name');
                $data['wdsalesperson'] = $wdsalesperson;
                $where = array(
                    'salesperson_id' => $invoiceDetail->sales_id
                );
                $salesPerson = $this->common_model->getRecord(TBL_CLIENT_SALESPERSON, array(
                    'sales_person_name',
                    'sales_contact_no',
                    'sales_person_email'
                ) , $where);
                $data['salesPerson'] = $salesPerson;
                $where = array(
                    'account_id' => $invoiceDetail->account_id
                );
                $accountPerson = $this->common_model->getRecord(TBL_CLIENT_ACCOUNTPERSON, array(
                    'account_person_name',
                    'account_contact_no',
                    'account_person_email'
                ) , $where);
                $data['accountPerson'] = $accountPerson;
                $paymentterm = $this->common_model->getRecords(TBL_PAYMENT_TERMS_MASTER, array(
                    'id',
                    'name'
                ));
                $data['paymentterm'] = $paymentterm;
                if ($invoiceDetail->category_id == ADSALESCAT || $invoiceDetail->category_id == ADSALESINCCAT) {
                    $impressionunit = $invoiceDetail->impression_unit;
                    $where = array(
                        'id' => $impressionunit
                    );
                    $unit = $this->common_model->getRecord(TBL_IMPRESSION_UNITS_MASTER, array(
                        'unit_name'
                    ) , $where);
                    $data['unit'] = $unit;
                }

                $where = array(
                    'id' => $invoiceDetail->country
                );
                $country = $this->common_model->getRecord(TBL_COUNTRY_MASTER, array(
                    'country_name'
                ) , $where);
                $data['country'] = $country;
                $where = array(
                    'id' => $invoiceDetail->state
                );
                $state = $this->common_model->getRecord(TBL_STATE_MASTER, array(
                    'state_name'
                ) , $where);
                $data['state'] = $state;
                $where = array(
                    'is_service_category' => 1
                );
                $servicesubcategories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array(
                    'id',
                    'category_name'
                ) , $where, 'category_name');
                $data['servicesubcategories'] = $servicesubcategories;
                $where = array(
                    'is_active' => 'Y'
                );
                $companylist = $this->common_model->getRecords(TBL_COMPANY_MASTER, array(
                    '*'
                ) , $where);
                $data['companylist'] = $companylist;
                $where = array(
                    'company_id=' => 1
                );
                $companyBankDetails = $this->common_model->getRecords(TBL_COMPANY_BANK_DETAILS_MASTER, array(
                    'id',
                    'currency'
                ) , $where);
                $data['companyBankDetails'] = $companyBankDetails;
            }
            else {
                $this->session->set_flashdata('error', "Invoice Not found");
                redirect('dashboard');
            }
        }
        else {
            $this->session->set_flashdata('error', "Missing invoice ID!!");
            redirect('dashboard');
        }

        /*Set currency conversion Array*/
        if($currentMonthConversion) {
            $data['currentMonthConversion'] = $currentMonthConversion;
        }

        /*Get financial start month*/
        $startMonthTexual = getConfiguration('financial_year_start_month');
        $financial_year_start_month = date('n', strtotime($startMonthTexual));
        $data['financial_year_start_month'] = $financial_year_start_month;

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Generate Invoice');
        $this->template->load('default', 'contents', 'default/invoices/generate_invoice', $data);
    }



     public function invoice_approval($id='') {

         $invoiceDetail = $this->InvoiceModel->getInvoice($id);
             $data = array('invoiceDetail'=> $invoiceDetail);
         if($invoiceDetail) {
             if (hasApprover($invoiceDetail->originator_user_id)) {
                 $approverDetail = getApprover($invoiceDetail->originator_user_id);
                 $approverName = $approverDetail->first_name . " " . $approverDetail->last_name;
                 $data['approverName'] = $approverName;
             }

             if ($invoiceDetail->generator_user_id) {
                 $generatorDetail = getUserInfo($invoiceDetail->generator_user_id);
                 $generatorName = $generatorDetail->first_name . " " . $generatorDetail->last_name;
                 $data['generatorName'] = $generatorName;
             }

             $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id,'role_name'=>'Originator');
             $invoiceAttachments = $this->common_model->getRecords(TBL_INVOICE_ATTACHMENTS, array('invoice_req_id', 'attach_file_name','attach_file_path', 'attach_type'), $where);
             $data['invoiceAttachments'] = $invoiceAttachments;

             $where = array('invoice_req_id' => $invoiceDetail->invoice_req_id ,'role_name'=>'Generator');
             $invoiceAttach = $this->common_model->getRecords(TBL_INVOICE_ATTACHMENTS, array('invoice_req_id', 'attach_file_name','attach_file_path'), $where);
             $data['invoiceAttach'] = $invoiceAttach;


             $wdsalesperson = $this->common_model->getRecords(TBL_USER, array('id', 'CONCAT(first_name,\' \', last_name) as name'));
             $data['wdsalesperson'] = $wdsalesperson;

             $where = array('salesperson_id' => $invoiceDetail->sales_id);
             $salesPerson = $this->common_model->getRecord(TBL_CLIENT_SALESPERSON, array('sales_person_name', 'sales_contact_no', 'sales_person_email'), $where);
             $data['salesPerson'] = $salesPerson;

             $where = array('account_id' => $invoiceDetail->account_id);
             $accountPerson = $this->common_model->getRecord(TBL_CLIENT_ACCOUNTPERSON, array('account_person_name', 'account_contact_no', 'account_person_email'), $where);
             $data['accountPerson'] = $accountPerson;

             $paymentterm = $this->common_model->getRecords(TBL_PAYMENT_TERMS_MASTER, array('id', 'name'));
             $data['paymentterm'] = $paymentterm;

             if ($invoiceDetail->category_id == ADSALESCAT || $invoiceDetail->category_id == ADSALESINCCAT) {
                 $impressionunit = $invoiceDetail->impression_unit;
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

             $where = array('is_service_category' => 1);
             $servicesubcategories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id', 'category_name'), $where);
             $data['servicesubcategories'] = $servicesubcategories;

             $where = array('is_active' => 'Y');
             $companylist = $this->common_model->getRecords(TBL_COMPANY_MASTER, array('*'), $where);
             $data['companylist'] = $companylist;

             $where = array('company_id' => $invoiceDetail->company_id);
             $companyBankDetails = $this->common_model->getRecords(TBL_COMPANY_BANK_DETAILS_MASTER, array('id', 'currency'), $where);
             $data['companyBankDetails'] = $companyBankDetails;
         }
         else {
             $this->session->set_flashdata('error', "Invoice Not found");
             redirect('dashboard');
         }

         $startMonthTexual = getConfiguration('financial_year_start_month');
         $financial_year_start_month = date('n', strtotime($startMonthTexual));
         $data['financial_year_start_month'] = $financial_year_start_month;

        $this->template->set('title', 'Generate Invoice');
        $this->template->load('default', 'contents', 'default/invoices/invoice_approval',$data);
    }


   /*
  * rejectInvoice
  * Purpose - To Reject Invoice by generator.
  * @Date -23/02/2018
  * @author - NJ
  */
    function rejectInvoice()
    {
        if ($this->input->is_ajax_request()) {
            $comment = $this->input->post('comment');
            $status = $this->input->post('status');
            $currentUser = getCurrentUser();
            $id = $this->input->post('Id');
            $invoiceDetails = $this->InvoiceModel->getInvoice($id);
            $approverComments=$invoiceDetails->approval_comment;
            $updateData = array(
                'generator_user_id' => $currentUser->id,
                'invoice_acceptance_status' => 'Reject',
                'invoice_generate_date' => date('Y-m-d'),
                'invoice_generator_comments' => $comment,
            );
            $message = "The Invoice Request has been rejected.";
            $where = array('invoice_req_id' => $id);
            $updatedData=$this->common_model->update(TBL_INVOICE_MASTER, $updateData, $where);
            if($updatedData)
            {
                $this->session->set_flashdata('success', "Invoice request has been rejected.");
            } else {
                $this->session->set_flashdata('error', "There is an error while rejecting invoice.");
            }

            if ($status == "Reject") { /*Send Email to Originator*/

                $subject = "IMS: Invoice Rejected";
                $template = 'invoice-rejectedByGenerator-notification';
                $originator = getUserInfo($invoiceDetails->originator_user_id);

                $generatorDetail = getUserInfo($currentUser->id);
                $generatorName = $generatorDetail->first_name . " " . $generatorDetail->last_name;
                $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                if (is_object($originator)) {
                   $toEmail = $originator->email;
                  // $toEmail = 'nishi.jain@webdunia.net';
                    $templateData = array('invoice' => $invoiceDetails,
                        'user' => $originator->first_name . ' ' . $originator->last_name,
                        'rejectedBy' =>  $generatorName,
                        'comment' => $comment,
                        'approverComments' =>$approverComments,
                    );
                    $cc = null;
                    if (hasApprover($invoiceDetails->originator_user_id)) {
                        $approverDetail = getApprover($invoiceDetails->originator_user_id);
                        $cc = $approverDetail->email;
                    }
                    EmailUtility::sendEmail($toEmail, $subject, $template, $templateData,null,$cc);
                }
                $response = array('success'=> 1, 'message'=> $message);
                echo json_encode($response);
            } else {
                $response = array('success'=> 0);
                echo json_encode($response);
            }
        }
    }



    public function approve_invoice()
    {
        $postData = $this->input->post();
        if($postData && $this->input->is_ajax_request()) {
            $cmp_id = explode("^##^", $postData['cmp']) [0];
            if ($cmp_id == 1) {
                $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim');
                $this->form_validation->set_rules('invoice_cat_abr', 'Invoice Category', 'required|trim');
                $this->form_validation->set_rules('invoice_year', 'Invoice Year', 'required|trim');
            }
            else {
                $this->form_validation->set_rules('invoice_no1', 'Invoice Number', 'required|trim');
                $this->form_validation->set_rules('invoice_cat_abr1', 'Invoice Category', 'required|trim');
                $this->form_validation->set_rules('invoice_year1', 'Invoice Year', 'required|trim');
            }

            $this->form_validation->set_rules('service_category', 'Service Category', 'required|trim');
            $this->form_validation->set_rules('invoice_gen_comments', 'Generator Comments', 'required|trim');
            $this->form_validation->set_rules('project_title', 'Project Title', 'required|trim');
            $this->form_validation->set_rules('payment_due_date', 'Payment Due Date', 'required|trim');
            $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
            $this->form_validation->set_rules('approval_comments', 'ApproVal Comments', 'required|trim');

            if ($this->form_validation->run()) {
                $edit = ($this->input->post('edit') ? $this->input->post('edit') : '');


                $invoice_date =($this->input->post('invoice_date') ? date('Y-m-d', strtotime($this->input->post('invoice_date'))) : '');
                $payment_due_date = ($this->input->post('payment_due_date') ? date('Y-m-d', strtotime($this->input->post('invoice_date'))):'');
                $net_amt = $this->input->post('net_amt');
                $grossamt = $this->input->post('grossamt');
                $tax_count = $this->input->post('taxcount');
                $total_tax = $this->input->post('tax' . ($tax_count - 1));
                $total_taxamt = $this->input->post('taxamt' . ($tax_count - 1));
                $service_category_id = ($this->input->post('service_category')?$this->input->post('service_category'):'');
                $conversion_rate = ($this->input->post('conversion_rate')?$this->input->post('conversion_rate'):'');
                $paymentterm = ($this->input->post('payment_term')?$this->input->post('payment_term'):'');
                $salesperson_id = ($this->input->post('wd_sales_id')?$this->input->post('wd_sales_id'):'');
                $po_curr = ($this->input->post('po_curr')?$this->input->post('po_curr'):'');
                $po_date = (($this->input->post('po_date') && $this->input->post('po_date') != '--') ? date('Y-m-d', strtotime($this->input->post('po_date'))): '');
                $po_dtl = $this->input->post('po_dtl');
                $po_no = $this->input->post('po_no');
                $po_amt = $this->input->post('po_amt');
                $category_id = $this->input->post('category_id');
                $project_title = ($this->input->post('project_title')?$this->input->post('project_title'):'');
                $gst_no = ($this->input->post('gst_no')?$this->input->post('gst_no'):'');
                $state = ($this->input->post('state')?$this->input->post('state'):'');
                $city =  ($this->input->post('city')?$this->input->post('city'):'');
                $client_name = ($this->input->post('client_name')?$this->input->post('client_name'):'');
                $client_address = ($this->input->post('client_addr')?$this->input->post('client_addr'):'');
                $place_of_supply = $this->input->post('place_of_supply');
                $currncytype = $this->input->post('currency');
                $bank_details = $this->input->post('bank_details');
                $approval_comments = $this->input->post('approval_comments');
                $invoice_gen_comments = $this->input->post('invoice_gen_comments');
                $country_id = $this->input->post('country_id');
                $invoice_id = $this->input->post('invoice_id');
                $invoice_cmp_id = $this->input->post('invoice_cmp_id');


                if ($cmp_id == 1) {
                $invoice_year = $postData['invoice_year'];
                $invoice_cat = $postData['invoice_cat_abr'];
                $invoice_no = $postData['invoice_no'];
                $invoice_no = $invoice_no . "/" . $invoice_cat . "/" . $invoice_year;
                $display_date = explode ( "-", $invoice_date );
                $invoiceDisplayDate = date ( "d-M-Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                } else {
                $invoice_year = $this->input->post('invoice_year1');
                $invoice_cat = $this->input->post('invoice_cat_abr1');
                $invoice_cat2 = $this->input->post('invoice_cat_abr2');
                $invoice_no = $this->input->post('invoice_no1');
                $invoice_no = $invoice_year . "/" . $invoice_cat . "/" . $invoice_cat2 . "/" . $invoice_no;
                $display_date = explode ( "-", $invoice_date );
                $invoiceDisplayDate = date ( "m/d/Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                }

                if ($edit != "") {
                    $updatemode = "updated";
                }

                else{
                    $updatemode = "accepted";
                }

                /*get service category name*/
                $where = array('id'=>$service_category_id,
                                'is_service_category'=>1);
                $service_category = $this->common_model->getRecord(TBL_CATEGORY_MASTER,array('category_name'),$where);

                /*get payment term name*/
                $where =  array('id'=>$paymentterm);
                $paymentTermDuration = $this->common_model->getRecord(TBL_PAYMENT_TERMS_MASTER,array('name'),$where);
                $paymentTerms = '';
                if($paymentTermDuration) {
                    $paymentTerms  =  $paymentTermDuration->name;
                }

                /*salesperson details*/
                $where = array('id'=>$salesperson_id,
                                'is_sales_person'=>1);
                $salesPerson = $this->common_model->getRecord(TBL_USER,array('CONCAT(first_name,\' \', last_name) as name'),$where);

                /*for invoice pdf and html genertaion*/
                $po_date1='';
                if ($category_id == WIRELESSCAT || $category_id == TECHNOLOGYCAT) {
                            $po_date1 = $po_date;
                } else {
                    if($po_date) {
                        $podate = explode("-", $po_date);
                        $po_date1 = $podate [2] . "-" . $podate [1] . "-" . $podate [0];
                        if ($podate [2] == "" && $podate [1] == "")
                            $po_date1 = $podate [0];

                    }
                }
                if($po_date1) {
                    $poDisplayDate = date ( 'd-M-Y', strtotime ($po_date1));
                } else {
                    $poDisplayDate = '--';
                }


                $where = array('company_id' => $cmp_id);

                $cmp_details = $this->common_model->getRecord(TBL_COMPANY_MASTER,array('company_name','company_address','company_contact','company_fax','company_short_code','invoice_footer_text','gst_no','sac_code','pan_no','include_tax'),$where);

                $taxdtl = array();
                $tax = array();
                $taxamt = array();
                $includestatus = array();

                $count_decrement = 1;
                if($invoice_cmp_id == $cmp_id){
                 $count_decrement = 2;
                 $total_tax = $this->input->post('tax' . ($tax_count - 1));
                 $total_taxamt = $this->input->post('taxamt' . ($tax_count - 1));
                }

                if($cmp_id==1){
                for($i = 1; $i <= ($tax_count - $count_decrement); $i ++) {
                $taxdtl[] = $this->input->post('taxdtl' . $i);
                $tax[] = $this->input->post('tax' . $i);
                $taxamt[] = $this->input->post('taxamt' . $i);
                $includestatus[] = $this->input->post('includestatus' . $i);

                }

               }

               if($invoice_cmp_id!=$cmp_id && $cmp_id == 1){
                $total_tax = $this->input->post('hiddenTotalTax');
                $total_taxamt = $this->input->post('total_taxamt');
               }

                /*pdf and html generation with signature*/
                $cheque_amt = convert_to_word($grossamt,$po_curr);

                $datainv = array('cmp_details'=>$cmp_details,
                           'display_date' => $invoiceDisplayDate,
                           'invoice_no' => $invoice_no,
                           'company_id' => $cmp_id,
                           'service_category' => $service_category->category_name,
                           'gst_no' => $gst_no,
                           'state' => $state,
                           'city' =>$city,
                           'client_name'=>$client_name,
                           'client_address'=>$client_address,
                           'sales_person'=>$salesPerson->name,
                           'project_title'=>$project_title,
                           'po_date'=> $poDisplayDate,
                           'paymentTermDuration'=> $paymentTerms,
                           'po_curr'=>$po_curr,
                           'grossamt'=>$grossamt,
                           'invoice_gen_comments'=>$invoice_gen_comments,
                           'net_amt'=>$net_amt,
                           'taxamt'=>$taxamt,
                           'taxdtl'=>$taxdtl,
                           'includestatus'=>$includestatus,
                           'total_tax'=>$total_tax,
                           'total_taxamt'=>$total_taxamt,
                           'tax_count'=>$tax_count,
                           'tax'=>$tax,
                           'po_no'=>$po_no,
                           'bank_details'=>$bank_details,
                           'cheque_amt'=>$cheque_amt,
                           'country_id'=>$country_id,
                           'approver'=>'Y'
                           );

                $html = $this->load->view('default/dashboard/invoice', $datainv, true);
                $addedPath = create_invoice_folder_html($html,$invoice_id,$cmp_details->company_short_code,$invoice_no,true);

                if($edit != ""){

                    /*if company id is the same*/

                    if($cmp_id == $invoice_cmp_id && $cmp_details->include_tax == 'Y') {

                        for ($i = 1; $i <= ($tax_count - 2); $i++) {
                            $columnid = $this->input->post('columnid' . $i);
                            $taxdtl = $this->input->post('taxdtl' . $i);
                            $tax = $this->input->post('tax' . $i);
                            $taxamt = $this->input->post('taxamt' . $i);
                            $includestatus = $this->input->post('includestatus' . $i);

                            $updateData = array();

                            $updateData = array('tax'=>$tax,
                                                'tax_amount'=>$taxamt);

                            $where = array('id'=>$columnid);

                            $this->common_model->update(TBL_INVOICE_REQTAX_MASTER,$updateData,$where);

                        }

                        $columnid = $this->input->post('columnid' . ($tax_count - 1) );
                        $updateData = array();

                        $updateData = array('tax'=>$total_tax,
                                            'tax_amount'=>$total_taxamt);
                        $where = array('id'=>$columnid);
                        $this->common_model->update(TBL_INVOICE_REQTAX_MASTER,$updateData,$where);

                        $taxation = $this->input->post('tax' . ($tax_count - 1) );

                    }else{
                        $where = array('invoice_req_id'=>$invoice_id);
                        $this->common_model->delete(TBL_INVOICE_REQTAX_MASTER,$where);

                        for ($i = 1; $i <= ($tax_count - 1); $i++) {
                        $insert_data = array();
                        $insert_data = array(
                                'invoice_req_id' => $invoice_id,
                                'tax_label' => $this->input->post('taxdtl' . $i) ,
                                'tax' => ($this->input->post('tax' . $i) ? $this->input->post('tax' . $i) : 0) ,
                                'tax_amount' => ($this->input->post('taxamt' . $i) ? $this->input->post('taxamt' . $i) : 0) ,
                                'includestatus' => $this->input->post('includestatus' . $i)
                        );
                        $this->common_model->insert(TBL_INVOICE_REQTAX_MASTER, $insert_data);
                        }

                        $insert_data = array(
                                'invoice_req_id' => $invoice_id,
                                'tax_label' => 'Total Tax %',
                                'tax' => $total_tax,
                                'tax_amount' => $total_taxamt ,
                                'includestatus' => ''
                        );
                        $this->common_model->insert(TBL_INVOICE_REQTAX_MASTER, $insert_data);

                        $taxation = (null!=$this->input->post('service_tax'))?$this->input->post('service_tax'): 0;
                    }

                    //update invoice

                    $updateData = array('invoice_no'=>$invoice_no,
                                        'invoice_date'=>$invoice_date,
                                        'invoice_generator_comments'=>$invoice_gen_comments,
                                        'wd_manager_id'=>$salesperson_id,
                                        'project_name'=>$project_title,
                                        'po_no'=>$po_no,
                                        'payment_term'=>$paymentterm,
                                        'billing_date'=>$po_date,
                                        'payment_due_date'=>$payment_due_date,
                                        'conversion_rate'=>$conversion_rate,
                                        'invoice_net_amount'=>$net_amt,
                                        'invoice_gross_amount'=>$grossamt,
                                        'taxation'=>$taxation,
                                        'gen_approval_status'=>'Accept',
                                        'gen_approval_comment'=>$approval_comments,
                                        'bank_detail' => nl2br($bank_details),
                                        'currncytype'=> $currncytype,
                                        'service_category'=>$service_category_id,
                                        'company_id'=>$cmp_id,
                                        'invoice_path'=>$addedPath
                                        );
                    $where = array('invoice_req_id'=>$invoice_id);

                    $this->common_model->update(TBL_INVOICE_MASTER,$updateData,$where);



                    //mail
                    $invoiceId = $this->input->post('invoice_id');
                    $invoiceDetails = $this->InvoiceModel->getInvoice($invoiceId);
                    $currentUser = getCurrentUser();
                    $category = $this->input->post('category_id');
                    $where = array('id' => $invoiceDetails->generator_user_id);
                    $generatorname = $this->common_model->getRecord(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name'), $where);
                    $originator = getUserInfo($invoiceDetails->originator_user_id);
                    $subject = "IMS : Invoice Accepted & Generated";
                    $template = 'invoice-acceptedByGenApprover-notification';
                    $generatorName = $generatorname->name;
                    $generatorEmail = getGeneratorsEmailByCategory($category);
                    $genApproverDetail = getUserInfo($currentUser->id);
                    $genApproverName = $genApproverDetail->first_name . " " . $genApproverDetail->last_name;
                    $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                    //$toEmail = 'nishi.jain@webdunia.net';
                    //$toEmail1 = 'nishi.jain@webdunia.net';
                    $toEmail = $originator->email;
                    $toEmail1 = $generatorEmail;
                    $cc = null;
                    $cc = $genApproverDetail->email;

                    $templateData1 = array('invoice' => $invoiceDetails,
                        'user' => $generatorName,
                        'updatedMode' =>$updatemode,
                        'acceptedBy' =>  $genApproverName,
                        'comments' => $this->input->post('invoice_gen_comments'),
                        'approvalcomments' => $this->input->post('approval_comments'),

                    );
                    $templateData = array('invoice' => $invoiceDetails,
                        'user' =>$originator->first_name . ' ' . $originator->last_name,
                        'updatedMode' =>$updatemode,
                        'acceptedBy' =>  $genApproverName ,
                        'comments' => $this->input->post('invoice_gen_comments'),
                        'approvalcomments' => $this->input->post('approval_comments'),
                    );

                    // $attachments = $this->email->attach($addedPath);
                    $attachments = FCPATH.$addedPath ;
                    EmailUtility::sendEmail($toEmail, $subject, $template, $templateData,$attachments);
                    EmailUtility::sendEmail($toEmail1, $subject, $template, $templateData1,$attachments,$cc);

                    $this->session->set_flashdata('success', "Invoice is successfully approved and confirmation has been sent to Invoice Originator !!");
                    $message = array('error'=>0,
                                     'message'=>"Invoice Approved");

                    echo json_encode($message);die;

                } else{

                    $updateData = array(
                                        'gen_approval_status'=>'Accept',
                                        'gen_approval_comment'=>$approval_comments,
                                        'invoice_path'=>$addedPath
                                        );
                    $where = array('invoice_req_id'=>$invoice_id);

                    $this->common_model->update(TBL_INVOICE_MASTER,$updateData,$where);

                    //mail
                    $invoiceId = $this->input->post('invoice_id');
                    $invoiceDetails = $this->InvoiceModel->getInvoice($invoiceId);
                    $currentUser = getCurrentUser();
                    $category = $this->input->post('category_id');
                    $where = array('id' => $invoiceDetails->generator_user_id);
                    $generatorname = $this->common_model->getRecord(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name'), $where);
                    $originator = getUserInfo($invoiceDetails->originator_user_id);
                    $subject = "IMS : Invoice Accepted & Generated";
                    $template = 'invoice-acceptedByGenApprover-notification';
                    $generatorName = $generatorname->name;
                    $generatorEmail = getGeneratorsEmailByCategory($category);
                    $genApproverDetail = getUserInfo($currentUser->id);
                    $genApproverName = $genApproverDetail->first_name . " " . $genApproverDetail->last_name;
                    $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);
                    //$toEmail = 'nishi.jain@webdunia.net';
                    //$toEmail1 = 'nishi.jain@webdunia.net';
                    $toEmail = $originator->email;
                    $toEmail1 = $generatorEmail;
                    $cc = null;
                    $cc = $genApproverDetail->email;

                    $templateData1 = array('invoice' => $invoiceDetails,
                        'user' => $generatorName,
                        'updatedMode' =>$updatemode,
                        'acceptedBy' =>  $genApproverName . '(' . $genApproverDetail->email . ')',
                        'comments' => $this->input->post('invoice_gen_comments'),
                        'approvalcomments' => $this->input->post('approval_comments'),

                    );
                    $templateData = array('invoice' => $invoiceDetails,
                        'user' =>$originator->first_name . ' ' . $originator->last_name,
                        'updatedMode' =>$updatemode,
                        'acceptedBy' =>  $genApproverName . '(' . $genApproverDetail->email . ')',
                        'comments' => $this->input->post('invoice_gen_comments'),
                        'approvalcomments' => $this->input->post('approval_comments'),
                    );

                    // $attachment = $this->email->attach($addedPath);
                    $attachments = FCPATH.$addedPath;
                    EmailUtility::sendEmail($toEmail, $subject, $template, $templateData,$attachments);
                    EmailUtility::sendEmail($toEmail1, $subject, $template, $templateData1,$attachments,$cc);

                    $this->session->set_flashdata('success', "Invoice is successfully approved and confirmation has been sent to Invoice Originator !!");
                    $message = array('error'=>0,
                                     'message'=>"Invoice Approved");

                    echo json_encode($message);die;
                }



            }
            else { /*else form validation unsuccessful*/
                $message = array('error'=>1,
                                 'message'=>"Some error occurred");

                    echo json_encode($message);die;
            }


        }
        //mail


}

    function approvarReject() {
        if ($this->input->is_ajax_request()) {

            $currentUser = getCurrentUser();
            $id = $this->input->post('Id');
            $generatorcomment = $this->input->post('comment');
            $approverComments = $this->input->post('Approvalcomment');
            $category = $this->input->post('Category');
            $rejectTo = $this->input->post('RejectTo');
            $invoiceDetails = $this->InvoiceModel->getInvoice($id);
            $where = array('id' => $invoiceDetails->generator_user_id);
            $generatorname = $this->common_model->getRecord(TBL_USER,array( 'id','CONCAT(first_name,\' \', last_name) as name'), $where);
                 $updateData = array(
                'gen_approval_status' => 'Reject',
                'invoice_acceptance_status' => 'Reject',
                'invoice_generator_comments' => $generatorcomment ,
                'gen_approval_comment' => $approverComments
            );

            $message = "The Invoice request has been rejected.";
            $where = array('invoice_req_id' => $id);
            $updatedData=$this->common_model->update(TBL_INVOICE_MASTER, $updateData, $where);
            if($updatedData)
            {
                $this->session->set_flashdata('success', "Invoice is rejected and confirmation has been sent to Invoice Originator and Generator Both.");
                $response = array('success'=> 1, 'message'=> $message);

            } else {
                $this->session->set_flashdata('error', "There is an error while rejecting invoice.");
                $response = array('success'=> 0, 'message'=> 'There is an error while rejecting invoice.');
            }
            if($rejectTo == "Originator")
            {

                 $subject = "IMS: Invoice Rejected";
                 $template = 'invoice-rejectedByGenerator-notification';
                 $originator = getUserInfo($invoiceDetails->originator_user_id);
                 $genApproverDetail = getUserInfo($currentUser->id);
                 $genApproverName = $genApproverDetail->first_name . " " . $genApproverDetail->last_name;
                 $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' .formatAmount($invoiceDetails->invoice_net_amount);
                 if (is_object($originator)) {
                      $toEmail = $originator->email;
                      //$toEmail = 'nishi.jain@webdunia.net';
                     $templateData = array('invoice' => $invoiceDetails,
                         'user' => $originator->first_name . ' ' . $originator->last_name,
                         'rejectedBy' =>  $genApproverName,
                         'comment' => $generatorcomment,
                         'approverComments' => $approverComments
                         );

                     EmailUtility::sendEmail($toEmail, $subject, $template, $templateData);
                 }
            }
            if($rejectTo == "Generator")
             {
                 $subject = "IMS : Invoice Rejected By Approver";
                 $template = 'invoice-rejectedByGenApprover-notification';
                 $generatorName = $generatorname->name;
                 $generatorEmail = getGeneratorsEmailByCategory($category);
                 $genApproverDetail = getUserInfo($currentUser->id);
                 $genApproverName = $genApproverDetail->first_name . " " . $genApproverDetail->last_name;
                 $invoiceDetails->formattedAmount = $invoiceDetails->currency_symbol . ' ' . formatAmount($invoiceDetails->invoice_net_amount);

                 $toEmail =$generatorEmail;
                 //$toEmail = 'nishi.jain@webdunia.net';
                 $templateData = array('invoice' => $invoiceDetails,
                     'user' => $generatorName,
                     'rejectedBy' =>  $genApproverName,
                     'comment' => $generatorcomment,
                     'approverComments' => $approverComments
                 );
                 EmailUtility::sendEmail($toEmail, $subject, $template, $templateData);
             }
            echo json_encode($response);
        }
    }

       public function getCurrency($cmp_id = 1,$currency="") {
        $where = array('company_id' => $cmp_id);
        $companyBankDetails = $this->common_model->getRecords(TBL_COMPANY_BANK_DETAILS_MASTER, array('id','currency'), $where);
        $option = '<option value="-1">None</option>';
        foreach ( $companyBankDetails as $row ) {
            $id = $row->id;
            $curr = $row->currency;

            if ($currency!='') {
                if($currency == $id) {
                    $option .= '<option value="' . $id . '" selected>' . $curr . '</option>';
                }
                else {
                    $option .= '<option value="' . $id . '">' . $curr . '</option>';
                }

            } else {
                $option .= '<option value="' . $id . '">' . $curr . '</option>';
            }
        }
        return $option;
    }

       public  function getBankDetailsByCurrency(){
       if ($this->input->is_ajax_request()) {
           $company_id = $this->input->post('company_id');
           $status = $this->input->post('status');
           $currency='';
          if ($status == "invoicegenerator") {
               $response = $this->getCurrency($company_id,$currency);
           } else if ($status == "invoiceapprover") {
               $id = $this->input->post('invoice_id');
               $invoiceDetails = $this->InvoiceModel->getInvoice($id);
               $response =$this->getCurrency($company_id,$invoiceDetails->currncytype );
           }
           echo $response;
           exit ();
       }
   }

    public function service_taxdtl()
    {
        $company_id = $this->input->post('company_id');
        $id = $this->input->post('invoice_id');
        $invoiceDetail = $this->InvoiceModel->getInvoice($id);
        $status = $this->input->post('status');
        if ($status == "invoicegenerator") {
            if ($invoiceDetail->invoice_acceptance_status == "Accept") {
                $tax_row = tax_column_accept($id, $invoiceDetail->currency_symbol,$invoiceDetail->invoice_net_amount,$company_id);
            } else {
                $tax_row = taxColumn($invoiceDetail,$company_id);
            }
        }
        else if ($status == "invoiceapprover") {

            if ($company_id == $invoiceDetail->company_id) {
                //echo "YES1"; die;
                $tax_row = tax_column_appr($id,$invoiceDetail->currency_symbol,$invoiceDetail->invoice_net_amount,$invoiceDetail->invoice_gross_amount,$company_id);
            }else {
                //echo "YES2"; die;
                $tax_row = tax_column_appr_update ( $invoiceDetail, $company_id);
            }
        }
        echo $tax_row;
    }

    /*
   * To Get BankDetails By CurrencyId.
   * @purpose -To Get BankDetails By CurrencyId.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function getBankDetailsById()
    {
        if($this->input->is_ajax_request()) {
            $currencyId = $this->input->post('currencyId');
            $company_id = $this->input->post('company_id');
            if($currencyId) {
                $where = array('id' => $currencyId,'company_id'=>$company_id);
                $bankDetails = $this->common_model->getRecords(TBL_COMPANY_BANK_DETAILS_MASTER, array('bank_details'), $where);
                $data = array('bankDetails' => $bankDetails);
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

    public function getInvoiceDetailsById() {

        if($this->input->is_ajax_request()) {

            $id = $this->input->post('invoice_id');
            $invoiceDetail = $this->InvoiceModel->getInvoice($id);
            echo json_encode($invoiceDetail);
            die;

        }

    }


    public function previewInvoice() {
        $userInfo = getCurrentUser();
        if($this->input->is_ajax_request()) {
            $data = array();

            $postData = $this->input->post();
               

            $cmp_id = explode("^##^", $this->input->post('cmp')) [0];
            if ($cmp_id == 1) {
                $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim');
                $this->form_validation->set_rules('invoice_cat_abr', 'Invoice Category', 'required|trim');
                $this->form_validation->set_rules('invoice_year', 'Invoice Year', 'required|trim');
            }
            else {
                $this->form_validation->set_rules('invoice_no1', 'Invoice Number', 'required|trim');
                $this->form_validation->set_rules('invoice_cat_abr1', 'Invoice Category', 'required|trim');
                $this->form_validation->set_rules('invoice_year1', 'Invoice Year', 'required|trim');
            }

            $this->form_validation->set_rules('service_category', 'Service Category', 'required|trim');
            $this->form_validation->set_rules('invoice_gen_comments', 'Generator Comments', 'required|trim');
            $this->form_validation->set_rules('project_title', 'Project Title', 'required|trim');
            $this->form_validation->set_rules('payment_due_date', 'Payment Due Date', 'required|trim');
            $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');

            if ($this->form_validation->run()) {

                $invoice_date =($this->input->post('invoice_date') ? date('Y-m-d', strtotime($this->input->post('invoice_date'))) : '');
                $service_category = ($this->input->post('service_category')?$this->input->post('service_category'):'');
                $gst_no = ($this->input->post('gst_no')?$this->input->post('gst_no'):'');
                $state = ($this->input->post('state')?$this->input->post('state'):'');
                $city =  ($this->input->post('city')?$this->input->post('city'):'');
                $client_name = ($this->input->post('client_name')?$this->input->post('client_name'):'');
                $client_address = ($this->input->post('client_addr')?$this->input->post('client_addr'):'');
                $salesperson_id = ($this->input->post('wd_sales_id')?$this->input->post('wd_sales_id'):'');
                $project_title = ($this->input->post('project_title')?$this->input->post('project_title'):'');
                $po_no = ($this->input->post('po_no')?$this->input->post('po_no'):'');
                $po_date =(($this->input->post('po_date') && $this->input->post('po_date') != '--') ? date('Y-m-d', strtotime($this->input->post('po_date'))) : '');
                $category_id = ($this->input->post('category_id')?$this->input->post('category_id'):'');
                $paymentterm = ($this->input->post('payment_term')?$this->input->post('payment_term'):'');
                $po_curr = ($this->input->post('po_curr')?$this->input->post('po_curr'):'');
                $grossamt = ($this->input->post('grossamt')?$this->input->post('grossamt'):'');
                $invoice_gen_comments = ($this->input->post('invoice_gen_comments')?$this->input->post('invoice_gen_comments'):'');
                $net_amt = ($this->input->post('net_amt')?$this->input->post('net_amt'):'');
                $tax_count = ($this->input->post('taxcount')?$this->input->post('taxcount'):'');
                $bankDetails = ($this->input->post('bank_details')?$this->input->post('bank_details'):'');
                $total_tax = ($this->input->post('total_tax')?$this->input->post('total_tax'):'');
                $total_taxamt = ($this->input->post('total_taxamt')?$this->input->post('total_taxamt'):'');
                $invoice_id = ($this->input->post('invoice_id')?$this->input->post('invoice_id'):'');
                $bank_details = ($this->input->post('bank_details')?$this->input->post('bank_details'):'');
                $country_id = ($this->input->post('country_id')?$this->input->post('country_id'):'');
                $approver = $this->input->post('approver');
                $invoice_cmp_id = $this->input->post('invoice_cmp_id');
                if(isApprover($userInfo->id)) {
                    $approver = 'Y';
                }
                $po_date1 = '';
                if ($category_id == WIRELESSCAT || $category_id == TECHNOLOGYCAT) {
                    $po_date1 = $po_date;
                } else {
                    $podate = explode ( "-", $po_date );
                    $po_date1 = $podate [2] . "-" . $podate [1] . "-" . $podate [0];
                    if ($podate [2] == "" && $podate [1] == "")
                        $po_date1 = $podate [0];
                }

                if($po_date1) {
                    $poDisplayDate = date ( 'd-M-Y', strtotime ($po_date1));
                } else {
                    $poDisplayDate = '--';
                }


                if ($cmp_id == 1) {
                    $invoice_year = $this->input->post('invoice_year');
                    $invoice_cat = $this->input->post('invoice_cat_abr');
                    $invoice_no = $this->input->post('invoice_no');
                    $invoice_no = $invoice_no . "/" . $invoice_cat . "/" . $invoice_year;
                    $display_date = explode ( "-", $invoice_date );
                    $invoiceDisplayDate = date ( "d-M-Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                } else {
                    $invoice_year = $this->input->post('invoice_year1');
                    $invoice_cat = $this->input->post('invoice_cat_abr1');
                    $invoice_cat2 = $this->input->post('invoice_cat_abr2');
                    $invoice_no = $this->input->post('invoice_no1');
                    $invoice_no = $invoice_year . "/" . $invoice_cat . "/" . $invoice_cat2 . "/" . $invoice_no;
                    $display_date = explode ( "-", $invoice_date );
                    $invoiceDisplayDate = date ( "m/d/Y", mktime ( 0, 0, 0, $display_date [1], $display_date [2], $display_date [0] ) );
                }

                /*taxdetails*/
                $taxdtl = array();
                $tax = array();
                $taxamt=array();
                $includestatus = array();

                $count_decrement = 1;
                if($approver == 'Y' && $invoice_cmp_id == $cmp_id){
                 $count_decrement = 2;
                 $total_tax = $this->input->post('tax' . ($tax_count - 1));
                 $total_taxamt = $this->input->post('taxamt' . ($tax_count - 1));
                }

                if($invoice_cmp_id!=$cmp_id && $cmp_id == 1){
                    $total_tax = $this->input->post('hiddenTotalTax');
                }
                //var_dump($count_decrement);die;

                if($cmp_id==1){


                    for($i = 1; $i <= ($tax_count - $count_decrement); $i ++) {
                    $taxdtl[] = $this->input->post('taxdtl' . $i);
                    $tax[] = $this->input->post('tax' . $i);
                    $taxamt[] = $this->input->post('taxamt' . $i);
                    $includestatus[] = $this->input->post('includestatus' . $i);
                    }

                }

                /*get company details*/

                $where = array('company_id' => $cmp_id);
                $cmp_details = $this->common_model->getRecord(TBL_COMPANY_MASTER,array('company_name','company_address','company_contact','company_fax','company_short_code','invoice_footer_text','gst_no','sac_code','pan_no'),$where);

                /*get service details*/

                $where = array('id'=>$service_category,
                               'is_service_category'=>1);
                $service_category = $this->common_model->getRecord(TBL_CATEGORY_MASTER,array('category_name'),$where);

                /*get salespersondetails*/

                $where = array('id'=>$salesperson_id,
                                'is_sales_person'=>1);
                $salesPerson = $this->common_model->getRecord(TBL_USER,array('CONCAT(first_name,\' \', last_name) as name'),$where);

                /*get payment term*/
                $where =  array('id'=>$paymentterm);
                $paymentTermDuration = $this->common_model->getRecord(TBL_PAYMENT_TERMS_MASTER,array('name'),$where);

                $cheque_amt = convert_to_word($grossamt,$po_curr);

                $data = array('cmp_details'=>$cmp_details,
                               'display_date' => $invoiceDisplayDate,
                               'invoice_no' => $invoice_no,
                               'company_id' => $cmp_id,
                               'service_category' => $service_category->category_name,
                               'gst_no' => $gst_no,
                               'state' => $state,
                               'city' =>$city,
                               'client_name'=>$client_name,
                               'client_address'=>$client_address,
                               'sales_person'=>$salesPerson->name,
                               'project_title'=>$project_title,
                               'po_date'=>$poDisplayDate,
                               'paymentTermDuration'=>$paymentTermDuration->name,
                               'po_curr'=>$po_curr,
                               'grossamt'=>$grossamt,
                               'invoice_gen_comments'=>$invoice_gen_comments,
                               'net_amt'=>$net_amt,
                               'taxamt'=>$taxamt,
                               'taxdtl'=>$taxdtl,
                               'includestatus'=>$includestatus,
                               'total_tax'=>$total_tax,
                               'total_taxamt'=>$total_taxamt,
                               'tax_count'=>$tax_count,
                               'tax'=>$tax,
                               'po_no'=>$po_no,
                               'bank_details'=>$bank_details,
                               'cheque_amt'=>$cheque_amt,
                               'country_id'=>$country_id,
                               'approver'=>$approver
                               );

                $html = $this->load->view('default/dashboard/invoice', $data, true);
                $addedPath = create_invoice_folder_html($html,$invoice_id,$cmp_details->company_short_code,$invoice_no);
                $data = array('error'=>0,
                               'path'=>base_url().$addedPath);
                echo json_encode($data);die;
            } else {
                $data = array('error'=>1,
                              'message'=>'Please validate the forms');
                echo json_encode($data);die;
            }
        }
    }
}







