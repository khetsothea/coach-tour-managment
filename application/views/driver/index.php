
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('http://localhost/app/index.php/driver/suggest','You have selected one or more rows, these will no longer be selected after your search. Are you sure you want to submit this search?');
    //enable_email('http://localhost/opensourcepos/index.php/customers/mailto');
   // enable_delete('Are you sure you want to delete the selected customers?','You have not selected any customers to delete');
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}


</script>

<div id="title_bar">
	<div id="title" class="float_left">Driver Details</div>
	<div id="new_button">
		<a href="http://localhost/app/index.php/driver/newDriver/" class="thickbox none" title="New Driver">
		<div class="big_button" style="float: left;"><span>New Driver</span></div></a></div>
</div>

<div id="table_action_header">
	<ul>
		
		<li class="float_right">
		
		  <img src="images/spinner_small.gif" alt="spinner" id="spinner" style="display: none;">
		  <form action="http://localhost/app/index.php/driver/search" method="post" accept-charset="utf-8" id="search_form">		<input type="text" name="search" id="search" >
	      </form>
		  
	    </li>
	</ul>
</div>

<div id="table_holder">
<table  class="tablesorter" id="sortable_table"><thead><tr><th width="6%"><input type="checkbox" id="select_all"></th>
<form name="form" id="sortable_table" action="http://localhost/app/index.php/driver/delete" method="post">
<th width="11%">Driver ID</th>
<th width="15%">Name</th>
<th width="11%">Route ID's</th>
<th width="8%">No</th>
<th width="11%">Street</th>
<th width="11%">City</th>
<th width="15%" >Phone Number</th>
<th width="5%">&nbsp;</th></tr>

<?php foreach ($driver as $row): ?>

<tr>
<td><input type="checkbox" name="ids[]" id="delete" value="<?php echo $row['driver_ID'] ?>" ></td>
<td ><?php echo $row['driver_ID'];?></td>
<td ><?php echo $row['name'];?></td>
<td ><?php echo $driver_route[$row['driver_ID']];?></td>
<td ><?php echo $row['num'];?></td>
<td ><?php echo $row['street'];?></td>
<td ><?php echo $row['city'];?></td>
<td ><?php echo $driver_tel[$row['driver_ID']][0]['telephonNum'] ;?></td>
<td><a href="http://localhost/app/index.php/driver/addRoute/<?php echo $row['driver_ID'] ?>" id="addroute">Add route</a></td>
</tr>

<?php endforeach ?>

<input name="delete" id="delete" type="submit" value="Delete" class="small_button"/>
</form>
</thead><tbody></tbody></table></div>

<div id="feedback_bar" class="success_message" style="opacity: 0;"></div>
</div>
</div>
