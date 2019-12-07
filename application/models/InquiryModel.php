<?php

class InquiryModel extends CI_Model
{
    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * TimeStamp : 09.March.2018
     */
    public function __construct()
    {
        $this->load->database();
    }

    /*To list all orders in a system*/
    function _get_datatables_query($userId = false, $categoryId = false, $status = false, $name = false, $orderBY = false) {

        $this->db->select('CM.*');
        $this->db->from(TBL_INQUIRY_MASTER.' as CM');
        $this->db->where('CM.status !=','COMPLETED');
        /*if($status) {
            $this->db->where('CM.status', $status);
        }*/

        if($name) {
            $name = $this->db->escape_like_str($name);
            $this->db->group_start();
            $this->db->where("CONCAT(CM.first_name, ' ', CM.last_name) LIKE '%".$name."%'", NULL, FALSE);
            $this->db->or_like('CM.fathers_first_name',$name);
            $this->db->or_like('CM.fathers_last_name',$name);
            $this->db->or_like('CM.pan_no',$name);
            $this->db->or_like('CM.aadhar_no',$name);
            $this->db->or_like('CM.mobile',$name);
            $this->db->group_end();
        }

        if($orderBY) {
            $this->db->order_by($orderBY);
        } else{
            $this->db->order_by('created_at DESC');
        }
    }
    /*To list all client in a system*/
    function listInquiries($userId = false, $categoryId = false, $status = false, $name = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
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
        $this->db->from(TBL_INQUIRY_MASTER);
        $this->db->where('status !=','COMPLETED');
        return $this->db->count_all_results();
    }

    /*To get Client Details*/
    public function getInquiry($inquiryId){

        $this->db->select('CM.*' );
        $this->db->from(TBL_INQUIRY_MASTER.' as CM');
        if($inquiryId) {
            $this->db->where('CM.ref_no', $inquiryId);
        }
        $query = $this->db->get();
        return $query->row();
    }

    /*To Update client master table*/
    public function update($where, $data)
    {
        $this->db->update(TBL_INQUIRY_MASTER, $data, $where);
        return $this->db->affected_rows();
    }

    public function getPendingInquiries($userId = false, $limitLength = 5, $limitStart = 0) {

        $this->db->from(TBL_INQUIRY_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        if($userId) {
            $this->db->where('Tm.staff_id', $userId);
        }
        $this->db->group_start();
        $this->db->where('Tm.status', 'PENDING');
        $this->db->group_end();
        $this->db->order_by('created_at DESC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }
}
?>