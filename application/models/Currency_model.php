<?php
/**
 * class Currency_model
 * 		This class contains all commonly used methods for Currency Conversion in the system
 * @category MODEL
 * @link ims.webdunia.net
 * @author Webdunia
 * @version    0.1
 * @Timestamp 04.Apr.2018
 */
class Currency_model extends CI_Model {


    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * @author Webdunia
     * TimeStamp : 15.May.2018(4.00 PM)
     */
    public function __construct()
    {
        $this->load->database();
    }

    /*
     * get_datatables_query
     * To get list of raised invoices.
     */
    function _get_datatables_query($month = false, $searchKey = false, $orderBY = false)
    {
        $this->db->select('Cc.*, curM.currency_symbol, curM.currency_name');
        $this->db->from(TBL_CURRENCY_CONVERSIONS . ' as Cc');
        //$this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Cc.currency_id');

        if ($searchKey) {
            $this->db->group_start();
            $this->db->like('curM.currency_symbol', $searchKey);
            $this->db->or_like('Cc.month',$searchKey);
            $this->db->or_like('Cc.conversion_rate',$searchKey);
            $this->db->group_end();
        }

        if ($month && $month != '-1') {
            $this->db->where('month', $month);
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('month DESC');
        }


    }

    function count_filtered($month = false, $searchKey = false, $orderBY = false)
    {
        $this->_get_datatables_query($month, $searchKey, $orderBY);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($month)
    {
        $this->db->from(TBL_CURRENCY_CONVERSIONS);
        $this->db->group_start();
        $this->db->where('month', $month);
        $this->db->group_end();
        return $this->db->count_all_results();
    }

    function listConversions($month = false, $searchKey = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
    {
        $this->_get_datatables_query($month, $searchKey, $orderBY);
        if($limitLength > 0) {
            $this->db->limit($limitLength, $limitStart);
        }

        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*Get Single Conversion record*/
    function getConversion($where) {

        $this->db->select('Cc.*, curM.currency_symbol, curM.currency_name');
        $this->db->from(TBL_CURRENCY_CONVERSIONS . ' as Cc');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Cc.currency_id');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }


}
/* End of file Currency_model.php */
/* Location: ./application/models/Currency_model.php */