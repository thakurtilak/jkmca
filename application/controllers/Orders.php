<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller
{

    /**
     * Index Page for this controller.
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
        $this->load->library('emailUtility');
        if (!isLoggedIn()) {
            redirect('login');
        }
    }


    /*
    * index
    * URL -Orders/index
    * PURPOSE -Use to list all orders in the system.
    * @Date -23/02/2018
    * @author - NJ
    */
    public function index()
    {
        $this->load->model('OrdersModel');
        $userDetail = getCurrentUser();

        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $order = $this->input->get('order[0][dir]');
            $categoryId = (!empty($this->input->get('category_id'))) ? $this->input->get('category_id') : false;
            $clientId = (!empty($this->input->get('client_id'))) ? $this->input->get('client_id') : false;
            $status = (!empty($this->input->get('status_id'))) ? $this->input->get('status_id') : false;
            $assigned = (!empty($this->input->get('type_id'))) ? $this->input->get('type_id') : false;
            $name = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "client_name";
                    break;
                case 2 :
                    $orderColumn = "category_name";
                    break;
                case 3 :
                    $orderColumn = "project_name";
                    break;
                case 4 :
                    $orderColumn = "start_date";
                    break;
                case 5 :
                    $orderColumn = "end_date";
                    break;
                case 7 :
                    $orderColumn = "order_amount";
                    break;
                default:
                    $orderColumn = "order_create_date";
            }
            $orderBY = $orderColumn . " " . $order;
            $ordersList = $this->OrdersModel->listOrders($userDetail->id, $categoryId, $clientId, $status, $assigned, $name, $orderBY, $start, $length);
            $recordsTotal = $this->OrdersModel->count_all($userDetail->id);
            $recordsFiltered = $this->OrdersModel->count_filtered($userDetail->id, $categoryId, $clientId, $status, $assigned, $name, $orderBY);
            $draw = $this->input->get('draw');
            $data = array();
            if ($ordersList) {
                foreach ($ordersList as $order) {

                    //$where = array('order_id' => $order->order_id);
                    //$invoiced = $this->common_model->getRecord(TBL_INVOICE_MASTER, array('*'), $where);
                    $invoiced = "";
                    $invoiceRequest = '';
                    if (trim($order->start_date) == "") {
                        $orderStartDate = "--";
                    } else {
                        $orderStartDate = ($order->start_date ? date('d-M-Y', strtotime($order->start_date)) : '');
                    }

                    if (trim($order->end_date) == "" || $order->project_type == "TNM") {
                        $orderEndDate = "--";
                    } else {
                        $orderEndDate = ($order->end_date ? date('d-M-Y', strtotime($order->end_date)) : '');
                    }

                    if ($order->order_unique_id == "") {
                        $orderId = '--';
                    } else {
                        $orderId = $order->order_unique_id;
                    }
                    if (trim($order->order_category_id) == "") {
                        $orderCategory = "--";
                    } else {
                        $orderCategory = $order->category_name;
                    }

                    if (trim($order->total_efforts) == "" && $order->project_type != 'TNM') {
                        $totalEfforts = "0.00";
                    } else {

                        if ($order->project_type == 'FB') {
                            if ($order->efforts_unit == 'D') {
                                $totalEfforts = $order->total_efforts . " PD's ";
                            } else if ($order->efforts_unit == 'M') {
                                $totalEfforts = $order->total_efforts . " PM's ";
                            } else {
                                $totalEfforts = $order->total_efforts . " Hours ";
                            }
                        } else {
                            if ($order->efforts_unit == 'D') {
                                $totalEfforts = $order->total_efforts . " PD's ";
                            } else if ($order->efforts_unit == 'M') {
                                $totalEfforts = $order->total_efforts . " PM's ";
                            } else {
                                $totalEfforts = $order->total_efforts . " Hours ";
                            }
                        }
                    }

                    if (trim($order->client_id) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $order->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $order->client_id . ">" . $clientName . "</a>";
                    }

                    if (trim($order->order_amount) == "") {
                        $orderAmount = "0.00";
                    } else {
                        $orderAmount = $order->currency_symbol . ' ' . formatAmount($order->order_amount);
                    }
                    $projectName = $order->project_name;
                    if ($order->created_by != $userDetail->id) {
                        $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='View'><i class='icon-view1'></i></a>";
                    } else {
                        if ($order->is_cancelled == 'N') {
                            if ($invoiced == "Invoiced") {
                                $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='View'><i class='icon-view1'></i></a><a class=\"mdl - js - button mdl - js - ripple - effect btn - pending action - btn noaction - btn\" href=\"javascript:void(0);\">" . $invoiced . "</a>";
                            } else if ($invoiceRequest == "Invoiced") {
                                $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='View'><i class='icon-view1'></i></a><a class=\"mdl-js-button mdl-js-ripple-effect btn-pending action-btn noaction-btn\" href=\"javascript:void(0);\">" . $invoiceRequest . "</a>";
                            } else {
                                $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='View' ><i class='icon-view1'></i></a><a class=\"mdl-js-button mdl-js-ripple-effect btn-pending action-btn\" href=\"#cancelModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='Cancel'><i class='icon-cancel'></i></a>";
                            }
                        } else {
                            $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . " title='View'><i class='icon-view1'></i></a><a class=\"mdl-js-button mdl-js-ripple-effect btn-pending action-btn noaction-btn\" href=\"javascript:void(0);\" title='Canceled'><i class='icon-cancel'></i></a>";
                        }
                    }

                    $tempData = array("order_id" => $orderId,
                        "client_name" => $clientName,
                        "category_name" => $orderCategory,
                        "project_name" => $projectName,
                        "start_date" => $orderStartDate,
                        "end_date" => $orderEndDate,
                        "total_efforts" => $totalEfforts,
                        "order_amount" => $orderAmount,
                        "order_date" => $order->order_create_date,
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
        //Get Order category
        $where = array('status' => 1, 'is_order_category' => 1);
        $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id', 'category_name'), $where, 'category_name');
        $data = array('categories' => $categories);

        /*$where1 = array('status' => 1);
        $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id','client_name'), $where1);
        $data['clients'] = $clients;*/

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Order List');
        $this->template->load('default', 'contents', 'default/orders/list', $data);
    }

    /*
     * cancel_order
     * URL - Orders/cancel-order
     * PURPOSE - To cancel Order
     * @Date -23/02/2018
     * @author - NJ
     */
    public function cancel_order($orderId)
    {
        $this->load->model('OrdersModel');
        $where = array('order_id' => $orderId);
        $userDetail = getCurrentUser();
        $postData = $this->input->post();
        if ($postData && $orderId) {
            $orderDetail = $this->common_model->getRecord(TBL_ORDER_MASTER, array('order_id', 'is_cancelled', 'created_by'), $where);
            if ($orderDetail) {
                if ($orderDetail->created_by == $userDetail->id) {
                    if ($orderDetail->is_cancelled == 'N') {

                        $dataToupdate = array('is_cancelled' => 'Y', 'cancellation_reason' => $postData['cancellation_reason']);
                        $isCanceled = $this->OrdersModel->update($where, $dataToupdate);
                        if ($isCanceled) {
                            $this->session->set_flashdata('success', "Order has been cancelled.");
                        } else {
                            $this->session->set_flashdata('error', "Error while cancel your order. Please try again");
                        }
                    } else {
                        $this->session->set_flashdata('error', "This order already cancelled.");
                    }
                } else {
                    $this->session->set_flashdata('error', "You are not authorized to cancel this order.");
                }
            } else {
                $this->session->set_flashdata('error', "Order doesn't exist.");
            }
        }
        redirect('orders');
    }

    /*
    * view_order
    * URL - Orders/view-order
    * PURPOSE - To view Order
    * @Date -23/02/2018
    * @author - NJ
    */
    public function view_order($orderId)
    {
        $this->load->model('OrdersModel');
        $orderDetail = $this->OrdersModel->getOrder($orderId);
        $data = array('orderDetail' => $orderDetail);
        if (($orderDetail->project_type == "FB") || (($orderDetail->project_type == "TNM") && ($orderDetail->efforts_unit == 'M'))) {
            $where = array('order_id' => $orderId);
            $orderSchedules = $this->common_model->getRecords(TBL_ORDER_INVOICE_SCHEDULE_MASTER, array('invoice_date', 'invoice_amount', 'invoice_comment', 'status'), $where);
            $data['orderSchedules'] = $orderSchedules;
        }

        $where = array('order_id' => $orderId);
        $orderAttachments = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('order_id','attach_file_name','attach_file_path', 'attach_type'), $where);
        $data['orderAttachments'] = $orderAttachments;

        $where = array('salesperson_id' => $orderDetail->sales_id);
        $salesPerson = $this->common_model->getRecord(TBL_CLIENT_SALESPERSON, array('sales_person_name', 'sales_contact_no', 'sales_person_email'), $where);
        $data['salesPerson'] = $salesPerson;

        $where = array('account_id' => $orderDetail->account_id);
        $accountPerson = $this->common_model->getRecord(TBL_CLIENT_ACCOUNTPERSON, array('account_person_name', 'account_contact_no', 'account_person_email'), $where);
        $data['accountPerson'] = $accountPerson;

        $where = array('client_id' => $orderDetail->client_id);
        $clientAgreements = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, array('agreement_name', 'client_id'), $where);
        $data['clientAgreements'] = $clientAgreements;

        $viewHtml = $this->load->view('default/orders/view', $data, true);
        echo $viewHtml;
    }

    /*
   * active_orders
   * URL - Orders/active-orders
   * PURPOSE - Use to list all active orders in the system
   * @Date -23/02/2018
   * @author - NJ
   */
    public function active_orders()
    {
        $this->load->model('OrdersModel');
        $userDetail = getCurrentUser();

        if ($this->input->is_ajax_request()) {

            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $order = $this->input->get('order[0][dir]');

            $name = $this->input->get('search[value]');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "client_name";
                    break;
                case 2 :
                    $orderColumn = "category_name";
                    break;
                case 3 :
                    $orderColumn = "project_name";
                    break;
                case 4 :
                    $orderColumn = "start_date";
                    break;
                case 5 :
                    $orderColumn = "end_date";
                    break;
                case 7 :
                    $orderColumn = "order_amount";
                    break;
                default:
                    $orderColumn = "order_create_date";
            }
            $orderBY = $orderColumn . " " . $order;
            $ordersList = $this->OrdersModel->listActiveOrders($userDetail->id, null, null, null, null, $name, $orderBY, $start, $length);
            $recordsTotal = $this->OrdersModel->count_all_activeorders();
            $recordsFiltered = $this->OrdersModel->count_filtered_activeorders($userDetail->id, null, null, null, null, $name, $orderBY);
            $draw = $this->input->get('draw');
            $data = array();
            if ($ordersList) {
                foreach ($ordersList as $order) {

                    //$where = array('order_id' => $order->order_id);
                    //$invoiced = $this->common_model->getRecord(TBL_INVOICE_MASTER, array('*'), $where);
                    $invoiced = "";
                    $invoiceRequest = '';
                    if (trim($order->start_date) == "") {
                        $orderStartDate = "--";
                    } else {
                        $orderStartDate = ($order->start_date ? date('d-M-Y', strtotime($order->start_date)) : '');
                    }

                    if (trim($order->end_date) == "" || $order->project_type == "TNM") {
                        $orderEndDate = "--";
                    } else {
                        $orderEndDate = ($order->end_date ? date('d-M-Y', strtotime($order->end_date)) : '');
                    }

                    if ($order->order_unique_id == "") {
                        $orderId = '--';
                    } else {
                        $orderId = $order->order_unique_id;
                    }
                    if (trim($order->order_category_id) == "") {
                        $orderCategory = "--";
                    } else {
                        $orderCategory = $order->category_name;
                    }

                    if (trim($order->total_efforts) == "" && $order->project_type != 'TNM') {
                        $totalEfforts = "0.00";
                    } else {

                        if ($order->project_type == 'FB') {
                            if ($order->efforts_unit == 'D') {
                                $totalEfforts = $order->total_efforts . " PD's ";
                            } else if ($order->efforts_unit == 'M') {
                                $totalEfforts = $order->total_efforts . " PM's ";
                            } else {
                                $totalEfforts = $order->total_efforts . " Hours ";
                            }
                        } else {
                            if ($order->efforts_unit == 'D') {
                                $totalEfforts = $order->total_efforts . " PD's ";
                            } else if ($order->efforts_unit == 'M') {
                                $totalEfforts = $order->total_efforts . " PM's ";
                            } else {
                                $totalEfforts = $order->total_efforts . " Hours ";
                            }
                        }
                    }

                    if (trim($order->client_id) == "") {
                        $clientName = "--";
                    } else {
                        $clientName = $order->client_name;
                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $order->client_id . ">" . $clientName . "</a>";
                    }

                    if (trim($order->order_amount) == "") {
                        $orderAmount = "0.00";
                    } else {
                        $orderAmount = $order->currency_symbol . ' ' . formatAmount($order->order_amount);
                    }
                    $projectName = $order->project_name;

                    $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href=\"#viewModal\" data-toggle=\"modal\" data-target-id=" . $order->order_id . ">View Order</a>";
                    $tempData = array("order_id" => $orderId,
                        "client_name" => $clientName,
                        "category_name" => $orderCategory,
                        "project_name" => $projectName,
                        "start_date" => $orderStartDate,
                        "end_date" => $orderEndDate,
                        "total_efforts" => $totalEfforts,
                        "order_amount" => $orderAmount,
                        "order_date" => $order->order_create_date,
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
        //Get Order category
        $where = array('status' => 1, 'is_order_category' => 1);
        $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id', 'category_name'), $where, 'category_name');
        $data = array('categories' => $categories);

        $data['user_id'] = $userDetail->id;
        $this->template->set('title', 'Order List');
        $this->template->load('default', 'contents', 'default/orders/activeorders_list', $data);
    }

    /*
    * Upload MultipleAgreement
    * @purpose - Upload Multiple agreement and save agreement name into database.
    * @Date -24/01/2018
    * @author - NJ
    */
    private function multifiles_do_upload($inserted_order_id = false)
    {
        $financialYear = getCurrentFinancialYear();
        $uploadDirectory = realpath('uploads') . DIRECTORY_SEPARATOR .$financialYear. DIRECTORY_SEPARATOR . 'orders_upload';
        // Ensure there's a trailing slash
        $uploadDirectory = strtr(
                rtrim($uploadDirectory, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;
        $uploadDirectory = $uploadDirectory . $inserted_order_id . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create upload directory...');
            }
        }
        $uploadedFiles = array();
        if(($this->input->post('order_type') == "E") && $this->input->post('order_id')) {
            $where = array('order_id' => $this->input->post('order_id'));
            $attachment_detail = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, 'attach_id', $where);
            if ($attachment_detail) { /*For existing File*/
                foreach ($attachment_detail as $key => $attachment) {
                    if (isset($_FILES['attachment']['name'][$attachment->attach_id]) && !empty($_FILES['attachment']['name'][$attachment->attach_id])) {
                        $fileObjName = 'attachment_upload' . $key;
                        $_FILES[$fileObjName]['name'] = $_FILES['attachment']['name'][$attachment->attach_id];
                        $_FILES[$fileObjName]['type'] = $_FILES['attachment']['type'][$attachment->attach_id];
                        $_FILES[$fileObjName]['tmp_name'] = $_FILES['attachment']['tmp_name'][$attachment->attach_id];
                        $_FILES[$fileObjName]['error'] = $_FILES['attachment']['error'][$attachment->attach_id];
                        $_FILES[$fileObjName]['size'] = $_FILES['attachment']['size'][$attachment->attach_id];
                        $new_name = time() . '_' . $_FILES[$fileObjName]['name'];
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
                    $uploadedFiles[] = array('error' => $this->upload->display_errors());
                }
            }
        }
        return $uploadedFiles;
    }

    /*
     * create_order
     * URL - Orders/create-order
     * PURPOSE - To create an order
     * @Date -23/02/2018
     * @author - NJ
     */
    public function create_order()
    {
        $this->load->model('OrdersModel');
        $postData = $this->input->post();
        if ($postData) {
            $this->form_validation->set_rules('category_id', 'Category', 'required');
            $this->form_validation->set_rules('client', 'Client Name', 'required');
            $this->form_validation->set_rules('project_type', 'Project type', 'required');
            if ($postData['project_type'] == 'FB') {

                // $this->form_validation->set_rules('add_invoice_startdate[]', 'start date', 'required');
                // $this->form_validation->set_rules('add_invoice_amount[]', 'amount', 'required');
                $this->form_validation->set_rules('end_date', 'End Date', 'required');

            } else {

                $this->form_validation->set_rules('efforts_unit', 'Effort Unit', 'required');
                if ($postData['efforts_unit'] == 'M') {
                    $this->form_validation->set_rules('duration', 'Duration', 'required');

                }
                if ($postData['efforts_unit'] == 'M' && $postData['duration'] != '') {
                    $this->form_validation->set_rules('add_invoice_startdate[]', 'Start Date', 'required');
                    $this->form_validation->set_rules('add_invoice_amount[]', 'Amount', 'required');
                    //$this->form_validation->set_rules('add_invoice_comment[]', 'comment', 'required');
                }

                $this->form_validation->set_rules('unit_rate', 'Unit Rate', 'required');
                $this->form_validation->set_rules('hourCurncy', 'Hour Currency', 'required');
            }

            $this->form_validation->set_rules('order_type', 'Order type', 'required');
            if ($postData['order_type'] == 'N') {

                $this->form_validation->set_rules('project_name', 'Project Name', 'required|is_unique[ims_order_master.project_name]');
            }
            if ($postData['order_type'] == 'E') {

                $this->form_validation->set_rules('order_id', 'Project Name', 'required');
            }

            $this->form_validation->set_rules('project_description', 'Project Description', 'required|trim');
            $this->form_validation->set_rules('wd_sales_id', 'Webdunia Sales Person Name', 'required|trim');
            $this->form_validation->set_rules('wd_tech_head_id', 'Webdunia Tech Head', 'required|trim');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
            $this->form_validation->set_rules('total_efforts', 'Total Efforts', 'required|trim');
            $this->form_validation->set_rules('order_amount', 'Order Amount', 'required|trim');
            $this->form_validation->set_rules('order_curncy', 'Order Currency', 'required|trim');
            $this->form_validation->set_rules('sales_contact_person', 'Client`s Manager Name', 'required|trim');
            $this->form_validation->set_rules('sales_contact_no', 'Client`s Manager contact No.', 'required|trim');
            $this->form_validation->set_rules('sales_email_id', 'Client`s Manager emailId', 'required|trim');
            $this->form_validation->set_rules('client_address', 'Client`s Address', 'required|trim');
            /* $this->form_validation->set_rules('account_contact_person', 'Account person name','required|trim');
             $this->form_validation->set_rules('account_contact_no', 'Account person contactno','required|trim');
             $this->form_validation->set_rules('account_email_id', 'Account person emailId','required|trim');*/
            $this->form_validation->set_rules('payment_term', 'Payment Term', 'required|trim');
            $this->form_validation->set_rules('invoice_org_remarks', 'Remarks', 'required|trim');
            if (empty($_POST['no_po'])) {

                $this->form_validation->set_rules('po_no', 'PO NO', 'required|trim');
                $this->form_validation->set_rules('po_dtl', 'PO detail', 'required|trim');
                $this->form_validation->set_rules('po_date', 'PO date', 'required|trim');
                //$this->form_validation->set_rules('file-upload-input', 'Attachment', 'required|trim');
            }
            if ($this->form_validation->run()) {

                $insert_data = array(
                    'order_category_id' => $this->input->post('category_id'),
                    'project_name' => $this->input->post('project_name'),
                    'project_type' => $this->input->post('project_type'),
                    'project_description' => $this->input->post('project_description'),
                    'wd_sales_person_id' => $this->input->post('wd_sales_id'),
                    'wd_tech_head_id' => $this->input->post('wd_tech_head_id'),
                    'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                    'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                    'efforts_unit' => $this->input->post('effort_unit'),
                    'total_efforts' => $this->input->post('total_efforts'),
                    'hourly_rate' => $this->input->post('hourly_rate'),
                    'hour_rate_currency' => $this->input->post('hourCurncy'),
                    'order_amount' => $this->input->post('order_amount'),
                    'order_currency' => $this->input->post('order_curncy'),
                    'po_no' => $this->input->post('po_no'),
                    'po_date' =>($this->input->post('po_date') ? date('Y-m-d', strtotime($this->input->post('po_date'))): ''),
                    'po_dtl' => $this->input->post('po_dtl'),
                    'payment_term' => $this->input->post('payment_term'),
                    'invoice_originator_remarks' => $this->input->post('invoice_org_remarks'),
                    'client_id' => $this->input->post('client'),
                    'sales_id' => $this->input->post('sales_contact_person'),
                    'account_id' => $this->input->post('account_contact_person'),
                    'attach_count' => count($this->input->post('client_agreement')),
                    'duration' => $this->input->post('duration'),
                    'order_create_date' => date('Y-m-d H:i:s', now()),
                    'created_by' => getCurrentUsersId(),

                );

                if ($this->input->post('project_type') == "TNM") {
                    $insert_data['initial_hours'] = $this->input->post('total_efforts');
                }


                if ($this->input->post('order_type') == "E") {
                    $where = array('order_id' => $this->input->post('order_id'));
                    $projectname = $this->common_model->getRecord(TBL_ORDER_MASTER, 'project_name', $where);
                    $insert_data['project_name'] = $projectname->project_name;
                }

                if ($this->input->post('order_type') == "E") {

                    $insert_data['is_main_order'] = "N";
                    $insert_data['main_order_id'] = $this->input->post('order_id');

                } else {
                    $insert_data['is_main_order'] = "Y";
                    $insert_data['main_order_id'] = '';
                }

                if (count($this->input->post('client_agreement')) != 0) {

                    $insert_data['attach_status'] = "Y";

                } else {
                    $insert_data['attach_status'] = "";
                }

                if ($this->input->post('po_no') == "") {
                    $insert_data['po_no'] = 'None';

                }

                if ($this->input->post('no_po') != "") {
                    $insert_data['no_po'] = 1;
                } else {
                    $insert_data['no_po'] = 0;
                }

                if ($this->input->post('project_type') == "TNM") {
                    $insert_data['efforts_unit'] = $this->input->post('efforts_unit');

                    if ($this->input->post('unit_rate') == "") {
                        $insert_data['hourly_rate'] = "''";

                    } else {
                        $insert_data['hourly_rate'] = $this->input->post('unit_rate');
                    }
                    if ($this->input->post('hourCurncy') == "") {
                        $insert_data['hour_rate_currency'] = "''";

                    } else {
                        $insert_data['hour_rate_currency'] = $this->input->post('hourCurncy');
                    }
                }

                $inserted_order_id = $this->common_model->insert(TBL_ORDER_MASTER, $insert_data);

                if ($inserted_order_id) {
                    if ($this->input->post('project_type') == "FB" || (($this->input->post('project_type') == "TNM") && ($this->input->post('efforts_unit') == "M"))) {

                        if (isset($postData['add_invoice_startdate'])) {
                            $numFields = count($postData['add_invoice_startdate']);
                            for ($i = 0; $i < $numFields; $i++) {
                                $statusIndex = $i + 1;
                                if (isset($postData['invoice_status_' . $statusIndex])) {
                                    $data = array(
                                        'invoice_date' => date('Y-m-d', strtotime($postData['add_invoice_startdate'][$i])),
                                        'invoice_amount' => $postData['add_invoice_amount'][$i],
                                        'invoice_comment' => $postData['add_invoice_comment'][$i],
                                        'status' => $postData['invoice_status_' . $statusIndex],
                                        'order_id' => $inserted_order_id,
                                        'order_type' => 'MO'
                                    );
                                    $this->common_model->insert(TBL_ORDER_INVOICE_SCHEDULE_MASTER, $data);
                                }

                            }
                        }

                        /*$where= array('order_id'=>$this->input->post('order_id'));
                        $invoice_detail = $this->common_model->getRecords(TBL_ORDER_INVOICE_SCHEDULE_MASTER, array('schedule_id','invoice_date', 'invoice_amount', 'invoice_comment','status'),$where);
                        foreach($invoice_detail as $key =>$value){
                            if(isset($postData['invoice_startdate'][$value->schedule_id])){
                                $data = array(
                                    'invoice_date' =>date('Y-m-d', strtotime($postData['invoice_startdate'][$value->schedule_id])),
                                    'invoice_amount'  =>  $postData['invoice_amount'][$value->schedule_id],
                                    'invoice_comment'  =>  $postData['invoice_comment'][$value->schedule_id],
                                    'order_id'=>$inserted_order_id,
                                    'order_type' =>'MO',
                                    'status' =>  $postData['invoice_status_'.$value->schedule_id],

                                );
                                $this->common_model->insert(TBL_ORDER_INVOICE_SCHEDULE_MASTER, $data);

                            }
                        }*/
                    }

                    $upload_data = $this->multifiles_do_upload($inserted_order_id);
                    //echo "<pre>";
                    //print_r($upload_data);
                    //die;
                    if ($this->input->post('order_type') == "E") {
                        $where = array('order_id' => $this->input->post('order_id'));
                        $attachment_data = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('attach_id', 'attach_file_path', 'attach_file_name', 'attach_type'), $where);
                        if ($attachment_data) {
                            $financialYear = getCurrentFinancialYear();
                            foreach ($attachment_data as $attachment) {

                                if (isset($upload_data['existing'][$attachment->attach_id])) {
                                    $orderattachments = array(
                                        'order_id' => $inserted_order_id,
                                        'attach_file_name' => $upload_data['existing'][$attachment->attach_id]['file_name'],
                                        'attach_file_path' => $upload_data['existing'][$attachment->attach_id]['file_path'],
                                        'creation_date' => date('Y-m-d H:i:s', now()),
                                        'attach_type' => $this->input->post('invoice_doc')[$attachment->attach_id]
                                    );
                                    $this->common_model->insert(TBL_ORDER_ATTACHMENT_MASTER, $orderattachments);
                                } else {
                                    /*Only insert those record that come in post*/
                                    if (isset($postData['invoice_doc']) && array_key_exists($attachment->attach_id, $postData['invoice_doc'])) {
                                        $attach_file_path = rtrim($attachment->attach_file_path, '/');
                                        $source = $attach_file_path.DIRECTORY_SEPARATOR. $attachment->attach_file_name;
                                        //$destination = realpath('uploads') . DIRECTORY_SEPARATOR . 'orders' . DIRECTORY_SEPARATOR . $inserted_order_id . DIRECTORY_SEPARATOR . $attachment_data[$i]->attach_file_name;
                                        $uploadDirectory = realpath('uploads') . DIRECTORY_SEPARATOR . $financialYear . DIRECTORY_SEPARATOR . 'order_upload';
                                        $uploadDirectory = strtr(
                                                rtrim($uploadDirectory, '/\\'),
                                                '/\\',
                                                DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
                                            ) . DIRECTORY_SEPARATOR;
                                        $destinationDir = $uploadDirectory . $inserted_order_id . DIRECTORY_SEPARATOR;
                                        if (!is_dir($destinationDir)) {
                                            if (!mkdir($destinationDir, 0755, true)) {
                                                die('Failed to create upload directory...');
                                            }
                                        }
                                        $destinationFile = $destinationDir . $attachment->attach_file_name;
                                        copy($source, $destinationFile);
                                        $insert_data = array(
                                            'order_id' => $inserted_order_id,
                                            'attach_file_path' => $destinationDir,
                                            'attach_file_name' => $attachment->attach_file_name,
                                            'creation_date' => date('Y-m-d H:i:s', now()),
                                            'attach_type' => $attachment->attach_type
                                        );
                                        $this->common_model->insert(TBL_ORDER_ATTACHMENT_MASTER, $insert_data);
                                    }
                                }

                            }
                        }
                    }

                    /*Add New ADD MORE*/
                    if (isset($postData['file-upload-input'])) {
                        /*Insert agreement  information. */
                        $numFields = count($postData['file-upload-input']);

                        for ($i = 0; $i < $numFields; $i++) {

                            if (isset($upload_data['new']) && isset($upload_data['new'][$i]) && isset($upload_data['new'][$i]['file_name']) && !empty($upload_data['new'][$i]['file_name'])) {
                                $orderattachments = array(
                                    'order_id' => $inserted_order_id,
                                    'attach_file_name' => $upload_data['new'][$i]['file_name'],
                                    'attach_file_path' => $upload_data['new'][$i]['file_path'],
                                    'creation_date' => date('Y-m-d H:i:s', now()),
                                    'attach_type' => $this->input->post('add_invoice_doc')[$i]
                                );
                                $this->common_model->insert(TBL_ORDER_ATTACHMENT_MASTER, $orderattachments);
                            }
                        }
                    }

                    if ($this->input->post('order_type') == "N") {
                        $id = str_pad($inserted_order_id, 3, "0", STR_PAD_LEFT);
                        $project_name = $this->input->post('project_name');
                        $order_unique_id = array(
                            'order_unique_id' => "$project_name" . "/" . "$id",
                        );
                        $where = array('order_id' => $inserted_order_id);
                        $this->common_model->update(TBL_ORDER_MASTER, $order_unique_id, $where);
                    } else {

                        $id = str_pad($inserted_order_id, 3, "0", STR_PAD_LEFT);
                        $where = array('order_id' => $this->input->post('order_id'));
                        $data = $this->common_model->getRecord(TBL_ORDER_MASTER, 'order_unique_id', $where);

                        $order_unique_id = array(
                            'order_unique_id' => $data->order_unique_id . "/" . "$id",
                        );
                        $where = array('order_id' => $inserted_order_id);
                        $this->common_model->update(TBL_ORDER_MASTER, $order_unique_id, $where);
                    }

                    //Send Email Notification to respective Manager
                    $subject = "IMS: New Order Created";
                    $template = 'add-order-notification';
                    $orderDetail = $this->OrdersModel->getOrder($inserted_order_id);

                    $orderDetail->formattedOrderAmount = $orderDetail->currency_symbol . ' ' . formatAmount($orderDetail->order_amount);

                    $salesPerson = getClientSalesPersonInfo($orderDetail->sales_id);
                    if (is_object($salesPerson)) {
                        $orderDetail->sales_person_name = $salesPerson->sales_person_name;
                        $orderDetail->sales_contact_no = $salesPerson->sales_contact_no;
                        $orderDetail->sales_person_email = $salesPerson->sales_person_email;
                    }
                    $accountPerson = getClientAccountPersonInfo($orderDetail->account_id);
                    if (is_object($accountPerson)) {
                        $orderDetail->account_person_name = $accountPerson->account_person_name;
                        $orderDetail->account_contact_no = $accountPerson->account_contact_no;
                        $orderDetail->account_person_email = $accountPerson->account_person_email;
                    }

                    $techHeadDetail = getUserInfo($orderDetail->wd_tech_head_id);
                    $techHeadName = $techHeadDetail->first_name . " " . $techHeadDetail->last_name;
                    $techHeadEmail = $techHeadDetail->email;
                    $requestUser = getCurrentUser();
                    $requestBy = $requestUser->first_name . " " . $requestUser->last_name;
                    $templateData = array('order' => $orderDetail, 'user' => $techHeadName, 'requestBy' => $requestBy);
                    $cc = null;
                    if ($requestUser->is_approver) {
                        $approverId = $requestUser->approver_user_id;
                        $where = array('id' => $approverId);
                        $approverDetail = $this->common_model->getRecord(TBL_USER, array('email'), $where);
                        $cc = $approverDetail->email;
                    }
                    EmailUtility::sendEmail($techHeadEmail, $subject, $template, $templateData, null, $cc);
                    /*END EMAIL CODE*/

                    $this->session->set_flashdata('success', $this->lang->line('ORDER_SUCCESS'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('ORDER_ERROR'));
                }
                redirect('orders');
            } else {

            }
        }


        $where = array('status' => 1, 'is_order_category' => 1);
        $categories = $this->common_model->getRecords(TBL_CATEGORY_MASTER, array('id', 'category_name'), $where, 'category_name');
        $data = array('categories' => $categories);

        $where = array('status' => 1);
        $clientname = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id', 'client_name'), $where, 'client_name');
        $data['clientname'] = $clientname;

        $currencyname = $this->common_model->getRecords(TBL_CURRENCY_MASTER, array('currency_id', 'currency_name'));
        $data['currencyname'] = $currencyname;

        $where = array('is_technical_head' => 1,'status' => 'A');
        $wdtechnicalhead = $this->common_model->getRecords(TBL_USER, array('id', 'CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        $data['wdtechnicalhead'] = $wdtechnicalhead;

        $where = array('is_sales_person' => 1,'status' => 'A');
        $wdsalesperson = $this->common_model->getRecords(TBL_USER, array('id', 'CONCAT(first_name,\' \', last_name) as name'), $where, 'name');
        //var_dump($wdsalesperson);die;
        $data['wdsalesperson'] = $wdsalesperson;

        $paymentterm = $this->common_model->getRecords(TBL_PAYMENT_TERMS_MASTER, array('id', 'name'));
        $data['paymentterm'] = $paymentterm;

        $this->template->set('title', 'Create Order');
        $this->template->load('default', 'contents', 'default/orders/create_order', $data);
    }

    /*
   * projectExists
   * PURPOSE - To check project exists in database.
   * @Date -23/02/2018
   * @author - NJ
   */
    public function projectExists()
    {
        //selecting records from database .
        $where = array('project_name' => $this->input->post('project_name'));
        $query = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id', 'project_name'), $where);
        if (count($query) > 0) {
            echo 'false';
            die;

        } else {
            echo 'true';
            die;
        }

    }

    /*
    *  getClientByCategory
    * @purpose - To get client according to category selected..
    * @Date - 25/01/2018
    * @author - NJ
    */
    public function getClientByCategory()
    {
        if ($this->input->is_ajax_request()) {

            $category_id = $this->input->post('cat_id');
            $where = array('status' => 1, 'category_id' => $category_id);
            $clients = $this->common_model->getRecords(TBL_CLIENT_MASTER, array('client_id', 'client_name'), $where, 'client_name');

            $data = array('clientname' => $clients);
            $options = $this->load->view('default/clients/options_creator', $data, TRUE);
            echo $options;
            die;
        }
    }

    /*
    *  getInfoByClientId
    * @purpose - To get details according to client selected..
    * @Date - 02/02/2018
    * @author - NJ
    */
    public function getInfoByClient()
    {
        if ($this->input->is_ajax_request()) {
            $client = $this->input->post('client');
            if ($client) {
                $where = array('client_id' => $client, 'is_main_order' => 'Y', 'is_cancelled' => 'N');
                $projectname = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id', 'project_name'), $where, 'project_name');
                $data = array('projectname' => $projectname);
                $options = $this->load->view('default/orders/options_creator_projectname', $data, TRUE);
                $data['projectoptions'] = $options;

                $where = array('client_id' => $client);
                $agreementname = $this->common_model->getRecords(TBL_CLIENT_AGREEMENTS, array('agreement_id', 'agreement_name'), $where);
                $data['agreementname'] = $agreementname;
                $options = $this->load->view('default/orders/options_creator_agreementname', $data, TRUE);
                $data['agreementoptions'] = $options;

                $where = array('client_id' => $client);
                $clients = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, array('salesperson_id', 'sales_person_name'), $where, 'sales_person_name');
                $data['managername'] = $clients;
                $options = $this->load->view('default/orders/options_creator_manager', $data, TRUE);
                $data['manageroptions'] = $options;

                $where = array('client_id' => $client);
                $clients = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, array('account_id', 'account_person_name'), $where, 'account_person_name');
                $data['accountpersonname'] = $clients;
                $options = $this->load->view('default/orders/options_creator_account', $data, TRUE);
                $data['accountpersonoptions'] = $options;

                echo json_encode($data);

                die;
            } else {
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    /*
    *  getManagerInfoByManagerName
    * @purpose - To get Manager Info according to Manager Name selected..
    * @Date - 25/01/2018
    * @author - NJ
    */
    public function getManagerInfoByManagerName()
    {
        if ($this->input->is_ajax_request()) {
            $salesId = $this->input->post('salesId');
            if ($salesId) {

                $where = array('salesperson_id' => $salesId);
                $salespersonsdetails = $this->common_model->getRecords(TBL_CLIENT_SALESPERSON, array('salesperson_id', 'sales_person_name', 'sales_contact_no', 'sales_person_email', 'CONCAT(sales_person_address," ", IFNULL(sales_person_address2, "") ) as sales_person_address'), $where );
                $data['salespersonsdetails'] = $salespersonsdetails;
                echo json_encode($data);
                die;
            } else {
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    /*
    *  getAccountInfoByAccountName
    * @purpose - To get Account Info according to Account Name selected..
    * @Date - 25/01/2018
    * @author - NJ
    */
    public function getAccountInfoByAccountName()
    {
        if ($this->input->is_ajax_request()) {
            $accountId = $this->input->post('accountId');
            if ($accountId) {
                $where = array('account_id' => $accountId);
                $accountpersonsdetails = $this->common_model->getRecords(TBL_CLIENT_ACCOUNTPERSON, array('account_id', 'account_person_name', 'account_contact_no', 'account_person_email'), $where, 'account_person_name');
                $data['accountpersonsdetails'] = $accountpersonsdetails;

                echo json_encode($data);
                die;
            } else {
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    /*
   *  getDetailsByProjectName
   * @purpose - To get details according to project Name selected..
   * @Date - 25/01/2018
   * @author - NJ
   */
    public function getDetailsByProjectName()
    {
        if ($this->input->is_ajax_request()) {
            $projectDetails = $this->input->post('projectDetails');
            if ($projectDetails) {
                $where = array('order_id' => $projectDetails);
                $projectinfo = $this->common_model->getRecords(TBL_ORDER_MASTER, array('order_id', 'project_description', 'wd_sales_person_id', 'wd_tech_head_id', 'po_no', 'DATE_FORMAT(po_date, "%d-%b-%Y") as po_date', 'po_dtl', 'payment_term'), $where);
                $data = array('projectinfo' => $projectinfo);


                $where = array('order_id' => $projectDetails);
                $attachmentinfo = $this->common_model->getRecords(TBL_ORDER_ATTACHMENT_MASTER, array('attach_id', 'attach_file_path', 'attach_file_name', 'attach_type'), $where);
                $data['attachmentinfo'] = $attachmentinfo;

                $where = array('order_id' => $projectDetails);

                $invoicescheduleinfo = $this->common_model->getRecords(TBL_ORDER_INVOICE_SCHEDULE_MASTER, array('DATE_FORMAT(invoice_date, "%d-%b-%Y") as invoice_date', 'invoice_amount', 'invoice_comment', 'schedule_id', 'status'), $where);

                $data['invoicescheduleinfo'] = $invoicescheduleinfo;

                echo json_encode($data);
                die;
            } else {
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }
}

