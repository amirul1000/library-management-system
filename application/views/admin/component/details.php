<a  href="<?php echo site_url('admin/component/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Component'); ?></h5>
<!--Data display of component with id--> 
<?php
	$c = $component;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Component Type</td><td><?php echo $c['component_type']; ?></td></tr>

<tr><td>Author</td><td><?php echo $c['author']; ?></td></tr>

<tr><td>Entry Date</td><td><?php echo $c['entry_date']; ?></td></tr>

<tr><td>Description</td><td><?php echo $c['description']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>


</table>
<!--End of Data display of component with id//--> 