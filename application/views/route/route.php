
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('http://localhost/app/index.php/driver/suggest','You have selected one or more rows, these will no longer be selected after your search. Are you sure you want to submit this search?');
    enable_email('http://localhost/opensourcepos/index.php/customers/mailto');
    enable_delete('Are you sure you want to delete the selected customers?','You have not selected any customers to delete');
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

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'http://localhost/opensourcepos/index.php/customers/get_row');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div id="title_bar">
	<div id="title" class="float_left">Driver Details</div>
	<div id="new_button">
		<a href="http://localhost/app/index.php/driver/newDriver/" class="thickbox none" title="New Customer">
		<div class="big_button" style="float: left;"><span>New Driver</span></div></a></div>
</div>
<div id="table_action_header">
	<ul>
		<li class="float_left"><span><a href="http://localhost/app/index.php/driver/setroute/<?php echo $driver_id ?>" id="saveroute">Save Route</a></span></li>
		<li class="float_right">
		  <img src="../../../../../../Users/Thimal/Desktop/Open Source Point of Sale -- Powered by Open Source Point Of Sale_files/spinner_small.gif" alt="spinner" id="spinner" style="display: none;">
		  <form action="http://localhost/app/index.php/driver/search" method="post" accept-charset="utf-8" id="search_form">		<input type="text" name="search" id="search" autocomplete="off" class="ac_input">
	      </form>
	    </li>
	</ul>
</div>
<div id="table_holder">
<table class="tablesorter" id="sortable_table"><thead><tr><th width="6%"><input type="checkbox" id="select_all"></th>
<th width="11%">Route_ID</th>
<th width="16%">Distance</th>
<th width="15%">Duration</th>

<th width="11%">&nbsp;</th></tr>
<?php foreach ($route as $row): ?>

<tr>
<td><input type="checkbox" name="routeid[]" value=<?php echo $row['route_ID']?> ></td>
<td><?php echo $row['route_ID'];?></td>
<td><?php echo $row['distance'];?></td>
<td><?php echo $row['duration'];?></td>

</tr>

<?php endforeach ?>
</thead><tbody></tbody></table></div>

<div id="feedback_bar" class="success_message" style="opacity: 0;"></div>
</div>
</div>
