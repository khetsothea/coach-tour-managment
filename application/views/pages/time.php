Time:
<select name="time" style="position:relative; left:70px;" onchange="changetext3(this.value)"><option value="">---select---</option>
	<?php
	foreach ($hhh as $sss_item)
	{
		echo '<option value="'.$sss_item['trip'].'">'.$sss_item['starttime'].'</option>';
	}
	?>
</select><br>