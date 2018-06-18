<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{

    /**
     * Category controller.
     * Purpose - To Add Category
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('common_model');
        $this->load->model('admin_model');

        if(!$this->session->userdata('systemAdmin'))
        {
            redirect('admin/login');
        }
    }

    /*
     * index
     * URL - admin/category
     */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $orderField = $this->input->get('order[0][column]');
            $direction = $this->input->get('order[0][dir]');
            $searchKey = $this->input->get('search[value]');
            $type = ($this->input->get('type')) ? $this->input->get('type') : 1;
            switch ($orderField) {
                case 1 :
                    $orderColumn = "category_name";
                    break;
                case 2 :
                    $orderColumn = "is_service_category";
                    break;
                case 3 :
                    $orderColumn = "is_order_category";
                    break;
                case 4 :
                    $orderColumn = "status";
                    break;
                default:
                    $orderColumn = "category_name";
            }

            $orderBY = $orderColumn . " " . $direction;

            $categoryList = $this->admin_model->listCategory($type, $searchKey, $orderBY, $start, $length);
            $recordsTotal = $this->admin_model->count_all_category();
            $recordsFiltered = $this->admin_model->listCategory($type, $searchKey, $orderBY, $start, $length, true);

            $draw = $this->input->get('draw');
            $data = array();
            if ($categoryList) {
                $s_no = $start +1;
                foreach ($categoryList as $row) {
                    $actionLink = '<a href="'. site_url("admin/category/edit/".$row->id).'" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Edit</a>';
                    $tempData = array(
                        "s_no" => $s_no,
                        "category_name" => $row->category_name,
                        "is_service_category" => ($row->is_service_category)? 'Yes':'No',
                        'is_order_category' =>  ($row->is_order_category)? 'Yes':'No',
                        'status' =>  ($row->status)? 'Yes':'No',
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

        $data = array();

        $this->template->set('title', 'Category Management');
        $this->template->load('admin', 'contents' , 'admin/category/index',$data);

    }

    /*add Category*/
    public function add(){

        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
            $this->form_validation->set_rules('is_service_category', 'Is Service Category', 'required|trim');
            if($postData['is_service_category'] == 0) {
                $this->form_validation->set_rules('is_order_category', 'Is Order Category', 'required|trim');
                $this->form_validation->set_rules('parent_category', 'Is Main Category', 'required|trim');
            }

            if(isset($postData['parent_category']) && $postData['parent_category'] == 0) {
                $this->form_validation->set_rules('parent_id', 'Parent Category', 'required|trim');
            }

            if ($this->form_validation->run()) {

                if($postData['is_service_category'] == 1) {
                    $postData['is_order_category'] = 0;
                    $postData['parent_id'] = 0;
                }

                if(isset($postData['parent_category']) && $postData['parent_category'] == 1) {
                    $postData['parent_id'] = 0;
                }
                if(isset($postData['parent_category'])) {
                    unset($postData['parent_category']);
                }
                $postData['created_date'] = date('Y-m-d H:i:s');
                unset($postData['Submit']);

                $isInserted = $this->common_model->insert(TBL_CATEGORY_MASTER, $postData);
                if($isInserted) {
                    $this->session->set_flashdata('success', 'Category added successfully');
                    redirect('admin/category');
                } else{
                    $this->session->set_flashdata('error', 'There is an error while adding Category. Please try again');
                    redirect('admin/category');
                }
            }
        }

        $where= array('status' => 1,'parent_id' => 0, 'is_service_category'=> 0);
        $parentCategory = $this->common_model->getRecords(TBL_CATEGORY_MASTER,'id, category_name',$where, 'category_name');

        $data = array('parentCategory' => $parentCategory);

        $this->template->set('title', 'Add Category');
        $this->template->load('admin', 'contents' , 'admin/category/add',$data);
    }

    /*Edit Category*/
    public function edit($id = false) {
        if($id){
            $where =  array('id' => $id);
            $currency = $this->common_model->getRecord(TBL_CATEGORY_MASTER, array('*'), $where);
            if($currency) {
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
                    $this->form_validation->set_rules('is_service_category', 'Is Service Category', 'required|trim');
                    if($postData['is_service_category'] == 0) {
                        $this->form_validation->set_rules('is_order_category', 'Is Order Category', 'required|trim');
                        $this->form_validation->set_rules('parent_category', 'Is Main Category', 'required|trim');
                    }

                    if(isset($postData['parent_category']) && $postData['parent_category'] == 0) {
                        $this->form_validation->set_rules('parent_id', 'Parent Category', 'required|trim');
                    }

                    if ($this->form_validation->run()) {
                        if($postData['is_service_category'] == 1) {
                            $postData['is_order_category'] = 0;
                            $postData['parent_id'] = 0;
                        }

                        if(isset($postData['parent_category']) && $postData['parent_category'] == 1) {
                            $postData['parent_id'] = 0;
                        }
                        if(isset($postData['parent_category'])) {
                            unset($postData['parent_category']);
                        }
                        unset($postData['Submit']);
                        $postData['modified_date'] = date('Y-m-d H:i:s');

                        $this->common_model->update(TBL_CATEGORY_MASTER, $postData, $where);
                        $this->session->set_flashdata('success', 'Currency updated successfully');
                        redirect('admin/category');
                    }
                }

                $where= array('status' => 1,'parent_id' => 0, 'is_service_category'=> 0);
                $parentCategory = $this->common_model->getRecords(TBL_CATEGORY_MASTER,'id, category_name',$where, 'category_name');

                $data = array('category' => $currency, 'parentCategory'=> $parentCategory);
                $this->template->set('title', 'Edit Category');
                $this->template->load('admin', 'contents' , 'admin/category/add',$data);

            } else{
                redirect('admin/category');
            }
        } else {
            redirect('admin/category');
        }
    }
}