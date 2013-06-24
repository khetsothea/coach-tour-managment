<h2>Enter New Coach Detail</h2>

<p><?php echo validation_errors(); ?>
  
  <?php echo form_open('coach/newCoach') ?>
 
</p>
<br />

<p>  
Capacity <br>
  <input type="input" name="capacity" />
</p>

<p> 
Mileage(km)<br>
  <input type="input" name="mileage" />
</p>


  <br/>
  <input type="submit" name="submit" value="Enter New Coach" />
</p>
</form>
