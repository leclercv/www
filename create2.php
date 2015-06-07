<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		 <center> Vincent Leclercq - Henri Dubois 
		 <br>
		 <h1>e-Testing system</h1>
		 </center>
	</head>
<BODY>
<?php
	if(isset($_SESSION['tok']) && isset($_SESSION['to']))
	{
		echo '<h3>Your test has been succesfully created ! You will receive a mail soon with these informations : </h3>';
		echo '<h5>Token : '.$_SESSION['tok'].'</h5>';
		echo '<h5>The mail has been sent to : '.$_SESSION['to']."</h5></br>";
	}
	else
	{
	echo "<script type='text/javascript'>document.location.replace('create.php');</script>";
	}
?>
<center>
<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'"onclick>Back to menu <span class="glyphicon glyphicon-home"></span></button>
</center>
</BODY>
</HTML>