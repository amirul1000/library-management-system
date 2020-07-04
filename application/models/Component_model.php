<?php

/**
 * Author: Amirul Momenin
 * Desc:Component Model
 */
class Component_model extends CI_Model
{
	protected $component = 'component';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get component by id
	 *@param $id - primary key to get record
	 *
     */
    function get_component($id){
        $result = $this->db->get_where('component',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all component
	 *
     */
    function get_all_component(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('component')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit component
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_component($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('component')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count component rows
	 *
     */
	function get_count_component(){
       $result = $this->db->from("component")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new component
	 *@param $params - data set to add record
	 *
     */
    function add_component($params){
        $this->db->insert('component',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update component
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_component($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('component',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete component
	 *@param $id - primary key to delete record
	 *
     */
    function delete_component($id){
        $status = $this->db->delete('component',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
