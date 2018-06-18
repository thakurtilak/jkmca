<?php

class OrdersModel extends CI_Model
{
    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * @author Webdunia
     * TimeStamp : 06.Feb.2018
     */
    public function __construct()
    {
        $this->load->database();
    }
    /*To list all orders in a system*/
    function _get_datatables_query($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false) {

        $this->db->select('Om.*, catM.category_name, clientM.client_name, curM.currency_symbol' );
        $this->db->from(TBL_ORDER_MASTER.' as Om');
        $this->db->join(TBL_CATEGORY_MASTER.' as catM','catM.id = Om.order_category_id');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Om.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Om.order_currency');


        if($categoryId) {
            $this->db->where('Om.order_category_id', $categoryId);
        }
        if($clientId) {
            $this->db->where('Om.client_id', $clientId);
        }
        if($status) {
            $this->db->where('Om.is_cancelled', $status);
        }

        if($assigned) {
            if($assigned == 1) {
                $this->db->where('Om.wd_tech_head_id', $userId);
            } elseif ($assigned == 2) {
                $this->db->where('Om.created_by', $userId);
            }
        } else {
            $this->db->group_start();
            $this->db->where('Om.created_by', $userId);
            $this->db->or_where('wd_tech_head_id', $userId);
            $this->db->group_end();
        }
        if($name) {
            $this->db->like('Om.project_name', $name);
            $this->db->or_like('clientM.client_name',$name);
        }

        if($orderBY) {
            $this->db->order_by($orderBY);
        } else{
            $this->db->order_by('order_create_date DESC');
        }


    }
    /*To list all orders in a system*/
    function listOrders($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
    {
        $this->_get_datatables_query($userId, $categoryId, $clientId, $status, $assigned, $name, $orderBY);
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();

    }
    /*Orders count_filtered*/
    function count_filtered($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false)
    {
        $this->_get_datatables_query($userId, $categoryId, $clientId, $status, $assigned, $name, $orderBY);
        $query = $this->db->get();
        return $query->num_rows();
    }
    /*Orders count_all*/
    public function count_all($userId)
    {
        $this->db->from(TBL_ORDER_MASTER);
        $this->db->where('created_by', $userId);
        $this->db->or_where('wd_tech_head_id', $userId);
        return $this->db->count_all_results();

    }
    /*Active Orders Listing*/
    function _get_datatables_query_activeorders($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false) {

        $this->db->select('Om.*, catM.category_name, clientM.client_name, curM.currency_symbol' );
        $this->db->from(TBL_ORDER_MASTER.' as Om');
        $this->db->join(TBL_CATEGORY_MASTER.' as catM','catM.id = Om.order_category_id');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Om.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Om.order_currency');

        $this->db->where('(Om.end_date>=NOW() OR Om.end_date=\'00-00-0000\')');
        if($name) {
            $this->db->like('Om.project_name', $name);
        }
        if($orderBY) {
            $this->db->order_by($orderBY);
        } else{
            $this->db->order_by('order_create_date DESC');
        }
    }

    /*Listing of Active Orders*/
    function listActiveOrders($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
    {
        $this->_get_datatables_query_activeorders($userId, $categoryId, $clientId, $status, $assigned, $name, $orderBY);

        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
      //  echo  $this->db->last_query(); die;
        return $query->result();

    }

    /*Count filtering of active orders*/
    function count_filtered_activeorders($userId, $categoryId = false, $clientId = false, $status = false, $assigned = false, $name = false, $orderBY = false)
    {
        $this->_get_datatables_query_activeorders($userId, $categoryId, $clientId, $status, $assigned, $name, $orderBY);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*Active Orders count_all*/
    public function count_all_activeorders()
    {
        $this->db->from(TBL_ORDER_MASTER);
        return $this->db->count_all_results();
    }


    /*To get Orders Details*/
    public function getOrder($orderId){

        $this->db->select('Om.*, CONCAT(um1.first_name, \' \' , um1.last_name) as wd_sales_person,  catM.category_name, CONCAT(um2.first_name, \' \' , um2.last_name) as wd_head_person,catM.category_name, clientM.client_name, clientM.address1,clientM.address2, curM.currency_symbol,curM1.currency_symbol as hour_currency,pT.name' );
        $this->db->from(TBL_ORDER_MASTER.' as Om');
        $this->db->join(TBL_CATEGORY_MASTER.' as catM','catM.id = Om.order_category_id');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Om.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Om.order_currency','left');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM1','curM1.currency_id = Om.hour_rate_currency','left');
        $this->db->join(TBL_USER. ' as um1','um1.id = Om.wd_sales_person_id');
        $this->db->join(TBL_USER. ' as um2','um2.id = Om.wd_tech_head_id');
        $this->db->join(TBL_PAYMENT_TERMS_MASTER.' as pT','pT.id = Om.payment_term');

        //$this->db->join(TBL_CLIENT_SALESPERSON. ' as sp','sp.salespersion_id = Om.sales_id');
        //$this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Om.order_currency');
        if($orderId) {
            $this->db->where('Om.order_id', $orderId);
        }
        $query = $this->db->get();
        return $query->row();
    }

    /*To Update Order master table*/
    public function update($where, $data)
    {
        $this->db->update(TBL_ORDER_MASTER, $data, $where);
        return $this->db->affected_rows();
    }

}
?>