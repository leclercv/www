<?php
session_start();
$base = mysql_connect ('localhost', 'root', 'root');
mysql_select_db ('etest', $base) ;
mysql_query("SET NAMES UTF8"); 
?>
<HTML>
<HEAD>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript" language="Javascript" src="jquery.js"></script>
	<script type="text/javascript">

	questions = new Array;
	mails = new Array;
	var i = 0;
	var itotal = 0;
	var ip= 0;

		$(function() {
			$("#verify").click(function(){
				//Gestion des erreurs
				var messagerrorfinal ="";

				var messagerrortype = "";
				var questionerrortype = "";
				var lasterrortype = null;

				var messagerrortitle = "";
				var questionerrortitle = "";
				var lasterrortitle = null;
				var cpterrortitle = 0;


				var messagerrorprop = "";
				var questionerrorprop = "";

				var cpterror = 0;

				//type

				for(var cpt =1;cpt<=i;cpt++){
					if($("#typequestion"+cpt).val() == 'choose'){
						questionerrortype = questionerrortype + " " + cpt;  
						lasterrortype = cpt;
						cpterror++;	
						messagerrortype = "You didn't choose any type for question " + questionerrortype;
					}
				}

				if(cpterror > 1){
					messagerrortype = "You didn't choose any type for questions";
					questionerrortype = questionerrortype.substring(0, questionerrortype.length-1);
					questionerrortype = questionerrortype + " & " + lasterrortype;
					messagerrortype = messagerrortype + questionerrortype;
				}

				//intitule de question

				for(var cpt =1;cpt<=i;cpt++){
					if($("#question"+cpt).val() == ''){
						questionerrortitle = questionerrortitle + " " + cpt;  
						lasterrortitle = cpt;
						cpterror++;
						cpterrortitle++;
					}
				}

				if(cpterrortitle > 1){
					messagerrortitle = "You left an empty field at the questions";
					questionerrortitle = questionerrortitle.substring(0, questionerrortitle.length-1);
					questionerrortitle = questionerrortitle + "& " + lasterrortitle;
					messagerrortitle = messagerrortitle + questionerrortitle;
				}
				else{
					messagerrortitle = "You left an empty field at question " + questionerrortitle; 
				}

				//Les propositions
				
				var compteurprop = 0;

					for(var cptprop =1;cptprop<=i;cptprop++){
						nbprop = questions[compteurprop].toString().split("Proposition").length-2;
						for(var scpt =1;scpt<=nbprop;scpt++){
							if($("#question"+cptprop+"proposition"+scpt).val() == ''){
								messagerrorprop = " \n You left an empty field at the proposition " + scpt + " of the question " + cptprop ;
								cpterror++;
							}
						}
						compteurprop ++;
					}

				//prof
				 	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			        var emailaddressVal = $("#teachermail").val();
			         
			        if(emailaddressVal == '') {
			            messagerrormail = "Teacher\'s mail field is empty \n";
			            cpterror++;
			        } else if(!emailReg.test(emailaddressVal)) {
						messagerrormail = "Teacher's mail address is incorrect \n";
			            cpterror++;
			        } 

			        //eleves

			        for(var cptbis = 1;cptbis<=nbmail;cptbis++){
			        	emailaddressVal =  	$("#studentmail"+cptbis).val();
				   		if(emailaddressVal == '') {
			            	messagerrormail = messagerrormail + "The mail address field of student "+cptbis+" is empty \n";
			            	cpterror++;
			      		}else if(!emailReg.test(emailaddressVal)) {
							messagerrormail = messagerrormail + "The mail address of student "+cptbis+" is incorrect \n";
			         	   cpterror++;
			        	} 
					}

				//Concatenation des messages d'erreurs

				messagerrorfinal = cpterror + " errors have been detected : \n" + messagerrortype + "\n" + messagerrortitle + messagerrorprop + "\n" + messagerrormail;

				if(cpterror==0){
					alert("There is no error in your test :)");
				}
				else{
					alert(messagerrorfinal);
				}
			});
		});


	$(function() {
		$("#valider").click(function(){
			var resultat = "";
			var resultatrep = "";
			var resultatfinal = "";
			var resultatrepfinal = "";
			var listemail ="";

			//On parcours les intitulés de questions

			for(var cpt =1;cpt<=i;cpt++){
				resultat = resultat + $("#typequestion"+cpt).val() + $("#question"+cpt).val() + " | ";
			}

			var compteur = 0;

			//Les propositions

			for(var cptprop =1;cptprop<=i;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-3;
				for(var scpt =1;scpt<=nbprop;scpt++){
					resultatrep = resultatrep + $("#question"+cptprop+"proposition"+scpt).val() + " _ ";
				}
				resultatrep = resultatrep.substring(0, resultatrep.length-3);
				resultatrep = resultatrep + " | ";
				compteur ++;
			}

			resultatrepfinal = resultatrep.substring(0, resultatrep.length-3);
			resultatfinal = resultat.substring(0, resultat.length-3);

			// Les mails

				var listemail = $("#teachermail").val();

				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
			   		listemail = listemail + " | "+$("#studentmail"+cptbis).val();
				}

				//Gestion des erreurs
				var messagerrorfinal ="";

				var messagerrortype = "";
				var questionerrortype = "";
				var lasterrortype = null;

				var messagerrortitle = "";
				var questionerrortitle = "";
				var lasterrortitle = null;
				var cpterrortitle = 0;

				var messagerrorprop = "";
				var questionerrorprop = "";

				var messagerrormail = "";
				var nberrormail = "";

				var cpterror = 0;

				//type

				for(var cpt =1;cpt<=i;cpt++){
					if($("#typequestion"+cpt).val() == 'choose'){
						questionerrortype = questionerrortype + " " + cpt;  
						lasterrortype = cpt;
						cpterror++;	
						messagerrortype = "You didn't choose any type for question " + questionerrortype;
					}
				}

				if(cpterror > 1){
					messagerrortype = "You didn't choose any type for questions";
					questionerrortype = questionerrortype.substring(0, questionerrortype.length-1);
					questionerrortype = questionerrortype + " & " + lasterrortype;
					messagerrortype = messagerrortype + questionerrortype;
				}
				
				//intitule de question

				for(var cpt =1;cpt<=i;cpt++){
					if($("#question"+cpt).val() == ''){
						questionerrortitle = questionerrortitle + " " + cpt;  
						lasterrortitle = cpt;
						cpterrortitle++;
						cpterror++;
					}
				}

				if(cpterrortitle > 1){
					messagerrortitle = "You left an empty field at the questions";
					questionerrortitle = questionerrortitle.substring(0, questionerrortitle.length-1);
					questionerrortitle = questionerrortitle + "& " + lasterrortitle;
					messagerrortitle = messagerrortitle + questionerrortitle;
				}
				else{
					messagerrortitle = "You left an empty field at question " + questionerrortitle; 
				}

				//Les propositions
				
					var compteurprop = 0;

					for(var cptprop =1;cptprop<=i;cptprop++){
						nbprop = questions[compteurprop].toString().split("Proposition").length-2;
						for(var scpt =1;scpt<=nbprop;scpt++){
							if($("#question"+cptprop+"proposition"+scpt).val() == ''){
								messagerrorprop = " \n You left an empty field at the proposition " + scpt + " of the question " + cptprop ;
								cpterror++;
							}
						}
						compteurprop ++;
					}

				//Les mails

					//prof
				 	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			        var emailaddressVal = $("#teachermail").val();
			         
			        if(emailaddressVal == '') {
			            messagerrormail = "Teacher\'s mail field is empty \n";
			            cpterror++;
			        } else if(!emailReg.test(emailaddressVal)) {
						messagerrormail = "Teacher's mail address is incorrect \n";
			            cpterror++;
			        } 

			        //eleves

			        for(var cptbis = 1;cptbis<=nbmail;cptbis++){
			        	emailaddressVal =  	$("#studentmail"+cptbis).val();
				   		if(emailaddressVal == '') {
			            	messagerrormail = messagerrormail + "The mail address field of student "+cptbis+" is empty \n";
			            	cpterror++;
			      		}else if(!emailReg.test(emailaddressVal)) {
							messagerrormail = messagerrormail + "The mail address of student "+cptbis+" is incorrect \n";
			         	   cpterror++;
			        	} 
					}

				//Concatenation des messages d'erreurs

				messagerrorfinal = cpterror + " errors have been detected : \n" + messagerrortype + "\n" + messagerrortitle + messagerrorprop + "\n" + messagerrormail;

				if(cpterror==0){
					var reponse = resultatfinal + " ~ " + resultatrepfinal + " ~ " + listemail;
					alert("Questions : " +resultatfinal  + " \n \n Réponses : " + resultatrepfinal + " \n \n Mails : " + listemail);
					document.getElementById('final').innerHTML = "<form method='post'><input name='validation' type='submit' value='"+reponse+"'/></form>";
				}
				else{
					alert(messagerrorfinal);
				}
		});
	});

	$(function(){
		$("#nouveauInput").click(function(){
			i++;
			itotal = i;
		    questions.push(
		    "<h2>Question " + i + "</h2><input type ='text' name ='question" + i + "' id='question" + i +"' value='' size=80/><br/><br/><input type='button' id='nouveauProposition"+i+"' onclick='nouveauProposition("+i+")' value='Add an answer'style='height:80px; width:200px'/><select id='typequestion"+i+"'><option value='0'>One correct answer</option><option value='1'>Multiple correct answers</option><option selected='selected' style='display:none' value='choose'>Choose the type of question "+i+"</option></select><br/><br/>");

		    var contenu = "";

		    for(var cpt = 0;cpt<i;cpt++){
		   		contenu = contenu + questions[cpt];
			}

			//Sauvegarder les valeurs des inputs : 

			//Les questions
			var contenuquestion = new Array;

			for(var cptbis = 1;cptbis<i;cptbis++){
		   		contenuquestion[cptbis] = $("#question"+cptbis).val();
			}

			//Les Propositions
			contenuproposition = new Array;
			var indextab = 0;
			var compteur = 0;

			for(var cptprop =1;cptprop<=i;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-2;
				for(var scpt =1;scpt<=nbprop;scpt++){
					contenuproposition[indextab] = $("#question"+cptprop+"proposition"+scpt).val();
					indextab++;
				}
				
				compteur ++;
			}

			//Les types des questions

			questiontype = new Array;

			if(i>1){
				for(var cptbis = 1;cptbis<itotal;cptbis++){
			   		questiontype[cptbis] = $("#typequestion"+cptbis).val();
				}
			}
			
		    document.getElementById('questions').innerHTML = contenu;

		    //Remettre les valeurs des inputs

		    //Les questions
			for(var cptbis = 1;cptbis<i;cptbis++){
	   			$("#question"+cptbis).val(contenuquestion[cptbis]);
			}

			//Les propositions
			var indextab = 0;
			var compteur = 0;

			for(var cptprop =1;cptprop<=i;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-2;
				for(var scpt =1;scpt<=nbprop;scpt++){
					$("#question"+cptprop+"proposition"+scpt).val(contenuproposition[indextab]);
					indextab++;
				}
			}

			//Les types des questions
			if(i>1){
				for(var cptbis = 1;cptbis<itotal;cptbis++){
			   		$("#typequestion"+cptbis).val(questiontype[cptbis]);
				}
			}
			compteur ++;
		    ip = 0;
		});
	});

		function nouveauProposition (i){
			ip++;
			var numproposition = questions[i-1].toString().split("Proposition").length-2;
		    questions[i-1] = questions[i-1] + "Proposition   "+numproposition+"<input type='text' name='proposition"+ip+"' id='question"+i+"proposition"+numproposition+"'value=''size=50/><br/>";

			//Sauvegarder les valeurs des inputs : 

			//Les questions
			var contenuquestion = new Array;

			for(var cptbis = 1;cptbis<=itotal;cptbis++){
		   		contenuquestion[cptbis] = $("#question"+cptbis).val();
			}

			//Les Propositions
			contenuproposition = new Array;
			var indextab = 0;
			var compteur = 0;

			for(var cptprop =1;cptprop<=itotal;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-2;
				for(var scpt =1;scpt<=nbprop;scpt++){
					contenuproposition[indextab] = $("#question"+cptprop+"proposition"+scpt).val();
					indextab++;
				}
				compteur ++;
			}

			//Les types des questions

			questiontype = new Array;

			for(var cptbis = 0;cptbis<=itotal;cptbis++){
		   		questiontype[cptbis] = $("#typequestion"+cptbis).val();
			}

			document.getElementById('questions').innerHTML = questions;

			//Remettre les valeurs des inputs

		    //Les questions
			for(var cptbis = 0;cptbis<=itotal;cptbis++){
	   			$("#question"+cptbis).val(contenuquestion[cptbis]);
			}

			//Les propositions
			var indextab = 0;
			var compteur = 0;

			for(var cptprop =1;cptprop<=itotal;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-2;
				for(var scpt =1;scpt<=nbprop;scpt++){
					$("#question"+cptprop+"proposition"+scpt).val(contenuproposition[indextab]);
					indextab++;
				}
				
			//Les types des questions
			for(var cptbis = 1;cptbis<=itotal;cptbis++){
		   		$("#typequestion"+cptbis).val(questiontype[cptbis]);
			}

				compteur ++;
			}

		}	

		var nbmail = 0;

		$(function(){
			$("#nouveauMail").click(function(){   
				nbmail ++;

				mails.push(nbmail + "<input type='text' name='studentmail"+nbmail+"' id='studentmail"+nbmail+"' value='' size=30/><br/>");

				var contenumail = "";

			    for(var cpt = 0;cpt<nbmail;cpt++){
			   		contenumail = contenumail + mails[cpt];
				}

				contenumailfinal = "<input type='text' name='teachermail' id='teachermail' placeholder='Enter your mail address here' value='' style='background-color: #00FF66;' size=30/><br/></br>" + contenumail;
				
				//Sauvegarder les valeurs des inputs : 

				//Le mail de l'enseignant
				var mailprof= $("#teachermail").val();

				//Les mails des élèves
				var arraymail = new Array;

				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
					arraymail[cptbis] = $("#studentmail"+cptbis).val();
				}

			    document.getElementById('mails').innerHTML = contenumailfinal;

			    //Remettre les valeurs des inputs : 

			    //Le mail de l'enseignant
				$("#teachermail").val(mailprof);

				//Les mails des élèves
				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
				   	$("#studentmail"+cptbis).val(arraymail[cptbis]);
				}
			});
		});  

	</script>

