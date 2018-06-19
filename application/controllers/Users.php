<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User');
        $this->load->model('common_model');
        $this->load->model('admin_model');
        $this->load->library('form_validation');
        $this->load->library('emailUtility');
        if(!isLoggedIn())
        {
            redirect('login');
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
            $role_id = $this->input->get('role_id');
            $status = $this->input->get('status');
            switch ($orderField) {
                case 1 :
                    $orderColumn = "first_name";
                    break;
                case 2 :
                    $orderColumn = "last_name";
                    break;
                case 3 :
                    $orderColumn = "email";
                    break;
                case 4 :
                    $orderColumn = "role_id";
                    break;
                case 5 :
                    $orderColumn = "is_manager";
                    break;
                case 6 :
                    $orderColumn = "is_sales_person";
                    break;
                case 7 :
                    $orderColumn = "status";
                    break;
                default:
                    $orderColumn = "first_name";
            }

            $orderBY = $orderColumn . " " . $direction;

            $userList = $this->User->listuser($role_id, $status, $searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->User->count_all_user();
            $recordsFiltered = $this->User->listuser($role_id, $status, $searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($userList) {
                $s_no = $start +1;
                foreach ($userList as $row) {
                    $actionLink = '<a href="'. site_url("users/edit/".$row->id).'" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" title="Edit"><i class=\'icon-edit\'></i></a>';
                    $tempData = array(
                        "s_no" => $s_no,
                        "first_name" => $row->first_name,
                        "last_name" => $row->last_name,
                        'email' =>  $row->email,
                        'role_name' => $row->role_name,
                        "status" => ($row->status == 'A')? 'Yes':'No',
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
        $where = array('status' => 'A');
        $roles = $this->common_model->getRecords(TBL_ROLE_MASTER, array('*'), $where);
        $data = array('roles'=> $roles);

        $this->template->set('title', 'User Management');
        $this->template->load('default', 'contents' , 'default/users/userlist',$data);
    }

    public function add()
    {
        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('first_name', 'FirstName', 'trim|required');
            $this->form_validation->set_rules('last_name', 'LastName' , 'trim|required');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required');
            $this->form_validation->set_rules('user_role', 'Role' , 'trim|required');
            $this->form_validation->set_rules('status', 'Is Active' , 'required');
            if (filter_var($postData['email_id'], FILTER_VALIDATE_EMAIL)) {

                if ($this->form_validation->run()) {
                    $email = $postData['email_id'];
                    $where = array(
                        'email' => $email
                    );
                    $userRecord = $this->common_model->getRecord(TBL_USER, 'id', $where);
                    if (!$userRecord) {
                        $roles = $postData['user_role'];
                        $password = $this->_randomPassword();
                        $dataArray = array(
                            'role_id' => $roles,
                            'first_name' => $postData['first_name'],
                            'last_name' => $postData['last_name'],
                            'email' => $postData['email_id'],
                            'password' => md5($password),
                            'status' => $postData['status'],
                            'created_date' => date('Y-m-d H:i:s')
                        );

                        $userId = $this->common_model->insert(TBL_USER, $dataArray);
                        if ($userId) {

                            /*Send Email notification to User*/
                            $to = array();
                            $to[] = $postData['email_id'];
                            $subject = "Welcome To JKM Associates";
                            $template = 'user-add-notification';
                            $user = (object)$dataArray;
                            $user->full_name = ucwords($user->first_name . ' ' . $user->last_name);
                            $templateData = array('password' => $password, 'user' => $user);
                            EmailUtility::sendEmail($to, $subject, $template, $templateData);
                            /*END EMAIL CODE*/
                            $this->session->set_flashdata('success', 'User added successfully');
                            redirect('users');
                        } else {
                            $this->session->set_flashdata('error', 'There is an error while adding user. Please try again');
                        }
                        redirect('users');
                    } else {
                        $this->session->set_flashdata('error', 'Email id Already Exist');
                        redirect('users/add');
                    }
                } else {
                    $this->session->set_flashdata('error',validation_errors());
                }
            } else {
                //echo "EMAIL FAIL"; die;
                $this->session->set_flashdata('error','Invalid email address');
                redirect('users/add');
            }
        }
        $roles = $this->User->getRole();

        //print_r($managers);
        $data = array('roles'=>$roles);

        $this->template->set('title', 'User Management');
        $this->template->load('default', 'contents' , 'default/users/create_user',$data);
    }

    public function edit($id)
    {
        if($id){
            $user = $this->common_model->getRecord(TBL_USER, array('*'), array('id'=> $id));
            if($user){
                //POST
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('first_name', 'FirstName', 'trim|required');
                    $this->form_validation->set_rules('last_name', 'LastName' , 'trim|required');
                    $this->form_validation->set_rules('email_id', 'Email', 'trim|required');
                    $this->form_validation->set_rules('user_role', 'Role' , 'trim|required');
                    $this->form_validation->set_rules('status', 'Is Active' , 'required');
                    if (filter_var($postData['email_id'], FILTER_VALIDATE_EMAIL)) {
                        if ($this->form_validation->run()) {
                            $email = $postData['email_id'];
                            $where = array(
                                'email' => $email,
                                'id !=' => $id
                            );
                            $existRecord = $this->common_model->getRecord(TBL_USER, 'id', $where);
                            if (!$existRecord) {
                                $roles = $postData['user_role'];
                                $dataArray = array(
                                    'role_id' => $roles,
                                    'first_name' => $postData['first_name'],
                                    'last_name' => $postData['last_name'],
                                    'email' => $postData['email_id'],
                                    'status' => $postData['status'],
                                );
                                $this->common_model->update(TBL_USER, $dataArray, array('id' => $id));
                                $this->session->set_flashdata('success', 'User updated successfully');
                                redirect('users');
                            } else {
                                $this->session->set_flashdata('error', 'Email id Already Exist');
                                redirect('users/edit/' . $id);
                            }

                        } else {
                            //$this->session->set_flashdata('error',validation_errors());
                        }
                    } else {
                        $this->session->set_flashdata('error','Invalid email address');
                        redirect('users/edit/' . $id);
                    }
                }
                //END POST

                $roles = $this->User->getRole();

                $data = array('user' => $user, 'roles'=> $roles);

                $this->template->set('title', 'User Management');
                $this->template->load('default', 'contents' , 'default/users/create_user',$data);
            } else {
                redirect('users');
            }
        } else {
            redirect('users');
        }
    }

    private function _randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /*
     * assign_category
     * URL - Admin/users/assign-category
     * Purpose - Responsible to assign category to generator
     */
    public function assign_category($userId=''){
        $data = [];
        $postData = $this->input->post();
        // print_r($postData);
        if($postData) {
            $this->form_validation->set_rules('user_id', 'User', 'trim|required');
            $this->form_validation->set_rules('targetParentCategory[]', 'Categories' , 'trim|required');
            if ($this->form_validation->run()) {
                //print_r($postData); die;
                $user_id = $postData['user_id'];
                $categories  = $postData['targetParentCategory'];
                $this->common_model->delete(TBL_INVOICE_CATEGORY_GEN_MAPPER, array('generator_user_id' => $user_id));
                if(is_array($categories)) {
                    $catMasterData = array();
                    foreach($categories as $item) {
                        $genCatMapper = array(
                            'generator_user_id' => $user_id,
                            'category_id' => $item,
                        );
                        $catMasterData[] = $genCatMapper;
                    }
                    $insertId = $this->common_model->insertMultiple(TBL_INVOICE_CATEGORY_GEN_MAPPER, $catMasterData);
                    if($insertId) {
                        $this->session->set_flashdata('success','Category assigned successfully.');
                    } else {
                        $this->session->set_flashdata('error','Error while assigning category.');
                    }
                }
            } else {
                $this->session->set_flashdata('error',validation_errors());
            }
            //redirect('admin/users/assign-category');
            redirect( current_url());

        }
        if(isset($userId) && $userId) {
            $allSelectedCategory = $this->admin_model->getRecords(TBL_INVOICE_CATEGORY_GEN_MAPPER, array('category_id', 'generator_user_id'), array('generator_user_id'=> $userId));
            $selectedCategories = array();
            if($allSelectedCategory) {
                foreach($allSelectedCategory as $items) {
                    $selectedCategories[] = $items->category_id;
                }
            }
            $data['selectedUser'] = $userId;
            $data['selectedCategories'] = $selectedCategories;
        }
        $where = "FIND_IN_SET( '".GENERATERROLEID."' , role_id) AND status = 'A' AND is_approver IS NOT NULL";
        $allUsers = $this->admin_model->getRecords(TBL_USER, array('id', 'CONCAT(first_name, " ", last_name) as name'), $where);
        $data['allUsers'] = $allUsers;

        //Get Order category
        $where = array('status' => 1,'parent_id' =>0,'is_service_category'=>0);
        $categories = $this->admin_model->getRecords(TBL_CATEGORY_MASTER, array('id','category_name'), $where,'category_name');
        $data['categories'] = $categories;
        $this->template->set('title', 'User Management');
        $this->template->load('admin', 'contents' , 'admin/users/assign_category',$data);
    }


}
