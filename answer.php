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
				<div>
				<input type="text"class="form-control" placeholder="Mail" aria-describedby="basic-addon1" name="mail"/>
		       	<input type="text" class="form-control" placeholder="Token" aria-describedby="basic-addon1" name="key"/>
		       </div>
				<?php
			        if(isset($_POST['valider'])){
			        	$mailconf = "";
			            $mail=$_POST['mail'];
			            $haserr = false;
			            if (!preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $mail)) 
			            {
			            echo '<br><div class="alert alert-danger" role="alert">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  <span class="sr-only">Error:</span>
						  Enter a valid mail address.
						</div>';
						$haserr = true;
						}
			            $token=$_POST['key'];
			            $numail = 0;
			            $req = mysql_query("SELECT Token FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
						list($listtoken)=mysql_fetch_row($req); 
						$tabtoken = explode(" | ", $listtoken);
						$booltok = true;
						$boolmail = true;
						for($a = 0; $a < count($tabtoken); $a++)
						{
							if($tabtoken[$a] == $token)
							{
								$booltok = false;
							}
						}
						if(((!mysql_num_rows($req)) || ($booltok == true)) && ($haserr == false))
			            { 
						echo '<div class="alert alert-danger" role="alert">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  <span class="sr-only">Error:</span>
						  Token not found.
						</div>';
						$haserr = true;
			            }
						$req2 = mysql_query("SELECT Mail FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
						list($listmail)=mysql_fetch_row($req2); 
						$tabmail = explode(" | ", $listmail);
						for($a = 0; $a < count($tabmail); $a++)
						{
							if($tabmail[$a] == $mail)
							{
								$boolmail = false;
							}
						}
						if(((!mysql_num_rows($req2)) || ($boolmail == true)) && ($haserr == false))
						{
						echo '<div class="alert alert-danger" role="alert">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  <span class="sr-only">Error:</span>
						  Mail not found for this token.
						</div>';
							$haserr = true;
						}
						for($i = 0; $i < count($tabmail); $i++)
						{
							if($mail == $tabmail[$i])
							{
								$numail = $i;
							}
						}
						if(($tabtoken[$numail] == $token) && ($mail == $tabmail[$numail])) //Vérification du mail
						{
						$_SESSION['token'] = $token;
			            $_SESSION['mail'] = $mail;
						echo "<script type='text/javascript'>document.location.replace('answer2.php');</script>";
						}
						if(($tabtoken[$numail] != $token) && ($booltok == false) && ($haserr == false))
						{
						echo '<div class="alert alert-danger" role="alert">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  <span class="sr-only">Error:</span>
						  The token and the mail address don\'t match.
						</div>';
						$haserr = true;
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