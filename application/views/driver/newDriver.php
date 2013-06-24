<h2>Enter New Driver Detail</h2>

<p><?php echo validation_errors(); ?>
  
  <?php echo form_open('driver/newDriver') ?>
 
</p>
<br />

<p>  
Name <br>
  <input type="input" name="name" />
</p>
<p>
Address
<p> 
&nbsp Number<br>
 &nbsp <input type="input" name="number" />
</p>
&nbsp Street
<p>
 &nbsp <input type="input" name="street" />
</p>
&nbsp City
<p>
 &nbsp <input type="input" name="city" />
</p>
</p>
Phone Number
<p>
  <input type="input" name="phoneNo" />
  <br />
  <br/>
  <input type="submit" name="submit" value="Enter New Driver" />
</p>
</form>
