<style>
body
{
	text-align:center;
}
h1{
	color:blue;
}
#container
{
	position:relative;
	margin-left:auto;
	margin-right:auto;
	margin-top:20px;
	width:360px;

}
#top
{
	position:relative;
	width:100%;
	height:20px;
	padding:2px;
	background-color:#005B7F;
	text-align:center;
	font-family:Verdana;
	color:white;
	font-size:12pt;
}
#login_form
{
	position:relative;
	width:100%;
	height:230px;
	padding:2px;	
	font-family:Verdana;
	color:white;
	font-size:10pt;
	background-color:#A7A7A7;
}
#welcome_message
{
	text-align:center;
	margin-top:10px;
	margin-bottom:20px;
}
.error
{
	margin:0 auto;
	border:3px solid #d3153b;
	background-color:#fbe6f2;
	padding:5px;
	width:80%;
	text-align:center;
	font-size:18px;
	margin-bottom:20px;
	
}
</style>
</head>
<body>
<h1>--Coach Tour Operator System--</h1>
<?php echo validation_errors(); ?>
<div id="container">
<?php echo form_open('/logging') ?>
<div id="top">
<?php echo "Logging"?>
</div>
<div id="login_form">
<div id="welcome_message">
		<?php echo "Welcome to Coach Tour Operator System. Pleace login using your username and password to continue." ?>
</div>
Username:<br><input type="text" name="username"><br>
Password:<br><input type="password" name="password"><br>
<input type="submit" value="Submit">
</div>
</div>
</form>