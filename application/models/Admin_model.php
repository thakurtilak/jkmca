<?php
/**
 * class Admin_model
 * 		This class contains all commonly used methods in the system
 * @category Controller
 * @link timesscholar.com
 * @author Webdunia
 * @version    0.1
 * @Timestamp 11.Apr.2018
 */
class Admin_model extends CI_Model {


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

    /**
     * Method : insert
     * Functionality :
     * 		Generalize function to insert data in any table
     * @author Webdunia
     * TimeStamp : 10.Jan.2018(4.10 PM)
     */
    public function insert($table,$data)
    {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * Method : insertMultiple
     * Functionality :
     * 		Generalize function to insert data in any table
     * @author Webdunia
     * TimeStamp : 10.Jan.2018(4.10 PM)
     */
    public function insertMultiple($table,$data)
    {
        $this->db->insert_batch($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * Method : update
     * Functionality :
     * 		Generalize function to update table records
     * @author Webdunia
     * TimeStamp : 10.Jan.2018(4.10 PM)
     */
    public function update($table,$data,$where)
    {
        $this->db->update($table,$data,$where);
        // echo $this->db->last_query(); die;
        return $this->db->affected_rows();
    }

    /**
     * Method : delete
     * Functionality :
     * 		Generalize function to delete table records
     * @author Webdunia
     * TimeStamp : 15.May.2017(4.10 PM)
     */
    public function delete($table,$where)
    {
        $result = $this->db->delete($table,$where);
        return $result;
    }


    public function getRecordCount($table, $where = array()) {
        try {
            $this->db->select('id'); //Assumming that Every table has id fields
            $this->db->distinct();
            $this->db->from($table);
            if($where) {
                $this->db->where($where);
            }
            $query = $this->db->get();
            return $query->num_rows();
        } catch(Exception $e) {
            print_r($e);
            return $e;
        }
    }

    /**
     * Get Record Based on limit
     */
    public function getRecords($table, $field = '*' , $where = array(), $orderBy = false, $order ='ASC', $limit = '', $offset = 0)
    {
        try {
            $this->db->select($field);

            $this->db->from($table);
            if(isset($where) && !empty($where))
            {
                $this->db->where($where);
            }

            if($limit !=''){
                $this->db->limit($limit, $offset);
            }
            if($orderBy){
                $this->db->order_by($orderBy, $order);
            }
            //$this->db->limit(5000, 0);
            $query = $this->db->get();
            //echo $this->db->last_query(); die;
            return $query->result();

        } catch(Exception $e) {
            print_r($e);
            return false;
        }
    }

    public function getRecord($table, $field = '*' , $where) {

        try {
            $this->db->select($field);

            $this->db->from($table);
            $this->db->where($where);

            $query = $this->db->get();
            //echo $this->db->last_query(); die;
            return $query->row();
        } catch(Exception $e) {
            print_r($e);
            return false;
        }

    }

    /*
     * listCurrency
     * Admin Management screen
     */
    public function listCurrency($searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $this->db->select('*');
        $this->db->from(TBL_CURRENCY_MASTER);

        if($searchKey){
            $this->db->group_start();
            $this->db->like('currency_name', $searchKey);
            $this->db->or_like('currency_symbol',$searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('currency_name DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $this->db->limit($limitLength, $limitStart);
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    function count_all_currency(){

        $this->db->from(TBL_CURRENCY_MASTER);
        return $this->db->count_all_results();
    }


    /*
     * listCategory
     * Admin Management screen
     */
    public function listCategory($type= '', $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $this->db->select('*');
        $this->db->from(TBL_CATEGORY_MASTER);
        if($type) {
            if($type == 1) {
                $this->db->where('parent_id', '0');
                $this->db->where('is_service_category', '0');
            } elseif($type == 2) {
                $this->db->where('parent_id <>', '0');
            }elseif($type == 3) {
                $this->db->where('is_order_category', 1);
            }elseif($type == 4) {
                $this->db->where('is_service_category', 1);
            }
        }
        if($searchKey){
            $this->db->group_start();
            $this->db->like('category_name', $searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('category_name DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $this->db->limit($limitLength, $limitStart);
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    function count_all_category(){

        $this->db->from(TBL_CATEGORY_MASTER);
        return $this->db->count_all_results();
    }


    /*
    * listCompany
    * Admin Management screen
    */
    public function listCompany($searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $this->db->select('*');
        $this->db->from(TBL_COMPANY_MASTER);

        if($searchKey){
            $this->db->group_start();
            $this->db->like('company_name', $searchKey);
            $this->db->or_like('company_address',$searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('company_name DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            if($limitLength >= 0 ){
                $this->db->limit($limitLength, $limitStart);
            }

            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    function count_all_company(){

        $this->db->from(TBL_COMPANY_MASTER);
        return $this->db->count_all_results();
    }

    /*
     * listTaxes
     * Admin Management screen
     */
    public function listTaxes($financialYear = '', $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $this->db->select('*');
        $this->db->from(TBL_TAX_MASTER);
        if($financialYear) {
            $this->db->where('financial_year', $financialYear);
        }
        if($searchKey){
            $this->db->group_start();
            $this->db->like('tax_detail', $searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('tax_detail DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            if($limitLength >= 0) {
                $this->db->limit($limitLength, $limitStart);
            }
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    function count_all_taxes($financialYear =''){

        $this->db->from(TBL_TAX_MASTER);
        if($financialYear) {
            $this->db->where('financial_year', $financialYear);
        }
        return $this->db->count_all_results();
    }


    /*
     * listInvoices
     * Admin List
    */
    public function listAdminInvoices($searchKey = '', $orderBY = false, $limitStart, $limitLength, $countOnly = false){
        $this->db->select('Tm.invoice_req_id,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no,Tm.po_date,Tm.invoice_no,Tm.invoice_date, Tm.invoice_generate_date,Tm.payment_due_date, uM.id, CONCAT(uM1.first_name, \' \' , uM1.last_name) as generatedBy, catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_USER . ' as uM1', 'uM1.id = Tm.generator_user_id','left');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status !=', 'Pending');
        $this->db->where('Tm.invoice_acceptance_status !=', 'Reject');
        $this->db->where('Tm.gen_approval_status IS NULL');
        $this->db->where('Tm.invoice_generate_date >=', '2014-04-01'); /*Based on current system*/

        if($searchKey){
            $this->db->group_start();
            $this->db->like('Tm.project_name', $searchKey);
            $this->db->or_like('clientM.client_name',$searchKey);
            $this->db->or_like('Tm.po_no',$searchKey);
            $this->db->or_like('Tm.invoice_no',$searchKey);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('invoice_originate_date DESC');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $this->db->limit($limitLength, $limitStart);
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    /*
     * count_all_listAdminInvoices
     * Admin List count
    */
    public function count_all_listAdminInvoices(){

        $this->db->select('Tm.invoice_req_id,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no,Tm.po_date,Tm.invoice_no,Tm.invoice_date, Tm.invoice_generate_date,Tm.payment_due_date, uM.id, CONCAT(uM1.first_name, \' \' , uM1.last_name) as generatedBy, catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_USER . ' as uM1', 'uM1.id = Tm.generator_user_id','left');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status !=', 'Pending');
        $this->db->where('Tm.invoice_acceptance_status !=', 'Reject');
        $this->db->where('Tm.gen_approval_status IS NULL');
        $this->db->where('Tm.invoice_generate_date >=', '2014-04-01'); /*Based on current system*/

        return $this->db->count_all_results();
    }
}
/* End of file Admin_model.php */