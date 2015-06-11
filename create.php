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
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/style.css" rel="stylesheet" media="all" type="text/css"> 
</HEAD>
	<script type="text/javascript">

	questions = new Array;
	mails = new Array;
	mailsname = new Array;
	media = new Array;
	mediabool = new Array;

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
			var messagerrormail = "";
			var messagerrorname = "";
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

			messagerrortype = messagerrortype + "\n"
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
			else if(cpterrortitle == 1){
				messagerrortitle = "You left an empty field at question " + questionerrortitle; 
			}
			//Les propositions
			
			var compteurprop = 0;
			for(var cptprop =1;cptprop<=i;cptprop++){
				nbprop = questions[compteurprop].toString().split("Proposition").length-2;
				for(var scpt =1;scpt<=nbprop;scpt++){
					if($("#question"+cptprop+"proposition"+scpt).val() == ''){
						messagerrorprop = " You left an empty field at the proposition " + scpt + " of the question " + cptprop ;
						cpterror++;
						}
					}
				compteurprop ++;
			}

			//mail prof
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	        var emailaddressVal = $("#teachermail").val();
		         
		    if(emailaddressVal == ''){
		        messagerrormail = "Teacher\'s mail field is empty \n";
			    cpterror++;
     		}else if(!emailReg.test(emailaddressVal)) {
				messagerrormail = "Teacher's mail address is incorrect \n";
       		   cpterror++;
     		} 

     		//name prof
     		var nameVal = $("#teachername").val();

		    if(nameVal == ''){
		        messagerrorname = "Teacher\'s name field is empty \n";
			    cpterror++;
     		}

		    //mail eleves
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

			//name eleve
			for(var cptbis = 1;cptbis<=nbmail;cptbis++){
     			var nameVal = $("#studentname"+cptbis).val();
 
			    if(nameVal == ''){
			        messagerrorname =  messagerrorname + "The name field of student "+cptbis+" is empty \n";
				    cpterror++;
	     		}
	     	}

			//Concatenation des messages d'erreurs

			messagerrorfinal = cpterror + " error(s) have been detected : \n \n" + messagerrortype + messagerrortitle + messagerrorprop + "\n" + messagerrormail + messagerrorname;

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
			var resultatrepsafe ="";
			var resultatsafe ="";
			var resultatmedia ="";
			var resultatmediafinal ="";

			//On parcours les intitulés de questions
			for(var cpt =1;cpt<=i;cpt++){
				resultatsafe = $("#typequestion"+cpt).val() + $("#question"+cpt).val();
				resultatsafe = resultatsafe.split("~").join(" ");
				resultatsafe = resultatsafe.split("_").join(" ");
				resultatsafe = resultatsafe.split("|").join(" ");

				resultat = resultat + resultatsafe + " | ";
			}

			var compteur = 0;

			//Les propositions

			for(var cptprop =1;cptprop<=i;cptprop++){
				nbprop = questions[compteur].toString().split("Proposition").length-3;
				for(var scpt =1;scpt<=nbprop;scpt++){
					resultatrepsafe = $("#question"+cptprop+"proposition"+scpt).val()
					resultatrepsafe = resultatrepsafe.split("~").join(" ");
					resultatrepsafe = resultatrepsafe.split("_").join(" ");
					resultatrepsafe = resultatrepsafe.split("|").join(" ");

					resultatrep = resultatrep +resultatrepsafe + " _ ";
				}
				resultatrep = resultatrep.substring(0, resultatrep.length-3);
				resultatrep = resultatrep + " | ";
				compteur ++;
			}

			resultatrepfinal = resultatrep.substring(0, resultatrep.length-3);
			resultatfinal = resultat.substring(0, resultat.length-3);

			// Les mails

			listemail = $("#teachermail").val();

			for(var cptbis = 1;cptbis<=nbmail;cptbis++){
		   		listemail = listemail + " | " +$("#studentmail"+cptbis).val();
			}

			// Les noms

			listename = $("#teachername").val();

			for(var cptbis = 1;cptbis<=nbmail;cptbis++){
		   		listename = listename + " | " +$("#studentname"+cptbis).val();
			}

			// Les médias
			var point = "!"
			for(var cpt =1;cpt<=i;cpt++){
				if($("#media"+cpt).val() == ''){
					$("#media"+cpt).val(point);
				}
				resultatmedia = resultatmedia + $("#media"+cpt).val() + " | ";
			}

			resultatmediafinal = resultatmedia.substring(0, resultatmedia.length-3);

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
			var messagerrorname = "";

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

			messagerrortype = messagerrortype + "\n"
				
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
			else if(cpterrortitle == 1){
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

			//mail prof
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	        var emailaddressVal = $("#teachermail").val();
		         
		    if(emailaddressVal == ''){
		        messagerrormail = "Teacher\'s mail field is empty \n";
			    cpterror++;
     		}else if(!emailReg.test(emailaddressVal)) {
				messagerrormail = "Teacher's mail address is incorrect \n";
       		   cpterror++;
     		} 

     		//name prof
     		var nameVal = $("#teachername").val();

		    if(nameVal == ''){
		        messagerrorname = "Teacher\'s name field is empty \n";
			    cpterror++;
     		}

		    //mail eleves
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

			//name eleve
			for(var cptbis = 1;cptbis<=nbmail;cptbis++){
     			var nameVal = $("#studentname"+cptbis).val();
 
			    if(nameVal == ''){
			        messagerrorname =  messagerrorname + "The name field of student "+cptbis+" is empty \n";
				    cpterror++;
	     		}
	     	}

			//Concatenation des messages d'erreurs

			messagerrorfinal = cpterror + " error(s) have been detected : \n" + messagerrortype + messagerrortitle + messagerrorprop + "\n" + messagerrormail + messagerrorname;

			if(cpterror==0){
				resultatfinal = resultatfinal.split("~").join(" ");
				resultatrepfinal =  resultatrepfinal.split("~").join(" ");

				var reponse = resultatfinal + " ~ " + resultatrepfinal + " ~ " + listemail + " ~ " + resultatmediafinal + " ~ " + listename;
				reponse = reponse.split("'").join("&#8217;");

				//alert("Questions : " +resultatfinal  + " \n \n Réponses : " + resultatrepfinal + " \n \n Mails : " + listemail + " \n \n Media : " + resultatmediafinal + "\n \n Names : " + listename );
				document.getElementById('final').innerHTML = "<form method='post' id='formulaire'><input type='hidden' name='validation' value='"+reponse+"'/></form>";
				document.getElementById('formulaire').submit();
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
		    questions.push("<h3><font color='white'>Question "+i+" title : </font></h3><input type='text' name='question"+i+"'id='question"+i+"'value='' size=50 maxlength=80/><input type='button' class='btn btn-primary' id='nouveaumedia"+i+"' onclick='nouveaumedia("+i+")' value='Add a media' style='height:28px; width:110px; font-family:Arial;'/><br><div id='media"+i+"'></div><br><br><input type='button' class='btn btn-primary' id='nouveauProposition"+i+"' onclick='nouveauProposition("+i+")' value='Add an answer' style='height:30px; width:160px; font-family:Arial;'/><select id='typequestion"+i+"'><option value='0'>One correct answer</option><option value='1'>Multiple correct answers</option><option selected='selected' style='display:none;' value='choose'>Choose the type of question "+i+"</option></select><br/><br/>");

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

			for(var cptbis = 0;cptbis<=itotal;cptbis++){
		   		questiontype[cptbis] = $("#typequestion"+cptbis).val();
			}	

			//Les medias

			allmedia = new Array;

			for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
		   		allmedia[cptbisbrouk] = $("#media"+cptbisbrouk).val();
			}			


		    document.getElementById('questions').innerHTML = contenu;

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
			}
				
			//Les types des questions
			for(var cptbis = 0;cptbis<itotal;cptbis++){
		   		$("#typequestion"+cptbis).val(questiontype[cptbis]);
			}

			//les media
			for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
		   		$("#media"+cptbisbrouk).val(allmedia[cptbisbrouk]);
			}

				compteur ++;
		    ip = 0;
		});
	});

	function nouveauProposition (i){
		ip++;
		var numproposition = questions[i-1].toString().split("Proposition").length-2;
		questions[i-1] = questions[i-1] + "<font color='white'>Proposition   "+numproposition+"   </font><input type='text' name='proposition"+ip+"' id='question"+i+"proposition"+numproposition+"' value='' size=40 maxlength=50/><br/>";

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

		//les medias
		allmedia = new Array;

		for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
	   		allmedia[cptbisbrouk] = $("#media"+cptbisbrouk).val();
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
		}
					
		//Les types des questions
		for(var cptbis = 1;cptbis<=itotal;cptbis++){
	  		$("#typequestion"+cptbis).val(questiontype[cptbis]);
	  	}

		//les medias
		for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
	  		$("#media"+cptbisbrouk).val(allmedia[cptbisbrouk]);
		}
		compteur ++;

		var nbmail = 0;

		for(var cpt = 1;cpt<=1000;cpt++){
			mediabool[cpt-1] = true;
		}
	}

		function nouveaumedia (i){
			if(mediabool[i-1]==true){
		   		 questions[i-1] =  "<br><br><h4><font color=white>Question "+i+" media link : </font><input type='text' name='media"+i+"'' id='media"+i+"' placeholder='Paste link of your media here.' value=''size=30 /></h4>" + questions[i-1];
		   	}
		   	 mediabool[i-1] = false;

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

			//les medias
			allmedia = new Array;

			for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
		   		allmedia[cptbisbrouk] = $("#media"+cptbisbrouk).val();
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
			}
				
				//Les types des questions
				for(var cptbis = 1;cptbis<=itotal;cptbis++){
			   		$("#typequestion"+cptbis).val(questiontype[cptbis]);
				}

				//les medias

				for(var cptbisbrouk = 0;cptbisbrouk<=itotal;cptbisbrouk++){
		   			$("#media"+cptbisbrouk).val(allmedia[cptbisbrouk]);
				}

				compteur ++;
			}

		$(function(){
			$("#nouveauMail").click(function(){   
				nbmail ++;

				mails.push("<font color='white'>Student " + nbmail + "  </font><input type='text' name='studentmail"+nbmail+"' id='studentmail"+nbmail+"' placeholder='Enter a student mail here' value='' size=25 maxlength=50/>  <input type='text' name='studentname"+nbmail+"' id='studentname"+nbmail+"' placeholder='Enter the student name here' value='' size=20 maxlength=50/><br/>");

				var contenumail = "";

			    for(var cpt = 0;cpt<nbmail;cpt++){
			   		contenumail = contenumail + mails[cpt];
				}

				contenumailfinal = "<font color='white'>Teacher  </font><input type='text' name='teachermail' id='teachermail' placeholder='Enter your mail address here' value=''size=25 maxlength=50/>  <input type='text' name='teachername' id='teachername' placeholder='Enter your name here' value=''size=20 maxlength=20/><br/></br>" + contenumail;
				//Sauvegarder les valeurs des inputs : 

				//Le mail de l'enseignant
				var mailprof= $("#teachermail").val();

				//Le nom de l'enseignant
				var nameprof= $("#teachername").val();

				//Les mails des élèves
				var arraymail = new Array;

				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
					arraymail[cptbis] = $("#studentmail"+cptbis).val();
				}

				//Les noms des élèves
				var arraymailname = new Array;

				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
					arraymailname[cptbis] = $("#studentname"+cptbis).val();
				}

			    document.getElementById('mails').innerHTML = contenumailfinal;

			    //Remettre les valeurs des inputs : 

			    //Le mail de l'enseignant
				$("#teachermail").val(mailprof);

				//Le nom de l'enseignant
				$("#teachername").val(nameprof);

				//Les mails des élèves
				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
				   	$("#studentmail"+cptbis).val(arraymail[cptbis]);
				}

				//Les noms des élèves
				for(var cptbis = 1;cptbis<=nbmail;cptbis++){
				   	$("#studentname"+cptbis).val(arraymailname[cptbis]);
				}
			});
		});  

	</script>
