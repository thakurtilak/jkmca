<?php
/** 
 * class Common_model 
 * 		This class contains all commonly used methods in the system
 * @category Controller  
 * @link timesscholar.com
 * @see http://timesscholar.com
 * @copyright  http://www.webdunia.net/
 * @author Webdunia
 * @version    0.1
 * @Timestamp 15.May.2017
 */
class Common_model extends CI_Model {


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



}
/* End of file Common_model.php */
/* Location: ./application/controllers/Common_model.php */