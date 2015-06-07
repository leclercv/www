<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style/style.css" rel="stylesheet" media="all" type="text/css"> 
	</head>
<BODY>
	<center>
	 <div id="title">e-Testing System </div>
		<div id="texte">
			<?php
			if(isset($_SESSION['tok']) && isset($_SESSION['to']))
			{
				echo '<h3>Your test has been succesfully created ! <br/> You will receive a mail soon with these informations : </h3>';
				echo '<h5><b>Token</b> : '.$_SESSION['tok'].'</h5>';
				echo '<h5><b>The mail has been sent to</b> : '.$_SESSION['to']."</h5></br>";
			}
			else
			{
			echo "<script type='text/javascript'>document.location.replace('create.php');</script>";
			}
		?></div>
		<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'">Back to menu <span class="glyphicon glyphicon-home"></span></button>
	</center>

</BODY>
</HTML>