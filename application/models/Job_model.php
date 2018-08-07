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
            $name = $this->db->escape_like_str($name);
            $this->db->group_start();
            $this->db->where("CONCAT(clientM.first_name, ' ', clientM.last_name) LIKE '%".$name."%'", NULL, FALSE);
            $this->db->or_where("CONCAT(uM.first_name, ' ', uM.last_name) LIKE '%".$name."%'", NULL, FALSE);
            $this->db->or_like('clientM.mobile', $name);
            $this->db->or_like('clientM.firm_name',$name);
            $this->db->or_like('Tm.job_number', $name);
            $this->db->or_like('clientM.pan_no',$name);
            $this->db->or_like('clientM.gst_no',$name);
            $this->db->or_like('clientM.aadhar_number',$name);
            $this->db->group_end();
            /*$this->db->group_start();
            $this->db->like('Tm.mobile_number', $name);
            $this->db->or_like('Tm.job_number', $name);
            $this->db->or_like('clientM.first_name',$name);
            $this->db->or_like('clientM.last_name',$name);
            $this->db->or_like('uM.first_name',$name);
            $this->db->or_like('uM.last_name',$name);
            $this->db->or_like('Tm.pan_no',$name);
            $this->db->or_like('Tm.aadhar_no',$name);
            $this->db->group_end();*/
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

        $this->db->select('Tm.*,wt.work,uM.id as userId,CONCAT(uM.first_name, \' \' , uM.last_name) as requestorname, CONCAT(PR.first_name, " " , IFNULL(PR.middle_name, ""), " ",IFNULL(PR.last_name, "")) as responsible, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact, clientM.firm_name' );
        $this->db->from(TBL_JOB_MASTER.' as Tm');
        $this->db->join(TBL_WORK_TYPE.' as wt','wt.id = Tm.work_type', 'left');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.created_by', 'left');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        $this->db->join(TBL_CLIENT_MASTER. ' as PR','PR.client_id = Tm.payment_responsible','left');
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
     * listPaymentLaser
     * Get the list of collections
    */
    public function listPaymentLaser($type, $clientId, $workType = false, $month = false,  $searchKey = false, $orderBY= false, $limitStart= 0, $limitLength = 10, $countOnly = false) {
        $this->db->from(TBL_JOB_MASTER . ' as Tm');
        $this->db->select('Tm.*, CONCAT(Tm.first_name, \' \' , Tm.last_name) as client_name, CONCAT(uM.first_name, \' \' , uM.last_name) as staff_name, wt.work, CONCAT(clientM.first_name, " " , IFNULL(clientM.middle_name, ""), " ",IFNULL(clientM.last_name, "")) as clientName, CONCAT(clientM.address1," ", IFNULL(clientM.address2, "") ) as clientAddress, clientM.mobile as clientContact');
        $this->db->join(TBL_USER . ' as uM', 'uM.id = Tm.staff_id');
        $this->db->join(TBL_WORK_TYPE . ' as wt', 'wt.id = Tm.work_type');
        $this->db->join(TBL_CLIENT_MASTER. ' as clientM','clientM.client_id = Tm.client_id','left');
        if($type == 1) {
            $this->db->group_start();
            $this->db->where('Tm.client_id', $clientId);
            $this->db->group_end();
        } elseif ($type == 0){
            $this->db->group_start();
            $this->db->where('Tm.payment_responsible', $clientId);
            $this->db->group_end();
        }

        $this->db->group_start();
        $this->db->where('Tm.status', 'completed');
        $this->db->where('Tm.remaining_amount >', 0);
        $this->db->group_end();

        if ($workType) {
            $this->db->where('Tm.work_type', $workType);
        }

        if ($searchKey) {
            $searchKey = $this->db->escape_like_str($searchKey);
            $this->db->group_start();
            $this->db->where("CONCAT(clientM.first_name, ' ', clientM.last_name) LIKE '%".$searchKey."%'", NULL, FALSE);
            $this->db->or_where("CONCAT(uM.first_name, ' ', uM.last_name) LIKE '%".$searchKey."%'", NULL, FALSE);
            $this->db->or_like('clientM.mobile', $searchKey);
            $this->db->or_like('clientM.firm_name',$searchKey);
            $this->db->or_like('Tm.job_number', $searchKey);
            $this->db->or_like('clientM.pan_no',$searchKey);
            $this->db->or_like('clientM.gst_no',$searchKey);
            $this->db->or_like('clientM.aadhar_number',$searchKey);
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

}



?>