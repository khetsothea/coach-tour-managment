<script>
setInterval(function(){document.location = "/app/index.php/assign";},5000);
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
h2{
color:#00478F;
}
body{
font-size:80%;
}
</style> 
</head>
<body>
<p><b><a href='/app/index.php'>logout</a></b></p>
<div id="border">
<h2>Scheduling Window</h2>
<?php
foreach ($assign as $item){
	echo form_open('/submit/'.$item['tour_id']);
	echo "Tour no ".$item['tour_id']." :"."<select name='driver'><option value=''>--select driver--</option>";
	foreach($driver[$item['tour_id']] as $dItem){
		echo "<option value='".$dItem['driver_id']."'>".$dItem['name']."</option>";
	}
	echo "</select><select name='coach'><option value=''>--select coach--</option>";
	foreach($coach[$item['tour_id']] as $cItem){
		echo "<option value='".$cItem['coach_id']."'>".$cItem['coach_id']."</option>";
	}	
	echo "</select>";
	echo "<input type='submit' value='Submit'></form>";
}
echo "<br><br>"
?>
</div>