<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_left_menu')){

    function get_left_menu($userID, $role_id){
        //get main CodeIgniter object
        $ci =& get_instance();

        //load database library
        $ci->load->database();

        $ci->db->select(array('DISTINCT(t2.menu_id), t2.*, t1.display_order'));
        //$ci->db->group_by('t2.menu_id');
        $ci->db->from(TBL_ROLE_MENU.' as t1');
        $ci->db->join(TBL_MENU_MASTER.' as t2','t2.menu_id = t1.menu_id');
        //$ci->db->where(array('t1.role_id' => $role_id));
        $ci->db->where('t1.role_id IN('.$role_id.')');
        $ci->db->where(array('t2.is_active' => 'Y'));
        $ci->db->where(array('t2.is_display' => 'Y'));
        $ci->db->order_by('t1.display_order', 'ASC');
        $query = $ci->db->get();
        //echo $ci->db->last_query(); die;
        $ParentMenus =  $query->result();
        //print_r($ParentMenus);
        if($ParentMenus) {
            $temp = array();
            foreach($ParentMenus as $key => $menuDetail){

                if(in_array($menuDetail->menu_id, $temp)) {
                    unset($ParentMenus[$key]);
                    continue;
                }
                $ci->db->select(array('DISTINCT(t2.menu_id), t2.*'));
                $ci->db->from(TBL_ROLE_SUBMENU.' as t1');
                $ci->db->join(TBL_MENU_MASTER.' as t2','t2.menu_id = t1.submenu_id');
                //$ci->db->where(array('t1.role_id' => $role_id));
                $ci->db->where('t1.role_id IN('.$role_id.')');
                $ci->db->where(array('t1.menu_id' => $menuDetail->menu_id));
                $ci->db->where(array('t2.is_active' => 'Y'));
                $ci->db->where(array('t2.is_display' => 'Y'));
                $ci->db->order_by('t1.display_order', 'ASC');
                $query2 = $ci->db->get();
                //echo $ci->db->last_query();
                $subMenus =  $query2->result();
                $menuDetail->submenuList = $subMenus;
                $temp[] = $menuDetail->menu_id;
            }
        }
        //print_r($ParentMenus);die;
        return $ParentMenus;
    }


    function get_All_menu(){
        //get main CodeIgniter object
        $ci =& get_instance();

        //load database library
        $ci->load->database();

        $ci->db->select(array('t1.*'));
        $ci->db->from(TBL_MENU_MASTER.' as t1');
        $ci->db->where(array('t1.menu_type' => 'Parent'));
        $query = $ci->db->get();
        $ParentMenus =  $query->result();

        if($ParentMenus) {
            foreach($ParentMenus as $menuDetail){

                $ci->db->select(array('t2.*'));
                $ci->db->from(TBL_ROLE_SUBMENU.' as t1');
                $ci->db->join(TBL_MENU_MASTER.' as t2','t2.menu_id = t1.submenu_id');
                $ci->db->where(array('t1.menu_id' => $menuDetail->menu_id));
                //$ci->db->where(array('t2.is_active' => 'Y'));
                //$ci->db->where(array('t2.is_display' => 'Y'));
                $ci->db->order_by('t1.display_order', 'ASC');
                $query2 = $ci->db->get();
                //echo $this->db->last_query(); die;
                $subMenus =  $query2->result();
                $menuDetail->submenuList = $subMenus;
            }
        }
        return $ParentMenus;
    }
}