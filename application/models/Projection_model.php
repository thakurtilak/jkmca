<?php
/**
 * class Projection_model
 * 		This class contains all commonly used methods for Projection in the system
 * @category MODEL
 * @link ims.webdunia.net
 * @author Webdunia
 * @version    0.1
 * @Timestamp 15.May.2018
 */
class Projection_model extends CI_Model {


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
     * getYearlyProjections
     * Returns Total projection of the user of any financial year
     */
    public function getMonthlyProjections($userId, $financialYear) {

        $this->db->select('pm.*');
        $this->db->from(TBL_PROJECTIONS_TOTAL . ' as pm');
        $this->db->where('pm.financial_year', $financialYear);
        if($userId && 0) {
            $this->db->where('pm.sales_person_id', $userId);
        }else {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('pm.sales_person_id IN('.$subQRY.')', NULL, FALSE);
            //We can get it for other manager like localization, adsales etc.. (NEED discussion)
        }

        $this->db->order_by('actual_month', 'ASC');
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getMonthlyAllProjections
     * Returns Total projection of the given Financial Year
     */
    public function getMonthlyAllProjections($financialYear) {

        $this->db->select('SUM(total_revenue) as total_revenue, actual_month');
        $this->db->from(TBL_PROJECTIONS_TOTAL . ' as pm');

        $this->db->where('pm.financial_year', $financialYear);
        $this->db->group_by('actual_month');
        $this->db->order_by('actual_month', 'ASC');
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getActualInvoiceForMonth
     * Returns All actual invoice for a user of given month
     */
    public function getActualInvoiceForMonth($userId, $month) {
        $this->db->select('Tm.invoice_net_amount, Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');
        if($userId) {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);
        }

        if ($month && !empty($month)) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getAllActualInvoiceForMonth
     * Returns All actual invoice for given month
     */
    public function getAllActualInvoiceForMonth($month){
        $this->db->select('Tm.invoice_net_amount,Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');

        if ($month && !empty($month)) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        //return $query->row();
        return $query->result();
    }

    /*
     * getStreamWiseTotalInvoiceForMonth
     * Return the category wise total invoice for given month
     */
    public function getStreamWiseTotalInvoiceForMonth($month){
        $this->db->select('Tm.invoice_net_amount,Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency, catM.category_name');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');

        if ($month && !empty($month)) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
    * getBusinessManagerWiseInvoicingForMonth
    * Return the business manager wise total invoice for given month
    */
    public function getBusinessManagerWiseInvoicingForMonth($managerId, $month, $isTechHead = false) {
        $this->db->select('Tm.invoice_net_amount,Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency, catM.category_name');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        if($isTechHead) { /*WE ARE ALWAYS SENDING THIS PARAM FALSE*/
            /*$this->db->join(TBL_ORDER_MASTER . ' as om', 'om.order_id = Tm.order_id', 'left');
            $this->db->group_start();
            $this->db->where('om.wd_tech_head_id', $managerId);
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $managerId OR id = $managerId";
            $this->db->or_where('Tm.wd_manager_id IN('.$subQRY.')', NULL, FALSE);
            $this->db->group_end();*/
        } else {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $managerId OR id = $managerId";
            $this->db->group_start();
            $this->db->where('Tm.wd_manager_id IN('.$subQRY.')', NULL, FALSE);
            $this->db->group_end();
        }
        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');

        if ($month && !empty($month)) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }
        $query = $this->db->get();
        //echo  $this->db->last_query();
        //echo "<br><br>";
        return $query->result();
    }

    /*
    * getsalesPersonWiseInvoicingForMonth
    * Return the sales wise total invoice for given month
    */
    public function getsalesPersonWiseInvoicingForMonth($salesPId, $month, $isTechHead = false) {
        $this->db->select('Tm.invoice_net_amount,Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency, catM.category_name');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        if($isTechHead) {/*WE ARE ALWAYS SENDING THIS PARAM FALSE*/
            /*$this->db->join(TBL_ORDER_MASTER . ' as om', 'om.order_id = Tm.order_id', 'left');
            $this->db->group_start();
            $this->db->where('om.wd_tech_head_id', $salesPId);
            $this->db->or_where('Tm.wd_sales_person_id', $salesPId);
            $this->db->group_end();*/
        } else {
            $this->db->group_start();
            $this->db->where('Tm.wd_sales_person_id', $salesPId);
            //$this->db->where('Tm.order_id IS NULL');
            $this->db->group_end();
        }
        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');

        if ($month && !empty($month)) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }
        $query = $this->db->get();
        //echo  $this->db->last_query();
        //echo "<br><br>";
        return $query->result();
    }


    public function getBusinessManagers($where = false, $field = array('*') , $orderBy = false, $order = 'ASC') {
        try {
            $this->db->select($field);

            $this->db->from(TBL_USER);
            $this->db->where('is_manager', 1);
            $this->db->where('is_approver IS NULL');
            if(isset($where) && !empty($where))
            {
                $this->db->where($where);
            }

            if($orderBy){
                $this->db->order_by($orderBy, $order);
            }

            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();

        } catch(Exception $e) {
            return false;
        }
    }

    public function getSalesPersons($where = false, $field = array('*') , $orderBy = false, $order = 'ASC') {
        try {
            $this->db->select($field);

            $this->db->from(TBL_USER);
            $this->db->where('is_sales_person', 1);
            //$this->db->where('is_approver IS NULL');
            if(isset($where) && !empty($where))
            {
                $this->db->where($where);
            }

            if($orderBy){
                $this->db->order_by($orderBy, $order);
            }

            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();

        } catch(Exception $e) {
            return false;
        }
    }
}
/* End of file Projection_model.php */
/* Location: ./application/models/Projection_model.php */