<?php

class Job_model extends CI_Model
{
    /**
     * Method : __construct
     * Functionality :
     *      Load database objects.
     * @author DHARMENDRA
     * TimeStamp : 06.Feb.2018
     */
    public function __construct()
    {
        $this->load->database();
    }

    /*
    * getAllexcutivesIds
    * To get all excutivesIds.
    */
    function _getAllexcutivesIds($userId) {

        $this->db->select('id');
        $this->db->from(TBL_USER);
        $this->db->where('approver_user_id', $userId);
        $query = $this->db->get();
        // echo  $this->db->last_query(); die;
        $users =  $query->result();
        $usersIDs = array();
        if($users) {
            foreach($users as $user) {
                $usersIDs[] = $user->id;
            }
        }
        return $usersIDs;
    }

     /*
      * get_datatables_query
      * To get list of raised invoices.
      */
    function _get_datatables_query($userId, $work_type = false, $status = false, $month = false, $payment_status ='', $name = false, $orderBY = false)
    {
        //$approverUsers = $this->_getAllexcutivesIds($userId);

        $this->db->from(TBL_JOB_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        if($userId) {
            $this->db->group_start();
            $this->db->where('Tm.staff_id', $userId);
            $this->db->group_end();
        }

        if($payment_status){
            if($payment_status == 'complete') {
                $this->db->group_start();
                $this->db->where('Tm.remaining_amount <=', 0);
                $this->db->group_end();
            } else if ($payment_status == 'pending'){
                $this->db->group_start();
                $this->db->where('Tm.remaining_amount >', 0);
                $this->db->group_end();
            }
        }

        if ($work_type) {
            $this->db->where('Tm.work_type', $work_type);
        }
        if ($status) {
            $this->db->group_start();
            $this->db->where('Tm.status', $status);
            $this->db->group_end();
        }

        if ($name) {
            $this->db->group_start();
            $this->db->like('Tm.mobile_number', $name);
            $this->db->or_like('Tm.job_number', $name);
            $this->db->or_like('Tm.first_name',$name);
            $this->db->or_like('Tm.last_name',$name);
            $this->db->or_like('uM.first_name',$name);
            $this->db->or_like('uM.last_name',$name);
            $this->db->or_like('Tm.pan_no',$name);
            $this->db->or_like('Tm.aadhar_no',$name);
            $this->db->group_end();
        }

        if ($month && $month != '-1') {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-01", strtotime($first_date));
            $second_date = date("Y-m-01", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('Tm.created_date >=', $first_date);
            $this->db->where('Tm.created_date <', $second_date);
            $this->db->group_end();
        }

        if ($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('created_date DESC');
        }


    }
    /*RaisedInvoice count_filtered*/
    function count_filtered($userId = false, $work_type = false, $status = false, $MONTH = false, $payment_status ='', $name = false, $orderBY = false)
    {
        $this->_get_datatables_query($userId, $work_type, $status, $MONTH, $payment_status, $name, $orderBY);
        $query = $this->db->get();
        return $query->num_rows();
    }
    /*Raised Invoice count_all*/
    public function count_all($userId, $case = 'raised')
    {
        //$approverUsers = $this->_getAllexcutivesIds($userId);
        $this->db->from(TBL_JOB_MASTER);
        if($userId){
            $this->db->group_start();
            $this->db->where('staff_id', $userId);
            $this->db->group_end();
            /*if($case == 'raised') {
                $this->db->group_start();
                $this->db->where('originator_user_id', $userId);
                if($approverUsers) {
                    $this->db->or_where_in('originator_user_id', $approverUsers);
                }
                $this->db->group_end();
            } elseif($case == 'pendingInvoice') {
                $this->db->group_start();
                $this->db->where('invoice_acceptance_status', 'Pending');
                $this->db->where('approval_status', 'accept');
                $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
                $this->db->where('originator_user_id IN('.$subQRY.')', NULL, FALSE);
                $this->db->group_end();
            }*/

        }

        return $this->db->count_all_results();
    }

    /*Jobs Listing*/
    function listJobs($userId = false, $work_type = false, $status = false, $month = false, $payment_status ='', $name = false, $orderBY = false, $limitStart = 0, $limitLength = 10)
    {

        $this->_get_datatables_query($userId, $work_type, $status, $month, $payment_status, $name, $orderBY);

        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*To get Job Details*/
    public function getJob($jobId){

        $this->db->select('Tm.*,wt.work,uM.id as userId,CONCAT(uM.first_name, \' \' , uM.last_name) as requestorname, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact' );
        $this->db->from(TBL_JOB_MASTER.' as Tm');
        $this->db->join(TBL_WORK_TYPE.' as wt','wt.id = Tm.work_type', 'left');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.created_by', 'left');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        if($jobId) {
            $this->db->where('Tm.id', $jobId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->row();
    }

    public function getJobDocuments($jobId){
        $this->db->select('m.*,dm.name as documentName' );
        $this->db->from(TBL_JOBS_ATTACHMENTS.' as m');
        $this->db->join(TBL_DOCUMENTS_MASTER.' as dm','dm.id = m.attach_type', 'left');
        if($jobId) {
            $this->db->where('m.job_id', $jobId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function getApprovePendingJobs($limitLength = 10, $limitStart = 0) {

        $this->db->from(TBL_JOB_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        $this->db->where('Tm.status', 'approval_pending');
        $this->db->order_by('complete_date DESC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    public function getPendingJobs($userId = false, $limitLength = 10, $limitStart = 0) {

        $this->db->from(TBL_JOB_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        if($userId) {
            $this->db->where('Tm.staff_id', $userId);
        }
        $this->db->group_start();
        $this->db->where('Tm.status', 'pending');
        $this->db->or_where('Tm.status', 'rejected');
        $this->db->group_end();
        $this->db->order_by('created_date ASC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    public function getPaymentPendingJobs($limitLength = 10, $limitStart = 0) {

        $this->db->from(TBL_JOB_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        $this->db->where('Tm.status', 'completed');
        $this->db->where('Tm.remaining_amount >', 0);
        $this->db->order_by('complete_date DESC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }


   /*Function to update invoice master table*/
    public function update($where, $data)
    {
        $this->db->update(TBL_INVOICE_MASTER, $data, $where);
        return $this->db->affected_rows();
    }

    /*To get UserDetails by Id*/
    public function getUserDetailsById($userId)
    {
        $this->db->select('Rm.role_name,uM.*');
        $this->db->from(TBL_ROLE_MASTER.' as Rm');
        $this->db->join(TBL_USER.' as uM','uM.role_id = Rm.id');
        if($userId)
        {
            $this->db->where('uM.id', $userId);

        }
        $query = $this->db->get();
        return $query->row();
        //echo  $this->db->last_query(); die;
    }

    /*
     * latestPendingInvoices
     * Get the pending invoice list those are pending for generation
    */
    public function latestPendingInvoices($userId, $clientId = false, $status = false, $month = false,  $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {

        $this->db->select('Tm.invoice_req_id,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no, uM.id, catM.category_name, clientM.client_name,curM.currency_symbol,Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status', 'Pending');
        $this->db->where('Tm.approval_status', 'accept');
        $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
        $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);

        if ($clientId) {
            $this->db->where('Tm.client_id', $clientId);
        }
        if ($status) {
            $this->db->where('Tm.invoice_acceptance_status', $status);
        }

        if ($month && $month != '-1') {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('invoice_originate_date >=', $first_date);
            $this->db->where('invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        if($searchKey){
            $this->db->group_start();
            $this->db->like('Tm.project_name', $searchKey);
            $this->db->or_like('clientM.client_name',$searchKey);
            $this->db->or_like('Tm.po_no',$searchKey);
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


    public function sumlatestPendingInvoices($userId,$groupBy= false, $limitStart= '', $limitLength = '', $countOnly = false) {

         $limit = "limit ".$limitStart.",".$limitLength;
        $sub_query_from = '(SELECT `Tm`.`invoice_req_id`, `Tm`.`invoice_originate_date`, `Tm`.`project_name`, `Tm`.`invoice_net_amount`, `Tm`.`invoice_currency`, `Tm`.`invoice_acceptance_status`, `Tm`.`category_id`, `Tm`.`client_id`, `Tm`.`originator_user_id`, `Tm`.`po_no`, `uM`.`id`, `catM`.`category_name`, `clientM`.`client_name`, `curM`.`currency_symbol`
            FROM `ims_invoice_master` as `Tm`
            JOIN `ims_user_master` as `uM` ON `uM`.`id` = `Tm`.`originator_user_id`
            JOIN `ims_invoice_category_master` as `catM` ON `catM`.`id` = `Tm`.`category_id`
            JOIN `ims_client_master` as `clientM` ON `clientM`.`client_id` = `Tm`.`client_id`
            JOIN `ims_currency_master` as `curM` ON `curM`.`currency_id` = `Tm`.`invoice_currency`
            WHERE invoice_acceptance_status = "Pending"
            AND approval_status = "accept"
            AND Tm.originator_user_id IN(SELECT id FROM ims_user_master WHERE approver_user_id = '.$userId.' OR id = '.$userId.')
            ORDER BY `invoice_originate_date` desc
            '.$limit.') as tt1';
        $this->db->select('currency_symbol`,SUM(invoice_net_amount)as sum');
        $this->db->from($sub_query_from);

        if($groupBy){
            $this->db->group_by('invoice_currency');
        }

        if($countOnly) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            //$this->db->limit($limitLength, $limitStart);
            $query = $this->db->get();
            //echo  $this->db->last_query(); die;
            return $query->result();
        }
    }

    /*
     * latestDueCollection
     * Get the due invoice list those payment not recieved.
    */
    public function latestDueCollection($userId, $isGenerator = false, $limitLength = 5, $limitStart=0) {

        $this->db->select('Tm.invoice_req_id,Tm.payment_recieved_flag, Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no,Tm.po_date,Tm.invoice_no,Tm.invoice_date,Tm.payment_due_date, uM.id, CONCAT(uM.first_name, \' \' , uM.last_name) as requestBy, catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.payment_recieved_flag !=', 'Y');
        if($isGenerator) {
            $this->db->where('Tm.generator_user_id', $userId);
            $this->db->order_by('payment_due_date DESC');
        } else {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);

            $this->db->order_by('invoice_originate_date DESC');
        }

        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*Get raised invoice for generator*/
    public function getGeneratorRaisedInvoices($userId, $limitLength = 5, $limitStart = 0) {

        $this->db->select('Tm.invoice_req_id,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no,Tm.po_date,Tm.invoice_no,Tm.invoice_date,Tm.payment_due_date, uM.id, CONCAT(uM.first_name, \' \' , uM.last_name) as requestBy,catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status !=', 'Pending');
        $this->db->where('Tm.generator_user_id =', $userId);

        $this->db->order_by('invoice_originate_date DESC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getGeneratorApprovalPendingInvoices
     * Get latest invoices those are pending for final approval
     */
    public function getGeneratorApprovalPendingInvoices($userId, $limitLength = 10, $limitStart = 0) {
        $this->db->select('Tm.invoice_req_id,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no,Tm.po_date,Tm.invoice_no,Tm.invoice_date, Tm.invoice_generate_date,Tm.payment_due_date, uM.id, CONCAT(uM1.first_name, \' \' , uM1.last_name) as generatedBy, catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_USER . ' as uM1', 'uM1.id = Tm.generator_user_id','left');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $this->db->where('Tm.invoice_acceptance_status !=', 'Pending');
        $this->db->where('Tm.invoice_acceptance_status !=', 'Reject');
        $this->db->where('Tm.gen_approval_userid =', $userId);
        $this->db->where('Tm.gen_approval_status IS NULL');
        $this->db->where('Tm.invoice_generate_date >=', '2014-04-01'); /*Based on current system*/

        $this->db->order_by('invoice_generate_date DESC');
        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getCollections
     * Get the list of collections
    */
    public function getCollections($roleId, $userId, $categoryId = false, $clientId = false, $paymentStatus = false, $month = false,  $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $hasApprover = false;
        if(hasApprover($userId)) {
            $hasApprover = true;
        }
        $this->db->select('Tm.invoice_req_id,Tm.po_date,Tm.invoice_no,Tm.invoice_date,Tm.invoice_net_amount, Tm.payment_recieved_flag, Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no, uM.id, catM.category_name, clientM.client_name,curM.currency_symbol');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        if($roleId == SUPERADMINROLEID ){

        } elseif($roleId == MANAGERROLEID) {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);
        }elseif ($roleId == ORIGINATERROLEID) {

            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);

        }elseif($roleId == GENERATERROLEID) {
            if($hasApprover) {
                $subQRY = "SELECT category_id FROM ".TBL_INVOICE_CATEGORY_GEN_MAPPER ." WHERE generator_user_id = $userId";
                $this->db->where('Tm.category_id IN('.$subQRY.')', NULL, FALSE);
            }
        } elseif($roleId == COLLECTORROLEID) {

        } else {
            //$subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            //$this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);
        }

        if($categoryId) {
            $this->db->where('Tm.category_id', $categoryId);
        }

        if ($clientId) {
            $this->db->where('Tm.client_id', $clientId);
        }
        if ($paymentStatus) {
            $this->db->where('Tm.payment_recieved_flag', $paymentStatus);
        }

        if ($month && $month != '-1') {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('invoice_date >=', $first_date);
            $this->db->where('invoice_date <=', $second_date);
            $this->db->group_end();
        }

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

    function count_all_CollectionsTotal($roleId, $userId) {
        $hasApprover = false;
        if(hasApprover($userId)) {
            $hasApprover = true;
        }

        $this->db->from(TBL_INVOICE_MASTER);
        $this->db->where('invoice_acceptance_status', 'Accept');
        if($roleId == SUPERADMINROLEID ){

        } elseif($roleId == MANAGERROLEID) {

        }elseif ($roleId == ORIGINATERROLEID) {

            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('originator_user_id IN('.$subQRY.')', NULL, FALSE);

        }elseif($roleId == GENERATERROLEID) {
            if($hasApprover) {
                $subQRY = "SELECT category_id FROM ".TBL_INVOICE_CATEGORY_GEN_MAPPER ." WHERE generator_user_id = $userId";
                $this->db->where('category_id IN('.$subQRY.')', NULL, FALSE);
            }
        } elseif($roleId == COLLECTORROLEID) {

        } else {
            //$subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            //$this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);
        }
        return $this->db->count_all_results();
    }

    /*
     * getTopInvoicesOfTheMonth
     * Manager's Dashboard
     **/
    public function getTopInvoicesOfTheMonth($userId, $clientId = false, $status = false, $month = false,  $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 5, $countOnly = false) {

        $this->db->select('Tm.invoice_req_id,Tm.invoice_no,Tm.invoice_originate_date,Tm.project_name,Tm.invoice_acceptance_status,Tm.invoice_net_amount,Tm.category_id, Tm.client_id,Tm.originator_user_id,Tm.po_no, uM.id, catM.category_name, clientM.client_name,curM.currency_symbol,Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        $this->db->join(TBL_CATEGORY_MASTER . ' as catM', 'catM.id = Tm.category_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');

        $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
        $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);

        if ($clientId) {
            $this->db->where('Tm.client_id', $clientId);
        }
        if ($status) {
            $this->db->where('Tm.invoice_acceptance_status', $status);
        }

        if ($month && $month != '-1') {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($month)));
            //$second_date = date("Y-m-t", strtotime($month));
            $this->db->group_start();
            $this->db->where('invoice_originate_date >=', $first_date);
            $this->db->where('invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        if($searchKey){
            $this->db->group_start();
            $this->db->like('Tm.project_name', $searchKey);
            $this->db->or_like('clientM.client_name',$searchKey);
            $this->db->or_like('Tm.po_no',$searchKey);
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
     * getProjectsWithTotalInvoice
     * Manager's Dashboard
     */
    function getProjectsWithTotalInvoice($userId, $isTechHead, $startDate = false, $endDate = false, $limitStart= 0, $limitLength = 5, $countOnly = false){
        $this->db->select('SUM(Tm.invoice_net_amount) as totalInvoice,om.project_name, clientM.client_name,curM.currency_symbol, Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        if($isTechHead) {
            //$this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.originator_user_id');
        }

        $this->db->join(TBL_ORDER_MASTER . ' as om', 'om.order_id = Tm.order_id');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        $this->db->where('Tm.invoice_acceptance_status', 'Accept');
        $this->db->where('Tm.gen_approval_status', 'Accept');
        if($isTechHead) {
            $this->db->where('om.wd_tech_head_id', $userId);
        } else {
            $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
            $this->db->where('om.wd_sales_person_id IN('.$subQRY.')', NULL, FALSE);
            //We can get it for other manager like localization, adsales etc.. (NEED discussion)
        }

        if ($startDate && $endDate) {
            $first_date = $startDate;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($endDate)));
            //$second_date = date("Y-m-t", strtotime($endDate));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }
        $this->db->group_by('Tm.order_id');
        $this->db->order_by('totalInvoice', 'desc');

        $this->db->limit($limitLength, $limitStart);
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getClientsWithTotalInvoice
     * Manager's Dashboard
     */
    public function getClientsWithTotalInvoice($userId, $clientId = false, $status = false, $month = false, $orderBY= false, $limitStart= 0, $limitLength = false, $countOnly = false){
        $this->db->select('Tm.invoice_net_amount,Tm.invoice_originate_date, clientM.client_name, curM.currency_symbol, Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CLIENT_MASTER . ' as clientM', 'clientM.client_id = Tm.client_id');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        if($status) {
            $this->db->where('Tm.invoice_acceptance_status', $status);
        } else {
            $this->db->where('Tm.invoice_acceptance_status', 'Accept');
            $this->db->where('Tm.gen_approval_status', 'Accept');
        }
        $subQRY = "SELECT id FROM ".TBL_USER ." WHERE approver_user_id = $userId OR id = $userId";
        $this->db->where('Tm.originator_user_id IN('.$subQRY.')', NULL, FALSE);

        if($clientId) {
            $this->db->where('clientM.client_name', $clientId);
        }

        if ($month) {
            $first_date = $month;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($first_date)));
            //$second_date = date("Y-m-t", strtotime($endDate));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        if($orderBY) {
            $this->db->order_by($orderBY);
        } else {
            $this->db->order_by('clientM.client_name', 'ASC');
        }

        if($limitLength) {
            $this->db->limit($limitLength, $limitStart);
        }
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }


    public function getTotalFinancialYearPendingInvoices($startDate, $endDate) {
        $this->db->select('Tm.invoice_req_id, Tm.invoice_net_amount, Tm.invoice_originate_date, Tm.invoice_currency');
        $this->db->from(TBL_INVOICE_MASTER . ' as Tm');
        $this->db->join(TBL_CURRENCY_MASTER. ' as curM','curM.currency_id = Tm.invoice_currency');
        $this->db->where('invoice_acceptance_status', 'Accept');
        $this->db->where('payment_recieved_flag', 'N');
        if ($startDate && $endDate) {
            $first_date = $startDate;
            //Here we treat 1-6th date as previous month and 7th to next month's 6th will be current month
            $first_date = date("Y-m-07", strtotime($first_date));
            $second_date = date("Y-m-06", strtotime('+1 month', strtotime($endDate)));
            //$second_date = date("Y-m-t", strtotime($endDate));
            $this->db->group_start();
            $this->db->where('Tm.invoice_originate_date >=', $first_date);
            $this->db->where('Tm.invoice_originate_date <=', $second_date);
            $this->db->group_end();
        }

        $this->db->order_by('invoice_originate_date', 'desc');

        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }

    /*
     * getManagersSalesPersons
     * Return the manager's sales person OR executives
     */
    public function getManagersSalesPersons($userId, $fields = array('*'), $orderBy = '') {
        $this->db->select($fields);
        $this->db->from(TBL_USER);
        $this->db->where('approver_user_id', $userId);
        $this->db->where('status', 'A');
        if($orderBy) {
            $this->db->order_by($orderBy);
        }
        $query = $this->db->get();
        //echo  $this->db->last_query(); die;
        return $query->result();
    }
	
}



?>