<BODY>
	 
	 <div id="title">Create your e-Test </div>
	 <div id="create">
	 	<h1><font color="white"> Questions : </font></h1>
		<div id='questions'></div><br/><br/>
	 </div>

		 <div id='boutons'><button type='button' class="btn btn-info" id='nouveauInput' style='height:30px; width:160px'/>Add a question <span class="glyphicon glyphicon-plus"></span></button><br/> <br/>
		 <div id="create">
		 	 <h1> <font color="white">Mails : </font></h1><br/>
		 	 <div id='boutons'><button type='button' class="btn btn-primary" id='nouveauMail' style='height:30px; width:160px'/>Add a student mail <span class="glyphicon glyphicon-envelope"></span></button></div><br/>
			 <div id='mails'><font color='white'>Teacher  </font> <input type='text' name='teachermail' id='teachermail' placeholder='Enter your mail address here' value='' size=25/> <input type='text' name='teachername' id='teachername' placeholder='Enter your name here' value='' size=20/><br/></div><br/><br/>
	    </div>

		 <div id='check'>
		 	<button type='button' class="btn btn-warning" id='verify' style='height:45px; width:200px'/> Check your e-test <span class="glyphicon glyphicon-search"></span></button><br/>
			<button type='button' class="btn btn-success" id='valider' style='height:45px; width:200px'> Done <span class="glyphicon glyphicon-ok"></span></button><br/>
			<button type="button" class="btn btn-danger btn-lg" onclick="self.location.href='index.php'" style='height:45px; width:200px'>Back to menu <span class="glyphicon glyphicon-home"></span></button>
		</div>
		<div id='final'></div>


		<?php
			if(isset($_POST['validation'])){
				$reponsesafe = addslashes($_POST['validation']);
				$to = "";
				$toname = "";
				$listmail = "";
				$textmail = "";
				$tabrep = explode(" ~ ", $reponsesafe);
				$question = $tabrep[0];
				$reponse = $tabrep[1];
				$mail = $tabrep[2];
				$vidimage = $tabrep[3];
				$listnameform = $tabrep[4];
				$token = microtime(true);
				$token = md5($token);
				$_SESSION['tok'] = $token;
				$tokentemp = "";
				$tabmail = explode(" | ", $mail);
				$tabnameform = explode(" | ", $listnameform);
				for($i = 1; $i < count($tabmail); $i++)
				{
					$toname = $toname." ".$tabnameform[$i]." : ".$tabmail[$i]."/";
				}
					
				$textmailteacher = "You can access it by using your token \n Token : ".$token." \n The test has been sent to : ".$toname;
				mail($tabmail[0], 'Your test is created !', $textmailteacher);
				for($i = 1; $i < count($tabmail); $i++)
				{
					$tokentemp = microtime(true);
					$tokentemp = md5($tokentemp);
					echo $tokentemp;
					$textmail = "The user ".$tabnameform[0]." has created a test ! \n You can access to this test on our website by using your token and your mail account \n Token : ".$tokentemp."\n http://etestingproject.hostoi.com";
					mail($tabmail[$i], 'Your teacher has created a test!', $textmail);
					$token = $token." | ".$tokentemp;
					echo $token;
				}
				$sql = mysql_query('INSERT INTO Form VALUES ("'.$token.'", "'.$reponse.'", "'.$vidimage.'", "'.$mail.'", "'.$question.'", "'.$listnameform.'")') or exit(mysql_error());
				$_SESSION['to'] = $toname;
				echo "<script type='text/javascript'>document.location.replace('create2.php');</script>";
			}
		?>
</BODY>
</HTML>