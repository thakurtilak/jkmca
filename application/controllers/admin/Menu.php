<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        // load form_validation library
        $this->load->library('form_validation');
        if(!$this->session->userdata('systemAdmin'))
        {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $menuList = $this->common_model->getRecords(TBL_MENU_MASTER);
        $data = array('menuList'=> $menuList);

        $this->template->set('title', 'Menu Management');
        $this->template->load('admin', 'contents' , 'admin/menu/list',$data);
    }

    /*
     * add - Menu Aff Action
     * Auther - Webdunia
     */
    public function add()
    {
        $postData = $this->input->post();
        if($postData) {
            $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
            $this->form_validation->set_rules('display_name', 'Display Name' , 'trim|required');
            $this->form_validation->set_rules('menu_description', 'Menu Description', 'trim|required');
            $this->form_validation->set_rules('redirect_url', 'URL' , 'trim|required');
            $this->form_validation->set_rules('menu_type', 'Menu Type' , 'required');
            $this->form_validation->set_rules('is_display', 'Menu Display' , 'required');
            $this->form_validation->set_rules('is_active', 'Is Active' , 'required');
            if ($this->form_validation->run()) {
                $menu_name = $postData['menu_name'];
                $where = array(
                    'menu_name' => $menu_name
                );
                $menuRecord = $this->common_model->getRecord(TBL_MENU_MASTER, 'menu_id', $where);
                if(!$menuRecord){

                    $dataArray = array(
                        'menu_name' => $postData['menu_name'],
                        'display_name' => $postData['display_name'],
                        'menu_description' => $postData['menu_description'],
                        'redirect_url' => $postData['redirect_url'],
                        'menu_type' => $postData['menu_type'],
                        'has_submenu' => ($postData['menu_type'] == 'Parent')? 'Y':'N',
                        'is_display' => isset($postData['is_display']) ? $postData['is_display']: 'N',
                        'is_active' => isset($postData['is_active']) ? $postData['is_active']: 'N'
                    );

                    if($postData['menu_type'] == 'Child' && $postData['parent_id']) {
                        $dataArray['parent_id'] =  $postData['parent_id'];
                    }

                    $menuId = $this->common_model->insert(TBL_MENU_MASTER, $dataArray);
                    if($menuId) {
                        $menuParentId = ($postData['menu_type'] == 'Child') ? $postData['parent_id'] : 0;
                        //get display order
                        $displayOrder = $this->common_model->getRecord(TBL_MENU_MAPPER, array("MAX(display_order) as menuOrder"), array('menu_id' => $menuParentId));
                        $menuMapperData = array (
                            "menu_id" => ($menuParentId == '0') ? '0' : $menuParentId,
                            "submenu_id" => $menuId,
                            "menu_parent_id" => ($menuParentId == '0') ? '0' : '1',
                            "submenu_type" => $postData['menu_type'],
                            "set_redirect_url" => 'N',
                            "display_order" => ($displayOrder) ? ++ $displayOrder->menuOrder : 1
                        );
                        $this->common_model->insert(TBL_MENU_MAPPER, $menuMapperData);
                        $this->session->set_flashdata('success', 'Menu added successfully');
                        redirect('admin/menu');
                    } else{
                        $this->session->set_flashdata('error', 'There is an error while adding Menu. Please try again');
                    }
                    redirect('admin/menu');
                } else {
                    $this->session->set_flashdata('error', 'Menu id Already Exist');
                }

            } else {
                $this->session->set_flashdata('error',validation_errors());
            }
        }
        //Get Parent Menus
        $parentMenus = $this->common_model->getRecords(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('menu_type'=> 'Parent','is_active'=> 'Y'));

        $data = array('parentMenus' => $parentMenus);

        $this->template->set('title', 'Menu Management');
        $this->template->load('admin', 'contents' , 'admin/menu/add',$data);
    }

    /*
     * edit - Menu Edit Action
     * Auther - Webdunia
     */
    public function edit($id)
    {
        if($id){
            $menu = $this->common_model->getRecord(TBL_MENU_MASTER, array('*'), array('menu_id'=> $id));
            if($menu){
                //POST
                $postData = $this->input->post();
                if($postData) {
                    $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
                    $this->form_validation->set_rules('display_name', 'Display Name' , 'trim|required');
                    $this->form_validation->set_rules('menu_description', 'Menu Description', 'trim|required');
                    $this->form_validation->set_rules('redirect_url', 'URL' , 'trim|required');
                    $this->form_validation->set_rules('menu_type', 'Menu Type' , 'required');
                    $this->form_validation->set_rules('is_display', 'Menu Display' , 'required');
                    $this->form_validation->set_rules('is_active', 'Is Active' , 'required');
                    if ($this->form_validation->run()) {
                        $menu_name = $postData['menu_name'];
                        $where = array(
                            'menu_name' => $menu_name,
                            'menu_id !=' => $id
                        );
                        $existRecord = $this->common_model->getRecord(TBL_MENU_MASTER, 'menu_id', $where);
                        if(!$existRecord){

                            $dataArray = array(
                                'menu_name' => $postData['menu_name'],
                                'display_name' => $postData['display_name'],
                                'menu_description' => $postData['menu_description'],
                                'redirect_url' => $postData['redirect_url'],
                                'menu_type' => $postData['menu_type'],
                                'has_submenu' => ($postData['menu_type'] == 'Parent')? 'Y':'N',
                                'is_display' => isset($postData['is_display']) ? $postData['is_display']: 'N',
                                'is_active' => isset($postData['is_active']) ? $postData['is_active']: 'N'
                            );

                            if($postData['menu_type'] == 'Child' && $postData['parent_id']) {
                                $dataArray['parent_id'] =  $postData['parent_id'];
                            }

                            $isUpdate = $this->common_model->update(TBL_MENU_MASTER, $dataArray, array('menu_id'=> $id));
                            if($isUpdate) {
                                //Also Update Menu mapper table
                                $menuParentId = ($postData['menu_type'] == 'Child') ? $postData['parent_id'] : 0;
                                $deleted = $this->common_model->delete(TBL_MENU_MAPPER, array('submenu_id' => $id));
                                if ($deleted) {
                                    //get display order
                                    $displayOrder = $this->common_model->getRecord(TBL_MENU_MAPPER, array("MAX(display_order) as menuOrder"), array('menu_id' => $menuParentId));
                                    $menuMapperData = array(
                                        "menu_id" => ($menuParentId == '0') ? '0' : $menuParentId,
                                        "submenu_id" => $id,
                                        "menu_parent_id" => ($menuParentId == '0') ? '0' : '1',
                                        "submenu_type" => $postData['menu_type'],
                                        "set_redirect_url" => 'N',
                                        "display_order" => ($displayOrder) ? ++$displayOrder->menuOrder : 1
                                    );

                                    $this->common_model->insert(TBL_MENU_MAPPER, $menuMapperData);
                                }
                            }
                            $this->session->set_flashdata('success', 'Menu updated successfully');
                            redirect('admin/menu');
                        } else {
                            $this->session->set_flashdata('error', 'Menu is Already Exist');
                        }

                    } else {
                        $this->session->set_flashdata('error',validation_errors());
                    }
                }
                //END POST
                //Get Parent Menus
                $parentMenus = $this->common_model->getRecords(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('menu_type'=> 'Parent','is_active'=> 'Y'));

                $data = array('menu' => $menu, 'parentMenus' => $parentMenus);
                $this->template->set('title', 'Menu Management');
                $this->template->load('admin', 'contents' , 'admin/menu/add',$data);
            } else {
                redirect('admin/menu');
            }
        } else {
            redirect('admin/menu');
        }
    }

    /*
     * Primary menu Assignment to Role
     */
    public function Menu_assignment($roleId = '') {

        $postData = $this->input->post();
       // print_r($postData);
        if($postData) {
            $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
            $this->form_validation->set_rules('targetParentMenus[]', 'Menus' , 'trim|required');
            if ($this->form_validation->run()) {
                //print_r($postData); die;
                $roleId = $postData['role_id'];
                $menus  = $postData['targetParentMenus'];
                $this->common_model->delete(TBL_ROLE_MENU, array('role_id' => $roleId));
                if(is_array($menus)) {
                    $displayOrder = 1;
                    $menuMasterData = array();
                    foreach($menus as $item) {
                        $menuRoleMapper = array(
                            'role_id' => $roleId,
                            'menu_id' => $item,
                            "submenu_id" => '0',
                            'display_order' => $displayOrder,
                        );
                        $menuMasterData[] = $menuRoleMapper;
                        $displayOrder++;
                    }
                    $insertId = $this->common_model->insertMultiple(TBL_ROLE_MENU, $menuMasterData);
                    if($insertId) {
                        $this->session->set_flashdata('success','Menu assigned successfully.');
                    } else {
                        $this->session->set_flashdata('error','Error while assigning menu.');
                    }
                }
            } else {
                $this->session->set_flashdata('error',validation_errors());
            }
            //redirect('admin/menu/menu-assignment');
        }

        //Get All Roles
        $allRoles = $this->common_model->getRecords(TBL_ROLE_MASTER, array('id', 'role_name'), array('status'=> 'A'));
        $allParentMenus = $this->common_model->getRecords(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('menu_type'=> 'Parent','is_active'=> 'Y'));

        $data = array('allRoles' => $allRoles, 'allParentMenus' => $allParentMenus);
        if(isset($roleId)) {

            $selectedRole = $this->common_model->getRecord(TBL_ROLE_MASTER, array('id', 'role_name'), array('status'=> 'A', 'id' => $roleId));
            $allSelectedRoleMenus = $this->common_model->getRecords(TBL_ROLE_MENU, array('menu_id', 'display_order'), array('role_id'=> $roleId));
            $selectedRoleMenus = array();
            if($allSelectedRoleMenus) {
                foreach($allSelectedRoleMenus as $items) {
                    $selectedRoleMenus[] = $items->menu_id;
                }
            }
            $data['selectedRole'] = $selectedRole;
            $data['selectedRoleMenus'] = $selectedRoleMenus;
        }

        $this->template->set('title', 'Menu Management');
        $this->template->load('admin', 'contents' , 'admin/menu/menu_assignment',$data);
    }


    /*
     * Submenu Assignment to Role
     */
    public function Submenu_assignment($roleId = '', $menuId = '') {

        $postData = $this->input->post();
        // print_r($postData);
        if($postData) {
            $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
            $this->form_validation->set_rules('pmenu_id', 'Primary Menu', 'trim|required');
            $this->form_validation->set_rules('targetMenus[]', 'Sub Menus' , 'trim|required');
            if ($this->form_validation->run()) {
                //print_r($postData); die;
                $roleId = $postData['role_id'];
                $menuId = $postData['pmenu_id'];
                $menus  = $postData['targetMenus'];
                $this->common_model->delete(TBL_ROLE_SUBMENU, array('role_id' => $roleId, 'menu_id' => $menuId));
                if(is_array($menus)) {
                    $displayOrder = 1;
                    $menuMasterData = array();
                    foreach($menus as $item) {
                        $menuRoleMapper = array(
                            'role_id' => $roleId,
                            'menu_id' => $menuId,
                            "submenu_id" => $item,
                            'display_order' => $displayOrder,
                        );
                        $menuMasterData[] = $menuRoleMapper;
                        $displayOrder++;
                    }
                    $insertId = $this->common_model->insertMultiple(TBL_ROLE_SUBMENU, $menuMasterData);
                    if($insertId) {
                        $this->session->set_flashdata('success','Menu assigned successfully.');
                    } else {
                        $this->session->set_flashdata('error','Error while assigning sub menu.');
                    }
                }
            } else {
                $this->session->set_flashdata('error',validation_errors());
            }
            //redirect('admin/menu/menu-assignment');
        }

        //Get All Roles
        $allRoles = $this->common_model->getRecords(TBL_ROLE_MASTER, array('id', 'role_name'), array('status'=> 'A'));
        $allParentMenus = $this->common_model->getRecords(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('menu_type'=> 'Parent','is_active'=> 'Y'));

        $data = array('allRoles' => $allRoles, 'allParentMenus' => $allParentMenus);
        if(isset($roleId)) {

            $selectedRole = $this->common_model->getRecord(TBL_ROLE_MASTER, array('id', 'role_name'), array('status'=> 'A', 'id' => $roleId));
            $allSelectedRoleMenus = $this->common_model->getRecords(TBL_ROLE_MENU, array('menu_id', 'display_order'), array('role_id'=> $roleId), '', 0, 'display_order');
           // $selectedRoleMenus = array();
            $allSelectedPrimaryMenus = array();
            if($allSelectedRoleMenus) {
                foreach($allSelectedRoleMenus as $items) {
                    $allSelectedPrimaryMenus[] = $this->common_model->getRecord(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('is_active'=> 'Y', 'menu_id' => $items->menu_id));
                    //$selectedRoleMenus[] = $items->menu_id;
                }
            }

            //If also Choose Primary Menu
            if(isset($menuId)) {
                $selectedPMenu = $this->common_model->getRecord(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('is_active'=> 'Y', 'menu_id' => $menuId));
                $subMenuData = $this->common_model->getRecords(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('is_active'=> 'Y', 'menu_type'=> 'Child', 'parent_id' => $menuId));
                $selectedsubMenus = $this->common_model->getRecords(TBL_ROLE_SUBMENU, array('submenu_id'), array('role_id'=> $roleId, 'menu_id' => $menuId), '', 0, 'display_order');
                $allSelectedSubMenus = array();
                $allSelectedSubMenusDetails = array();
                if($selectedsubMenus) {
                    foreach($selectedsubMenus as $items) {
                        $allSelectedSubMenusDetails[] = $this->common_model->getRecord(TBL_MENU_MASTER, array('menu_id', 'display_name'), array('is_active'=> 'Y', 'menu_id' => $items->submenu_id));
                        $allSelectedSubMenus[] = $items->submenu_id;
                    }
                }
            }

            //print_r($allSelectedSubMenus);
            $data['selectedRole'] = $selectedRole;
            $data['selectedPMenu'] = $selectedPMenu;
            $data['subMenuData'] = $subMenuData;
            $data['allSelectedPrimaryMenus'] = $allSelectedPrimaryMenus;
            $data['allSelectedSubMenus'] = $allSelectedSubMenus;
            $data['allSelectedSubMenusDetails'] = $allSelectedSubMenusDetails;
        }

        $this->template->set('title', 'Menu Management');
        $this->template->load('admin', 'contents' , 'admin/menu/submenu_assignment',$data);
    }


}
