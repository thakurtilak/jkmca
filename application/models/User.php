<?php

class User extends CI_Model
{
    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * @author Webdunia
     * TimeStamp : 15.May.2017(4.00 PM)
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function getRole()
    {
        $this->db->select('id, role_name');
        $this->db->from('ims_role_master');
        $this->db->where(array('status'=>'A'));

        $query = $this->db->get();

        return $query->result();
    }


    function listuser($role_id = '', $status = '',$searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false)
    {

        $this->db->select('*');
        $this->db->from(TBL_USER);

        if($role_id) {
            $where = "FIND_IN_SET( '".$role_id."' , role_id)";
            $this->db->where($where);
            //$this->db->where('role_id', $role_id);
        }
        $this->db->where('id >', 1); //For DS email
        if($status) {
            $this->db->where('status', $status);
        }

        if($searchKey){
            $this->db->group_start();
            $this->db->like('first_name', $searchKey);
            $this->db->or_like('last_name',$searchKey);
            $this->db->or_like('email',$searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('first_name DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $this->db->limit($limitLength, $limitStart);
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            $users =  $query->result();

            if($users) {
                foreach($users as $user) {
                    $roleIds = explode(',', $user->role_id);
                    $this->db->select('role_name');
                    $this->db->from(TBL_ROLE_MASTER);
                    $this->db->where_in('id', $roleIds);
                    $subquery = $this->db->get();
                    $roles =  $subquery->result();
                    $roleName = '';
                    if($roles){
                        foreach($roles as $rl) {
                            if($roleName) {
                                $roleName .= ' , ';
                            }
                            $roleName .= $rl->role_name;

                        }
                    }
                    $user->role_name = rtrim($roleName, ',');
                }
            }
        }
        return $users;

    }

    function count_all_user(){

        $this->db->from(TBL_USER);
        return $this->db->count_all_results();
    }

    // get permissions from for this roleid
    function getUsePermissions($userId, $fields = array('*'))
    {
        $this->db->select($fields);
        $this->db->from(TBL_PERMISSIONS);
        $this->db->join(TBL_USER_PERMISSION_MAP, TBL_USER_PERMISSION_MAP.'.permissionID = '.TBL_PERMISSIONS.'.permissionID');
        $this->db->where('userId', $userId);
        // get role
        $query = $this->db->get();
        // set permissions array and return
        if ($query->num_rows())
        {
            foreach ($query->result() as $row)
            {
                $permissions[$row->category][] = $row->permissionID;
            }

            return $permissions;
        }
        else
        {
            return false;
        }
    }

    public function getApprovers($fields = array('*'), $where) {
        $this->db->select($fields);
        $this->db->from(TBL_USER);
        $this->db->where('is_approver IS NULL');
        if($where) {
            $this->db->where($where);
        }

        $this->db->order_by('name DESC');
        $query = $this->db->get();
        $users =  $query->result();

        return $users;
    }
}
?>