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
		<center> Vincent Leclercq - Henri Dubois 
		 <br>
		 <h1>e-Testing system</h1>
	</head>
	<body>
		<br>	
		<p> <h2>Enter your mail address, your token and then click "OK"</h2> </p>
		<br>
		<div class="input-group">

			<form name="validation" method="post">

				<input type="text"class="form-control" placeholder="Mail" aria-describedby="basic-addon1" name="mail"/>
		       	<input type="text" class="form-control" placeholder="Token" aria-describedby="basic-addon1" name="key"/></br>
				<?php
			        if(isset($_POST['valider'])){
			        	$mailconf = "";
			            $mail=$_POST['mail'];
			            $token=$_POST['key'];
			            $_SESSION['token'] = $token;
			            $req = mysql_query("SELECT Token FROM Form WHERE Token = '" . $token . "'") or exit(mysql_error());
						if (mysql_num_rows($req) == 1)// Vérification du Token
						{
						    echo 'Ok';
							$req = mysql_query("SELECT Mail FROM Form WHERE Token = '".$token."'") or exit(mysql_error());
							list($mailconf)=mysql_fetch_row($req); 
							if(strstr($mailconf,$mail)) //Vérification du mail
							{
								echo "mailmatch";
								echo "<script type='text/javascript'>document.location.replace('answer2.php');</script>";
							}
						}			            
			        }
		    	?>
		    	
		        <center>
		        <input name ="valider" class="btn btn-success btn-lg" type="submit" onclick; value="OK">
    		</form>
    		
    		<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'"onclick>Back to menu <span class="glyphicon glyphicon-home"></span></button>
    		</center>
    	</div>

    </center>
	</body>
</html>