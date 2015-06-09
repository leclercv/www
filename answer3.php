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
			if(isset($_SESSION['tmail']))
			{
				echo '<h3>You have sucessfully answered this test ! <br/> Your answers has been sent to : '.$_SESSION['teacher'].' at this adrress : '.$_SESSION['tmail'].'<br>Thank you !</h3><br>';
			}
			?>
			<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'"onclick>Back to menu <span class="glyphicon glyphicon-home"></span></button>
	</center>
</BODY>
</HTML>