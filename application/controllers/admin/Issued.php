<?php

 /**
 * Author: Amirul Momenin
 * Desc:Issued Controller
 *
 */
class Issued extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Issued_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of issued table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['issued'] = $this->Issued_model->get_limit_issued($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/issued/index');
		$config['total_rows'] = $this->Issued_model->get_count_issued();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/issued/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save issued
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'collector_users_id' => html_escape($this->input->post('collector_users_id')),
'issued_by_users_id' => html_escape($this->input->post('issued_by_users_id')),
'component_id' => html_escape($this->input->post('component_id')),
'date_issued' => html_escape($this->input->post('date_issued')),
'date_return' => html_escape($this->input->post('date_return')),
'comment' => html_escape($this->input->post('comment')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['issued'] = $this->Issued_model->get_issued($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Issued_model->update_issued($id,$params);
				$this->session->set_flashdata('msg','Issued has been updated successfully');
                redirect('admin/issued/index');
            }else{
                $data['_view'] = 'admin/issued/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $issued_id = $this->Issued_model->add_issued($params);
				$this->session->set_flashdata('msg','Issued has been saved successfully');
                redirect('admin/issued/index');
            }else{  
			    $data['issued'] = $this->Issued_model->get_issued(0);
                $data['_view'] = 'admin/issued/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details issued
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['issued'] = $this->Issued_model->get_issued($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/issued/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting issued
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $issued = $this->Issued_model->get_issued($id);

        // check if the issued exists before trying to delete it
        if(isset($issued['id'])){
            $this->Issued_model->delete_issued($id);
			$this->session->set_flashdata('msg','Issued has been deleted successfully');
            redirect('admin/issued/index');
        }
        else
            show_error('The issued you are trying to delete does not exist.');
    }
	
	/**
     * Search issued
	 * @param $start - Starting of issued table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('collector_users_id', $key, 'both');
$this->db->or_like('issued_by_users_id', $key, 'both');
$this->db->or_like('component_id', $key, 'both');
$this->db->or_like('date_issued', $key, 'both');
$this->db->or_like('date_return', $key, 'both');
$this->db->or_like('comment', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['issued'] = $this->db->get('issued')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/issued/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('collector_users_id', $key, 'both');
$this->db->or_like('issued_by_users_id', $key, 'both');
$this->db->or_like('component_id', $key, 'both');
$this->db->or_like('date_issued', $key, 'both');
$this->db->or_like('date_return', $key, 'both');
$this->db->or_like('comment', $key, 'both');

		$config['total_rows'] = $this->db->from("issued")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/issued/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export issued
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'issued_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $issuedData = $this->Issued_model->get_all_issued();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Collector Users Id","Issued By Users Id","Component Id","Date Issued","Date Return","Comment"); 
		   fputcsv($file, $header);
		   foreach ($issuedData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $issued = $this->db->get('issued')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/issued/print_template.php');
			$html = ob_get_clean();
			include(APPPATH."third_party/mpdf60/mpdf.php");					
			$mpdf=new mPDF('','A4'); 
			//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
			//$mpdf->mirrorMargins = true;
		    $mpdf->SetDisplayMode('fullpage');
			//==============================================================
			$mpdf->autoScriptToLang = true;
			$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
			$mpdf->autoVietnamese = true;
			$mpdf->autoArabic = true;
			$mpdf->autoLangToFont = true;
			$mpdf->setAutoBottomMargin = 'stretch';
			$stylesheet = file_get_contents(APPPATH."third_party/mpdf60/lang2fonts.css");
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			//$mpdf->AddPage();
			$mpdf->Output($filePath);
			$mpdf->Output();
			//$mpdf->Output( $filePath,'S');
			exit;	
	  }
	   
	}
}
//End of Issued controller