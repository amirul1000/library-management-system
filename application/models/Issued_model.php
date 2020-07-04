<?php

/**
 * Author: Amirul Momenin
 * Desc:Issued Model
 */
class Issued_model extends CI_Model
{
	protected $issued = 'issued';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get issued by id
	 *@param $id - primary key to get record
	 *
     */
    function get_issued($id){
        $result = $this->db->get_where('issued',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all issued
	 *
     */
    function get_all_issued(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('issued')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit issued
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_issued($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('issued')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count issued rows
	 *
     */
	function get_count_issued(){
       $result = $this->db->from("issued")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new issued
	 *@param $params - data set to add record
	 *
     */
    function add_issued($params){
        $this->db->insert('issued',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update issued
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_issued($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('issued',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete issued
	 *@param $id - primary key to delete record
	 *
     */
    function delete_issued($id){
        $status = $this->db->delete('issued',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
