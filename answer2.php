<?php
session_start();
$base = mysql_connect ('localhost', 'root', 'root');
mysql_select_db ('etest', $base) ;
mysql_query("SET NAMES UTF8"); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<center> Vincent Leclercq - Henri Dubois 
		 <br>
		 <h1>e-Testing system</h1>
		 </center>
	</head>
	<body>
<?php
		$token = $_SESSION['token'];
		$question = "";
		$answer = "";
		$hasansw = "";
		$req = mysql_query("SELECT Question FROM Form WHERE Token = '".$token."'") or exit(mysql_error());
		list($question)=mysql_fetch_row($req); 
		$req = mysql_query("SELECT Answer FROM Form WHERE Token = '".$token."'") or exit(mysql_error());
		list($answer)=mysql_fetch_row($req); 
		$tabquest = explode(" | ", $question);
		$tabansw = explode(" | ", $answer);
		echo "<form method='post'>";
		for($i = 0; $i < count($tabquest); $i++)
		{
			if($tabquest[$i]{0} == 1)
			{
				echo "<h1>".substr($tabquest[$i], 1)."</h1>";
				$tabanswcourant = explode(" _ ", $tabansw[$i]);
					for($a = 0; $a < count($tabanswcourant); $a++)
					{
						echo '<input type="checkbox" name="answ'.$i.'" value="'.$tabanswcourant[$a].'">'.$tabanswcourant[$a].'<br>';
					}
			}
			if($tabquest[$i]{0} == 0)
			{
				echo "<h1>".substr($tabquest[$i], 1)."</h1>";
				$tabanswcourant = explode(" _ ", $tabansw[$i]);
					for($a = 0; $a < count($tabanswcourant); $a++)
					{
						if($a == 0)
						{
						echo '<input type="radio" name="answ'.$i.'" value="'.$tabanswcourant[$a].'" checked>'.$tabanswcourant[$a].'<br>';
						}
						else
						{
						echo '<input type="radio" name="answ'.$i.'" value="'.$tabanswcourant[$a].'">'.$tabanswcourant[$a].'<br>';
						}
					}
			}
		}
				echo '<br><input name ="valider2" class="btn btn-success btn-lg" type="submit" value="OK">';
				echo "</form>";
				if(isset($_POST['valider2'])){
					echo "lol";
				for($z = 0 ; $z < count($tabquest) ; $z++)
				{
				$hasansw = $hasanw.substr($tabquest[$z], 1)." : ";

				}
			}
?>
	</body>
</html>