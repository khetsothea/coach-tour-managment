Ending:
<select name="ending" style="position:relative; left:55px;" onchange="changetext2(this.value)"><option value="">---select---</option>
	<?php
	foreach ($mmm[$idd] as $sss_item)
	{
		echo '<option value="'.$sss_item['route'].'">'.$sss_item['name'].'</option>';
	}
	?>
</select><br>