</HEAD>
<BODY>

	<h1> Questions : </h1>
	<div id='questions'></div><br/><br/>
	<input type='button' id='nouveauInput' style='height:80px; width:200px' value='Add a question'/><br/> <br/>
	<h1> Mails : </h1>
	<div id='mails'>
		<input type='text' name='teachermail' id='teachermail' placeholder='Enter your mail address here' value='' style='background-color: #00FF66;' size=30/><br/>
	</div><br/><br/>
	<input type='button' id='nouveauMail' style='height:80px; width:200px' value='Add a mail'/><br/> <br/>

	<h1> Validation : </h1>

	Be sure to leave no empty fields ! <br/>
	You can check your test by clicking this button : 
	<input type='button' value='Check your test' id='verify' style='height:80px; width:200px'/><br/><br/><br/>
	<input type='button' value='Done' id='valider' style='height:80px; width:200px'/>
	<div id='final'></div>

	<?php
		if(isset($_POST['validation'])){
			$tabrep = explode(" ~ ", $_POST['validation']);
			$question = $tabrep[0];
			$reponse = $tabrep[1];
			$mail = $tabrep[2];
			$token = microtime(true);
			$token = md5($token);
			$sql = 'INSERT INTO Form VALUES ("'.$token.'", "'.$reponse.'", " ", "'.$mail.'", "'.$question.'")';
			mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
		}
	?>

</BODY>
</HTML>