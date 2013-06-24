<script>
function loadXMLDoc(url,cfung,str)
{
	
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=cfung;
	xmlhttp.open("GET",url);
	xmlhttp.send();
	
}

function changetext1(str)
{

	  document.getElementById("lama").innerHTML="";
	  document.getElementById("tama").innerHTML="";
	if (str=="")
	  {
	  document.getElementById("rama").innerHTML="";
	  return;
	  }
loadXMLDoc("/project/index.php/end/"+str,function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("rama").innerHTML=xmlhttp.responseText;
    }
  },str);
}
function changetext2(str)
{

	  document.getElementById("tama").innerHTML="";
	if (str=="")
	  {
	  document.getElementById("lama").innerHTML="";
	  return;
	  }
loadXMLDoc("/project/index.php/time/"+str,function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("lama").innerHTML=xmlhttp.responseText;
    }
  },str);
}

function changetext3(str)
{
	if (str=="")
	  {
	  document.getElementById("tama").innerHTML="";
	  return;
	  }
loadXMLDoc("/project/index.php/details/"+str,function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("tama").innerHTML=xmlhttp.responseText;
    }
  },str);
}
</script>
<style>
a:link {color:#FFFFFF;text-decoration:none;background-color:#002850;}  
a:visited {color:#FFFFFF;text-decoration:none;} 
a:active {color:#0000FF;text-decoration:none;}
a:hover {background-color:#193D62;}
a {
position:absolute;
right:0px;
top:0px;
}
#border{  
margin-top:25px;
margin-bottom:25px;
margin-right:50px;
margin-left:50px;
background-color:#E6E6E6;
padding-top:15px;
padding-bottom:15px;
padding-right:15px;
padding-left:15px;
}
#error{
color:red;
}
h2{
color:#00478F;
}
body{
font-size:80%;
}
#jama{
margin-top:25px;
margin-bottom:25px;
margin-right:900px;
margin-left:50px;
background-color:#FFFF99;
padding-top:15px;
padding-bottom:15px;
padding-right:15px;
padding-left:15px;
}
</style>
</head>
<body>
<p><b><a href='/app/index.php'>logout</a></b></p>
<div id="border">
<div id="error">
<?php echo validation_errors(); ?>
</div>
<?php echo form_open('/book') ?>

<h2>Booking Form</h2>
 

	Full name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="name"><br><br>Address:<br>No:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input
		type="text" name="number">&nbsp&nbsp&nbsp&nbsp&nbspStreet:<input type="text" name="street">&nbsp&nbsp&nbsp&nbsp&nbspCity:<input
		type="text" name="city"><br><br> Telephon No:<br>Home:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text"
		name="telHome">&nbsp&nbsp&nbsp&nbsp&nbspOffice:<input type="text" name="telOffice">Mobile:<input
		type="text" name="telMoblile"><br><br> Route:<br>Starting: <select style="position:relative; left:50px;"
		name="starting" onchange="changetext1(this.value)">
		<option value="">---select---</option>
		<?php
		foreach ($sss as $sss_item)
		{
			echo '<option value="'.$sss_item['id'].'">'.$sss_item['name'].'</option>';
		}
		?>
	</select>
	<div id="rama">
		
	</div>
	<div id="lama">
		
	</div>
	<div id="tama"></div>passengers:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="passengers"> <br><br>
	Starting date:&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="date"><br><br>
	<input type="submit" value="Submit">

</div>

</form>


