<?php
session_start();
$base = mysql_connect ('localhost', 'root', 'root');
mysql_select_db ('etest', $base) ;
mysql_query("SET NAMES UTF8"); 
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/style.css" rel="stylesheet" media="all" type="text/css"> 
		<center> 
	</head>
	<body>
		 <div id="title">Answer an e-Test </div>
		 <br>	
		 <p> <div id="create"><font color="white"><h3>Enter your mail address, your token and then click 'OK'.</h3></font></div> </p>
		 <br>
		 <div class="input-group">

			<form name="validation" method="post">

				<input type="text"class="form-control" placeholder="Mail" aria-describedby="basic-addon1" name="mail"/>
		       	<input type="text" class="form-control" placeholder="Token" aria-describedby="basic-addon1" name="key"/>
				<?php
			        if(isset($_POST['valider'])){
			        	$mailconf = "";
			            $mail=$_POST['mail'];
			            $token=$_POST['key'];
			            $_SESSION['token'] = $token;
			            $_SESSION['mail'] = $mail;
			            $req = mysql_query("SELECT Token FROM Form WHERE Token = '" . $token . "'") or exit(mysql_error());
						if (mysql_num_rows($req) == 1)// Vérification du Token
						{
							$req = mysql_query("SELECT Mail FROM Form WHERE Token = '".$token."'") or exit(mysql_error());
							list($mailconf)=mysql_fetch_row($req); 
							if(strstr($mailconf,$mail)) //Vérification du mail
							{
								echo "<script type='text/javascript'>document.location.replace('answer2.php');</script>";
							}
						}			            
			        }
		    	?>
		    	
		        <center>
		        </div>
		        <br/><input name ="valider" class="btn btn-success btn-lg" type="submit" onclick; value="OK">
    		</form>
    		
    		<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'"onclick>Back to menu <span class="glyphicon glyphicon-home"></span></button>
    		</center>

    </center>
	</body>
</html>