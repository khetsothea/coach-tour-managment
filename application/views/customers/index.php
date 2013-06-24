
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
	<div id="title" class="float_left">Customer Details</div>
	
</div>
<div id="table_action_header">
	<ul>
		<li class="float_left"><span><a href="http://localhost/app/index.php/driver/delete" id="delete">Delete</a></span></li>
		<li class="float_right">
		  <img src="images/spinner_small.gif" alt="spinner" id="spinner" style="display: none;">
		  <form action="http://localhost/app/index.php/driver/search" method="post" accept-charset="utf-8" id="search_form">		<input type="text" name="search" id="search" autocomplete="off" class="ac_input">
	      </form>
	    </li>
	</ul>
</div>
<div id="table_holder">
<table class="tablesorter" id="sortable_table"><thead><tr><th width="6%"><input type="checkbox" id="select_all"></th>
<th width="11%">Customer ID</th>
<th width="16%">Name</th>
<th width="12%">Number</th>
<th width="11%">Street</th>
<th width="5%">City</th>
<th width="13%">Phone Number</th>
<th width="11%">&nbsp;</th></tr>
<?php foreach ($customer as $row): ?>

<tr>
<td><input type="checkbox" name="idd[]" value="<?php echo $row['individual_ID'] ?>" ></td>
<td><?php echo $row['individual_ID'];?></td>
<td><?php echo $row['name'];?></td>
<td><?php echo $row['num'];?></td>
<td><?php echo $row['street'];?></td>
<td><?php echo $row['city'];?></td>
<td> <?php echo $customer_tel[$row['individual_ID']][0]['telephonNum']?></td>

</tr>

<?php endforeach ?>
</thead><tbody></tbody></table></div>
<div id="feedback_bar" class="success_message" style="opacity: 0;"></div>
</div>
</div>
