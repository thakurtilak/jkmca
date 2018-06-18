<?php

class ClientModel extends CI_Model
{
    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * @author Webdunia
     * TimeStamp : 09.March.2018
     */
    public function __construct()
    {
        $this->load->database();
    }

    /*To list all orders in a system*/
    function _get_datatables_query($userId = false, $categoryId = false, $status = false, $name = false, $orderBY = false) {

        $this->db->select('CM.*');
        $this->db->from(TBL_CLIENT_MASTER.' as CM');
        $status = 1; // only showing active clients
        if($status === '0' || $status == 1) {
            $this->db->where('CM.status', $status);
        }

        if($name) {
            
            $this->db->group_start();
            $this->db->like('CM.first_name', $name);
            $this->db->or_like('CM.middle_name',$name);
            $this->db->or_like('CM.last_name',$name);
            $this->db->or_like('CM.pan_no',$name);
            $this->db->or_like('CM.aadhar_number',$name);
            $this->db->or_like('CM.mobile',$name);
            $this->db->group_end();
        }

        if($orderBY) {
            $this->db->order_by($orderBY);
        } else{
            $this->db->order_by('first_name ASC');
        }
    }
    /*To list all client in a system*/
    function listClient($userId = false, $categoryId = false, $status = false, $name = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
    {
        $this->_get_datatables_query($userId, $categoryId,  $status,  $name, $orderBY);
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();

    }
    /*Orders count_filtered*/
    function count_filtered($userId = false, $categoryId = false, $status = false,  $name = false, $orderBY = false)
    {
        $this->_get_datatables_query($userId, $categoryId, $status, $name, $orderBY);
        $query = $this->db->get();
        return $query->num_rows();
    }
    /*Orders count_all*/
    public function count_all($userId = false)
    {
        $this->db->from(TBL_CLIENT_MASTER);
        $this->db->where('status', 1);
       /* if($userId) {
            $this->db->where('created_by', $userId);
        }*/

        return $this->db->count_all_results();
    }

    /*To get Client Details*/
    public function getClient($clientId){

        $this->db->select('CM.*' );
        $this->db->from(TBL_CLIENT_MASTER.' as CM');
        if($clientId) {
            $this->db->where('CM.client_id', $clientId);
        }
        $query = $this->db->get();
        return $query->row();
    }

    /*To Update client master table*/
    public function update($where, $data)
    {
        $this->db->update(TBL_CLIENT_MASTER, $data, $where);
        return $this->db->affected_rows();
    }

}
?>