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
		<link href="style/style.css" rel="stylesheet" media="all" type="text/css"> 
	</head>
	<body>

		<div id="title">Answer an e-Test </div>
		<div id="answer">
			<font color="white">
			<?php
			if (isset($_SESSION['token']) && isset($_SESSION['mail'])){
				$token = $_SESSION['token'];
				$nameuser = "";
				$req = mysql_query("SELECT Mail FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
				list($listmail)=mysql_fetch_row($req); 
				$req = mysql_query("SELECT Name FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
				list($listname)=mysql_fetch_row($req); 
				$tabname = explode(" | ", $listname);
				$tabmail = explode(" | ", $listmail);
				$_SESSION['teacher'] = $tabname[0];
				for($h = 0; $h < count($tabmail); $h++)
				{
					if($_SESSION['mail'] == $tabmail[$h])
					{
						$user = $tabname[$h];
					}
				}
				echo "<h3>Hello ".$user.", have a nice test !</h3>";
				$multrep = "";
				$question = "";
				$answer = "";
				$hasansw = "";
				$videoimage = "";
				$req = mysql_query("SELECT Question FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
				list($question)=mysql_fetch_row($req); 
				$req = mysql_query("SELECT Answer FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
				list($answer)=mysql_fetch_row($req); 
				$req = mysql_query("SELECT GAnswer FROM Form WHERE Token LIKE '%".$token."%'") or exit(mysql_error());
				list($videoimage)=mysql_fetch_row($req); 
				$tabquest = explode(" | ", $question);
				$tabansw = explode(" | ", $answer);
				$tabvideoimage = explode(" | ", $videoimage);
				echo "<form method='post'>";
				for($i = 0; $i < count($tabquest); $i++){
					echo "<h1>".substr($tabquest[$i], 1)."</h1>";
					if($tabvideoimage[$i] != "!" && strstr($tabvideoimage[$i],"youtube"))
					{
						if(substr($tabvideoimage[$i], 0, 5) == "https")
						{
						echo "<br> <iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/".substr($tabvideoimage[$i], 32)."\" frameborder=\"0\" allowfullscreen></iframe><br>";
						}
						if(substr($tabvideoimage[$i], 0, 5) == "http:")
						{
						echo "<br> <iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/".substr($tabvideoimage[$i], 31)."\" frameborder=\"0\" allowfullscreen></iframe><br>";
						}
					}
					if($tabvideoimage[$i] != "!" && !(strstr($tabvideoimage[$i],"youtube")))
					{
						echo "<br><img src=\"".$tabvideoimage[$i]."\"width=\"420\" height=\"315\"><br> ";
					}
					if($tabquest[$i]{0} == 1){
						$tabanswcourant = explode(" _ ", $tabansw[$i]);
							for($a = 0; $a < count($tabanswcourant); $a++)
							{
								echo '<input type="checkbox" name="'.$i.'cansw'.$a.'" value=" '.$tabanswcourant[$a].'">'.$tabanswcourant[$a]."&nbsp;&nbsp;";
							}
					}
					if($tabquest[$i]{0} == 0){
						$tabanswcourant = explode(" _ ", $tabansw[$i]);
							for($a = 0; $a < count($tabanswcourant); $a++){
								if($a == 0)
								{
									echo '<input type="radio" name="ransw'.$i.'" value=" '.$tabanswcourant[$a].'">'.$tabanswcourant[$a]."&nbsp;&nbsp;";
								}
								else
								{
									echo '<input type="radio" name="ransw'.$i.'" value=" '.$tabanswcourant[$a].'">'.$tabanswcourant[$a]."&nbsp;&nbsp;";
								}
							}
					}
				}
				echo '<br><br><input name ="valider2" class="btn btn-success btn-lg" type="submit" value="OK">';
		
				if(isset($_POST['valider2'])){
					for($z = 0 ; $z < count($tabquest) ; $z++){
						$hasansw = $hasansw.substr($tabquest[$z], 1)." : ";
						$tabanswcourant = explode(" _ ", $tabansw[$z]);
						if($tabquest[$z]{0} == 1){
							$multrep = "";
							for($y = 0; $y < count($tabanswcourant); $y++){
								if(isset($_POST[$z.'cansw'.$y])){
									$multrep = $multrep.$_POST[$z.'cansw'.$y]." / ";
								}
							}
							$multrep = substr($multrep, 0, -2);
							$hasansw = $hasansw.$multrep."\n";
						}
						if($tabquest[$z]{0} == 0){
							$multrep = "";
							for($x = 0; $x < count($tabanswcourant); $x++){
								if(isset($_POST['ransw'.$z])){
									$multrep = $_POST['ransw'.$z]." ";
								}
							}
							$hasansw = $hasansw.$multrep."\n";
						}
					}
					$listmail = "";
					$hasansw = "The user ".$user." "."has answered your test ! Here are his answers : \n".$hasansw;
					mail($tabmail[0], 'Someone has answered your test !', $hasansw);
					$_SESSION['tmail'] = $tabmail[0];
					echo "<script type='text/javascript'>document.location.replace('answer3.php');</script>";
				}
			}
			else{
				echo "<script type='text/javascript'>document.location.replace('answer.php');</script>";
			}
		?>
		<button type='button' class='btn btn-danger btn-lg' onclick="self.location.href='index.php'">Back to menu <span class='glyphicon glyphicon-home'></span></button>
		</font>
		<?php
			echo "</form>";
		?>

</div>
</body>
</html>