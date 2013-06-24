<h2>Enter New Route Detail</h2>

<p><?php echo validation_errors(); ?>
  
  <?php echo form_open('route/newRoute') ?>
 
</p>
<br />

<p> 
Distance<br>
  <input type="input" name="distance" />
</p>
<br/>
<div id="table_holder">
<table class="tablesorter" id="sortable_table"><thead><tr><th width="6%"><input type="checkbox" id="select_all"></th>
<th width="11%">Town ID</th>
<th width="16%">Name</th>
<th width="5%">Order</th>

<th width="11%">&nbsp;</th></tr>
<?php foreach ($town as $row): ?>

<tr>
<td><input type="checkbox" name="idd[]" value="<?php echo $row['town_ID'] ?>" ></td>
<td><?php echo $row['town_ID'];?></td>
<td><?php echo $row['name'];?></td>
<td>  <input type="input" name="order<?php echo $row['town_ID']  ?>" size="5" /></td>

</tr>

<?php endforeach ?>
</thead><tbody></tbody></table></div>
  <br />
  <br/>
  <input type="submit" name="submit" value="Enter New Route" />
</p>
</form>
