<a  href="<?php echo site_url('admin/issued/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Issued'); ?></h5>
<!--Data display of issued with id--> 
<?php
	$c = $issued;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Collector Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['collector_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Issued By Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['issued_by_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Component</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Component_model');
									   $dataArr = $this->CI->Component_model->get_component($c['component_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Date Issued</td><td><?php echo $c['date_issued']; ?></td></tr>

<tr><td>Date Return</td><td><?php echo $c['date_return']; ?></td></tr>

<tr><td>Comment</td><td><?php echo $c['comment']; ?></td></tr>


</table>
<!--End of Data display of issued with id//--> 